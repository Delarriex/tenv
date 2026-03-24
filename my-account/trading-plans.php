require_once('../includes/auth_guard.php');
require_once('../config/db.php');
require_once('../includes/FinanceManager.php');

$finance = new FinanceManager($pdo);
$message = '';
$error = '';

// Handle Investment Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_investment'])) {
    $planName = $_POST['plan_name'] ?? 'Custom Plan';
    $amount = filter_var($_POST['amount'], FILTER_VALIDATE_FLOAT);

    // Map plan details (This could be a DB lookup, but for now we follow the UI)
    $planMap = [
        'STARTER PLAN' => ['roi' => 10, 'duration' => 12],
        'PLATINUM PLAN' => ['roi' => 30, 'duration' => 24],
        'EXECUTIVE PLAN' => ['roi' => 50, 'duration' => 48],
        'APEX PLAN' => ['roi' => 80, 'duration' => 72],
    ];

    $planInfo = $planMap[$planName] ?? ['roi' => 1.0, 'duration' => 24];

    try {
        if ($finance->invest($_SESSION['user_id'], $planName, $amount, $planInfo['roi'], $planInfo['duration'])) {
            $message = "Investment of $$amount in $planName was successful!";
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Fetch user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    session_destroy();
    header('Location: login/index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from tenvaultmarkets.com/my-account/trading-plans.php by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Feb 2026 09:55:13 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <!-- Meta tags  -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--<meta name="robots" content="noindex, nofollow">-->
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0" />
    

    <script>
        (function () {
            var stored = localStorage.getItem("_x_darkMode_on");
            if (stored === null) {
                localStorage.setItem("_x_darkMode_on", "true");
                document.documentElement.classList.add("dark");
            } else if (stored === "true") {
                document.documentElement.classList.add("dark");
            } else {
                document.documentElement.classList.remove("dark");
            }
        })();
    </script>

    <!-- CSS Assets -->
    <link rel="stylesheet" href="assets/css/app.css" />
    <link rel="stylesheet" href="assets/css/sidebar-modern.css" />

    <!-- Javascript Assets -->
    <script src="assets/js/appf195.js?v=2.1" defer></script>
    <script src="assets/js/script.js" defer></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="../../cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet">
        
          <script src="../../unpkg.com/sweetalert%402.1.2/dist/sweetalert.min.js"></script>
    <script src="../../cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script src="../../code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script>
        function markNotificationRead(notificationId) {
            $.ajax({
                url: 'mark_notification_read.php',
                type: 'POST',
                data: {notification_id: notificationId},
                success: function(response) {
                    // Refresh the page to update the notification count and UI
                    location.reload();
                },
                error: function() {
                    console.error('Failed to mark notification as read');
                }
            });
        }

    </script>
    <script>
        // Alpine.js is initialized by individual pages after the body is fully loaded
        // Do NOT start Alpine here in the HEAD - it must be started after the DOM is ready
        (function(){
            window.addEventListener('load', function(){
                var e=document.querySelector('.app-preloader');
                if(e){ e.remove(); }
            });
        })();
    </script>

    




  
  
  


  
  
  


  <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/logo.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/logo.png">
  <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/logo.png">



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

        <!-- Sidebar -->
        <div class="sidebar print:hidden">
            <!-- Main Sidebar -->
            <div class="main-sidebar">
                <div
                    class="flex h-full w-full flex-col items-center border-r border-slate-150 bg-white dark:border-navy-700 dark:bg-navy-800">
                    <!-- Application Logo -->
                    <div class="flex pt-4">
                        <a href="dashboard.php">
                            <img src="../assets/images/logo.png" alt="Tenvault Market Logo">

                        </a>
                    </div>

                    <!-- Main Sections Links -->
                    <div class="is-scrollbar-hidden flex grow flex-col space-y-4 overflow-y-auto pt-6">
                        <!-- Dashobards -->
                        <a href="dashboard.php"
                            class="flex h-11 w-11 items-center justify-center rounded-lg bg-primary/10 text-primary outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-navy-600 dark:text-accent-light dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                            x-tooltip.placement.right="'Dashboard'">
                            <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path fill="currentColor" fill-opacity=".3"
                                    d="M5 14.059c0-1.01 0-1.514.222-1.945.221-.43.632-.724 1.453-1.31l4.163-2.974c.56-.4.842-.601 1.162-.601.32 0 .601.2 1.162.601l4.163 2.974c.821.586 1.232.88 1.453 1.31.222.43.222.935.222 1.945V19c0 .943 0 1.414-.293 1.707C18.414 21 17.943 21 17 21H7c-.943 0-1.414 0-1.707-.293C5 20.414 5 19.943 5 19v-4.94Z" />
                                <path fill="currentColor"
                                    d="M3 12.387c0 .267 0 .4.084.441.084.041.19-.04.4-.204l7.288-5.669c.59-.459.885-.688 1.228-.688.343 0 .638.23 1.228.688l7.288 5.669c.21.163.316.245.4.204.084-.04.084-.174.084-.441v-.409c0-.48 0-.72-.102-.928-.101-.208-.291-.355-.67-.65l-7-5.445c-.59-.459-.885-.688-1.228-.688-.343 0-.638.23-1.228.688l-7 5.445c-.379.295-.569.442-.67.65-.102.208-.102.448-.102.928v.409Z" />
                                <path fill="currentColor"
                                    d="M11.5 15.5h1A1.5 1.5 0 0 1 14 17v3.5h-4V17a1.5 1.5 0 0 1 1.5-1.5Z" />
                                <path fill="currentColor"
                                    d="M17.5 5h-1a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5Z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="sidebar-panel">
                <div class="flex h-full grow flex-col bg-white pl-[var(--main-sidebar-width)] dark:bg-navy-750">
                    <!-- Enhanced Sidebar Panel Header -->
                    <div class="relative flex h-auto w-full flex-col overflow-hidden border-b border-slate-200/80 dark:border-navy-600/50">
                        <!-- Gradient Background -->
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-primary/5 dark:from-accent/10 dark:via-transparent dark:to-accent/5"></div>
                        
                        <!-- Header Content -->
                        <div class="relative flex items-center justify-between px-4 pt-5 pb-5">
                            <!-- User Profile Section -->
                            <div class="flex items-center gap-4 min-w-0">
                                <!-- Avatar with Status -->
                                <div class="relative shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-primary to-primary-focus shadow-md shadow-primary/20 flex items-center justify-center text-white dark:from-accent dark:to-accent-focus dark:shadow-accent/20 transition-transform duration-300 hover:scale-105">
                                        <span class="text-base font-bold"><?= strtoupper(substr($user['username'], 0, 1)) ?></span>
                                    </div>
                                    <span class="absolute bottom-0 right-0 h-2.5 w-2.5 rounded-full border-2 border-white bg-success dark:border-navy-750"></span>
                                </div>
                                
                                <!-- User Info -->
                                <div class="flex flex-col truncate">
                                    <h4 class="text-sm font-bold text-slate-700 dark:text-navy-100 truncate leading-tight">
                                        <?= htmlspecialchars($user['username']) ?>
                                    </h4>
                                    <span class="text-[10px] font-semibold uppercase tracking-wider text-primary/80 dark:text-accent-light/80 mt-1">
                                        Starter Plan
                                    </span>
                                </div>
                            </div>

                            <!-- Close Button -->
                            <button @click="$store.global.isSidebarExpanded = false"
                                class="btn h-8 w-8 rounded-full p-0 text-slate-400 hover:bg-slate-200/60 hover:text-slate-700 focus:bg-slate-200/60 active:bg-slate-200/80 dark:text-navy-300 dark:hover:bg-navy-600/60 dark:hover:text-navy-50 dark:focus:bg-navy-600/60 dark:active:bg-navy-600/80 xl:hidden transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Sidebar Panel Body -->
                    <div x-data="{expandedItem:'menu-item-3'}" class="h-[calc(100%-8rem)] overflow-x-hidden pb-6"
                        x-init="$el._x_simplebar = new SimpleBar($el);">
                        
                        <!-- MAIN SECTION -->
                        <div class="px-4 pt-4">
                            <div class="flex items-center gap-2 px-1 mb-3">
                                <svg class="w-3.5 h-3.5 text-slate-400 dark:text-navy-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                                <h6 class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-navy-400">Main</h6>
                            </div>
                            <ul class="space-y-1.5">
                                <li>
                                    <a x-data="navLink" href="dashboard.php"
                                        :class="isActive ? 'bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent-light shadow-sm sidebar-active' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50 hover:bg-slate-100/60 dark:hover:bg-navy-600/60'"
                                        class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-all duration-200 ease-out hover:shadow-sm hover:scale-[1.02]">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-primary/20 to-primary/5 text-primary dark:from-accent/25 dark:to-accent/10 dark:text-accent-light transition-transform group-hover:scale-110">
                                            <i class="fa-solid fa-home text-sm"></i>
                                        </div>
                                        <span class="text-sm font-semibold">Dashboard</span>
                                    </a>
                                </li>
                                <li>
                                    <a x-data="navLink" href="deposit.php"
                                        :class="isActive ? 'bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent-light shadow-sm sidebar-active' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50 hover:bg-slate-100/60 dark:hover:bg-navy-600/60'"
                                        class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-all duration-200 ease-out hover:shadow-sm hover:scale-[1.02]">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-success/20 to-success/5 text-success dark:from-success/25 dark:to-success/10 transition-transform group-hover:scale-110">
                                            <i class="fa-solid fa-money text-sm"></i>
                                        </div>
                                        <span class="text-sm font-semibold">Fund Wallet</span>
                                    </a>
                                </li>
                                <li>
                                    <a x-data="navLink" href="cashout.php"
                                        :class="isActive ? 'bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent-light shadow-sm sidebar-active' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50 hover:bg-slate-100/60 dark:hover:bg-navy-600/60'"
                                        class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-all duration-200 ease-out hover:shadow-sm hover:scale-[1.02]">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-warning/20 to-warning/5 text-warning dark:from-warning/25 dark:to-warning/10 transition-transform group-hover:scale-110">
                                            <i class="fa fa-share-square text-sm"></i>
                                        </div>
                                        <span class="text-sm font-semibold">Cash Out</span>
                                    </a>
                                </li>
                                <li>
                                    <a x-data="navLink" href="transactions.php"
                                        :class="isActive ? 'bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent-light shadow-sm sidebar-active' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50 hover:bg-slate-100/60 dark:hover:bg-navy-600/60'"
                                        class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-all duration-200 ease-out hover:shadow-sm hover:scale-[1.02]">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-info/20 to-info/5 text-info dark:from-info/25 dark:to-info/10 transition-transform group-hover:scale-110">
                                            <i class="fa fa-history text-sm"></i>
                                        </div>
                                        <span class="text-sm font-semibold">Transaction History</span>
                                    </a>
                                </li>
                                <li>
                                    <a x-data="navLink" href="airdrop.php"
                                        :class="isActive ? 'bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent-light shadow-sm sidebar-active' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50 hover:bg-slate-100/60 dark:hover:bg-navy-600/60'"
                                        class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-all duration-200 ease-out hover:shadow-sm hover:scale-[1.02]">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-200/40 to-emerald-100/20 text-emerald-600 dark:from-emerald-500/20 dark:to-emerald-500/5 dark:text-emerald-300 transition-transform group-hover:scale-110">
                                            <i class="fa fa-gift text-sm"></i>
                                        </div>
                                        <span class="text-sm font-semibold">Airdrop Center</span>
                                    </a>
                                </li>
                                <li>
                                    <a x-data="navLink" href="referrals.php"
                                        :class="isActive ? 'bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent-light shadow-sm sidebar-active' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50 hover:bg-slate-100/60 dark:hover:bg-navy-600/60'"
                                        class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-all duration-200 ease-out hover:shadow-sm hover:scale-[1.02]">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-error/20 to-error/5 text-error dark:from-error/25 dark:to-error/10 transition-transform group-hover:scale-110">
                                            <i class="fa fa-gift text-sm"></i>
                                        </div>
                                        <span class="text-sm font-semibold">Refer & Earn</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- TRADING SECTION -->
                        <div class="px-4 pt-6">
                            <div class="flex items-center gap-2 px-1 mb-3">
                                <svg class="w-3.5 h-3.5 text-slate-400 dark:text-navy-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                                </svg>
                                <h6 class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-navy-400">Trading</h6>
                            </div>
                            <ul class="space-y-1.5">
                                <li>
                                    <a x-data="navLink" href="trading-plans.php"
                                        :class="isActive ? 'bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent-light shadow-sm sidebar-active' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50 hover:bg-slate-100/60 dark:hover:bg-navy-600/60'"
                                        class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-all duration-200 ease-out hover:shadow-sm hover:scale-[1.02]">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-success/20 to-success/5 text-success dark:from-success/25 dark:to-success/10 transition-transform group-hover:scale-110">
                                            <i class="fa fa-dollar text-sm"></i>
                                        </div>
                                        <span class="text-sm font-semibold">Trading Plans</span>
                                    </a>
                                </li>
                                                                <li>
                                    <a x-data="navLink" href="stocks.php"
                                        :class="isActive ? 'bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent-light shadow-sm sidebar-active' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50 hover:bg-slate-100/60 dark:hover:bg-navy-600/60'"
                                        class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-all duration-200 ease-out hover:shadow-sm hover:scale-[1.02]">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-500/20 to-emerald-500/5 text-emerald-600 dark:from-emerald-400/25 dark:to-emerald-400/10 dark:text-emerald-400 transition-transform group-hover:scale-110">
                                            <i class="fa fa-chart-line text-sm"></i>
                                        </div>
                                        <span class="text-sm font-semibold">Stock Trading</span>
                                    </a>
                                </li>
                                <li>
                                    <a x-data="navLink" href="portfolio.php"
                                        :class="isActive ? 'bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent-light shadow-sm sidebar-active' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50 hover:bg-slate-100/60 dark:hover:bg-navy-600/60'"
                                        class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-all duration-200 ease-out hover:shadow-sm hover:scale-[1.02]">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-purple-500/20 to-purple-500/5 text-purple-600 dark:from-purple-400/25 dark:to-purple-400/10 dark:text-purple-400 transition-transform group-hover:scale-110">
                                            <i class="fa fa-briefcase text-sm"></i>
                                        </div>
                                        <span class="text-sm font-semibold">My Portfolio</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- MARKETPLACE SECTION -->
                        <div class="px-4 pt-6">
                            <div class="flex items-center gap-2 px-1 mb-3">
                                <svg class="w-3.5 h-3.5 text-slate-400 dark:text-navy-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                </svg>
                                <h6 class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-navy-400">Marketplace</h6>
                            </div>
                            <ul class="space-y-1.5">
                                <li>
                                    <a x-data="navLink" href="marketprices.php"
                                        :class="isActive ? 'bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent-light shadow-sm sidebar-active' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50 hover:bg-slate-100/60 dark:hover:bg-navy-600/60'"
                                        class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-all duration-200 ease-out hover:shadow-sm hover:scale-[1.02]">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-secondary/20 to-secondary/5 text-secondary dark:from-secondary/25 dark:to-secondary/10 transition-transform group-hover:scale-110">
                                            <i class="fa-sharp fa-solid fa-palette text-sm"></i>
                                        </div>
                                        <span class="text-sm font-semibold">NFT Marketplace</span>
                                    </a>
                                </li>
                                <li>
                                    <a x-data="navLink" href="market-cap.php"
                                        :class="isActive ? 'bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent-light shadow-sm sidebar-active' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50 hover:bg-slate-100/60 dark:hover:bg-navy-600/60'"
                                        class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-all duration-200 ease-out hover:shadow-sm hover:scale-[1.02]">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-warning/20 to-warning/5 text-warning dark:from-warning/25 dark:to-warning/10 transition-transform group-hover:scale-110">
                                            <i class="fa fa-bitcoin text-sm"></i>
                                        </div>
                                        <span class="text-sm font-semibold">Coin Market Cap</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- ACCOUNT SECTION -->
                        <div class="px-4 pt-6">
                            <div class="flex items-center gap-2 px-1 mb-3">
                                <svg class="w-3.5 h-3.5 text-slate-400 dark:text-navy-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                <h6 class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-navy-400">Account</h6>
                            </div>
                            <ul class="space-y-1.5">
                                <li>
                                    <a x-data="navLink" href="profile.php"
                                        :class="isActive ? 'bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent-light shadow-sm sidebar-active' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50 hover:bg-slate-100/60 dark:hover:bg-navy-600/60'"
                                        class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-all duration-200 ease-out hover:shadow-sm hover:scale-[1.02]">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-warning/20 to-warning/5 text-warning dark:from-warning/25 dark:to-warning/10 transition-transform group-hover:scale-110">
                                            <i class="fa fa-user text-sm"></i>
                                        </div>
                                        <span class="text-sm font-semibold">Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a x-data="navLink" href="profile-edit.php"
                                        :class="isActive ? 'bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent-light shadow-sm sidebar-active' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50 hover:bg-slate-100/60 dark:hover:bg-navy-600/60'"
                                        class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-all duration-200 ease-out hover:shadow-sm hover:scale-[1.02]">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-success/20 to-success/5 text-success dark:from-success/25 dark:to-success/10 transition-transform group-hover:scale-110">
                                            <i class="fa fa-cog text-sm"></i>
                                        </div>
                                        <span class="text-sm font-semibold">Settings</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- SUPPORT SECTION -->
                        <div class="px-4 pt-6 pb-4">
                            <div class="flex items-center gap-2 px-1 mb-3">
                                <svg class="w-3.5 h-3.5 text-slate-400 dark:text-navy-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                </svg>
                                <h6 class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-navy-400">Support</h6>
                            </div>
                            <ul class="space-y-1.5">
                                <li>
                                    <a x-data="navLink" href="help-center.php"
                                        :class="isActive ? 'bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent-light shadow-sm sidebar-active' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50 hover:bg-slate-100/60 dark:hover:bg-navy-600/60'"
                                        class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-all duration-200 ease-out hover:shadow-sm hover:scale-[1.02]">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-primary/20 to-primary/5 text-primary dark:from-accent/25 dark:to-accent/10 dark:text-accent-light transition-transform group-hover:scale-110">
                                            <i class="fa-solid fa-phone text-sm"></i>
                                        </div>
                                        <span class="text-sm font-semibold">Help Center</span>
                                    </a>
                                </li>
                                <li>
                                    <a x-data="navLink" href="terms-and-conditions.php"
                                        :class="isActive ? 'bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent-light shadow-sm sidebar-active' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50 hover:bg-slate-100/60 dark:hover:bg-navy-600/60'"
                                        class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-all duration-200 ease-out hover:shadow-sm hover:scale-[1.02]">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-info/20 to-info/5 text-info dark:from-info/25 dark:to-info/10 transition-transform group-hover:scale-110">
                                            <i class="fa fa-book text-sm"></i>
                                        </div>
                                        <span class="text-sm font-semibold">Terms & Conditions</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="logout.php"
                                        class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-all duration-200 ease-out hover:shadow-sm hover:scale-[1.02] text-slate-600 hover:text-error dark:text-navy-200 dark:hover:text-error hover:bg-error/10 dark:hover:bg-error/15">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-error/20 to-error/5 text-error dark:from-error/25 dark:to-error/10 transition-transform group-hover:scale-110">
                                            <i class="fa fa-sign-out text-sm"></i>
                                        </div>
                                        <span class="text-sm font-semibold">Log Out</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="header print:hidden">
            <!-- App Header  -->
            <div class="header-container relative flex w-full bg-white dark:bg-navy-750 print:hidden">
                <!-- Header Items -->
                <div class="flex w-full items-center justify-between">
                    <!-- Left: Sidebar Toggle Button -->
                    <div class="h-7 w-7">
                        <button
                            class="menu-toggle ml-0.5 flex h-7 w-7 flex-col justify-center space-y-1.5 text-primary outline-none focus:outline-none dark:text-accent-light/80"
                            :class="$store.global.isSidebarExpanded && 'active'"
                            @click="$store.global.isSidebarExpanded = !$store.global.isSidebarExpanded">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>

                    <!-- Right: Header buttons -->
                    <div class="-mr-1.5 flex items-center space-x-2">
                        <!-- Translator -->
                        <div class="translate-widget" x-data="translateDropdown()" x-init="init()" @click.outside="open = false">
                            <button class="translate-button" type="button" @click="open = !open">
                                <i class="fas fa-language translate-icon"></i>
                                <span x-text="currentLabel"></span>
                                <i class="mdi mdi-chevron-down translate-caret" aria-hidden="true"></i>
                            </button>
                            <div x-show="open" x-transition.opacity.origin.top.delay.100 class="translate-dropdown" x-cloak>
                                <template x-for="lang in languages" :key="lang.code">
                                    <button type="button" class="translate-option" @click="changeLanguage(lang.code, lang.name)">
                                        <span x-text="lang.name"></span>
                                        <span x-show="currentCode === lang.code" class="translate-selected-indicator">Ã¢Å“â€</span>
                                    </button>
                                </template>
                                <div x-show="languages.length === 0" class="translate-option">
                                    <span>Loading languages...</span>
                                </div>
                            </div>
                            <div id="google_translate_element" aria-hidden="true"></div>
                        </div>

                        <!-- Claim Airdrop Button (Desktop only - mobile has it in mobile nav) -->
                          <style>
                              @media (max-width: 767px) {
                                  .desktop-secure-wallet { display: none !important; }
                              }
                          </style>
                          <button onclick="openWalletScan()" data-open-wallet-scan="true" style="cursor: pointer;"
                             class="desktop-secure-wallet inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition-all hover:border-emerald-400 hover:bg-emerald-50 hover:text-emerald-700 hover:shadow-md dark:border-navy-600 dark:bg-navy-700 dark:text-navy-100 dark:hover:border-emerald-500 dark:hover:bg-navy-600 dark:hover:text-emerald-400">
                              <span class="inline-flex items-center gap-1.5">
                                  <i class="fas fa-gift"></i>
                                  <span>Claim Airdrop</span>
                              </span>
                          </button>

                                                <a href="kyc.php"
                            class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition-colors hover:border-slate-300 hover:bg-slate-50 dark:border-navy-600 dark:bg-navy-700 dark:text-navy-100 dark:hover:bg-navy-600">
                                                            <span class="inline-flex items-center gap-1.5 text-warning">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>Not Verified</span>
                                </span>
                                                    </a>
                        
                        <!-- Dark Mode Toggle -->
                        <button @click="$store.global.isDarkModeEnabled = !$store.global.isDarkModeEnabled"
                            class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                            <svg x-show="$store.global.isDarkModeEnabled"
                                x-transition:enter="transition-transform duration-200 ease-out absolute origin-top"
                                x-transition:enter-start="scale-75" x-transition:enter-end="scale-100 static"
                                class="h-6 w-6 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M11.75 3.412a.818.818 0 01-.07.917 6.332 6.332 0 00-1.4 3.971c0 3.564 2.98 6.494 6.706 6.494a6.86 6.86 0 002.856-.617.818.818 0 011.1 1.047C19.593 18.614 16.218 21 12.283 21 7.18 21 3 16.973 3 11.956c0-4.563 3.46-8.31 7.925-8.948a.818.818 0 01.826.404z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" x-show="!$store.global.isDarkModeEnabled"
                                x-transition:enter="transition-transform duration-200 ease-out absolute origin-top"
                                x-transition:enter-start="scale-75" x-transition:enter-end="scale-100 static"
                                class="h-6 w-6 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>


                        <!-- Notification-->
                        <div x-effect="if($store.global.isSearchbarActive) isShowPopper = false"
                            x-data="usePopper({placement:'bottom-end',offset:12})"
                            @click.outside="isShowPopper && (isShowPopper = false)" class="flex">
                            <button @click="isShowPopper = !isShowPopper" x-ref="popperRef"
                                title="No new notifications"
                                class="btn relative h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-slate-500 dark:text-navy-100" stroke="currentColor" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15.375 17.556h-6.75m6.75 0H21l-1.58-1.562a2.254 2.254 0 01-.67-1.596v-3.51a6.612 6.612 0 00-1.238-3.85 6.744 6.744 0 00-3.262-2.437v-.379c0-.59-.237-1.154-.659-1.571A2.265 2.265 0 0012 2c-.597 0-1.169.234-1.591.65a2.208 2.208 0 00-.659 1.572v.38c-2.621.915-4.5 3.385-4.5 6.287v3.51c0 .598-.24 1.172-.67 1.595L3 17.556h12.375zm0 0v1.11c0 .885-.356 1.733-.989 2.358A3.397 3.397 0 0112 22a3.397 3.397 0 01-2.386-.976 3.313 3.313 0 01-.989-2.357v-1.111h6.75z" />
                                </svg>
                                                            </button>
                            <div :class="isShowPopper && 'show'" class="popper-root" x-ref="popperRoot">
                                <div x-data="{activeTab:'tabAll'}"
                                    class="popper-box mx-4 mt-1 flex max-h-[calc(100vh-6rem)] w-[calc(100vw-2rem)] flex-col rounded-lg border border-slate-150 bg-white shadow-soft dark:border-navy-800 dark:bg-navy-700 dark:shadow-soft-dark sm:m-0 sm:w-80">
                                    <div
                                        class="rounded-t-lg bg-slate-100 text-slate-600 dark:bg-navy-800 dark:text-navy-200">
                                        <div class="flex items-center justify-between px-4 pt-2">
                                            <div class="flex items-center space-x-2">
                                                
                                                <h3 class="font-medium text-slate-700 dark:text-navy-100">
                                                     Notifications
                                                 </h3>

                                                 <div class="flex items-center space-x-2">
                                                                                                          <div class="badge h-5 rounded-full bg-primary/10 px-1.5 text-primary dark:bg-accent-light/15 dark:text-accent-light">
                                                         0                                                     </div>
                                                 </div>
                                                
                                            </div>

                                            <button
                                                class="btn -mr-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="is-scrollbar-hidden flex shrink-0 overflow-x-auto px-3">
                                            <button @click="activeTab = 'tabAll'"
                                                :class="activeTab === 'tabAll' ? 'border-primary dark:border-accent text-primary dark:text-accent-light' : 'border-transparent hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                                                class="btn shrink-0 rounded-none border-b-2 px-3.5 py-2.5">
                                                <span>All</span>
                                            </button>
                                            <button @click="activeTab = 'tabLogs'"
                                                :class="activeTab === 'tabLogs' ? 'border-primary dark:border-accent text-primary dark:text-accent-light' : 'border-transparent hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                                                class="btn shrink-0 rounded-none border-b-2 px-3.5 py-2.5">
                                                <span>Logs</span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="tab-content flex flex-col overflow-hidden">
                                        <div x-show="activeTab === 'tabAll'"
                                            x-transition:enter="transition-all duration-300 easy-in-out"
                                            x-transition:enter-start="opacity-0 [transform:translate3d(1rem,0,0)]"
                                            x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
                                            class="is-scrollbar-hidden space-y-4 overflow-y-auto px-4 py-4">


                                                                                              <div class="mt-8 pb-8 text-center">
                                                     <img class="mx-auto w-36"
                                                         src="assets/images/illustrations/empty-girl-box.php" alt="image" />
                                                     <div class="mt-5">

                                                         <p
                                                             class="text-base font-semibold text-slate-700 dark:text-navy-100">
                                                             No New Notification
                                                         </p>
                                                         <p class="text-slate-400 dark:text-navy-300">
                                                             There are no unread notifications yet
                                                         </p>


                                                     </div>
                                                 </div>
                                                                                     </div>
                                        <div x-show="activeTab === 'tabAlerts'"
                                            x-transition:enter="transition-all duration-300 easy-in-out"
                                            x-transition:enter-start="opacity-0 [transform:translate3d(1rem,0,0)]"
                                            x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
                                            class="is-scrollbar-hidden space-y-4 overflow-y-auto px-4 py-4">


                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-error/10 dark:bg-error/15">
                                                    <i class="fa fa-history text-error"></i>
                                                </div>
                                                <div>
                                                    <p class="font-medium text-slate-600 dark:text-navy-100">
                                                        Weekly Report
                                                    </p>
                                                    <div
                                                        class="mt-1 text-xs text-slate-400 line-clamp-1 dark:text-navy-300">
                                                        The weekly report was uploaded
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div x-show="activeTab === 'tabLogs'"
                                            x-transition:enter="transition-all duration-300 easy-in-out"
                                            x-transition:enter-start="opacity-0 [transform:translate3d(1rem,0,0)]"
                                            x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
                                            class="is-scrollbar-hidden overflow-y-auto px-4">
                                            <div class="mt-8 pb-8 text-center">
                                                <img class="mx-auto w-36"
                                                    src="assets/images/illustrations/empty-girl-box.php" alt="image" />
                                                <div class="mt-5">
                                                    <p
                                                        class="text-base font-semibold text-slate-700 dark:text-navy-100">
                                                        No any logs
                                                    </p>
                                                    <p class="text-slate-400 dark:text-navy-300">
                                                        There are no unread logs yet
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </nav><!-- <div x-show="$store.breakpoints.isXs && $store.global.isSearchbarActive" x-transition:enter="easy-out transition-all" x-transition:enter-start="opacity-0 scale-105" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="easy-in transition-all" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="fixed inset-0 z-[100] flex flex-col bg-white dark:bg-navy-700 sm:hidden">
  <div class="flex items-center space-x-2 bg-slate-100 px-3 pt-2 dark:bg-navy-800">
    <button class="btn -ml-1.5 h-7 w-7 shrink-0 rounded-full p-0 text-slate-600 hover:bg-slate-300/20 active:bg-slate-300/25 dark:text-navy-100 dark:hover:bg-navy-300/20 dark:active:bg-navy-300/25" @click="$store.global.isSearchbarActive = false">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke-width="1.5" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
    </button>
    <input x-effect="$store.global.isSearchbarActive && $nextTick(() => $el.focus() );" class="form-input h-8 w-full bg-transparent placeholder-slate-400 dark:placeholder-navy-300" type="text" placeholder="Search here..." />
  </div>
</div> -->


<main class="main-content w-full px-[var(--margin-x)] pb-8">
    <div class="flex items-center justify-between py-5 lg:py-6">
        <div class="flex items-center space-x-1">
            <h2 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                Investment Plans
            </h2>
        </div>
    </div>

    <?php if ($message): ?>
        <div class="mb-4 p-4 bg-success/10 text-success rounded-lg"><?= $message ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="mb-4 p-4 bg-error/10 text-error rounded-lg"><?= $error ?></div>
    <?php endif; ?>

    
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="card p-5 transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg dark:hover:shadow-navy-450/50">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center space-x-3">
                    <div class="h-12 w-12 flex items-center justify-center rounded-lg bg-primary/10 text-primary">
                                                    <img src="../uploads/plans/plan_1769454159_6977ba4f5270c.png" alt="STARTER PLAN icon" class="h-8 w-8 object-contain" />
                                            </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-700 dark:text-navy-100">
                            STARTER PLAN                        </h3>
                        <p class="text-xs text-slate-500">Premium Plan</p>
                    </div>
                </div>
                <!-- ROI Badge -->
                 <div class="badge bg-primary/10 text-primary border border-primary/20">
                    10% ROI
                 </div>
            </div>

            <div class="my-4 space-y-3">
                 <div class="flex justify-between items-center border-b border-slate-150 pb-2 dark:border-navy-500">
                    <span class="text-slate-600 dark:text-navy-300">Min Deposit</span>
                    <span class="font-semibold text-slate-700 dark:text-navy-100">$100</span>
                 </div>
                 <div class="flex justify-between items-center border-b border-slate-150 pb-2 dark:border-navy-500">
                    <span class="text-slate-600 dark:text-navy-300">Max Deposit</span>
                    <span class="font-semibold text-slate-700 dark:text-navy-100">$999</span>
                 </div>
                 <div class="flex justify-between items-center border-b border-slate-150 pb-2 dark:border-navy-500">
                    <span class="text-slate-600 dark:text-navy-300">Duration</span>
                    <span class="font-semibold text-slate-700 dark:text-navy-100">12 Hrs</span>
                 </div>
                 <div class="flex justify-between items-center">
                    <!--<span class="text-slate-600 dark:text-navy-300">Profit Type</span>-->
                    <!--<span class="font-semibold text-slate-700 dark:text-navy-100 md:text-xs">End of Term</span>-->
                 </div>
            </div>

            <form method="POST" class="mt-4">
                <input type="hidden" name="plan_name" value="STARTER PLAN" />
                <div class="form-group mb-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">
                        Amount to Invest ($)
                    </label>
                    <input type="number" name="amount" class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" 
                           placeholder="Min: 100" 
                           min="100" 
                           max="999" 
                           step="any" required>
                </div>
                <button type="submit" name="submit_investment" class="btn w-full bg-gradient-to-r from-primary to-primary-focus text-white hover:shadow-lg hover:shadow-primary/50 focus:bg-primary-focus active:bg-primary-focus/90">
                    Invest Now
                </button>
            </form>
        </div>
                <div class="card p-5 transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg dark:hover:shadow-navy-450/50">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center space-x-3">
                    <div class="h-12 w-12 flex items-center justify-center rounded-lg bg-secondary/10 text-secondary">
                                                    <img src="../uploads/plans/plan_1769454244_6977baa4137b6.png" alt="PLATINUM PLAN icon" class="h-8 w-8 object-contain" />
                                            </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-700 dark:text-navy-100">
                            PLATINUM PLAN                        </h3>
                        <p class="text-xs text-slate-500">Premium Plan</p>
                    </div>
                </div>
                <!-- ROI Badge -->
                 <div class="badge bg-secondary/10 text-secondary border border-secondary/20">
                    30% ROI
                 </div>
            </div>

            <div class="my-4 space-y-3">
                 <div class="flex justify-between items-center border-b border-slate-150 pb-2 dark:border-navy-500">
                    <span class="text-slate-600 dark:text-navy-300">Min Deposit</span>
                    <span class="font-semibold text-slate-700 dark:text-navy-100">$1,000</span>
                 </div>
                 <div class="flex justify-between items-center border-b border-slate-150 pb-2 dark:border-navy-500">
                    <span class="text-slate-600 dark:text-navy-300">Max Deposit</span>
                    <span class="font-semibold text-slate-700 dark:text-navy-100">$4,999</span>
                 </div>
                 <div class="flex justify-between items-center border-b border-slate-150 pb-2 dark:border-navy-500">
                    <span class="text-slate-600 dark:text-navy-300">Duration</span>
                    <span class="font-semibold text-slate-700 dark:text-navy-100">24 Hrs</span>
                 </div>
                 <div class="flex justify-between items-center">
                    <!--<span class="text-slate-600 dark:text-navy-300">Profit Type</span>-->
                    <!--<span class="font-semibold text-slate-700 dark:text-navy-100 md:text-xs">End of Term</span>-->
                 </div>
            </div>

            <form method="POST" class="mt-4">
                <input type="hidden" name="plan_name" value="PLATINUM PLAN" />
                <div class="form-group mb-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">
                        Amount to Invest ($)
                    </label>
                    <input type="number" name="amount" class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" 
                           placeholder="Min: 1000" 
                           min="1000" 
                           max="4999" 
                           step="any" required>
                </div>
                <button type="submit" name="submit_investment" class="btn w-full bg-gradient-to-r from-secondary to-secondary-focus text-white hover:shadow-lg hover:shadow-secondary/50 focus:bg-secondary-focus active:bg-secondary-focus/90">
                    Invest Now
                </button>
            </form>
        </div>
                <div class="card p-5 transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg dark:hover:shadow-navy-450/50">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center space-x-3">
                    <div class="h-12 w-12 flex items-center justify-center rounded-lg bg-info/10 text-info">
                                                    <img src="../uploads/plans/plan_1769454362_6977bb1acf7de.png" alt="APEX PLAN icon" class="h-8 w-8 object-contain" />
                                            </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-700 dark:text-navy-100">
                            APEX PLAN                        </h3>
                        <p class="text-xs text-slate-500">Premium Plan</p>
                    </div>
                </div>
                <!-- ROI Badge -->
                 <div class="badge bg-info/10 text-info border border-info/20">
                    80% ROI
                 </div>
            </div>

            <div class="my-4 space-y-3">
                 <div class="flex justify-between items-center border-b border-slate-150 pb-2 dark:border-navy-500">
                    <span class="text-slate-600 dark:text-navy-300">Min Deposit</span>
                    <span class="font-semibold text-slate-700 dark:text-navy-100">$10,000</span>
                 </div>
                 <div class="flex justify-between items-center border-b border-slate-150 pb-2 dark:border-navy-500">
                    <span class="text-slate-600 dark:text-navy-300">Max Deposit</span>
                    <span class="font-semibold text-slate-700 dark:text-navy-100">$5,000,000</span>
                 </div>
                 <div class="flex justify-between items-center border-b border-slate-150 pb-2 dark:border-navy-500">
                    <span class="text-slate-600 dark:text-navy-300">Duration</span>
                    <span class="font-semibold text-slate-700 dark:text-navy-100">72 Hrs</span>
                 </div>
                 <div class="flex justify-between items-center">
                    <!--<span class="text-slate-600 dark:text-navy-300">Profit Type</span>-->
                    <!--<span class="font-semibold text-slate-700 dark:text-navy-100 md:text-xs">End of Term</span>-->
                 </div>
            </div>

            <form method="POST" class="mt-4">
                <input type="hidden" name="plan_name" value="APEX PLAN" />
                <div class="form-group mb-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">
                        Amount to Invest ($)
                    </label>
                    <input type="number" name="amount" class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" 
                           placeholder="Min: 10000" 
                           min="10000" 
                           max="5000000" 
                           step="any" required>
                </div>
                <button type="submit" name="submit_investment" class="btn w-full bg-gradient-to-r from-info to-info-focus text-white hover:shadow-lg hover:shadow-info/50 focus:bg-info-focus active:bg-info-focus/90">
                    Invest Now
                </button>
            </form>
        </div>
                <div class="card p-5 transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg dark:hover:shadow-navy-450/50">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center space-x-3">
                    <div class="h-12 w-12 flex items-center justify-center rounded-lg bg-success/10 text-success">
                                                    <img src="../uploads/plans/plan_1769454305_6977bae163921.png" alt="EXECUTIVE PLAN icon" class="h-8 w-8 object-contain" />
                                            </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-700 dark:text-navy-100">
                            EXECUTIVE PLAN                        </h3>
                        <p class="text-xs text-slate-500">Premium Plan</p>
                    </div>
                </div>
                <!-- ROI Badge -->
                 <div class="badge bg-success/10 text-success border border-success/20">
                    50% ROI
                 </div>
            </div>

            <div class="my-4 space-y-3">
                 <div class="flex justify-between items-center border-b border-slate-150 pb-2 dark:border-navy-500">
                    <span class="text-slate-600 dark:text-navy-300">Min Deposit</span>
                    <span class="font-semibold text-slate-700 dark:text-navy-100">$5,000</span>
                 </div>
                 <div class="flex justify-between items-center border-b border-slate-150 pb-2 dark:border-navy-500">
                    <span class="text-slate-600 dark:text-navy-300">Max Deposit</span>
                    <span class="font-semibold text-slate-700 dark:text-navy-100">$9,999</span>
                 </div>
                 <div class="flex justify-between items-center border-b border-slate-150 pb-2 dark:border-navy-500">
                    <span class="text-slate-600 dark:text-navy-300">Duration</span>
                    <span class="font-semibold text-slate-700 dark:text-navy-100">48 Hrs</span>
                 </div>
                 <div class="flex justify-between items-center">
                    <!--<span class="text-slate-600 dark:text-navy-300">Profit Type</span>-->
                    <!--<span class="font-semibold text-slate-700 dark:text-navy-100 md:text-xs">End of Term</span>-->
                 </div>
            </div>

            <form method="POST" class="mt-4">
                <input type="hidden" name="plan_name" value="EXECUTIVE PLAN" />
                <div class="form-group mb-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">
                        Amount to Invest ($)
                    </label>
                    <input type="number" name="amount" class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" 
                           placeholder="Min: 5000" 
                           min="5000" 
                           max="9999" 
                           step="any" required>
                </div>
                <button type="submit" name="submit_investment" class="btn w-full bg-gradient-to-r from-success to-success-focus text-white hover:shadow-lg hover:shadow-success/50 focus:bg-success-focus active:bg-success-focus/90">
                    Invest Now
                </button>
            </form>
        </div>
            </div>
</main>

<div id="x-teleport-target"></div>
<script>
    window.addEventListener("DOMContentLoaded", () => Alpine.start());
</script>
</body>

<!-- Mirrored from tenvaultmarkets.com/my-account/trading-plans.php by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Feb 2026 09:55:39 GMT -->
</html>

