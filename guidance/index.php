<?php
session_start();

if (isset($_SESSION['email'])) {
    header('Location: guidance.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ADMIN LOGIN | GUIDANCE</title>
    <link href="assets/image/image1.png" rel="icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<style>.custom-shape-divider-bottom-1734644541 {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
    transform: rotate(180deg);
}

.custom-shape-divider-bottom-1734644541 svg {
    position: relative;
    display: block;
    width: calc(100% + 1.3px);
    height: 66px;
}

.custom-shape-divider-bottom-1734644541 .shape-fill {
    fill: #C90C0C;
}</style>
<body class="min-h-screen bg-cover bg-center bg-no-repeat flex items-center justify-center p-4">
<div class="custom-shape-divider-bottom-1734644541">
    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
    </svg>
</div>
    <div class="w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden">
        <!-- Header Section -->
        <div class="p-6 bg-gradient-to-r from-red-600 to-red-700">
            <div class="text-center">
                <img src="../assets/image/icon.png" alt="MCC Logo" class="w-20 h-20 mx-auto mb-4">
                <h1 class="text-2xl font-bold text-white">Admin Login</h1>
                <p class="text-red-100 mt-1">Guidance Department</p>
            </div>
        </div>

        <!-- Login Form -->
        <div class="p-6">
            <form action="../action/process_guidance_login.php" method="post" class="space-y-4" id="loginForm">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" name="email" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <i class="bi bi-eye-slash absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 cursor-pointer" id="togglePassword"></i>
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition duration-200 font-medium">
                    Login
                </button>
            </form>

            <div class="mt-6 text-center space-y-4">
                <p class="text-sm text-gray-600">
                    <a href="forgot-password.php" class="text-red-600 hover:text-red-800 font-medium">Forgot Password?</a>
                </p>
                <a href="../portal.php" 
                   class="inline-block text-sm text-gray-600 hover:text-gray-800 font-medium">
                    Back to Home
                </a>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Password toggle functionality
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });

        // Prevent back button
        function preventBack() {
            window.history.forward();
        }
        setTimeout("preventBack()", 0);
        window.onunload = function() { null };
    </script>
</body>
</html>