<?php

include "config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$basename = basename($_SERVER['HTTP_REFERER']);
$basename_replace = str_replace($basename, "reset_password.php", $_SERVER['HTTP_REFERER']);

$str_code = rand(100000, 10000000);
$reset_code = str_shuffle("abcdefghijklmnopqrstuvwxyz");

$url = $basename_replace. "?resetLink=".$reset_code;

if (isset($_POST['resetLink'])) {
    
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sqlSelect = "SELECT * FROM user WHERE email = '".$email."' AND status = 'active'";
    $resultSelect = mysqli_query($conn, $sqlSelect);
    if (mysqli_num_rows($resultSelect) > 0) {
        
        require 'phpmailer/src/Exception.php';
        require 'phpmailer/src/PHPMailer.php';
        require 'phpmailer/src/SMTP.php';

        $mail = new PHPMailer(true);
        
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Port = 465;
        $mail->Username = 'pangantiaditya@gmail.com';
        $mail->Password = 'isgdqmvuzslzmrnl';
        $mail->SMTPSecure = 'ssl';
        $mail->From = 'pangantiaditya@gmail.com';
        $mail->FromName = 'Reset Password Link';
        $mail->addAddress($email);
        $mail->WordWrap = 50;
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password Link';

        $message_body = '<p>For reset password, please click to given link <b>'.$url.'</b>.</p> <p>Sincerely,</p>';
        $mail->Body = $message_body;

        if($mail->Send())
        {
            $sqlUpdate = "UPDATE user SET reset_code = '".$reset_code."' WHERE email = '".$email."'"; 
            $resultUpdate = mysqli_query($conn, $sqlUpdate);
            if ($resultUpdate) { 
                echo '<script>alert("Please Check Your Email for Reset password")</script>';
                header('Refresh:1; url=index.php');
            }
            else {
                echo "<script>alert('Something went wrong');</script>";
            }
        }
        else
        {
            $message = $mail->ErrorInfo;
            echo '<script>alert("'.$message.'")</script>';
        }
    }
    else {
        echo "<script>alert('No account found');</script>";
    }
}
?>

<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
    <div class="wrapper">
        <div class="otp">
            <h2>Forgot Password</h2>
            <hr>
            <form action="" method="POST">
                <div class="form-group">
                    <label>Registered Email</label>
                    <input type="email" name="email" placeholder="Enter your registered email" autocomplete="off">
                </div>
                <div class="form-group">
                    <label></label>
                    <input type="submit" name="resetLink" value="Submit">
                </div>
            </form>
        </div>
    </div>
</body>
<script type="text/javascript" src="js/jquery.min.3-4-1.js"></script>
</html>
