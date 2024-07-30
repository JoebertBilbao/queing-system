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

$user_id = $_SESSION['user_id'];
$sql = "SELECT step_status FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($step_status);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Student | Registration Form</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/images.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <style>
  .navmenu ul {
    margin-bottom: 0;
    padding: 0;
    list-style: none;
  }

  .navmenu ul li {
    margin: 0 10px;
  }

  .user-dropdown {
    position: relative;
  }

  .user-circle {
    cursor: pointer;
    font-size: 24px;
  }

  .dropdown-menu {
    min-width: 120px;
  }

  @media (max-width: 768px) {
    .navmenu {
      display: none;
      position: absolute;
      top: 60px; /* Adjust based on your header height */
      left: 0;
      right: 0;
      background: #fff;
      flex-direction: column;
      align-items: center;
      z-index: 1000;
    }

    .navmenu.active {
      display: flex;
    }

    .navmenu ul {
      flex-direction: column;
      width: 100%;
    }

    .navmenu ul li {
      margin: 10px 0;
      width: 100%;
      text-align: center;
    }

    .navmenu ul li a {
      display: block;
      width: 100%;
      padding: 10px;
    }

    /* Hide the preloader in mobile view */
    #preloader {
      display: none;
    }
  }

  /* Additional CSS for the table */
  .student-portal {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      margin-top: 50px;
    }

    .student-portal table {
      border-collapse: collapse;
      width: 80%;
      max-width: 800px;
      margin: 0 auto;
      font-family: 'Montserrat', sans-serif; /* Change font family */
      border: 1px solid #ddd; /* Add border */
      border-radius: 8px; /* Add border radius for styling */
      overflow: hidden; /* Hide overflow to prevent shadow overlap */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
    }

    .student-portal th, .student-portal td {
      border: 1px solid #ddd;
      padding: 10px; /* Increase padding for better spacing */
      text-align: center;
    }

    .student-portal th {
      background-color: #6c757d; /* Change background color for table head */
      color: #fff; /* Change text color for table head */
      font-weight: bold;
    }

    .student-portal h2 {
      margin-bottom: 20px;
      font-family: 'Roboto', sans-serif; /* Change font family for headings */
    }
  </style>
  
</head>

<body class="index-page">

  <header id="header" class="header sticky-top">
    <div class="branding d-flex align-items-center">
      <div class="container position-relative d-flex align-items-center justify-content-between">
        <!-- User Dropdown -->
        <div class="user-dropdown ms-auto">
          <div class="user-circle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle"></i> <em style="font-size:15px;"><?php echo $_SESSION['full_name']; ?> </em>
          </div>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <?php if(isset($_SESSION['full_name'])): ?>
              <li><span class="dropdown-item"><?php echo $_SESSION['full_name']; ?></span></li>
              <li><hr class="dropdown-divider"></li>
            <?php endif; ?>
            <li><a class="dropdown-item text-right" href="logout.php">Logout</a></li>
          </ul>
        </div>

        <!-- Mobile Nav Toggle Button -->
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </div>
    </div>
  </header>

  <div id="preloader">
    <div></div>
    <div></div>
    <div></div>
  </div>

  <!-- Student Portal Table -->
  <div class="student-portal">
    <h2>Student Portal</h2>
    <table>
      <thead>
        <tr>
          <th>Steps</th>
          <th>Office</th>
          <th>Remarks</th>
        </tr>
      </thead>
      <tbody>
            <?php
            $steps = [
                ['Step 1', 'Guidance Office'],
                ['Step 2', 'Department Head'],
                ['Step 3', 'Registrar Office'],
                ['Step 4', 'SSC Office'],
                ['Step 5', 'Clinic Office'],
                ['Step 6', 'MCCEA Office'],
                ['Step 7', 'COR Office']
            ];

            $status_labels = [
                'not started' => 'Not Started',
                'in process' => 'In Process',
                'step 2' => 'Step 2',
                'step 3' => 'Step 3',
                'step 4' => 'Step 4',
                'step 5' => 'Step 5',
                'step 6' => 'Step 6',
                'step 7' => 'Step 7',
                'Completed' => 'Completed'
            ];

            foreach ($steps as $index => $step) {
              $step_number = $index + 1;
              $status = "Not Started";
              
              if ($step_status === 'in process') {
                if ($step_number === 1) {
                  $status = "In Process";
                }
              } elseif (strpos($step_status, 'step') !== false) {
                $current_step = intval(substr($step_status, 5));
                if ($step_number < $current_step) {
                  $status = "Done";
                } elseif ($step_number === $current_step) {
                  $status = "In Process";
                }
              } elseif ($step_status === 'Completed') {
                if ($step_number === count($steps)) {
                  $status = "Completed";
                } else {
                  $status = "Done";
                }
              }
            
              echo "<tr>";
              echo "<td>{$step[0]}</td>";
              echo "<td>{$step[1]}</td>";
              echo "<td>{$status}</td>";
              echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
$lastStepStatus = "";
foreach ($steps as $index => $step) {
    if ($index == count($steps) - 1) {
        $step_number = $index + 1;
        if ($step_status === 'Completed') {
            $lastStepStatus = "Completed";
        }
    }
}

if ($lastStepStatus === "Completed") {
    echo '<div class="alert alert-info text-center mt-5" role="alert">
            <h4 class="alert-heading">Congratulations!</h4>
            <p class="mb-0">You\'re Enrolled now!</p>
          </div>';
} else {
    echo '<div class="alert alert-warning text-center mt-5" role="alert">
            <h4 class="alert-heading">Registration In Progress</h4>
            <p class="mb-0">Please complete all steps to finalize your enrollment.</p>
          </div>';
}
?>
  </div>

  <script>
    document.querySelector('.mobile-nav-toggle').addEventListener('click', function() {
        document.querySelector('.navmenu').classList.toggle('active');
    });

    document.querySelectorAll('.navmenu a').forEach(function(link) {
        link.addEventListener('click', function() {
            document.querySelector('.navmenu').classList.remove('active');
        });
    });

    function validateSession() {
            fetch('index.php?validate_session=1')
                .then(response => {
                    if (!response.ok) {
                        window.location.href = '../login.php';
                    }
                });
        }

        // Check session every 5 minutes
        setInterval(validateSession, 300000);
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <script type="text/javascript">
        function preventBack(){
            window.history.forward()
        }; setTimeout("preventBack()",0);
        window.onunload=function(){null;}
        </script>

<script>
        (function (global) {
            if (typeof (global) === "undefined") {
                throw new Error("window is undefined");
            }
            var _hash = "!";
            var noBackPlease = function () {
                global.location.href += "#";
                global.setTimeout(function () {
                    global.location.href += "!";
                }, 50);
            };
            global.onhashchange = function () {
                if (global.location.hash !== _hash) {
                    global.location.hash = _hash;
                }
            };
            global.onload = function () {
                noBackPlease();
                document.body.onkeydown = function (e) {
                    var elm = e.target.nodeName.toLowerCase();
                    if (e.which === 8 && (elm !== 'input' && elm !== 'textarea')) {
                        e.preventDefault();
                    }
                    e.stopPropagation();
                };
            };
        })(window);
    </script>

  </body>

</html>
