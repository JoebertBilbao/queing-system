<?php
session_start();
require '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the passwords match
    if ($password !== $confirm_password) {
        echo "<script>
                alert('Passwords do not match.');
                window.location.href = 'signup.html';
              </script>";
        exit;
    }

    // Check if the email already exists
    $sql = "SELECT * FROM admin WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<script>
                alert('An account with this email already exists.');
                window.location.href = 'signup.html';
              </script>";
        exit;
    }

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $sql = "INSERT INTO admin (email, password) VALUES ('$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Signup successful. You can now log in.');
                window.location.href = '../portal.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
                window.location.href = 'signup.html';
              </script>";
    }

    $conn->close();
}
?>
