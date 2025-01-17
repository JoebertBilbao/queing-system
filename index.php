<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>MCC QUEUING SYSTEM</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">


  <!-- Favicons -->
  <link href="assets/image/images.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <!-- Add this in your styles -->
<style>
  html, body {
        overflow-x: hidden;
        max-width: 100%;
        position: relative;
        touch-action: pan-y;
    }

    @media (max-width: 768px) {
        #hero .hero-img img {
            width: 100%;
            height: auto;
        }

        #hero .btn-get-started {
            font-size: 14px;
            padding: 8px 16px;
        }

        .sitename {
            font-size: 20px;
        }

        .typewriter-title, .typewriter-subtitle {
            font-size: 1.5rem;
        }
    }

  /* Add background to the Hero Section */
  #hero {
    background-image: url('assets/image/mccback.jpg'); /* Replace with the path to your background image */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    padding: 90px 0; /* Adjust padding as needed for your design */
    position: relative;
  }

  /* Optional: Add a dark overlay to make text more readable */
  #hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5); /* Dark overlay (adjust opacity as needed) */
    z-index: -1; /* Ensure overlay is behind the content */
  }

  /* Ensure text and other content are visible above the background */
  .hero .container {
    position: relative;
    z-index: 1;
  }

  /* Optional: Adjust hero section text size for better readability */
  #hero h1 {
    color: white; /* Change text color for contrast */
  }
  #hero p {
    color: white; /* Change text color for contrast */
  }
  /* Styling for the Hero Section */
#hero {
    background-color: #f4f4f4; /* Adjust background color to your choice */
}

/* Make the icon bigger */
.icon-image {
    width: 500px; /* Adjust the width to make the icon bigger */
    height: 500px; /* Adjust the height */
}
<div class="container">
  <div class="row gy-4">
    <!-- Text Content -->
    <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
      <h1 id="typewriter-title" class="typewriter-title"></h1>
      <p id="typewriter-subtitle" class="typewriter-subtitle"></p>
      <div class="d-flex gap-3">
        <a href="portal" class="btn-get-started btn btn-primary btn-lg">Admin Portal</a>
        <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" 
           class="glightbox btn-watch-video btn btn-outline-secondary btn-lg d-flex align-items-center" 
           target="_blank" rel="noopener noreferrer">
          <span class="me-2">Watch Video</span>
          <i class="bi bi-play-circle"></i>
        </a>
      </div>
    </div>
    <!-- Image Content -->
    <div class="col-lg-6 order-1 order-lg-2 hero-img">
      <div class="icon-container text-center">
        <img src="assets/image/logo.png" class="img-fluid animated icon-image" alt="MCC Queuing System Logo">
      </div>
    </div>
  </div>
</div>

<!-- JavaScript for Typewriter Effect -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const typewriter = (elementId, text, delay = 150) => {
      const element = document.getElementById(elementId);
      let index = 0;

      const type = () => {
        if (index < text.length) {
          const character = text.charAt(index);
          element.innerHTML += character === " " ? "&nbsp;" : character; // Ensure spaces are rendered properly
          index++;
          setTimeout(type, delay);
        }
      };
      type();
    };

    // Typewriter effect for the title and subtitle
    typewriter('typewriter-title', 'MCC QUEUING SYSTEM', 200);
    setTimeout(() => typewriter('typewriter-subtitle', 'Please select a portal to proceed.', 150), 2500);
  });
</script>

<!-- CSS for Typewriter Look -->
<style>
  /* Typewriter Font Style */
  .typewriter-title, .typewriter-subtitle {
    font-family: 'Courier New', Courier, monospace;
    font-size: 2rem;
    color: #333;
    white-space: nowrap;
    overflow: hidden;
    display: inline-block;
  }

  /* Typewriter Cursor */
  .typewriter-title::after, .typewriter-subtitle::after {
    content: '|';
    font-size: 1.5rem;
    margin-left: 5px;
    animation: blink-caret 0.7s steps(1) infinite;
    color: #333;
  }

  /* Blinking Caret Animation */
  @keyframes blink-caret {
    0%, 100% {
      opacity: 1;
    }
    50% {
      opacity: 0;
    }
  }
  .btn-getstarted {
    background-color: #007bff;
    color: white;
    padding: 8px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s ease;
  }

  .btn-getstarted:hover {
    background-color: #0056b3; /* Slightly darker blue on hover */
  }
  .btn-get-started {
        background-color: blue;
        color: #fff; /* Adjust text color for better contrast */
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        text-decoration: none;
        transition: background-color 0.3s, transform 0.3s;
    }
</style>


</style>

  <!-- =======================================================
  * Template Name: Vesperr
  * Template URL: https://bootstrapmade.com/vesperr-free-bootstrap-template/
  * Updated: Jun 29 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/image/download.png" alt="">
        <h1 class="sitename">MCC QUEUING SYSTEM</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home<br></a></li>
          <li><a href="#about">About</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="login">Register & Enrolled</a>

    </div>
  </header>

  <main class="main">

<!-- Hero Section -->
<section id="hero" class="hero section" style="background-color: #f4f4f4;"> <!-- You can adjust the background color here -->

  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
      <h1 id="typewriter-title" class="typewriter"></h1>
      <p id="typewriter-subtitle" class="typewriter"></p>
        <div class="d-flex">
          <a href="portal" class="btn-get-started">Admin Portal</a>
          <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" class="glightbox btn-watch-video d-flex align-items-center"></a>
        </div>
      </div>
      <div class="col-lg-6 order-1 order-lg-2 hero-img">
        <!-- Icon Image with background and resizing -->
        <div class="icon-container">
          <img src="assets/image/logo.png" class="img-fluid animated icon-image" alt="Icon">
        </div>
      </div>
    </div>
  </div>

</section><!-- /Hero Section -->

    <!-- Clients Section -->
    

    <!-- About Section -->
    <section id="about" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>About Us</h2>
        <p>His needs result from something he wants to escape from</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-5">

          <div class="content col-xl-5 d-flex flex-column" data-aos="fade-up" data-aos-delay="100">
            <h3>They provide the most valuable pleasure as it were</h3>
            <p>
            It is important to take care of the patient, to be followed by the patient, but it will happen at such a time that there is a lot of work and pain.  </p>
            <a href="#" class="about-btn align-self-center align-self-xl-start"><span>About us</span> <i class="bi bi-chevron-right"></i></a>
          </div>

          <div class="col-xl-7" data-aos="fade-up" data-aos-delay="200">
            <div class="row gy-4">

              <div class="col-md-6 icon-box position-relative">
                <i class="bi bi-briefcase"></i>
                <h4><a href="#" class="stretched-link">Let it be the pleasures of the body</a></h4>
                <p>They are the result, or as it were, of something that is equal to these labors, except that some</p>
              </div><!-- Icon-Box -->

              <div class="col-md-6 icon-box position-relative">
                <i class="bi bi-gem"></i>
                <h4><a href="#" class="stretched-link">Except for any work</a></h4>
                <p>Unless they are blinded by lust, they do not come forth; they are in fault who abandon their duties</p>
              </div><!-- Icon-Box -->

              <div class="col-md-6 icon-box position-relative">
                <i class="bi bi-broadcast"></i>
                <h4><a href="#" class="stretched-link">Hard work will result</a></h4>
                <p>Either he takes it with no one, or everyone. All the pains that the elders do</p>
              </div><!-- Icon-Box -->

              <div class="col-md-6 icon-box position-relative">
                <i class="bi bi-easel"></i>
                <h4><a href="#" class="stretched-link">Of the blessed truth</a></h4>
                <p>The expedients of the truth are of no consequence at the time of the praises of the covenants of life</p>
              </div><!-- Icon-Box -->

            </div>
          </div>

        </div>

      </div>

    </section><!-- /About Section -->


  </main>

  <footer id="footer" class="footer">

<div class="container">
<div class="container">
  <div class="copyright text-center fade-in">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">MCCQUEUINGSYSTEM</strong> <span>All Rights Reserved</span></p>

      <!-- Contact Information -->
      <div class="contact-info">
          <div class="contact-group">
              <i class="fas fa-user-circle"></i>
              <strong>Web Developer:</strong> <a href="#">Joebert Bilbao</a>
          </div>
          <div class="contact-group">
          <i class="fab fa-facebook"></i>
          <strong>MCC Page: Click Here  <i class="fas fa-hand-point-right" style="margin-left: 5px;"></i></strong>
          <a href="https://www.facebook.com/madridejoscollege" target="_blank">MCC Facebook Page</a>
            </div>
          <div class="contact-group">
              <i class="fas fa-envelope"></i>
              <strong>Email:</strong> <a href="#">Jbbilbao80@gmail.com</a>
          </div>
          <div class="contact-group">
              <i class="fas fa-phone"></i>
              <strong>Contact:</strong> <a href="#">09551349995</a>
          </div>
          <div class="contact-group">
              <i class="fas fa-map-marker-alt"></i>
              <strong>Address:</strong> <a href="#">Brgy Kodia, Purok Mahugany, Sitio Gahung, 6053</a>
          </div>
      </div>
  </div>
</div>


    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you've purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
      <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
    </div>
  </div>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

</footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const typewriter = (elementId, text, delay = 150, loopDelay = 2000) => {
      const element = document.getElementById(elementId);
      let index = 0;

      const type = () => {
        if (index < text.length) {
          const character = text.charAt(index);
          element.innerHTML += character === " " ? "&nbsp;" : character; // Ensure spaces are rendered properly
          index++;
          setTimeout(type, delay);
        } else {
          // Wait for a moment, then clear text and restart
          setTimeout(() => {
            element.innerHTML = "";
            index = 0;
            type();
          }, loopDelay);
        }
      };

      type();
    };

    // Continuous typewriter effect for the title and subtitle
    typewriter('typewriter-title', 'MCC QUEUING SYSTEM', 200, 3000);
    setTimeout(() => typewriter('typewriter-subtitle', 'Please select a portal to proceed.', 150, 3000), 2500);
  });
</script>


</body>

</html>