<?php
session_start();
require '../database/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $recaptcha_response = $_POST['recaptcha_response'] ?? '';

    // Verify reCAPTCHA
    $secret_key = '6LedFpMqAAAAAP3lE4T-osBEkFWTlQAM_xYJpaXL';
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';

    if (empty($recaptcha_response)) {
        die('Error: reCAPTCHA response is missing.');
    }

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
    $sql = "SELECT * FROM admin WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
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
            exit();
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

    $stmt->close();
    $conn->close();
}
?>
