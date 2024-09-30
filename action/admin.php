<?php
session_start(); // Start session at the beginning of the script
require '../database/db.php';

// Initialize login attempts and lockout time
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['lockout_time'] = 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user is currently locked out
    if ($_SESSION['lockout_time'] > time()) {
        $remainingTime = $_SESSION['lockout_time'] - time();
        echo "
            <script>
                Swal.fire({
                    title: 'Locked Out!',
                    text: 'Too many failed attempts. Try again in " . ceil($remainingTime / 60) . " minutes.',
                    icon: 'error',
                    confirmButtonText: 'Okay'
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
            // Password is correct, reset attempts and session
            $_SESSION['login_attempts'] = 0; // Reset attempts
            $_SESSION['lockout_time'] = 0; // Reset lockout time
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $row['name'];

            // Redirect to dashboard
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
                        text: 'Login successful. Redirecting...',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '../admin/admin.php';
                    });
                </script>
            </body>
            </html>";
            exit;
        } else {
            // Increment login attempts
            $_SESSION['login_attempts']++;

            if ($_SESSION['login_attempts'] >= 3) {
                // Lock out for 30 minutes
                $_SESSION['lockout_time'] = time() + (30 * 60);
                echo "
                    <script>
                        Swal.fire({
                            title: 'Too Many Attempts!',
                            text: 'You are locked out for 30 minutes.',
                            icon: 'error',
                            confirmButtonText: 'Okay'
                        }).then(() => {
                            window.location.href = '../admin/index.php';
                        });
                    </script>
                ";
            } else {
                echo "
                    <script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Invalid password. Attempt " . $_SESSION['login_attempts'] . " of 3.',
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        }).then(() => {
                            window.location.href = '../admin/index.php';
                        });
                    </script>
                ";
            }
        }
    } else {
        echo "
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Email not found.',
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
                title: 'WARNING! Notify to Admin!',
                text: 'Access Denied',
                icon: 'error',
                confirmButtonText: 'Try Again'
            }).then(() => {
                window.location.href = '../admin/index.php';
            });
        </script>
    ";
}

$conn->close();
?>
