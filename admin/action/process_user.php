<?php
include('../../database/db.php');

// Function to sanitize user input
function sanitize_input($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $name = sanitize_input($_POST['name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    try {
        switch ($action) {
            case 'add':
                // Add user logic
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO admin (name, email, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $name, $email, $hashed_password);
                break;
            
            case 'edit':
                // Edit user logic
                if (!empty($password)) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE admin SET name = ?, email = ?, password = ? WHERE id = ?");
                    $stmt->bind_param("sssi", $name, $email, $hashed_password, $id);
                } else {
                    $stmt = $conn->prepare("UPDATE admin SET name = ?, email = ? WHERE id = ?");
                    $stmt->bind_param("ssi", $name, $email, $id);
                }
                break;
            
            case 'delete':
                // Delete user logic
                $stmt = $conn->prepare("DELETE FROM admin WHERE id = ?");
                $stmt->bind_param("i", $id);
                break;
            
            default:
                throw new Exception("Invalid action");
        }

        if (!$stmt->execute()) {
            // Database error
            throw new Exception($stmt->error);
        }
        $stmt->close();
    } catch (Exception $e) {
        // Log the error (you may want to implement proper error logging)
        error_log("Error in process_user.php: " . $e->getMessage());
    }
} 

$conn->close();

// Redirect to manage-user.php regardless of the outcome
header("Location: ../manage-user.php");
exit();
?>