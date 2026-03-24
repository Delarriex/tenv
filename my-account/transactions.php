<?php
require_once 'auth_guard.php';

$username = $user['username'] ?? 'User';
$balance = number_format($user['balance'] ?? 0, 2);

// Fetch transactions
$stmt = $pdo->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$transactions = $stmt->fetchAll();
?>
<!DOCTYPE html>
<head>
    <?php include 'partials/head.php'; ?>
    <title>Transactions - Tenvault</title>
</head>

<body x-data class="is-header-blur" x-bind="$store.global.documentBody" :class="{ 'is-sidebar-open': $store.global.isSidebarExpanded }">
    <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900">

        <?php include 'partials/sidebar.php'; ?>

        <?php include 'partials/header.php'; ?>

        <main class="main-content w-full px-[var(--margin-x)] pb-8 pt-6" x-data="{ activeTab: 'all', searchTerm: '' }">
            <div class="flex flex-col items-center justify-between space-y-4 py-5 sm:flex-row sm:space-y-0 lg:py-6">
                <div class="flex flex-col items-center space-y-1 sm:items-start">
                    <h2 class="text-xl font-medium text-slate-700 dark:text-navy-50">Transaction History</h2>
                    <p class="text-xs+ text-slate-500 dark:text-navy-200">View and manage your financial activity</p>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="rounded-lg bg-slate-100 px-3 py-2 dark:bg-navy-800">
                        <span class="text-xs+ font-medium text-slate-500 dark:text-navy-300">Available Balance:</span>
                        <span class="ml-1 text-sm font-bold text-primary dark:text-accent-light">$<?php echo $balance; ?></span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
                <div class="card p-2">
                    <div class="flex space-x-1 overflow-x-auto rounded-lg bg-slate-150 p-1 dark:bg-navy-800">
                        <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-white shadow text-slate-800 dark:bg-navy-600 dark:text-navy-100' : 'text-slate-600 dark:text-navy-200'" class="btn shrink-0 rounded-lg px-3 py-2 font-medium transition-all">All</button>
                        <button @click="activeTab = 'deposit'" :class="activeTab === 'deposit' ? 'bg-white shadow text-success dark:bg-navy-600' : 'text-slate-600 dark:text-navy-200'" class="btn shrink-0 rounded-lg px-3 py-2 font-medium transition-all">Deposits</button>
                        <button @click="activeTab = 'withdrawal'" :class="activeTab === 'withdrawal' ? 'bg-white shadow text-error dark:bg-navy-600' : 'text-slate-600 dark:text-navy-200'" class="btn shrink-0 rounded-lg px-3 py-2 font-medium transition-all">Withdrawals</button>
                    </div>
                </div>

                <div class="card hidden sm:block">
                    <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                        <table class="is-hoverable w-full text-left">
                            <thead>
                                <tr class="border-b border-slate-150 bg-slate-50/50 dark:border-navy-500 dark:bg-navy-700/50">
                                    <th class="px-4 py-3 font-semibold uppercase lg:px-5">Type</th>
                                    <th class="px-4 py-3 font-semibold uppercase lg:px-5">Amount</th>
                                    <th class="px-4 py-3 font-semibold uppercase lg:px-5">Date</th>
                                    <th class="px-4 py-3 font-semibold uppercase lg:px-5">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($transactions)): ?>
                                    <tr><td colspan="4" class="p-8 text-center text-slate-400 dark:text-navy-300">No transactions found.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($transactions as $tx): ?>
                                        <tr x-show="activeTab === 'all' || activeTab === '<?php echo $tx['type']; ?>'">
                                            <td class="px-4 py-3 sm:px-5 font-medium uppercase"><?php echo $tx['type']; ?></td>
                                            <td class="px-4 py-3 sm:px-5 font-bold text-slate-700 dark:text-navy-100">$<?php echo number_format($tx['amount'], 2); ?></td>
                                            <td class="px-4 py-3 sm:px-5"><?php echo date('M d, Y H:i', strtotime($tx['created_at'])); ?></td>
                                            <td class="px-4 py-3 sm:px-5">
                                                <span class="badge rounded-full <?php echo $tx['status'] === 'completed' ? 'bg-success/10 text-success' : 'bg-warning/10 text-warning'; ?>">
                                                    <?php echo $tx['status']; ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Mobile Cards -->
                <div class="sm:hidden space-y-4">
                    <?php if (empty($transactions)): ?>
                        <div class="card p-8 text-center text-slate-400 dark:text-navy-300">No transactions found.</div>
                    <?php else: ?>
                        <?php foreach ($transactions as $tx): ?>
                            <div class="card p-4" x-show="activeTab === 'all' || activeTab === '<?php echo $tx['type']; ?>'">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-bold uppercase text-xs"><?php echo $tx['type']; ?></span>
                                    <span class="text-xs text-slate-400"><?php echo date('M d, Y', strtotime($tx['created_at'])); ?></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-slate-700 dark:text-navy-100">$<?php echo number_format($tx['amount'], 2); ?></span>
                                    <span class="badge rounded-full <?php echo $tx['status'] === 'completed' ? 'bg-success/10 text-success' : 'bg-warning/10 text-warning'; ?>">
                                        <?php echo $tx['status']; ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
    <script>window.addEventListener("DOMContentLoaded", () => Alpine.start());</script>
</body>
</html>
