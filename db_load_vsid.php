<?php
include 'admin/config/config.php'; 



$msg=array();
$code =0;

$vsid = $_GET["vsid"]+0;
if($vsid>0){
	get_db_data($vsid);
}



function get_db_data($vsid){
	global $lnk;
	global $msg;
	$arr=array();
	$result= $lnk ->query("select vs_id,vs_name,vs_a_name,vs_b_name,vs_board,vs_time,vs_status,vs_score,data_1,data_2,update_time from curl_load_data where vs_id=".$vsid." order by id");
	while ($rs=mysqli_fetch_assoc($result)){
		$rs["update_time"] = date("H:i:s",$rs["update_time"]);
		$arr[]=$rs;
		
	}
	$msg =  $arr;		
}
echo json_encode(array("code"=>$code,"data"=>$msg));
?>