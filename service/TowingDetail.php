<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	$survey_id=$_REQUEST['towing_id'];
	$auth_key=$_REQUEST['auth_key'];
	$Cass_survey_request = new Cass_survey_request;
	$Cass_towing= new Cass_finish_towing;
	
	$query=$Cass_survey_request->Select("where survey_id='$survey_id'");
	$pecah=$Cass_survey_request->tampil();
	$nopol=$pecah['policy_no'];
	$certi=$pecah['certificateno'];
	$userId=$pecah['surveyor'];
	$workshop=$pecah['workshop'];
	$dataUser=new Cass_MstDataUser;
	$dataUser->select("where policyno='$nopol' and certificateno='$certi'");
	$pecahDataUser=$dataUser->tampil();
	$MST_MENU_PRIVILEDGE=new MST_MENU_PRIVILEDGE;
	$MST_MENU_PRIVILEDGE->select("where ID='$userId'");
	$pecahUser=$MST_MENU_PRIVILEDGE->tampil();
	$MST_BENGKEL=new MST_BENGKEL;
	$MST_BENGKEL->select("where id ='$workshop'");
	$pecahMST_BENGKEL=$MST_BENGKEL->tampil();
	$Cass_pickUp_survey=new Cass_pickUp_survey;
	$Cass_pickUp_survey->select("where survey_id='$survey_id'");
	$pecahCass_pickUp_survey=$Cass_pickUp_survey->tampil();
	$Cass_towing->select("where survey_id='$survey_id'");
	$tampilTowing=$Cass_towing->tampil();
	
	if($survey_id=='')
	{
		/*$Cout .='{"msg":"Invalid Towing id"}';
		echo $Cout='{"data":'.$Cout.'}';*/
		$Cout4 = "Invalid Towing id";
		$query="0";

	}elseif($auth_key=='')
	{
		/*$Cout .='{"msg":"Invalid Auth Key"}';
		echo $Cout='{"data":'.$Cout.'}';*/
		$Cout4 = "Invalid Auth Key";
		$query="0";
	}else{
	$Cout="";
		if($Cout !=""){$Cout .=",";}		
		$Cout .='{"id":"'.$pecah["survey_id"].'",';
		$Cout .='"state":"'.$pecah["status"].'",';
		$Cout .='"detail":{';
		//$Cout .='"timestamp":"'.$pecah["status"].'",';
		$Cout .='"timestamp":"'.date("D d-M-Y",strtotime($pecah["survey_date"]))." ".$pecah["survey_time"].'",';
		$Cout .='"car_number":"'.$pecahDataUser["license_no"].'",';
		$Cout .='"car_type":"'.$pecahDataUser["vehicle_brand"]." ".$pecahDataUser["vehicle_model"].'",';
		$Cout .='"address":"'.$pecah["location_address"].'",';
		$Cout .='"notes":"'.$pecah["notes"].'"},';
		$Cout .='"agent":{';
		$Cout .='"id":"'.$pecahUser["ID"].'",';
		$Cout .='"name":"'.$pecahUser["Name"].'",';
		$Cout .='"phone":"'.$pecahUser["Phone"].'",';
		$Cout .='"profile_image":"'.$pecahUser["pic"].'",';
		$Cout .='"lat":"'.$pecahCass_pickUp_survey["lat"].'",';
		$Cout .='"lon":"'.$pecahCass_pickUp_survey["lon"].'"},';
		$Cout .='"recipient":{';
		$Cout .='"recipient_type":"2",';
		$Cout .='"name":"'.$tampilTowing["penerima"].'",';		
		$Cout .='"phone":"'.$tampilTowing["phone"].'"}}';		
	/*$Cout='{"data":'.$Cout.'}';
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
			
			//$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
				
	}
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
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;
?>
