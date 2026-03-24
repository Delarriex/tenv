<?php
require_once 'auth_guard.php';

$username = $user['username'] ?? 'User';
$email = $user['email'] ?? '';
$fullName = $user['full_name'] ?? '';
$balance = number_format($user['balance'] ?? 0, 2);
$plan = $user['plan'] ?? 'Starter Plan';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials/head.php'; ?>
    <title>Profile - Tenvault</title>

    <style>
    /* Branding Excellence */
    .uc-logo img, .auth-logo img, .header-logo img {
        height: 160px !important;
        width: auto !important;
        object-fit: contain;
        display: block;
        image-rendering: -webkit-optimize-contrast;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
    }
    @media (max-width: 768px) {
        .uc-logo img, .auth-logo img, .header-logo img {
            height: 50px !important;
        }
    }
    </style>
</head>

<body x-data class="is-header-blur" x-bind="$store.global.documentBody" :class="{ 'is-sidebar-open': $store.global.isSidebarExpanded }">
    <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900">

        <?php include 'partials/sidebar.php'; ?>

        <?php include 'partials/header.php'; ?>

        <main class="main-content w-full px-[var(--margin-x)] pb-8 pt-6">
            <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-4">
                    <div class="card p-4 sm:p-5">
                        <div class="flex items-center space-x-4">
                            <div class="avatar h-14 w-14">
                                <div class="mask is-squircle h-full w-full bg-gradient-to-br from-primary to-primary-focus flex items-center justify-center text-white text-xl font-bold">
                                    <?php echo strtoupper(substr($username, 0, 1)); ?>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-base font-medium text-slate-700 dark:text-navy-100"><?php echo $fullName ?: $username; ?></h3>
                                <p class="text-xs+"><b>Username: </b><?php echo $username; ?></p>
                            </div>
                        </div>
                        <ul class="mt-6 space-y-1.5 font-inter font-medium text-sm">
                            <li><a href="profile.php" class="flex items-center space-x-2 rounded-lg bg-primary/10 px-4 py-2.5 text-primary">My Profile</a></li>
                            <li><a href="profile-edit.php" class="flex items-center space-x-2 rounded-lg px-4 py-2.5 text-slate-600 hover:bg-slate-100 dark:text-navy-200 dark:hover:bg-navy-600">Edit Personal Info</a></li>
                            <li><a href="kyc.php" class="flex items-center space-x-2 rounded-lg px-4 py-2.5 text-slate-600 hover:bg-slate-100 dark:text-navy-200 dark:hover:bg-navy-600">KYC Verification</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-8">
                    <div class="card">
                        <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100"><?php echo $username; ?>'s Profile</h2>
                            <a href="profile-edit.php" class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus">Edit</a>
                        </div>
                        <div class="p-4 sm:p-5">
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-xs font-semibold uppercase text-slate-400">Account Balance</label>
                                    <div class="mt-1 text-2xl font-bold text-slate-700 dark:text-navy-100">$ <?php echo $balance; ?></div>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold uppercase text-slate-400">Account Plan</label>
                                    <div class="mt-1 text-lg font-semibold text-primary"><?php echo $plan; ?></div>
                                </div>
                            </div>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-xs font-semibold uppercase text-slate-400">Full Name</label>
                                    <div class="mt-1 text-slate-700 dark:text-navy-100"><?php echo $fullName ?: 'Not Set'; ?></div>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold uppercase text-slate-400">Email Address</label>
                                    <div class="mt-1 text-slate-700 dark:text-navy-100"><?php echo $email; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>window.addEventListener("DOMContentLoaded", () => Alpine.start());</script>
</body>
</html>
