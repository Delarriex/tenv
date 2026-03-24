<?php
require_once 'auth_guard.php';

$message = '';
$error = '';
$quotes = $finance->getLiveQuotes();
$balance = number_format($user['balance'] ?? 0, 2);
?>
<!DOCTYPE html>
<html lang="en">
    <?php include 'partials/head.php'; ?>
    <style>
        .stocks-hero { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border-radius: 16px; padding: 2rem; margin-bottom: 1.5rem; color: #fff; }
        .stocks-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; }
        .stock-card { background: #0f172a; border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 16px; padding: 1.5rem; transition: all 0.3s ease; }
        .stock-card:hover { transform: translateY(-5px); border-color: #10b981; }
        .stock-logo { width: 48px; height: 48px; border-radius: 12px; background: #1e293b; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; }
        .stock-price { font-size: 1.5rem; font-weight: 700; color: #f8fafc; }
        .stock-change.positive { color: #10b981; }
        .stock-change.negative { color: #ef4444; }
        .stock-btn { display: flex; align-items: center; justify-content: center; padding: 0.75rem; border-radius: 8px; font-weight: 600; transition: background 0.2s; text-decoration: none; }
        .stock-btn-primary { background: #10b981; color: #fff; }
        .stock-btn-secondary { background: #1e293b; color: #cbd5e1; border: 1px solid rgba(255,255,255,0.1); }
    </style>
</head>
<body x-data class="is-header-blur" x-bind="$store.global.documentBody" :class="{ 'is-sidebar-open': $store.global.isSidebarExpanded }">
    <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900">
        <?php include 'partials/sidebar.php'; ?>
        <?php include 'partials/header.php'; ?>
        <main class="main-content w-full px-[var(--margin-x)] pb-8 pt-6">
            <div class="stocks-hero flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold">Stock Market</h1>
                    <p class="text-slate-400">Trade world-class assets with real-time accuracy.</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-slate-400">Available Balance</p>
                    <h2 class="text-xl font-bold text-success">$<?php echo $balance; ?></h2>
                </div>
            </div>

            <div class="stocks-grid">
                <?php if (empty($quotes)): ?>
                    <p class="text-center text-slate-500 col-span-full">Loading live market data...</p>
                <?php else: ?>
                    <?php foreach ($quotes as $ticker => $q): ?>
                        <div class="stock-card">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="stock-logo">
                                    <img src="https://financialmodelingprep.com/image-stock/<?php echo $ticker; ?>.png" alt="<?php echo $ticker; ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo $ticker; ?>&background=random'">
                                </div>
                                <div>
                                    <h3 class="font-bold text-white"><?php echo strtoupper($q['name'] ?? $ticker); ?></h3>
                                    <span class="text-xs text-slate-500"><?php echo $ticker; ?> / USD</span>
                                </div>
                            </div>
                            <div class="mb-4">
                                <p class="stock-price">$<?php echo number_format($q['price'] ?? 0, 2); ?></p>
                                <span class="stock-change <?php echo ($q['change'] ?? 0) >= 0 ? 'positive' : 'negative'; ?>">
                                    <?php echo ($q['change'] ?? 0) >= 0 ? '+' : ''; ?><?php echo $q['changePercent'] ?? '0.00'; ?>%
                                </span>
                            </div>
                            <div class="flex gap-2">
                                <a href="stock-detail.php?ticker=<?php echo $ticker; ?>" class="stock-btn stock-btn-secondary flex-1">Details</a>
                                <a href="stock-detail.php?ticker=<?php echo $ticker; ?>&buy=1" class="stock-btn stock-btn-primary flex-1">Trade</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
