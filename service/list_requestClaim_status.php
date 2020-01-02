<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type,X-Custom-Header");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
	$branchId=$_REQUEST['branch'];
	$claimno=$_REQUEST['claimno'];
	if($branchId=='')
	{
		$branchId=$data->branch;
		$claimno=$data->claimno;
	}
	$listData=new tr_survey_log;
	$fuActifity= new fu_activity;
	$profileCare= new MST_PROFILE_CARE;
	$rtf=new RTF;
	$query=$listData->get_query_requestClaim_status($branchId,$claimno);
	
	$Cout="";
	$no=1;
	while($pecah=$listData->tampil()){
		$no_claim=$pecah["claimno"];			
		$status=$pecah["status"];
		
		if($status=='7')
		{
			$statusnya="PLA to Care";
		}elseif($status=='6')
		{
			$statusnya="PLA send to Workshop";
		}elseif($status=='5'){
			$statusnya="Manual Via Care";		
		}elseif($status=='4'){
			$statusnya="Reschedule";		
		}else{
			$statusnya="Belum PLA";
		}
		$fuActifity->select_join_bengkel("where A.no_claim='$no_claim' and CONVERT(varchar, A.workshop)<>''");
		$pecah_bengkel=$fuActifity->tampil();

		if($Cout !=""){$Cout .=",";}		
		$Cout .='{"calls_id":"'.$pecah["calls_id"].'",';	
		$Cout .='"tanggal":"'.$pecah["tanggal"].'",';
		$Cout .='"branch":"'.$pecah["branch"].'",';
		$Cout .='"names":"'.$pecah["names"].'",';
		$Cout .='"reg_id":"'.$pecah["reg_id"].'",';
		$Cout .='"survey_id":"'.$pecah["survey_id"].'",';
		$Cout .='"survey_date":"'.$pecah["survey_date"].'",';
		$Cout .='"policyno":"'.$pecah["policyno"].'",';
		$Cout .='"claimno":"'.$pecah["claimno"].'",';
		//$Cout .='"address":"'.str_replace("\t","",$pecah["address"]).'",';
		$Cout .='"city":"'.$pecah["city"].'",';
		$Cout .='"province":"'.$pecah["province"].'",';
		$Cout .='"remarks":"'.$pecah["remarks"].'",';
		$Cout .='"status":"'.$statusnya.'",';
		$Cout .='"surveyor":"'.$pecah["surveyor"].'",';
		$Cout .='"workshop":"'.$pecah_bengkel["nama_bengkel"].'",';
		$Cout .='"no":"'.$no.'",';
		$Cout .='"from":"'.$pecah["from"].'",';
		$Cout .='"name":"'.$pecah["name"].'"}';	
		$no=$no+1;	
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
			//$Cout='{"status":"'.$Cout3.'","msg":"'.$claimno.'","data":['.$Cout.']}';
			$Cout='{"data":['.$Cout.']}';
			echo $Cout;		
?>
