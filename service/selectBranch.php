<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	//include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
	$branch=new mst_branch;
	$query=$branch->select("where branchid in('10','14','24','01')");
	
	//$bengkel=new MST_BENGKEL;
	//$bengkel->Select("");
	$Cout="";
	while($pecah=$branch->tampil()){
		if($Cout !=""){$Cout .=",";}		
		$Cout .='{"id":"'.$pecah["BranchId"].'",';	
		$Cout .='"name":"'.$pecah["BranchName"].'",';
		$Cout .='"address":"'.$pecah["Address"].'",';
		$Cout .='"phone":"'.$pecah["Phone"].'",';
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
