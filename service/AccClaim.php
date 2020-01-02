<?php
include '../service/MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
	$request_id=$_REQUEST['request_id'];
	
	$authKey=$_REQUEST['auth_key'];
	//$workshop=$_REQUEST['workshop_id'];
	//$OR=$_REQUEST['own_risk'];
	//======================================================================
	$userPanfic=new Cass_UserPanfic;
	$Cass_pickUp_survey=new Cass_pickUp_survey;
	$menuPreviledge=new MST_MENU_PRIVILEDGE;
	$notification=new Cass_notification;
	$Survey_request=new Cass_survey_request;
	$Cass_Gcm=new Cass_Gcm;
	$SendNotif=new PushNotif; 
	$sendMail= new Mailer;
	$MST_BENGKEL= new MST_BENGKEL;
	$Cass_MstUser=new Cass_MstUser;
	$JoinTable=new JoinTable;

	$JoinTable->selectAccClaim("where a.survey_id='$request_id'");
	$tampilRequest=$JoinTable->tampil();
	$ClaimNo=$tampilRequest['claimno'];
	$statusInter=$tampilRequest['status_internal'];
	$userID=$tampilRequest['user_id'];
	$nama_bengkel=$tampilRequest['nama_bengkel'];
	$alamat_bengkel=$tampilRequest['alamat'];
	$mail=$tampilRequest['mail'];
	
	$Cass_Gcm->select("where user_id='$userID'");
		$ids = array();
		while($viewApikey=$Cass_Gcm->tampil())
		{
			if($Apikey !=""){$Apikey .=",";}
			array_push($ids, "".$viewApikey['device_id']."");
		}
	
			//===========ini ws yang akses ke ws CARE
			/*$client=new SoapClient("http://192.168.0.99/shieldservice/service/casandra_service.asmx?WSDL");
		    $result=$client->SendSpk(array('id'=>$request_id));
		    $result->SendSpkResult->SendSpkResult;
		    
		    $hasil=$result->SendSpkResult;*/
		    $tgl=date('d M Y');//tgl terbentuk SPK
		    $newdate = date('d M Y', strtotime('+21 days', strtotime($tgl)));//tanggal akhir SPK
		    $kirimMail=$sendMail->SendMailCustomer($mail,$request_id,$tgl,$newdate,$nama_bengkel,$alamat_bengkel,$ClaimNo);
		    if($kirimMail=='1')
		    {
		    	$pesan="Detail SPK telah di kirim ke e-mail anda ".$mail;
		    }else
		    {
		    	$pesan="Kirim e-mail gagal";
		    }
		    $updatenya = array('read_status' =>"2");//update sa
		    $notification->ubah($updatenya,"where content_id='$request_id' and notification_type='3'");

		    $isinotif = array('user_id' =>$tampilRequest['user_id'] ,
				'notification_type'=>"1",//jenis notifikasi kasih rating
				'rating_type'=>"1",
				'content_id'=>$tampilRequest['survey_id'],
				'content_name'=>$surveyor,
				'create_date'=>date("Y-m-d H:i:s"),
				'read_status'=>"1");
			
				$notification->select("where  content_id='$request_id' and notification_type='1'");
				$tampilNotif=$notification->tampil();
				$notifnya=$tampilNotif['content_id'];
				if($notifnya=='')
				{
					$notification->simpan($isinotif);//menampilkan data untuk ke notifikasi	Rating user
					$AccDate = array('acc_date' =>date("Y-m-d H:i:s"));					
					$Survey_request->ubah($AccDate,"where survey_id='$request_id'");
					$SendNotif->sendPushNotification("Silahkan berikan rating pada Agent kami", $ids);
				}				
		    //=============================================================================================
		    $data= $kirimMail;//substr($hasil,0,1);//ambil karakter pertama
			$msg = $pesan;//substr($hasil,1);
			$Cout3 = $data;//$query;
			//$Cout4 = "Invalid AUTH key";
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$msg.'","data":'.$Cout.'}';
			echo $Cout;
?>
