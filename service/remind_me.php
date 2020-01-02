<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
	/*$profil=new Profil_panfic;
	$query=$profil->select("");*/
	
	//$bengkel=new MST_BENGKEL;
	//$bengkel->Select("");
	//$Cout="";
		/*while($pecah=$profil->tampil()){
		if($Cout !=""){$Cout .=",";}
		$nama_perusahaan=$pecah["nama_perusahaan"];*/		
		$Cout .='{"title":"Reminde me later",';
		$Cout .='"msg":"Mohon hubungi Customer Service untuk melakukan pembatalan"}';
		//}
			
			$Cout='{"status":"1","msg":"","data":'.$Cout.'}';
			echo $Cout;	
?>
