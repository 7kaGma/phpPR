<?php
$test = "Wryyyy\n";
echo $test;
echo "<br>";
$test2 =json_encode($test);
echo $test2;
$test3 =str_replace("\\n","JOJO",$test2);
echo "<br>";
echo $test3;
?>