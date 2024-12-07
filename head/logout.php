<?php
session_start();
session_destroy();
header("Location: ../head/index"); // Redirect to login page after logout
?>