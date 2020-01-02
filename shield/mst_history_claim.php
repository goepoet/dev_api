<?php
include '../service/MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type,X-Custom-Header");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

include '../conf/konek.php';
$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
$tipe=$data->tipe;


//$mst_user = new MST_MENU_PRIVILEDGE;
//$shield1= new shield;
$shield= new shield;
	$shield->select_mst_history_claim(" where tipe ='$tipe' ");
$Cout="";
while($pecah=$shield->tampil()){
	if($Cout !=""){$Cout .=",";}
	
	$Cout .='{"id":"'.$pecah["id"].'",';
	$Cout .='"name":"'.$pecah["nama_progress"].'"}';	
	$no=$no + 1;
}
$Cout='{"status":"'.$Cout3.'","msg":"'.$msg.'","total_data":"'.$no.'","data":['.$Cout.']}';
echo $Cout;

/*$shield->get_user_care("where ID='isit01'");
$hasil=$shield->tampil();
echo $hasil["CT"];*/
?>
