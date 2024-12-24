<?php

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
    <title>ADMIN VERIFICATION | GUIDANCE</title>
    <link href="assets/image/image1.png" rel="icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-cover bg-center bg-no-repeat flex items-center justify-center p-4" >
    <div class="w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden">
        <!-- Header Section -->
        <div class="p-6 bg-gradient-to-r from-gray-50 to-white border-b">
    <div class="text-center flex items-center justify-end">  <!-- Changed justify-center to justify-end -->
        <img src="../assets/image/Google.png" alt="MCC Logo" class="w-25 h-20">  <!-- Changed from w-16 h-16 to w-12 h-12 -->
    </div>
    <div class="text-center mt-4">
        <h1 class="text-2xl font-bold text-gray-800">Admin Verification</h1>
    </div>
</div>
        <!-- Verification Form -->
        <div class="p-6">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-4" id="loginAccessForm">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" name="email" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                           placeholder="Enter your email">
                </div>

                <button type="submit" 
                        class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition duration-200 font-medium">
                    Send Login Link
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="../portal.php" 
                   class="inline-block text-sm text-gray-600 hover:text-gray-800 font-medium">
                    Back to Home
                </a>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Prevent back button
        function preventBack() {
            window.history.forward();
        }
        setTimeout("preventBack()", 0);
        window.onunload = function() { null };
    </script>
</body>
</html>
