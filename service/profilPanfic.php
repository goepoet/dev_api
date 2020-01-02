<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
	$profil=new Profil_panfic;
	$query=$profil->select("");
	
	//$bengkel=new MST_BENGKEL;
	//$bengkel->Select("");
	$Cout="";
		while($pecah=$profil->tampil()){
		if($Cout !=""){$Cout .=",";}
		$nama_perusahaan=$pecah["nama_perusahaan"];		
		$Cout .='{"company_name":"'.$pecah["nama_perusahaan"].'",';
		$Cout .='"address":"'.$pecah["alamat_perusahaan"].'",';
		$Cout .='"phone":"'.$pecah["phone"].'",';
		$Cout .='"mail":"'.$pecah["email"].'",';
		$Cout .='"fax":"'.$pecah["fax"].'",';
		$Cout .='"web":"'.$pecah["web"].'",';
		$Cout .='"facebook":"'.$pecah["facebook"].'",';
		$Cout .='"twitter":"'.$pecah["twitter"].'",';
		$Cout .='"instagram":"'.$pecah["instagram"].'"}';
		}
			if($query=='0'){
				$Cout4 = "Invalid query";
				$Cout = "{}";
			}else
			{
				$Cout4 = "";
				if($nama_perusahaan=='')
				{
					$Cout = "{}";
				}
			}
	
			$Cout3 = $query;

			//$Cout4 = "Invalid AUTH key";
			//$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;	
?>
