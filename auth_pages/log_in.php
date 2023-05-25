<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION['id'])){
    header("Location: ../main_pages");
}
?>

<html lang="en">

<head>

    <title>LOG IN</title>
    
    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">

    <!-- CSS File -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css.css">
    <style>
        .dot{
            position: absolute;
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
    <!--<div class="box">-->
        <div class="form-bx">
            <div class="form-value">
                <span class="dot"  onclick="window.location.href='../';"><i class="fa fa-home"></i></span>
                <h2 style="color: #dc6315;margin-top:5px;">Login</h2>
                <form  method="POST">
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="email" name="email" required>
                        <label style="color: #dc6315;" >E-mail</label>
                    </div>
                    <p id="err" style="color: red; display: none;">Don't have an account... <a href="sign_up.php">Register now</a></p>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="password" required>
                        <label style="color: #dc6315;" >Password</label>                       
                    </div>
                    <p id="error" style="color: red; display: none;">Invalid password. Please try again.</p>
                    <!-- <label for="myCheckbox">Check this box:</label>
                    <input type="checkbox" id="myCheckbox"> -->
                    <div class="" style="margin-left:auto;margin-right:auto; margin-bottom:10px; margin-top:-10px;">
                        <label style="color: #dc6315;justify-content: center;" >Remember me </label>                       
                        <input type="checkbox" name="checkbox" >

                    </div>
                    <button name="button" class="btn btn1">Log in</button>                           
                    <div class="register">
                        <p>Don't have an account... <a href="sign_up.php">Register now</a></p>
                        <p><a name="forget" href="forget.php">Forget password?</a></p>
                    </div>
                </form>
            </div>
        </div>    
    <!--</div>-->
</body>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>
<?php
if (isset($_POST["button"])) {
include("database.php");
$password=$_POST["password"];
$email=$_POST["email"];


$mot_de_passe=0;
$exist=true;
$sql="SELECT * FROM user";
$result=mysqli_query($conn,$sql);
if (mysqli_num_rows( $result)>0) {
   $row =mysqli_fetch_all($result);
   foreach($row as $i){
       if ($i[0]==$email) {
          $exist=false;
          $mot_de_passe=$i[1];
          break; 
        }
    }
}
if ($exist) {    
    echo "<script>document.getElementById(\"err\").style.display = \"block\";</script>";
}else if (password_verify($password,$mot_de_passe)) {    
    $_SESSION["email"] = $email;
    $_SESSION["remember_me"] = 1;
    if (isset($_POST['checkbox'])){ $_SESSION["remember_me"] = 1;}
    $_SESSION["id"] = session_id();
    header("Location: ../main_pages/createOrjoin.php");////////////////////////////////////////////////////
    
}else{
    echo "<script>document.getElementById(\"error\").style.display = \"block\";</script>" ;
}
}
?>