<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");
	//include '../conf/konekCare.php';
	//include '../conf/konek.php';
$data=json_decode(file_get_contents("php://input"));
ini_set('memory_limit', '-1');
if(!isset($_SESSION)){
	session_start();
}
	//================================================
	//$auth_key=$_REQUEST['auth_key'];//$data->auth_key;//"b9876c0dbcccf24ec7498d24ba1fee3a";
	$id_policy=$_REQUEST['policy_id'];//$data->policy_id;//tambahan di App untuk menampilkan datanya melalui param di App
	$ceksesi=$_SESSION['banget'];

	$auth_key=$data->id;
	//================================================
	$Cass_survey_request = new Cass_survey_request;
	$Cass_MstUser = new Cass_UserPanfic;
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
	$shield=new shield;

	$nomor=$Cass_survey_request->autonum();
	$Cass_MstUser->select("where auth_key_shield='$auth_key'");

	$Cass_MstDataUser->select("where ID='$id_policy'");
	$pecah=$Cass_MstUser->tampil();
	$pecahDataUser=$Cass_MstDataUser->tampil();	
	//================================================
	$user_id=$pecah['user_id'];
	$branch_id=$data->branch_id;//$_REQUEST['branch_id'];
	$policy_no=$data->policy_number;
	$certificateno=$data->certificateno;//penambahan data sertifikat untuk proses PLA
	$location_address=$data->location_address;
	$location_detail=$data->location_detail;	
	$timestamp=$data->survey_date;//$_REQUEST['timestamp'];
	$date_of_loss=$data->date_of_loss;
	$time_of_loss=$data->time_of_loss;
	$loss_location=$data->location_of_loss;
	$cause_of_loss=$data->cause_of_loss_id;
	$notes=$data->notes;
	$survey_date=$data->survey_date;
	$survey_time=$data->survey_time;
	$names=$data->name;
	$ano=$data->ano;
	$license_number=$data->license_number;
	$report_from=$data->report_from;
	$subject=$data->subject;
	$workshop=$data->workshop;
	$mobile_no=$data->mobile;
	$report_date=$data->report_date;//date('Y-m-d H:i:s');//
	$report_time=$data->report_time;//date('H:i:s');//
	if($user_id==''){
			$Cout3 = "0";
			$Cout4 = "Sesion telah habis, silahkan login terlebih dahulu untuk dapat melanjutkan proses ini";
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'"}';
			echo $Cout;	
	}else{
		if($policy_no !='')
		{
			$cekData=$Cass_survey_request->select_shield("where policy_no='$policy_no' and certificateno='$certificateno' and date_of_loss='$date_of_loss' and status_claim='1' and claimno is null");
			$hasilcek=$Cass_survey_request->tampil_row();
			$cekRegis1=$Cass_survey_request->tampil();
			$idCek = $cekRegis1['ID'];
			if ($hasilcek==1)
			{

				$Cout3 = "1";					
				$Cout = "{}";
				$Cout4="Permohonan claim sudah pernah di daftarkan tapi gagal dapat no Claim, Silahkan klik simpan lagi.. ";
				$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'"}';

				$data_ubahan = array('status_internal' =>$hasil ,'status_claim'=>'2','claimno'=>'-' );//new code
				$Cass_survey_request->ubah_shield($data_ubahan,"where ID='$idCek'");//new code

				echo $Cout;	

			}else{
				$Cass_survey_request->select_shield("where policy_no='$policy_no' and certificateno='$certificateno' and date_of_loss='$date_of_loss' and status_claim='1' and claimno is not null and claimno <>'-' order by ID desc");
				$cekRegis=$Cass_survey_request->tampil();
				$no_claim=$cekRegis['claimno'];
				if($no_claim !=''){
					$Cout3 = "1";					
					$Cout = "{}";
					$Cout4="Permohonan claim sudah pernah di daftarkan dengan no Claim : ".$no_claim." coba cek di CARE ya.." ;
					$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'"}';
					echo $Cout;	
				}else{
				//--------
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
					'estimator'=>$report_date,
					'surveyor'=>"-",
					'status_internal'=>"",
					'workshop'=>$workshop,
					'auth_key'=>$auth_key,
					'names'=>$names,
					'license_number'=>$license_number,
					'report_from'=>$report_from,
					'subject'=>$subject,
					'ano'=>$ano,
					'mobile_no'=>$mobile_no,
					'res_survey_date'=>$report_date,
					'res_survey_time'=>$report_time
				);
				$simpan=$Cass_survey_request->simpan_shield($isinya);

				//========================================update atau simpan nilai Deductible ke table mst_profile_Care======
					$acceptance->select("where POLICYNO='$policy_no' and CERTIFICATENO='$certificateno' order by ANO desc");
					$tampilAccp=$acceptance->tampil();					
					$claimant=$tampilAccp['AID'];
					$aName=$tampilAccp['AName'];

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
											'PHONE'=>$license_number,
											'DEDUCTIBLE'=>$tampilDeduc['FIXEDMIN']
											);
						$ProfileCare->simpan($insertProfile);
					}else
					{
						$updateProfile = array('ID'=>$claimant,
											'POLICYNO'=>$policy_no,
											'CERTIFICATENO'=>$certificateno,
											'NAME'=>$aName,
											'ADDRESS'=>"",
											'PHONE'=>$license_number,
											'DEDUCTIBLE'=>$tampilDeduc['FIXEDMIN']);
						$ProfileCare->ubah($updateProfile,"where POLICYNO='$policy_no' and CERTIFICATENO='$certificateno'");
					}
					//===================================
				
				if($simpan=='0')
				{
					$Cout4 = "Permohonan survey gagal";
				}else
				{
					$Cass_survey_request->select_shield("where user_id='$user_id' order by ID desc");
					$viewId=$Cass_survey_request->tampil();
					$idnya=$viewId['ID'];

					$Cout4 = "Data tersimpan ".$idnya;
					
					$Cass_survey_request->select_shield("where (ID= $idnya - 1) and  claimno is null and status_claim ='1' order by ID desc");//new code
					$datanya=$Cass_survey_request->tampil_row();//new code
					if($datanya == 0){//new code
						//sleep(2);//delay code 5 detik
						//$client=new SoapClient("http://192.168.0.99/shieldservice/service/casandra_service.asmx?WSDL");//di bunuh dulu 13-12-2019 karena Claim sedang di tutup
					    $result=$client->Register_shield(array('id'=>$idnya));
					    $result->Register_shieldResult->Register_shieldResult;		    
					    $hasil=$result->Register_shieldResult;
					    //=============================================================================================
					    $data=substr($hasil,0,1);//ambil karakter pertama 
					    $hasil=substr($hasil,1);//kaga ambil karakter pertama
					    $simpan=$data;
					    //=========code tambahan fungsinya buat simpen history claim dari awal di daftarkan================
					    $noclaimnya=substr($hasil,-14);
					    $data_history = array('tgl' => date('Y-m-d H:i:s'),'claimno'=>$noclaimnya,'status'=>$simpan,'remarks'=>'Claim terdaftar','user_update'=>$user_id);
					    $shield->simpan_history_claim($data_history);
					    //=============update refdate di care================================
					    $dataCare = array('RefDate' =>$report_date,'RefTime'=>$report_time );
						$query=$shield->update_ref_claim($dataCare,"where ClaimNo='$noclaimnya'");
					    //======================================
					}else{//new code
						$data="1";//new code
						$hasil="Sistem register sedang sibuk (ada proses Register no Claim), silahkan coba beberapa saat lagi (30 detik lagi) Agar no Claim tidak tertukar";//new code
						$data_ubahan = array('status_internal' =>$hasil ,'status_claim'=>'2','claimno'=>'-' );//new code
						$Cass_survey_request->ubah_shield($data_ubahan,"where ID='$idnya'");//new code
						$simpan="0";
					}
				    $Cout4 = $hasil;
				}
				$Cout3 = $simpan;					
				$Cout = "{}";
				$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'"}';
				echo $Cout;	
				//---------
				}
			}			
		}
		else
		{
			$Cout3 = "0";
			$Cout4 = "Harap lengkapi form permohonan survey anda";
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'"}';
			echo $Cout;			
		}		
	}
	?>
