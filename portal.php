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
            overflow-x: hidden;
            display: flex;
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-image: url('assets/image/bluredd.png');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
        }

        .sidebar {
            width: 250px;
            background-color: rgba(255, 255, 255, 0.8);
            height: 100vh;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.collapsed {
            transform: translateX(-250px);
        }

        .toggle-btn {
            position: absolute;
            top: 20px;
            left: 260px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            z-index: 1100;
            transition: left 0.3s ease-in-out;
        }

        .sidebar.collapsed ~ .toggle-btn {
            left: 10px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
            transition: margin-left 0.3s ease-in-out;
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: 0;
        }
    </style>
</head>
<body class="bg-light">
<div class="sidebar">
    <div class="header">
        <img src="assets/image/download.png" alt="Madridejos Community College Logo" width="100" height="80">
        <p>MADRIDEJOS COMMUNITY COLLEGE</p>
    </div>
    <a href="index" class="nav-link"><i class="bi bi-house-door"></i>Home</a>
    <a href="admin/verification" class="nav-link"><i class="bi bi-person-lock"></i>Admin Dashboard</a>
    <a href="guidance/index" class="nav-link"><i class="bi bi-calendar-check"></i> Guidance Office</a>
    
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
<div class="main-content">
  <div class="login-box">
    <h2 id="typewriter-title" class="typewriter-title"></h2>
    <p id="typewriter-subtitle" class="typewriter-subtitle"></p>
  </div>
</div>


<!-- JavaScript for Continuous Typewriter Effect -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const typewriter = (elementId, text, delay = 150, callback = null) => {
      const element = document.getElementById(elementId);
      let index = 0;

      const type = () => {
        if (index < text.length) {
          const character = text.charAt(index);
          element.innerHTML += character === " " ? "&nbsp;" : character; // Ensure spaces are rendered properly
          index++;
          setTimeout(type, delay);
        } else if (callback) {
          // Trigger the next animation when this one finishes
          callback();
        }
      };

      type();
    };

    // Start animations sequentially
    typewriter('typewriter-title', 'Login to View The Dashboard.', 100, () => {
      typewriter('typewriter-subtitle', 'Welcome Administrators.', 150);
    });
  });
</script>



<!-- CSS for Typewriter Effect -->
<style>
  .typewriter-title,
  .typewriter-subtitle {
    font-family: 'Courier New', Courier, monospace;
    white-space: nowrap; /* Prevent wrapping */
    display: inline-block;
    color: #333;
    text-align: justify; /* Adjust alignment for better readability */
  }

  /* Styling for the login box */
  .login-box {
    max-width: 500px;
    margin: 50px auto;
    text-align: center;
    padding: 20px;
    background: #f4f4f4;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden; /* Prevent text from spilling outside */
    resize: vertical; /* Allow box to resize dynamically */
    min-height: 120px; /* Set a minimum height for the box */
  }

  .login-box h2 {
    font-size: 1.8rem;
    margin-bottom: 10px;
    word-break: break-word; /* Ensure long words break properly */
  }

  .login-box p {
    font-size: 1.2rem;
    color: #666;
    word-break: break-word; /* Ensure long words break properly */
  }
</style>

</body>
</html>
