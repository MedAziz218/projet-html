<!DOCTYPE html>
<?php
session_start();

if(empty($_SESSION["id"])){
  header("Location: ../index.html"); 
}

// if (empty($_SESSION["remember_me"])){
//   session_destroy();
// }
if (isset($_GET['join'])) {
    join_room();
  }
if (isset($_GET['create'])) {
  create_room();
}
if (isset($_GET['tryAgain'])) {
    if ($_GET['tryAgain']==2) {
        echo '<script>alert("No room with this name exists, make sure to enter the right name please."); location.href="createOrjoin.php";</script>';
    }
    if ($_GET['tryAgain']==1) {
        echo '<script>alert("A room with this name exists already, please enter another name."); location.href="createOrjoin.php"</script>';
    }
    unset($_GET['tryAgain']);
    

}

function join_room(){
    include("database.php");    
    $name = $_GET['join']; unset($_GET['create']);
    $exist=true;

    try{
        $sql="Select * from $name;";
        $result=mysqli_query($conn,$sql);
        
       
    }catch (Exception) {
        $exist=false;
        header("Location: createOrjoin.php?tryAgain=2");
    }
   
    if ($exist){
        echo "<script>alert('room found! joining now');location.href='index.php?room=$name';</script>";
    }
}
function create_room(){
    include("database.php");    
    $name = $_GET['create'];
    unset($_GET['create']);
    $_GET['create'] = "";
    $exist=true;

    try{
        $sql="Select * from $name;";
        $result=mysqli_query($conn,$sql);
       
        header("Location: createOrjoin.php?tryAgain=1");
    }catch (Exception) {
        $exist=false;
        

    }
    if (!$exist){
        // $sql="create TABLE $name(action VARCHAR(200) , date DATETIME NULL DEFAULT CURRENT_TIMESTAMP PRIMARY KEY);";
        $sql="CREATE TABLE $name(vidOrder INT NOT NULL , vidID TEXT NOT NULL , 
                playing BOOLEAN NULL DEFAULT NULL , time TIME NULL DEFAULT NULL ,
                 PRIMARY KEY (vidOrder) );";
        $result=mysqli_query($conn,$sql);
        echo "<script>alert('room created successfully ! joining now');location.href='index.php?room=$name';</script>";

    }
    
}
?>

<html>
  <head>
    <title>main Page </title>
    <link rel="stylesheet" href="_css/createOrjoin.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">     
    <!-- <script type="text/javascript" src="https://tiiny.host/ad-script.js"></script><script defer data-domain="projethtml.tiiny.site" src="https://analytics.tiiny.site/js/plausible.js"></script></head> -->
</head>
<body>
<div class="buttons-container">
  <button class="button-arounder" onclick="create();">Create Room</button>
  <button class="button-arounder" onclick="join();">Join Room</button>

</div>

</body>
<script>
    function create(){
        let name = prompt("Please enter a name for the Room ");
        if (name != null) {
        location.href = `createOrjoin.php?create=${name}`

}
    }
    function join(){
        let name = prompt("Please enter a name for the Room ");
        if (name != null) {
        location.href = `createOrjoin.php?join=${name}`

        }
    }
</script>
</html>