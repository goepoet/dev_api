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

$shield=new shield;
if($status=='1'){
	$posisi="Incoming claim";
}elseif ($status=='2') {
	$posisi="Pending for offer";
}elseif ($status=='3') {
	$posisi="Pending repairer acceptance";
}elseif ($status=='4') {
	$posisi="Repair Progress";
}elseif ($status=='5') {
	$posisi="Pending DV & final bill";
}elseif ($status=='6') {
	$posisi="Pending for payment";
}

if($claimno==''){
	$query="0";
	$msg="Silahkan Pilih no claimnya dahulu";
}else{
	$datanya = array('STATUS' =>$status );

	$query=$shield->ubah_claim_status($datanya," where CLAIM_NO='$claimno'");

	if($query=='0')
	{
		$msg = "Update gagal";
		$Cout = "{}";
	}else
	{
		$msg = "No Claim ".$claimno." berhasil pindah ke ".$posisi.".";

	}
}
$Cout='{"status":"'.$query.'","msg":"'.$msg.'"}';
echo $Cout;


?>
