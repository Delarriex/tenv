<?php
require_once 'auth_guard.php';
require_once '../config/db.php';

// Get user data for the sidebar
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$pageTitle = "Refer & Earn - Tenvault";

$referralCode = $user['username'] ?? ''; // Assuming referral code is the username or a specific field
$referralLink = "register/index.php?ref=" . $referralCode;
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'partials/head.php'; ?>
<body x-data class="is-header-blur" x-bind="$store.global.documentBody" :class="{ 'is-sidebar-open': $store.global.isSidebarExpanded }">
    <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900">
        <?php include 'partials/sidebar.php'; ?>
        <?php include 'partials/header.php'; ?>
        
        <main class="main-content w-full px-[var(--margin-x)] pb-8 pt-6">
            <div class="flex flex-col items-start justify-between space-y-3 py-5 sm:flex-row sm:items-center sm:space-y-0 lg:py-6">
                <div>
                    <h2 class="text-xl font-medium text-slate-700 dark:text-navy-50">Refer & Earn</h2>
                    <p class="text-xs+ text-slate-500 dark:text-navy-200">Share your link and earn bonuses on qualified deposits.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:grid-cols-3 lg:gap-6">
                <div class="card p-5 lg:col-span-2">
                    <h3 class="text-base font-semibold text-slate-700 dark:text-navy-100">Your Referral Link</h3>
                    <p class="mt-1 text-xs text-slate-500 dark:text-navy-300">Copy and share this link to invite new users.</p>
                    <div class="mt-4 flex flex-col gap-3 sm:flex-row">
                        <input id="referralLink" readonly class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 text-slate-600 dark:border-navy-450 dark:text-navy-100" value="<?= htmlspecialchars($referralLink) ?>">
                        <button type="button" onclick="copyReferralLink()" class="btn h-10 bg-primary font-semibold text-white hover:bg-primary-focus focus:bg-primary-focus">
                            Copy Link
                        </button>
                    </div>
                </div>
                <div class="card p-5">
                    <h3 class="text-base font-semibold text-slate-700 dark:text-navy-100">Referral Summary</h3>
                    <div class="mt-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500 dark:text-navy-300">Total Referred Users</span>
                            <span class="text-lg font-semibold text-slate-700 dark:text-navy-100">0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500 dark:text-navy-300">Total Referral Earnings</span>
                            <span class="text-lg font-semibold text-success">$0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-5 p-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold text-slate-700 dark:text-navy-100">Referral History</h3>
                </div>
                <div class="mt-4 overflow-x-auto">
                    <table class="is-hoverable w-full text-left">
                        <thead>
                            <tr class="border-b border-slate-150 bg-slate-50/50 dark:border-navy-500 dark:bg-navy-700/50">
                                <th class="whitespace-nowrap px-4 py-3 text-xs font-semibold uppercase text-slate-600 dark:text-navy-200">Referred User</th>
                                <th class="whitespace-nowrap px-4 py-3 text-xs font-semibold uppercase text-slate-600 dark:text-navy-200">Date Joined</th>
                                <th class="whitespace-nowrap px-4 py-3 text-xs font-semibold uppercase text-slate-600 dark:text-navy-200">Deposit Status</th>
                                <th class="whitespace-nowrap px-4 py-3 text-xs font-semibold uppercase text-slate-600 dark:text-navy-200">Bonus Earned</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-500 dark:text-navy-300">No referrals yet.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <script>
    function copyReferralLink() {
        var linkInput = document.getElementById('referralLink');
        linkInput.select();
        linkInput.setSelectionRange(0, 99999);
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(linkInput.value);
        } else {
            document.execCommand('copy');
        }
        // Optional: show a toast or alert
        alert('Referral link copied to clipboard!');
    }
    </script>
</body>
</html>
