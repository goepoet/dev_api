<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
	$auth_key=$_REQUEST['auth_key'];
	$history_type=$_REQUEST['history_type'];
	
	$Cass_MstUser=new Cass_MstUser;
	$Cass_survey_request=new Cass_survey_request;
	$Cass_MstDataUser=new Cass_MstDataUser;
	$Cass_MstUser->Select("where token_id='$auth_key'");
	$tampilUser=$Cass_MstUser->tampil();
	$userId=$tampilUser['userid'];
	

	$query=$Cass_survey_request->Select("where status_claim='$history_type' and user_id='$userId' order by ID desc");
	//$tampilSurvey=$Cass_survey_request->tampil();
	

	$Cout="";
	if($auth_key =='')
	{
		/*$Cout .='{"msg":"Invalid Auth Key"}';
		echo $Cout='{"data":'.$Cout.'}';*/
		$Cout4 = "Invalid Auth Key";
		$query="0";
	}else
	{
		while($pecah=$Cass_survey_request->tampil())
		{
		$noPolicy=$pecah["policy_no"];
		$noCertificate=$pecah["certificateno"];

		$Cass_MstDataUser->Select("where policyno ='$noPolicy' and certificateno='$noCertificate'");
		$tampilDataUser=$Cass_MstDataUser->tampil();

		if($Cout !=""){$Cout .=",";}		
		$Cout .='{"id":"'.$pecah["survey_id"].'",';
		$Cout .='"request_type":"'.$pecah["request_type"].'",';
		//$Cout .='"timestamp":"'.$pecah["timestamp"].'",';
		$Cout .='"timestamp":"'.date("D d-M-Y",strtotime($pecah["survey_date"]))." ".$pecah["survey_time"].'",';
		$Cout .='"status":"'.$pecah["status"].'",';
		$Cout .='"policy_number":"'.$pecah["policy_no"].'",';
		$Cout .='"car_type":"'.$tampilDataUser["vehicle_brand"]." ".$tampilDataUser["vehicle_model"].'"}';
		}
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
