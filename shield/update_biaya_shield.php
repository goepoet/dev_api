<?php
include '../service/MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type,X-Custom-Header");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

include '../conf/konek.php';
$data=json_decode(file_get_contents("php://input"));
$shield=new shield();
$mst_bengkel=new MST_BENGKEL();
$mst_bengkel2=new MST_BENGKEL();
$id=$data->id;
//$biaya=$data->biaya;

$mst_bengkel->Select("where ID='$id' and biaya='1'");//ini buat cek
$mst_bengkel2->Select("where ID='$id'");//ini buat ambil nama bengkel
$tmpl_bengkel=$mst_bengkel2->tampil();
$cek_ws=$mst_bengkel->tampil_row();
if($cek_ws==1){
	$biaya='';
	$msg="Biaya shield untuk bengkel --".$tmpl_bengkel["nama_bengkel"]."-- sudah di non aktifkan";
	$data_regis = array('SPK_NO' =>$biaya);
	$shield->ubah_tr_ws_registration($data_regis,"where WORKSHOP='$id'");
}else{
	$biaya='1';
	$msg="Biaya shield untuk bengkel --".$tmpl_bengkel["nama_bengkel"]."-- sudah di Aktifkan";
}
$datanya = array('biaya' =>$biaya);
$query=$shield->ubah_mst_bengkel($datanya,"where ID='$id'");

$Cout='{"status":"'.$query.'","msg":"'.$msg.'"}';
echo $Cout;


?>
