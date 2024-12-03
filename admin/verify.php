<?php
// Security Headers
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload"); // Enforces HTTPS
header("X-Frame-Options: SAMEORIGIN"); // Protects against clickjacking
header("X-Content-Type-Options: nosniff"); // Prevents MIME type sniffing
header("Referrer-Policy: no-referrer-when-downgrade"); // Controls referrer information sent with requests
header("Permissions-Policy: accelerometer=(), autoplay=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=()"); // Restricts feature permissions

session_start();
require '../database/db.php'; // Include database connection

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_code = $_POST['otp'];

    // Validate the entered OTP
    if (ctype_digit($entered_code) && strlen($entered_code) === 6) {
        // Prepare statement to check the verification code
        $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ? AND code = ?");
        $stmt->bind_param("si", $_SESSION['email'], $entered_code);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Code is correct
            // Remove the code from the database after successful verification
            $delete_stmt = $conn->prepare("UPDATE admin SET code = NULL WHERE email = ?");
            $delete_stmt->bind_param("s", $_SESSION['email']);
            $delete_stmt->execute();

            // Clear the session variable
            unset($_SESSION['email']);

            // Redirect to login page after successful verification
            header("Location: index");
            exit;
        } else {
            $error = "Invalid verification code. Please try again.";
        }
    } else {
        $error = "Invalid code format. Please enter a 6-digit code.";
    }
}
?>
<link rel="icon" href="applicant/assets/img/mcc1.png" type="image/x-icon" />
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: green;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    .container {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
        max-width: 400px;
        width: 100%;
    }
    .error {
        color: white;
        font-size: 14px;
        margin-top: 10px;
        background-color: #e74c3c;
        padding: 10px;
        border-radius: 5px;
        width: 100%;
        max-width: 350px;
        margin: 10px auto;
    }
    input[type="text"] {
        width: 100%;
        padding: 15px;
        font-size: 18px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 20px;
    }
    button {
        background-color: #4a90e2;
        color: #fff;
        border: none;
        padding: 12px 20px;
        font-size: 16px;
        border-radius: 20px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #357ab7;
    }
    p {
        text-align: center;
        margin-top: 20px;
    }
    p a {
        color: #007BFF;
        text-decoration: none;
    }
    p a:hover {
        text-decoration: underline;
    }
    form img {
        width: 100px;
        height: 100px;
        margin-bottom: 20px;
    }
</style>
</head>
<body>
    <div class="container">
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <img src="img/verification.png" alt="Password Protection">
            <h2>Verify Your Email</h2>
            <input type="text" name="otp" maxlength="6" pattern="\d{6}" placeholder="Enter 6-digit OTP" required>
            <button type="submit">Verify Code</button>
        </form>
    </div>
</body>
