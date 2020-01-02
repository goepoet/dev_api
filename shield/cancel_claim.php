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
$surveyor=$data->surveyor;
$estimator=$data->estimator;

$shield=new shield;
$tr_survey_log=new tr_survey_log;
$mst_menu_priv=new MST_MENU_PRIVILEDGE;

$mst_menu_priv->select(" where Name='$surveyor'");
$tampil_surv=$mst_menu_priv->tampil();
$surveyornya=$tampil_surv["ID"];//cari surveyor

$mst_menu_priv->select(" where Name='$estimator'");
$tampil_est=$mst_menu_priv->tampil();
$estimator=$tampil_est["ID"];//cari estimator

if($claimno==''){
	$msg="Silahkan pilih no Claim terlebih dahulu";
	$query="0";

}else{
	$datanya = array('STATUS' =>"5");
	$datacare = array('ASource' =>'' );//data Care

	$query = $tr_survey_log->ubah($datanya," where CLAIMNO='$claimno'");
	if($query==1){
		$shield->update_ref_claim($datacare,"where ClaimNo='$claimno'");
		$msg="Claim berhasil dibatalkan, silahkan hapus no Claim di CARE seperti biasa";
	}else{
		$msg="Cancel claim gagal";
	}
}
$Cout='{"status":"'.$query.'","msg":"'.$msg.'"}';
echo $Cout;


?>
