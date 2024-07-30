<?php
require '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists
    $sql = "SELECT * FROM admins WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Verify the password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['email'] = $email; 

          
            echo "<script>
                    window.location.href = '../admin/dashboard.php';
                  </script>";
            exit; // Ensure
        } else {
            echo "<script>
                    alert('Invalid password.');
                    window.location.href = '../admin/index.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('No user found with this email.');
                window.location.href = '../admin/index.php';
              </script>";
    }

    $conn->close();
}
?>