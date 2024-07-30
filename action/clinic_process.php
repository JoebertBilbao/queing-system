<?php
// Include your database connection file
require '../database/db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $medical_history = $_POST['medical_history'];
    $medications = $_POST['medications'];
    $allergies = $_POST['allergies'];
    $symptoms = $_POST['symptoms'];
    $appointment_date = $_POST['appointment_date'];

    // SQL query to insert data into your table
    $sql = "INSERT INTO clinic_forms (fullname, dob, contact, email, address, medical_history, medications, allergies, symptoms, appointment_date)
            VALUES ('$fullname', '$dob', '$contact', '$email', '$address', '$medical_history', '$medications', '$allergies', '$symptoms', '$appointment_date')";

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
