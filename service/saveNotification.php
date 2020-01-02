<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	
	$auth_key=$_REQUEST['auth_key'];
	$notification_type=$_REQUEST['notification_type'];
	$rating_type=$_REQUEST['rating_type'];
	//=============================================
	$MstUser=new Cass_MstUser;
	$MstUser->select("where token_id='$auth_key'");
	$TampilUser=$MstUser->tampil();
	$userId=$TampilUser['userid'];

	$notif=new Cass_notification;
	
	
	$isinya = array(
		'user_id'=>$userId,
		'notification_type'=>$notification_type,
		'rating_type'=>$rating_type,
		'content_id'=>"isit01",
		'content_name'=>"",
		'create_date'=>date('Y-m-d H:m:s'),
		'read_status'=>'1'
	);
	$query=$notif->simpan($isinya);
	echo $query;
?>
