<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	
	$auth_key=str_replace('\'','',$_REQUEST['auth_key']);
	//=============================================
	$Cass_survey_request = new Cass_survey_request;
	$menuPreviledge=new MST_MENU_PRIVILEDGE;
	$MST_PROFILE_CARE=new MST_PROFILE_CARE;
	$Cass_MstUser=new Cass_MstUser;
	$mstDataUser=new Cass_MstDataUser;
	$mstBengkel= new MST_BENGKEL;

	$Cass_MstUser->select("Where token_id='$auth_key'");
	$TampilUser=$Cass_MstUser->tampil();
	$userId=$TampilUser['userid'];
	$notif=new Cass_notification;
	$query=$notif->select("where read_status='1' and user_id='$userId' order by ID asc");
	while($pecah=$notif->tampil()){
		$requsId=$pecah["content_id"];
		$ratingType=$pecah['rating_type'];
		$notifType=$pecah['notification_type'];

		$Cass_survey_request->select("where survey_id='$requsId'");
		$tampil_survey=$Cass_survey_request->tampil();
		$surveyorID=$tampil_survey["surveyor"];
		$workshop=$tampil_survey['workshop'];
		$polis=$tampil_survey["policy_no"];
		$certificat=$tampil_survey["certificateno"];
		$OR=$tampil_survey["own_risk"];
		$mstBengkel->select("where ID='$workshop'");//cari nama bengkel
		$tampilBengkel=$mstBengkel->tampil();
		$menuPreviledge->select("where ID='$surveyorID'");//cari nama agent
		$tampilUser=$menuPreviledge->tampil();
		
		if($ratingType=='2')//bengkel
		{
			$userName=$tampilBengkel['nama_bengkel'];//nama bengkel
			$gbrUser="http://shield.panfic.com:8081/image_shield/profile/workshop.png";
		}
		else
		{
			$userName=$tampilUser['Name'];//nama user
			$gbrUser=$tampilUser['pic'];
		}
		
		$mstDataUser->select("where policyno='$polis' and certificateno='$certificat'");
		$tampilKendaraan=$mstDataUser->tampil();
		$MST_PROFILE_CARE->select("where POLICYNO='$polis' and CERTIFICATENO='$certificat'");
		$tampilProfil=$MST_PROFILE_CARE->tampil();
		$deduc=$tampilProfil["DEDUCTIBLE"];
		$totalOR=$OR * $deduc;
		if($Cout !=""){$Cout .=",";}
		//$idnya=$pecah["ID"];

		$Cout .='{"id":"'.$pecah["ID"].'",';	
		$Cout .='"notification_type":"'.$pecah["notification_type"].'",';
		$Cout .='"rating_type":"'.$pecah["rating_type"].'",';
		$Cout .='"content_id":"'.$pecah["content_id"].'",';
		$Cout .='"content_name":"'.$userName." (".$pecah["content_id"].")".'",';
		$Cout .='"content_date":"'.date("Y-m-d",strtotime($tampil_survey["survey_date"])).'",';
		$Cout .='"content_time":"'.$tampil_survey["survey_time"].'",';
		$Cout .='"content_new_date":"'.date("Y-m-d",strtotime($tampil_survey["res_survey_date"])).'",';
		$Cout .='"content_new_time":"'.$tampil_survey["res_survey_time"].'",';
		if($notifType=='3'){
		$Cout .='"content_spk_title":"Persetujuan OR",';
		$Cout .='"content_spk_msg":"Berikut terlampir nilai OR yang harus anda bayarkan, untuk dapat melanjutkan proses klaim",';
		$Cout .='"content_spk_name":"'.$tampilKendaraan['claimant'].'",';
		$Cout .='"content_spk_machine_no":"'.$tampilKendaraan['machine_number'].'",';
		$Cout .='"content_spk_car_no":"'.$tampilKendaraan['license_no'].'",';
		$Cout .='"content_spk_value":"'.$OR.'",';
		$Cout .='"content_spk_price":"'.$deduc.'",'; 
		$Cout .='"content_spk_total":"'.$totalOR.'",'; 
		}
		$Cout .='"content_profile_image":"'.$gbrUser.'"}';
	}
		$Cout3 = $query;			
		$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":['.$Cout.']}';
		echo $Cout;	
?>