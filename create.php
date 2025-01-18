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

// SQL query to drop the users table if it exists
$dropTableSql = "DROP TABLE IF EXISTS `users`";
$conn->query($dropTableSql); // Drop the table

// SQL query to create the users table
$sql = "
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `year_level` enum('1st_year','2nd_year','3rd_year','4th_year') NOT NULL,
  `status` enum('new_student','transferee') NOT NULL,
  `semester` enum('1st_semester','2nd_semester') NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `course` enum('bsit','bshm','bsba','bsed','beed') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `step_status` varchar(255) DEFAULT 'not started',
  `verification_code` varchar(100) NOT NULL,
  `code` varchar(250) NOT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `terms_accepted` tinyint(4) NOT NULL,
  `last_step_change` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

// Execute the query to create the table
if ($conn->query($sql) === TRUE) {
    echo "Table 'users' created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
