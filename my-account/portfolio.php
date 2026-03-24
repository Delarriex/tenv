<?php
require_once 'auth_guard.php';
require_once '../config/db.php';
require_once '../includes/FinanceManager.php';

$finance = new FinanceManager($pdo);
$portfolio = $finance->getPortfolio($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html lang="en">
    <?php include 'partials/head.php'; ?>
    <style>
        .portfolio-header { background: #0f172a; border-radius: 16px; padding: 2rem; margin-bottom: 2rem; color: #fff; border: 1px solid rgba(255,255,255,0.05); }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { background: #1e293b; padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); }
        .stock-table { width: 100%; border-collapse: separate; border-spacing: 0 0.5rem; }
        .stock-table th { text-align: left; padding: 1rem; color: #64748b; font-size: 0.85rem; text-transform: uppercase; }
        .stock-row { background: #0f172a; color: #fff; transition: transform 0.2s; }
        .stock-row td { padding: 1rem; }
        .stock-row:hover { transform: scale(1.01); background: #1a2333; }
        .profit { color: #10b981; }
        .loss { color: #ef4444; }
    </style>
</head>
<body x-data class="is-header-blur" x-bind="$store.global.documentBody" :class="{ 'is-sidebar-open': $store.global.isSidebarExpanded }">
    <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900">
        <?php include 'partials/sidebar.php'; ?>
        <?php include 'partials/header.php'; ?>
    <div class="main-content px-[var(--margin-x)] py-8">
        <div class="portfolio-header">
            <h1 class="text-3xl font-bold mb-2">My Investment Portfolio</h1>
            <p class="text-slate-400">Real-time status of your assets and overall performance.</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <p class="text-slate-400 text-sm mb-1">Total Market Value</p>
                <h2 class="text-2xl font-bold text-white">$<?php echo number_format($portfolio['total_valuation'], 2); ?></h2>
            </div>
            <div class="stat-card">
                <p class="text-slate-400 text-sm mb-1">Total Profit/Loss</p>
                <h2 class="text-2xl font-bold <?php echo $portfolio['total_profit_loss'] >= 0 ? 'profit' : 'loss'; ?>">
                    $<?php echo number_format($portfolio['total_profit_loss'], 2); ?>
                    <span class="text-sm">(<?php echo number_format($portfolio['total_profit_loss_percent'], 2); ?>%)</span>
                </h2>
            </div>
            <div class="stat-card">
                <p class="text-slate-400 text-sm mb-1">Assets Held</p>
                <h2 class="text-2xl font-bold text-white"><?php echo count($portfolio['holdings']); ?> Assets</h2>
            </div>
        </div>

        <div class="card p-6 bg-slate-800/50 border-white/5">
            <?php if (empty($portfolio['holdings'])): ?>
                <div class="text-center py-10">
                    <i class="fa fa-briefcase text-5xl text-slate-600 mb-4"></i>
                    <p class="text-slate-500">You don't hold any assets yet.</p>
                    <a href="stocks.php" class="text-primary hover:underline mt-2 inline-block">Explore the Market</a>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="stock-table">
                        <thead>
                            <tr>
                                <th>Asset</th>
                                <th>Quantity</th>
                                <th>Avg. Cost</th>
                                <th>Current Price</th>
                                <th>Market Value</th>
                                <th>Profit / Loss</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($portfolio['holdings'] as $h): ?>
                                <tr class="stock-row">
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <img src="https://financialmodelingprep.com/image-stock/<?php echo $h['symbol']; ?>.png" width="32" class="rounded" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo $h['symbol']; ?>'">
                                            <span class="font-bold"><?php echo $h['symbol']; ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo number_format($h['shares'], 4); ?></td>
                                    <td>$<?php echo number_format($h['avg_price'], 2); ?></td>
                                    <td>$<?php echo number_format($h['current_price'], 2); ?></td>
                                    <td class="font-bold">$<?php echo number_format($h['market_value'], 2); ?></td>
                                    <td class="<?php echo $h['profit_loss'] >= 0 ? 'profit' : 'loss'; ?> font-bold">
                                        <?php echo $h['profit_loss'] >= 0 ? '+' : ''; ?>$<?php echo number_format($h['profit_loss'], 2); ?>
                                        <br>
                                        <span class="text-xs">(<?php echo number_format($h['profit_loss_percent'], 2); ?>%)</span>
                                    </td>
                                    <td>
                                        <a href="stock-detail.php?ticker=<?php echo $h['symbol']; ?>" class="text-primary hover:text-white transition-colors">Trade</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        </main>
    </div>
    <script>window.addEventListener("DOMContentLoaded", () => Alpine.start());</script>
</html>
