<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
	$branchId=$_REQUEST['branch'];

	$surveyor=new MST_MENU_PRIVILEDGE;
	$query=$surveyor->select("where branch='$branchId' and surveyor='Y'");
	
	//$bengkel=new MST_BENGKEL;
	//$bengkel->Select("");
	$Cout="";
	while($pecah=$surveyor->tampil()){
		if($Cout !=""){$Cout .=",";}		
		$Cout .='{"id":"'.$pecah["ID"].'",';	
		$Cout .='"name":"'.$pecah["Name"].'",';
		$Cout .='"phone":"'.$pecah["Phone"].'",';
		$Cout .='"pic":"'.$pecah["pic"].'"}';		
		}
	/*$Cout='{"data":['.$Cout.']}';
	echo ($Cout);*/
	if($query=='0')
	{
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
