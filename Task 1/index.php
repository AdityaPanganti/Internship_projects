<?php
include "config.php";
session_start();

if (isset($_SESSION['id'])) {
    header("Location: home.php");
    exit(); // Ensure script stops after redirecting
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to hash passwords securely
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// LOGIN PROCESS CODE
if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Password not hashed here

    $sqlLogin = "SELECT * FROM user WHERE email = ? AND status = 'active'";
    $stmt = mysqli_prepare($conn, $sqlLogin);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultLogin = mysqli_stmt_get_result($stmt);
    
    if(mysqli_num_rows($resultLogin) > 0) {
        $rowLogin = mysqli_fetch_assoc($resultLogin);
        
        if (password_verify($password, $rowLogin['password'])) {
            // Password verification successful
            $_SESSION['id'] = $rowLogin['uid'];
            $name = $rowLogin['name'];

            // Don't store password in cookies
            setcookie('username', $name);

            header("Location: home.php");
            exit(); // Ensure script stops after redirecting
        } else {
            echo "<script>alert('Wrong password')</script>";
        }
    } else {
        echo "<script>alert('No user exists with this email')</script>";
    }
}

// Registration and Email Verification
if (isset($_POST['register'])) {
    $otp = substr(str_shuffle("0123456789"), 0, 5);
    $activation_code = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 10);

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = hashPassword($_POST['password']); // Hash password securely
    
    $sqlInsert = "INSERT INTO user (name, email, password, otp, activation_code) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sqlInsert);
    mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $password, $otp, $activation_code);
    
    if (mysqli_stmt_execute($stmt)) {
        // Send email verification
        require 'phpmailer/src/Exception.php';
        require 'phpmailer/src/PHPMailer.php';
        require 'phpmailer/src/SMTP.php';

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->SMTPDebug = 2;  // Enable verbose debug output
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587; // Correct SMTP port for Gmail
        $mail->Username = '#';
        $mail->Password = '#';
        $mail->SMTPSecure = 'tls'; // Use TLS instead of SSL
        $mail->setFrom('#', '#');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Verification code to verify your Email Address';
        $mail->Body = '<p>For verifying your email address, enter this verification code when prompted: <b>'.$otp.'</b>.</p><p>Sincerely,</p>';

        if($mail->send()) {
            echo '<script>alert("Please Check Your Email for Verification Code")</script>';
            header('location:email_verify.php?code='.$activation_code);
            exit(); // Ensure script stops after redirecting
        } else {
            echo '<script>alert("Failed to send verification email")</script>';
        }
    } else {
        echo '<script>alert("Failed to register user")</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Signup Page</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<nav class="navbar">
        <div class="logo_item">
         
          <img src="img/target.jpg" ></i><font color="white" ><a href="1.html" style="color:#29539f; text-decoration: none; font-size: 22px;">Target Audience Navigator</a></font>
         </div>
        <font align="left">  <a href="1.html" style="color:#29539f; text-decoration: none; font-size: 15px;">Home</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        <a href="aboutus.php" style="color:#29539f; text-decoration: none; font-size: 15px;">About us</a></font>
        </div>
      </nav>
    <div class="wrapper" id="login-side">
        <div class="left-side">
            <h2>Login</h2>
            <hr>
            <form action="" method="POST">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="abc@gmail.com" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="******" autocomplete="off" required> 
                </div>
                <div class ="form-group-extra">
                    <input type="checkbox" name="rememberme" value="checked">
                    <label class="rem">Remember me &nbsp</label>
                    <label class="forgot"><a href="forgot_password.php"> Forgot Password?</a></label>
                </div>
                <div class="form-group">
                    <label></label>
                    <input type="submit" name="login" value="Login">
                </div>       
            </form>
        </div>
        <div class="container"></div>
        <div class="right-side" id="signup-text-side">
            <h2>Registered</h2>
            <hr>
            <div class="right-side-text">
                <p>Don't have an account?</p>
                <p>Please click signup button for registration</p>
                <a href="#" id="signup-button">Signup</a>
            </div>
        </div>
    </div>

    <div class="wrapper display" id="signup-side">
        <div class="left-side signUp">
            <h2>Signup</h2>
            <hr>
            <form action="" method="POST">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" placeholder="Your Name" autocomplete="off" required>
                </div> 
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="abc@gmail.com" autocomplete="off" required>
                </div> 
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="******" autocomplete="off" required>
                </div> 
                <div class ="form-group-extra">
                    <input type="checkbox" name="rememberme">
                    <label class="rem">Remember me &nbsp</label>
                    <label class="forgot"><a href="forgot_password.php"> Forgot Password?</a></label>
                </div>
                <div class="form-group">
                    <label></label>
                    <input type="submit" name="register" value="Signup">
                </div>
            </form>
        </div>
        <div class="container"></div>
        <div class="right-side" id="login-text-side">
            <h2>Login</h2>
            <hr>
            <div class="right-side-text">
                <p>Already have an account?</p>
                <p>Please click on Login button for Login</p>
                <a href="interface.html" id="login-button">Login</a>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="js/jquery.min.3-4-1.js"></script>
    <script>
        $(document).ready(function(){
            $('#signup-button').click(function(){
                $('#login-side').addClass('display').fadeOut();
                $('#signup-side').removeClass('display').fadeIn();
            });
            $('#login-button').click(function(){
                $('#signup-side').addClass('display').fadeOut();
                $('#login-side').removeClass('display').fadeIn();
            });
        });
    </script>

</body>
</html>
