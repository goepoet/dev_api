<?php
	include '../conf/konek.php';
	include 'MainFrame.php';
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");	
	$data=json_decode(file_get_contents("php://input"));
	ini_set('memory_limit', '512');
	$tr_surveyLog=new tr_survey_log;
	//$userid=mysql_real_escape_string($data->userid);
	//$password=mysql_real_escape_string($data->password);
	$nomor=$tr_surveyLog->autonum();// nomor survey
	$isinya = array
	(
		'SURVEY_ID'=>$nomor,
		'SURVEY_DATE'=>"2016-08-09",
		'POLICYNO'=>"",
		'CLAIMNO'=>"",
		'ADDRESS'=>"",
		'CITY'=>"",
		'PROVINCE'=>"",
		'CS'=>"",
		'ESTIMATOR'=>"",
		'SURVEYOR'=>"",
		'STATUS'=>"",
		'REMARKS'=>"",
		'REG_ID'=>"FU1608051840",//di isi ama nomor follow up
		'URUT'=>"",
		'OWNRISK'=>"",
		'OWNRISK_2'=>""
	);		 	
	$tr_surveyLog->simpan($isinya);	
?>
