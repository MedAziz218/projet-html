<?php
$db_server="localhost";
$db_user="root";
$db_pass="";
$db_name="watchsyncedrooms";
$conn="watch";
$table=$_GET['room'];

try {
    $conn=mysqli_connect($db_server,$db_user,$db_pass,$db_name);
    $sql="Select * from $table";
    
    $result=mysqli_query($conn,$sql);
    if (mysqli_num_rows( $result)>0) {
      $row =mysqli_fetch_all($result);
      foreach($row as $i){
          echo "$i[0] $i[1] $i[2] $i[3]\n";
       }
   }
   //  echo $result;

} catch (mysqli_sql_exception) {
    echo "<script>alert(\"base Could not connect !\")</script>";
}

if (!$conn){
    echo "<script>alert(\"base Could not connect !\")</script>";
}
?>