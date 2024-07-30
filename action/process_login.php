<?php
session_start();
require '../database/db.php';

function generateUniqueSessionId() {
    return bin2hex(random_bytes(16));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, name, email, password, course, step_status FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $email, $hashed_password, $course, $step_status);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Check if this is the first login
            if ($step_status === 'not started') {
                // Update step status for Step 1 to 'in process'
                $update_sql = "UPDATE users SET step_status = 'in process' WHERE id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("i", $id);
                $update_stmt->execute();
                $update_stmt->close();
            }

            $_SESSION['full_name'] = $name;
            $_SESSION['course'] = $course;
            $_SESSION['user_id'] = $id;

            // Generate and store session
            $session_id = generateUniqueSessionId();
            $expires = date('Y-m-d H:i:s', time() + (86400 * 30)); // 30 days from now

            $session_sql = "INSERT INTO user_sessions (session_id, user_id, expires) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE session_id = VALUES(session_id), expires = VALUES(expires)";
            $session_stmt = $conn->prepare($session_sql);
            $session_stmt->bind_param("sis", $session_id, $id, $expires);
            $session_stmt->execute();
            $session_stmt->close();

            // Set cookie
            setcookie('user_session', $session_id, time() + (86400 * 30), "/", "", true, true);

            echo "<script>
            window.location.href = '../student/index.php';
            </script>";
            exit;
        } else {
            echo "<script>
            alert('Invalid password. Please try again.');
            window.location.href = '../login.php';
            </script>";
        }
    } else {
        echo "<script> 
        alert('No user found with this email.');
        window.location.href = '../login.php'; 
        </script> ";
    }

    $stmt->close();
    $conn->close();
}
?>