<?php
include '../service/MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type,X-Custom-Header");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

include '../conf/konek.php';
$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
$desc=$data->desc;// jika val = 1 maka ambil data per user, tapi  jika val 2 = maka bisa ambil data dari cabng lain


$mst_part= new MstPart;

$mst_part->select("where DESCRIPTION like'%$desc%'");
while($pecah=$mst_part->tampil()){
	if($Cout !=""){$Cout .=",";}
	$Cout .='{"id":"'.$pecah["kol"].'",';
	$Cout .='"desc":"'.$pecah["description"].'"}';	
	$no=$no + 1;
}
$Cout='{"status":"'.$Cout3.'","msg":"'.$msg.'","total_data":"'.$no.'","data":['.$Cout.']}';
echo $Cout;

/*$shield->get_user_care("where ID='isit01'");
$hasil=$shield->tampil();
echo $hasil["CT"];*/
?>
