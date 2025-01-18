<?php
// Check if notifications.php is properly configured

// notifications.php
session_start();
include '../database/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit();
}



$user_id = $_SESSION['user_id'];

// Get user's current step status and name
$sql = "SELECT step_status, name, last_step_change FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$notifications = [];

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $step_status = $row['step_status'];
    $student_name = $row['name'];
    $last_step_change = $row['last_step_change'];

    // Define office names for each step
    $offices = [
        1 => 'Guidance Office',
        2 => 'Department Head',
        3 => 'Registrar Office',
        4 => 'SSC Office',
        5 => 'Clinic Office',
        6 => 'MCCEA Office',
        7 => 'COR Office'
    ];

    // Get notifications from the database
    $sql = "SELECT 
                notification_type,
                step_number,
                message,
                created_at,
                is_read,
                TIMESTAMPDIFF(SECOND, created_at, NOW()) as seconds_ago
            FROM step_notifications 
            WHERE user_id = ?
            ORDER BY created_at DESC
            LIMIT 50";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $notif_result = $stmt->get_result();
    
    // Process existing notifications from database
    while ($notif = $notif_result->fetch_assoc()) {
        // Format time ago
        $seconds_ago = $notif['seconds_ago'];
        if ($seconds_ago < 60) {
            $time_ago = "Just now";
        } elseif ($seconds_ago < 3600) {
            $time_ago = floor($seconds_ago / 60) . " minutes ago";
        } elseif ($seconds_ago < 86400) {
            $time_ago = floor($seconds_ago / 3600) . " hours ago";
        } else {
            $time_ago = floor($seconds_ago / 86400) . " days ago";
        }

        $notification = [
            'title' => '',
            'message' => $notif['message'],
            'time_ago' => $time_ago,
            'icon' => '',
            'color' => '',
            'is_read' => $notif['is_read'],
            'timestamp' => $notif['created_at']
        ];

        // Set notification properties based on type
        switch ($notif['notification_type']) {
            case 'not_started':
                $notification['title'] = 'Registration Not Started';
                $notification['icon'] = 'info-circle';
                $notification['color'] = 'blue';
                break;
            case 'step_completed':
                $notification['title'] = 'Step Completed';
                $notification['icon'] = 'check-circle';
                $notification['color'] = 'green';
                break;
            case 'current_step':
                $notification['title'] = 'Current Step';
                $notification['icon'] = 'clock';
                $notification['color'] = 'yellow';
                break;
            case 'registration_completed':
                $notification['title'] = 'Registration Completed';
                $notification['icon'] = 'check-circle';
                $notification['color'] = 'green';
                break;
        }

        $notifications[] = $notification;
    }

    // Check if we need to create new notifications
    $should_create_notification = false;
    if (!isset($_SESSION['last_notification_step'])) {
        $should_create_notification = true;
    } else if ($_SESSION['last_notification_step'] !== $step_status) {
        $should_create_notification = true;
    }

    if ($should_create_notification) {
        // Insert new notification based on current status
        $notification_type = '';
        $step_number = null;
        $message = '';

        if ($step_status === 'not started') {
            $notification_type = 'not_started';
            $message = 'Please proceed to the Guidance Office to start your registration.';
        } else if (strpos($step_status, 'step') !== false) {
            $current_step = intval(substr($step_status, 5));
            
            // Add notification for completed step
            if ($current_step > 1) {
                $sql = "INSERT INTO step_notifications (user_id, notification_type, step_number, message, created_at) 
                        VALUES (?, 'step_completed', ?, ?, NOW())";
                $completed_message = "Step " . ($current_step - 1) . " has been completed successfully.";
                $stmt = $conn->prepare($sql);
                $prev_step = $current_step - 1;
                $stmt->bind_param("iis", $user_id, $prev_step, $completed_message);
                $stmt->execute();
            }
            
            // Add notification for current step
            $notification_type = 'current_step';
            $step_number = $current_step;
            $message = "Please proceed to " . $offices[$current_step] . " for Step " . $current_step;
        } else if ($step_status === 'Completed') {
            $notification_type = 'registration_completed';
            $message = 'All registration steps have been completed successfully.';
        }

        // Insert the new notification
        if ($notification_type) {
            $sql = "INSERT INTO step_notifications (user_id, notification_type, step_number, message, created_at) 
                    VALUES (?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isis", $user_id, $notification_type, $step_number, $message);
            $stmt->execute();
        }

        $_SESSION['last_notification_step'] = $step_status;
        
        // Fetch the newly created notification
        $sql = "SELECT * FROM step_notifications 
                WHERE user_id = ? 
                ORDER BY created_at DESC 
                LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $new_notif = $stmt->get_result()->fetch_assoc();
        
        if ($new_notif) {
            array_unshift($notifications, [
                'title' => ucfirst(str_replace('_', ' ', $new_notif['notification_type'])),
                'message' => $new_notif['message'],
                'time_ago' => 'Just now',
                'icon' => $notification_type === 'registration_completed' ? 'check-circle' : 
                         ($notification_type === 'current_step' ? 'clock' : 'info-circle'),
                'color' => $notification_type === 'registration_completed' ? 'green' : 
                          ($notification_type === 'current_step' ? 'yellow' : 'blue'),
                'is_read' => 0,
                'timestamp' => $new_notif['created_at']
            ]);
        }
    }
}

if (isset($_POST['mark_all_read'])) {
    $user_id = $_SESSION['user_id'];
    
    // Update all unread notifications to read
    $sql = "UPDATE step_notifications 
            SET is_read = 1 
            WHERE user_id = ? AND is_read = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    echo json_encode(['success' => true]);
    exit;
}

echo json_encode($notifications);
$stmt->close();
$conn->close();
?>
