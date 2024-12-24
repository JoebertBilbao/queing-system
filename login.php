<?php
session_start();
include 'database/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: student/index.php');
    exit();
}

$msg = "";

if (isset($_GET['verification'])) {
    $verification_code = $_GET['verification'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE verification_code = ?");
    $stmt->bind_param('s', $verification_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $update_stmt = $conn->prepare("UPDATE users SET verification_code='', verified=1 WHERE verification_code = ?");
        $update_stmt->bind_param('s', $verification_code);
        if ($update_stmt->execute()) {
            $msg = "<div class='fixed top-4 right-4 flex items-center p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-50'>
                      <svg class='flex-shrink-0 w-4 h-4' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 20 20'>
                          <path d='M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z'/>
                      </svg>
                      <div class='ms-3 text-sm font-medium'>
                          Account verified successfully! You can now login.
                      </div>
                      <button type='button' class='ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8' onclick='this.parentElement.remove()'>
                          <span class='sr-only'>Close</span>
                          <svg class='w-3 h-3' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 14 14'>
                              <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6'/>
                          </svg>
                      </button>
                    </div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN | STUDENTS</title>
    <link href="assets/image/images.png" rel="icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
</head>
<style>
.custom-shape-divider-bottom-1734644541 {
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
}
</style>
<body class="min-h-screen bg-cover bg-center bg-no-repeat flex items-center justify-center p-4">
    <?php echo $msg; ?>
    <div class="custom-shape-divider-bottom-1734644541">
    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
    </svg>
</div>
    <div class="w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden">
        <!-- Header Section -->
        <div class="p-6 bg-gradient-to-r from-red-600 to-red-700">
            <div class="text-center">
                <img src="assets/image/icon.png" alt="MCC Logo" class="w-20 h-20 mx-auto mb-4">
                <h1 class="text-2xl font-bold text-white">Student Login</h1>
                <p class="text-red-100 mt-1">Madridejos Community College</p>
            </div>
        </div>

        <!-- Login Form -->
        <div class="p-6">
            <form action="action/process_login.php" method="post" class="space-y-4">
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
                    Don't have an account? 
                    <a href="signup.php" class="text-red-600 hover:text-red-800 font-medium">Register</a>
                </p>
                <a href="index.php" 
                   class="inline-block text-sm text-gray-600 hover:text-gray-800 font-medium">
                    Back to Home
                </a>
            </div>
        </div>
    </div>

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

        // Auto-hide success message after 5 seconds
        setTimeout(function() {
            const alertMessage = document.querySelector('[class*="fixed top-4"]');
            if (alertMessage) {
                alertMessage.remove();
            }
        }, 5000);
    </script>
</body>
</html>