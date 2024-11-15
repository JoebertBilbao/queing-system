<?php
session_start();

// If user is already logged in, redirect to dashboard or home page
if (isset($_SESSION['user_id'])) {
    header('Location: student/index.php');
    exit();
}

// Process login form submission if any
// Your existing login form and logic here
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LOGIN | STUDENTS</title>
    <!-- Custom CSS File -->
    <link rel="stylesheet" href="style.css">
    <link href="assets/image/images.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <style>
        /* Add some basic styling for the toggle icon */
        .password-container {
            position: relative;
        }

        .password-container input {
            padding-right: 40px; /* Adjust this value based on the width of the icon */
        }

        .toggle-password {
            position: absolute;
            top: 40%;
            right: 20px;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 1;
        }
        /* Responsive table styles */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        @media (max-width: 768px) {
            table {
                font-size: 12px;
            }

            th, td {
                padding: 8px;
            }
        }

        @media (max-width: 480px) {
            table {
                font-size: 10px;
            }

            th, td {
                padding: 5px;
            }

            .table-container {
                overflow-x: auto;
            }

            table {
                display: block;
                width: 100%;
                overflow-x: auto;
                white-space: nowrap;
            }

            th, td {
                display: block;
                text-align: right;
            }

            th {
                text-align: left;
            }

            th::after, td::after {
                content: ':';
            }

            td {
                position: relative;
                padding-left: 50%;
            }

            td::before {
                position: absolute;
                top: 0;
                left: 0;
                width: 50%;
                padding-right: 10px;
                white-space: nowrap;
                content: attr(data-label);
                text-align: left;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login form">
            <header>Login</header>
            <form action="action/process_login.php" method="post">
                <input type="text" name="email" placeholder="Enter your email">
                <div class="password-container">
                    <input type="password" id="password" name="password" placeholder="Enter your password">
                    <i class="toggle-password bi bi-eye-slash" id="togglePassword"></i>
                </div>
                <!-- <a href="#">Forgot password?</a> -->
                <input type="submit" class="button" value="Login">
            </form>
            <div class="signup">
                <span class="signup">Don't have an account? <br> <br> <a href="signup.php">Register</a>
                </span>
                <div class="text-center mt-3">
                    <a href="index.php" class="btn btn-secondary btn-sm">Back to Home</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

    <!-- JavaScript to handle password toggle -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>
</body>

</html>
