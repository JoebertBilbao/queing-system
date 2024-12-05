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

// SQL to drop table if it exists
$sql = "DROP TABLE IF EXISTS `users`";

// Execute query with error handling
try {
    if ($conn->query($sql) === TRUE) {
        echo "Table 'users' dropped successfully";
    } else {
        echo "Error dropping table: " . $conn->error;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn->close();
?>
