    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
        
    <script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script>
        function markNotificationRead(notificationId) {
            $.ajax({
                url: 'mark_notification_read.php',
                type: 'POST',
                data: {notification_id: notificationId},
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    console.error('Failed to mark notification as read');
                }
            });
        }

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
    
    /* Back Button Sidebar Alignment */
    .header-logo-container {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    </style>
