<?php
session_start();
include '../database/db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_score = null;
if (isset($_SESSION['full_name'])) {
    $full_name = $_SESSION['full_name'];
    $sql = "SELECT score FROM requests WHERE full_name = ? ORDER BY request_date DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $full_name);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $user_score = $row['score'];
        $_SESSION['user_score'] = $user_score;
    }
    $stmt->close();
}
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
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

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
</style>

</head>

<body class="index-page">

  <header id="header" class="header sticky-top">
    <div class="branding d-flex align-items-center">
   
      <div class="container position-relative d-flex align-items-center justify-content-between">
      <nav id="navmenu" class="navmenu d-flex justify-content-center flex-grow-1">
      <ul class="d-flex justify-content-center list-unstyled mb-0">
                    <li><a href="exam.php" class="active">Exam Result</a></li>
                    <li><a href="interview.php" class="nav-link-disabled">Interview w/Head</a></li>
                    <li><a href="enrollreq.php" class="nav-link-disabled">Enrollment Req.</a></li>
                    <li><a href="sscreg.php" class="nav-link-disabled">SSC Registration</a></li>
                    <li><a href="clinic.php"  class="nav-link-disabled">Clinic</a></li>
                    <li><a href="mccea.php" class="nav-link-disabled">Mccea</a></li>
                    <li><a href="cor.php" class="nav-link-disabled">COR</a></li>
                </ul>
      </nav>

        <!-- User Dropdown -->
        <div class="user-dropdown">
          <div class="user-circle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle"></i> <em style="font-size:15px;">Welcome </em>
          </div>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <?php if(isset($_SESSION['full_name'])): ?>
              <li><span class="dropdown-item"><?php echo $_SESSION['full_name']; ?></span></li>
              <li><hr class="dropdown-divider"></li>
            <?php endif; ?>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
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
    <div></div>
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

    window.onload = function() {
        var userScore = <?php echo json_encode($user_score); ?>;
        if (userScore === null) {
            document.querySelectorAll('.nav-link-disabled').forEach(function(link) {
                link.classList.add('disabled');
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                });
            });
        } else {
            document.querySelectorAll('.nav-link-disabled').forEach(function(link) {
                link.classList.remove('disabled');
            });
        }
    };
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

  </body>

</html>