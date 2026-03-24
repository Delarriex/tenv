<?php
require_once 'auth_guard.php';
require_once '../config/db.php';

// Get user data for the sidebar
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$pageTitle = "Airdrop Center - Tenvault";
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'partials/head.php'; ?>
<style>
  .airdrop-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
  }
  .airdrop-badge.pending { background: rgba(251, 191, 36, 0.15); color: #f59e0b; }
  .airdrop-badge.verifying { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
  .airdrop-badge.approved { background: rgba(16, 185, 129, 0.15); color: #10b981; }
  .airdrop-badge.rejected { background: rgba(239, 68, 68, 0.15); color: #ef4444; }
  .airdrop-badge.cancelled { background: rgba(148, 163, 184, 0.2); color: #94a3b8; }
  .airdrop-tab {
    padding: 6px 12px;
    border-radius: 999px;
    font-weight: 600;
    font-size: 0.85rem;
  }
  .airdrop-tab.active {
    background: #0f172a;
    color: #fff;
  }
  .airdrop-skeleton {
    display: grid;
    gap: 10px;
  }
  .airdrop-skeleton .line {
    height: 14px;
    border-radius: 999px;
    background: linear-gradient(90deg, rgba(226,232,240,0.6), rgba(203,213,225,0.9), rgba(226,232,240,0.6));
    background-size: 200% 100%;
    animation: shimmer 1.4s ease infinite;
  }
  @keyframes shimmer {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
  }
</style>
<body x-data class="is-header-blur" x-bind="$store.global.documentBody" :class="{ 'is-sidebar-open': $store.global.isSidebarExpanded }">
    <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900">
        <?php include 'partials/sidebar.php'; ?>
        <?php include 'partials/header.php'; ?>
        
        <main class="main-content w-full px-[var(--margin-x)] pb-8 pt-6">
            <div class="mt-4 sm:mt-5 lg:mt-6">
                <div class="card px-4 py-5 sm:px-5">
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-700 dark:text-navy-100">Airdrop Center</h2>
                            <p class="text-sm text-slate-500 dark:text-navy-300">Track your current claim and history</p>
                        </div>
                        <a href="dashboard.php" class="btn h-9 rounded-full border border-slate-200 px-4 text-xs font-semibold text-slate-600 hover:bg-slate-100 dark:border-navy-600 dark:text-navy-100">
                            Back to Dashboard
                        </a>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-12 gap-4 sm:gap-5">
                    <div class="col-span-12 lg:col-span-4">
                        <div class="card px-4 py-5 sm:px-5">
                            <h3 class="text-sm font-semibold text-slate-700 dark:text-navy-100">Current Claim Status</h3>
                            <div class="mt-4 rounded-2xl border border-slate-200/60 bg-slate-50 px-4 py-4 text-sm text-slate-600 dark:border-navy-700 dark:bg-navy-800/60 dark:text-navy-200">
                                No airdrop is available right now.
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-8">
                        <div class="card px-4 py-5 sm:px-5">
                            <div class="flex items-center justify-between flex-wrap gap-3">
                                <div>
                                    <h3 class="text-sm font-semibold text-slate-700 dark:text-navy-100">Airdrop Claim History</h3>
                                    <p class="text-xs text-slate-400">Latest claims appear first</p>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <a class="airdrop-tab active" href="?filter=all">All</a>
                                    <a class="airdrop-tab " href="?filter=pending">Pending/Verifying</a>
                                    <a class="airdrop-tab " href="?filter=approved">Approved</a>
                                    <a class="airdrop-tab " href="?filter=rejected">Rejected/Cancelled</a>
                                </div>
                            </div>

                            <div class="mt-4 airdrop-skeleton" id="airdrop-skeleton">
                                <div class="line" style="width: 90%;"></div>
                                <div class="line" style="width: 70%;"></div>
                                <div class="line" style="width: 80%;"></div>
                            </div>

                            <div class="mt-4 rounded-2xl border border-dashed border-slate-200/70 px-4 py-6 text-center text-sm text-slate-500 dark:border-navy-700 dark:text-navy-300">
                                No airdrop claims found for this filter.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        // Simulating skeleton hide for demo consistency
        setTimeout(() => {
            document.getElementById('airdrop-skeleton').style.display = 'none';
        }, 1000);
    </script>
</body>
</html>
