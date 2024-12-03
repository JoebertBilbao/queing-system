<?php
// Add HTTP security headers
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload"); // Enforce HTTPS
header("X-Frame-Options: SAMEORIGIN"); // Prevent clickjacking
header("X-Content-Type-Options: nosniff"); // Prevent MIME-type sniffing
header("Referrer-Policy: no-referrer-when-downgrade"); // Control the referrer information
header("Permissions-Policy: geolocation=(), microphone=(), camera=()"); // Control browser features
// Redirect to admin/index.php

// Start the session
session_start();
require '../vendor/autoload.php';
include('../database/db.php'); // Include database connection

$error = ""; // Variable to store error message
$success = ""; // Variable to store success message

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"])) {
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

    if (!$email) {
        $error = "Invalid email format.";
    } else {
        // Check if the email exists in the database
        $stmt = $conn->prepare("SELECT id FROM admin WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // User exists
            $stmt->close();

            // Configure PHPMailer
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'jbbilbao80@gmail.com';
            $mail->Password = 'axgdjelbsziuzvxa';
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email content
            $mail->isHTML(true);
            $mail->setFrom('jbbilbao80@gmail.com', 'Verification System');
            $mail->addAddress($email);
            $mail->Subject = "Login to Your Account";

            // Direct login link
            $loginUrl = "https://mccqueueingsystem.com/admin/index.php";

            $mail->Body = "
            <html>
            <body>
                <h2>Login to Your Account</h2>
                <p>Click the button below to log in:</p>
                <a href='{$loginUrl}' style='display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;'>Start Login</a>
                <p>If you did not request this login, please ignore this email.</p>
            </body>
            </html>";

            // Send the email
            if ($mail->send()) {
                $_SESSION["email"] = $email;
                $success = "We've sent a verification email to your address.";
            } else {
                $error = "Error sending login email. Please try again.";
            }
        } else {
            // User does not exist
            $error = "Email not found in our system.";
        }


    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Access</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="email"] {
            padding: 12px;
            margin: 10px 0;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            font-size: 16px;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: #e74c3c;
            margin-top: 15px;
        }

        .success {
            color: #2ecc71;
            margin-top: 15px;
        }

        .home-link {
            margin-top: 15px;
        }
        .text-center .btn {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 20px;
        font-size: 14px;
        border-radius: 5px;
        background-color: #6c757d; /* Gray button background */
        color: white;
        text-decoration: none;
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
<body>
    <div class="container">
        <h1>Login Access</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="loginAccessForm">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="submit" value="Send Login Link">
            <div class="text-center">
        <a href="../portal.php" class="btn btn-secondary btn-sm">Home</a>
    </div>
        </form>
        
        <?php if (!empty($error)) { ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php } ?>

        <?php if (!empty($success)) { ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
        <?php } ?>
    </div>
</body>
</html>
