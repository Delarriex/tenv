<?php
require_once('auth_check.php');
require_once('../config/db.php');

$stmt = $pdo->prepare("SELECT t.*, u.username FROM transactions t JOIN users u ON t.user_id = u.id ORDER BY t.created_at DESC");
$stmt->execute();
$transactions = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Transactions - Admin</title>
    <link rel="stylesheet" href="../my-account/assets/css/app.css">
</head>
<body class="bg-slate-50 dark:bg-navy-900 p-8">
    <div class="max-w-6xl mx-auto">
        <header class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-slate-700 dark:text-navy-100">Transaction History</h1>
            <a href="index.php" class="btn bg-slate-200 text-slate-700">Back to Dashboard</a>
        </header>

        <div class="card overflow-hidden">
            <table class="is-hoverable w-full text-left">
                <thead>
                    <tr class="border-b border-slate-150 bg-slate-50 dark:border-navy-500 dark:bg-navy-700">
                        <th class="px-4 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100">Date</th>
                        <th class="px-4 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100">User</th>
                        <th class="px-4 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100">Type</th>
                        <th class="px-4 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100">Amount</th>
                        <th class="px-4 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100">Status</th>
                        <th class="px-4 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100">Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $tx): ?>
                        <tr class="border-b border-slate-100 dark:border-navy-500">
                            <td class="px-4 py-3"><?= $tx['created_at'] ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($tx['username']) ?></td>
                            <td class="px-4 py-3 uppercase text-xs"><?= $tx['type'] ?></td>
                            <td class="px-4 py-3 font-bold">$<?= number_format($tx['amount'], 2) ?></td>
                            <td class="px-4 py-3">
                                <span class="badge rounded-full px-2 py-0.5 text-xs font-semibold
                                    <?= $tx['status'] === 'completed' ? 'bg-success/10 text-success' : ($tx['status'] === 'pending' ? 'bg-warning/10 text-warning' : 'bg-error/10 text-error') ?>">
                                    <?= $tx['status'] ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-500">
                                <?= htmlspecialchars($tx['method'] ?? '-') ?> | <?= htmlspecialchars($tx['reference_id'] ?? '-') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
