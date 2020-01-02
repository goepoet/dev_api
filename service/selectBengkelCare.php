<?php
	include 'MainFrame.php';
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$branch_code=$_REQUEST['branch_id'];
	$nama_bengkel=$_REQUEST['name'];
	if($nama_bengkel=='')
	{
		$nama_bengkel=$data->name;
	}
	$bengkel=new PROFILE;
	$mst_bengkel=new MST_BENGKEL;
	
	//$query=$bengkel->select("where lob in('13','21') and dumpf='0' and name like'%$nama_bengkel%' and ID not like 'M%'");
	$query=$mst_bengkel->Select("where nama_bengkel like '%$nama_bengkel%'");
	$Cout="";
	while($pecah=$mst_bengkel->tampil()){
		if($Cout !=""){$Cout .=",";}		
		$Cout .='{"id":"'.$pecah["ID"].'",';
		$Cout .='"name":"'.str_replace('"','\'',preg_replace( '/\s+/',' ',$pecah["nama_bengkel"])).'"}';
		//$Cout .='"address":"'.$pecah["alamat"].'",';
		// $Cout .='"city":"'.$pecah["city"].'",';
		// $Cout .='"branch_id":"'.$pecah["branch_code"].'",';
		// $Cout .='"phone":"'.$pecah["telp"].'",';
		// $Cout .='"fax":"'.$pecah["fax"].'",';
		// $Cout .='"email":"'.$pecah["email"].'",';
		// $Cout .='"rating":"'.$pecah["rating"].'",';
		// $Cout .='"no_rekening":"'.$pecah["no_rekening"].'",';		
		// $Cout .='"atas_nama":"'.str_replace('"','\'',preg_replace( '/\s+/',' ',$pecah["atas_nama"])).'",';
		// $Cout .='"bank":"'.$pecah["nama_bank"].'",';
		// $Cout .='"cabangBank":"'.$pecah["cabang_bank"].'"}';
		}
	//$Cout='{"data":['.$Cout.']}';
	//echo ($Cout);

			$Cout3 = $query;
			$Cout4 = "";
			//$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":['.$Cout.']}';
			echo $Cout;	
?>
