<?php
session_start(); // Start session at the beginning of the script
require '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $recaptcha_response = $_POST['recaptcha_response'];

    // Your reCAPTCHA secret key
    $secret_key = '6LedFpMqAAAAAP3lE4T-osBEkFWTlQAM_xYJpaXL';

    // Verify reCAPTCHA v3 token
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $response = file_get_contents($recaptcha_url . "?secret=$secret_key&response=$recaptcha_response");
    $response_keys = json_decode($response, true);

    if (!$response_keys['success'] || $response_keys['score'] < 0.5) {
        echo "
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'reCAPTCHA verification failed. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'Try Again'
                }).then(() => {
                    window.location.href = '../admin/index.php';
                });
            </script>
        ";
        exit;
    }

    // Check if user exists
    $sql = "SELECT * FROM admin WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Verify the password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $row['name'];

            echo "
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
            ";
            exit;
        } else {
            echo "
                <script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Invalid password.',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    }).then(() => {
                        window.location.href = '../admin/index.php';
                    });
                </script>
            ";
        }
    } else {
        echo "
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'No user found with this email.',
                    icon: 'error',
                    confirmButtonText: 'Try Again'
                }).then(() => {
                    window.location.href = '../admin/index.php';
                });
            </script>
        ";
    }

    $conn->close();
}
?>
