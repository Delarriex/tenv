<?php
require_once('auth_check.php');
require_once('../config/db.php');

$search = $_GET['search'] ?? '';

// Build Query
$query = "SELECT * FROM users";
$params = [];

if (!empty($search)) {
    $query .= " WHERE username LIKE ? OR email LIKE ? OR full_name LIKE ?";
    $params = ["%$search%", "%$search%", "%$search%"];
}

$query .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management - Tenvault Admin</title>
    <link rel="stylesheet" href="../my-account/assets/css/app.css">
    <link rel="stylesheet" href="../../cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body class="bg-slate-50 dark:bg-navy-900 p-8">
    <div class="max-w-7xl mx-auto">
        <header class="flex justify-between items-center mb-8">
            <div>
                <a href="index.php" class="text-xs text-primary hover:underline flex items-center gap-1 mb-2">
                    <i class="fa fa-arrow-left"></i> Back to Dashboard
                </a>
                <h1 class="text-2xl font-bold text-slate-700 dark:text-navy-100">User Management</h1>
            </div>
            <div class="flex gap-4">
                <form action="" method="GET" class="flex gap-2">
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search users..." class="form-input w-64 border rounded-lg px-3 py-2 text-sm bg-white dark:bg-navy-800 dark:border-navy-600">
                    <button class="btn bg-primary text-white">Search</button>
                    <?php if (!empty($search)): ?>
                        <a href="users.php" class="btn bg-slate-200 text-slate-700">Clear</a>
                    <?php endif; ?>
                </form>
            </div>
        </header>

        <div class="card p-0 overflow-hidden bg-white dark:bg-navy-800 shadow-sm border border-slate-200 dark:border-navy-600 rounded-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-100 dark:bg-navy-700 text-slate-600 dark:text-navy-100 text-xs font-bold uppercase tracking-wider">
                            <th class="px-6 py-4">Username</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Balance</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-navy-700">
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-500">No users found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $u): ?>
                                <tr class="hover:bg-slate-50 dark:hover:bg-navy-700/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-navy-600 flex items-center justify-center text-xs font-bold">
                                                <?= strtoupper(substr($u['username'], 0, 2)) ?>
                                            </div>
                                            <span class="font-medium text-slate-700 dark:text-navy-100"><?= htmlspecialchars($u['username']) ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-500 dark:text-navy-300"><?= htmlspecialchars($u['email']) ?></td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-slate-700 dark:text-navy-100">$<?= number_format($u['balance'], 2) ?></div>
                                        <div class="text-xs text-success">+$<?= number_format($u['profit'], 2) ?> profit</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if ($u['is_verified']): ?>
                                            <span class="badge bg-success/10 text-success px-2 py-1 rounded text-xs">Verified</span>
                                        <?php else: ?>
                                            <span class="badge bg-slate-200 text-slate-500 px-2 py-1 rounded text-xs">Unverified</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs capitalize px-2 py-1 rounded <?= $u['role'] === 'admin' ? 'bg-primary/10 text-primary' : 'bg-slate-100 text-slate-600' ?>">
                                            <?= $u['role'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="user-edit.php?id=<?= $u['id'] ?>" class="p-2 hover:bg-primary/10 text-primary rounded-lg transition-colors" title="Edit User">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="activity.php?user_id=<?= $u['id'] ?>" class="p-2 hover:bg-slate-100 dark:hover:bg-navy-600 text-slate-500 rounded-lg transition-colors" title="View History">
                                                <i class="fa fa-history"></i>
                                            </a>
                                        </div>
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
