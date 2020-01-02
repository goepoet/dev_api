<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	$survey_id=$_REQUEST['survey_id'];//"RC1609000019";//$data->survey_id;
	$auth_key=$_REQUEST['auth_key'];//$data->auth_key;

	$Cass_decline_survey=new Cass_decline_survey;
	$Cass_decline_survey->select("where request_id='$survey_id'");
	$tampilDecline=$Cass_decline_survey->tampil();
	if ($tampilDecline['note']=="")//cek note Cancel survey
	{
		$decline="-";
	}else{
		$decline="".$tampilDecline['note']."";
	}
	
	$Cass_survey_request = new Cass_survey_request;
	
	$Cass_survey_request->Select("where survey_id='$survey_id'");
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
	
	$Cout="";	
		if($Cout !=""){$Cout .=",";}		
		$Cout .='{"id":"'.$pecah["survey_id"].'",';
		$Cout .='"state":"'.$pecah["status"].'",';
		$Cout .='"detail":{';
		$Cout .='"timestamp":"'.date("D d-M-Y",strtotime($pecah["survey_date"]))." ".$pecah["survey_time"].'",';
		$Cout .='"car_number":"'.$pecahDataUser["license_no"].'",';
		$Cout .='"car_type":"'.$pecahDataUser["vehicle_brand"]." ".$pecahDataUser["vehicle_model"].'",';
		$Cout .='"address":"'.$pecah["location_address"].'",';
		$Cout .='"notes":"'.$pecah["notes"].'"},';
		$Cout .='"agent":{';
		$Cout .='"id":"'.$pecahUser["ID"].'",';
		$Cout .='"name":"'.$pecahUser["Name"].'",';
		$Cout .='"phone":"'.$pecahUser["phone"].'",';
		$Cout .='"profile_image":"'.$pecahUser["pic"].'",';
		$Cout .='"lat":"'.$pecahCass_pickUp_survey["lat"].'",';
		$Cout .='"lon":"'.$pecahCass_pickUp_survey["lon"].'"},';

		$Cout .='"cancel_skip":{';
		$Cout .='"id":"'.$pecah["survey_id"].'",';		
		$Cout .='"reason":"'.$decline.'"},';

		$Cout .='"workshop":{';
		$Cout .='"id":"'.$pecahMST_BENGKEL["ID"].'",';
		$Cout .='"name":"'.$pecahMST_BENGKEL["nama_bengkel"].'",';
		$Cout .='"address":"'.$pecahMST_BENGKEL["alamat"].'",';		
		$Cout .='"phone":"'.$pecahMST_BENGKEL["telp"].'"}}';		

		$idnya=$pecah["survey_id"];
		if($idnya=='')
		{
			$Cout3 = "0";
			$Cout = "{}";
		}else
		{
			$Cout3 = "1";
		}

		$Cout4 = "";

		$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
		echo $Cout;	
?>
