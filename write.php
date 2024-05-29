<?php

ini_set( 'display_errors', 1 );

$name=$_POST["name"];
$age=$_POST["age"];
$gender=$_POST["gender"];
$expectation=$_POST["expectation"];
$thoughts=$_POST["thoughts"];
$br=",";

$str=date("Y-m-d H:i:s").$br.$name.$br.$age.$br.$gender.$br.$expectation.$br.$thoughts;
$file=fopen("./data.txt","a");
fwrite($file,$str."\n");
fclose($file);

header("Location:./index.php");
?>
