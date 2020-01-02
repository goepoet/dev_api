<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
	//$branch_id=$_GET['id'];
	//$nama_bengkel=$_GET['id'];
	$branch=$_REQUEST['branch'];
	$towing=new Cass_MstTowing;
	
	$query=$towing->Select("");
	
	//$bengkel=new MST_BENGKEL;
	//$bengkel->Select("");
	$Cout="";
	while($pecah=$towing->tampil()){
		if($Cout !=""){$Cout .=",";}		
		$Cout .='{"id":"'.$pecah["ID"].'",';
		$Cout .='"name":"'.$pecah["towing_name"].'",';
		$Cout .='"rating":"'.$pecah["rating"].'",';
		$Cout .='"phone":"'.$pecah["phone"].'",';
		$Cout .='"lat":"'.$pecah["lat"].'",';
		$Cout .='"lon":"'.$pecah["lon"].'"}';	
		}
	/*$Cout='{"data":['.$Cout.']}';
	echo ($Cout);*/
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
