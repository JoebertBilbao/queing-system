<?php
session_start(); // Start session to access session variables

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page or any other page after logout
header("Location: ../guidance/index");
exit;
?>

