<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

<link rel="stylesheet" type="text/css" href="css/login.css"/>
<!--                 under here is script                                        -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/login.js"></script>
<title>趣学-后台管理登录</title>
</head>

<body>
	<div id="container">
        <img id="bg" src="image/img_background.png">
        	<div id="form">
            	<embed id="quxueicon" src="image/Combined Shape.svg" width="108px" height="108px"></embed>
                <input id="username" name="username" type="text" placeholder="请输入用户名"/>
                <p id="notice1">请输入正确的用户名</p>
                <input id="password" name="password" type="password" placeholder="请输入6~20位密码"/>
                <p id="notice2">请输入正确的密码</p>
                <input id="login" name="login" value="登录" type="button"/>
            </div>
        
    </div>
    <form id="subform" action="index.php" method="post" style="display:none">
    	<input id="subun" type="hidden" name="userid">
    </form>
<script type="text/javascript">
$(document).ready(function(){
	
	
	
	

	
	$("#username").keyup(function(){
		var username=$("#username").val();
		$.ajax({
				type: 'POST',
				url: 'phpbase/ajaxselect.php',
				data:{
					"sql":"select*from administrator where adminid='"+username+"'"
				},
				async: false, 
				success: function (data) {
					
					var result=eval("("+data+")");
					if(result==""){
						$("#notice1").css({"visibility":"visible"});
					}
					if(result!=""){
						$("#notice1").css({"visibility":"hidden"});	
					}
					
					
				}
		   
		});
	});
	$("#password").focus(function(){
			$("#notice2").css({"visibility":"hidden"});
			
	});
	$("#password").click(function(){
			$("#notice2").css({"visibility":"hidden"});
			
	});
	$("#password").keydown(function(){
			$("#notice2").css({"visibility":"hidden"});
			
	});
	
	document.onkeydown=function(event){
            var e = event || window.event || arguments.callee.caller.arguments[0];
            
             if(e && e.keyCode==13){ 
			 	login();
             }
        }; 
	$("#login").bind('click',function(){
		login();
	});
	function login(){
		var username=$("#username").val();
		var getpw=$("#password").val();
		var dbpw="";
		
		if(username!=""&&getpw!=""){
			$.ajax({
			
				type: 'POST',
				url: 'phpbase/ajaxselect.php',
				data:{
					"sql":"select*from administrator where adminid='"+username+"'"
				},
				async: false, 
				success: function (data) {
					
					var result=eval("("+data+")");
					
					if(result==""){alert("未知错误！请联系开发者1220347113@qq.com");}
					else{
						dbpw=result[0][3];
						
						if(dbpw==getpw){
							$("#notice2").css({"visibility":"hidden"});
							 
							 var successusername=$("#username").val();
							 $("#subun").val(successusername);
										
									    
							 $("#subform").submit();	        
						}else{
							$("#notice2").css({"visibility":"visible"});	
						}
					}
					
				}
		   
			});
		}	
	}
	
});
</script>

    
</body>
</html>