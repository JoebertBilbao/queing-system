<?php
session_start();

// If user is already logged in, redirect to dashboard or home page
// if (!isset($_SESSION['email'])) {
//     header('Location: verification.php');
//     exit();
// }

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Get the reCAPTCHA response
    $recaptcha_response = $_POST['g-recaptcha-response'];

    // Your reCAPTCHA secret key
    $secret_key = '6LfFVY8qAAAAAIl2JZR3CuvRws0mNwzvtZjkkVuky';

    // Verify reCAPTCHA with Google
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $response = file_get_contents($recaptcha_url . "?secret=$secret_key&response=$recaptcha_response");
    $response_keys = json_decode($response, true);

    // If reCAPTCHA is not successful, show an error
    if (!$response_keys['success']) {
        echo "<script>alert('Please complete the reCAPTCHA verification!');</script>";
    } else {
        // Proceed with checking the email and password (example)
        // Assuming you're using a database to validate user credentials:
        // Example: check_user_credentials($email, $password);
        
        // If valid, redirect to admin page or dashboard
        $_SESSION['email'] = $email; // Store user session
        header('Location: admin.php');
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
    <title>Login | Admin</title>
    <link rel="stylesheet" href="style.css">
    <link href="assets/image/image1.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        .password-container {
            position: relative;
        }

        .password-container input {
            padding-right: 40px;
        }

        .toggle-password {
            position: absolute;
            top: 40%;
            right: 20px;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 1;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login form">
            <header>ADMIN</header>
            <form id="loginForm" action="../action/admin.php" method="post" onsubmit="return validateForm()">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <div class="password-container">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <i class="toggle-password bi bi-eye-slash" id="togglePassword"></i>
                </div>
                <!-- reCAPTCHA widget -->
                <div class="g-recaptcha" data-sitekey="6LfFVY8qAAAAADfMHTIBOlt_SZu8u8C6FxawmWHA"></div>

                <input type="submit" class="button" value="Login">
                <a href="forgot-password.php" style=" float:right;">Forgot Password?</a>
            </form>

            <div class="signup">
                <div class="text-center mt-3">
                    <a href="../portal.php" class="btn btn-secondary btn-sm">Back to Home</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        function validateForm() {
            const recaptchaResponse = grecaptcha.getResponse();

            // If reCAPTCHA is not checked
            if (recaptchaResponse.length === 0) {
                alert('Please complete the reCAPTCHA verification!');
                return false;  // Prevent form submission
            }
            return true;  // Allow form submission
        }
    </script>

    <script type="text/javascript">
        function preventBack(){
            window.history.forward()
        }; setTimeout("preventBack()", 0);
        window.onunload=function(){null;}
    </script>
</body>

</html>
