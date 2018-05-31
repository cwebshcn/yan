<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="后台管理">
<meta name="keywords" content="后台管理">
<meta name="author" content="code by vic.tang">
<title>页面展示</title>
<link rel="stylesheet" href="css/bootstrap.min.css">

<style type="text/css">
	body{
		font-size:10px;
	}
	.center{
		text-align: center;
	}
	.left{
		text-align: left;
	}
	.right{
		text-align: right;
	}
	.vs_checkbox{
		text-align: center;
		width:2rem;
		height:2rem;
	}
	.vs_name{
		color:#cc9900;
		font-size:1.2rem;
	}
	.vs_time{
		font-size:1.2rem;
		color:#666;
	}
	.vs_status{
		color:#993300;
		font-size:2rem;
		font-weight: bold;
	}
	.vs_board{
		font-size:1.2rem;
		color:#666;
	}
	.vs_vs_name{
		color:#666;
		font-size:1.6rem;
	}
	.vs_score{
		color:#ff3300;
		font-size:2rem;
		font-weight: bold;
	}
	.vs_go{
		font-size:2rem;
		text-align: center;
	}
</style>
<!--[if lt IE 9]>
<script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<!-- Favicons -->
</head>
<body>
<div id="d">
	<div v-for="l in list">
		<table class="table   table-hover js-table margin-top-25" data-toggle="table" data-url=""  data-click-to-select="true"  data-select-item-name="radioName" style="width:100%;border:0px;margin:0px;">
			<tr></td>
			<table style="width:100%;height:2rem">
				<tr>
					<td width="5%" class="vs_checkbox "><input type="checkbox" vlue=""></td>
					<td width="30%" class="right vs_name">{{l.vs_name}}</td>
					<td width="10%" class="right vs_time">{{l.vs_time}}</td>
					<td width="10%" class="center vs_status">{{l.vs_status}}</td>
					<td width="45%" class="left vs_board">{{l.vs_board}} &nbsp;&nbsp; {{l.data_1}} &nbsp;&nbsp; {{l.data_2}}</td>
				</tr>
			</table>
			<table style="width:100%;height:2rem;border-bottom:1px solid #f0f0f0; ">
				<tr>
					<td width="45%" class="right vs_vs_name">{{l.vs_a_name}}</td>
					<td width="10%" class="center vs_score">{{l.vs_score}}</td>
					<td width="35" class="left vs_vs_name">{{l.vs_b_name}}</td>
					<td width="10%" class="right vs_go" :vsid="l.vs_id" onclick=""><span class="glyphicon glyphicon-chevron-right"></span></td>
				</tr>
			</table>

	</div>

</div>
</body>

<script src="https://cdn.bootcss.com/jquery/2.2.3/jquery.js"></script>
<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="https://cdn.bootcss.com/vue/2.5.16/vue.js"></script>

<script>
var d = new Vue({
	el:"#d",
	data:{
		"list":[],
	}
})
load_data();
setInterval(function(){
	load_data();
},3000);
function load_data(){
	$.ajax({
		url:"db_load_api.php",
		type:"get",
		dataType:"json",
		success : function(msg){
			d.list=msg.data;
			console.log(msg.data);
		}
	})
}

$(document).on("click",".vs_go",function(){
	var vsid = $(this).attr("vsid");
	if(!vsid){
		alert("参数错误！");
		return;
	}
	window.location.href="data_list.php?vsid="+vsid;
})

</script>
</html>