<?php
session_start(); // Start session to store student's information

include '../database/db.php'; // Include your database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $year_level = $_POST['year_level'];
    $status = $_POST['status'];
    $semester = $_POST['semester'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $course = $_POST['course'];

    // Check if passwords match
    if ($password != $confirm_password) {
        echo "<script>
                alert('Passwords do not match.');
                window.history.back();
              </script>";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, year_level, status, semester, email, password, course) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "<script>
                alert('Database error: {$conn->error}');
                window.history.back();
              </script>";
        exit();
    }

    $stmt->bind_param("sssssss", $name, $year_level, $status, $semester, $email, $hashed_password, $course);

    if ($stmt->execute()) {
        $_SESSION['name'] = $name;
        $_SESSION['course'] = $course;

        echo "<script>
                alert('New record created successfully');
                window.location.href = '../login.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: {$stmt->error}');
                window.history.back();
              </script>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
