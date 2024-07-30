<?php
include('../database/db.php');

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Start transaction
    $conn->begin_transaction();

    try {
        // Get the user data
        $select_sql = "SELECT * FROM users WHERE id = ?";
        $select_stmt = $conn->prepare($select_sql);
        $select_stmt->bind_param("i", $id);
        $select_stmt->execute();
        $result = $select_stmt->get_result();
        $user_data = $result->fetch_assoc();

        // Insert into departmenthead table
        $insert_sql = "INSERT INTO departmenthead (name, email, course, year_level, status, semester) VALUES (?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ssssss", $user_data['name'], $user_data['email'], $user_data['course'], $user_data['year_level'], $user_data['status'], $user_data['semester']);
        $insert_stmt->execute();

        // Update status in users table
        $update_sql = "UPDATE users SET status = 'Moved to Department Head' WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("i", $id);
        $update_stmt->execute();

        // Commit transaction
        $conn->commit();
        
        echo 'success';
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo 'Error: ' . $e->getMessage();
    }

    $conn->close();
} else {
    echo 'No ID provided';
}
?>