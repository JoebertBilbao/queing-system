<?php
session_start();
require '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = intval($_POST['id']); // Ensure the student ID is an integer

    // Fetch the current step status
    $sql = "SELECT step_status FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentStatus = $row['step_status'];

        // Define the step progression sequence
        $stepSequence = [
            'not started' => 'in process',
            'in process' => 'step 2',
            'step 2' => 'step 3',
            'step 3' => 'step 4',
            'step 4' => 'step 5',
            'step 5' => 'step 6',
            'step 6' => 'step 7',
            'step 7' => 'Completed',
            'Completed' => 'Completed'
        ];

        // Determine the next step status
        $nextStatus = $stepSequence[$currentStatus] ?? 'Completed'; // Default to 'Completed' if current status is not in the sequence

        // Update the step status
        $updateSql = "UPDATE users SET step_status = ? WHERE id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("si", $nextStatus, $studentId);

        if ($stmt->execute()) {
            $response = array('status' => 'success');
        } else {
            $response = array('status' => 'error', 'message' => $stmt->error);
        }

        $stmt->close();
    } else {
        $response = array('status' => 'error', 'message' => 'Student not found');
    }

    $conn->close();
    echo json_encode($response);
}
?>
