
<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from tenvaultmarkets.com/my-account/forget_password.php by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Feb 2026 09:57:17 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
   <!-- Meta tags  -->
   <meta charset="UTF-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />

   <title>Tenvault Markets | Global Stock Trading Platform</title>
   


   <!-- CSS Assets -->
   <!-- CSS Assets -->
   <link rel="stylesheet" href="assets/css/app.css" />
   




  
  
  


  
  
  


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
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>


<body x-data class="is-header-blur" x-bind="$store.global.documentBody">
    <!-- App preloader-->
    <div class="app-preloader fixed z-50 grid h-full w-full place-content-center bg-slate-50 dark:bg-navy-900">
      <div class="app-preloader-inner relative inline-block h-48 w-48"></div>
    </div>

    <!-- Page Wrapper -->
    <div id="root" class="min-h-100vh flex grow" x-cloak>
      <main class="grid w-full grow grid-cols-1 place-items-center py-8 px-4">
        <div class="w-full max-w-md">
          <!-- Logo & Header -->
          <div class="text-center mb-8">
            <a href="login/index.php" class="inline-block transition-transform hover:scale-105">
              <img src="../assets/images/logo.png" alt="Tenvault Market Logo">
            </a>
            <h1 class="mt-6 text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
              Reset Password
            </h1>
            <p class="text-slate-400 mt-2 text-sm sm:text-base">
              Enter your email to receive recovery instructions
            </p>
          </div>

          <!-- Auth Card -->
          <div class="auth-card p-6 sm:p-8">
            
            <form action="#" method="post" class="space-y-5">
              <!-- Email -->
              <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-600 dark:text-slate-300">Email Address</label>
                <div class="input-wrapper relative">
                  <input required name="email" class="auth-input w-full" placeholder="Enter your email" type="email" />
                  <i class="fas fa-envelope auth-icon"></i>
                </div>
              </div>

              <!-- Submit Button -->
              <button type="submit" name="submit" class="auth-btn w-full">
                Send Reset Link
              </button>

              <!-- Back Link -->
              <p class="text-center text-sm text-slate-500 dark:text-slate-400 pt-2">
                Remembered your password? 
                <a href="login/index.php" class="font-bold text-indigo-500 hover:text-indigo-400 transition-colors">Back to Sign In</a>
              </p>
            </form>
          </div>

          <!-- Footer Links -->
          <div class="mt-8 flex items-center justify-center gap-4 text-xs text-slate-500">
            <a href="#" class="hover:text-indigo-400 transition-colors">Privacy Policy</a>
            <span class="text-slate-600">ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â¢</span>
            <a href="#" class="hover:text-indigo-400 transition-colors">Terms of Service</a>
          </div>
        </div>
      </main>
    </div>

    <div id="x-teleport-target"></div>
    <script>
      window.addEventListener("DOMContentLoaded", () => Alpine.start());
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
   </body>

<!-- Mirrored from tenvaultmarkets.com/my-account/forget_password.php by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Feb 2026 09:57:19 GMT -->
</html>

