<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/index.css"/>
<!--                 under here is script                                        -->
<script type="text/javascript" src="js/jquery.min.js"></script>

<title>趣学-后台</title>
</head>

<body style="overflow-x:hidden;">
	<div id="left-menu">
    	<div id="menu-top">
        	<img id="headphoto" src="http://112.74.213.69/android/pictures/userhead/head1.jpg"/>
            <?php 
				error_reporting(E_ALL || ~E_NOTICE);
				$userid="null";
				$userid=$_POST["userid"];
				error_reporting(0);
				
				
				include_once("phpbase/DBconn.php");
				if($userid!=null&&$_POST!=null){
					if($userid=="null"){$userid="adminnull";echo "cuowu";}
					$sql="select*from administrator where adminid='".$userid."'";
					$result=mysqli_query($conn,$sql);
					$s=mysqli_fetch_array($result);
					$dbadminname=$s['adminname'];
					$dbrank=$s['rank'];
					$dblastlogin=$s['lastlogin'];
					
					$html='<div id="info">';
						$html.='<p id="username">'.$dbadminname.'</p>';
						$html.='<p id="rank">'.$dbrank.'</p>';
						$html.='<p id="lastlogin">上次登录:'.$dblastlogin.'</p>';
					$html.='</div>';
					echo $html;
				}else{
					$html='<div id="info">';
						$html.='<a href="login.php" id="username">请登录</a>';
					$html.='</div>';
					echo $html;
				}
			?>
            
        </div>
        <div class="bord"></div>
    	<div id="menu-middle">
        	<div id="mb1" class="menubutton">
            	<div id="cs1" class="chosen"></div>
                <div id="mbp1" class="menubutton-p">众筹管理</div>
                <div id="no1" class="messageno"></div>
            </div>
            <div id="mb2" class="menubutton">
                <div id="cs2" class="chosen"></div>
                <div id="mbp2" class="menubutton-p">教师管理</div>
                <div id="no2" class="messageno"></div>
            </div>
            <div id="mb3" class="menubutton">
            	<div id="cs3" class="chosen"></div>
                <div id="mbp3" class="menubutton-p">用户管理</div>
                <div id="no3" class="messageno"></div>
            </div>
            <div id="mb4" class="menubutton">
            	<div id="cs4" class="chosen"></div>
                <div id="mbp4" class="menubutton-p">热点管理</div>
                <div id="no4" class="messageno"></div>
            </div>
        </div>
        <div class="bord"></div>
    	<div id="menu-bottom">
        	<div class="bottommenubutton"><p style="margin:30px 227px 30px 50px" class="menubutton-p" >修改密码</p></div>
            <div class="bottommenubutton"><p style="margin:30px 186px 30px 50px" class="menubutton-p">查看登录记录</p></div>
            <div class="bottommenubutton"><p style="color: #1867FF;margin:30px 268px 30px 50px" class="menubutton-p">登出</p></div>
        </div>
    </div>
    <!--<form id="subform" action="index.php" method="post" style="display:none">
    	<input id="subun" type="hidden" name="userid">
    </form>-->
    
    <iframe id="mainframe" frameborder="no">
    </iframe>
    
    <script type="text/javascript">
    $(document).ready(function(){
		$(".messageno").css({"visibility":"hidden"});
		$.ajax({
			type: 'POST',
				url: 'phpbase/ajaxselect.php',
				data:{
					"sql":"select count(*) new from raisecourse where stage=1"
				},
				async: false, 
				success: function (data) {
					
					var result=eval("("+data+")");
					var newinfo=result[0][0];
					
					if(newinfo<=9){
						$("#no1").css({
							"width":"20px",
							"margin-left":"157px"
						});
					}
					if(newinfo>9&&newinfo<=99){
						$("#no1").css({
							"width":"50px",
							"margin-left":"147px"
						});
					}
					if(newinfo>99){
						$("#no1").css({
							"width":"40px",
							"margin-left":"137px"
						});	
					}
					if(newinfo>999){
						newinfo=999;
						$("#no1").css({
							"width":"40px",
							"margin-left":"137px"
						});
					}	
					
					
					if(newinfo!=0){
						$("#no1").html(newinfo);
						$("#no1").css({"visibility":"visible"});	
					}
					
				}
		});
		$.ajax({
			type: 'POST',
				url: 'phpbase/ajaxselect.php',
				data:{
					"sql":"select count(*) new from teacher where stage=1"
				},
				async: false, 
				success: function (data) {
					
					var result=eval("("+data+")");
					var newinfo=result[0][0];
					
					if(newinfo<=9){
						$("#no1").css({
							"width":"20px",
							"margin-left":"157px"
						});
					}
					if(newinfo>9&&newinfo<=99){
						$("#no1").css({
							"width":"30px",
							"margin-left":"147px"
						});
					}
					if(newinfo>99){
						$("#no1").css({
							"width":"40px",
							"margin-left":"137px"
						});	
					}
					if(newinfo>999){
						newinfo=999;
						$("#no1").css({
							"width":"40px",
							"margin-left":"137px"
						});
					}	
					
					
					if(newinfo!=0){
						$("#no2").html(newinfo);
						$("#no2").css({"visibility":"visible"});	
					}
					
				}
		});
		$("#mainframe").attr("src","frame1.php");
		$("#cs1").css({
			"visibility":"visible"	
		});	
		var mbp;
		$(".menubutton-p").click(function(e){
			var id = $(e.target).attr('id');
			var no=id.substr(3);
			
			mbp=no;
			
			
		});
		$(".menubutton").click(function(e){
			var id = $(e.target).attr('id');
			var no=id.substr(2);
				if(mbp!=null){no=mbp;}
				$("#mainframe").attr("src","frame"+no+".php");	
				$(".chosen").css({
					"visibility":"hidden"	
				});
				$("#cs"+no).css({
					"visibility":"visible"	
				});
				mbp=null;
				
		});
		
	});
    </script>
    <script type="text/javascript">
	var adminid="<?php echo $userid;?>";//父页面的adminid一定要单独在一个sript标签内或者放到sript标签内的最后才能被子页面读取到
	</script>
    
</body>
</html>