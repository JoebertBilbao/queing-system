<?php
// Start the session
session_start();
require '../vendor/autoload.php';
include('../database/db.php'); // Include database connection

// Generate a random verification code
$code = rand(100000, 999999);
$error = ""; // Variable to store error message

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"])) {
    $email = $_POST["email"];

    // Check if the username exists and is verified
    $stmt = $conn->prepare("SELECT id FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // User exists and is verified
        $stmt->close();

        // Store the verification code in the database
        $stmt = $conn->prepare("UPDATE admin SET code = ? WHERE email = ?");
        $stmt->bind_param("is", $code, $email);
        $stmt->execute();

        // Configure PHPMailer
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'jbbilbao80@gmail.com'; // SMTP username
        $mail->Password = 'axgdjelbsziuzvxa'; // SMTP password
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email content
        $mail->setFrom('mccqueueing@gmail.com', 'Verification System');
        $mail->addAddress($email);
        $mail->Subject = "Verification Code";
        $mail->Body = "Your verification code is: " . $code;

        // Send the email
        if ($mail->send()) {
            // Store the email in the session and redirect to the verification page
            $_SESSION["email"] = $email;
            header("Location: verify");
            exit;
        } else {
            $error = "Error sending email: " . $mail->ErrorInfo;
        }
    } else {
        // User does not exist or is not verified
        $error = "Failed to send verification code. Please try again.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        /* General Styling */
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

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Form Container */
        form {
            background-color: white;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        /* Input Fields */
        input[type="email"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            font-size: 16px;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Error Message */
        .error {
            margin-top: 10px;
            padding: 10px;
            background-color: #e74c3c;
            color: white;
            border-radius: 4px;
            text-align: center;
        }

    </style>
</head>
<body>
    <div>
        <h1>Email Verification</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="emailVerificationForm">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="submit" value="Send Verification Email">
        </form>
        <div class="text-center mt-3">
                    <a href="../portal.php" class="btn btn-secondary btn-sm">Home</a>
                </div>
        <?php if (!empty($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
    </div>
</body>
</html>

