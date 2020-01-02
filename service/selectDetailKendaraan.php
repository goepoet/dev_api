<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konekCare.php';
	$data=json_decode(file_get_contents("php://input"));
	ini_set('memory_limit', '-1');
	//$norangka=$data->norangka;
	$norangka='MHKV1BA2JBK094791';
	
	$acceptance=new ACCEPTANCE;
	$ainfo=new Ainfo;
	$acceptance->select("where VALUEDESC like'%$norangka%'");
	$pecahAccp=$acceptance->tampil();	
	$toc=substr($pecahAccp['POLICYNO'],2,4);//cari TOC
	$detailVehicle = $ainfo->detailvehicle($pecahAccp['ANO'],$toc );//ambil detail kendaan
	
		$Cout="";
		
		if($Cout !=""){$Cout .=",";}	
		$Cout .='{"name":"'.$pecahAccp['AName'].'",';	
		$Cout .='"policyno":"'.$pecahAccp['POLICYNO'].'",';
		$Cout .='"certificateno":"'.$pecahAccp['CERTIFICATENO'].'",';
		$Cout .='"license_no":"'.$detailVehicle['License_number'].'",';
		$Cout .='"vehicle_brand":"'.$detailVehicle['Brand'].'",';
		$Cout .='"vehicle_type":"'.$detailVehicle['Vehicle_type'].'",';
		$Cout .='"vehicle_model":"'.$detailVehicle['Vehicle_model'].'",';
		$Cout .='"color":"'.$detailVehicle['Color'].'",';
		$Cout .='"year":"'.$detailVehicle['Year'].'",';
		$Cout .='"chasis_number":"'.$detailVehicle['Chasis_number'].'",';
		$Cout .='"machine_number":"'.$detailVehicle['Machine_number'].'",';
		$Cout .='"start_date":"'.date("d-M-Y",strtotime($pecahAccp["SDATE"])).'",';		
		$Cout .='"end_date":"'.date("d-M-Y",strtotime($pecahAccp["EDATE"])).'"}';
		
	$Cout='{"data":['.$Cout.']}';
	echo ($Cout);
?>
