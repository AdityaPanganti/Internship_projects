<?php
include "config.php";

date_default_timezone_set("Asia/Kolkata");

if (isset($_POST['verify'])) {
    if (isset($_GET['code'])) {
        
        $activation_code = $_GET['code'];
        $otp = $_POST['otp'];

        $sqlSelect = "SELECT * FROM user WHERE activation_code = '".$activation_code."'";
        $resultSelect = mysqli_query($conn, $sqlSelect);
        if (mysqli_num_rows($resultSelect) > 0) {
            
            $rowSelect = mysqli_fetch_assoc($resultSelect);

            $rowOtp = $rowSelect['otp'];
            $rowSignupTime = $rowSelect['signup_time']; 

            $rowSignupTime = date('d-m-Y h:i:s',strtotime($rowSignupTime));
            $rowSignupTime = date_create($rowSignupTime);    
            date_modify($rowSignupTime, "+1 minutes");
            $timeUp = date_format($rowSignupTime, 'd-m-Y h:i:s');

             if ($rowOtp !== $otp) {
                echo "<script>alert('Please provide correct OTP')</script>";
             }
             else {
                if (date('d-m-Y h:i:s') >= $timeUp) {
                    echo "<script>alert('Otp expired!')</script>";
                    header("Refresh:1; url-index.php");
                  }
                  else {
                    $sqlUpdate = "UPDATE user SET status = 'active' WHERE otp = '".$otp."' AND activation_code = '".$activation_code."'";
                    $resultUpdate = mysqli_query($conn, $sqlUpdate);
                    
                    if ($resultUpdate) {
                       
                        echo "<script>alert('Your Account Successfully Activated')</script>";
                        header("Refresh:1; url=index.php");

                    }
                    else {
                        echo "<script>alert('Your Account Failed to Activated')</script>";
                    }
                  }
             }
        }
        else{
            header("Location: index.php");
            exit;
        }
    }
}

?>

<html>
    <head>
        <title>OTP page</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>

    <body>
        <div class="wrapper">
            <div class="otp">
                <h2>OTP Verify</h2>
                <hr>
                <form action="" method="POST">
                    <div class="form-group">
                        <label>ENTER OTP</label>
                        <input type="text" name="otp" placeholder="Enter otp to verify email" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label></label>
                        <input type="submit" name="verify" value="Verify">
                    </div>
                </form>
            </div>
        </div>
    </body>

    <script type="text/javascript" src="js/jquery.min.3-4-1.js"></script>

    </html>