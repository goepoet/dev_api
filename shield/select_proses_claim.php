<?php
include '../service/MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type,X-Custom-Header");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

include '../conf/konek.php';
$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
$status=$data->status;
$authKey=$data->auth_key;
$claimno=$data->claimno;
$remarks=$data->remarks;
$ws_id=$data->ws_id;

$shield = new shield;
$user_panfic=new Cass_UserPanfic;
$rtf=new RTF;

//=======================================
	$user_panfic->select("where auth_key_shield='$authKey'");
	$tampilkan= $user_panfic->tampil();
	$cek_user=$user_panfic->tampil_row();
	$user_id=$tampilkan['user_id'];
//=====================================
	$query=$shield->select_history_claim("where claimno='$claimno' order by id desc");
	
	while($pecah=$shield->tampil()){
		if($Cout !=""){$Cout .=",";}		
		$Cout .='{"id":"'.$pecah["id"].'",';
		$Cout .='"date":"'.date_format(date_create($pecah["tgl"]),"d M Y H:i:s").'",';
		$Cout .='"claimno":"'.$pecah["claimno"].'",';
		$Cout .='"remarks":"'.$pecah["remarks"].'",';
		$Cout .='"desc":"'.$rtf->Text($pecah["description"]).'"}';
				
		}
	

$Cout='{"status":"'.$query.'","msg":"'.$msg.'","data":['.$Cout.']}';  
echo $Cout;
?>
