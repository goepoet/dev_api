<?php
	include 'MainFrame.php';
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	//include '../conf/konekCare.php';
	//include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	ini_set('memory_limit', '-1');
	//================================================
	$auth_key=$_REQUEST['auth_key'];//$data->auth_key;//"b9876c0dbcccf24ec7498d24ba1fee3a";
	$id_policy=$_REQUEST['policy_id'];//$data->policy_id;//tambahan di App untuk menampilkan datanya melalui param di App
	//================================================
	$Cass_survey_request = new Cass_survey_request;
	$Cass_MstUser = new Cass_MstUser;
	$Cass_MstDataUser=new Cass_MstDataUser;
	$notif=new Cass_notification;
	$menuPreviledge=new MST_MENU_PRIVILEDGE;

	$SendNotif=new PushNotif; 
	$sms=new Sms;
	$Cass_Gcm=new Cass_Gcm;

	$nomor=$Cass_survey_request->autonum();

	$Cass_MstUser->select("where token_id='$auth_key'");
	$Cass_MstDataUser->select("where ID='$id_policy'");
	$pecah=$Cass_MstUser->tampil();
	$pecahDataUser=$Cass_MstDataUser->tampil();
	
	//================================================
	$user_id=$pecah['userid'];
	$branch_id="01";//$_REQUEST['branch_id'];//tidak ada branch karena untuk branch ini tidak berlaku untuk permohonan ini (hanya berlaku untuk permohonan surve.
	$policy_no=$pecahDataUser['policyno'];
	$certificateno=$pecahDataUser['certificateno'];//penambahan data sertifikat untuk proses PLA
	$location_address=$_REQUEST['location_address'];
	$location_detail=$_REQUEST['location_detail'];
	$location_lat=$_REQUEST['location_lat'];
	$location_lon=$_REQUEST['location_lon'];
	$timestamp=$_REQUEST['timestamp'];
	$date_of_loss="";
	$loss_location="";
	$cause_of_loss=$_REQUEST['cause_of_damage_id'];
	$notes=$_REQUEST['notes'];
	$survey_date=date('Y-m-d H:i:s');//$_REQUEST['survey_date'];
	$survey_time=$_REQUEST['survey_time'];
	if($cause_of_loss=='04'){//request towing
		$request_type="2";//$_REQUEST['request_type'];
		$Cass_Gcm->gcm_internal("where estimator ='T'");
		$pesanPush="Anda memiliki permohonan towing";
	}else
	{
		$request_type="3";// request road assitance
		$Cass_Gcm->gcm_internal("where estimator ='R'");
		$pesanPush="Anda memiliki permohonan Road Assistance";
	}
	$Cass_survey_request->select("where user_id='$user_id' and status_claim='1' and request_type='$request_type' and policy_no='$policy_no' and certificateno='$certificateno'");
	$tampilSurvey=$Cass_survey_request->tampil();
	$userSurvey=$tampilSurvey['user_id'];
	//================================================
	$menuPreviledge->select("where branch='$branch_id' and estimator ='Y'");
	$tampilEstimator=$menuPreviledge->tampil();
	$estimator=$tampilEstimator['ID'];	
	$isinotif = array(
		'user_id'=>$user_id,//yang request
		'notification_type'=>"3",//konfirmasi ke estimator
		'rating_type'=>"",
		'content_id'=>$estimator,//notif tujuan
		'content_name'=>"",
		'create_date'=>date('Y-m-d H:i:s'),
		'read_status'=>'1'
	);
	//========Cari GCM estimator======================================================
		$ids = array();
		while($viewApikey=$Cass_Gcm->tampil())
		{
			if($Apikey !=""){$Apikey .=",";}	
			//$Apikey .="'".$viewApikey['device_id']."'";
			array_push($ids, "".$viewApikey['device_id']."");
		}	

	if($userSurvey !='')
	{
				$Cout3 = "0";
				if($request_type=='2'){
					$Cout4 = "Anda masih memiliki permohonan towing yang belum selesai";
				}else
				{
					$Cout4 = "Anda masih memiliki permohonan road assistance yang belum selesai";
				}
				
				$Cout = "{}";
				$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
				echo $Cout;		
	}else
	{				
		if($location_address !='')
		{
				$Cass_survey_request->totalSurvey("where survey_id='$nomor'");
				$tampilkan=$Cass_survey_request->tampil();
				$dataS=$tampilkan['total'];
				if($dataS !='0')
				{
					$nomor=$Cass_survey_request->autonum(); 
				}
				$isinya = array(
					'user_id'=>$user_id,
					'register_date'=>date('Y-m-d H:i:s'),
					'survey_id'=>$nomor,
					'branch_id'=>$branch_id,
					'policy_no'=>$policy_no,
					'certificateno'=>$certificateno,
					'location_address'=>$location_address,
					'location_detail'=>$location_detail,
					'location_lat'=>$location_lat,
					'location_lon'=>$location_lon,
					'timestamp'=>$timestamp,
					'date_of_loss'=>$date_of_loss,
					'loss_location'=>$loss_location,
					'cause_of_loss'=>$cause_of_loss,
					'notes'=>$notes,
					'survey_date'=>$survey_date,
					'survey_time'=>$survey_time,
					'status'=>"Pending",
					'request_type'=>$request_type,
					'status_claim'=>"1",
					'estimator'=>"",
					'surveyor'=>"",
					'workshop'=>"",
					'auth_key'=>$auth_key
				);
				$simpan=$Cass_survey_request->simpan($isinya);				
				//echo ($simpan);
				if($simpan=='0')
					{
						$Cout4 = "Permohonan gagal";
					}else
					{
						$Cout4 = "Permohonan anda akan segera kami proses";
						if($cause_of_loss=='04'){//towing nih
							$SendNotif->sendPushNotificationTowing($pesanPush, $ids);
						}
							else
						{
							$SendNotif->sendPushNotificationRoad($pesanPush, $ids);
						}

						//request towing
						//$notifID=$SendNotif->sendPushNotification($pesanPush, $ids);//kririm push notif
					}
					$Cout3 = $simpan;					
					$Cout = "{}";
					$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
					echo $Cout;				
		}else
		{
				$Cout3 = "0";
				$Cout4 = "Harap lengkapi form permohonan survey anda";
				$Cout = "{}";
				$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
				echo $Cout;				
		}
	}
?>
