        <!-- Sidebar -->
        <div class="sidebar print:hidden">
            <!-- Main Sidebar -->
            <div class="main-sidebar">
                <div class="flex h-full w-full flex-col items-center border-r border-slate-150 bg-white dark:border-navy-700 dark:bg-navy-800">
                    <!-- Application Logo -->
                    <div class="flex pt-4">
                        <a href="dashboard.php">
                            <img src="../assets/images/logo.png" alt="Tenvault Market Logo" class="h-11 w-11 transition-transform duration-500 ease-in-out hover:rotate-[360deg]">
                        </a>
                    </div>

                    <!-- Main Sections Links -->
                    <div class="is-scrollbar-hidden flex grow flex-col space-y-4 overflow-y-auto pt-6">
                        <!-- Dashobards -->
                        <a href="dashboard.php"
                            class="flex h-11 w-11 items-center justify-center rounded-lg bg-primary/10 text-primary outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-navy-600 dark:text-accent-light dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                            x-tooltip.placement.right="'Dashboard'">
                            <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path fill="currentColor" fill-opacity=".3" d="M5 14.059c0-1.01 0-1.514.222-1.945.221-.43.632-.724 1.453-1.31l4.163-2.974c.56-.4.842-.601 1.162-.601.32 0 .601.2 1.162.601l4.163 2.974c.821.586 1.232.88 1.453 1.31.222.43.222.935.222 1.945V19c0 .943 0 1.414-.293 1.707C18.414 21 17.943 21 17 21H7c-.943 0-1.414 0-1.707-.293C5 20.414 5 19.943 5 19v-4.94Z" />
                                <path fill="currentColor" d="M3 12.387c0 .267 0 .4.084.441.084.041.19-.04.4-.204l7.288-5.669c.59-.459.885-.688 1.228-.688.343 0 .638.23 1.228.688l7.288 5.669c.21.163.316.245.4.204.084-.04.084-.174.084-.441v-.409c0-.48 0-.72-.102-.928-.101-.208-.291-.355-.67-.65l-7-5.445c-.59-.459-.885-.688-1.228-.688-.343 0-.638.23-1.228.688l-7 5.445c-.379.295-.569.442-.67.65-.102.208-.102.448-.102.928v.409Z" />
                                <path fill="currentColor" d="M11.5 15.5h1A1.5 1.5 0 0 1 14 17v3.5h-4V17a1.5 1.5 0 0 1 1.5-1.5Z" />
                                <path fill="currentColor" d="M17.5 5h-1a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5Z" />
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
                                        <?= htmlspecialchars($user['plan'] ?? 'Starter Plan') ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Close Button -->
                            <button @click="$store.global.isSidebarExpanded = false"
                                class="btn h-8 w-8 rounded-full p-0 text-slate-400 hover:bg-slate-200/60 hover:text-slate-700 focus:bg-slate-200/60 active:bg-slate-200/80 dark:text-navy-300 dark:hover:bg-navy-600/60 dark:hover:text-navy-50 dark:focus:bg-navy-600/60 dark:active:bg-navy-600/80 xl:hidden transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Sidebar Panel Body -->
                    <div x-data="{expandedItem:'menu-item-3'}" class="h-[calc(100%-8rem)] overflow-x-hidden pb-6" x-init="$el._x_simplebar = new SimpleBar($el);">
                        
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
                                    <a href="../api/logout_action.php"
                                        class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-all duration-200 ease-out hover:shadow-sm hover:scale-[1.02] text-slate-600 hover:text-error dark:text-navy-200 dark:hover:text-error hover:bg-error/10 dark:hover:bg-error/15">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-error/20 to-error/10 text-error dark:from-error/25 dark:to-error/10 transition-transform group-hover:scale-110">
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
