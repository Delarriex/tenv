<?php
require_once('auth_check.php');
require_once('../config/db.php');

$userId = $_GET['user_id'] ?? null;
if (!$userId) {
    header('Location: users.php');
    exit();
}

// Fetch User
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
    die("User not found.");
}

// Fetch Transactions
$stmt = $pdo->prepare("SELECT id, type, amount, status, method, reference_id, created_at FROM transactions WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$userId]);
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Investments
$stmt = $pdo->prepare("SELECT id, 'investment' as type, amount, status, plan_name as method, '' as reference_id, created_at FROM investments WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$userId]);
$investments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Combine and Sort
$activities = array_merge($transactions, $investments);
usort($activities, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Activity - Tenvault Admin</title>
    <link rel="stylesheet" href="../my-account/assets/css/app.css">
    <link rel="stylesheet" href="../../cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body class="bg-slate-50 dark:bg-navy-900 p-8">
    <div class="max-w-5xl mx-auto">
        <header class="mb-8 flex justify-between items-end">
            <div>
                <a href="users.php" class="text-xs text-primary hover:underline flex items-center gap-1 mb-2">
                    <i class="fa fa-arrow-left"></i> Back to User List
                </a>
                <h1 class="text-2xl font-bold text-slate-700 dark:text-navy-100 italic">Audit Log: <?= htmlspecialchars($user['username']) ?></h1>
                <p class="text-sm text-slate-500">Current Balance: <b>$<?= number_format($user['balance'], 2) ?></b> | Profit: <b>$<?= number_format($user['profit'], 2) ?></b></p>
            </div>
            <div class="pb-2">
                <a href="user-edit.php?id=<?= $userId ?>" class="btn btn-sm bg-primary text-white">Edit Profile</a>
            </div>
        </header>

        <div class="card p-0 overflow-hidden bg-white dark:bg-navy-800 shadow-sm border border-slate-200 dark:border-navy-600 rounded-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-100 dark:bg-navy-700 text-slate-600 dark:text-navy-100 text-xs font-bold uppercase tracking-wider">
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Method/Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-navy-700">
                        <?php if (empty($activities)): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500">No activity recorded for this user.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($activities as $act): ?>
                                <tr class="hover:bg-slate-50 dark:hover:bg-navy-700/50">
                                    <td class="px-6 py-4 text-sm text-slate-400">
                                        <?= date('M d, Y', strtotime($act['created_at'])) ?>
                                        <div class="text-xs"><?= date('H:i', strtotime($act['created_at'])) ?></div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold capitalize <?= in_array($act['type'], ['deposit', 'profit']) ? 'text-success' : 'text-slate-700 dark:text-navy-100' ?>">
                                        <?= $act['type'] ?>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-sm">
                                        $<?= number_format($act['amount'], 2) ?>
                                    </td>
                                    <td class="px-6 py-4 text-xs">
                                        <?php if ($act['status'] === 'completed' || $act['status'] === 'approved'): ?>
                                            <span class="text-success flex items-center gap-1 font-bold italic"><i class="fa fa-check-circle"></i> Success</span>
                                        <?php elseif ($act['status'] === 'pending' || $act['status'] === 'active'): ?>
                                            <span class="text-warning flex items-center gap-1 font-bold italic"><i class="fa fa-clock-o"></i> Running/Pending</span>
                                        <?php else: ?>
                                            <span class="text-error flex items-center gap-1 font-bold italic"><i class="fa fa-times-circle"></i> Failed</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-500">
                                        <span class="text-slate-700 dark:text-navy-100 font-medium"><?= htmlspecialchars($act['method']) ?></span>
                                        <?php if ($act['reference_id']): ?>
                                            <div class="mt-1 opacity-50">Ref: <?= htmlspecialchars($act['reference_id']) ?></div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
