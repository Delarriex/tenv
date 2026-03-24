<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_SESSION['user_id'])) {
    header('Location: ../dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<style>
    /* Safety fallback for preloader */
    @keyframes fadeOut { from { opacity: 1; visibility: visible; } to { opacity: 0; visibility: hidden; } }
    .hide-preloader { animation: fadeOut 0.5s forwards; }
</style>

<!-- Mirrored from argoncryptos.com/my-account/login/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 03 Dec 2024 03:41:47 GMT -->
<!-- Added by HTTrack -->
<!-- Mirrored from tenvaultmarkets.com/my-account/login/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Feb 2026 09:55:40 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
   <!-- Meta tags  -->
   <meta charset="UTF-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />

   <title>Tenvault Markets | Global Stock Trading Platform</title>
   


   <!-- CSS Assets -->
   <!-- CSS Assets -->
   <link rel="stylesheet" href="../assets/css/app.css" />
   




  
  
  


  
  
  


  <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/logo.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../../assets/images/logo.png">
  <link rel="apple-touch-icon" sizes="180x180" href="../../assets/images/logo.png">



<style>
/* Branding Excellence */
        .uc-logo img,
        .auth-logo img,
        .header-logo img {
            height: 80px !important;
            width: auto !important;
            object-fit: contain;
            display: block;
            image-rendering: -webkit-optimize-contrast;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        @media (max-width: 768px) {
            .uc-logo img,
            .auth-logo img,
            .header-logo img {
                height: 60px !important;
            }
        }

        /* Mobile Sidebar Frosted Glass Refinement */
        #uc-menu-panel .uc-offcanvas-bar {
            background: rgba(0, 0, 0, 0.7) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            width: 320px;
        }
</style>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>




<body x-data class="is-header-blur" x-bind="$store.global.documentBody">
    <!-- No Preloader -->

    <!-- Page Wrapper -->
    <div id="root" class="min-h-100vh flex grow" x-cloak>
      <main class="grid w-full grow grid-cols-1 place-items-center py-8 px-4">
        <div class="w-full max-w-md">
          <!-- Logo & Header -->
          <div class="text-center mb-8 auth-logo">
            <a href="../../index.html" class="inline-block transition-transform hover:scale-105">
              <img src="../../assets/images/logo.png" alt="Tenvault Market Logo">
            </a>
            <h1 class="mt-6 text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
              Welcome Back
            </h1>
            <p class="text-slate-400 mt-2 text-sm sm:text-base">
              Sign in to your account to continue
            </p>
          </div>

          <!-- Auth Card -->
          <div class="auth-card p-6 sm:p-8">
            
            <form action="#" method="post" class="space-y-5">
              <!-- Username -->
              <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-600 dark:text-slate-300">Username or Email</label>
                <div class="input-wrapper relative">
                  <input required name="username" 
                    class="auth-input w-full" 
                    placeholder="Enter your username or email" type="text" />
                  <i class="fas fa-user auth-icon"></i>
                </div>
              </div>

              <!-- Password -->
              <div class="space-y-2">
                <div class="flex items-center justify-between">
                  <label class="block text-sm font-semibold text-slate-600 dark:text-slate-300">Password</label>
                  <a href="../forget_password.php" class="text-xs font-medium text-indigo-500 hover:text-indigo-400 transition-colors">Forgot password?</a>
                </div>
                <div class="input-wrapper relative">
                  <input required name="password" 
                    class="auth-input w-full" 
                    placeholder="Enter your password" type="password" />
                  <i class="fas fa-lock auth-icon"></i>
                </div>
              </div>

              <!-- Remember Me -->
              <div class="flex items-center gap-2">
                <input id="remember" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-indigo-500 focus:ring-indigo-500" />
                <label for="remember" class="text-sm text-slate-500 dark:text-slate-400 cursor-pointer">Remember me</label>
              </div>

              <!-- Submit Button -->
              <button type="submit" name="submit" class="auth-btn w-full">
                Sign In
              </button>

              <!-- Divider -->
              <div class="flex items-center gap-4 py-2">
                <div class="flex-1 h-px bg-slate-200 dark:bg-slate-700"></div>
                <span class="text-xs text-slate-400 uppercase tracking-wider">Secure Access</span>
                <div class="flex-1 h-px bg-slate-200 dark:bg-slate-700"></div>
              </div>

              <!-- Sign Up Link -->
              <p class="text-center text-sm text-slate-500 dark:text-slate-400">
                Don't have an account? 
                <a href="../register/index.php" class="font-bold text-indigo-500 hover:text-indigo-400 transition-colors">Create one now</a>
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

    
    <script>
      // Global Preloader Safety
      setTimeout(() => {
        const preloader = document.querySelector('.app-preloader');
        if (preloader) preloader.style.display = 'none';
      }, 3000);
    </script>
    <div id="x-teleport-target"></div>
    <script>
      document.querySelector('form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const btn = e.target.querySelector('button');
        const originalText = btn.innerText;
        btn.innerText = 'Signing In...';
        btn.disabled = true;

        try {
          const response = await fetch('../../api/login_action.php', {
            method: 'POST',
            body: formData
          });
          const result = await response.json();
          if (result.status === 'success') {
            window.location.href = result.redirect;
          } else {
            alert(result.message);
            btn.innerText = originalText;
            btn.disabled = false;
          }
        } catch (error) {
          console.error('Error:', error);
          alert('An error occurred. Please try again.');
          btn.innerText = originalText;
          btn.disabled = false;
        }
      });

      window.addEventListener("DOMContentLoaded", () => Alpine.start());
    </script>
        <!-- Use FontAwesome if available/included elsewhere, or include here if needed -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
   </body>

<!-- Mirrored from tenvaultmarkets.com/my-account/login/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Feb 2026 09:55:50 GMT -->
</html>


