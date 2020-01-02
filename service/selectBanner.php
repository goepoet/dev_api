<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
	$banner=new Cass_Banner;
	$query=$banner->select("");
	
	//$bengkel=new MST_BENGKEL;
	//$bengkel->Select("");
	$Cout="";
	while($pecah=$banner->tampil()){
		if($Cout !=""){$Cout .=",";}		
		$Cout .='{"id":"'.$pecah["ID"].'",';
		$Cout .='"img_url":"'.$pecah["img_url"].'",';
		$Cout .='"link_url":"'.$pecah["link_url"].'"}';
		}
	/*$Cout='{"data":['.$Cout.']}';
	//$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
	echo ($Cout);*/
	/*$Cout3 = "false";
	$Cout4 = "Harap lengkapi form permohonan survey anda";
	//$Cout = "{}";
	$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
	echo $Cout;*/
			if($query=='0'){
				$Cout4 = "Invalid query";
			}else
			{
				$Cout4 = "";
			}
			$Cout3 = $query;			
			//$Cout4 = "Invalid AUTH key";
			//$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":['.$Cout.']}';
			echo $Cout;	

?>
