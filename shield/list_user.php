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
$ws_id=$data->ws_id;


$mst_user = new MST_MENU_PRIVILEDGE;
$shield1= new shield;
$shield= new shield;
	$shield1->get_user_priviledge(" ");
$Cout="";
while($pecah=$shield1->tampil()){
	if($Cout !=""){$Cout .=",";}
	//$idnya=$pecah["ID"];
	//$sysuser->select("");

	$Cout .='{"id":"'.$pecah["ID"].'",';
	$Cout .='"name":"'.$pecah["Name"].'"}';	
	$no=$no + 1;
}
$Cout='{"status":"'.$Cout3.'","msg":"'.$msg.'","total_data":"'.$no.'","data":['.$Cout.']}';
echo $Cout;

/*$shield->get_user_care("where ID='isit01'");
$hasil=$shield->tampil();
echo $hasil["CT"];*/
?>
