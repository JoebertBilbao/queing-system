<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PORTALS</title>
    <link href="assets/image/images.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    
    <!-- Fonts and Vendor CSS Files -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    
    <style>
 body {
    display: flex;
    flex-direction: row;
    min-height: 100vh;
    margin: 0;
    font-family: 'Roboto', sans-serif;
    background-image: url('assets/image/bluredd.png'); /* Update this path */
    background-size: cover; /* Adjust to cover the whole page */
    background-attachment: fixed; /* Optional: to make the background fixed during scrolling */
    background-position: center; /* Center the image */
    background-repeat: no-repeat; /* Ensure the image doesn't repeat */
}

.sidebar {
    width: 250px;
    background-color: rgba(255, 255, 255, 0.8); /* Solid background color or slight transparency */
    height: 100vh;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    position: fixed;
    top: 0;
    left: 0;
    overflow-y: auto; /* Ensure content in the sidebar is scrollable if necessary */
    z-index: 1000; /* Ensure sidebar stays above other content */
}

.sidebar .nav-link {
    display: flex;
    align-items: center;
    padding: 10px;
    text-decoration: none;
    color: #333;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.sidebar .nav-link:hover {
    background-color: #e9ecef;
}

.sidebar .nav-link i {
    margin-right: 10px;
}

.sidebar .dashboard-link {
    margin-bottom: 20px;
    font-weight: bold;
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
<body class="bg-light">
    <div class="sidebar">
        <div class="header">
            <img src="assets/image/download.png" alt="Madridejos Community College Logo" width="100" height="80">
            <p>MADRIDEJOS COMMUNITY COLLEGE</p>   
        </div>
        <a href="admin/index.php" class="nav-link"><i class="bi bi-person-lock"></i>Admin Dashboard</a>
        <a href="guidance/index.php" class="nav-link"><i class="bi bi-calendar-check"></i> Guidance Office</a>
        <a href="head/index.php" class="nav-link"><i class="bi bi-person-circle"></i> Department Head</a>
        <a href="registrar/index.php" class="nav-link"><i class="bi bi-file-earmark-text"></i> Registrar Office</a>
        <a href="ssc/index.php" class="nav-link"><i class="bi bi-clipboard-data"></i> SSC Office</a>
        <a href="clinic/index.php" class="nav-link"><i class="bi bi-heart"></i> Clinic Office</a>
        <a href="mccea/index.php" class="nav-link"><i class="bi bi-gear"></i> MCCEA Office</a>
        <a href="cor/index.php" class="nav-link"><i class="bi bi-file-earmark-code"></i> COR</a>
        <a href="./index.php" class="nav-link"><i class="bi bi-house-door"></i> Back to Home</a>
    </div>
    <div class="main-content">
        <div class="login-box">
            <h2>Login as Admin</h2><p>Welcome Administrators</p>
            <!-- Add form elements if needed here -->
        </div>
    </div>
</body>
</html>
