<?php
require_once 'auth_guard.php';
require_once '../config/db.php';

// Fetch user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$username = $user['username'] ?? 'User';
$email = $user['email'] ?? '';
$fullName = $user['full_name'] ?? '';
$phone = $user['phone'] ?? '';
$address = $user['address'] ?? '';
$balance = number_format($user['balance'] ?? 0, 2);
$plan = $user['plan'] ?? 'Starter Plan';

$message = '';
$error = '';

// Handle Profile Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $newFullName = $_POST['full_name'] ?? '';
    $newPhone = $_POST['phone'] ?? '';
    $newAddress = $_POST['address'] ?? '';
    
    try {
        $updateStmt = $pdo->prepare("UPDATE users SET full_name = ?, phone = ?, address = ? WHERE id = ?");
        $updateStmt->execute([$newFullName, $newPhone, $newAddress, $_SESSION['user_id']]);
        $message = "Profile updated successfully!";
        
        // Refresh user data
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
        $fullName = $user['full_name'];
        $phone = $user['phone'];
        $address = $user['address'];
    } catch (PDOException $e) {
        $error = "Update failed: " . $e->getMessage();
    }
}

// Handle Password Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_password'])) {
    $currentPass = $_POST['current_password'] ?? '';
    $newPass = $_POST['new_password'] ?? '';
    $confirmPass = $_POST['confirm_password'] ?? '';
    
    if (password_verify($currentPass, $user['password'])) {
        if ($newPass === $confirmPass) {
            $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);
            $updatePassStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $updatePassStmt->execute([$hashedPass, $_SESSION['user_id']]);
            $message = "Password updated successfully!";
        } else {
            $error = "New passwords do not match.";
        }
    } else {
        $error = "Incorrect current password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

    <?php include 'partials/head.php'; ?>
    <title>Edit Profile - Tenvault</title>
</head>

<body x-data class="is-header-blur" x-bind="$store.global.documentBody" :class="{ 'is-sidebar-open': $store.global.isSidebarExpanded }">
    <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900">
        <?php include 'partials/sidebar.php'; ?>
        <?php include 'partials/header.php'; ?>
        <!-- Content -->
        <main class="main-content w-full px-[var(--margin-x)] pb-8 pt-6">
            <div class="max-w-4xl mx-auto">
                <?php if ($message): ?>
                    <div class="mb-4 p-4 bg-success/10 text-success rounded-lg"><?php echo $message; ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="mb-4 p-4 bg-error/10 text-error rounded-lg"><?php echo $error; ?></div>
                <?php endif; ?>

                <div class="grid grid-cols-1 gap-6">
                    <!-- Profile Info -->
                    <div class="card p-6">
                        <h2 class="text-xl font-bold mb-4">Personal Information</h2>
                        <form method="POST">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="block">
                                    <span>Full Name</span>
                                    <input name="full_name" value="<?php echo htmlspecialchars($fullName); ?>" class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450" type="text" />
                                </label>
                                <label class="block">
                                    <span>Phone Number</span>
                                    <input name="phone" value="<?php echo htmlspecialchars($phone); ?>" class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450" type="text" />
                                </label>
                                <label class="block md:col-span-2">
                                    <span>Residential Address</span>
                                    <textarea name="address" class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450"><?php echo htmlspecialchars($address); ?></textarea>
                                </label>
                            </div>
                            <button name="update_profile" type="submit" class="btn mt-4 bg-primary text-white px-6 py-2 rounded-lg">Update Profile</button>
                        </form>
                    </div>

                    <!-- Password Update -->
                    <div class="card p-6">
                        <h2 class="text-xl font-bold mb-4">Security Settings</h2>
                        <form method="POST">
                            <div class="grid grid-cols-1 gap-4">
                                <label class="block">
                                    <span>Current Password</span>
                                    <input name="current_password" type="password" class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450" required />
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <label class="block">
                                        <span>New Password</span>
                                        <input name="new_password" type="password" class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450" required />
                                    </label>
                                    <label class="block">
                                        <span>Confirm New Password</span>
                                        <input name="confirm_password" type="password" class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450" required />
                                    </label>
                                </div>
                            </div>
                            <button name="update_password" type="submit" class="btn mt-4 bg-warning text-white px-6 py-2 rounded-lg">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>window.addEventListener("DOMContentLoaded", () => Alpine.start());</script>
</body>
</html>
