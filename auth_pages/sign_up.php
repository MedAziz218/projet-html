<?php
session_start();
if (isset($_SESSION['id'])){
    header("Location: ../main_pages");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>SIGN UP</title>
    
    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">
    <!-- CSS File -->
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .dot{
            position: absolute;
            left: 30px;
            top:10px;
            justify-content: center;
            align-content: center;
            align-items: center;
            height: 25px;
            width: 25px;
            background: transparent;
            border-radius: 50%;
            display: inline-block;
            font-size: 2rem;
            padding: 3px;
            cursor: pointer;
            color:#b1b1b1 ;
        }
    </style>
    
</head>
<body>

   <!-- <div class="box">-->
        <div class="f-bx">
            <div class="form-value">
                <span class="dot"  onclick="window.location.href='../';"><i class="fa fa-home"></i></span>

                <h2 style="color: #dc6315; margin: 40px auto -20px auto;">Sign Up</h2>

                  <form  method="POST" id="myForm" style="display: block;flex-direction: column; justify-content: center; align-items: center;">
                      <div class="inputbox" id="username" style="margin-left: auto; margin-right: auto;" >
                          <input type="text" id="username"  name="username" required>
                          <label style="color: #dc6315;">Username</label>
                      </div>
                      
                      <div class="inputbox" id="email" style="margin-left: auto; margin-right: auto;" >
                          <ion-icon name="mail-outline"></ion-icon>
                          <input type="email" id="im"  name="email" required>
                          <label style="color: #dc6315;">E-mail</label>
                      </div>
                      <p id="err" style="color: red; display: none;  margin-bottom:-14px;margin-top:-24px;">email used !.</p>
                      <div class="inputbox"  style="margin-left: auto; margin-right: auto;">
                          <ion-icon name="lock-closed-outline"></ion-icon>
                          <input type="password" name="password" required>
                          <label style="color: #dc6315;">Password</label>
                      </div>
                      <div class="inputbox"  style="margin-left: auto; margin-right: auto;">
                          <ion-icon name="lock-closed-outline"></ion-icon>
                          <input type="password" name="conf" required>
                          <label style="color: #dc6315;">confirm_password</label>
                      </div>
                      <p id="error" style="color: red; display: none; margin-bottom:2px;">Passwords do not match.</p>
                      <p id="nb" style="color: red; display: none; margin-bottom:2px;">Password should be more then 8 characteres...</p>
                      <p id="invalid" style="color: red; display: none; margin-bottom:2px;">Invalid Email</p>
                      
                      <button name="button" class="btn btn1" id="up">Sign up</button> 
                      <div class="register" style="margin-top:7px;">
                         <p>Already have an account... <a href="log_in.php">Login now</a></p>
                     </div>
                  </form>
                
            </div>
        </div>    
   <!-- </div>-->
</body>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</html>
<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once("PHPMailer-master/src/PHPMailer.php");
require_once("PHPMailer-master/src/SMTP.php");
include("database.php");
if (isset($_POST["button"])) {
    $password=$_POST["password"];
    $conf_pass=$_POST["conf"];
    $email=$_POST["email"];
    $_SESSION["email"]=$email;
    $_SESSION["id"]="sign";
    $exist=false;
    $sql="SELECT * FROM user";
    $result=mysqli_query($conn,$sql);
    if (mysqli_num_rows( $result)>0) {
       $row =mysqli_fetch_all($result);
       foreach($row as $i){
           if ($i[0]==$email) {
              $exist=true;
              break; 
            }
        }
    }
    if ($exist){    
      echo "<script>document.getElementById(\"err\").style.display = \"block\";</script>";
    }else if ($password!=$conf_pass){    
        echo "<script>document.getElementById(\"error\").style.display = \"block\";</script>";
    }else if (strlen($password)<8){    
        echo "<script>document.getElementById(\"nb\").style.display = \"block\";</script>";
    }else {
        $hash=password_hash($password,PASSWORD_DEFAULT);
        $_SESSION["email"]=$email;
        $_SESSION["hash"]=$hash;
        // $sql="INSERT INTO user (email,password) VALUES ('$email','$hash')";////////////
        // mysqli_query($conn,$sql);
        // mysqli_query($conn,"commit");
        // mysqli_close($conn);
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host='smtp.gmail.com';
        $mail->SMTPAuth=true;
        $mail->Username=''; //mail name 
        $mail->Password='';//mail password
        $mail->SMTPSecure='ssl';
        $mail->Port=465;
        $mail->setFrom('','watch synced');

        try{
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'signing up!';
            $verification=rand(1000,9999);
            $mail->Body = 'Your verification code '.strval($verification);
            $mail->send();

            $_SESSION["verif"]=$verification;
            header("Location: verif.php");
        }
        catch (Exception){
             echo "<script>document.getElementById(\"invalid\").style.display = \"block\";</script>";
        }
        
        
       
    }
}

?>
