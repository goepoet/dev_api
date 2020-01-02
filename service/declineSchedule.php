<?php
include '../service/MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
	$request_id=$_REQUEST['request_id'];
	$authKey=$_REQUEST['auth_key'];
	$note=$_REQUEST['note'];
	//======================================================================
	
	$menuPreviledge=new MST_MENU_PRIVILEDGE;
	$Survey_request=new Cass_survey_request;
	$notif=new Cass_notification;
	$Decline=new Cass_decline_survey;
	$userInternal=new Cass_MstUser;
	$SendNotif=new PushNotif; 
	$sms=new Sms;
	$Cass_Gcm=new Cass_Gcm;

	$userInternal->select("where token_id='$authKey'");
	$tampilUser=$userInternal->tampil();
	$userId=$tampilUser['userid'];
	$isiDecline = array('reg_date' =>date("Y-m-d H:i:s"),'request_id'=>$request_id,'note'=>$note,'decline_id'=>$userId);
	$Survey_request->select("where survey_id='$request_id'");
	$tampilReq=$Survey_request->tampil();
	$branch_id=$tampilReq['branch_id'];
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
	if($note=='')
	{
		/*$Cout .='{"Msg":"Silahkan masukan alasan pembatan anda"}';
		echo $Cout='{"data":'.$Cout.'}';*/
		$Cout4 = "Silahkan masukan alasan pembatan anda";
		$query="0";
	}else
	{
		$isinya = array('status_claim' =>"2",'status'=>"Cancel by user",'status_internal'=>"Cancel" );
		$query=$Survey_request->ubah($isinya,"where survey_id='$request_id'");
		$Decline->simpan($isiDecline);
		if($query=='0')
		{
			$Cout4 = "Invalid query";
		}else
		{
			$Cout4="Survey berhasil di batalkan";
			$notifID=$SendNotif->sendPushNotificationEsti("User membatalkan jadwal", $ids);
		}
		//echo ($query);
	}
			$Cout3 = $query;			
			//$Cout4 = "Invalid AUTH key";
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;
?>
