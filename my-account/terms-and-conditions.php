<?php
require_once 'auth_guard.php';
require_once '../config/db.php';

// Fetch user data for header/sidebar
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$pageTitle = "Terms and Conditions - Tenvault";
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'partials/head.php'; ?>
<body x-data class="is-header-blur" x-bind="$store.global.documentBody" :class="{ 'is-sidebar-open': $store.global.isSidebarExpanded }">
    <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900">
        <?php include 'partials/sidebar.php'; ?>
        <?php include 'partials/header.php'; ?>
        
        <main class="main-content w-full px-[var(--margin-x)] pb-8 pt-6">
            <div class="grid grid-cols-12 lg:gap-6">
               <div class="col-span-12 pt-6 lg:col-span-8 lg:pb-6">
                  <div class="card p-4 lg:p-6">
                     <div class="font-inter text-base text-slate-600 dark:text-navy-200">
                        <h1 class="text-xl font-medium text-slate-900 dark:text-navy-50 lg:text-2xl">
                           Terms and Conditions
                        </h1>
                        <p class="mt-4">
                           These Website Standard Terms and Conditions written on this webpage shall manage your use of our website, Tenvault accesible at tenvaultmarkets.com.
                        </p>
                        <br />
                        <h2 class="text-xl font-medium text-slate-900 dark:text-navy-50 lg:text-2xl">
                           Introduction
                        </h2>
                        <p>
                           These Terms will be applied fully and affect to your use of this Website. By using this Website, you agreed to accept all terms and conditions written in here. You must not use this Website if you disagree with any of these Website Standard Terms and Conditions.
                        </p>
                        <p class="mt-2">
                           Minors or people below 18 years old are not allowed to use this Website.
                        </p>
                        <br />
                        <h2 class="text-xl font-medium text-slate-900 dark:text-navy-50 lg:text-2xl">
                           Intellectual Property Rights
                        </h2>
                        <p>
                           Other than the content you own, under these Terms, Tenvault and/or its licensors own all the intellectual property rights and materials contained in this Website.
                        </p>
                        <p class="mt-2">
                           You are granted limited license only for purposes of viewing the material contained on this Website.
                        </p>
                        <br />
                        <h2 class="text-xl font-medium text-slate-900 dark:text-navy-50 lg:text-2xl">
                           Restrictions
                        </h2>
                        <ul class="list-inside list-disc font-medium text-slate-800 dark:text-navy-100 space-y-2">
                           <li>Publishing any Website material in any other media;</li>
                           <li>Selling, sublicensing and/or otherwise commercializing any Website material;</li>
                           <li>Publicly performing and/or showing any Website material;</li>
                           <li>Using this Website in any way that is or may be damaging to this Website;</li>
                           <li>Using this Website in any way that impacts user access to this Website;</li>
                           <li>Using this Website contrary to applicable laws and regulations;</li>
                           <li>Engaging in any data mining, data harvesting, data extracting;</li>
                           <li>Using this Website to engage in any advertising or marketing.</li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="col-span-12 py-6 lg:sticky lg:bottom-0 lg:col-span-4 lg:self-end">
                  <div class="card">
                     <div class="px-4 pt-2 pb-5 sm:px-5">
                        <h3 class="pt-2 text-lg font-medium text-slate-700 dark:text-navy-100">
                           Severability
                        </h3>
                        <p class="mt-3">
                           If any provision of these Terms is found to be invalid under any applicable law, such provisions shall be deleted without affecting the remaining provisions herein.
                        </p>
                     </div>
                     <div class="px-4 pt-2 pb-5 sm:px-5">
                        <h3 class="pt-2 text-lg font-medium text-slate-700 dark:text-navy-100">
                           Variation of Terms
                        </h3>
                        <p class="mt-3">
                           Tenvault is permitted to revise these Terms at any time as it sees fit, and by using this Website you are expected to review these Terms on a regular basis.
                        </p>
                     </div>
                  </div>
               </div>
            </div>
        </main>
    </div>
</body>
</html>
