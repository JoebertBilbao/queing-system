<?php
include('../database/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Validate the ID
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        echo 'Invalid ID';
        exit();
    }

    // Select student data
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();

        // Move student data to another table (e.g., `moved_students`)
        $sql = "INSERT INTO moved_students (name, email, course, year_level, status, semester) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $student['name'], $student['email'], $student['course'], $student['year_level'], $student['status'], $student['semester']);
        $stmt->execute();

        // Delete student data from the original table
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo 'Student data moved successfully';
    } else {
        echo 'Student not found';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'Invalid request';
}
?>
