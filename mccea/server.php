<?php
// Security Headers
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload"); // Enforces HTTPS
header("X-Frame-Options: SAMEORIGIN"); // Protects against clickjacking
header("X-Content-Type-Options: nosniff"); // Prevents MIME type sniffing
header("Referrer-Policy: no-referrer-when-downgrade"); // Controls referrer information sent with requests
header("Permissions-Policy: accelerometer=(), autoplay=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=()"); // Restricts feature permissions

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require("../config.php");
require '../vendor/PHPMailer/src/Exception.php';
require '../vendor/PHPMailer/src/PHPMailer.php';
require '../vendor/PHPMailer/src/SMTP.php';
?>
<?php 
session_start();

$email = "";
$name = "";
$errors = array();


//connect to database
$con = mysqli_connect('127.0.0.1', 'u510162695_mccsystem', '1Mccsystem', 'u510162695_mccsystem');

//for verified email


    //if user click continue button in forgot password form
    if(isset($_POST['check-email'])){
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $check_email = "SELECT * FROM mccea WHERE email='$email'";
        $run_sql = mysqli_query($con, $check_email);
        if(mysqli_num_rows($run_sql) > 0){
            $code = rand(100000, 999999);
            $insert_code = "UPDATE mccea SET OTP = $code WHERE email = '$email'";
            $run_query =  mysqli_query($con, $insert_code);
            if($run_query){
                $subject = "Reset Password Notification";
                $message = "<h2>MCC QUEUEING SYSTEM</h2>
                <p>This is your OTP code:  <b>$code</b> <br><br>
                    Please use this code to set your new password.<br><br>
                    If you didn't request this code, you can disregard this message.
                </p>
                ";
                $sender = "Jbbilbao80@gmail.com";
                //Load composer's autoloader

// $insert_data = "INSERT INTO `messagein` (`Id`, `SendTime`, `MessageFrom`, `MessageTo`, `MessageText`) VALUES ('', '', 'MPLA', '$email', 'OTP code is $code')";
//         $data_check = mysqli_query($con, $insert_data);

    $mail = new PHPMailer(true);                            
    try {
        //Server settings
        $mail->isSMTP();                                     
        $mail->Host = 'smtp.gmail.com';                      
        $mail->SMTPAuth = true;                             
        $mail->Username = $sender;     
        $mail->Password = 'shlytsgxqjtjuuxd';             
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );                         
        $mail->SMTPSecure = 'ssl';                           
        $mail->Port = 465;                                   

        //Send Email
        $mail->setFrom('Jbbilbao80@gmail.com', 'Madridejos Community College');
        
        //Recipients
        $mail->addAddress($email);              
        $mail->addReplyTo('Jbbilbao80@gmail.com');
        
        //Content
        $mail->isHTML(true);                     

        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
		
       $_SESSION['result'] = 'Message has been sent';
	   
    } catch (Exception $e) {
	   $_SESSION['result'] = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
	   
    }
	
	
                if(isset($email, $subject, $message, $sender)){
                    $info = "We've sent a password reset otp to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;

                    header('location: reset-code.php');
                    exit();
                }else{
                    $errors['otp-error'] = "Failed while sending code!";
                }
            }else{
                $errors['db-error'] = "Something went wrong!";
            }
        }else{
            $errors['email'] = "This email address does not exist!";
            
        }
        
    }

    //if user click check reset otp button
    if(isset($_POST['check-reset-otp'])){
        $_SESSION['info'] = "";
        $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
        $check_code = "SELECT * FROM mccea WHERE OTP = $otp_code";
        $code_res = mysqli_query($con, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $email = $fetch_data['email'];
            $_SESSION['email'] = $email;
            $info = "Please create a new password.";
            $_SESSION['info'] = $info;
            header('location: createnewpassword.php');
            exit();
        }else{
            $errors['otp-error'] = "You've entered an incorrect code!";
        }
    }

    //if user click change password button
    if(isset($_POST['change-password'])){
        $_SESSION['info'] = "";
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
        if($password !== $cpassword){
            $errors['password'] = "Confirm password not matched!";
        }else{
            $code = 0;
            $email = $_SESSION['email']; //getting this email using session
            $encpass = password_hash($password, PASSWORD_DEFAULT);
            $update_pass = "UPDATE mccea SET OTP = $code, password = '$encpass' WHERE email = '$email'";
            $run_query = mysqli_query($con, $update_pass);
            if($run_query){
                $info = "Your password has been reset. You can now login with your new password.";
                $_SESSION['info'] = $info;
                header('Location: backtologin.php');
            }else{
                $errors['db-error'] = "Failed to change your password!";
            }
        }
    }
    
   //if login now button click
   // if(isset($_POST['login-now'])){
     //   header('Location: login.php');
    //}
?>