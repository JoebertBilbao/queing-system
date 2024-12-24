<?php 
require_once "server.php"; 
$email = $_SESSION['email'];
if($email == false){
  header('Location: index');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Code Verification</title>
    <link rel="stylesheet" href="style.css">
    <link href="assets/image/image1.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        html, body {
            height: 100%;
            background-color: #faf9f6;
        }
        .verification-container {
            max-width: 400px;
            width: 90%;
        }
        .btn-danger {
            background-color: #fd2323;
        }
        .btn-danger:hover {
            background-color: #f71d1d;
        }
        .start-end {
            text-align: right;
        }
        body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        height: 100vh;
        background: url('../assets/image/loginbackground.jpg') no-repeat center center/cover;
        display: justify;
        justify-content: center;
        align-items: center;
    }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="verification-container bg-white p-4 rounded shadow">
        <div class="start-end"></div>
        <h2 class="text-center mb-3">Enter OTP</h2>
        <p class="text-center mb-4">Enter the otp sent to your email.</p>
        <?php 
                    if(isset($_SESSION['info'])){
                        ?>
                     <div class="alert alert-success text-center" style="padding: 0.4rem 0.4rem">
                         <?php echo $_SESSION['info']; ?>
                     </div>
                     <?php
                    }
                    ?>
                     <?php
                    if(count($errors) > 0){
                        ?>
                     <div class="alert alert-danger text-center">
                         <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                     </div>
                     <?php
                    }
                    ?>
        <form action="reset-code.php" method="POST" autocomplete="off">
            <div class="mb-3">
                <input type="text" name="otp" class="form-control" placeholder="Enter otp code" required>
            </div>
            <button type="submit" name="check-reset-otp"  class="btn btn-danger w-100 mb-3"> Submit</button>
            <p class="text-center mb-0">Didn’t receive a code? <a href="forgot-password.php" class="text-danger">Resend Code</a></p>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
