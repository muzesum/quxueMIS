<?php 
include_once("doSelect.php");
$sql=$_POST['sql'];
$x=doSelect($sql);
echo $x;
?>