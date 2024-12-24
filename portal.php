<?php

session_start();
require_once 'database/db.php';

function isStepReached($step) {
    global $conn;

    // Define the step progression sequence with numeric rankings
    $stepOrder = [
        'in process' => 1,
        'step 2' => 2,
        'step 3' => 3,
        'step 4' => 4,
        'step 5' => 5,
        'step 6' => 6,
        'step 7' => 7,
        'Completed' => 8,
    ];

    // Check if the step is valid
    if (!isset($stepOrder[$step])) {
        return false; // Invalid step
    }

    // Get the numeric ranking of the required step
    $requiredRank = $stepOrder[$step];

    // Query to check if any student has reached or surpassed the given step
    $sql = "SELECT COUNT(*) AS step_count 
            FROM users 
            WHERE step_status IN (
                SELECT step_status 
                FROM users 
                WHERE FIND_IN_SET(step_status, ?) > 0
            )";
    
    $stepsToCheck = implode(',', array_keys(array_filter($stepOrder, function ($rank) use ($requiredRank) {
        return $rank >= $requiredRank; // Include all steps up to and beyond the current one
    })));

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $stepsToCheck);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['step_count'] > 0; // Return true if at least one student qualifies
    }

    return false;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PORTALS</title>
    <link href="assets/image/images.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    
    <!-- Fonts and Vendor CSS Files -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    
    <style>
        @media (max-width: 768px) {
  .sidebar {
    width: 100%; /* Full width for small screens */
    height: auto;
    position: relative; /* Allow flow with other content */
  }

  .main-content {
    margin-left: 0; /* Remove the sidebar's margin */
    padding: 10px;
  }
}
@media (max-width: 768px) {
  .login-box {
    max-width: 90%; /* Allow more flexibility in width */
    padding: 15px;
  }

  .typewriter-title, .typewriter-subtitle {
    font-size: 1.2rem; /* Reduce font size for smaller screens */
    text-align: center; /* Center text for better readability */
  }
}
body {
  overflow-x: hidden; /* Disable horizontal scrolling */
}

html, body {
  max-width: 100%; /* Prevent overscrolling */
}


body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: rgba(255, 255, 255, 0.9);
            height: 100vh;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            transition: transform 0.3s ease-in-out;
            z-index: 1000;
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        .sidebar .header {
            text-align: center;
            padding: 20px 10px;
            border-bottom: 1px solid #ddd;
        }

        .sidebar .header img {
            max-width: 100px;
            height: auto;
        }

        .sidebar .nav-link {
            display: block;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background-color: #f1f1f1;
        }

        .sidebar .dropdown-menu {
            display: none;
            flex-direction: column;
            padding-left: 15px;
        }

        .sidebar .dropdown-menu.show {
            display: flex;
        }

.main-content {
    margin-left: 250px; /* Match the width of the sidebar */
    padding: 20px;
    flex: 1;
    overflow-y: auto; /* Ensure content is scrollable if necessary */
    display: flex;
    justify-content: center;
    align-items: center; /* Center content vertically */
    height: calc(100vh - 40px); /* Full viewport height minus header height */
}

.header {
    text-align: center;
    margin-bottom: 40px;
    padding: 20px 0;
    background-color: transparent;
}

.header img {
    max-width: 100%;
    margin-bottom: 10px;
    opacity: 0.8;
}

.header p {
    margin: 0;
}

.charts-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.chart-container {
    width: 100%;
    height: 400px;
}

.chart-right {
    grid-column: 2;
}

.login-box {
    background-color: rgba(255, 255, 255, 0.9); /* Slight transparency for the box */
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    padding: 20px;
    text-align: center;
    max-width: 400px; /* Limit the width of the box */
    width: 100%;
}

.login-box h2 {
    color: rgba(0, 0, 0, 0.7); /* Semi-transparent text */
    margin-bottom: 20px;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3); /* Optional shadow for better readability */
}

.login-box input {
    width: calc(100% - 20px);
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.login-box button {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    background-color: #007bff;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
}

.login-box button:hover {
    background-color: #0056b3;
}
    </style>
</head>
<button class="toggle-btn" id="toggleSidebar">☰</button>
    <div class="sidebar" id="sidebar">
        <div class="header">
            <img src="assets/image/download.png" alt="Madridejos Community College Logo">
            <p>MADRIDEJOS COMMUNITY COLLEGE</p>
        </div>
        <a href="index" class="nav-link"><i class="bi bi-house-door"></i> Home</a>
        <a href="admin/verification" class="nav-link"><i class="bi bi-person-lock"></i> Admin Dashboard</a>
        <a href="#guidance" class="nav-link dropdown-toggle" onclick="toggleDropdown('guidanceMenu')">
            <i class="bi bi-calendar-check"></i> Offices
        </a>
        <div class="dropdown-menu" id="guidanceMenu">
            <?php if (isStepReached('step 2')): ?>
                <a href="head/index" class="nav-link"><i class="bi bi-person-circle"></i> Department Head</a>
            <?php endif; ?>
            <?php if (isStepReached('step 3')): ?>
                <a href="registrar/index" class="nav-link"><i class="bi bi-file-earmark-text"></i> Registrar Office</a>
            <?php endif; ?>
            <?php if (isStepReached('step 4')): ?>
                <a href="ssc/index" class="nav-link"><i class="bi bi-clipboard-data"></i> SSC Office</a>
            <?php endif; ?>
            <?php if (isStepReached('step 5')): ?>
                <a href="clinic/index" class="nav-link"><i class="bi bi-heart"></i> Clinic Office</a>
            <?php endif; ?>
            <?php if (isStepReached('step 6')): ?>
                <a href="mccea/index" class="nav-link"><i class="bi bi-gear"></i> MCCEA Office</a>
            <?php endif; ?>
            <?php if (isStepReached('step 7')): ?>
                <a href="cor/index" class="nav-link"><i class="bi bi-file-earmark-code"></i> COR</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="main-content" id="mainContent">
        <div class="login-box">
            <h2 id="typewriter-title" class="typewriter-title"></h2>
            <p id="typewriter-subtitle" class="typewriter-subtitle"></p>
        </div>
    </div>
    <script>
        // Toggle sidebar visibility
        document.getElementById('toggleSidebar').addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            sidebar.classList.toggle('hidden');
            mainContent.classList.toggle('expanded');
        });

        // Toggle dropdown menu
        function toggleDropdown(menuId) {
            const menu = document.getElementById(menuId);
            menu.classList.toggle('show');
        }
    </script>

    <script>
        // Toggle sidebar visibility
        document.getElementById('toggleSidebar').addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            sidebar.classList.toggle('hidden');
            mainContent.classList.toggle('expanded');
        });

        // Toggle dropdown menu
        function toggleDropdown(menuId) {
            const menu = document.getElementById(menuId);
            menu.classList.toggle('show');
        }
    </script>

</body>
</html>
