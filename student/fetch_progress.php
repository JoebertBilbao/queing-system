<?php
session_start();
include '../database/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT step_status FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($step_status);
$stmt->fetch();
$stmt->close();

$steps = [
    ['Step 1', 'Guidance Office'],
    ['Step 2', 'Department Head'],
    ['Step 3', 'Registrar Office'],
    ['Step 4', 'SSC Office'],
    ['Step 5', 'Clinic Office'],
    ['Step 6', 'MCCEA Office'],
    ['Step 7', 'COR Office']
];

$progress_data = [];

foreach ($steps as $index => $step) {
    $step_number = $index + 1;
    $status = "Not Started";
    $status_class = "bg-gray-100 text-gray-800";
    
    if ($step_status === 'in process') {
        if ($step_number === 1) {
            $status = "In Process";
            $status_class = "bg-blue-100 text-blue-800";
        }
    } elseif (strpos($step_status, 'step') !== false) {
        $current_step = intval(substr($step_status, 5));
        if ($step_number < $current_step) {
            $status = "Done";
            $status_class = "bg-green-100 text-green-800";
        } elseif ($step_number === $current_step) {
            $status = "In Process";
            $status_class = "bg-blue-100 text-blue-800";
        }
    } elseif ($step_status === 'Completed') {
        $status = "Completed";
        $status_class = "bg-green-100 text-green-800";
    }
    
    $progress_data[] = [
        'step' => $step[0],
        'office' => $step[1],
        'status' => $status,
        'status_class' => $status_class
    ];
}

echo json_encode([
    'progress' => $progress_data,
    'step_status' => $step_status
]);
?>