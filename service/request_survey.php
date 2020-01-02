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
	$acceptance=new ACCEPTANCE;
	$rcover= new RCOVER;
	$accded= new ACCDED;
 	$SendNotif=new PushNotif; 
	$sms=new Sms;
	$Cass_Gcm=new Cass_Gcm;
	$ProfileCare=new MST_PROFILE_CARE;

	$nomor=$Cass_survey_request->autonum();
	$Cass_MstUser->select("where token_id='$auth_key'");
	$Cass_MstDataUser->select("where ID='$id_policy'");
	$pecah=$Cass_MstUser->tampil();
	$pecahDataUser=$Cass_MstDataUser->tampil();	
	//================================================
	$user_id=$pecah['userid'];
	$branch_id=$_REQUEST['branch_id'];
	$policy_no=$_REQUEST['policy_number'];
	$certificateno=$pecahDataUser['certificateno'];//penambahan data sertifikat untuk proses PLA
	$location_address=$_REQUEST['location_address'];
	$location_detail=$_REQUEST['location_detail'];
	$location_lat=$_REQUEST['location_lat'];
	$location_lon=$_REQUEST['location_lon'];
	$timestamp=$_REQUEST['survey_date'];//$_REQUEST['timestamp'];
	$date_of_loss=$_REQUEST['date_of_loss'];
	$time_of_loss=$_REQUEST['time_of_loss'];
	$loss_location=$_REQUEST['location_of_loss'];
	$cause_of_loss=$_REQUEST['cause_of_loss_id'];
	$notes=$_REQUEST['notes'];
	$survey_date=$_REQUEST['survey_date'];
	$survey_time=$_REQUEST['survey_time'];
	$Cass_survey_request->select("where user_id='$user_id' and status_claim='1' and request_type='1' and policy_no='$policy_no' and certificateno='$certificateno'");
	$tampilSurvey=$Cass_survey_request->tampil();
	$userSurvey=$tampilSurvey['user_id'];
	//================================================
	$menuPreviledge->select("where branch='$branch_id' and estimator ='Y'");
	$tampilEstimator=$menuPreviledge->tampil();
	$estimator=$tampilEstimator['ID'];
	//========Cari GCM estimator======================================================
		$Cass_Gcm->gcm_internal("where branch='$branch_id' and estimator ='Y'");
		$ids = array();
		while($viewApikey=$Cass_Gcm->tampil())
		{
			if($Apikey !=""){$Apikey .=",";}	
			//$Apikey .="'".$viewApikey['device_id']."'";
			array_push($ids, "".$viewApikey['device_id']."");
		}		
		//======== isi push notif buat customer ===========================
		$Cass_Gcm->select("where user_id='$user_id'");
		$idC= array();
		while($viewApikey2=$Cass_Gcm->tampil())
		{
			if($Apikey2 !=""){$Apikey2 .=",";}	
			//$Apikey .="'".$viewApikey['device_id']."'";
			array_push($idC, "".$viewApikey2['device_id']."");
		}		

	//=====================================================================	
	$isinotif = array(
		'user_id'=>$user_id,//yang request
		'notification_type'=>"3",//konfirmasi ke estimator
		'rating_type'=>"",
		'content_id'=>$estimator,//notif tujuan
		'content_name'=>"",
		'create_date'=>date('Y-m-d H:i:s'),
		'read_status'=>'1'
	);
	$acceptance->select("where POLICYNO='$policy_no' and CERTIFICATENO='$certificateno' order by ANO desc");
	$tampilAccp=$acceptance->tampil();
	$ano=$tampilAccp['ANO'];
	$claimant=$tampilAccp['AID'];
	$aName=$tampilAccp['AName'];
	$rcover->select("where ANO='$ano' and CODE in('KBM-01','CMP-01','CMP-13','SKBM-01','CMP-15','CMP-16','CMP-14','CMP-17','CMP-18') and SDATE <= '$date_of_loss' and EDATE >= '$date_of_loss'");
	$tampilRcover=$rcover->tampil_row();
	//$isiRcover=$tampilRcover['ANO'];

	if ($tampilRcover=='')
	{
			$Cout3 = "0";
			$Cout4 = "Anda tidak memiliki Coverage Comprehensive untuk tanggal kejadian ini.";
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;
	}elseif($user_id=='')//update barunya..
	{	
			$Cout3 = "0";
			$Cout4 = "Sesi anda telah habis silahkan logout dan login kembali.";
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;
	}
	elseif($time_of_loss=='')
	{
			$Cout3 = "0";
			$Cout4 = "Silahkan Masukan Jam kejadian.";
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;
	}
	elseif($date_of_loss=='')
	{
			$Cout3 = "0";
			$Cout4 = "Silahkan Masukan Tanggal kejadian.";
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;
	}
	else
	{
		if($userSurvey !='')
		{			
			$Cout3 = "0";
			$Cout4 = "Nomor polis ini sudah pernah di daftarkan silahkan lihat di menu History";			
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;
		}else
		{				
			if($policy_no !='' && $branch_id !='' && $location_address !='' && $cause_of_loss !='' && $survey_date !='' && $survey_time !='')
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
					'time_of_loss'=>$time_of_loss,
					'loss_location'=>$loss_location,
					'cause_of_loss'=>$cause_of_loss,
					'notes'=>$notes,
					'survey_date'=>$survey_date,
					'survey_time'=>$survey_time,
					'status'=>"Pending",
					'request_type'=>"1",
					'status_claim'=>"1",
					'estimator'=>"",
					'surveyor'=>"-",
					'status_internal'=>"",
					'workshop'=>"",
					'auth_key'=>$auth_key
				);
					$simpan=$Cass_survey_request->simpan($isinya);
					//========================================update atau simpan nilai Deductible======
					$accded->select("where ano='$ano' and (REMARKS like '%Kerugian Sebagian%' or REMARKS like '%Partial Loss%' or REMARKS like '%Comprehensive%' or REMARKS like '%Kerugian Lain%' )  and REMARKS not like'%komersil%' and REMARKS not like '%penipuan%' and REMARKS not like '%Penggelapan%'");
					$tampilDeduc=$accded->tampil();

					$ProfileCare->select("where POLICYNO='$policy_no' and CERTIFICATENO='$certificateno'");
					$dataProfile=$ProfileCare->tampil_row();
					if($dataProfile==0)
					{
						$insertProfile = array('ID'=>$claimant,
											'POLICYNO'=>$policy_no,
											'CERTIFICATENO'=>$certificateno,
											'NAME'=>$aName,
											'ADDRESS'=>"",
											'PHONE'=>"",
											'DEDUCTIBLE'=>$tampilDeduc['FIXEDMIN']
											);
						$ProfileCare->simpan($insertProfile);
					}else
					{
						$updateProfile = array('DEDUCTIBLE'=>$tampilDeduc['FIXEDMIN']);
						$ProfileCare->ubah($updateProfile,"where POLICYNO='$policy_no' and CERTIFICATENO='$certificateno'");
					}
					//===================================
					
					if($simpan=='0')
					{
						$Cout4 = "Permohonan survey gagal";
					}else
					{
						$rcover->select("where ANO='$ano' and CODE='KBM-17'");
						$barisan=$rcover->tampil_row();
						if($barisan=='0')
						{
							$otoriz="di bengkel Non Authorized";
						}else
						{
							$otoriz="";
						}
						$Cout4 = "Permohonan anda akan segera kami proses. pada jam kerja ";
						$notifID=$SendNotif->sendPushNotificationEsti("Ada Permohonan survey", $ids);
						$SendNotif->sendPushNotificationFCM("Ada Permohonan survey", $ids);
						$notif_sendiri=$SendNotif->sendPushNotification("Survey akan di proses pada jam kerja",$idC);

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
	}	
?>
