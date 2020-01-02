<?php
	include '../conf/konek.php';
	include 'MainFrame.php';
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");	
	$data=json_decode(file_get_contents("php://input"));
	ini_set('memory_limit', '512');
	$fu_activity=new fu_activity;
	//$userid=mysql_real_escape_string($data->userid);
	//$password=mysql_real_escape_string($data->password);
	$nomor=$fu_activity->autonum();
	$isinya = array(
		'REG_ID'=>$nomor,
		'urut'=>"0",
		'tgl_fu'=>"",
		'priority'=>"",
		'status'=>"",
		'no_polis'=>"",
		'no_claim'=>"",
		'surveyor'=>"",
		'workshop'=>"",
		'untuk'=>"",
		'oleh'=>"",
		'remarks'=>"",
		'calls_id'=>""
	);		 	
	$fu_activity->simpan($isinya);	
?>
