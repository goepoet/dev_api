<?php
include '../service/MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
	$auth_key=$_REQUEST['auth_key'];
	$request_id=$_REQUEST['survey_id'];
	$survey_date=$_REQUEST['survey_date'];
	$survey_time=$_REQUEST['survey_time'];
	$reponse=$_REQUEST['response_type'];
	//======================================================================
	$MstUser=new Cass_MstUser;
	$menuPreviledge=new MST_MENU_PRIVILEDGE;
	$Survey_request=new Cass_survey_request;
	$notif=new Cass_notification;
	$SendNotif=new PushNotif; 
	$sms=new Sms;
	$Cass_Gcm=new Cass_Gcm;
	$Decline=new Cass_decline_survey;
	
	$MstUser->select("where token_id='$auth_key'");
	$Survey_request->select("where survey_id='$request_id'");
	$tampilSurvey=$Survey_request->tampil();
	$userId=$tampilSurvey['user_id'];
	$branch_id=$tampilSurvey['branch_id'];

	$reschedule_date=$tampilSurvey['res_survey_date'];
	$reschedule_time=$tampilSurvey['res_survey_time'];
	
	$isinya = array(
		'user_id'=>$userId,
		'notification_type'=>"2",
		'rating_type'=>"",
		'content_id'=>"",
		'content_name'=>$request_id,
		'create_date'=>date('Y-m-d H:i:s'),
		'read_status'=>'1'
	);
	//========Cari GCM estimator======================================================
		$Cass_Gcm->gcm_internal("where branch='$branch_id' and estimator ='Y'");
		$ids = array();
		while($viewApikey=$Cass_Gcm->tampil())
		{
			if($Apikey !=""){$Apikey .=",";}	
			//$Apikey .="'".$viewApikey['device_id']."'";
			array_push($ids, "".$viewApikey['device_id']."");
		}
	//================================================================================	
	if($reponse=='')
	{
		/*$Cout .='{"msg":"silahkan masukan persetujuan anda"}';
		echo $Cout='{"data":'.$Cout.'}';*/
				$Cout3 = "0";
				$Cout4 = "silahkan masukan persetujuan anda";
				$Cout = "{}";
				$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
				echo $Cout;	
	}else{
		if($reponse=='1')
		{
			$Datanya = array('survey_date' =>$reschedule_date ,'survey_time'=>$reschedule_time,'timestamp'=>$reschedule_date);
			$query=$Survey_request->ubah($Datanya,"where survey_id='$request_id'");
			
			$Cout3 = $query;
			if($query=='1')
			{
				$Cout4 = "Terima kasih telah memverifikasi waktu survey anda";
				$notifID=$SendNotif->sendPushNotificationEsti("User menyetujui jadwal", $ids);
			}else
			{
				$Cout4 = "Jadwal gagal di verivikasi";
			}
			
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;	
		}elseif($reponse=='2')
		{
			$Datanya = array('survey_date' =>$survey_date ,'survey_time'=>$survey_time,'timestamp'=>$reschedule_date);
			$query=$Survey_request->ubah($Datanya,"where survey_id='$request_id'");
			
			$Cout3 = $query;
			if($query=='1')
			{
				$Cout4 = "Jadwal survey berhasil di perbaharui";
				$notifID=$SendNotif->sendPushNotificationEsti("User memperbarui jadwal survey", $ids);
			}else
			{
				$Cout4 = "Jadwal gagal di verivikasi";
			}
			
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;	
		}elseif($reponse=='3') 
		{
			$isiDecline = array('reg_date' =>date("Y-m-d H:i:s"),'request_id'=>$request_id,'note'=>"",'decline_id'=>$userId);
			$isinya = array('status_claim' =>"2",'status'=>"Cancel by Customer",'status_internal'=>"Cancel" );
			$query=$Survey_request->ubah($isinya,"where survey_id='$request_id'");
			$Decline->simpan($isiDecline);
			$Cout3 = $query;
			if($query=='0')
			{
				$Cout4 = "Invalid query";
			}else
			{
				$Cout4="Survey berhasil di batalkan";
				$notifID=$SendNotif->sendPushNotificationEsti("User membatalkan jadwal", $ids);
			}
			//====================
			/*$Datanya = array('survey_date' =>$survey_date ,'survey_time'=>$survey_time,'timestamp'=>$reschedule_date);
			$query=$Survey_request->ubah($Datanya,"where survey_id='$request_id'");
			
			$Cout3 = $query;
			if($query=='1')
			{
				$Cout4 = "Jadwal survey berhasil di perbaharui";
				$notifID=$SendNotif->sendPushNotification("User memperbarui jadwal survey", $ids);
			}else
			{
				$Cout4 = "Jadwal gagal di verivikasi";
			}*/
			
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;	
		}

		else
		{
			/*$Cout ='{"msg":"Silahkan pilih jadwal survey yang lain"}';
			echo $Cout='{"data":'.$Cout.'}';*/

			$Cout3 = "1";
			$Cout4 = "Silahkan pilih jadwal survey yang lain";
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;	
		}
		
		
	}
?>
