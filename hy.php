<?php

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

// SQL to create the table
$sql = "CREATE TABLE `step_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `notification_type` enum('not_started','step_completed','current_step','registration_completed') NOT NULL,
  `step_number` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Table `step_notifications` created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// Close connection
$conn->close();

?>
