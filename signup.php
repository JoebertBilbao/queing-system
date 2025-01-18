
<?php
// Add HTTP security headers
require 'vendor/autoload.php';
include 'database/db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';

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
      }  elseif (!preg_match('/^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/', $password)) {
            $msg = "<div class='alert alert-danger'>Password must contain at least one capital letter, one number, and one special character (!@#$%^&*).</div>";
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
                    $mail->Username = 'delacruzjohnanthon@gmail.com';  // Your email
                    $mail->Password = 'ihgqsryyueffftqt';  // Your app password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port = 465;
                
                    $mail->setFrom('delacruzjohnanthon@gmail.com', 'Madridejos Community College');
                    $mail->addAddress($email);
                
                    $mail->isHTML(true);
                    $mail->Subject = 'Email Verification - Madridejos Community College';
                    
                    $mail->Body = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <script src='https://cdn.tailwindcss.com'></script>
</head>
<body style='margin: 0; padding: 0; background-color: #f3f4f6; font-family: system-ui, -apple-system, sans-serif;'>
    <table width='100%' cellpadding='0' cellspacing='0' role='presentation' style='background-color: #f3f4f6; padding: 24px;'>
        <tr>
            <td align='center'>
                <table width='100%' cellpadding='0' cellspacing='0' role='presentation' style='max-width: 600px; margin: 0 auto; background-color: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>
                    <!-- Header -->
                    <tr>
                        <td style='padding: 32px 24px; text-align: center; border-bottom: 1px solid #e5e7eb;'>
                            <img src='https://mccqueueingsystem.com/assets/image/download.png' alt='MCC Logo' style='width: 120px; height: auto; margin: 0 auto;'>
                            <h1 style='margin: 20px 0 0; color: #ccc; font-size: 24px; font-weight: 700;'>Welcome to Madridejos Community College</h1>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style='padding: 32px 24px;'>
                            <div style='text-align: center; margin-bottom: 24px;'>
                                <h2 style='margin: 0 0 16px; color: #1f2937; font-size: 20px; font-weight: 600;'>Verify Your Email Address</h2>
                                <p style='margin: 0; color: #4b5563; font-size: 16px;'>Thank you for registering with Madridejos Community College.</p>
                                <p style='margin: 8px 0 0; color: #4b5563; font-size: 16px;'>Please verify your email to activate your account.</p>
                            </div>

                            <!-- Student ID Box -->
                            <div style='background-color: #f9fafb; border-radius: 8px; padding: 16px; margin: 24px 0; text-align: center;'>
                                <p style='margin: 0 0 8px; color: #6b7280; font-size: 14px;'>Your Student ID</p>
                                <p style='margin: 0; color: #111827; font-size: 24px; font-weight: 700; font-family: monospace;'>{$id}</p>
                            </div>

                            <!-- Verification Button -->
                            <div style='text-align: center; margin: 32px 0;'>
                                <a href='https://mccqueueingsystem.com/login.php?verification=$verification_code' 
                                   style='display: inline-block; background-color: #dc2626; color: white; padding: 12px 32px; 
                                          border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 16px;
                                          transition: background-color 0.2s;'>
                                    Verify Email Address
                                </a>
                            </div>

                            <p style='margin: 24px 0 0; text-align: center; color: #6b7280; font-size: 14px;'>
                                If you didn't create an account with Madridejos Community College,<br>you can safely ignore this email.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style='padding: 24px; text-align: center; border-top: 1px solid #e5e7eb;'>
                            <p style='margin: 0 0 8px; color: #6b7280; font-size: 12px;'>This is an automated message, please do not reply to this email.</p>
                            <p style='margin: 0; color: #6b7280; font-size: 12px;'>© 2024 Madridejos Community College. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
";
                
                    $mail->AltBody = "Welcome to Madridejos Community College!\n\nYour Student ID: {$id}\n\nPlease verify your email by clicking this link: http://localhost/mccsystem/login.php?verification=$verification_code";
                
                    $mail->send();
                    $_SESSION['alert_type'] = 'success';
                    $_SESSION['alert_message'] = 'Verification email sent! Please check your inbox.';
                    $msg = "<div class='alert alert-info'>Verification email sent. Please check your inbox.</div>";
                    
                } catch (Exception $e) {
                    $_SESSION['alert_type'] = 'error';
                    $_SESSION['alert_message'] = 'Mailer Error: ' . $mail->ErrorInfo;
                    $msg = "<div class='alert alert-danger'>Mailer Error: {$mail->ErrorInfo}</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Something went wrong, please try again.</div>";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGNUP | STUDENTS</title>
    <link href="assets/image/images.png" rel="icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen bg-cover bg-center bg-no-repeat flex items-center justify-center p-4">
    <!-- Success Alert - Initially Hidden -->
    <?php if (isset($_SESSION['alert_type'])): ?>
    <div id="alertMessage" class="fixed top-4 right-4 flex items-center p-4 mb-4 <?php echo $_SESSION['alert_type'] === 'success' ? 'text-green-800 bg-green-50' : 'text-red-800 bg-red-50'; ?> rounded-lg z-50" role="alert">
        <?php if ($_SESSION['alert_type'] === 'success'): ?>
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
            </svg>
        <?php else: ?>
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
            </svg>
        <?php endif; ?>
        <div class="ms-3 text-sm font-medium">
            <?php echo htmlspecialchars($_SESSION['alert_message']); ?>
        </div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 <?php echo $_SESSION['alert_type'] === 'success' ? 'bg-green-50 text-green-500 hover:bg-green-200' : 'bg-red-50 text-red-500 hover:bg-red-200'; ?> rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 inline-flex items-center justify-center h-8 w-8" onclick="this.parentElement.classList.add('hidden')">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-2xl w-full max-w-5xl overflow-hidden">
        <!-- Header Section with Gradient -->
        <div class="bg-gradient-to-r from-red-600 to-red-700 p-6">
            <div class="flex flex-col sm:flex-row items-center gap-6">
                <img src="assets/image/icon.png" alt="School Logo" class="w-32 h-32 object-contain">
                <div class="text-center sm:text-left">
                    <h1 class="text-2xl font-bold text-white">Student Registration</h1>
                    <p class="text-red-100 mt-2">Madridejos Community College</p>
                </div>
            </div>
        </div>

        <!-- Registration Form -->
        <div class="p-6">
            <form method="post" class="space-y-8">
                <!-- Grid Layout - Row 1 -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Course</label>
                        <select name="course" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                            <option value="bsit">BS Information Technology</option>
                            <option value="bshm">BS Hospitality Management</option>
                            <option value="bsba">BS Business Administration</option>
                            <option value="bsed">BS Secondary Education</option>
                            <option value="beed">BS Elementary Education</option>
                        </select>
                    </div>
                </div>

                <!-- Grid Layout - Row 2 -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Year Level</label>
                        <select name="year_level" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                            <option value="1st_year">1st Year</option>
                            <option value="2nd_year">2nd Year</option>
                            <option value="3rd_year">3rd Year</option>
                            <option value="4th_year">4th Year</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Student Type</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                            <option value="new_student">New Student</option>
                            <option value="transferee">Transferee</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Semester</label>
                        <select name="semester" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                            <option value="1st_semester">1st Semester</option>
                            <option value="2nd_semester">2nd Semester</option>
                        </select>
                    </div>
                </div>

                <!-- Grid Layout - Row 3 -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2 relative">
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                        <i class="bi bi-eye-slash absolute right-3 top-7 cursor-pointer text-gray-500" id="togglePassword"></i>
                        <div id="passwordFeedback" class="text-xs mt-1 space-y-1"></div>
                    </div>
                    <div class="space-y-2 relative">
                        <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                        <i class="bi bi-eye-slash absolute right-3 top-7 cursor-pointer text-gray-500" id="toggleConfirmPassword"></i>
                    </div>
                    <div class="flex items-center justify-center">
                        <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 transition duration-200 font-medium">
                            Register Account
                        </button>
                    </div>
                </div>

                <!-- Terms and Login Section -->
                <div class="space-y-4 pt-4 border-t">
                    <div class="flex items-center space-x-2">
                    <input type="checkbox" name="terms_conditions" id="terms_conditions" 
                    class="rounded border-gray-300 text-red-600 focus:ring-red-500" required>
                        <label class="text-sm text-gray-600">
                            I agree to the <a href="#" class="text-red-600 hover:text-red-800 terms-link">Terms and Conditions</a>
                        </label>
                    </div>
                    <div class="text-center text-sm text-gray-600">
                        Already have an account? <a href="login.php" class="text-red-600 hover:text-red-800 font-medium">Login</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Terms and Conditions Modal -->
    <div id="termsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 max-w-lg w-full">
            <div class="flex justify-between items-center">
                <h3 class="text-lg sm:text-xl font-semibold">Terms and Conditions</h3>
                <button class="text-gray-500 hover:text-gray-700" onclick="closeModal()">&times;</button>
            </div>
            <div class="mt-4 space-y-2 max-h-96 overflow-y-auto text-sm text-gray-700">
                <p>Welcome to the Madridejos Community College Queueing System. By using this system, you agree to the following:</p>
                <ul class="list-disc pl-5">
                    <li>Eligibility: The system is only for use by MCC students.</li>
                    <li>Account Security: Maintain confidentiality of your credentials.</li>
                    <li>Usage Policy: Use for legitimate academic or administrative purposes.</li>
                    <li>Data Privacy: Personal information is used for registration purposes only.</li>
                    <li>Prohibited Activities: Avoid any activities that harm the system's integrity.</li>
                    <li>System Availability: We do not guarantee 100% uptime.</li>
                    <li>Changes to Terms: We reserve the right to modify these terms anytime.</li>
                </ul>
            </div>
            <div class="flex justify-end space-x-2 mt-4">
                <button class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400" onclick="closeModal()">Decline</button>
                <button class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700" onclick="acceptTerms()">Accept</button>
            </div>
        </div>
    </div>

    <script>


        // Modal functionality
        function showModal() {
            document.getElementById('termsModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('termsModal').classList.add('hidden');
        }

        function acceptTerms() {
            const termsCheckbox = document.getElementById('terms_conditions');
            termsCheckbox.disabled = false;
            termsCheckbox.checked = true;
            closeModal();
        }

        document.querySelector('.terms-link').addEventListener('click', function (e) {
            e.preventDefault();
            showModal();
        });

        // Password visibility toggle
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        togglePassword.addEventListener('click', function () {
            const type = password.type === 'password' ? 'text' : 'password';
            password.type = type;
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });

        const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
        const confirmPassword = document.querySelector('#confirm_password');
        toggleConfirmPassword.addEventListener('click', function () {
            const type = confirmPassword.type === 'password' ? 'text' : 'password';
            confirmPassword.type = type;
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });

        // Password validation feedback
        const passwordFeedback = document.getElementById('passwordFeedback');
        password.addEventListener('input', function () {
            const value = password.value;
            const rules = [
                { regex: /[A-Z]/, message: "At least one uppercase letter" },
                { regex: /[0-9]/, message: "At least one number" },
                { regex: /[!@#$%^&*]/, message: "At least one special character (!@#$%^&*)" },
                { regex: /.{8,}/, message: "Minimum 8 characters" }
            ];
            const feedback = rules.map(rule => `<span class="${rule.regex.test(value) ? 'text-green-500' : 'text-red-500'}">${rule.message}</span>`).join('<br>');
            passwordFeedback.innerHTML = feedback;
        });

        const form = document.getElementById('registrationForm');
const termsCheckbox = document.getElementById('terms_conditions');

form.addEventListener('submit', function(e) {
    if (!termsCheckbox.checked) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Terms & Conditions Required',
            text: 'Please accept the terms and conditions to continue.',
            confirmButtonColor: '#dc2626'
        });
    }
});

// Update the acceptTerms function
function acceptTerms() {
    termsCheckbox.checked = true;
    closeModal();
}

        <?php
// Clear the session alert after displaying
if (isset($_SESSION['alert_type'])) {
    unset($_SESSION['alert_type']);
    unset($_SESSION['alert_message']);
}
?>
    </script>
</body>
</html>
