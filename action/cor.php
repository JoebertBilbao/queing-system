<?php
// Include your database connection file
require '../database/db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $firstname = $_POST['name'];
    $lastname = $_POST['surname'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $need = $_POST['need'];
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    // SQL query to insert data into your table
    $sql = "INSERT INTO cor_forms (firstname, lastname, address, contact, email, need, message)
            VALUES ('$firstname', '$lastname', '$address', '$contact', '$email', '$need', '$message')";

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
