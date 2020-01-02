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
	$branch_id=$_REQUEST['branch_id'];
	$policy_no="";
	$certificateno="";//penambahan data sertifikat untuk proses PLA
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

	$Cass_survey_request->select("where user_id='$user_id' and status_claim='1' and request_type='3'");
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
		$Cass_Gcm->gcm_internal("where branch='$branch_id' and estimator ='Y'");
		$ids = array();
		while($viewApikey=$Cass_Gcm->tampil())
		{
			if($Apikey !=""){$Apikey .=",";}	
			//$Apikey .="'".$viewApikey['device_id']."'";
			array_push($ids, "".$viewApikey['device_id']."");
		}

	if($userSurvey !='')
	{
				/*$pesan="Anda masih memiliki permohonan Road Assistance yang belum selesai";
				$Cout='{"data":[{"msg":"'.$pesan.'"}]}';
				echo ($Cout);*/
					$Cout3 = "0";
					$Cout4 = "Anda masih memiliki permohonan Road Assistance yang belum selesai";
					$Cout = "{}";
					$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
					echo $Cout;		
	}else
	{				
		if($location_address !='' && $cause_of_loss !='')
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
					'request_type'=>"3",
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
						$notifID=$SendNotif->sendPushNotification("Ada Permohonan survey", $ids);
					}
					$Cout3 = $simpan;					
					$Cout = "{}";
					$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
					echo $Cout;
				//$notif->simpan($isinotif);//dimatiin dulu buat info ke estimator
		}else
		{
				/*$pesan="Harap lengkapi form permohonan survey anda";
				$Cout='{"data":[{"msg":"'.$pesan.'"}]}';
				echo ($Cout);	*/
				$Cout3 = "0";
				$Cout4 = "Harap lengkapi form permohonan survey anda";
				$Cout = "{}";
				$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
				echo $Cout;			
		}
	}

	//echo ($userSurvey);
	
?>
