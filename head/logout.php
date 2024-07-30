<?php
session_start();
session_destroy();
header("Location: ../head/index.php"); // Redirect to login page after logout
?>