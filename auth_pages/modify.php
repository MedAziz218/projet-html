<?php
require 'database.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>MODIFY</title>
    
    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">
    <!-- CSS File -->
    <link rel="stylesheet" href="css.css">
</head>
<body>

    <!--<div class="box">-->
        <div class="form-bx">
            <div class="form-value">
                <h2 style="color: #dc6315;">Modify</h2>
                  <form  method="POST">
                      <div class="inputbox">
                          <ion-icon name="lock-closed-outline"></ion-icon>
                          <input type="password" name="password" required>
                          <label style="color: #dc6315;">New Password</label>
                      </div>
                      <div class="inputbox">
                          <ion-icon name="lock-closed-outline"></ion-icon>
                          <input type="password" name="conf" required>
                          <label style="color: #dc6315;">confirm New Password</label>
                      </div>
                      <p id="error" style="color: red; display: none;">Passwords do not match.</p>
                      <p id="nb" style="color: red; display: none;">Password should be more then 8 characteres...</p>
                      <button name="button" class="btn btn1" id="up">Modify</button> 
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
if (isset($_POST["button"])) {
    $password=$_POST["password"];
    $conf_pass=$_POST["conf"];
   if ($password!=$conf_pass){    
        echo "<script>document.getElementById(\"error\").style.display = \"block\";</script>";
    }else if (strlen($password)<8){    
        echo "<script>document.getElementById(\"nb\").style.display = \"block\";</script>";
    }else {
        
        include("database.php");
        $hash=password_hash($password,PASSWORD_DEFAULT);///////
            $a=$_SESSION["email"];
            $sql="UPDATE user
            SET password = '$hash'
            WHERE email = '$a'";
            mysqli_query($conn,$sql);
            mysqli_query($conn,"commit");
            mysqli_close($conn);
            header("Location: log_in.php");//////////////////////////
    }
}

?>