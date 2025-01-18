<?php
$servername = "127.0.0.1"; // Replace with your hosting's DB hostname
$username = "u510162695_mccsystem";
$password = "1Mccsystem";
$dbname = "u510162695_mccsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to delete all records from the users table
$sql = "DELETE FROM users";

if ($conn->query($sql) === TRUE) {
    echo "All records deleted successfully.";
} else {
    echo "Error deleting records: " . $conn->error;
}

$conn->close();
?>
