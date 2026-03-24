<?php
session_start();
require_once('../config/db.php');

$error = '';

if (isset($_SESSION['user_id'])) {
    // Check if truly admin
    $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    if ($stmt->fetchColumn() === 'admin') {
        header('Location: index.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identity = $_POST['identity'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($identity) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$identity, $identity]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            if ($user['role'] === 'admin') {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: index.php');
                exit();
            } else {
                $error = "Access Denied: You do not have administrator privileges.";
            }
        } else {
            $error = "Invalid credentials. Please try again.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Tenvault</title>
    <link rel="stylesheet" href="../my-account/assets/css/app.css">
    <link rel="stylesheet" href="../../cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen p-4">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white tracking-tight">Tenvault <span class="text-primary text-sm font-normal uppercase tracking-widest ml-1">Admin</span></h1>
            <p class="text-slate-400 mt-2 text-sm italic">Authorized Access Only</p>
        </div>

        <div class="card p-8 bg-navy-800 border border-navy-600 shadow-2xl rounded-2xl">
            <?php if ($error): ?>
                <div class="mb-6 p-4 bg-error/10 text-error text-xs font-bold rounded-xl border border-error/20 flex items-center gap-3">
                    <i class="fa fa-exclamation-triangle"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Username or Email</label>
                    <div class="relative">
                        <i class="fa fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <input type="text" name="identity" required placeholder="admin@example.com" class="form-input w-full border-navy-600 bg-navy-900 text-white rounded-xl pl-11 py-3 focus:border-primary transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password</label>
                    <div class="relative">
                        <i class="fa fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <input type="password" name="password" required placeholder="••••••••" class="form-input w-full border-navy-600 bg-navy-900 text-white rounded-xl pl-11 py-3 focus:border-primary transition-all">
                    </div>
                </div>

                <button type="submit" class="btn bg-primary hover:bg-primary-focus text-white w-full py-4 rounded-xl font-bold shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2">
                    Sign In to Console <i class="fa fa-sign-in"></i>
                </button>
            </form>
        </div>

        <div class="mt-8 text-center text-xs text-slate-500">
            <p>&copy; 2026 Tenvault Systems. All rights reserved.</p>
            <div class="mt-2 flex justify-center gap-4">
                <a href="../index.html" class="hover:text-white transition-colors">Main Site</a>
                <a href="../my-account/login/index.php" class="hover:text-white transition-colors">User Login</a>
            </div>
        </div>
    </div>
</body>
</html>
