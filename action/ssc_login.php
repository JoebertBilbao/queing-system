<?php
session_start(); // Start session at the beginning of the script
require '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists
    $sql = "SELECT * FROM ssc WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Verify the password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables
            $_SESSION['email'] = $email;

            // Redirect to dashboard or wherever needed
            echo "<script>
                    window.location.href = '../ssc/ssc.php';
                  </script>";
            exit;
        } else {
            echo "<script>
                    alert('Invalid password.');
                    window.location.href = '../ssc/index.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('No user found with this email.');
                window.location.href = '../ssc/index.php';
              </script>";
    }

    $conn->close();
}
?>
