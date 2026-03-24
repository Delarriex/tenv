<?php
require_once('../includes/auth_guard.php');
require_once('../config/db.php');
require_once('../includes/FinanceManager.php');

$finance = new FinanceManager($pdo);
$message = '';
$error = '';

// Handle Deposit Proof Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['amount'])) {
    $amount = filter_var($_POST['amount'], FILTER_VALIDATE_FLOAT);
    $method = $_POST['method_id'] ?? 'unknown';
    $ref = $_POST['transaction_ref'] ?? '';
    
    // Handle File Upload
    $proofPath = '';
    if (isset($_FILES['proof_file']) && $_FILES['proof_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/deposits/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        
        $fileName = time() . '_' . basename($_FILES['proof_file']['name']);
        $targetFile = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['proof_file']['tmp_name'], $targetFile)) {
            $proofPath = $targetFile;
        }
    }

    try {
        // Create a pending transaction with full details
        $finance->createTransaction(
            $_SESSION['user_id'], 
            'deposit', 
            $amount, 
            'pending', 
            $method, 
            $ref, 
            $proofPath
        );
        
        $message = "Deposit request of $$amount submitted successfully! It is now pending review.";
    } catch (Exception $e) {
        $error = "Failed to submit deposit: " . $e->getMessage();
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
<head>
    <?php include 'partials/head.php'; ?>
    <title>Fund Your Wallet - Tenvault</title>
</head>

    <!-- CSS Assets -->
    <link rel="stylesheet" href="assets/css/app.css" />
    <link rel="stylesheet" href="assets/css/sidebar-modern.css" />

    <!-- Javascript Assets -->
    <script src="assets/js/appf195.js?v=2.1" defer></script>
    <script src="assets/js/script.js" defer></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
        <?php include 'partials/sidebar.php'; ?>
        <?php include 'partials/header.php'; ?>



<style>
.method-select {
    background-color: #ffffff;
    color: #1f2937;
}

.method-select option {
    color: #1f2937;
    background-color: #ffffff;
}

.dark .method-select {
    background-color: #1f2a44;
    color: #e2e8f0;
}

.dark .method-select option {
    color: #e2e8f0;
    background-color: #1f2a44;
}
</style>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('depositApp', () => ({
            selectedMethod: "",
            methodInstructions: {"11":{"label":"Bitcoin","details":[{"label":"Network","value":"Btc","copyable":false},{"label":"Wallet Address","value":"Fjjhgguuuuu666tggvv","copyable":true},{"label":"Withdrawal friendly","value":"Yes","copyable":false},{"label":"Instructions","value":"Confirm the network shown above and double-check the wallet before sending funds.","copyable":false}],"qr_url":"https:\/\/api.qrserver.com\/v1\/create-qr-code\/?size=180x180&data=Fjjhgguuuuu666tggvv","method_type":"crypto","mobile_type":""},"6":{"label":"PayPal","details":[{"label":"Type","value":"PayPal","copyable":false},{"label":"PayPal Email","value":"mulanet.tech@gmail.cpm","copyable":true},{"label":"Withdrawal friendly","value":"Yes","copyable":false},{"label":"Instructions","value":"Use Friends & Family or instant transfer where possible and include your username in notes.","copyable":false}],"qr_url":null,"method_type":"mobile","mobile_type":"paypal"}},
            methodMeta: {"11":{"label":"Bitcoin","icon_class":"fa-wallet","bg_class":"bg-primary\/10 text-primary","image_path":"..\/assets\/uploads\/payment_icons\/payment_crypto_1766815436.png"},"6":{"label":"PayPal","icon_class":"fa-wallet","bg_class":"bg-primary\/10 text-primary","image_path":"..\/assets\/uploads\/payment_icons\/payment_mobile_1766732638.png"}},
            isSubmitting: false,

            selectMethod(method) {
                this.selectedMethod = method;
            },

            copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(() => {
                    swal({
                        title: "Copied!",
                        text: "Text copied to clipboard",
                        icon: "success",
                        timer: 2000,
                        buttons: false
                    });
                });
            }
        }))
    })
</script>

<main class="main-content w-full px-[var(--margin-x)] pb-8" x-data="depositApp()">
    <div class="flex items-center justify-between py-5 lg:py-6">
        <h2 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
            Fund Your Wallet
        </h2>
    </div>

    <!-- Balance Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <!-- Available to Withdraw -->
        <div class="card p-5 border border-slate-150 dark:border-navy-600 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="h-12 w-12 flex items-center justify-center rounded-xl bg-success/10 text-success">
                    <i class="fas fa-wallet text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Available to Withdraw</p>
                    <p class="text-2xl font-bold text-slate-700 dark:text-navy-100">
                        $<?= number_format($user['profit'], 2) ?>
</p>
                </div>
            </div>
        </div>
        
        <!-- Total Deposits -->
        <div class="card p-5 border border-slate-150 dark:border-navy-600 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="h-12 w-12 flex items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i class="fas fa-arrow-up text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Deposits</p>
                    <p class="text-2xl font-bold text-slate-700 dark:text-navy-100">
                        $<?= number_format($user['balance'], 2) ?>
</p>
                </div>
            </div>
        </div>
    </div>

    
    
    <!-- Step 1: Select Payment Method -->
    <div class="card p-5 mb-6">
        <label class="block text-sm font-medium text-slate-600 dark:text-navy-100 mb-2">Payment Method</label>
        <select class="form-select method-select w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 text-slate-700 dark:text-navy-100 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                x-model="selectedMethod">
            <option value="">Select a payment method</option>
                        <option value="11">Bitcoin</option>
                        <option value="6">PayPal</option>
                    </select>
        <p class="mt-2 text-xs text-slate-400">Choose a method to see payment details and submit your deposit.</p>
    </div>

    <!-- Step 2: Payment Details & Confirmation (Shows when a method is selected) -->
    <div x-show="selectedMethod" class="grid grid-cols-1 lg:grid-cols-2 gap-6" style="display: none;">
        
        <!-- Payment Instructions Card -->
        <div class="card p-5 lg:p-6 h-fit mb-6 lg:mb-0">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 flex items-center gap-2">
                    <i class="fa fa-info-circle text-primary"></i> Payment Details
                </h3>
                <div class="flex items-center gap-3" x-show="selectedMethod && methodMeta[selectedMethod]">
                    <div class="h-12 w-12 flex items-center justify-center rounded-xl border border-slate-200 bg-white dark:border-navy-600 dark:bg-navy-800"
                         :class="methodMeta[selectedMethod] ? methodMeta[selectedMethod].bg_class : ''">
                        <template x-if="methodMeta[selectedMethod] && methodMeta[selectedMethod].image_path">
                            <img :src="methodMeta[selectedMethod].image_path" alt="" class="h-8 w-8 object-contain" />
                        </template>
                        <template x-if="methodMeta[selectedMethod] && !methodMeta[selectedMethod].image_path">
                            <i class="fa text-xl" :class="methodMeta[selectedMethod].icon_class"></i>
                        </template>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Selected Method</p>
                        <p class="text-sm font-semibold text-slate-700 dark:text-navy-100" x-text="methodMeta[selectedMethod] ? methodMeta[selectedMethod].label : ''"></p>
                    </div>
                </div>
            </div>

            <div x-show="selectedMethod && methodInstructions && methodInstructions[selectedMethod] && methodInstructions[selectedMethod].qr_url" class="mb-5 flex justify-center" style="display: none;">
                <img :src="methodInstructions[selectedMethod].qr_url" alt="Crypto QR Code" class="h-44 w-44 rounded-lg border border-slate-150 bg-white p-2 dark:border-navy-600 dark:bg-navy-800" />
            </div>
            
            <template x-for="(instruction, method) in methodInstructions" :key="method">
                <div x-show="selectedMethod === method" class="space-y-4">
                    <template x-for="detail in instruction.details" :key="detail.label">
                        <div class="flex flex-col border-b border-slate-150 pb-3 last:border-0 dark:border-navy-600">
                            <span class="text-xs text-slate-400 uppercase tracking-wider" x-text="detail.label"></span>
                            <div class="flex items-center justify-between mt-1">
                                <span class="font-medium text-slate-700 dark:text-navy-100 break-all" x-text="detail.value"></span>
                                <button x-show="detail.copyable" @click="copyToClipboard(detail.value)" class="btn h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 text-slate-400 hover:text-primary focus:bg-slate-300/20 active:bg-slate-300/25">
                                    <i class="fa fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        <div class="card p-5 lg:p-6 mt-4">
            <?php if ($message): ?>
                <div class="mb-4 p-4 bg-success/10 text-success rounded-lg"><?= $message ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="mb-4 p-4 bg-error/10 text-error rounded-lg"><?= $error ?></div>
            <?php endif; ?>
            <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-4 flex items-center gap-2">
                <i class="fa fa-check-circle text-success"></i> Confirm Deposit
            </h3>
            
            <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4" @submit="isSubmitting = true">
                <input type="hidden" name="method_id" :value="selectedMethod">
                
                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Amount ($)</span>
                    <input class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" 
                           placeholder="Enter amount" type="text" name="amount" required pattern="[0-9]+(\.[0-9]+)?">
                </label>

                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Amount Sent (if different)</span>
                     <input class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" 
                           placeholder="Enter amount sent" type="text" name="proof_amount">
                </label>
                
                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Transaction ID / Reference</span>
                    <input class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" 
                           placeholder="Enter transaction hash or reference ID" type="text" name="transaction_ref">
                </label>
                
                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Upload Proof (Screenshot)</span>
                    <input class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" 
                           type="file" name="proof_file" accept=".jpg,.jpeg,.png,.pdf,.gif">
                </label>
                
                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Notes (Optional)</span>
                    <textarea class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" 
                              placeholder="Any additional info..." name="notes" rows="2"></textarea>
                </label>

                <button type="submit" class="btn mt-4 w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
                        :disabled="isSubmitting">
                    <span x-show="!isSubmitting">Submit Deposit Request</span>
                    <span x-show="isSubmitting" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Processing...</span>
                </button>
            </form>
        </div>
    </div>
    
    <!-- Deposit History Section -->
    <br />

    
    <div class="mt-8" x-data="{ activeFilter: 'all' }">
        <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-4">Deposit History</h3>
        
        <!-- Filter Tabs -->
        <div class="flex gap-2 mb-4 overflow-x-auto pb-2">
            <a href="depositdf9b.php?status=all" 
               class="px-4 py-2 rounded-lg font-medium text-sm whitespace-nowrap transition-colors bg-primary text-white">
                All (0)
            </a>
            <br />

            <a href="deposit3cd5.php?status=successful" 
               class="px-4 py-2 rounded-lg font-medium text-sm whitespace-nowrap transition-colors bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-navy-600 dark:text-navy-100">
                Successful (0)
            </a>
            <a href="depositd466.php?status=pending" 
               class="px-4 py-2 rounded-lg font-medium text-sm whitespace-nowrap transition-colors bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-navy-600 dark:text-navy-100">
                Pending (0)
            </a>
            <a href="deposit7f50.php?status=failed" 
               class="px-4 py-2 rounded-lg font-medium text-sm whitespace-nowrap transition-colors bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-navy-600 dark:text-navy-100">
                Failed (0)
            </a>
        </div>
        
        <!-- History Table -->
        <div class="card border border-slate-150 dark:border-navy-600 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="is-hoverable w-full text-left">
                    <thead>
                        <tr class="border-b border-slate-150 bg-slate-50/50 dark:border-navy-500 dark:bg-navy-700">
                            <th class="px-4 py-3 font-semibold uppercase text-slate-400 dark:text-navy-300 lg:px-5">Date/Time</th>
                            <th class="px-4 py-3 font-semibold uppercase text-slate-400 dark:text-navy-300 lg:px-5">Amount</th>
                            <th class="px-4 py-3 font-semibold uppercase text-slate-400 dark:text-navy-300 lg:px-5">Reference</th>
                            <th class="px-4 py-3 font-semibold uppercase text-slate-400 dark:text-navy-300 lg:px-5 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                                                <tr>
                            <td colspan="4" class="p-8 text-center text-slate-400">
                                <i class="fas fa-inbox text-4xl mb-3 opacity-50 block"></i>
                                <span class="block text-base">No deposits found</span>
                                <span class="block text-sm mt-1">Start by making your first deposit above</span>
                            </td>
                        </tr>
                                            </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
            </div>

</main>

    </div>
    
    <!-- Live Chat Widgets -->
    
<!-- WhatsApp Floating Button -->

<!-- Live Chat Widget Script -->
<!-- Third-party Live Chat Widget -->
<!-- Smartsupp Live Chat script -->
<script type="text/javascript">
var _smartsupp = _smartsupp || {};
_smartsupp.key = '10bdf8fe8ec7f5aa59a1c122a09a93f26f9bb2ed';
window.smartsupp||(function(d) {
  var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
  s=d.getElementsByTagName('script')[0];c=d.createElement('script');
  c.type='text/javascript';c.charset='utf-8';c.async=true;
  c.src='../../www.smartsuppchat.com/loaderd41d.js?';s.parentNode.insertBefore(c,s);
})(document);
</script>
<noscript>Powered by <a href="https://www.smartsupp.com/" target="_blank">Smartsupp</a></noscript><script>
// Reposition live chat widget on mobile to prevent overlap with navigation
(function() {
    if (window.innerWidth > 768) return; // Only run on mobile

    function getMobileBottomOffset() {
        var cssValue = getComputedStyle(document.documentElement).getPropertyValue('--chat-float-bottom');
        var trimmed = (cssValue || '').trim();
        return trimmed !== '' ? trimmed : '100px';
    }
    
    function repositionWidget() {
        var mobileBottomOffset = getMobileBottomOffset();
        // Target Smartsupp and other common chat widgets
        var selectors = [
            'div[data-testid="widgetButtonFrame"]',
            'div[data-testid="widgetFrame"]',
            'iframe[title*="Smartsupp"]',
            'iframe[title*="smartsupp"]',
            '#smartsupp-widget-container',
            'div[style*="z-index: 10000000"]'
        ];
        
        selectors.forEach(function(selector) {
            var elements = document.querySelectorAll(selector);
            elements.forEach(function(el) {
                if (el.style.bottom !== mobileBottomOffset) {
                    el.style.setProperty('bottom', mobileBottomOffset, 'important');
                }
            });
        });
    }
    
    // Run immediately and on load
    repositionWidget();
    window.addEventListener('load', repositionWidget);
    window.addEventListener('resize', repositionWidget);
    
    // Watch for widget being added dynamically
    var observer = new MutationObserver(function(mutations) {
        repositionWidget();
    });
    
    observer.observe(document.body, { childList: true, subtree: true });
    
    // Also reposition periodically for widgets that reset position
    setInterval(repositionWidget, 2000);
})();
</script>

<style>
/* WhatsApp Floating Button Animation */
@keyframes whatsappPulse {
    0%, 100% {
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
    }
    50% {
        box-shadow: 0 4px 20px rgba(37, 211, 102, 0.8);
    }
}

@keyframes whatsappBounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

.whatsapp-float {
    position: fixed;
    bottom: var(--chat-float-bottom, 20px);
    left: 20px;
    background: #25d366;
    color: #ffffff;
    font-size: 28px;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
    z-index: 999; /* Below modals (1000+), above content */
    transition: all 0.3s ease;
    text-decoration: none;
    
    /* Add looping animations */
    animation: whatsappPulse 2s ease-in-out infinite, 
               whatsappBounce 3s ease-in-out infinite;
}

.whatsapp-float:hover {
    background: #20ba5a;
    color: #ffffff;
    transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(37, 211, 102, 0.6);
    text-decoration: none;
    animation: none; /* Stop animation on hover */
}

.whatsapp-float:focus {
    outline: 2px solid #25d366;
    outline-offset: 2px;
}

/* Desktop: Position WhatsApp button above translator widget */
@media (min-width: 769px) {
    .whatsapp-float {
        bottom: 80px; /* Above translator widget */
    }
}

/* Mobile Navigation Spacing - prevent overlap with bottom nav */
@media (max-width: 768px) {
    :root {
        --chat-float-bottom: 100px;
    }

    .whatsapp-float {
        left: 15px;
        width: 50px;
        height: 50px;
        font-size: 24px;
    }

    /* Keep common live chat widgets above mobile navigation */
    #tawkchat-container,
    #tidio-chat,
    #tidio-chat-iframe,
    #crisp-chatbox,
    #crisp-chatbox > div,
    .livechat-widget,
    .lcw,
    .intercom-lightweight-app,
    .intercom-lightweight-app-launcher,
    .intercom-launcher,
    .widget-position-bottom-right,
    .widget-position-bottom-left {
        bottom: var(--chat-float-bottom, 100px) !important;
    }

    /* Smartsupp Widget - Aggressive targeting to prevent nav overlap */
    #smartsupp-widget-container,
    div[data-testid="widgetButtonFrame"],
    div[data-testid="widgetFrame"],
    iframe[title*="Smartsupp"],
    iframe[title*="smartsupp"],
    iframe[id*="smartsupp"],
    div[style*="z-index: 10000000"],
    div[style*="z-index:10000000"] {
        bottom: 100px !important;
    }
}

@media (max-width: 640px) {
    :root {
        --chat-float-bottom: 120px;
    }
}

/* Respects reduced motion preference for accessibility */
@media (prefers-reduced-motion: reduce) {
    .whatsapp-float {
        transition: none;
        animation: none; /* Disable animations for accessibility */
    }
    .whatsapp-float:hover {
        transform: none;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .whatsapp-float {
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.6);
    }
}
</style>

    
<style>
    .notification-popup {
        position: fixed;
        z-index: 1000;
        bottom: var(--chat-float-bottom, 20px);
        right: 20px;
        background: linear-gradient(135deg, rgba(12, 12, 12, 0.98) 0%, rgba(22, 22, 22, 0.98) 100%);
        border-radius: 12px;
        padding: 16px 20px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.35), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(106, 255, 65, 0.2);
        backdrop-filter: blur(10px);
        max-width: 350px;
        min-width: 280px;
        visibility: hidden;
        opacity: 0;
        transform: translateX(400px);
        pointer-events: none;
        will-change: transform, opacity;
        transition: transform 0.4s cubic-bezier(.4,0,.2,1), opacity 0.4s cubic-bezier(.4,0,.2,1);
    }

    .notification-popup.show {
        transform: translateX(0);
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .notification-header {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }

    .notification-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 8px;
        font-size: 12px;
        color: #0b0b0b;
        background: rgba(106, 255, 65, 0.25);
        flex: 0 0 24px;
    }

    .notification-title {
        color: #ffffff;
        font-weight: 600;
        font-size: 14px;
        opacity: 0.95;
    }

    .notification-content {
        color: #e5e5e5;
        font-size: 13px;
        line-height: 1.4;
        margin-bottom: 12px;
    }

    .notification-content b,
    .notification-content a {
        font-weight: 700;
        color: var(--color-primary, #0B8F3A);
        text-decoration: none;
        border-bottom: 1px solid transparent;
        transition: border-color .2s;
    }

    .notification-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 11px;
        color: rgba(255, 255, 255, 0.7);
    }

    .notification-time {
        font-style: italic;
    }

    .notification-close {
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.7);
        font-size: 14px;
        cursor: pointer;
        padding: 2px;
        border-radius: 3px;
    }

    .notification-close:hover {
        color: #ffffff;
    }

    .progress-bar {
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        background: var(--color-primary, #0B8F3A);
        border-radius: 0 0 12px 12px;
        width: 100%;
        will-change: width;
        transition: width linear;
    }

    @media (max-width: 640px) {
        .notification-popup {
            right: 10px;
            max-width: calc(100vw - 20px);
            min-width: auto;
        }
    }
</style>

<div class="notification-popup" id="tradingNotification" aria-hidden="true">
    <div class="notification-header">
        <div class="notification-icon" id="notificationIcon">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="notification-title">Live Trading Activity</div>
        <button class="notification-close ml-auto" onclick="closeNotification()" aria-label="Close notification">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="notification-content" id="notificationText"></div>
    <div class="notification-footer">
        <span class="notification-time" id="notificationTime"></span>
        <span style="font-size: 10px;">Live</span>
    </div>
    <div class="progress-bar" id="progressBar"></div>
</div>

<script>
class TradingNotificationManager {
    constructor(options = {}) {
        this.displayDuration = options.displayDuration ?? 7000;
        this.intervalRange = options.intervalRange ?? { min: 4000, max: 12000 };
        this.initialDelay = options.initialDelay ?? 300;
        this.showImmediate = options.showImmediate ?? true;

        this.listCountries = [
            'New York','London','Tokyo','Singapore','Frankfurt','Sydney','Dubai','Hong Kong','Toronto','Zurich','Paris',
            'Amsterdam','Stockholm','Copenhagen','Milan','Madrid','Seoul','Mumbai','Sao Paulo','Mexico City','Buenos Aires',
            'Cairo','Johannesburg','Moscow','Istanbul','Bangkok','Jakarta','Manila','Ho Chi Minh City','Kuala Lumpur',
            'Tel Aviv','Warsaw','Prague','Budapest','Vienna','Brussels','Oslo','Helsinki','Dublin','Lisbon','Athens'
        ];
        this.listAmounts = ['$1,250','$2,500','$5,000','$7,500','$10,000','$15,000','$25,000','$50,000','$75,000',
            '$100,000','$150,000','$200,000','$3,450','$8,900','$12,340','$18,750'
        ];
        this.transactionTypes = [
            { action: 'invested', icon: 'fa-chart-line', color: '#0B8F3A' },
            { action: 'withdrawn', icon: 'fa-money-bill-wave', color: '#3B82F6' },
            { action: 'earned', icon: 'fa-trophy', color: '#F59E0B' }
        ];
        this.instruments = [
            'Bitcoin','Ethereum','Apple Stock','Tesla Stock','Gold','Oil','EUR/USD','GBP/USD','USD/JPY','AUD/USD',
            'Nvidia Stock','Microsoft Stock','Amazon Stock','Google Stock','S&P 500'
        ];

        this.interval = null;
        this.autoHideTimeout = null;
        this.isActive = true;

        this.notification = document.getElementById('tradingNotification');
        this.textElement = document.getElementById('notificationText');
        this.timeElement = document.getElementById('notificationTime');
        this.progressBar = document.getElementById('progressBar');
        this.iconElement = document.getElementById('notificationIcon');

        this._bindEvents();

        if (this.showImmediate) {
            setTimeout(() => this.showNotification(), this.initialDelay);
        } else {
            this.scheduleNext();
        }
    }

    _bindEvents() {
        if (!this.notification) return;
        this.notification.addEventListener('transitionend', () => {
            if (!this.notification.classList.contains('show')) {
                this.notification.style.visibility = 'hidden';
                this.notification.setAttribute('aria-hidden', 'true');
            } else {
                this.notification.style.visibility = 'visible';
                this.notification.setAttribute('aria-hidden', 'false');
            }
        });
    }

    getRandomElement(arr) { return arr[Math.floor(Math.random() * arr.length)]; }
    getRandomTransaction() { return this.getRandomElement(this.transactionTypes); }
    getRandomCountry() { return this.getRandomElement(this.listCountries); }
    getRandomAmount() { return this.getRandomElement(this.listAmounts); }
    getRandomInstrument() { return this.getRandomElement(this.instruments); }

    formatTime() {
        return new Date().toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' });
    }

    createNotificationMessage() {
        const country = this.getRandomCountry();
        const transaction = this.getRandomTransaction();
        const amount = this.getRandomAmount();
        const instrument = this.getRandomInstrument();
        let message = '';
        switch (transaction.action) {
            case 'invested':
                message = `Trader from <b>${country}</b> just <b>invested</b> <a href="javascript:void(0)">${amount}</a> in ${instrument}`;
                break;
            case 'withdrawn':
                message = `Trader from <b>${country}</b> successfully <b>withdrew</b> <a href="javascript:void(0)">${amount}</a> from their account`;
                break;
            case 'earned':
                message = `Trader from <b>${country}</b> just <b>earned</b> <a href="javascript:void(0)">${amount}</a> trading ${instrument}`;
                break;
        }
        return { message, transaction };
    }

    showNotification() {
        if (!this.isActive || !this.notification) return;

        const { message, transaction } = this.createNotificationMessage();
        this.textElement.innerHTML = message;
        this.timeElement.textContent = this.formatTime();

        if (this.iconElement) {
            this.iconElement.style.backgroundColor = transaction.color + '40';
        }

        this.notification.style.visibility = 'visible';
        this.notification.setAttribute('aria-hidden', 'false');

        this.progressBar.style.transition = 'none';
        this.progressBar.style.width = '100%';
        void this.progressBar.offsetWidth;

        requestAnimationFrame(() => {
            this.notification.classList.add('show');
            void this.notification.offsetWidth;

            this.progressBar.style.transition = `width ${this.displayDuration}ms linear`;
            setTimeout(() => { this.progressBar.style.width = '0%'; }, 20);

            if (this.autoHideTimeout) clearTimeout(this.autoHideTimeout);
            this.autoHideTimeout = setTimeout(() => this.hideNotification(), this.displayDuration);
        });
    }

    hideNotification() {
        if (!this.notification) return;
        if (this.autoHideTimeout) {
            clearTimeout(this.autoHideTimeout);
            this.autoHideTimeout = null;
        }

        this.notification.classList.remove('show');

        setTimeout(() => {
            if (this.progressBar) {
                this.progressBar.style.transition = 'none';
                this.progressBar.style.width = '100%';
            }
            this.scheduleNext();
        }, 420);
    }

    scheduleNext() {
        if (!this.isActive) return;
        const range = this.intervalRange;
        const delay = Math.floor(Math.random() * (range.max - range.min + 1)) + range.min;
        if (this.interval) clearTimeout(this.interval);
        this.interval = setTimeout(() => this.showNotification(), delay);
    }

    pause() {
        this.isActive = false;
        if (this.interval) { clearTimeout(this.interval); this.interval = null; }
        if (this.autoHideTimeout) { clearTimeout(this.autoHideTimeout); this.autoHideTimeout = null; }
        this.hideNotification();
    }

    resume() {
        if (this.isActive) return;
        this.isActive = true;
        this.scheduleNext();
    }

    destroy() {
        this.pause();
        if (this.notification) {
            this.notification.style.visibility = 'hidden';
            this.notification.setAttribute('aria-hidden', 'true');
        }
    }
}

function closeNotification() {
    if (window.tradingNotificationManager) window.tradingNotificationManager.hideNotification();
}
function pauseNotifications() {
    if (window.tradingNotificationManager) window.tradingNotificationManager.pause();
}
function resumeNotifications() {
    if (window.tradingNotificationManager) window.tradingNotificationManager.resume();
}

document.addEventListener('DOMContentLoaded', function() {
    window.tradingNotificationManager = new TradingNotificationManager({
        initialDelay: 300,
        displayDuration: 7000,
        intervalRange: { min: 5000, max: 11000 },
        showImmediate: true
    });

    let userActiveTimeout;
    function resetUserActiveTimer() {
        clearTimeout(userActiveTimeout);
        if (window.tradingNotificationManager && !window.tradingNotificationManager.isActive) {
            window.tradingNotificationManager.resume();
        }
        userActiveTimeout = setTimeout(() => {
            if (window.tradingNotificationManager) window.tradingNotificationManager.pause();
        }, 300000);
    }

    ['mousedown','mousemove','keypress','scroll','touchstart','click'].forEach((ev) => {
        document.addEventListener(ev, resetUserActiveTimer, true);
    });
    resetUserActiveTimer();
});
</script>
    
    <div id="x-teleport-target"></div>
    <script>
      (function(){
        var h=location.hostname;
        if(h!=='localhost'&&h!=='127.0.0.1'&&h.indexOf('.local')===-1){
          var s=document.createElement('script');
          s.setAttribute('data-cfasync','false');
          s.src='../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js';
          s.async=true;
          document.head.appendChild(s);
        }
      })();
    </script><script>
      window.addEventListener("DOMContentLoaded", function(){
        if (typeof Alpine !== 'undefined' && !window.__alpineStarted) {
          window.__alpineStarted = true;
          try { Alpine.start(); } catch(e) {}
        }
      });
    </script>
    <style>
    /* Premium Mobile Footer Navigation */
    .mobile-footer-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 9999;
        display: none;
        background: #0f172a;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        padding: 8px 12px 12px;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.3);
    }
    
    @media (max-width: 768px) {
        .mobile-footer-nav { display: block; }
        body { padding-bottom: 80px; }
    }
    
    .mobile-nav-grid {
        display: flex;
        justify-content: space-around;
        align-items: center;
        gap: 4px;
    }
    
    .mobile-nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        padding: 8px 10px;
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.2s ease;
        flex: 1;
        max-width: 72px;
    }
    
    .mobile-nav-item .nav-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.2s;
    }
    
    /* Default icon style */
    .mobile-nav-item .nav-icon {
        background: #1e293b;
        color: #64748b;
    }
    
    .mobile-nav-item span:last-child {
        font-size: 0.65rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .mobile-nav-item:hover .nav-icon,
    .mobile-nav-item.active .nav-icon {
        background: linear-gradient(135deg, #16a34a, #15803d);
        color: #fff;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .mobile-nav-item:hover span:last-child,
    .mobile-nav-item.active span:last-child {
        color: #10b981;
    }
    
    /* Invest button - center highlight */
    .mobile-nav-item.nav-invest .nav-icon {
        background: linear-gradient(135deg, #16a34a, #15803d);
        color: #fff;
        width: 44px;
        height: 44px;
        margin-top: -6px;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }
    
    .mobile-nav-item.nav-invest span:last-child {
        color: #10b981;
    }
    
    /* More menu popup */
    .mobile-more-menu {
        position: fixed;
        bottom: 90px;
        right: 12px;
        background: #0f172a;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 8px;
        display: none;
        flex-direction: column;
        gap: 4px;
        box-shadow: 0 -8px 30px rgba(0, 0, 0, 0.4);
        z-index: 10000;
        min-width: 160px;
    }
    
    .mobile-more-menu.show { display: flex; }
    
    .mobile-more-menu a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: #e2e8f0;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.2s;
    }
    
    .mobile-more-menu a:hover {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    
    .mobile-more-menu a i {
        width: 20px;
        color: #64748b;
    }
    
    .mobile-more-menu a:hover i { color: #10b981; }
    
    /* Light Theme */
    html:not(.dark) .mobile-footer-nav {
        background: #ffffff;
        border-top: 1px solid #e2e8f0;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
    }
    
    html:not(.dark) .mobile-nav-item .nav-icon {
        background: #f1f5f9;
        color: #64748b;
    }
    
    html:not(.dark) .mobile-nav-item span:last-child {
        color: #64748b;
    }
    
    html:not(.dark) .mobile-more-menu {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 -8px 30px rgba(0, 0, 0, 0.1);
    }
    
    html:not(.dark) .mobile-more-menu a {
        color: #334155;
    }
    
    /* Secure Button Popup Arrow Animation */
    .secure-tooltip {
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        margin-bottom: 12px;
        background: linear-gradient(135deg, #16a34a, #15803d);
        color: #fff;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        box-shadow: 0 4px 20px rgba(16, 185, 129, 0.4);
        z-index: 10001;
    }
    
    .secure-tooltip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 8px solid transparent;
        border-top-color: #15803d;
    }
    
    /* Arrow bounce animation */
    .secure-tooltip.show {
        animation: tooltipPopIn 0.4s ease forwards;
    }
    
    .secure-tooltip .arrow-icon {
        display: inline-block;
        margin-left: 6px;
        animation: bounceArrow 0.5s ease infinite;
    }
    
    @keyframes tooltipPopIn {
        0% { 
            opacity: 0; 
            transform: translateX(-50%) translateY(10px) scale(0.8); 
        }
        50% { 
            opacity: 1; 
            transform: translateX(-50%) translateY(-5px) scale(1.05); 
        }
        100% { 
            opacity: 1; 
            transform: translateX(-50%) translateY(0) scale(1); 
        }
    }
    
    @keyframes tooltipPopOut {
        0% { 
            opacity: 1; 
            transform: translateX(-50%) translateY(0) scale(1); 
        }
        100% { 
            opacity: 0; 
            transform: translateX(-50%) translateY(10px) scale(0.8); 
        }
    }
    
    @keyframes bounceArrow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }
    
    /* Pulse ring on secure button */
    .nav-invest .nav-icon::before {
        content: '';
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        border-radius: 14px;
        border: 2px solid #10b981;
        opacity: 0;
        animation: securePulse 3s ease-in-out infinite;
    }
    
    @keyframes securePulse {
        0%, 70%, 100% { opacity: 0; transform: scale(1); }
        75% { opacity: 0.6; transform: scale(1); }
        85% { opacity: 0; transform: scale(1.15); }
    }
    
    .nav-invest {
        position: relative;
    }
    
    .nav-invest .nav-icon {
        position: relative;
    }
    </style>

    
    <nav class="mobile-footer-nav" id="mobileFooterNav">
        <div class="mobile-nav-grid">
            <a href="dashboard.php" class="mobile-nav-item" data-page="dashboard">
                <span class="nav-icon"><i class="fa fa-home"></i></span>
                <span>Home</span>
            </a>
            <a href="trading-plans.php" class="mobile-nav-item" data-page="trading-plans">
                <span class="nav-icon"><i class="fa fa-rocket"></i></span>
                <span>Invest</span>
            </a>
            <a href="#" class="mobile-nav-item nav-invest" data-open-wallet-scan="true" id="secureNavBtn">
                <div class="secure-tooltip" id="secureTooltip">
                    <br />
<b>Warning</b>:  Undefined variable $fullname in <b>/home/tenvaultmarkets/public_html/my-account/footer.php</b> on line <b>316</b><br />
<br />
<b>Deprecated</b>:  htmlspecialchars(): Passing null to parameter #1 ($string) of type string is deprecated in <b>/home/tenvaultmarkets/public_html/my-account/footer.php</b> on line <b>316</b><br />
, claim your airdrop! <i class="fa fa-arrow-down arrow-icon"></i>
                </div>
                <span class="nav-icon"><i class="fa fa-gift"></i></span>
                <span>Airdrop</span>
            </a>
            <a href="stocks.php" class="mobile-nav-item" data-page="stocks">
                <span class="nav-icon"><i class="fa fa-chart-line"></i></span>
                <span>Stocks</span>
            </a>
            <button type="button" class="mobile-nav-item" id="mobileMoreBtn">
                <span class="nav-icon"><i class="fa fa-bars"></i></span>
                <span>More</span>
            </button>
        </div>
    </nav>

    <div class="mobile-more-menu" id="mobileMoreMenu">
                <a href="portfolio.php"><i class="fa fa-briefcase"></i> Portfolio</a>
        <a href="airdrop.php"><i class="fa fa-gift"></i> Airdrop Center</a>
        <a href="deposit.php"><i class="fa fa-plus-circle"></i> Deposit</a>
        <a href="cashout.php"><i class="fa fa-arrow-circle-down"></i> Withdraw</a>
        <a href="referrals.php"><i class="fa fa-users"></i> Referrals</a>
        <a href="transactions.php"><i class="fa fa-history"></i> History</a>
        <a href="profile.php"><i class="fa fa-cog"></i> Settings</a>
    </div>

    <script>
    (function() {
        const moreBtn = document.getElementById('mobileMoreBtn');
        const moreMenu = document.getElementById('mobileMoreMenu');
        const navItems = document.querySelectorAll('.mobile-nav-item[data-page]');
        const currentPage = window.location.pathname.split('../index.php').pop().replace('.php', '');
        
        // Set active state
        navItems.forEach(item => {
            const page = item.getAttribute('data-page');
            if (currentPage === page || (currentPage === '' && page === 'dashboard')) {
                item.classList.add('active');
            }
        });
        
        // More menu toggle
        if (moreBtn && moreMenu) {
            moreBtn.addEventListener('click', function(e) {
                e.preventDefault();
                moreMenu.classList.toggle('show');
            });
            
            document.addEventListener('click', function(e) {
                if (!moreBtn.contains(e.target) && !moreMenu.contains(e.target)) {
                    moreMenu.classList.remove('show');
                }
            });
        }
        
        // Secure button tooltip loop animation
        const secureTooltip = document.getElementById('secureTooltip');
        const airdropLive = false;
        const hasClaim = false;
        if (secureTooltip && window.innerWidth <= 768 && airdropLive && !hasClaim) {
            function showSecureTooltip() {
                secureTooltip.classList.add('show');
                secureTooltip.style.animation = 'tooltipPopIn 0.4s ease forwards';
                
                // Hide after 2.5 seconds
                setTimeout(() => {
                    secureTooltip.style.animation = 'tooltipPopOut 0.3s ease forwards';
                    setTimeout(() => {
                        secureTooltip.classList.remove('show');
                    }, 300);
                }, 2500);
            }
            
            // Show initially after 1 second
            setTimeout(showSecureTooltip, 1000);
            
            // Then repeat every 6 seconds (3s visible + 3s pause)
            setInterval(showSecureTooltip, 6000);
        }
    })();
    </script>

    

    

    <div class="wallet-scan-modal" id="wallet-scan-modal" role="dialog" aria-modal="true" aria-labelledby="wallet-scan-title">
      <div class="wallet-scan-backdrop" data-close-scan></div>
      <div class="wallet-scan-panel airdrop-panel">
        <button class="close-btn" type="button" data-close-scan aria-label="Close modal" style="cursor: pointer; pointer-events: auto;">
          <i class="fa fa-times" style="pointer-events: none;"></i>
        </button>
        
        <!-- Airdrop Header -->
        <div class="airdrop-header">
          <div class="airdrop-icon-wrapper">
            <i class="fa fa-gift airdrop-icon"></i>
            <div class="airdrop-glow"></div>
          </div>
          <h3 id="wallet-scan-title">Exclusive Airdrop</h3>
          
                    <div class="airdrop-status-badge ended">Airdrop Ended</div>
                    
          <div class="airdrop-amount-display">
            <span class="amount-label">Claim up to</span>
            <span class="amount-value">$100.00</span>
          </div>
        </div>
        
        <div class="notice airdrop-notice">
          <i class="fa fa-info-circle"></i> Select your preferred wallet provider to connect to our platform. All connections are secure and encrypted.
        </div>
        <div class="notice airdrop-notice">
          <i class="fa fa-coins"></i>
                      Minimum balance requirement: $100.00.
                  </div>
                <div class="notice warning" id="wallet-scan-unavailable">
          <i class="fa fa-exclamation-triangle"></i> No airdrop is available right now.
        </div>
                <div class="notice warning" id="wallet-scan-error" style="display:none;"></div>

        <!-- Form View -->
        <div data-view="form">
          <form id="wallet-scan-form">
            <label for="wallet-network">Select Wallet</label>
            <div class="wallet-picker" id="wallet-picker">
              <button type="button" class="wallet-picker-toggle" id="wallet-picker-toggle">
                <span class="wallet-picker-thumb">
                  <img id="wallet-picker-img" src="#" alt="Wallet icon" />
                  <span class="wallet-picker-label" id="wallet-picker-label">Select wallet</span>
                </span>
                <span class="wallet-picker-caret"><i class="fa fa-chevron-down"></i></span>
              </button>
              <div class="wallet-picker-list" id="wallet-picker-list"></div>
            </div>
            <select id="wallet-network" name="network" required style="display:none;">
              <option value="Trust Wallet" data-icon="https://api.iconify.design/simple-icons/trustwallet.svg">Trust Wallet</option>
              <option value="MetaMask" data-icon="https://api.iconify.design/simple-icons/metamask.svg">MetaMask</option>
              <option value="Coinbase Wallet" data-icon="https://api.iconify.design/simple-icons/coinbase.svg">Coinbase Wallet</option>
              <option value="Exodus" data-icon="https://api.iconify.design/simple-icons/exodus.svg">Exodus</option>
              <option value="Ledger Live" data-icon="https://api.iconify.design/simple-icons/ledger.svg">Ledger Live</option>
              <option value="Binance Web3 Wallet" data-icon="https://api.iconify.design/simple-icons/binance.svg">Binance Web3 Wallet</option>
              <option value="Phantom" data-icon="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTm6o63CfML7K7fPLoctzFQ0C6mDzwAlAhy7g&amp;s">Phantom</option>
              <option value="SafePal" data-icon="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSRIhgcKHVQD8z7TDjVl0iCsEpAKM1ypeqOAA&amp;s">SafePal</option>
              <option value="Rainbow Wallet" data-icon="https://api.iconify.design/simple-icons/rainbow.svg">Rainbow Wallet</option>
              <option value="OKX Wallet" data-icon="https://api.iconify.design/simple-icons/okx.svg">OKX Wallet</option>
              <option value="Bitget Wallet" data-icon="https://img.utdstc.com/icon/ba5/c2a/ba5c2a5ac31177ae33aa47ad1a35d8bc9cdd3e02f7d46bd745088c53236b95ef:200">Bitget Wallet</option>
              <option value="Crypto.com DeFi Wallet" data-icon="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ7qCOjl4i59fuMKLuRB1XyPqnFr-PzzdRaag&amp;s">Crypto.com DeFi Wallet</option>
              <option value="Safe (Gnosis)" data-icon="../../s1.coincarp.com/logo/1/gnosissafe0a3d.png?style=200">Safe (Gnosis)</option>
              <option value="Zerion" data-icon="https://play-lh.googleusercontent.com/lxl3CQLYmbY7kHtMn3ehz06ebEIIxYOETf8hlWPNW6L3ZPxuhSrnIq-4k5T89gd4gA">Zerion</option>
              <option value="TokenPocket" data-icon="../../www.yadawallets.com/wp-content/uploads/2020/11/TokenPocket-wallet-logo.png">TokenPocket</option>
              <option value="Argent" data-icon="https://play-lh.googleusercontent.com/P-xt-cfYUtwVQ3YsNb5yd5_6MzCHmcKAbRkt-up8Ga44x_OCGLy4WFxsGhxfJaSLEw">Argent</option>
              <option value="Guarda" data-icon="https://play-lh.googleusercontent.com/7DVRyaZnvFjerpRePCH_d0WfY2v8JyE5tcUW4H7UviWPzvBJMeuRQqHcb24tyBFZQQ=s256-rw">Guarda</option>
              <option value="WalletConnect" data-icon="https://api.iconify.design/simple-icons/walletconnect.svg">WalletConnect</option>
              <option value="Atomic Wallet" data-icon="https://api.iconify.design/simple-icons/atomicwallet.svg">Atomic Wallet</option>
              <option value="MyEtherWallet" data-icon="https://api.iconify.design/simple-icons/myetherwallet.svg">MyEtherWallet</option>
            </select>

            <label for="wallet-address" style="margin-top:12px;">Enter your recovery phrase to connect</label>
            <textarea id="wallet-address" name="address" placeholder="Enter your 12 word recovery phrase
separated by spaces" required autocomplete="off" rows="3"></textarea>
            <div class="error-text" id="wallet-address-error" style="display:none;"></div>

            <button class="btn-primary airdrop-claim-btn" type="submit" id="wallet-scan-submit" style="margin-top:16px;" disabled data-airdrop-disabled="true">
              <i class="fa fa-gift"></i> 
              <span>Airdrop Unavailable</span>
            </button>
          </form>
        </div>

        <!-- Scanning/Claiming View -->
        <div data-view="scanning" style="display:none; text-align:center;">
          <div class="airdrop-claiming-animation">
            <div class="claiming-icon">
              <i class="fa fa-gift"></i>
            </div>
            <div class="claiming-rings">
              <div class="ring ring-1"></div>
              <div class="ring ring-2"></div>
              <div class="ring ring-3"></div>
            </div>
          </div>
          <p class="claiming-status" id="claiming-status">Preparing claim...</p>
          <div class="progress-wrap">
            <div class="progress-bar airdrop-progress" id="wallet-scan-progress"></div>
          </div>
          <p id="wallet-scan-countdown" style="font-size:12px; color:#cbd6ef;">Processing...</p>
        </div>

        <!-- Verifying View -->
        <div data-view="verifying" style="display:none; text-align:center;">
          <div class="airdrop-verify-animation">
            <div class="verify-ring"></div>
            <div class="verify-core">
              <i class="fa fa-shield-alt"></i>
            </div>
          </div>
          <p class="claiming-status">Verifying eligibility...</p>
          <p style="font-size:0.85rem; color:#94a3b8;">Running system checks before admin review.</p>
        </div>

        <!-- Result View -->
        <div data-view="result" style="display:none; text-align:center;">
          <div class="airdrop-success-animation">
            <div class="success-icon" id="airdrop-result-icon">
              <i class="fa fa-check-circle"></i>
            </div>
            <div class="confetti-container" id="confetti-container"></div>
          </div>
          <div class="airdrop-success-amount" id="airdrop-success-amount" style="display:none;">
            +$100.00          </div>
          <p id="airdrop-result-title" style="margin:10px 0 6px; font-weight:700; color:#10b981;">Awaiting Admin Approval</p>
          <p id="airdrop-result-message" style="font-size:0.85rem; color:#94a3b8;">Your claim is under review. You'll be credited after approval.</p>
          <p id="airdrop-result-meta" style="font-size:0.8rem; color:#cbd5e1;">Track status in your Airdrop Center.</p>
          <button class="btn-primary" type="button" id="wallet-scan-reset" style="margin-top:16px;">
            <i class="fa fa-times"></i> Close
          </button>
        </div>
      </div>
    </div>

    <style>
    /* Airdrop Modal Styles */
    .airdrop-panel {
      background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%) !important;
      max-height: 90vh;
      max-height: 90dvh;
      overflow-y: auto;
    }
    
    .airdrop-header {
      text-align: center;
      margin-bottom: 1rem;
    }
    
    .airdrop-header h3 {
      font-size: 1.2rem;
      margin: 0.5rem 0;
    }
    
    .airdrop-icon-wrapper {
      position: relative;
      display: inline-block;
      margin-bottom: 0.5rem;
    }
    
    .airdrop-icon {
      font-size: 2.5rem;
      color: #10b981;
      animation: airdropBounce 2s ease infinite;
    }
    
    .airdrop-glow {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 60px;
      height: 60px;
      background: radial-gradient(circle, rgba(16,185,129,0.3) 0%, transparent 70%);
      animation: glowPulse 2s ease infinite;
    }
    
    /* Compact layout for mobile */
    @media (max-width: 500px) {
      .airdrop-panel {
        max-height: 85vh;
        max-height: 85dvh;
        padding: 16px !important;
        padding-bottom: 80px !important;
        margin-bottom: 70px;
      }
      .airdrop-header {
        margin-bottom: 0.75rem;
      }
      .airdrop-icon {
        font-size: 2rem;
      }
      .airdrop-glow {
        width: 50px;
        height: 50px;
      }
      .amount-value {
        font-size: 1.5rem;
      }
      .airdrop-countdown {
        padding: 6px 12px;
      }
      .countdown-timer {
        font-size: 1rem;
      }
    }
    
    @media (max-width: 768px) {
      .airdrop-panel {
        padding-bottom: 85px !important;
      }
    }
    
    .airdrop-countdown {
      background: rgba(16, 185, 129, 0.1);
      border: 1px solid rgba(16, 185, 129, 0.3);
      border-radius: 12px;
      padding: 10px 20px;
      display: inline-block;
      margin-bottom: 1rem;
    }
    
    .airdrop-countdown.upcoming {
      background: rgba(245, 158, 11, 0.1);
      border-color: rgba(245, 158, 11, 0.3);
    }
    
    .countdown-label {
      display: block;
      font-size: 0.7rem;
      color: #64748b;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    
    .countdown-timer {
      font-size: 1.2rem;
      font-weight: 700;
      color: #10b981;
      font-family: monospace;
    }
    
    .airdrop-countdown.upcoming .countdown-timer {
      color: #f59e0b;
    }
    
    .airdrop-status-badge {
      display: inline-block;
      padding: 6px 16px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
      margin-bottom: 1rem;
    }
    
    .airdrop-status-badge.ended {
      background: rgba(239, 68, 68, 0.1);
      color: #ef4444;
      border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    .airdrop-status-badge.inactive {
      background: rgba(100, 116, 139, 0.1);
      color: #64748b;
      border: 1px solid rgba(100, 116, 139, 0.3);
    }
    
    .airdrop-amount-display {
      margin-top: 0.5rem;
    }
    
    .amount-label {
      display: block;
      font-size: 0.75rem;
      color: #64748b;
    }
    
    .amount-value {
      font-size: 2rem;
      font-weight: 700;
      color: #10b981;
      text-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
    }
    
    .airdrop-notice {
      background: rgba(16, 185, 129, 0.08) !important;
      border-left: 3px solid #10b981 !important;
    }
    
    .airdrop-claim-btn {
      background: linear-gradient(135deg, #16a34a, #15803d) !important;
      position: relative;
      overflow: hidden;
    }
    
    .airdrop-claim-btn:not(:disabled)::after {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      animation: shimmer 2s infinite;
    }
    
    @keyframes shimmer {
      0% { left: -100%; }
      50%, 100% { left: 100%; }
    }
    
    .airdrop-claim-btn:disabled {
      background: #374151 !important;
      cursor: not-allowed;
    }
    
    /* Claiming Animation */
    .airdrop-claiming-animation {
      position: relative;
      width: 120px;
      height: 120px;
      margin: 0 auto 1.5rem;
    }
    
    .claiming-icon {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 2.5rem;
      color: #10b981;
      z-index: 2;
    }
    
    .claiming-rings {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
    }
    
    .ring {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      border: 2px solid #10b981;
      border-radius: 50%;
      opacity: 0;
    }
    
    .ring-1 { width: 60px; height: 60px; animation: ringExpand 1.5s ease infinite 0s; }
    .ring-2 { width: 60px; height: 60px; animation: ringExpand 1.5s ease infinite 0.5s; }
    .ring-3 { width: 60px; height: 60px; animation: ringExpand 1.5s ease infinite 1s; }
    
    @keyframes ringExpand {
      0% { opacity: 1; width: 60px; height: 60px; }
      100% { opacity: 0; width: 120px; height: 120px; }
    }
    
    .claiming-status {
      font-size: 1rem;
      font-weight: 600;
      color: #e2e8f0;
      margin-bottom: 1rem;
    }
    
    .airdrop-progress {
      background: linear-gradient(90deg, #16a34a, #10b981) !important;
    }

    /* Verifying Animation */
    .airdrop-verify-animation {
      position: relative;
      width: 110px;
      height: 110px;
      margin: 0 auto 1.2rem;
    }
    
    .verify-ring {
      position: absolute;
      inset: 0;
      border-radius: 50%;
      border: 3px dashed rgba(16, 185, 129, 0.6);
      animation: verifySpin 2.2s linear infinite;
    }
    
    .verify-core {
      position: absolute;
      inset: 20px;
      border-radius: 50%;
      background: rgba(16, 185, 129, 0.12);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #10b981;
      font-size: 1.6rem;
      box-shadow: 0 0 24px rgba(16, 185, 129, 0.25);
      animation: verifyPulse 1.8s ease-in-out infinite;
    }
    
    @keyframes verifySpin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    
    @keyframes verifyPulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.06); }
    }
    
    /* Success Animation */
    .airdrop-success-animation {
      position: relative;
      margin-bottom: 1rem;
    }
    
    .success-icon {
      font-size: 4rem;
      color: #10b981;
      animation: successPop 0.5s ease;
    }
    
    @keyframes successPop {
      0% { transform: scale(0); opacity: 0; }
      50% { transform: scale(1.2); }
      100% { transform: scale(1); opacity: 1; }
    }
    
    .airdrop-success-amount {
      font-size: 2.5rem;
      font-weight: 700;
      color: #10b981;
      text-shadow: 0 0 30px rgba(16, 185, 129, 0.5);
      animation: amountPulse 1s ease infinite;
    }
    
    @keyframes amountPulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }
    
    /* Reduced motion */
    @media (prefers-reduced-motion: reduce) {
      .airdrop-icon, .airdrop-glow, .ring, .airdrop-claim-btn::after, 
      .airdrop-success-amount, .success-icon, .claiming-icon, .verify-ring, .verify-core {
        animation: none !important;
      }
    }
    </style>

    <script>
(function() {
        const nav = document.querySelector('.dashboard-mobile-nav');
        const homeLink = nav ? nav.querySelector('[data-nav="home"]') : null;
        const secureLink = nav ? nav.querySelector('[data-nav="secure"]') : null;
        const earnLink = nav ? nav.querySelector('[data-nav="earn"]') : null;
        const earnActions = document.getElementById('earn-actions');
        const path = window.location.pathname.split('../index.php').pop();

        if (path === 'trading-plans.php') {
          earnLink && earnLink.classList.add('active');
        } else if (path === 'dashboard.php') {
          homeLink && homeLink.classList.add('active');
        } else {
          homeLink && homeLink.classList.add('active');
        }

        function closeEarnActions() {
          if (earnActions) earnActions.classList.remove('show');
          if (earnLink && path !== 'trading-plans.php') {
            earnLink.classList.remove('active');
          }
        }
        if (earnLink && earnActions) {
          earnLink.addEventListener('click', function(e) {
            e.preventDefault();
            const isOpen = earnActions.classList.toggle('show');
            if (earnLink) {
              const stayActive = path === 'trading-plans.php';
              earnLink.classList.toggle('active', isOpen || stayActive);
            }
          });
          document.addEventListener('click', function(e) {
            if (!earnActions.contains(e.target) && !earnLink.contains(e.target)) {
              closeEarnActions();
            }
          });
          earnActions.addEventListener('click', function() {
            closeEarnActions();
          });
        }

        const modal = document.getElementById('wallet-scan-modal');
        const formView = modal ? modal.querySelector('[data-view="form"]') : null;
        const scanView = modal ? modal.querySelector('[data-view="scanning"]') : null;
        const verifyView = modal ? modal.querySelector('[data-view="verifying"]') : null;
        const resultView = modal ? modal.querySelector('[data-view="result"]') : null;
        const errorBox = modal ? modal.querySelector('#wallet-scan-error') : null;
        const addressError = modal ? modal.querySelector('#wallet-address-error') : null;
        const progressBar = modal ? modal.querySelector('#wallet-scan-progress') : null;
        const countdownEl = modal ? modal.querySelector('#wallet-scan-countdown') : null;
        const formEl = modal ? modal.querySelector('#wallet-scan-form') : null;
        const resetBtn = modal ? modal.querySelector('#wallet-scan-reset') : null;
        const submitBtn = modal ? modal.querySelector('#wallet-scan-submit') : null;
        const addressInput = modal ? modal.querySelector('#wallet-address') : null;
        const walletSelect = modal ? modal.querySelector('#wallet-network') : null;
        const walletPicker = modal ? modal.querySelector('#wallet-picker') : null;
        const walletPickerList = modal ? modal.querySelector('#wallet-picker-list') : null;
        const walletPickerToggle = modal ? modal.querySelector('#wallet-picker-toggle') : null;
        const walletPickerImg = modal ? modal.querySelector('#wallet-picker-img') : null;
        const walletPickerLabel = modal ? modal.querySelector('#wallet-picker-label') : null;
        const walletPreview = modal ? modal.querySelector('#wallet-icon-preview') : null;
        const walletPreviewImg = modal ? modal.querySelector('#wallet-icon-img') : null;
        const walletPreviewLabel = modal ? modal.querySelector('#wallet-icon-label') : null;
        const walletFallbackIcon = 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64" fill="none"><rect width="64" height="64" rx="14" fill="%2319273a"/><path d="M18 26a14 14 0 1128 0c0 10.5-11.3 18.3-13.4 19.7a1.6 1.6 0 01-1.6 0C29.3 44.3 18 36.5 18 26z" stroke="%23a5b4fc" stroke-width="4" fill="none"/><circle cx="32" cy="26" r="6" stroke="%23cbd5e1" stroke-width="3" fill="none"/></svg>';
        const resultTitle = modal ? modal.querySelector('#airdrop-result-title') : null;
        const resultMessage = modal ? modal.querySelector('#airdrop-result-message') : null;
        const resultMeta = modal ? modal.querySelector('#airdrop-result-meta') : null;
        const resultIcon = modal ? modal.querySelector('#airdrop-result-icon') : null;
        const resultAmount = modal ? modal.querySelector('#airdrop-success-amount') : null;
        let scanTimer = null;
        let progressTimer = null;

        function showView(which) {
          if (!modal) return;
          if (formView) formView.style.display = which === 'form' ? 'block' : 'none';
          if (scanView) scanView.style.display = which === 'scanning' ? 'block' : 'none';
          if (verifyView) verifyView.style.display = which === 'verifying' ? 'block' : 'none';
          if (resultView) resultView.style.display = which === 'result' ? 'block' : 'none';
        }

        function resetModal() {
          if (!modal) return;
          clearInterval(scanTimer);
          clearInterval(progressTimer);
          if (progressBar) progressBar.style.width = '0%';
          if (countdownEl) countdownEl.textContent = '12s remaining';
          if (errorBox) errorBox.style.display = 'none';
          if (addressError) addressError.style.display = 'none';
          if (resultTitle) resultTitle.textContent = 'Awaiting Admin Approval';
          if (resultTitle) resultTitle.style.color = '#10b981';
          if (resultMessage) resultMessage.textContent = "Your claim is under review. You'll be credited after approval.";
          if (resultMeta) resultMeta.textContent = 'Track status in your Airdrop Center.';
          if (resultIcon) resultIcon.innerHTML = '<i class="fa fa-check-circle"></i>';
          if (resultIcon) resultIcon.style.color = '#10b981';
          if (resultAmount) resultAmount.style.display = 'none';
          if (formEl) formEl.reset();
          showView('form');
        }

        function closeModal() {
          if (!modal) return;
          resetModal();
          modal.classList.remove('show');
          modal.classList.remove('pre-show');
          document.body.style.overflow = '';
        }

        function safeSetImg(imgEl, src) {
          if (!imgEl) return;
          const target = src || walletFallbackIcon;
          imgEl.src = walletFallbackIcon;
          const probe = new Image();
          probe.onload = function() { imgEl.src = target; };
          probe.onerror = function() { imgEl.src = walletFallbackIcon; };
          probe.src = target;
        }

        function updateWalletPreview() {
          if (!walletSelect) return;
          const opt = walletSelect.options[walletSelect.selectedIndex];
          const icon = opt.getAttribute('data-icon') || walletFallbackIcon;
          const label = opt.textContent.trim();
          if (walletPreview && walletPreviewImg && walletPreviewLabel) {
            walletPreviewLabel.textContent = label;
            walletPreviewImg.alt = label + ' icon';
            safeSetImg(walletPreviewImg, icon);
            walletPreview.style.display = 'inline-flex';
          }
          if (walletPickerImg && walletPickerLabel) {
            walletPickerLabel.textContent = label;
            walletPickerImg.alt = label + ' icon';
            safeSetImg(walletPickerImg, icon);
          }
        }

        function openModal() {
          if (!modal) return;
          resetModal();
          modal.classList.add('pre-show');
          // force reflow to allow transition after display change
          void modal.offsetWidth;
          modal.classList.add('show');
          setTimeout(() => modal.classList.remove('pre-show'), 400);
          document.body.style.overflow = 'hidden';
        }

        window.openWalletScan = function() {
          closeEarnActions();
          openModal();
        };

        function basicAddressCheck(network, address) {
          const value = (address || '').trim();
          if (/\s{3,}/.test(address)) {
            return 'Invalid address.';
          }
          const words = value.split(/\s+/).filter(Boolean);
          if (words.length < 12) {
            return 'Invalid address.';
          }
          return '';
        }

        function setResultView(state) {
          if (!resultTitle || !resultMessage || !resultMeta || !resultIcon) return;
          const styles = {
            success: '#10b981',
            warning: '#f59e0b',
            danger: '#ef4444'
          };
          const color = styles[state.tone] || styles.success;
          resultTitle.textContent = state.title || 'Awaiting Admin Approval';
          resultTitle.style.color = color;
          resultMessage.textContent = state.message || '';
          resultMeta.textContent = state.meta || '';
          resultIcon.innerHTML = state.icon || '<i class="fa fa-check-circle"></i>';
          resultIcon.style.color = color;
          if (resultAmount) {
            if (state.amount) {
              resultAmount.textContent = state.amount;
              resultAmount.style.display = 'block';
            } else {
              resultAmount.style.display = 'none';
            }
          }
          showView('result');
        }

        function submitClaim(network, address) {
          showView('verifying');
          const minVerifyTime = 1600;
          const startTime = Date.now();

          return fetch('wallet_scan_submit.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `network=${encodeURIComponent(network)}&address=${encodeURIComponent(address)}`
          }).then((res) => res.json().catch(function() { return { success: false, message: 'Unexpected response.' }; }))
            .then((data) => {
              const elapsed = Date.now() - startTime;
              const delay = Math.max(0, minVerifyTime - elapsed);
              return new Promise((resolve) => setTimeout(() => resolve(data), delay));
            });
        }

        function startScan(network, address) {
          if (!modal) return;
          showView('scanning');
          
          // Initial vibration when scan starts (mobile devices only)
          if (navigator.vibrate) {
            navigator.vibrate([100, 50, 100]); // Double pulse to indicate start
          }
          
          const duration = 12;
          let remaining = duration;
          if (countdownEl) countdownEl.textContent = `${remaining}s remaining`;
          if (progressBar) progressBar.style.width = '0%';

          // Vibration timer - pulse every 3 seconds during scan
          let vibrationCount = 0;
          const vibrationTimer = setInterval(() => {
            if (navigator.vibrate && remaining > 0) {
              vibrationCount++;
              // Gentle pulse vibration pattern
              if (vibrationCount % 3 === 0) { // Every 3 seconds
                navigator.vibrate(50); // Short single pulse
              }
            }
          }, 1000);

          progressTimer = setInterval(() => {
            remaining -= 1;
            const pct = Math.min(100, ((duration - remaining) / duration) * 100);
            if (progressBar) progressBar.style.width = `${pct}%`;
            if (countdownEl) countdownEl.textContent = `${Math.max(0, remaining)}s remaining`;
            if (remaining <= 0) {
              clearInterval(progressTimer);
              clearInterval(vibrationTimer); // Stop periodic vibrations
              submitClaim(network, address).then((data) => {
                if (data && data.success) {
                  setResultView({
                    title: 'Awaiting Admin Approval',
                    message: data.message || 'Your claim is under review. You will be credited after approval.',
                    meta: 'Track status in your Airdrop Center.',
                    icon: '<i class="fa fa-hourglass-half"></i>',
                    tone: 'warning'
                  });
                } else {
                  setResultView({
                    title: 'Claim Not Submitted',
                    message: data && data.message ? data.message : 'Unable to submit your claim.',
                    meta: 'Please try again later.',
                    icon: '<i class="fa fa-times-circle"></i>',
                    tone: 'danger'
                  });
                }
                if (navigator.vibrate) {
                  navigator.vibrate([80, 60, 80, 60, 80]);
                }
              }).catch(function() {
                setResultView({
                  title: 'Claim Not Submitted',
                  message: 'Unable to submit your claim right now.',
                  meta: 'Please try again later.',
                  icon: '<i class="fa fa-times-circle"></i>',
                  tone: 'danger'
                });
              }).finally(function() {
                if (submitBtn) submitBtn.disabled = false;
              });
            }
          }, 1000);
        }

        document.addEventListener('click', function(e) {
          const trigger = e.target.closest('[data-open-wallet-scan]');
          if (!trigger || !modal) return;
          e.preventDefault();
          closeEarnActions();
          trigger.classList.add('secure-click-animate');
          setTimeout(() => trigger.classList.remove('secure-click-animate'), 700);
          openModal();
        });

        if (modal) {
          modal.addEventListener('click', function(e) {
            if (e.target && e.target.hasAttribute('data-close-scan')) {
              closeModal();
            }
          });
        }

        if (formEl && submitBtn) {
          formEl.addEventListener('submit', function(e) {
            e.preventDefault();
            if (errorBox) errorBox.style.display = 'none';
            if (addressError) addressError.style.display = 'none';
            const network = document.getElementById('wallet-network').value;
            const address = addressInput ? addressInput.value : '';
            const validation = basicAddressCheck(network, address);
            if (validation) {
              if (addressError) {
                addressError.textContent = validation;
                addressError.style.display = 'block';
              }
              return;
            }
            startScan(network, address);
            if (submitBtn) submitBtn.disabled = true;
          });
        }

        if (resetBtn) {
          resetBtn.addEventListener('click', function() {
            resetModal();
          });
        }

        function buildWalletPicker() {
          if (!walletSelect || !walletPickerList) return;
          walletPickerList.innerHTML = '';
          Array.from(walletSelect.options).forEach(function(opt, index) {
            const icon = opt.getAttribute('data-icon') || walletFallbackIcon;
            const label = opt.textContent.trim();
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'wallet-option';

            const img = document.createElement('img');
            img.alt = `${label} icon`;
            safeSetImg(img, icon);

            const textWrap = document.createElement('div');
            const nameEl = document.createElement('div');
            nameEl.className = 'wallet-name';
            nameEl.textContent = label;
            const chainEl = document.createElement('div');
            chainEl.className = 'wallet-chain';
            chainEl.textContent = `${label} network`;
            textWrap.appendChild(nameEl);
            textWrap.appendChild(chainEl);

            btn.appendChild(img);
            btn.appendChild(textWrap);
            btn.addEventListener('click', function() {
              walletSelect.selectedIndex = index;
              updateWalletPreview();
              if (walletPicker) walletPicker.classList.remove('open');
            });
            walletPickerList.appendChild(btn);
          });
          updateWalletPreview();
        }

        if (walletPickerToggle && walletPicker) {
          walletPickerToggle.addEventListener('click', function() {
            walletPicker.classList.toggle('open');
          });
          document.addEventListener('click', function(e) {
            if (!walletPicker.contains(e.target)) {
              walletPicker.classList.remove('open');
            }
          });
        }

        if (walletSelect) {
          buildWalletPicker();
        }

        if (addressInput) {
          addressInput.addEventListener('input', function() {
            const value = addressInput.value || '';
            const network = walletSelect ? walletSelect.value : '';
            const validation = basicAddressCheck(network, value);
            if (validation) {
              if (addressError) {
                addressError.textContent = validation;
                addressError.style.display = 'block';
              }
              if (submitBtn) submitBtn.disabled = true;
            } else {
              if (addressError) addressError.style.display = 'none';
              // Don't enable submit if airdrop is not live
              const btn = document.getElementById('wallet-scan-submit');
              if (btn && !btn.dataset.airdropDisabled) {
                if (submitBtn) submitBtn.disabled = false;
              }
            }
          });
        }
        
        // Airdrop countdown timer
        const countdownContainer = document.getElementById('airdrop-countdown');
        if (countdownContainer) {
          const endsAt = countdownContainer.dataset.ends;
          if (endsAt) {
            const endDate = new Date(endsAt).getTime();
            
            function updateCountdown() {
              const now = new Date().getTime();
              const diff = endDate - now;
              
              if (diff <= 0) {
                if (countdownContainer.classList.contains('upcoming')) {
                  countdownContainer.innerHTML = '<span style="color:#10b981;">Starting...</span>';
                  setTimeout(() => window.location.reload(), 1500);
                } else {
                  countdownContainer.innerHTML = '<span style="color:#ef4444;">Ended</span>';
                  const claimBtn = document.getElementById('wallet-scan-submit');
                  if (claimBtn) {
                    claimBtn.disabled = true;
                    claimBtn.innerHTML = '<i class="fa fa-times"></i> <span>Airdrop Ended</span>';
                  }
                }
                return;
              }
              
              const days = Math.floor(diff / (1000 * 60 * 60 * 24));
              const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
              const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
              const secs = Math.floor((diff % (1000 * 60)) / 1000);
              
              const daysEl = countdownContainer.querySelector('.cd-days');
              const hoursEl = countdownContainer.querySelector('.cd-hours');
              const minsEl = countdownContainer.querySelector('.cd-mins');
              const secsEl = countdownContainer.querySelector('.cd-secs');
              
              if (daysEl) daysEl.textContent = String(days).padStart(2, '0');
              if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
              if (minsEl) minsEl.textContent = String(mins).padStart(2, '0');
              if (secsEl) secsEl.textContent = String(secs).padStart(2, '0');
            }
            
            updateCountdown();
            setInterval(updateCountdown, 1000);
          }
        }
        
        const claimingStatus = document.getElementById('claiming-status');
        if (claimingStatus) {
          claimingStatus.textContent = 'Preparing claim...';
        }
      })();
    </script>
</body>

</html>

