<?php

$servername = "127.0.0.1";
$username = "u510162695_mccsystem";
$password = "1Mccsystem";
$dbname = "u510162695_mccsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>