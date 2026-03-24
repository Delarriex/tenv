<?php
require_once('auth_check.php');
require_once('../config/db.php');

// Fetch pending deposits
$stmt = $pdo->prepare("SELECT t.*, u.username, u.email FROM transactions t JOIN users u ON t.user_id = u.id WHERE t.status = 'pending' AND t.type = 'deposit' ORDER BY t.created_at DESC");
$stmt->execute();
$pendingDeposits = $stmt->fetchAll();

// Fetch pending withdrawals
$stmt = $pdo->prepare("SELECT t.*, u.username, u.email FROM transactions t JOIN users u ON t.user_id = u.id WHERE t.status = 'pending' AND t.type = 'withdrawal' ORDER BY t.created_at DESC");
$stmt->execute();
$pendingWithdrawals = $stmt->fetchAll();

// Fetch Stats
$stats = [
    'total_users' => $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'user'")->fetchColumn(),
    'tvl' => $pdo->query("SELECT SUM(balance + profit) FROM users")->fetchColumn(),
    'total_payouts' => $pdo->query("SELECT SUM(amount) FROM transactions WHERE type = 'withdrawal' AND status = 'completed'")->fetchColumn(),
    'active_investments' => $pdo->query("SELECT COUNT(*) FROM investments WHERE status = 'active'")->fetchColumn()
];

$pendingKycCount = $pdo->query("SELECT COUNT(*) FROM kyc WHERE status = 'pending'")->fetchColumn();
$totalPending = count($pendingDeposits) + count($pendingWithdrawals);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Tenvault</title>
    <link rel="stylesheet" href="../my-account/assets/css/app.css">
    <link rel="stylesheet" href="../../cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body class="bg-slate-50 dark:bg-navy-900 p-8">
    <div class="max-w-6xl mx-auto">
        <header class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-slate-700 dark:text-navy-100">Admin Dashboard</h1>
            <div class="flex gap-4">
                <a href="users.php" class="btn bg-primary text-white flex items-center gap-2">
                    <i class="fa fa-users"></i> User Management
                </a>
                <a href="transactions.php" class="btn bg-slate-100 text-slate-700 dark:bg-navy-700 dark:text-navy-100 flex items-center gap-2">
                    <i class="fa fa-exchange"></i> All Transactions
                </a>
                <a href="../my-account/dashboard.php" class="btn bg-slate-200 text-slate-700">User View</a>
            </div>
        </header>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8 text-center">
            <div class="card p-6 bg-white dark:bg-navy-800 shadow-sm border border-slate-200 dark:border-navy-600 rounded-2xl">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Users</p>
                <p class="text-2xl font-bold text-slate-700 dark:text-navy-100"><?= number_format($stats['total_users']) ?></p>
            </div>
            <div class="card p-6 bg-white dark:bg-navy-800 shadow-sm border border-slate-200 dark:border-navy-600 rounded-2xl">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total TVL</p>
                <p class="text-2xl font-bold text-primary">$<?= number_format($stats['tvl'], 2) ?></p>
            </div>
            <div class="card p-6 bg-white dark:bg-navy-800 shadow-sm border border-slate-200 dark:border-navy-600 rounded-2xl">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Payouts</p>
                <p class="text-2xl font-bold text-error">$<?= number_format($stats['total_payouts'] ?? 0, 2) ?></p>
            </div>
            <div class="card p-6 bg-white dark:bg-navy-800 shadow-sm border border-slate-200 dark:border-navy-600 rounded-2xl">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Active Trades</p>
                <p class="text-2xl font-bold text-success"><?= number_format($stats['active_investments']) ?></p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="card p-6 bg-primary text-white shadow-lg rounded-2xl flex justify-between items-center transition-transform hover:scale-[1.02]">
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider opacity-80">Funding</h3>
                    <p class="text-2xl font-black mt-1"><?= count($pendingDeposits) ?></p>
                    <p class="text-[10px] opacity-70 mt-1">Pending Deposits</p>
                </div>
                <i class="fa fa-arrow-down text-3xl opacity-30"></i>
            </div>
            <div class="card p-6 bg-warning text-white shadow-lg rounded-2xl flex justify-between items-center transition-transform hover:scale-[1.02]">
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider opacity-80">Payouts</h3>
                    <p class="text-2xl font-black mt-1"><?= count($pendingWithdrawals) ?></p>
                    <p class="text-[10px] opacity-70 mt-1">Pending Withdrawals</p>
                </div>
                <i class="fa fa-arrow-up text-3xl opacity-30"></i>
            </div>
            <div class="card p-6 bg-slate-700 text-white shadow-lg rounded-2xl flex justify-between items-center transition-transform hover:scale-[1.02]">
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider opacity-80">KYC</h3>
                    <p class="text-2xl font-black mt-1"><?= $pendingKycCount ?></p>
                    <a href="kyc.php" class="text-[10px] text-primary-focus hover:underline mt-1 inline-block">Review Documents &rarr;</a>
                </div>
                <i class="fa fa-id-card text-3xl opacity-30"></i>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Pending Deposits -->
            <div class="card p-6">
                <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <i class="fa fa-arrow-down text-success"></i> Pending Funding (Deposits)
                </h2>
                <?php if (empty($pendingDeposits)): ?>
                    <p class="text-slate-500 py-4">No pending funding requests.</p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($pendingDeposits as $tx): ?>
                            <div class="p-4 border rounded-lg bg-slate-50 dark:bg-navy-700 dark:border-navy-500">
                                <div class="flex justify-between mb-2">
                                    <span class="font-bold">$<?= number_format($tx['amount'], 2) ?></span>
                                    <span class="text-xs text-slate-400"><?= $tx['created_at'] ?></span>
                                </div>
                                <p class="text-sm">User: <b><?= htmlspecialchars($tx['username']) ?></b> (<?= htmlspecialchars($tx['email']) ?>)</p>
                                <p class="text-xs text-slate-500 mt-1">Method: <?= htmlspecialchars($tx['method']) ?> | Ref: <?= htmlspecialchars($tx['reference_id'] ?? 'N/A') ?></p>
                                <div class="mt-4 flex gap-2">
                                    <form action="process_transaction.php" method="POST" class="inline">
                                        <input type="hidden" name="id" value="<?= $tx['id'] ?>">
                                        <input type="hidden" name="action" value="approve">
                                        <button class="btn btn-sm bg-success text-white">Approve</button>
                                    </form>
                                    <form action="process_transaction.php" method="POST" class="inline">
                                        <input type="hidden" name="id" value="<?= $tx['id'] ?>">
                                        <input type="hidden" name="action" value="reject">
                                        <input type="text" name="note" placeholder="Reason..." class="form-input text-xs w-24 inline-block">
                                        <button class="btn btn-sm bg-error text-white">Reject</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pending Withdrawals -->
            <div class="card p-6">
                <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <i class="fa fa-arrow-up text-warning"></i> Pending Payouts (Withdrawals)
                </h2>
                <?php if (empty($pendingWithdrawals)): ?>
                    <p class="text-slate-500 py-4">No pending payout requests.</p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($pendingWithdrawals as $tx): ?>
                            <div class="p-4 border rounded-lg bg-slate-50 dark:bg-navy-700 dark:border-navy-500">
                                <div class="flex justify-between mb-2">
                                    <span class="font-bold">$<?= number_format($tx['amount'], 2) ?></span>
                                    <span class="text-xs text-slate-400"><?= $tx['created_at'] ?></span>
                                </div>
                                <p class="text-sm">User: <b><?= htmlspecialchars($tx['username']) ?></b></p>
                                <p class="text-xs text-slate-500 mt-1">Method: <?= htmlspecialchars($tx['method']) ?></p>
                                <p class="text-xs font-mono bg-white dark:bg-navy-900 p-1 mt-1 truncate"><?= htmlspecialchars($tx['wallet_address']) ?></p>
                                <div class="mt-4 flex gap-2">
                                    <form action="process_transaction.php" method="POST" class="inline">
                                        <input type="hidden" name="id" value="<?= $tx['id'] ?>">
                                        <input type="hidden" name="action" value="approve">
                                        <button class="btn btn-sm bg-success text-white">Mark Paid</button>
                                    </form>
                                    <form action="process_transaction.php" method="POST" class="inline">
                                        <input type="hidden" name="id" value="<?= $tx['id'] ?>">
                                        <input type="hidden" name="action" value="reject">
                                        <input type="text" name="note" placeholder="Reason..." class="form-input text-xs w-24 inline-block">
                                        <button class="btn btn-sm bg-error text-white">Reject (Refund)</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
