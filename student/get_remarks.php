<?php
session_start();
include '../database/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];
$step_status = 'not started'; // Set a default value

$sql = "SELECT step_status FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $step_status = $row['step_status'];
}

$stmt->close();

$steps = [
    'Step 1', 'Step 2', 'Step 3', 'Step 4', 'Step 5', 'Step 6', 'Step 7'
];

$remarks = [];

foreach ($steps as $index => $step) {
    $step_number = $index + 1;
    $status = "Not Started";
    
    if ($step_status === 'in process') {
        if ($step_number === 1) {
            $status = "In Process";
        }
    } elseif (strpos($step_status, 'step') !== false) {
        $current_step = intval(substr($step_status, 5));
        if ($step_number < $current_step) {
            $status = "Done";
        } elseif ($step_number === $current_step) {
            $status = "In Process";
        }
    } elseif ($step_status === 'Completed') {
        $status = $step_number === count($steps) ? "Completed" : "Done";
    }
    
    $remarks[] = $status;
}

echo json_encode($remarks);
$conn->close();
?>