<?php
	include '../conf/konek.php';
	include 'MainFrame.php';
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");	
	$data=json_decode(file_get_contents("php://input"));
	ini_set('memory_limit', '512');
	$callsLog=new callsLog;
	//$userid=mysql_real_escape_string($data->userid);
	//$password=mysql_real_escape_string($data->password);
	$nomor=$callsLog->autonum();
	$isinya = array(
		'calls_id'=>$nomor,
		'names'=>"iwan",
		'alamat'=>"wanaherang",
		'detail_business'=>"5",
		'tanggal'=>'2016-08-08',
		'detail_info'=>'1',
		'[from]'=>'a',
		'user_insert'=>'isit'
	);		 	
	$callsLog->simpan($isinya);	
?>
