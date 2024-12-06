<?php
session_start();
require '../database/db.php';

// Set login attempt limit and lockout duration
$max_attempts = 3;
$lockout_duration = 300; // 5 minutes in seconds

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize session variables if not set
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['last_attempt_time'] = time();
    }

    // Check if user is locked out
    $time_since_last_attempt = time() - $_SESSION['last_attempt_time'];
    if ($_SESSION['login_attempts'] >= $max_attempts && $time_since_last_attempt < $lockout_duration) {
        showError("Too many failed attempts. Please try again after " . (int)(($lockout_duration - $time_since_last_attempt) / 60) . " minute(s).");
        exit();
    }

    // Verify reCAPTCHA v3
    $recaptcha_secret = "6Lc5vpMqAAAAANE-_jqvUCQyETTNiF9M7hZyQfDL";
    $recaptcha_response = $_POST['recaptcha_response'];

    $verify_url = "https://www.google.com/recaptcha/api/siteverify";
    $data = [
        'secret' => $recaptcha_secret,
        'response' => $recaptcha_response
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $verify_response = file_get_contents($verify_url, false, $context);
    $response_data = json_decode($verify_response);

    // Check reCAPTCHA score
    if ($response_data->success && $response_data->score >= 0.5) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM admin WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Reset login attempts after successful login
                $_SESSION['login_attempts'] = 0;

                $_SESSION['email'] = $email;
                $_SESSION['name'] = $row['name'];

                echo "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Redirecting...</title>
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                </head>
                <body>
                    <script>
                        Swal.fire({
                            title: 'Success!',
                            text: 'Login successful. Redirecting!...',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = '../admin/admin.php';
                        });
                    </script>
                </body>
                </html>";
                exit();
            } else {
                // Invalid password
                logFailedAttempt();
                showError('Invalid password.');
            }
        } else {
            // No user found
            logFailedAttempt();
            showError('No user found with this email.');
        }
        $stmt->close();
    } else {
        logFailedAttempt();
        showError('reCAPTCHA verification failed. Please try again.');
    }
    $conn->close();
}

function logFailedAttempt() {
    $_SESSION['login_attempts']++;
    $_SESSION['last_attempt_time'] = time();
}

function showError($message) {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Login Error</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: 'Error!',
                text: '$message',
                icon: 'error',
                confirmButtonText: 'Try Again!'
            }).then(() => {
                window.location.href = '../admin/index.php';
            });
        </script>
    </body>
    </html>";
}
?>
