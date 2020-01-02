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

if($surveyor==''){
	$msg="Silahkan pilih nama Surveyornya";
	$query="0";
}else if($estimator==''){
	$msg="Silahkan pilih nama Estimator";
}else{
	$mst_menu_priv->select(" where Name='$surveyor'");
	$tampil_surv=$mst_menu_priv->tampil();
	$surveyornya=$tampil_surv["ID"];//cari surveyor

	$mst_menu_priv->select(" where Name='$estimator'");
	$tampil_est=$mst_menu_priv->tampil();
	$estimator=$tampil_est["ID"];//cari estimator

	$datanya = array('ESTIMATOR' =>$estimator , 'SURVEYOR'=>$surveyornya);
	$query = $tr_survey_log->ubah($datanya," where CLAIMNO='$claimno'");
	if($query==1){
		$msg="Claim akan dipickup oleh ".$surveyor;
	}else{
		$msg="Pickup claim gagal";
	}
}
$Cout='{"status":"'.$query.'","msg":"'.$msg.'"}';
echo $Cout;


?>
