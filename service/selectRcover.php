<?php
	include 'MainFrame.php';
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	
	$data=json_decode(file_get_contents("php://input"));
	ini_set('memory_limit', '-1');
	//==================================Parameter=========
	
	//$nopol=mssql_real_escape_string($data->nopol);
	//$certif=mssql_real_escape_string($data->certif);
	$nopol="06022314080037";
	$certif="002378";
	//===================================================
	$acceptance=new ACCEPTANCE;
	$rCover=new RCOVER;
	
	$acceptance->select("where POLICYNO='$nopol' and CERTIFICATENO='$certif'");
	$pecah=$acceptance->tampil();
	$ano=$pecah['ANO'];
	$rCover->getDetail($ano);
	
	$Cout="";
	while($pecahrCover=$rCover->tampil()){
		if($Cout !=""){$Cout .=",";}		
		$Cout .='{"Remark":"'.$pecahrCover["REMARK"].'",';
		$Cout .='"Sdate":"'.date("d-M-Y",strtotime($pecahrCover["SDATE"])).'",';		
		$Cout .='"Edate":"'.date("d-M-Y",strtotime($pecahrCover["EDATE"])).'"}';
		}
	$Cout='{"data":['.$Cout.']}';
	echo ($Cout);
?>
