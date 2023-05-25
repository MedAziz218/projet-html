<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">
    <!-- CSS File -->
    <link rel="stylesheet" href="css.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify</title> 
</head>
<body>
<!--<div class="box">-->
        <div class="form-bx">
            <div class="form-value">
                  <h2 style="color: #dc6315;">Verify</h2>
                  <h4>Thank You For Signing Up!</h4><br>
                  <h5>check the confirmation email</h5>
                  <h6>Note: If you do not receive the email in few minutes:
                  <ul>
                    <li>check spam folder</li>
                    <li>verify if you typed your email correctly</li>

                  </ul>
                  </h6>
                  <form method="POST">
                      <div class="inputbox">
                          <input type="text" name="verif" required>
                          <label style="color: #dc6315;">Verification Code:</label>
                      </div>
                      <p id="conf"  style="color: red; display: none ">Incorrect code !</p>
                      <p id="confirm" style="display: none;"><button class="btn btn1" name="resend" id="up">Resend code</button></p>
                      <button name="button" class="btn btn1" id="up">verify</button> 
                      
                  </form>
                </form>
            </div>
        </div>    
<!--</div>-->
</body>

</html>
<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once("PHPMailer-master/src/PHPMailer.php");
require_once("PHPMailer-master/src/SMTP.php");
include("database.php");
if (isset($_POST["button"])) {
    if ($_POST["verif"]==$_SESSION["verif"]) {
        if ($_SESSION["id"]=="forget") {
            header("Location: modify.php");
        }else {
            $hash=$_SESSION["hash"];
            $email=$_SESSION["email"];
            $username=$_SESSION["username"];
            $birthdate=$_SESSION["birthdate"];
            $gender=$_SESSION["gender"];
            // $sql="INSERT INTO user (username,birthdate,gender,email,password) VALUES ('$username','$birthdate','$gender','$email','$hash')";////////////
            $sql="INSERT INTO user (email,password) VALUES ('$email','$hash')";////////////
            mysqli_query($conn,$sql);
            mysqli_query($conn,"commit");
            mysqli_close($conn);
            session_destroy();
            header("Location: log_in.php");/////////////////////////////////
        }
        
    }else {
        echo "<script>document.getElementById(\"conf\").style.display = \"block\";</script>";
        echo "<script>document.getElementById(\"confirm\").style.display = \"block\";</script>";
    }    
}
if (isset($_POST["resend"])){
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host='smtp.gmail.com';
    $mail->SMTPAuth=true;
    $mail->Username='syncedwatch@gmail.com';
    $mail->Password='tnguokkikwyxzxoj';
    $mail->SMTPSecure='ssl';
    $mail->Port=465;
    $mail->setFrom('syncedwatch@gmail.com','watch synced');
    $mail->addAddress($_SESSION["email"]);
    $mail->isHTML(true);
    $mail->Subject = 'signing up!';
    $verification=rand(1000,9999);
    $_SESSION["verif"]=$verification;
    $mail->Body = 'Your verification code '.strval($verification);
    $mail->send();
    header("Location: verif.php");
}
?>