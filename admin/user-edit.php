<?php
require_once('auth_check.php');
require_once('../config/db.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: users.php');
    exit();
}

$message = '';
$error = '';

// Fetch User
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    die("User not found.");
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $balance = (float)$_POST['balance'];
    $profit = (float)$_POST['profit'];
    $plan = $_POST['plan'];
    $role = $_POST['role'];
    $isVerified = isset($_POST['is_verified']) ? 1 : 0;

    try {
        $updateStmt = $pdo->prepare("UPDATE users SET full_name = ?, email = ?, balance = ?, profit = ?, plan = ?, role = ?, is_verified = ? WHERE id = ?");
        $updateStmt->execute([$fullName, $email, $balance, $profit, $plan, $role, $isVerified, $id]);
        $message = "User updated successfully!";
        
        // Refresh data
        $stmt->execute([$id]);
        $user = $stmt->fetch();
    } catch (PDOException $e) {
        $error = "Update failed: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User - Tenvault Admin</title>
    <link rel="stylesheet" href="../my-account/assets/css/app.css">
    <link rel="stylesheet" href="../../cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body class="bg-slate-50 dark:bg-navy-900 p-8">
    <div class="max-w-4xl mx-auto">
        <header class="mb-8">
            <a href="users.php" class="text-xs text-primary hover:underline flex items-center gap-1 mb-2">
                <i class="fa fa-arrow-left"></i> Back to User List
            </a>
            <h1 class="text-2xl font-bold text-slate-700 dark:text-navy-100">Edit User: <?= htmlspecialchars($user['username']) ?></h1>
        </header>

        <?php if ($message): ?>
            <div class="mb-6 p-4 bg-success/10 text-success rounded-xl border border-success/20"><?= $message ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="mb-6 p-4 bg-error/10 text-error rounded-xl border border-error/20"><?= $error ?></div>
        <?php endif; ?>

        <div class="card p-8 bg-white dark:bg-navy-800 shadow-sm border border-slate-200 dark:border-navy-600 rounded-xl">
            <form action="" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-500 mb-2">Full Name</label>
                        <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" class="form-input w-full border rounded-lg px-4 py-3 bg-slate-50 dark:bg-navy-900 dark:border-navy-700">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-500 mb-2">Email Address</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-input w-full border rounded-lg px-4 py-3 bg-slate-50 dark:bg-navy-900 dark:border-navy-700">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-500 mb-2">Account Balance ($)</label>
                        <input type="number" step="0.01" name="balance" value="<?= $user['balance'] ?>" class="form-input w-full border rounded-lg px-4 py-3 bg-slate-50 dark:bg-navy-900 dark:border-navy-700 font-bold">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-500 mb-2">Total Profit ($)</label>
                        <input type="number" step="0.01" name="profit" value="<?= $user['profit'] ?>" class="form-input w-full border rounded-lg px-4 py-3 bg-slate-50 dark:bg-navy-900 dark:border-navy-700 font-bold text-success">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-500 mb-2">Investment Plan</label>
                        <select name="plan" class="form-input w-full border rounded-lg px-4 py-3 bg-slate-50 dark:bg-navy-900 dark:border-navy-700">
                            <option value="Starter Plan" <?= $user['plan'] === 'Starter Plan' ? 'selected' : '' ?>>Starter Plan</option>
                            <option value="Platinum Plan" <?= $user['plan'] === 'Platinum Plan' ? 'selected' : '' ?>>Platinum Plan</option>
                            <option value="Executive Plan" <?= $user['plan'] === 'Executive Plan' ? 'selected' : '' ?>>Executive Plan</option>
                            <option value="Apex Plan" <?= $user['plan'] === 'Apex Plan' ? 'selected' : '' ?>>Apex Plan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-500 mb-2">Account Role</label>
                        <select name="role" class="form-input w-full border rounded-lg px-4 py-3 bg-slate-50 dark:bg-navy-900 dark:border-navy-700 font-bold">
                            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Administrator</option>
                        </select>
                    </div>
                    <div class="flex items-end pb-3">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_verified" value="1" <?= $user['is_verified'] ? 'checked' : '' ?> class="w-5 h-5 rounded border-slate-300 text-primary">
                            <span class="text-sm font-bold text-slate-700 dark:text-navy-100">Verified User</span>
                        </label>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-navy-700 flex justify-end gap-3">
                    <a href="users.php" class="btn bg-slate-200 text-slate-700">Cancel</a>
                    <button type="submit" name="update_user" class="btn bg-primary text-white px-8">Update User Profile</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
