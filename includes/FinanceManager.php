<?php
/**
 * FinanceManager Class
 * Handles all financial operations: deposits, investments, withdrawals, and profits.
 * Expanded to support Stock Trading and Portfolio Valuation.
 */
class FinanceManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Create a new transaction record
     */
    public function createTransaction($userId, $type, $amount, $status = 'completed', $method = null, $refId = null, $proof = null, $wallet = null) {
        $stmt = $this->pdo->prepare("INSERT INTO transactions (user_id, type, amount, status, method, reference_id, proof_image, wallet_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$userId, $type, $amount, $status, $method, $refId, $proof, $wallet]);
    }

    /**
     * Trading Plans: Create a new investment
     */
    public function invest($userId, $planName, $amount, $roi, $durationHours) {
        try {
            $this->pdo->beginTransaction();

            // Check balance
            $stmt = $this->pdo->prepare("SELECT balance FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $balance = $stmt->fetchColumn();

            if ($balance < $amount) {
                throw new Exception("Insufficient balance to invest $$amount in $planName.");
            }

            // Deduct balance
            $stmt = $this->pdo->prepare("UPDATE users SET balance = balance - ? WHERE id = ?");
            $stmt->execute([$amount, $userId]);

            // Create investment record
            $startDate = date('Y-m-d H:i:s');
            $endDate = date('Y-m-d H:i:s', strtotime("+$durationHours hours"));
            
            $stmt = $this->pdo->prepare("INSERT INTO investments (user_id, plan_name, amount, roi_percentage, duration_hours, status, last_profit_at, start_date, end_date) VALUES (?, ?, ?, ?, ?, 'active', ?, ?, ?)");
            $stmt->execute([$userId, $planName, $amount, $roi, $durationHours, $startDate, $startDate, $endDate]);

            // Log transaction
            $this->createTransaction($userId, 'investment', $amount, 'completed', 'Trading Plan', $planName);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) $this->pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Stock Trading: Buy shares
     */
    public function buyStock($userId, $symbol, $quantity, $price) {
        try {
            $this->pdo->beginTransaction();
            $totalCost = $quantity * $price;

            // Check balance
            $stmt = $this->pdo->prepare("SELECT balance FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $balance = $stmt->fetchColumn();

            if ($balance < $totalCost) {
                throw new Exception("Insufficient balance to buy $quantity shares of $symbol at $$price.");
            }

            // Deduct balance
            $stmt = $this->pdo->prepare("UPDATE users SET balance = balance - ? WHERE id = ?");
            $stmt->execute([$totalCost, $userId]);

            // Add/Update portfolio
            $stmt = $this->pdo->prepare("INSERT INTO portfolio (user_id, symbol, shares, avg_price) 
                VALUES (?, ?, ?, ?) 
                ON DUPLICATE KEY UPDATE 
                avg_price = ( (shares * avg_price) + (? * ?) ) / (shares + ?),
                shares = shares + ?");
            $stmt->execute([$userId, $symbol, $quantity, $price, $quantity, $price, $quantity, $quantity]);

            // Log transaction
            $this->createTransaction($userId, 'investment', $totalCost, 'completed', 'Stock Purchase', $symbol);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Stock Trading: Sell shares
     */
    public function sellStock($userId, $symbol, $quantity, $price) {
        try {
            $this->pdo->beginTransaction();

            // Check ownership
            $stmt = $this->pdo->prepare("SELECT shares FROM portfolio WHERE user_id = ? AND symbol = ?");
            $stmt->execute([$userId, $symbol]);
            $owned = $stmt->fetchColumn();

            if (!$owned || $owned < $quantity) {
                throw new Exception("You do not own enough shares of $symbol to sell.");
            }

            $totalCredit = $quantity * $price;

            // Update portfolio
            $stmt = $this->pdo->prepare("UPDATE portfolio SET shares = shares - ? WHERE user_id = ? AND symbol = ?");
            $stmt->execute([$quantity, $userId, $symbol]);

            // Remove if 0
            $this->pdo->prepare("DELETE FROM portfolio WHERE user_id = ? AND symbol = ? AND shares <= 0")->execute([$userId, $symbol]);

            // Credit balance
            $stmt = $this->pdo->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
            $stmt->execute([$totalCredit, $userId]);

            // Log transaction
            $this->createTransaction($userId, 'profit', $totalCredit, 'completed', 'Stock Sale', $symbol);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Get live quotes from cache or API
     */
    public function getLiveQuotes() {
        $cacheFile = __DIR__ . '/../api/stock-quotes-cache.json';
        if (file_exists($cacheFile)) {
            $data = json_decode(file_get_contents($cacheFile), true);
            if (isset($data['quotes'])) {
                $quotes = [];
                foreach ($data['quotes'] as $q) {
                    $ticker = strtoupper(explode('.', $q['symbol'])[0]);
                    $quotes[$ticker] = $q;
                }
                return $quotes;
            }
        }
        return [];
    }

    /**
     * Get user's portfolio with real-time valuation
     */
    public function getPortfolio($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM portfolio WHERE user_id = ?");
        $stmt->execute([$userId]);
        $holdings = $stmt->fetchAll();
        
        $quotes = $this->getLiveQuotes();
        $totalValuation = 0;
        $totalInvested = 0;

        foreach ($holdings as &$h) {
            $symbol = strtoupper($h['symbol']);
            $currentPrice = $quotes[$symbol]['price'] ?? $h['avg_price'];
            $h['current_price'] = (float)$currentPrice;
            $h['market_value'] = $h['shares'] * $currentPrice;
            $h['profit_loss'] = $h['market_value'] - ($h['shares'] * $h['avg_price']);
            $h['profit_loss_percent'] = ($h['avg_price'] > 0) ? ($h['profit_loss'] / ($h['shares'] * $h['avg_price'])) * 100 : 0;
            
            $totalValuation += $h['market_value'];
            $totalInvested += ($h['shares'] * $h['avg_price']);
        }

        return [
            'holdings' => $holdings,
            'total_valuation' => $totalValuation,
            'total_profit_loss' => $totalValuation - $totalInvested,
            'total_profit_loss_percent' => ($totalInvested > 0) ? (($totalValuation - $totalInvested) / $totalInvested) * 100 : 0
        ];
    }

    /**
     * Process profits for trading plans (Accrual logic)
     */
    public function processProfits() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM investments WHERE status = 'active'");
            $investments = $stmt->fetchAll();

            foreach ($investments as $inv) {
                $now = time();
                $lastAt = strtotime($inv['last_profit_at']);
                $endAt = strtotime($inv['end_date'] ?: date('Y-m-d H:i:s', $now + 86400));
                
                $secondsPassed = $now - $lastAt;
                if ($secondsPassed < 3600) continue; 

                $hoursPassed = floor($secondsPassed / 3600);
                $totalProfitExpected = ($inv['amount'] * ($inv['roi_percentage'] ?: 1)) / 100;
                $profitPerHour = $totalProfitExpected / ($inv['duration_hours'] ?: 24);
                
                $profitToCredit = round($profitPerHour * $hoursPassed, 4);

                if ($profitToCredit > 0) {
                    $this->pdo->beginTransaction();
                    $this->pdo->prepare("UPDATE users SET profit = profit + ? WHERE id = ?")->execute([$profitToCredit, $inv['user_id']]);
                    $this->createTransaction($inv['user_id'], 'profit', $profitToCredit, 'completed', 'System', 'ROI Accrual');
                    $newLastAt = date('Y-m-d H:i:s', $lastAt + ($hoursPassed * 3600));
                    $this->pdo->prepare("UPDATE investments SET last_profit_at = ? WHERE id = ?")->execute([$newLastAt, $inv['id']]);
                    if ($now >= $endAt) {
                        $this->pdo->prepare("UPDATE investments SET status = 'completed' WHERE id = ?")->execute([$inv['id']]);
                    }
                    $this->pdo->commit();
                }
            }
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) $this->pdo->rollBack();
            error_log("ROI Error: " . $e->getMessage());
        }
    }

    /**
     * Update transaction status and handle associated balance changes
     */
    public function updateTransactionStatus($txId, $status, $note = '') {
        try {
            $this->pdo->beginTransaction();

            // Get current transaction details
            $stmt = $this->pdo->prepare("SELECT * FROM transactions WHERE id = ?");
            $stmt->execute([$txId]);
            $tx = $stmt->fetch();

            if (!$tx) throw new Exception("Transaction not found.");
            if ($tx['status'] === $status) {
                $this->pdo->commit();
                return true; // Already updated
            }

            // Update status
            $stmt = $this->pdo->prepare("UPDATE transactions SET status = ?, admin_note = ? WHERE id = ?");
            $stmt->execute([$status, $note, $txId]);

            // Handle balance adjustments based on transition
            if ($status === 'completed' && $tx['type'] === 'deposit') {
                // Add balance on deposit approval
                $stmt = $this->pdo->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
                $stmt->execute([$tx['amount'], $tx['user_id']]);
            } elseif ($status === 'failed' && $tx['type'] === 'withdrawal' && $tx['status'] === 'pending') {
                // Refund balance on withdrawal rejection (only if it was pending)
                $stmt = $this->pdo->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
                $stmt->execute([$tx['amount'], $tx['user_id']]);
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) $this->pdo->rollBack();
            error_log("Update status error: " . $e->getMessage());
            return false;
        }
    }
}
?>
