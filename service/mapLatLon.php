<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include '../conf/konek.php';

$posisi=new MST_MENU_PRIVILEDGE;

$posisi->posisiSurveyor("where user_id <>'' and surveyor='Y'");
$Cout="";
while ($pecah=$posisi->tampil()) 
{
	if($Cout !=""){$Cout .=",";}		
	$Cout .='{"id":"'.$pecah["user_id"].'",';	
	$Cout .='"name":"'.$pecah["Name"].'",';
	$Cout .='"surveyor":"'.$pecah["Name"].'",';
	$Cout .='"lat":"'.$pecah["lat_agent"].'",';		
	$Cout .='"lon":"'.$pecah["lon_agent"].'"}';
}

$survey=new Cass_survey_request;
//$survey->select("where status <>'Ready To Workshop' and status_claim ='1'");
$survey->select("where request_type='1' and status_claim='1'  and branch_id in(01,24,14) and status not in('Ready To Workshop','Arrived','On Going')
and status_internal not in('Completed','Waiting PLA','Unpaid Premium')");
while ($request=$survey->tampil()) {
	$status=$request["status_internal"];
	if ($status=='Unpaid Premium'){
		$status=" [". $request["status_internal"]."] ";
	}else
	{
		$status="";
	}
	if($Cout !=""){$Cout .=",";}		
	$Cout .='{"id":"Claim",';	
	$Cout .='"name":"'.$request["survey_id"].$status.'",';
	$Cout .='"surveyor":"'.$request["surveyor"].'",';
	$Cout .='"lat":"'.$request["location_lat"].'",';		
	$Cout .='"lon":"'.$request["location_lon"].'"}';
}


/*$Cout = '{"id":48,"title":"sapi","longitude":"106.849808","latitude":"-6.242894"},{"id":46,"title":"kambing","longitude":"106.908490","latitude":"-6.156779"},{"id":46,"title":"kebo","longitude":"106.65270991623403","latitude":"-6.2023937307141495"}';*/
$Cout='{"data":['.$Cout.']}';
echo $Cout;	
//print_r($survey);

?>
