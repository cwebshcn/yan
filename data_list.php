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
	td{
		font-size:1.2rem;
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
	<div style="text-align: center;"><a href='data_index.php' style='font-size:2rem'>返回主页</a></div>
	<div v-for="l in list">
		<table class="table   table-hover js-table margin-top-25" data-toggle="table" data-url=""  data-click-to-select="true"  data-select-item-name="radioName" style="width:100%;border:0px;margin:0px;">
			<tr></td>
			<table style="width:100%;height:2rem;border-bottom:1px solid #f0f0f0; ">
				<tr>
					<td class="center " width="16%">{{l.vs_status}} </td>
					<td class="center " width="16%">{{l.vs_score}} </td>
					<td class="center " width="17%">{{l.vs_board}} </td>
					<td class="center " width="17%">{{l.data_1}} </td>
					<td class="center " width="17%">{{l.data_2}} </td>
					<td class="center " width="17%">{{l.vs_time}} </td>
				</tr>
			</table>

	</div>

</div>
</body>

<script src="https://cdn.bootcss.com/jquery/2.2.3/jquery.js"></script>
<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="https://cdn.bootcss.com/vue/2.5.16/vue.js"></script>

<script>

(function($) {
	$.getUrlParam = function(name) {
		var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
		var r = window.location.search.substr(1).match(reg);
		if (r != null)
			return unescape(r[2]);
		return null;
	}
})(jQuery);


var vsid=$.getUrlParam("vsid");

var d = new Vue({
	el:"#d",
	data:{
		"list":[],
	}
})
load_data();
setInterval(function(){
	load_data();
},15000);
function load_data(){
	$.ajax({
		url:"db_load_vsid.php?vsid="+vsid,
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