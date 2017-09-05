<?php 
include_once("doWriteDB.php");
$sql=$_POST['sql'];
$x=doWriteDB($sql);
echo $x;
?>