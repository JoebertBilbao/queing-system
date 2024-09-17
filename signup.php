<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include 'database/db.php';
$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $year_level = $conn->real_escape_string($_POST['year_level']);
    $status = $conn->real_escape_string($_POST['status']);
    $semester = $conn->real_escape_string($_POST['semester']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $course = $conn->real_escape_string($_POST['course']);
    $created_at = date('Y-m-d H:i:s');
    $step_status = 'pending'; // Assuming a default status
    $code = $conn->real_escape_string(md5(rand())); // This might be redundant with verification_code

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
        $msg = "<div class='alert alert-danger'>{$email} - This email already exists.</div>";
    } else {    
        $sql = "INSERT INTO users (name, year_level, status, semester, email, password, course, created_at, step_status, code) 
                VALUES ('$name', '$year_level', '$status', '$semester', '$email', '$password', '$course', '$created_at', '$step_status', '$code')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<div style='display: none;'>";
            $mail = new PHPMailer(true);

            try {
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'jbbilbao80@gmail.com'; // Replace with your email
                $mail->Password   = 'axgdjelbsziuzvxa'; // Replace with your app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;

                $mail->setFrom('jbbilbao80@gmail.com', 'Madridejos Community College'); // Replace with your email and name
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Email Verification';
                $mail->Body    = 'Here is the verification link <b><a href="http://mccqueueingsystem.com/mccsystem/?verification='.$code.'">http://mccqueueingsystem.com/mccsystem/?verification='.$code.'</a></b>';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            echo "</div>";
            $msg = "<div class='alert alert-info'>We've sent a verification link to your email address.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Something went wrong.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIGNUP | STUDENTS</title>
    <!---Custom CSS File--->
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link href="assets/image/images.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-o4XBMDyA6I3jFq70N4o+ZSHSHY8fP+tZnCZ4EXWvHo6MnW+spt9u9N5+M3gybgY6" crossorigin="anonymous">

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
            height: 80vh;
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
    </style>
</head>

<body>
    <div class="container">
        <div class="registration">
            <header>Signup</header>
            <?php echo $msg; ?>
            <form  method="post" class="form">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter your fullname">
                </div>
                <div class="form-group">
                    <label for="year_level">Year Level</label>
                    <select name="year_level" id="year_level">
                        <option value="1st_year">1st Year</option>
                        <option value="2nd_year">2nd Year</option>
                        <option value="3rd_year">3rd Year</option>
                        <option value="4th_year">4th Year</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="student_type">Student Type</label>
                    <select name="status" id="student_type">
                        <option value="new_student">New Student</option>
                        <option value="transferee">Transferee</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <select name="semester" id="semester">
                        <option value="1st_semester">1st Semester</option>
                        <option value="2nd_semester">2nd Semester</option>
                    </select>
                </div>
                <div class="form-group full-width">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" placeholder="Enter your email">
                </div>
                <div class="form-group password-container">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Create a password">
                    <i class="toggle-password bi bi-eye-slash" id="togglePassword"></i>
                </div>
                <div class="form-group password-container">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your password">
                    <i class="toggle-password bi bi-eye-slash" id="toggleConfirmPassword"></i>
                </div>
                <div class="form-group full-width">
                    <label for="course">Course</label>
                    <select name="course" id="course">
                        <option value="bsit">Bachelor of Science in Information Technology (BSIT)</option>
                        <option value="bshm">Bachelor of Science in Hospitality Management (BSHM)</option>
                        <option value="bsba">Bachelor of Science in Business Administration (BSBA)</option>
                        <option value="bsed">Bachelor of Secondary Education (BSED)</option>
                        <option value="beed">Bachelor of Elementary Education (BEED)</option>
                    </select>
                </div>
                <div class="form-group full-width">
                    <input type="submit" class="button" value="Signup">
                </div>
            </form>
            <div class="signup">
                <span class="signup">Already have an account?
                    <br><br> <a href="login.php">Login</a>
                </span>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-uDyQso9LD2TCkAsPtASgZmEd6hfA5f/C6sEb+rRZKD+ljbV8qKoFVpqzUjK7m18a" crossorigin="anonymous"></script>


    <!-- JavaScript to handle password toggle -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });

        const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
        const confirmPassword = document.querySelector('#confirm_password');

        toggleConfirmPassword.addEventListener('click', function (e) {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>
</body>

</html>
