<?php
session_start();
include '../database/db.php';

function validateSessionFromDatabase($session_id) {
    global $conn;
    $sql = "SELECT user_id FROM user_sessions WHERE session_id = ? AND expires > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $session_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

function getUserFullName($user_id) {
    global $conn;
    $sql = "SELECT name FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['name'];
    }
    return null;
}

function getUserIdFromSession($session_id) {
    global $conn;
    $sql = "SELECT user_id FROM user_sessions WHERE session_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $session_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['user_id'];
    }
    return null;
}

if (!isset($_SESSION['user_id']) || isset($_GET['validate_session'])) {
    if (isset($_COOKIE['user_session'])) {
        $session_id = $_COOKIE['user_session'];
        if (validateSessionFromDatabase($session_id)) {
            $_SESSION['user_id'] = getUserIdFromSession($session_id);
            $_SESSION['full_name'] = getUserFullName($_SESSION['user_id']);
        } else {
            header('Location: ../login.php');
            exit();
        }
    } else {
        header('Location: ../login.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student | Registration Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
</head>
<style>
 .notification-wrapper {
    position: relative;
}

.notification-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
}

.notification-panel {
    display: none;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

/* Show panel when active */
.notification-panel[x-show="openNotif"] {
    display: block;
}

.notification-overlay[x-show="openNotif"] {
    display: block;
}

.notification-header {
    padding: 1rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.notification-content {
    overflow-y: auto;
    padding: 0.5rem 0;
}

/* Mobile styles */
@media (max-width: 768px) {
    .notification-panel {
        position: fixed !important;
        left: 50% !important;
        top: 50% !important;
        transform: translate(-50%, -50%) !important;
        width: 90% !important;
        max-width: 380px !important;
        margin: 0 !important;
    }
    
    .notification-content {
        max-height: 60vh;
    }
}

/* Desktop styles */
@media (min-width: 769px) {
    .notification-panel {
        position: absolute;
        right: 0;
        top: 100%;
        transform: none;
        width: 384px;
        margin-top: 0.5rem;
    }
    
    .notification-overlay {
        display: none !important;
    }
}

/* Custom scrollbar */
.notification-content::-webkit-scrollbar {
    width: 6px;
}

.notification-content::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.notification-content::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

.notification-content::-webkit-scrollbar-thumb:hover {
    background: #555;
}


</style>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white shadow-md">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <img src="../assets/image/download.png" alt="School Logo" class="h-10 w-10 object-contain">
                    <div class="text-xl font-bold text-gray-800">Student Portal</div>
                </div>
                <div class="flex items-center space-x-4">
                <div class="notification-wrapper" x-data="{ openNotif: false }">
    <button @click="openNotif = !openNotif" class="relative text-gray-700 hover:text-gray-900">
        <i class="fas fa-bell text-xl"></i>
        <span class="notification-badge absolute -top-1 -right-1 h-4 w-4 bg-red-500 rounded-full flex items-center justify-center text-xs text-white">0</span>
    </button>
    
    <!-- Overlay -->
    <div x-show="openNotif" @click="openNotif = false" class="notification-overlay"></div>
    
    <!-- Panel -->
    <div x-show="openNotif" @click.away="openNotif = false" class="notification-panel">
        <div class="notification-header">
            <h3 class="text-lg font-semibold text-gray-700">Notifications</h3>
            <button @click="openNotif = false" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="notification-container" class="notification-content">
            <!-- Notifications will be inserted here -->
        </div>
    </div>
</div>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                            <i class="fas fa-user-circle text-2xl"></i>
                            <span class="text-sm font-medium"><?php echo $_SESSION['full_name']; ?></span>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                            <div class="px-4 py-2 text-sm text-gray-700"><?php echo $_SESSION['full_name']; ?></div>
                            <hr class="my-1">
                            <a href="logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Registration Progress</h2>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Steps</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Office</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="progress-table-body">
                        <!-- Progress data will be loaded dynamically -->
                    </tbody>
                </table>
            </div>

            <div class="mt-8" id="status-container">
                <!-- Status message will be loaded dynamically -->
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.8.2/alpine.js"></script>
    <script>
        // Global variables to track last update timestamps
        let lastNotificationUpdate = 0;
        let lastProgressUpdate = 0;
        let isInitialLoad = true;

        // Session validation
        function validateSession() {
            fetch('index.php?validate_session=1')
                .then(response => {
                    if (!response.ok) {
                        window.location.href = '../login.php';
                    }
                });
        }

        // Prevent back button
        function preventBack() {
            window.history.forward();
        }

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            // Initial fetches
            fetchStepNotifications(true);
            fetchProgress(true);
            
            // Set up polling
            setInterval(() => fetchStepNotifications(false), 3000);
            setInterval(() => fetchProgress(false), 3000);
            setInterval(validateSession, 300000);
            
            setTimeout(preventBack, 0);
        });

        async function fetchStepNotifications(isInitial) {
            try {
                const response = await fetch('notifications.php');
                if (!response.ok) throw new Error('Network response was not ok');
                
                const data = await response.json();
                if (data.error) throw new Error(data.error);
                
                // Check if there are actually new notifications
                const latestTimestamp = data.length > 0 ? new Date(data[0].timestamp).getTime() : 0;
                if (!isInitial && latestTimestamp <= lastNotificationUpdate) return;
                
                lastNotificationUpdate = latestTimestamp;
                updateNotificationUI(data);
            } catch (error) {
                console.error('Error fetching notifications:', error);
            }
        }

        async function fetchProgress(isInitial) {
            try {
                const response = await fetch('fetch_progress.php');
                if (!response.ok) throw new Error('Network response was not ok');
                
                const data = await response.json();
                if (data.error) throw new Error(data.error);
                
                // Check if there are actual changes in the progress
                const progressHash = JSON.stringify(data);
                if (!isInitial && progressHash === lastProgressUpdate) return;
                
                lastProgressUpdate = progressHash;
                updateProgressUI(data);
            } catch (error) {
                console.error('Error fetching progress:', error);
            }
        }

        function updateNotificationUI(notifications) {
            const container = document.getElementById('notification-container');
            const badge = document.querySelector('.notification-badge');
            
            if (!notifications.length) {
                container.innerHTML = `
                    <div class="px-4 py-3 text-sm text-gray-500">
                        No new notifications
                    </div>`;
                badge.textContent = '0';
                return;
            }

            container.innerHTML = notifications.map(notification => `
                <a href="#" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-${notification.icon} text-${notification.color}-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">${notification.title}</p>
                            <p class="text-sm text-gray-500">${notification.message}</p>
                            <p class="text-xs text-gray-400 mt-1">${notification.time_ago}</p>
                        </div>
                    </div>
                </a>
            `).join('');
            
            badge.textContent = notifications.length;
        }

        function updateProgressUI(data) {
            // Update progress table
            const tbody = document.getElementById('progress-table-body');
            tbody.innerHTML = data.progress.map(step => `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${step.step}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${step.office}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${step.status_class}">
                            ${step.status}
                        </span>
                    </td>
                </tr>
            `).join('');

            // Update status message
            const statusContainer = document.getElementById('status-container');
            statusContainer.innerHTML = data.step_status === 'Completed' 
                ? `<div class="bg-green-100 border-l-4 border-green-500 p-4 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-green-800">Congratulations!</h3>
                            <p class="text-green-700">You're now officially enrolled!</p>
                        </div>
                    </div>
                   </div>`
                : `<div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-yellow-500"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-yellow-800">Registration In Progress</h3>
                            <p class="text-yellow-700">Please complete all steps to finalize your enrollment.</p>
                        </div>
                    </div>
                   </div>`;
        }

        window.onunload = function() { null };

        document.addEventListener('DOMContentLoaded', function() {
    // Get references to notification elements
    const notificationButton = document.querySelector('[x-data="{ openNotif: false }"]');
    const notificationBadge = document.querySelector('.notification-badge');
    
    // Add click handler for notification button
    notificationButton.addEventListener('click', async function(e) {
        // Only proceed if clicking the button itself or the bell icon
        if (e.target.closest('button')) {
            try {
                // Send request to mark all notifications as read
                const response = await fetch('notifications.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'mark_all_read=1'
                });

                if (!response.ok) throw new Error('Network response was not ok');
                
                // Update the badge to show 0
                notificationBadge.textContent = '0';
                
                // Update the notification list UI to show all as read
                const notifications = document.querySelectorAll('#notification-container > div');
                notifications.forEach(notification => {
                    notification.classList.remove('bg-blue-50');
                    const titleElement = notification.querySelector('.font-bold');
                    if (titleElement) {
                        titleElement.classList.remove('font-bold');
                    }
                });
                
            } catch (error) {
                console.error('Error marking notifications as read:', error);
            }
        }
    });
});

function updateNotificationUI(notifications) {
    const container = document.getElementById('notification-container');
    const badge = document.querySelector('.notification-badge');
    const notificationPanel = document.querySelector('.notification-panel');
    
    if (!notifications.length) {
        container.innerHTML = `
            <div class="px-4 py-3 text-sm text-gray-500">
                No notifications
            </div>`;
        badge.textContent = '0';
        return;
    }

    // Count unread notifications
    const unreadCount = notifications.filter(n => !n.is_read).length;
    badge.textContent = unreadCount;
    
    // Show only the latest notification initially
    container.innerHTML = `
        <div class="px-4 py-3 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-700">Notifications</h3>
        </div>
        <div class="notification-preview">
            <div class="block px-4 py-3 hover:bg-gray-50 cursor-pointer ${!notifications[0].is_read ? 'bg-blue-50' : ''}"
                 data-notification-id="${notifications[0].id}">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-${notifications[0].icon} text-${notifications[0].color}-500"></i>
                    </div>
                    <div class="ml-3 flex-grow">
                        <p class="text-sm font-medium text-gray-900 ${!notifications[0].is_read ? 'font-bold' : ''}">${notifications[0].title}</p>
                        <p class="text-sm text-gray-500">${notifications[0].message}</p>
                        <p class="text-xs text-gray-400 mt-1">${notifications[0].time_ago}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 py-2 border-t border-gray-100">
            <button class="text-sm text-blue-600 hover:text-blue-800 w-full text-left" id="view-all-notifications">
                View all notifications
            </button>
        </div>
        <div class="all-notifications hidden">
            ${notifications.map(notification => `
                <div class="block px-4 py-3 hover:bg-gray-50 border-t border-gray-100 ${!notification.is_read ? 'bg-blue-50' : ''}"
                     data-notification-id="${notification.id}">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-${notification.icon} text-${notification.color}-500"></i>
                        </div>
                        <div class="ml-3 flex-grow">
                            <p class="text-sm font-medium text-gray-900 ${!notification.is_read ? 'font-bold' : ''}">${notification.title}</p>
                            <p class="text-sm text-gray-500">${notification.message}</p>
                            <p class="text-xs text-gray-400 mt-1">${notification.time_ago}</p>
                        </div>
                    </div>
                </div>
            `).join('')}
        </div>`;

    // Add click handler for "View all notifications"
    const viewAllButton = document.getElementById('view-all-notifications');
    const allNotifications = container.querySelector('.all-notifications');
    const notificationPreview = container.querySelector('.notification-preview');
    
    viewAllButton.addEventListener('click', function() {
        notificationPreview.classList.add('hidden');
        allNotifications.classList.remove('hidden');
        viewAllButton.innerHTML = 'Show less';
        
        // Toggle between view all and show less
        if (viewAllButton.getAttribute('data-expanded') === 'true') {
            notificationPreview.classList.remove('hidden');
            allNotifications.classList.add('hidden');
            viewAllButton.innerHTML = 'View all notifications';
            viewAllButton.setAttribute('data-expanded', 'false');
        } else {
            viewAllButton.setAttribute('data-expanded', 'true');
        }
    });
}

// Update the notification panel style in your header HTML
document.querySelector('.relative[x-data="{ openNotif: false }"]').innerHTML = `
    <button @click="openNotif = !openNotif" class="relative text-gray-700 hover:text-gray-900">
        <i class="fas fa-bell text-xl"></i>
        <span class="notification-badge absolute -top-1 -right-1 h-4 w-4 bg-red-500 rounded-full flex items-center justify-center text-xs text-white">0</span>
    </button>
    <div x-show="openNotif" @click.away="openNotif = false" 
         class="absolute right-0 mt-2 w-96 bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden">
        <div id="notification-container" class="max-h-[calc(100vh-200px)] overflow-y-auto">
            <!-- Notifications will be inserted here -->
        </div>
    </div>
`;
    </script>
</body>
</html>
