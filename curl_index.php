<?php require("./curl_load_config.php");?>



<?php 

$g = getList();
if(!$g){
	echo "您的登录次数达到上限！已被强制退出！<br><button onclick='window.location.href=\"?tk_reset=1\"'>重新登录</button>";	
	exit;
}
foreach ($g as $v) {
	//两者一样
	$id=$v[50];
	if($id!=@$oid){
		echo "<div style='background:#ee3399;line-height:40px;color:#fff;padding:5px;'>". $v[18]."-".$v[19]."<b> | ".$v[2]." | ".$v[1]."</b></div>";
	}
	echo "<div style='font-size:16px; background:#f0f0f0;border:2px solid #fff;padding:20px;marign-top:20px;'>";
	echo "<span style='background:#ff99cc;color:#fff'>".$v[5]."</span>  (全场独赢)".$v[33]." (全场让球)".$v[8]."|".$v[9]." (全场大小)".$v[11]."(半场独赢)".$v[36]."(半场让球)".$v[28]."(半场大小)".$v[25]."<br>";
	echo "<span style='background:#ff99cc;color:#fff'>".$v[6]."</span> | (全场让球)".$v[9]." | ". $v[10]. "(全场大小)".$v[12]."(半场独赢)".$v[37]."(半场让球)".$v[27]."(半场大小)".$v[26]."<br>"; 
	echo $v[51]=="Y" ? "和局":"";
	echo "(全场独赢)".$v[35];
	echo  "</div>";
	$oid=$v[50]; 
 }

 print_r($g);

exit();
?>




<script src="https://cdn.bootcss.com/jquery/2.2.3/jquery.js"></script>
<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>


<?php



exit; 

//如果没有ACT执行
//破解远程地址
$url = "https://sbc.ry00000.com/iovation/vindex.html?webProtocal=https&webDomain=".str_replace("https://","",URL);
//得到远程地址
$tmpHtml = curlGet($url);

?>

<script>
setTimeout(function(){
	var blackbox = ($("#blackbox").val());
	$.ajax({
		url:"?black=write",
		type:"post",
		data : "blackbox="+blackbox,
		success : function(msg){
			var arrUrl=window.location.href.split("/");
			strUrl = arrUrl[arrUrl.length-1].split(".")[0]+".php";
			window.location=strUrl;
		}
	})
},5000);
</script>