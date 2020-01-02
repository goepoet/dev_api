<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);

	$branch_code=$_REQUEST['branch_id'];
	$nama_bengkel=$_REQUEST['ws_name'];
	$bengkel=new MST_BENGKEL;
	if($branch_code =='')
	{
		$query=$bengkel->Select("where nama_bengkel like '%$nama_bengkel%'");
	}else
	{
		$query=$bengkel->Select("where nama_bengkel like '%$nama_bengkel%' and branch_code like'%$branch_code%'");
	}
	//$bengkel=new MST_BENGKEL;
	//$bengkel->Select("");
	$Cout="";
	while($pecah=$bengkel->tampil()){
		if($Cout !=""){$Cout .=",";}		
		$Cout .='{"id":"'.$pecah["ID"].'",';
		$Cout .='"name":"'.$pecah["nama_bengkel"].'",';
		$Cout .='"address":"'.$pecah["alamat"].'",';
		$Cout .='"city":"'.$pecah["city"].'",';
		$Cout .='"branch_id":"'.$pecah["branch_code"].'",';
		$Cout .='"phone":"'.$pecah["telp"].'",';
		$Cout .='"fax":"'.$pecah["fax"].'",';
		$Cout .='"email":"'.$pecah["email"].'",';
		$Cout .='"rating":"'.$pecah["rating"].'",';
		$Cout .='"no_rekening":"'.$pecah["no_rekening"].'",';		
		$Cout .='"atas_nama":"'.str_replace('"','\'',preg_replace( '/\s+/',' ',$pecah["atas_nama"])).'",';
		$Cout .='"bank":"'.$pecah["nama_bank"].'",';
		$Cout .='"cabangBank":"'.$pecah["cabang_bank"].'"}';
		}
	//$Cout='{"data":['.$Cout.']}';
	//echo ($Cout);

			$Cout3 = $query;
			$Cout4 = "";
			//$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":['.$Cout.']}';
			echo $Cout;	
?>
