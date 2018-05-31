<?php
include 'admin/config/config.php'; 
//定义变量
$cfg = array(
	"weburl"  => "https://hga025.com",
	"user"    => "abcdeF1234",  //dntz18
	"pswd"    => "abcd123",  
	"langx"   => "zh-cn",
	"blackbox"=> @file_get_contents("temp/blackbox.txt"),
	"lgined"  => "",
	"auto"    => "",
); 


//登录
function login(){
	global $cfg;
	$url=$cfg['weburl']."/app/member/new_login.php?username=".$cfg['user']."&passwd=".$cfg['pswd']."&langx=".$cfg["langx"];
	$tk = explode("|", curlGet($url));
	return $tk[3];
}


//自动登录
if(!isset($_COOKIE["tk"])||empty($_COOKIE["tk"])||isset($_GET["tk_reset"])){
	$tk=login();
	$url ='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].str_replace("tk_reset=1","",$_SERVER["QUERY_STRING"]);
	setcookie("tk", $tk, time()+1600);
	echo "<script>window.location.href=\"$url\";</script>";
	exit;
}

//列表
function getList(){
	global $lnk;
	global $cfg;
	$url=$cfg['weburl']."/app/member/FT_browse/body_var.php?uid=".$_COOKIE["tk"]."&rtype=re&langx=zh-cn&mtype=3&page_no=0&league_id=&hot_game=&isie11='N'";
	$list=curlGetGzip($url);
	$list = str_replace("'","",$list);
	preg_match("/<script>([\s\S]*?)<\/script>/",$list,$js);
	preg_match_all("/g\(\[([\s\S]*?)\]\)/",$js[1],$gg);
	$data_arr=array();
	foreach ($gg[1] as $v) {
		$data_arr[]=explode(",",$v);
	}

	foreach ($data_arr as $v) {
		$vs_id=$v[50];
		$vs_name = $v[2];
		$vs_a_name = $v[5];
		$vs_b_name = $v[6];
		$vs_board =$v[8];
		$vs_time_arr = explode("^",$v[48]);
		$vs_time = $vs_time_arr[1];
		$vs_time = $vs_time_arr[0] == "MTIME" ? "MTIME":$vs_time;
		$vs_status = strip_tags($v[1]);
		$vs_score = $v[18].":".$v[19];
		$data_1 = $v[9];
		$data_2 = $v[10];
		$update_time = time();


		$json_data = json_encode($v);
		if($vs_id!=@$oid and strpos($v[55],"角")<=0){
			$oid=$v[50];
			$arr = get_db_data($vs_id);
			if(count($arr)>0){
				if($arr["data_1"]!=$data_1 or $arr["data_2"]!=$data_2 or $arr["vs_score"]!=$vs_score or $arr["vs_board"]!=$vs_board)
				$lnk -> query("insert into curl_load_data(vs_id,vs_name,vs_a_name,vs_b_name,vs_board,vs_time,vs_status,vs_score,data_1,data_2,update_time,json_data)values('$vs_id','$vs_name','$vs_a_name','$vs_b_name','$vs_board','$vs_time','$vs_status','$vs_score','$data_1','$data_2','$update_time','$json_data')");
			}else{
				$lnk -> query("insert into curl_load_data(vs_id,vs_name,vs_a_name,vs_b_name,vs_board,vs_time,vs_status,vs_score,data_1,data_2,update_time,json_data)values('$vs_id','$vs_name','$vs_a_name','$vs_b_name','$vs_board','$vs_time','$vs_status','$vs_score','$data_1','$data_2','$update_time','$json_data')");
			}
		}
	}

	return $data_arr;
}

function get_db_data($vs_id){
	global $lnk;
	$arr=array();
	$result= $lnk ->query("select vs_id,vs_name,vs_a_name,vs_b_name,vs_board,vs_time,vs_status,vs_score,data_1,data_2 from curl_load_data where vs_id=".$vs_id." order by id desc limit 1");
	while ($rs=mysqli_fetch_assoc($result)){
		$arr=$rs;
	}
	return $arr;
}

//列表2
function getSubList($id){
	global $cfg;
	$url = $cfg['weburl']."/app/member/FT_browse/body_var_re_allbets.php?gid=".$id."&uid=".$_COOKIE["tk"]."&ltype=3&langx=zh-cn&gtype=FT&imp=N&ptype=&showtype=RB";
	$list=curlGetGzip($url);
	//$list = str_replace("'","",$list);
	return $list;
}



//http://www.777ff.com/
/*
$server_t="localhost"; 	// 服务器
$username_sql_t="sq_hg777"; 	// MYSQL用户名
$password_sql_t="VUsKyjRQG2J2VrMp"; 	// MYSQL密码VUsKyjRQG2J2VrMp  nVxEmAZ9PfNwLzU9
$database_t="sq_hg777"; 	
$datebase_name= ""; //数据库前缀
$lnk=mysqli_connect($server_t,$username_sql_t,$password_sql_t,$datebase_name.$database_t); //链接服务器
$lnk->query("SET NAMES 'utf8mb4'");
*/
function curlGetGzip($URL){
	global $cfg;    
    $c = curl_init();     
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($c, CURLOPT_ENCODING, "gzip");  
	//curl_setopt($c, CURLOPT_HEADER, 1);//输出远程服务器的header信息  
	curl_setopt($c, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727;'.$cfg["weburl"].')');  
    curl_setopt($c, CURLOPT_URL, $URL);     
    $contents = curl_exec($c);     
    curl_close($c);  
    if ($contents) {return $contents;}  
    else {return FALSE;}   
}

function curlPostGzip($URL,$data,$jumpUrl=""){ 
	global $cfg;     
    $c = curl_init();     
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($c,CURLOPT_POST,1);
    curl_setopt($c, CURLOPT_ENCODING, "gzip");  
	//curl_setopt($c, CURLOPT_HEADER, 1);//输出远程服务器的header信息  
	curl_setopt($c, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727;'.$cfg["weburl"].')');  
	curl_setopt($c,CURLOPT_POSTFIELDS,$data);
    curl_setopt($c, CURLOPT_URL, $URL); 
    curl_setopt($c,CURLOPT_REFERER,$jumpUrl);//伪造地址从A到B    
    $contents = curl_exec($c);     
    curl_close($c);  
    if ($contents) {return $contents;}  
    else {return FALSE;}   
}


function curlGet($URL){ 
	global $cfg;      
    $c = curl_init();     
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);  
	curl_setopt($c, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727;'.$cfg["weburl"].')');  
    curl_setopt($c, CURLOPT_URL, $URL);     
    $contents = curl_exec($c);     
    curl_close($c);  
    if ($contents) {return $contents;}  
    else {return FALSE;}   
} 


//POST方法
function curlPost($go_url,$data,$jumpUrl=""){
	global $cfg; 
	$ch = curl_init($go_url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch,CURLOPT_COOKIEFILE,COOKIE_URL);
	curl_setopt($ch,CURLOPT_POST,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,0);
	curl_setopt($ch,CURLOPT_HEADER, 0);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727;'.$cfg["weburl"].')');  
	curl_setopt($ch,CURLOPT_REFERER,$jumpUrl);//伪造地址从A到B
	curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
	$content = curl_exec($ch);
	curl_close($ch);
	return $content;
}


//blackbox 获取，好偈没什么用，先放着
function getBlackbox(){
	$url = "https://sbc.ry00000.com/iovation/vindex.html?webProtocal=https&webDomain=".str_replace("https://","",$cfg["weburl"]);
	$tmpHtml = curlGetGzip($url);
	return $tempHtml;
}
echo json_encode(getList());
?>