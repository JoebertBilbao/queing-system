
<?php
// Add HTTP security headers

require 'vendor/autoload.php';
include 'database/db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$msg = "";

// Generate a unique random 6-digit ID for `id` column
function generateRandomId($conn) {
    do {
        $randomId = rand(100000, 999999); // 6-digit random number
        $stmt = $conn->prepare("SELECT 1 FROM users WHERE id = ?");
        $stmt->bind_param('i', $randomId);
        $stmt->execute();
        $result = $stmt->get_result();
    } while ($result->num_rows > 0); // Ensure uniqueness
    return $randomId;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $year_level = $_POST['year_level'];
    $status = $_POST['status'];
    $semester = $_POST['semester'];
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $course = $_POST['course'];
    $created_at = date('Y-m-d H:i:s');
    $step_status = 'not started';
    $verification_code = md5(rand());
    $id = generateRandomId($conn); // Generate random ID for `id`

    $terms_accepted = isset($_POST['terms_conditions']) ? 1 : 0;

    if ($terms_accepted !== 1) {
        $msg = "<div class='alert alert-danger'>You must accept the terms and conditions.</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "<div class='alert alert-danger'>Invalid email format.</div>";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $msg = "<div class='alert alert-danger'>Name can only contain letters and spaces.</div>";
    } elseif (preg_match("/\s/", $password)) {
        $msg = "<div class='alert alert-danger'>Password should not contain spaces.</div>";
    } elseif ($password !== $confirm_password) {
        $msg = "<div class='alert alert-danger'>Passwords do not match.</div>";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $msg = "<div class='alert alert-danger'>The email already exists.</div>";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $insert_query = "INSERT INTO users (id, name, year_level, status, semester, email, password, course, created_at, step_status, verification_code, terms_accepted) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param('issssssssssi', $id, $name, $year_level, $status, $semester, $email, $password_hash, $course, $created_at, $step_status, $verification_code, $terms_accepted);

            if ($stmt->execute()) {
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'jbbilbao80@gmail.com';  // Your email
                    $mail->Password = 'vgisipyttnbyrafg';  // Your app password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port = 465;

                    $mail->setFrom('jbbilbao80@gmail.com', 'Madridejos Community College');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Email Verification';
                    $mail->Body = "
                        <div>
                            <h2>Welcome to Madridejos Community College</h2>
                            <p>Your ID: <strong>{$id}</strong></p>
                            <p>Click the button below to verify your email:</p>
                            <a href='https://mccqueueingsystem.com/login.php?verification=$verification_code'
                               style='background: #28a745; color: white; text-decoration: none; padding: 10px; border-radius: 5px;'>Verify Your Email</a>
                        </div>
                    ";

                    $mail->send();
                    $msg = "<div class='alert alert-info'>Verification email sent. Please check your inbox.</div>";
                } catch (Exception $e) {
                    $msg = "<div class='alert alert-danger'>Mailer Error: {$mail->ErrorInfo}</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Something went wrong, please try again.</div>";
            }
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $suspiciousPatterns = [
        '/<script>/i',
        '/SELECT .* FROM/i',
        '/DROP TABLE/i',
        '/[\'"()=<>;]/'
    ];

    foreach ($_POST as $key => $value) {
        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $value)) {
                die("<h1 style='color: red; text-align: center;'>Hoii kopal kaba bossing!</h1>");
            }
        }
    }

    // Continue processing the form inputs after validation
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIGNUP | STUDENTS</title>
    <link href="assets/image/images.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #009688;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 800px;
            height: 90;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .registration {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .registration header {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #009688;
        }

        .form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            flex-grow: 1;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            width: calc(50% - 7.5px);
        }

        .form-group.full-width {
            width: 100%;
        }

        .form-group label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
            font-size: 14px;
        }

        .form-group input[type="text"],
        .form-group input[type="password"],
        .form-group select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group input[type="submit"] {
            padding: 12px;
            border: none;
            background: #009688;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
            transition: background-color 0.3s;
        }

        .form-group input[type="submit"]:hover {
            background-color: #00796b;
        }

        .signup {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .signup a {
            color: #009688;
            text-decoration: none;
            font-weight: bold;
        }

        .signup a:hover {
            text-decoration: underline;
        }

        .password-container {
            position: relative;
        }

        .password-container input {
            padding-right: 40px; /* Adjust this value based on the width of the icon */
        }

        .toggle-password {
            position: absolute;
            top: 65%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 1;
        }


        @media (max-width: 768px) {
            .form-group {
                width: 100%;
            }
            @media (max-width: 768px) {
            .form-group {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .registration {
                padding: 20px;
            }

            .form-group label {
                font-size: 12px;
            }

            .form-group input[type="text"],
            .form-group input[type="password"],
            .form-group select {
                font-size: 12px;
                padding: 6px;
            }

            .form-group input[type="submit"] {
                font-size: 14px;
                padding: 10px;
            }

            .signup {
                font-size: 12px;
            }
        }
        }

        #terms_conditions {
    accent-color: gray; /* Default color */
    cursor: pointer;
}

#terms_conditions:checked {
    accent-color: dodgerblue; /* Blue when checked */
}
body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        height: 100vh;
        background: url('assets/image/loginbackground.jpg') no-repeat center center/cover;
        display: justify;
        justify-content: center;
        align-items: center;
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="registration">
            <header>Signup</header>
            <?php echo $msg; ?>
            <form method="post" class="form">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter your fullname" required>
                </div>
                <div class="form-group">
                    <label for="year_level">Year Level</label>
                    <select name="year_level" id="year_level" required>
                        <option value="1st_year">1st Year</option>
                        <option value="2nd_year">2nd Year</option>
                        <option value="3rd_year">3rd Year</option>
                        <option value="4th_year">4th Year</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="student_type">Student Type</label>
                    <select name="status" id="student_type" required>
                        <option value="new_student">New Student</option>
                        <option value="transferee">Transferee</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <select name="semester" id="semester" required>
                        <option value="1st_semester">1st Semester</option>
                        <option value="2nd_semester">2nd Semester</option>
                    </select>
                </div>
                <div class="form-group full-width">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group password-container">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Create a password" required>
                    <i class="toggle-password bi bi-eye-slash" id="togglePassword"></i>
                </div>
                <div class="form-group password-container">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your password" required>
                    <i class="toggle-password bi bi-eye-slash" id="toggleConfirmPassword"></i>
                </div>
                <div class="form-group full-width">
                    <label for="course">Course</label>
                    <select name="course" id="course" required>
                        <option value="bsit">Bachelor of Science in Information Technology (BSIT)</option>
                        <option value="bshm">Bachelor of Science in Hospitality Management (BSHM)</option>
                        <option value="bsba">Bachelor of Science in Business Administration (BSBA)</option>
                        <option value="bsed">Bachelor of Secondary Education (BSED)</option>
                        <option value="beed">Bachelor of Elementary Education (BEED)</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="terms_conditions">
                        <input type="checkbox" name="terms_conditions" id="terms_conditions" disabled required>
                        I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a>.
                    </label>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Register</button>
                </div>
            </form>
            <div class="signup">
                <span class="signup">Already have an account? <br><br> <a href="login.php">Login</a></span>
            </div>
        </div>
    </div>
 <!-- Terms and Conditions Modal -->
 <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Include the terms content here -->
            <p>Welcome to the Madridejos Community College (MCC) Queueing System. By using this system, you agree to the following terms and conditions:</p>
<ul>
    <li><strong>Eligibility:</strong> The system is only for use by students of Madridejos Community College. Access is restricted to registered students with valid credentials.</li>
    <li><strong>Account Security:</strong> You are responsible for maintaining the confidentiality of your account details, including your email and password. Any unauthorized access to your account is your responsibility.</li>
    <li><strong>Usage Policy:</strong> The system should be used only for legitimate academic or administrative purposes. Any misuse, including but not limited to, tampering with system functions or data, may result in the suspension or termination of your access.</li>
    <li><strong>Data Privacy:</strong> Personal information collected through the system is used for registration and scheduling purposes only. We commit to protecting your data according to applicable data privacy laws and regulations.</li>
    <li><strong>Prohibited Activities:</strong> You are prohibited from engaging in activities that could harm the system's integrity or security, including but not limited to, hacking attempts, unauthorized data collection, or distributing malicious software.</li>
    <li><strong>System Availability:</strong> While we strive to ensure the system is always available, we do not guarantee 100% uptime. The system may be temporarily unavailable for maintenance or unforeseen technical issues.</li>
    <li><strong>Changes to Terms:</strong> We reserve the right to modify these terms and conditions at any time. Any changes will be posted on this page, and it is your responsibility to review them regularly.</li>
    <li><strong>Liability:</strong> Madridejos Community College is not liable for any direct, indirect, incidental, or consequential damages arising from your use of the system, including data loss or disruption of service.</li>
    <li><strong>Acceptance:</strong> By using this system, you agree to comply with these terms. If you do not agree with any of these terms, you must not use the system.</li>
</ul>
<p>If you have any questions or concerns about these terms, please contact the MCC support team at <strong>MCC Queueing System</strong>.</p>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Decline</button>
            <button type="button" id="acceptTerms" class="btn btn-success" data-bs-dismiss="modal">Accept</button>
          </div>
        </div>
      </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
document.getElementById('acceptTerms').addEventListener('click', function () {
    const termsCheckbox = document.getElementById('terms_conditions');
    termsCheckbox.disabled = false; // Enable the checkbox
    termsCheckbox.checked = true; // Check the checkbox
});

// Add CSS to style the checkbox
document.addEventListener('DOMContentLoaded', function() {
    const termsCheckbox = document.getElementById('terms_conditions');
    
    // Add event listener to change accent color when checked
    termsCheckbox.addEventListener('change', function() {
        if (this.checked) {
            this.style.accentColor = 'dodgerblue';
        } else {
            this.style.accentColor = 'gray';
        }
    });
});
</script>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });

        const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
        const confirmPassword = document.querySelector('#confirm_password');
        toggleConfirmPassword.addEventListener('click', function () {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });

        document.querySelectorAll("input, select").forEach(input => {
        input.addEventListener("input", () => {
        const value = input.value;

        // Define suspicious patterns to test
        const suspiciousPatterns = [
            /<script>/i,
            /SELECT .* FROM/i,
            /DROP TABLE/i,
            /[\'"()=<>;]/
        ];

        for (const pattern of suspiciousPatterns) {
            if (pattern.test(value)) {
                alert("Hoii kopal kaba bossing!");
                document.body.innerHTML = `
                    <h1 style="color: red; text-align: center; font-size: 100px; margin-top: 0%; font-family: Arial, sans-serif;">
                        Hoii kopal kaba bossing!
                    </h1>
                    <h2 style="color: red; text-align: center; font-size: 15px; margin-top: 0%; font-family: Arial, sans-serif;">
                        Meet Up Sumbagay!
                    </h2>`;
                break;
            }
        }
    });
});
    </script>
</body>
</html>
