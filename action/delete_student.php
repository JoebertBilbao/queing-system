<?php
include_once('../database/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM transactions WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                window.location.href = '../studentdash/transaction.php';
              </script>";
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "No ID specified";
    exit;
}

$conn->close();
?>