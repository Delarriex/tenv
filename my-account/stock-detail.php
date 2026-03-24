<?php
require_once 'auth_guard.php';
require_once '../config/db.php';
require_once '../includes/FinanceManager.php';

$finance = new FinanceManager($pdo);
$ticker = $_GET['ticker'] ?? 'AAPL';
$ticker = strtoupper(preg_replace('/[^A-Za-z]/', '', $ticker));

$quotes = $finance->getLiveQuotes();
$quote = $quotes[$ticker] ?? null;

if (!$quote) {
    die("Stock info for $ticker not available.");
}

$message = '';
$error = '';

// Handle Trade
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['trade'])) {
    $action = $_POST['action']; // buy or sell
    $quantity = (float)$_POST['quantity'];
    $price = $quote['price'];

    try {
        if ($action === 'buy') {
            $finance->buyStock($_SESSION['user_id'], $ticker, $quantity, $price);
            $message = "Successfully purchased $quantity shares of $ticker!";
        } else {
            $finance->sellStock($_SESSION['user_id'], $ticker, $quantity, $price);
            $message = "Successfully sold $quantity shares of $ticker!";
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Get user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// Get portfolio info for this stock
$stmt = $pdo->prepare("SELECT shares, avg_price FROM portfolio WHERE user_id = ? AND symbol = ?");
$stmt->execute([$_SESSION['user_id'], $ticker]);
$holding = $stmt->fetch() ?: ['shares' => 0, 'avg_price' => 0];

?>
<!DOCTYPE html>
<html lang="en">
    <?php include 'partials/head.php'; ?>
    <style>
        .detail-card { background: #0f172a; border-radius: 16px; padding: 2rem; color: #fff; border: 1px solid rgba(255,255,255,0.05); }
        .tradingview-widget-container { border-radius: 12px; overflow: hidden; margin: 1.5rem 0; height: 500px; }
        .trade-input { background: #1e293b; border: 1px solid #334155; color: #fff; padding: 0.75rem; border-radius: 8px; width: 100%; }
        .btn-buy { background: #10b981; color: #fff; width: 100%; padding: 1rem; border-radius: 12px; font-weight: 700; margin-top: 1rem; }
        .btn-sell { background: #ef4444; color: #fff; width: 100%; padding: 1rem; border-radius: 12px; font-weight: 700; margin-top: 1rem; }
    </style>
</head>
<body x-data class="is-header-blur" x-bind="$store.global.documentBody" :class="{ 'is-sidebar-open': $store.global.isSidebarExpanded }">
    <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900">
        <?php include 'partials/sidebar.php'; ?>
        <?php include 'partials/header.php'; ?>
    <div class="main-content px-[var(--margin-x)] py-8">
        <div class="detail-card">
            <?php if ($message): ?>
                <div class="mb-4 p-4 bg-success/10 text-success rounded-lg"><?php echo $message; ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="mb-4 p-4 bg-error/10 text-error rounded-lg"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="flex justify-between items-start">
                <div class="flex items-center gap-4">
                    <img src="https://financialmodelingprep.com/image-stock/<?php echo $ticker; ?>.png" width="60" alt="">
                    <div>
                        <h1 class="text-3xl font-bold"><?php echo $quote['name']; ?> (<?php echo $ticker; ?>)</h1>
                        <p class="text-slate-400">Current Market Price: <span class="text-white font-bold">$<?php echo number_format($quote['price'], 2); ?></span></p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-slate-400">Your Holdings</p>
                    <h2 class="text-2xl font-bold"><?php echo number_format($holding['shares'], 4); ?> Units</h2>
                </div>
            </div>

            <!-- TradingView Widget -->
            <div class="tradingview-widget-container">
                <div id="tradingview_chart"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                <script type="text/javascript">
                new TradingView.widget({
                  "autosize": true,
                  "symbol": "NASDAQ:<?php echo $ticker; ?>",
                  "interval": "D",
                  "timezone": "Etc/UTC",
                  "theme": "dark",
                  "style": "1",
                  "locale": "en",
                  "toolbar_bg": "#f1f3f6",
                  "enable_publishing": false,
                  "hide_side_toolbar": false,
                  "allow_symbol_change": true,
                  "container_id": "tradingview_chart"
                });
                </script>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Buy Form -->
                <div class="bg-slate-800/50 p-6 rounded-xl border border-white/5">
                    <h3 class="text-xl font-bold mb-4 text-success"><i class="fa fa-shopping-cart"></i> Buy <?php echo $ticker; ?></h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="buy">
                        <label class="block text-sm mb-2 text-slate-400">Quantity of Shares</label>
                        <input type="number" name="quantity" step="any" min="0.0001" class="trade-input mb-4" placeholder="Enter amount..." required>
                        <p class="text-xs text-slate-500 mb-4">Account Balance: $<?php echo number_format($user['balance'], 2); ?></p>
                        <button type="submit" name="trade" class="btn-buy">Confirm Purchase</button>
                    </form>
                </div>

                <!-- Sell Form -->
                <div class="bg-slate-800/50 p-6 rounded-xl border border-white/5">
                    <h3 class="text-xl font-bold mb-4 text-error"><i class="fa fa-share"></i> Sell <?php echo $ticker; ?></h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="sell">
                        <label class="block text-sm mb-2 text-slate-400">Quantity to Sell</label>
                        <input type="number" name="quantity" step="any" min="0.0001" max="<?php echo $holding['shares']; ?>" class="trade-input mb-4" placeholder="Enter amount..." required>
                        <p class="text-xs text-slate-500 mb-4">Held Shares: <?php echo number_format($holding['shares'], 4); ?></p>
                        <button type="submit" name="trade" class="btn-sell" <?php echo $holding['shares'] <= 0 ? 'disabled' : ''; ?>>Execute Sell Order</button>
                    </form>
                </div>
            </div>
            
            <div class="mt-6 text-center">
                <a href="stocks.php" class="text-slate-400 hover:text-white"><i class="fa fa-arrow-left"></i> Back to Market</a>
            </div>
        </div>
        </main>
    </div>
    <script>window.addEventListener("DOMContentLoaded", () => Alpine.start());</script>
</body>
</html>
