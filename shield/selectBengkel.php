<?php
include '../service/MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type,X-Custom-Header");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");


	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);

	$ws_id=$data->ws_id;
	$nama_bengkel=$data->ws_name;
	$bengkel=new MST_BENGKEL;
	$mst_user= new MST_USER;
	if($ws_id =='')
	{
		$query=$bengkel->Select("");
	}else
	{
		$query=$bengkel->Select("where ID='$ws_id'");
	}
	//$bengkel=new MST_BENGKEL;
	//$bengkel->Select("");
	$Cout="";
	while($pecah=$bengkel->tampil()){
		if($Cout !=""){$Cout .=",";}
		$id=$pecah["ID"];
		if($pecah["biaya"]=='1'){
			$biaya="Aktif";
			$btn="Non Aktifkan";
		}else{
			$biaya="Tidak Aktif";
			$btn="Aktifkan";
		}
		$mst_user->select("where ID='$id'");
		$view_user = $mst_user->tampil();

		$Cout .='{"id":"'.$pecah["ID"].'",';
		$Cout .='"name":"'.$pecah["nama_bengkel"].'",';
		$Cout .='"address":"'.$pecah["alamat"].'",';
		$Cout .='"city":"'.$pecah["city"].'",';
		$Cout .='"branch_id":"'.$pecah["branch_code"].'",';
		$Cout .='"phone":"'.$pecah["telp"].'",';
		$Cout .='"fax":"'.$pecah["fax"].'",';
		$Cout .='"email":"'.$pecah["email"].'",';
		$Cout .='"rating":"'.$pecah["rating"].'",';
		$Cout .='"vat":"'.$pecah["VAT"].'",';
		$Cout .='"tax":"'.$pecah["TAX2"].'",';
		$Cout .='"sparepart":"'.$pecah["TAX"].'",';
		$Cout .='"no_rekening":"'.$pecah["no_rekening"].'",';		
		$Cout .='"atas_nama":"'.str_replace('"','\'',preg_replace( '/\s+/',' ',$pecah["atas_nama"])).'",';
		$Cout .='"bank":"'.$pecah["nama_bank"].'",';
		$Cout .='"cabangBank":"'.$pecah["cabang_bank"].'",';
		$Cout .='"user_id":"'.$view_user["UserID"].'",';
		$Cout .='"biaya_shield":"'.$biaya.'",';
		$Cout .='"btn_biaya":"'.$btn.'",';
		$Cout .='"pass":"'.$view_user["UserPassword"].'"}';
		}
	//$Cout='{"data":['.$Cout.']}';
	//echo ($Cout);

			$Cout3 = $query;
			$Cout4 = "";
			//$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":['.$Cout.']}';
			echo $Cout;	
?>
