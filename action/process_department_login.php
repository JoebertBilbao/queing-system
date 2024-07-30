<?php
  session_start();
require '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists
    $sql = "SELECT * FROM department WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Verify the password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
          
            $_SESSION['department'] = $row['department']; 

            header("Location: ../head/departmenthead.php");
            exit;
        } else {
            echo "<script>alert('Invalid password.'); window.location.href = '../head/index.php';</script>";
        }
    } else {
        echo "<script>alert('No user found with this email.'); window.location.href = '../head/index.php';</script>";
    }

    $conn->close();
}
?>
