<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konekCare.php';
	$data=json_decode(file_get_contents("php://input"));
	ini_set('memory_limit', '-1');
	//$id=mysql_real_escape_string($data->id);
	$norangka='MHKV1BA2JBK094791';
	$bengkel=new ACCEPTANCE;
	$bengkel->select("where VALUEDESC like'%$norangka%'");
	
	//$bengkel=new MST_BENGKEL;
	//$bengkel->Select("");
	$Cout="";
	while($pecah=$bengkel->tampil()){
		if($Cout !=""){$Cout .=",";}		
		$Cout .='{"Ano":"'.$pecah["ANO"].'",';
		$Cout .='"Name":"'.$pecah["AName"].'",';
		$Cout .='"Policyno":"'.$pecah["POLICYNO"].'",';
		$Cout .='"Certificateno":"'.$pecah["CERTIFICATENO"].'",';
		$Cout .='"NoRangka":"'.$pecah["VALUEID"].'"}';
		}
	$Cout='{"data":['.$Cout.']}';
	echo ($Cout);
?>
