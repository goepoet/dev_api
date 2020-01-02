<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
	$RoadAsst=new Cass_RoadAsst;
	$query=$RoadAsst->select("");
	
	//$bengkel=new MST_BENGKEL;
	//$bengkel->Select("");
	$Cout="";
	while($pecah=$RoadAsst->tampil()){
		if($Cout !=""){$Cout .=",";}		
		$Cout .='{"id":"'.$pecah["road_id"].'",';		
		$Cout .='"remarks":"'.$pecah["remarks"].'"}';
		}
	/*$Cout='{"data":['.$Cout.']}';
	echo ($Cout);*/
	$Cout3 = $query;
			if($query=='0')
			{
				$Cout4 = "Invalid query";
				$Cout = "{}";
			}else
			{
				$Cout4 = "";
			}			
			//$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":['.$Cout.']}';
			echo $Cout;
?>
