<?php
// Database connection parameters
$servername = "localhost";
$username = "u510162695_mccsystem";
$password = "1Mccsystem";
$dbname = "u510162695_mccsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to delete all records in the users table
$sql = "DELETE FROM users";

if ($conn->query($sql) === TRUE) {
    echo "All records deleted successfully from the users table.";
} else {
    echo "Error deleting records: " . $conn->error;
}

// Close connection
$conn->close();
?>
