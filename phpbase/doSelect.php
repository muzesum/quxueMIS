<?php 
function doSelect($sql){
	include_once("DBconn.php");
	if(!$conn){
		die("error:".$conn->connect_error);
	}
	
	$result=mysqli_query($conn,$sql);
	$css=$result->fetch_all();
	$v=json_encode($css);
	
	
	$conn->close();
	return $v;
}
?>