<?php
include 'admin/config/config.php'; 


$msg=array();
$code =0;
get_db_data();
function get_db_data(){
	global $lnk;
	global $msg;
	$arr=array();
	$today =  strtotime(date("Y-m-d")); 
	$result= $lnk ->query("select vs_id,vs_name,vs_a_name,vs_b_name,vs_board,vs_time,vs_status,vs_score,data_1,data_2 from (select * from curl_load_data where update_time>=".$today."  order by id desc) b  group by b.vs_id");
	while ($rs=mysqli_fetch_assoc($result)){
		$arr[]=$rs;
	}
	$msg =  $arr;		
}
echo json_encode(array("code"=>$code,"data"=>$msg))
?>