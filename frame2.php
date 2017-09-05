<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/frametop.css"/>
<!--                 under here is script                                        -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<title>教师管理</title>
</head>

<body style="overflow-x:hidden">
	<div class="topdiv">
    	<p class="time"></p>
        <div id="btn1" class="headbtn"><p id="btp1" class="headbtn-p">教师审批</p><div id="ud1" class="underline"></div></div>
        <div id="btn2" class="headbtn"><p id="btp2" class="headbtn-p">教师管理</p><div id="ud2" class="underline"></div></div>
        
    </div>
    <div class="datadiv">
    	<iframe id="teacher" style="height:100%;width:100%;border:none;"></iframe>
    </div>
    <script type="text/javascript">
	$(document).ready(function() {
		
		
		$("#teacher").attr("src","tablepage/teacher1.php");
		$("#ud1").css({"visibility":"visible"});
		var ud;
		$(".underline").click(function(e){
			var id = $(e.target).attr('id');
			var no=id.substr(2);
			ud=no;
		});
		$(".headbtn-p").click(function(e){
			var id = $(e.target).attr('id');
			var no=id.substr(3);
			$(".underline").css({
				"visibility":"hidden"	
			});
			$("#ud"+no).css({
				"visibility":"visible"	
			});
			$("#teacher").attr("src","tablepage/teacher"+no+".php");
		});
		$(".headbtn").click(function(e){
			var id = $(e.target).attr('id');
			var no=id.substr(3);
			if(ud!=null){no=ud;}
			$(".underline").css({
				"visibility":"hidden"	
			});
			$("#ud"+no).css({
				"visibility":"visible"	
			});
			$("#teacher").attr("src","tablepage/teacher"+no+".php");
			ud=null;
		});
    	function time() {
		var date = new Date();
		var n = date.getFullYear();
		var y = date.getMonth()+1;
		var t = date.getDate();
		var h = date.getHours();
		var m = date.getMinutes();
		var s = date.getSeconds();
		var day= date.getDay();
		var today = new Array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');  
 		var week = today[day]; 
		
		
		var show=n+"年"+y+"月"+t+"日 "+week+" "+h+":";
		if(m<10){show+="0";}
		show+=m+":";
		if(s<10){show+="0";}
		show+=s;
		$(".time").html(show);
		
		}
		time();
		setInterval(time, 1000);
	});
	var adminid=parent.adminid;
    </script>
</body>
</html>