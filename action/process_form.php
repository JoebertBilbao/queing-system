<?php 
require '../database/db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['name'];
    $lastname = $_POST['surname'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $course = $_POST['course'];
    $high_school = $_POST['highschool'];
    $message = $_POST['message'];

    // Prepare and bind SQL statement
    $sql = "INSERT INTO enroll_requests (firstname, lastname, email, date_of_birth, address , course , high_school ,message) 
    VALUES ('$firstname', '$lastname', '$email','$dob','$address','$course','$high_school','$message')";

// Execute the query
if ($conn->query($sql) === TRUE) {
// Redirect to a success page or display a success message
echo "Form submitted successfully!";
} else {
// Handle errors if the query fails
echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$conn->close();
}

?>