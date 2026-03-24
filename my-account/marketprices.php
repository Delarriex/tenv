<?php
require_once 'auth_guard.php';
require_once '../config/db.php';

// Get user data for the sidebar
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$pageTitle = "Crypto and NFT News - Tenvault";
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'partials/head.php'; ?>
<script src="https://www.cryptohopper.com/widgets/js/script"></script>
<body x-data class="is-header-blur" x-bind="$store.global.documentBody" :class="{ 'is-sidebar-open': $store.global.isSidebarExpanded }">
    <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900">
        <?php include 'partials/sidebar.php'; ?>
        <?php include 'partials/header.php'; ?>
        
        <main class="main-content w-full px-[var(--margin-x)] pb-8 pt-6">
            <div class="flex items-center justify-between py-5 lg:py-6">
                <div class="flex items-center space-x-1">
                    <h2 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-50 lg:text-2xl">
                        Crypto and NFT News
                    </h2>
                </div>

                <div class="flex items-center space-x-2">
                    <label class="relative hidden sm:flex">
                        <input class="form-input peer h-9 w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 text-xs+ placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" placeholder="Search News..." type="text" />
                        <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-colors duration-200" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3.316 13.781l.73-.171-.73.171zm0-5.457l.73.171-.73-.171zm15.473 0l.73-.171-.73.171zm0 5.457l.73.171-.73-.171zm-5.008 5.008l-.171-.73.171.73zm-5.457 0l-.171.73.171-.73zm0-15.473l-.171-.73.171.73zm5.457 0l.171-.73-.171.73zM20.47 21.53a.75.75 0 101.06-1.06l-1.06 1.06zM4.046 13.61a11.198 11.198 0 010-5.115l-1.46-.342a12.698 12.698 0 000 5.8l1.46-.343zm14.013-5.115a11.196 11.196 0 010 5.115l1.46.342a12.698 12.698 0 000-5.8l-1.46.343zm-4.45 9.564a11.196 11.196 0 01-5.114 0l-.342 1.46c1.907.448 3.892.448 5.8 0l-.343-1.46zM8.496 4.046a11.198 11.198 0 015.115 0l.342-1.46a12.698 12.698 0 00-5.8 0l.343 1.46zm0 14.013a5.97 5.97 0 01-4.45-4.45l-1.46.343a7.47 7.47 0 005.568 5.568l.342-1.46zm5.457 1.46a7.47 7.47 0 005.568-5.567l-1.46-.342a5.97 5.97 0 01-4.45 4.45l.342 1.46zM13.61 4.046a5.97 5.97 0 014.45 4.45l1.46-.343a7.47 7.47 0 00-5.568-5.567l-.342 1.46zm-5.457-1.46a7.47 7.47 0 00-5.567 5.567l1.46.342a5.97 5.97 0 014.45-4.45l-.343-1.46zm8.652 15.28l3.665 3.664 1.06-1.06-3.665-3.665-1.06 1.06z" />
                            </svg>
                        </span>
                    </label>
                </div>
            </div>
            <div class="mb-5" style="margin-top:-20px; margin-bottom: 20px; height:62px; background-color: #1D2330; overflow:hidden; box-sizing: border-box; border: 1px solid #282E3B; border-radius: 4px; text-align: right; line-height:14px; block-size:36px; font-size: 12px; font-feature-settings: normal; text-size-adjust: 100%; box-shadow: inset 0 -20px 0 0 #262B38;padding:1px;padding: 0px; width: 100%;">
                <div style="height:40px; padding:0px; margin:0px; width: 100%;">
                    <iframe src="https://widget.coinlib.io/widget?type=horizontal_v2&amp;theme=transparent&amp;pref_coin_id=1505&amp;invert_hover=no" width="100%" height="36px" scrolling="auto" marginwidth="0" marginheight="0" frameborder="0" border="0" style="border:0;margin:0;padding:0;"></iframe>
                </div>
            </div>
            <div style="color:white;" class="cryptohopper-web-widget" data-id="5"></div>
        </main>
    </div>
</body>
</html>
