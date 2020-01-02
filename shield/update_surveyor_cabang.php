<?php
include '../service/MainFrame.php';
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Headers: Content-Type,X-Custom-Header");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

include '../conf/konek.php';
$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
$val=$data->val;// jika val = 1 maka ambil data per user, tapi  jika val 2 = maka bisa ambil data dari cabng lain
$authKey=$data->auth_key;
$claimno=$data->claimno;

$tr_survey_log = new tr_survey_log;
$fu_activity= new fu_activity;
$rtf=new RTF;
$userPanfic=new Cass_UserPanfic;
$menuPreviledge=new MST_MENU_PRIVILEDGE;

$userPanfic->selectJoinUser("where auth_key_shield='$authKey'");
$TampilUser=$userPanfic->tampil();
$branch_id=$TampilUser['Branch'];
$surveyor=$TampilUser['ID'];

$datanya = array('ESTIMATOR' =>$surveyor ,'SURVEYOR'=>$surveyor );

$query=$tr_survey_log->ubah($datanya," where claimno='$claimno'");

if($query=='0')
	{
		$msg = "Invalid query";
		$Cout = "{}";
	}else
	{
		$msg = "Update berhasil";

	}
$Cout='{"status":"'.$query.'","msg":"'.$msg.'"}';
echo $Cout;


?>
