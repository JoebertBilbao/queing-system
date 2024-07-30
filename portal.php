<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PORTALS</title>
    <link href="assets/image/images.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <style>
        .header {
            text-align: center;
            margin-bottom: 40px;
            background-color: transparent; 
            padding: 20px 0; 
        }
        .header img {
            max-width: 100%; 
            margin-bottom: 10px;
            opacity: 0.8; /* Adjust opacity for transparency */
        }
        .header h2 {
            margin: 0; 
        }
        .card {
            display: flex;
            flex-direction: column;
            height: 100%;
            text-align: center; 
            justify-content: center; 
            cursor:pointer;
            background-color: rgba(255, 255, 255, 0.8); /* Transparent background */
            border: none; /* Remove border */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Optional: Add shadow */
            transition: transform 0.2s ease-in-out; /* Optional: Add smooth hover effect */
        }
        .card:hover {
            transform: translateY(-5px); /* Optional: Add hover effect */
        }
        .card-body {
            flex: 1;
        }
        .card-icon {
            font-size: 3rem; 
            margin-bottom: 10px; 
        }
        .card-title {
            margin-top: 0.5rem; 
        }

        
        body {
            background-image: url('assets/image/bg-font.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed; 
            font-family: 'Roboto', sans-serif; /* Use Roboto font for body text */
        }
    </style>
</head>
<body class="bg-light">
    <div class="header">
        <img src="assets/image/download.png" alt="Madridejos Community College Logo" width="100" height="80">
        <h2>Madridejos Community College</h2>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <!-- Portal 1 -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <i class="bi bi-calendar-check card-icon"></i>
                        <a href="guidance/index.php"><h5 class="card-title">GUIDANCE OFFICE</h5></a>
                    </div>
                </div>
            </div>

            <!-- Portal 2 -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <i class="bi bi-person-circle card-icon"></i>
                        <a href="head/index.php"><h5 class="card-title">DEPARTMENT HEAD</h5></a>
                    </div>
                </div>
            </div>

            <!-- Portal 3 -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <i class="bi bi-file-earmark-text card-icon"></i>
                        <a href="registrar/index.php"><h5 class="card-title">REGISTRAR OFFICE</h5></a>
                    </div>
                </div>
            </div>

            <!-- New Portal: Bank to Home -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <i class="bi bi-clipboard-data card-icon"></i>
                        <a href="ssc/index.php"><h5 class="card-title">SSC OFFICE</h5></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <!-- Portal 4 -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <i class="bi bi-heart card-icon"></i>
                        <a href="clinic/index.php"><h5 class="card-title">CLINIC OFFICE</h5></a>
                    </div>
                </div>
            </div>

            <!-- Portal 5 -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <i class="bi bi-gear card-icon"></i> 
                        <a href="mccea/index.php"><h5 class="card-title">MCCEA OFFICE</h5></a>
                    </div>
                </div>
            </div>

            <!-- Portal 6 -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <i class="bi bi-file-earmark-code card-icon"></i>
                        <a href="cor/index.php"><h5 class="card-title">COR</h5></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <!-- Portal 7 -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <i class="bi bi-house-door card-icon"></i>
                        <a href="./index.php"><h5 class="card-title">BACK TO HOME</h5></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
