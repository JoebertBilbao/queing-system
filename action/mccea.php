<?php
// Include your database connection file
require '../database/db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $upper_size = $_POST['upper_size'];
    $lower_size = $_POST['lower_size'];
    $uniform_price = $_POST['price'];
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    // Prepare a statement to insert data (recommended for security)
    $stmt = $conn->prepare("INSERT INTO uniform_requests (name, surname, email, gender, upper_size, lower_size, uniform_price, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters (s for string, i for integer, d for double, b for blob)
    $stmt->bind_param("ssssssss", $firstname, $lastname, $email, $gender, $upper_size, $lower_size, $uniform_price, $message);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to a success page or display a success message
        echo "Uniform request submitted successfully!";
    } else {
        // Handle errors if the query fails
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();

    // Close database connection
    $conn->close();
}
?>
