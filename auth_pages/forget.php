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
    <title>FORGET</title> 
</head>
<body>
<!--<div class="box">-->
        <div class="form-bx">
            <div class="form-value">
                <h2 style="color: #dc6315;">FORGET</h2>
                  <form method="POST">
                      <div class="inputbox">
                          <ion-icon name="mail-outline"></ion-icon>
                          <input type="text" name="email" required>
                          <label style="color: #dc6315;">Your email:</label>
                      </div>
                      <p id="conf"  style="color: red; display: none ">Incorrect email !</p>
                      <button name="button" class="btn btn1" id="up">verify</button> 
                      
                  </form>
                </form>
            </div>
        </div>    
    <!--</div>-->
</body>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>
<?php
include("database.php");
use PHPMailer\PHPMailer\PHPMailer;
require_once("PHPMailer-master/src/PHPMailer.php");
require_once("PHPMailer-master/src/SMTP.php");
if (isset($_POST["button"])) {
    $email=$_POST["email"];
    $_SESSION["email"]=$email;
    $exist=true;
    $sql="SELECT * FROM user";
    $result=mysqli_query($conn,$sql);
    mysqli_close($conn);
    if (mysqli_num_rows( $result)>0) {
       $row =mysqli_fetch_all($result);
       foreach($row as $i){
           if ($i[0]==$email) {
              $exist=false;
              break; 
            }
        }
    }
    if ($exist){    
      echo "<script>document.getElementById(\"conf\").style.display = \"block\";</script>";
    }else{    
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
    $mail->Subject = 'Password Reset !';
    $verification=rand(1000,9999);
    $_SESSION["verif"]=$verification;
    $mail->Body = 'Your verification code '.strval($verification);
    $mail->send();
    $_SESSION["id"]="forget";
    header("Location: verif.php");
    }
}
?>