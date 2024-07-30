<?php
// Include the database connection file
require '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $fullName = htmlspecialchars($_POST['fullName']);
    $course = htmlspecialchars($_POST['course']);
    $studentType = htmlspecialchars($_POST['studentType']);

    // Prepare SQL statement to insert data into the database
    $sql = "INSERT INTO student_applications (full_name, course, student_type) VALUES (?, ?, ?)";

    // Use prepared statements for security
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $fullName, $course, $studentType);

    // Execute the statement
    if ($stmt->execute()) {
        // Successful insertion
        echo "<script>
                alert('Application submitted successfully.');
                window.location.href = '../studentdash/header.php'; // Redirect to a success page or homepage
              </script>";
    } else {
        // Error handling
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
