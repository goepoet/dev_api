<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
	$name=$data->name;
	$COL=new location;
	$query=$COL->select("where Name like '%$name%'");
	
	//$bengkel=new MST_BENGKEL;
	//$bengkel->Select("");
	$Cout="";
		while($pecah=$COL->tampil()){
		if($Cout !=""){$Cout .=",";}		
		$Cout .='{"id":"'.$pecah["Location"].'",';		
		$Cout .='"remarks":"'.$pecah["Name"].'"}';
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
