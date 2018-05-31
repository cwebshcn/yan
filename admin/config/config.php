<?php
//本地数据库

$server_t="175.102.3.161"; 	// 服务器
$username_sql_t="sq_yan"; 	// MYSQL用户名
$password_sql_t="VUsKyjRQG2J2VrMp"; 	// MYSQL密码VUsKyjRQG2J2VrMp  nVxEmAZ9PfNwLzU9
$database_t="sq_yan"; 	
$datebase_name= ""; //数据库前缀
$lnk=mysqli_connect($server_t,$username_sql_t,$password_sql_t,$datebase_name.$database_t); //链接服务器
$lnk->query("SET NAMES 'utf8mb4'");
?>