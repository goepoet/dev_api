<?php
include '../service/MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type,X-Custom-Header");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

include '../conf/konek.php';
$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
$status=$data->status;// jika val = 1 maka ambil data per user, tapi  jika val 2 = maka bisa ambil data dari cabng lain
$authKey=$data->auth_key;
$claimno=$data->claimno;
//$claimno=str_replace(",", "','", $claimno);
//$ws_id=$data->ws_id;


$mst_user = new MST_MENU_PRIVILEDGE;
$bkl= new MST_BENGKEL;
$shield= new shield;
$user=new Cass_UserPanfic;
$fu_act= new fu_activity;
$tr_survey_log=new tr_survey_log;
$rtf=new RTF;

$user->selectJoinUser("where auth_key_shield='$authKey'");
$view_user=$user->tampil();
$branch=$view_user["Branch"];

if($branch==''){
	$Cout3="0";
	$msg="Silahkan login dahulu";
}else{
	$datanya = array('ASource' =>'' );//data Care
	$data_tr = array('STATUS' =>'5' , );//data sheild
	$hasil_care=$shield->update_ref_claim($datanya,"where ClaimNo='$claimno'");
	$hasil_ws=$tr_survey_log->ubah($data_tr,"where CLAIMNO='$claimno'");
	$Cout3=$hasil_care." ".$hasil_ws;
	if($hasil_care==1){
		$msg="Open lock Care berhasil untuk no claim ".$claimno." ".$hasil_ws;
	}else{
		$msg="Open lock Care gagal ".$hasil_ws;
	}
}
$Cout='{"status":"'.$Cout3.'","msg":"'.$msg.'","total_data":"'.$no.'"}';
echo $Cout;

/*$shield->get_user_care("where ID='isit01'");
$hasil=$shield->tampil();
echo $hasil["CT"];*/
?>
