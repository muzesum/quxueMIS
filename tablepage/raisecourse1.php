<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/tablepage.css" />
<link rel="stylesheet" type="text/css" href="../css/dialog.css"/>

<script type="text/javascript" src="../js/jquery.min.js"></script>
<title>待审核众筹</title>
</head>

<body>

<div id="pagination">
	
    <a id="before" class="inline">上一页</a>
    <a class="inline" id="pageinfo"></a>
    <a id="next" class="inline">下一页</a>
    <a id="datainfo" class="inline"></a>
    
</div>
<div><input id="operate" type="button" onclick="showDialog();" value="操作当前项目"><input id="refresh" type="button" value="刷新数据"></div>
<table id="datagrid" cellpadding="30px;"></table>
	<div class="ui-dialog" id="dialogMove" onselectstart='return false;'>
		<div class="ui-dialog-title" id="dialogDrag"  onselectstart="return false;" >
			操作当前众筹
			<a class="ui-dialog-closebutton" href="javascript:hideDialog();"></a>
		</div>
		<p id="dialog-i1"></p>
        <hr/>
        <input id="pass" type="button" value="通过审核"/>
        <input id="refuse" type="button" value="拒绝该众筹"/>
        <br/>
        <label>说明您操作的理由或是备注</label><input id="dialog-i2"/>
	</div>
<script type="text/javascript">
var adminid=parent.adminid;
var tablecursor;
var cursorbefore="-1";
$(document).ready(function(e) {
	var data;
	function getdata(){
		$.ajax({
					type: 'POST',
					url: '../phpbase/ajaxselect.php',
					data:{
						"sql":"select id,studentname,organization,job,teachername,price,unitprice,createtime,classtime,teacher.notes from raisecourse INNER JOIN teacher on teacher.teacherid=raisecourse.teacherid INNER JOIN student on student.studentid=raisecourse.studentid where adminid='"+adminid+"'and raisecourse.stage='1'"
					},
					async: false, 
					success: function (datain) {
						data=datain;
						
					}
			   
		});
	}
	getdata();
	
	function updatetable(pageSize,pageno){
    
					
					$("#datagrid").html("");
					var appendth='<tr class="tr-th">';
					appendth+="<th></th>";
					appendth+="<th>众筹id</th>";
					appendth+="<th>发起者姓名</th>";
					appendth+="<th>讲师所属机构</th>";
					appendth+="<th>讲师职业</th>";
					appendth+="<th>讲师姓名</th>";
					appendth+="<th>讲师要价（元）</th>";
					appendth+="<th>学生最低支付（元）</th>";
					appendth+="<th>发起时间</th>";
					appendth+="<th>开课时间</th>";
					appendth+="<th>讲师简述</th>";
					$("#datagrid").append(appendth);
					var result=eval(data);
					
					var rowCount=result.length;//总记录数
					var cellCount=result[0].length;//列数
					var page=Math.ceil(rowCount/pageSize);
					var firstdata=(pageno-1)*pageSize;
					
					
					
					var lastdata=firstdata+pageSize;
					var currentdata=pageSize;
					if(pageSize*pageno>rowCount&&(rowCount%pageSize)!=0){currentdata=rowCount-firstdata;}
					
					$("#pageinfo").html('第<input id="pageno" onfocus="this.select()" type="number"/>页/共'+page+'页');
					$("#datainfo").html('当前显示'+currentdata+'条数据，每页最多显示<input id="pagesize" onfocus="this.select()" type="number"/>条记录，共'+rowCount+'条记录（“更改页数或页数据数后使输入框失去焦点以应用”）');//注意这样动态生成的html元素绑定事件时要按本页的方法($(document).on)
					
					$("#pageno").val(pageno);
					$("#pagesize").val(pageSize);
					var html="";
					
					if(lastdata>rowCount){lastdata=rowCount;}
					
					for(var i=firstdata;i<lastdata;i++){//i是行数
					
						html+='<tr id="tr-line'+i+'" class="zhltr">';
						
						html+="<td>"+(i+1)+"</td>";
						for(var i2=0;i2<cellCount;i2++){//i2是列数
							html+="<td>";
							html+=result[i][i2];
							html+="</td>";
							
						}
						html+="</tr>";	
					}
					
					$("#datagrid").append(html);
					
				
		
	}//end of updatetable()
	updatetable(4,1);
	$("#next").click(function(){
		var pageno=parseInt($("#pageno").val());
		pageno++;
		var pagesize=parseInt($("#pagesize").val());
		
		updatetable(pagesize,pageno);
	});
	$("#before").click(function(){
		var pageno=parseInt($("#pageno").val());
		pageno--;
		var pagesize=parseInt($("#pagesize").val());
		updatetable(pagesize,pageno);
		
	});
	$("#refresh").click(function(){
		getdata();
		updatetable(4,1);
		alert("成功刷新！");
	});
	$(document).on("change","#pageno,#pagesize",function(){
		var pageno=parseInt($("#pageno").val());
		var pagesize=parseInt($("#pagesize").val());
		
		updatetable(pagesize,pageno);	
	});
	$(document).on("click",".zhltr",function(e){
		var id=$(this).attr('id');
		tablecursor=parseInt(id.replace("tr-line",""));
		
		$("#tr-line"+cursorbefore).css({
			"background":"rgba(234,234,234,1)"	
		});
		$("#"+id).css({
			"background":"rgba(255,255,204,1)"	
		});
		cursorbefore=tablecursor;
	});
	$("#operate").click(function(){
		var result=eval(data);
		
		if(tablecursor==undefined){
			$("#dialog-i1").html("系统提示：请选择数据进行操作(直接点击表格需要操作的一行数据)");
		}else{
			$("#dialog-i1").html("您选择了"+rsid+"进行操作，您可以直接点击表格中的其它行来进行操作");	
		}
		/*var rsid=result[tablecursor][0];
		
		
		if(rsid!=null){$("#dialog-i1").html("您选择了"+rsid+"进行操作");}
		else{$("#dialog-i1").html("请选择数据进行操作");}	
		console.log(rsid);*/
	});
	$("#pass").click(function(){ 
	var result=eval(data);
		$.ajax({
					type: 'POST',
					url: '../phpbase/ajaxselect.php',
					data:{
						"sql":"UPDATE raisecourse SET stage='2' WHERE (id='"+result[tablecursor][0]+"')"
					},
					async: false, 
					success: function () {
						alert("当前众筹已通过审核");
						updatetable(4,1);
					}
			   
		});
	});
	$("#refuse").click(function(){
		var result=eval(data);
		$.ajax({
					type: 'POST',
					url: '../phpbase/ajaxselect.php',
					data:{
						"sql":"UPDATE raisecourse SET stage='-1' WHERE (id='"+result[tablecursor][0]+"')"
					},
					async: false, 
					success: function () {
						alert("已拒绝请求");
						updatetable(4,1);
					}
			   
		});
	});
	$(document).on("click",".zhltr",function(){
		var result=eval(data);
		var rsid=result[tablecursor][0];
		$("#dialog-i1").html("您选择了"+rsid+"进行操作");	
	})
	
});
</script>
<script type="text/javascript">
	var dialogInstace , onMoveStartId;	//	用于记录当前可拖拽的对象
	
		// var zIndex = 9000;

		//	获取元素对象	
		function g(id){return document.getElementById(id);}

		//	自动居中元素（el = Element）
		function autoCenter( el ){
			var bodyW = document.documentElement.clientWidth;
			var bodyH = document.documentElement.clientHeight;

			var elW = el.offsetWidth;
			var elH = el.offsetHeight;

			el.style.left = (bodyW-elW)/2 + 'px';
			el.style.top = (bodyH-elH)/2 + 'px';
			
		}

		//	自动扩展元素到全部显示区域
		function fillToBody( el ){
			el.style.width  = document.documentElement.clientWidth  +'px';
			el.style.height = document.documentElement.clientHeight + 'px';
		}

		//	Dialog实例化的方法
		function Dialog( dragId , moveId ){

			var instace = {} ;

			instace.dragElement  = g(dragId);	//	允许执行 拖拽操作 的元素
			instace.moveElement  = g(moveId);	//	拖拽操作时，移动的元素

			instace.mouseOffsetLeft = 0;			//	拖拽操作时，移动元素的起始 X 点
			instace.mouseOffsetTop = 0;			//	拖拽操作时，移动元素的起始 Y 点

			instace.dragElement.addEventListener('mousedown',function(e){

				var e = e || window.event;

				dialogInstace = instace;
				instace.mouseOffsetLeft = e.pageX - instace.moveElement.offsetLeft ;
				instace.mouseOffsetTop  = e.pageY - instace.moveElement.offsetTop ;
				
				// instace.moveElement.style.zIndex = zIndex ++;
			})

			return instace;
		}

		//	在页面中侦听 鼠标弹起事件
		document.onmouseup = function(e){
			
			dialogInstace = false;
			clearInterval(onMoveStartId);

		}

		//	在页面中侦听 鼠标移动事件
		document.onmousemove = function(e) {
			var e = e || window.event;
			var instace = dialogInstace;
		    if (instace) {
		    	
		    	var maxX = document.documentElement.clientWidth -  instace.moveElement.offsetWidth;
		    	var maxY = document.documentElement.clientHeight - instace.moveElement.offsetHeight ;

				instace.moveElement.style.left = Math.min( Math.max( ( e.pageX - instace.mouseOffsetLeft) , 0 ) , maxX) + "px";
				instace.moveElement.style.top  = Math.min( Math.max( ( e.pageY - instace.mouseOffsetTop ) , 0 ) , maxY) + "px";
		    }
			if(e.stopPropagation) {
				e.stopPropagation();
			} else {
				e.cancelBubble = true;
			}
		};

		//	拖拽对话框实例对象
		Dialog('dialogDrag','dialogMove');

		


		//	重新调整对话框的位置和遮罩，并且展现
		function showDialog(){
			g('dialogMove').style.display = 'block';
			g('mask').style.display = 'block';
			autoCenter( g('dialogMove') );
			fillToBody( g('mask') );
		}

		//	关闭对话框
		function hideDialog(){
			g('dialogMove').style.display = 'none';
			g('mask').style.display = 'none';
		}

		//	侦听浏览器窗口大小变化
		//window.onresize = showDialog;
</script>


</body>
</html>