        <?php
        $isDashboard = basename($_SERVER['PHP_SELF']) === 'dashboard.php';
        ?>
        <nav class="header print:hidden">
            <!-- App Header  -->
            <div class="header-container relative flex w-full bg-white dark:bg-navy-750 print:hidden">
                <!-- Header Items -->
                <div class="flex w-full items-center justify-between">
                    <!-- Left: Sidebar Toggle & Back Button -->
                    <div class="flex items-center gap-2">
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
                        
                        <?php if (!$isDashboard): ?>
                        <a href="javascript:history.back()" class="btn h-8 w-8 rounded-full p-0 text-slate-500 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:text-navy-100 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" title="Go Back">
                            <i class="fa fa-arrow-left text-base"></i>
                        </a>
                        <?php endif; ?>
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
                                        <span x-show="currentCode === lang.code" class="translate-selected-indicator">✓</span>
                                    </button>
                                </template>
                                <div x-show="languages.length === 0" class="translate-option">
                                    <span>Loading languages...</span>
                                </div>
                            </div>
                            <div id="google_translate_element" aria-hidden="true"></div>
                        </div>

                        <!-- Claim Airdrop Button -->
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

                        <a href="kyc.php" class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition-colors hover:border-slate-300 hover:bg-slate-50 dark:border-navy-600 dark:bg-navy-700 dark:text-navy-100 dark:hover:bg-navy-600">
                            <?php if (($user['kyc_status'] ?? '') === 'verified'): ?>
                                <span class="inline-flex items-center gap-1.5 text-success">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Verified</span>
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 text-warning">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>Not Verified</span>
                                </span>
                            <?php endif; ?>
                        </a>
                        
                        <!-- Dark Mode Toggle -->
                        <button @click="$store.global.isDarkModeEnabled = !$store.global.isDarkModeEnabled"
                            class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                            <svg x-show="$store.global.isDarkModeEnabled" x-transition:enter="transition-transform duration-200 ease-out absolute origin-top" x-transition:enter-start="scale-75" x-transition:enter-end="scale-100 static" class="h-6 w-6 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.75 3.412a.818.818 0 01-.07.917 6.332 6.332 0 00-1.4 3.971c0 3.564 2.98 6.494 6.706 6.494a6.86 6.86 0 002.856-.617.818.818 0 011.1 1.047C19.593 18.614 16.218 21 12.283 21 7.18 21 3 16.973 3 11.956c0-4.563 3.46-8.31 7.925-8.948a.818.818 0 01.826.404z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" x-show="!$store.global.isDarkModeEnabled" x-transition:enter="transition-transform duration-200 ease-out absolute origin-top" x-transition:enter-start="scale-75" x-transition:enter-end="scale-100 static" class="h-6 w-6 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Notification-->
                        <div x-effect="if($store.global.isSearchbarActive) isShowPopper = false" x-data="usePopper({placement:'bottom-end',offset:12})" @click.outside="isShowPopper && (isShowPopper = false)" class="flex">
                            <button @click="isShowPopper = !isShowPopper" x-ref="popperRef" title="No new notifications" class="btn relative h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500 dark:text-navy-100" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.375 17.556h-6.75m6.75 0H21l-1.58-1.562a2.254 2.254 0 01-.67-1.596v-3.51a6.612 6.612 0 00-1.238-3.85 6.744 6.744 0 00-3.262-2.437v-.379c0-.59-.237-1.154-.659-1.571A2.265 2.265 0 0012 2c-.597 0-1.169.234-1.591.65a2.208 2.208 0 00-.659 1.572v.38c-2.621.915-4.5 3.385-4.5 6.287v3.51c0 .598-.24 1.172-.67 1.595L3 17.556h12.375zm0 0v1.11c0 .885-.356 1.733-.989 2.358A3.397 3.397 0 0112 22a3.397 3.397 0 01-2.386-.976 3.313 3.313 0 01-.989-2.357v-1.111h6.75z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
