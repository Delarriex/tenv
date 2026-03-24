<?php
require_once 'auth_guard.php';
require_once '../config/db.php';

// Fetch user data for header/sidebar
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$pageTitle = "Help Center - Tenvault";
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'partials/head.php'; ?>
<body x-data class="is-header-blur" x-bind="$store.global.documentBody" :class="{ 'is-sidebar-open': $store.global.isSidebarExpanded }">
    <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900">
        <?php include 'partials/sidebar.php'; ?>
        <?php include 'partials/header.php'; ?>
        
        <main class="main-content w-full px-[var(--margin-x)] pb-8 pt-6">
            <div class="max-w-4xl mx-auto">
                <div class="text-center py-12">
                    <h2 class="text-3xl font-bold mb-4">How can we help you?</h2>
                    <p class="text-slate-500 mb-8">Search our help center or contact our support team.</p>
                    <div class="relative max-w-md mx-auto">
                        <input class="form-input w-full rounded-full border border-slate-300 bg-transparent px-12 py-3 dark:border-navy-450" placeholder="Search for answers..." type="text" />
                        <i class="fa fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                    <div class="card p-6">
                        <h3 class="text-xl font-bold mb-4">Frequently Asked Questions</h3>
                        <div class="space-y-4">
                            <details class="group border-b border-slate-200 dark:border-navy-500 pb-4">
                                <summary class="flex justify-between items-center cursor-pointer font-medium hover:text-primary">
                                    How do I withdraw my profits?
                                    <i class="fa fa-chevron-down group-open:rotate-180 transition-transform"></i>
                                </summary>
                                <p class="mt-4 text-slate-500">You can withdraw profits via the Cash Out page. We support various payment methods including crypto and bank transfers.</p>
                            </details>
                            <details class="group border-b border-slate-200 dark:border-navy-500 pb-4">
                                <summary class="flex justify-between items-center cursor-pointer font-medium hover:text-primary">
                                    What is the minimum investment?
                                    <i class="fa fa-chevron-down group-open:rotate-180 transition-transform"></i>
                                </summary>
                                <p class="mt-4 text-slate-500">Our Starter Plan begins with as little as $100. Check our Trading Plans page for more details.</p>
                            </details>
                        </div>
                    </div>

                    <div class="card p-6 flex flex-col items-center justify-center text-center">
                        <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-4">
                            <i class="fa fa-envelope text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Still need help?</h3>
                        <p class="text-slate-500 mb-6">Our support team is available 24/7 to assist you.</p>
                        <a href="mailto:support@tenvaultmarkets.com" class="btn bg-primary text-white px-8 py-2 rounded-lg">Contact Support</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
