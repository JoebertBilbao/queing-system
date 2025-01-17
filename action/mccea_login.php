<?php
session_start(); // Start session at the beginning of the script
require '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists
    $sql = "SELECT * FROM mccea WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Verify the password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables
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
                        text: 'Login successful. Redirecting...',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '../mccea/mccea.php';
                    });
                </script>
            </body>
            </html>";
      exit;
  } else {
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
                        title: 'Error!',
                        text: 'Invalid password.',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    }).then(() => {
                        window.location.href = '../mccea/index.php';
                    });
                </script>
                </body>
                </html";
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
            title: 'WARNING! Notify to Admin!',
            title: 'Security Alert! Access Denied!',
            text: 'This Facility Under 24 hours Surveillance ,Trespassers will be prosecuted!!',
            icon: 'error',
            confirmButtonText: 'Try Again'
                }).then(() => {
                    window.location.href = '../mccea/index.php';
                });
            </script>
        </body>
        </html>";
}


    $conn->close();
}
?>
