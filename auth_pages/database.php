<?php

$db_server="localhost";
$db_user="root";
$db_pass="";
$db_name="watchSynced";
$conn="watch";
try {
    $conn=mysqli_connect($db_server,$db_user,$db_pass,$db_name);
} catch (mysqli_sql_exception) {
    echo "<script>alert(\"base Could not connect !\")</script>";
}
if (!$conn){
    echo "<script>alert(\"base Could not connect !\")</script>";
}
?>