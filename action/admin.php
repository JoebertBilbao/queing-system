<?php
session_start();
require '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verify reCAPTCHA v3
    $recaptcha_secret = "6LdFIJMqAAAAAIUJqbtrsFofxx7D-Z96oRo1xwFN";
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

    // Check if the score is above your threshold (e.g., 0.5)
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
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $row['name'];

            // Redirect to dashboard or wherever needed
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
      exit;
  } else {
      echo "
                <script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Invalid password.',
                        icon: 'error',
                        confirmButtonText: 'Try Again!'
                    }).then(() => {
                        window.location.href = '../admin/index.php';
                    });
                </script>
           ";
  }
} else {
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
                    text: 'No user found with this email.',
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
