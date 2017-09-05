<?php 
	
	function doWriteDB($sql){
		include_once("DBconn.php");
		if(!$conn){
		die("error:".$conn->connect_error);
		}
		
		$result=mysqli_query($conn,$sql);
		if($result){
			$v=true;
		}else{$v=false;}
		
		
		
		$conn->close();
		return $v;
	}
	
?>