<?php
require_once('../includes/auth_guard.php');
require_once('../config/db.php');
require_once('../includes/FinanceManager.php');

$finance = new FinanceManager($pdo);
$message = '';
$error = '';

// Handle Withdrawal Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['amount'])) {
    $amount = filter_var($_POST['amount'], FILTER_VALIDATE_FLOAT);
    $method = $_POST['method_id'] ?? 'unknown';
    $wallet = $_POST['wallet_address'] ?? '';

    try {
        if ($amount <= 0) throw new Exception("Invalid amount.");

        // Check balance
        $stmt = $pdo->prepare("SELECT balance FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user_balance = $stmt->fetchColumn();

        if ($user_balance < $amount) {
            throw new Exception("Insufficient balance for this withdrawal.");
        }

        // Deduct from balance
        $stmt = $pdo->prepare("UPDATE users SET balance = balance - ? WHERE id = ?");
        $stmt->execute([$amount, $_SESSION['user_id']]);

        // Create a pending transaction with method and wallet
        $finance->createTransaction(
            $_SESSION['user_id'],
            'withdrawal',
            $amount,
            'pending',
            $method,
            null,
            null,
            $wallet
        );
        
        $message = "Withdrawal request of $$amount submitted successfully! It is now pending review.";
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// User data is fetched globally in auth_guard.php
?>
<!DOCTYPE html>
<html lang="en">
    <?php include 'partials/head.php'; ?>
    <title>Withdraw Funds - Tenvault</title>
</head>
<body x-data class="is-header-blur" x-bind="$store.global.documentBody" :class="{ 'is-sidebar-open': $store.global.isSidebarExpanded }">
    <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900">
        <?php include 'partials/sidebar.php'; ?>
        <?php include 'partials/header.php'; ?>
        <main class="main-content w-full px-[var(--margin-x)] pb-8 pt-6">
            <div class="flex items-center justify-between py-5 lg:py-6">
                <h2 class="text-xl font-medium text-slate-700 dark:text-navy-50">Withdraw Funds</h2>
            </div>

            <div class="max-w-xl mx-auto">
                <div class="card p-5 lg:p-6">
                    <?php if ($message): ?>
                        <div class="mb-4 p-4 bg-success/10 text-success rounded-lg"><?= $message ?></div>
                    <?php endif; ?>
                    <?php if ($error): ?>
                        <div class="mb-4 p-4 bg-error/10 text-error rounded-lg"><?= $error ?></div>
                    <?php endif; ?>

                    <div class="mb-6 p-4 bg-slate-100 dark:bg-navy-800 rounded-lg">
                        <p class="text-xs text-slate-500">Available Balance</p>
                        <p class="text-2xl font-bold text-slate-700 dark:text-navy-100">$<?= number_format($user['balance'], 2) ?></p>
                    </div>

                    <form method="POST" class="space-y-4">
                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Withdrawal Amount ($)</span>
                            <input class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2" 
                                   type="number" name="amount" required min="10" step="any" placeholder="Min: $10.00">
                        </label>

                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Withdrawal Method</span>
                            <select name="method_id" class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2">
                                <option value="BTC">Bitcoin (BTC)</option>
                                <option value="ETH">Ethereum (ETH)</option>
                                <option value="USDT">USDT (TRC20)</option>
                                <option value="Bank">Bank Transfer</option>
                            </select>
                        </label>

                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Wallet Address / Account Details</span>
                            <textarea name="wallet_address" class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2" 
                                      rows="3" required placeholder="Enter your destination address or bank details"></textarea>
                        </label>

                        <button type="submit" class="btn w-full bg-primary text-white h-11">Request Withdrawal</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/appf195.js?v=2.1" defer></script>
</body>
</html>
