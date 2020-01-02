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
$claimno=str_replace(",", "','", $claimno);
//$ws_id=$data->ws_id;


$mst_user = new MST_MENU_PRIVILEDGE;
$bkl= new MST_BENGKEL;
$shield= new shield;
$user=new Cass_UserPanfic;
$fu_act= new fu_activity;

$rtf=new RTF;

/*$user->selectJoinUser("where auth_key_shield='$authKey'");
$view_user=$user->tampil();
$branch=$view_user["Branch"];
if($branch==''){
	$branch="0";
}*/
$shield->list_open_lock($claimno);
while($pecah=$shield->tampil()){
	if($Cout !=""){$Cout .=",";}
	
	
	$Cout .='{"calls_id":"'.$pecah["calls_id"].'",';
	$Cout .='"tgl_survey":"'.$pecah["tanggal"].'",';	
	$Cout .='"branch":"'.$pecah["branch"].'",';
	$Cout .='"name":"'.$pecah["names"].'",';	
	$Cout .='"reg_id":"'.$pecah["reg_id"].'",';	
	$Cout .='"survey_id":"'.$pecah["survey_id"].'",';		
	$Cout .='"survey_date":"'.$pecah["survey_date"].'",';	
	$Cout .='"policyno":"'.$pecah["policyno"].'",';	
	$Cout .='"claimno":"'.$pecah["claimno"].'",';	
	$Cout .='"alamat":"'.$rtf->text($pecah["address"]).'",';	
	$Cout .='"city":"'.$pecah["city"].'",';	
	$Cout .='"workshop":"'.$ws_id.'",';	
	$Cout .='"status":"'.$pecah["status"].'",';	
	$Cout .='"cs":"'.$pecah["name"].'"}';	
	$no=$no + 1;
}
$msg="Proses memuat data selesai...";
$Cout='{"status":"'.$Cout3.'","msg":"'.$msg.'","total_data":"'.$no.'","data":['.$Cout.']}';
echo $Cout;

/*$shield->get_user_care("where ID='isit01'");
$hasil=$shield->tampil();
echo $hasil["CT"];*/
?>
