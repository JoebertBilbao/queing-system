<?php
require '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $department = $_POST['department']; // New department field from form

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert admin into the database
    $sql = "INSERT INTO department (email, password, department) VALUES ('$email', '$hashed_password', '$department')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('New record created successfully');
            window.location.href = '../head/index.php';
          </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
