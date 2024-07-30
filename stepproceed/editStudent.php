<?php
include('../database/db.php');

$id = $_POST['id'];
$newCourse = $_POST['course'];

// Fetch the old course from the database
$sql = "SELECT course FROM departmenthead WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    echo 'Student not found';
    exit;
}

$oldCourse = $student['course'];

// Update the student's course
$sql = "UPDATE departmenthead SET course = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $newCourse, $id);
if ($stmt->execute()) {
    // Remove from old course table if needed and add to new course table
    // Example: Move the student to the new department

    // Insert logic to move student to the new department if necessary
    // This could include removing from old department table and adding to new one

    echo 'success';
} else {
    echo 'Error updating course';
}

$stmt->close();
$conn->close();
?>
