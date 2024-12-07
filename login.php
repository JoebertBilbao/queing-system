<?php
session_start();
include 'database/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: student/index');
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
            $msg = "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative'>Account verification successfully completed.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Verification failed. Please try again.</div>";
        }
    } else {
        header("Location: login");
        exit();
    }
}
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

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        height: 100vh;
        background: url('assets/image/loginbackground.jpg') no-repeat center center/cover;
        display: justify;
        justify-content: center;
        align-items: center;
    }

    .container {
        width: 100%;
        max-width: 400px;
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .login.form {
        padding: 20px 30px;
    }

    header {
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    input[type="email"],
    input[type="password"],
    .button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .button {
        background: #4e54c8;
        color: #fff;
        font-weight: bold;
        border: none;
        cursor: pointer;
    }

    .button:hover {
        background: #8f94fb;
    }

    .signup {
        text-align: center;
        margin-top: 20px;
    }

    .signup .btn {
        background: #4e54c8;
        color: #fff;
        font-size: 14px;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        text-decoration: none;
    }

    .signup .btn:hover {
        background: #8f94fb;
    }
</style>

</head>

<body>
    <div class="container">
        <div class="login form">
            <header>Login</header>
            <form action="action/process_login.php" method="post">
                <?php 
                echo $msg;
                ?>
                <input type="text" name="email" placeholder="Enter your email">
                <div class="password-container">
                    <input type="password" id="password" name="password" placeholder="Enter your password">
                    <i class="toggle-password bi bi-eye-slash" id="togglePassword"></i>
                </div>
                <!-- <a href="#">Forgot password?</a> -->
                <input type="submit" class="button" value="Login">
            </form>
            <div class="signup">
                <span class="signup">Don't have an account? <br> <br> <a href="signup">Register</a>
                </span>
                <div class="text-center mt-3">
                    <a href="index" class="btn btn-secondary btn-sm">Back to Home</a>
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
