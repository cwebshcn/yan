<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="后台管理">
<meta name="keywords" content="后台管理">
<meta name="author" content="code by vic.tang">
<title>读取数据....</title>
<link href="../css/bootstrap.min.css" rel="stylesheet">
<!--[if lt IE 9]>
<script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<!-- Favicons -->
</head>
<body>
	<div>正在读取数据，已读取 <span id="load_count">0</span> 次   这次要等的时间（<span id="t"></span>）</div>
</body>

<script src="https://cdn.bootcss.com/jquery/2.2.3/jquery.js"></script>
<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

<script>


function a(){
	var t=3000+Math.ceil(Math.random()*7000);
	$("#t").text(t);
	setTimeout(function(){
		$.ajax({
			url:"curl_load_config.php",
			type:"get",
			success : function(msg){
				$("#load_count").text(parseInt($("#load_count").text())+1);
				a();
			}
		})
		
	},t);
	return;
}

a();
</script>
</html>