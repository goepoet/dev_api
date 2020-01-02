<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	//include '../conf/konekCare.php';
	//include '../conf/konek.php';
$data=json_decode(file_get_contents("php://input"));
ini_set('memory_limit', '-1');

	//$id=mysql_real_escape_string($data->email);
$Api_key=$_REQUEST['api_key'];
	$email=$_REQUEST['email'];//$data->email;//dari data yang dilempar apps
	$phone=$_REQUEST['phone_number'];//$data->phone_number;//dari data yang dilempar apps
	$norangka=$_REQUEST['frame_number'];//$data->frame_number//dari data yang dilempar apps
	/*$Api_key=$data->api_key;
	$email=$data->email;//dari data yang dilempar apps
	$phone=$data->phone_number;//dari data yang dilempar apps
	$norangka=$data->frame_number;//dari data yang dilempar apps*/
	//================================================
	$awalnnya=substr($phone,0,1);//ambil karakter pertama
	$Noawal="62";//no awal
	$NoAkhir=substr($phone,1);//setelah no awal
	if ($awalnnya=='0'){
		$phone=$Noawal.$NoAkhir;//gabungkan
	}
	

	$MstProfileCare=new MST_PROFILE_CARE;
	$acceptance=new ACCEPTANCE;
	$accded= new ACCDED;
	$Rcover=new RCOVER;
	$cass_MstUser= new Cass_MstUser;
	$ainfo=new Ainfo;
	$Cass_MstDataUser= new Cass_MstDataUser;
	$cass_MstUser->select("where mail='$email'");//cek user terdaftar
	$pecahMstuser=$cass_MstUser->tampil();
	$Cass_MstDataUser->select("where chasis_number='$norangka'");//dek rangka udah di pernah di daftarin belon
	$pecahMstDataUser=$Cass_MstDataUser->tampil();  
	$sms=new Sms;
	$mail=new Mailer;
	$dAte=date('Y-m-d');
	
	$cekUser=$pecahMstuser['mail'];
	
	$cekRangkaTerdaftar=$pecahMstDataUser['chasis_number'];
	$acceptance->Select("where VALUEDESC like'%$norangka%' order by ANO desc");
	$pecahAccp=$acceptance->tampil();
	$cek=$pecahAccp['ANO'];
	$Aid=$pecahAccp['AID'];
	$Aname=$pecahAccp['AName'];
	
	if($cekUser !=''){
		
		$Cout3 = "0";
		$Cout4 = "Alamat e-mail anda telah terdaftar";
		$Cout = "{}";
		$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
		echo $Cout;
		

	}
	elseif($cek==''){//cek no rangka kalo ada atau ga di care
		
		$Cout3 = "0";
		$Cout4 = "No Rangka anda tidak di temukan pada sistem kami".$cek;
		$Cout = "{}";
		$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
		echo $Cout;
	}
	elseif($cekRangkaTerdaftar !='')
	{
		
		$Cout3 = "0";
		$Cout4 = "Nomor Rangka anda telah terdaftar";
		$Cout = "{}";
		$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
		echo $Cout;
	}
	else
	{
		
		$Rcover->select("where ANO='$cek' and SDATE <= '$dAte' and EDATE >= '$dAte' and CATEGORY='M'");
		$TampilCover=$Rcover->tampil();
		$Rcoverage=$TampilCover["REMARK"];//coverage saat terdaftar
		if($Rcoverage=='')
		{
			$Rcoverage="No Coverage";
		}else{
			$Rcover->select("where ANO='$cek' and CODE='KBM-17'");
			$TampilCover=$Rcover->tampil_row();
			if($TampilCover=='0')
			{
				$otoriz="(Non Authorized)";
			}else
			{
				$otoriz="(Authorized)";
			}
		}
		$coverage=$Rcoverage ." ". $otoriz;
		//=================================================
		$accded->select("where ANO='$cek' and (REMARKS like '%Kerugian Sebagian%' or REMARKS like '%Partial Loss%' or REMARKS like '%Comprehensive%')");
		$tampilOR=$accded->tampil();
		$nilaiOR=$tampilOR['FIXEDMIN'];//nilai OR dari care
		//================================================
		$u1=$pecahAccp['ANO'];//nilai ano
		$u2=substr($norangka,3,2);//no rangka
		$u3=$cass_MstUser->autonum();//autonumber
		$u4=substr($pecahAccp['ANO'],3,2);//ano juga
		$u5=substr($pecahAccp['POLICYNO'],3,2);//ano juga
		$toc=substr($pecahAccp['POLICYNO'],2,4);//cari TOC
		$userId=$u1.$u2.$u3;
		$password=$u3.$u5.$u4;
		$policyno=$pecahAccp['POLICYNO'];
		$certificate=$pecahAccp['CERTIFICATENO'];
		$name=$pecahAccp['AName'];
		$datenya=date("Y-m-d H:i:s");
		$token=md5($userid.$datenya);
		//================================================
		$detailVehicle = $ainfo->detailvehicle($pecahAccp['ANO'],$toc );
		$tokenId="";	
		$datauser = array(
			'userid'=>$userId,
			'password'=>$password,
			'name'=>"Owner name",
			'mail'=>$email,
			'phone'=>$phone,
			'api_key'=>$Api_key,
			'reg_date'=>date("Y-m-d"),
			'token_id'=>$token//'11'
		);
		$datadetail = array(
			'userid'=>$userId,
			'policyno'=>$policyno,
			'certificateno'=>$certificate,
			'claimant'=>$name,
			'license_no'=>$detailVehicle['License_number'],
			'vehicle_brand'=>$detailVehicle['Brand'],
			'vehicle_type'=>$detailVehicle['Vehicle_type'],
			'vehicle_model'=>$detailVehicle['Vehicle_model'],
			'color'=>$detailVehicle['Color'],
			'year'=>$detailVehicle['Year'],
			'chasis_number'=>$detailVehicle['Chasis_number'],
			'machine_number'=>$detailVehicle['Machine_number'],
			'coverage'=>$coverage,
			'start_date'=>$pecahAccp['SDATE'],
			'end_date'=>$pecahAccp['EDATE']
		);
		$isiProfileCare = array('ID' =>$Aid ,'POLICYNO'=>$policyno,'CERTIFICATENO'=>$certificate,'NAME'=>$Aname,'ADDRESS'=>"-",'PHONE'=>"",'DEDUCTIBLE'=>$nilaiOR);

		if($phone !='')
		{
			$cass_MstUser->select("where userid='$userId'");
			$DaUser=$cass_MstUser->tampil_row();
			if($DaUser =='0')
			{
				$query=$cass_MstUser->register($datauser);//insert user id buat login
				$Cass_MstDataUser->simpan($datadetail);//insert data kendaraan user
				$MstProfileCare->select("where POLICYNO='$policyno' and CERTIFICATENO='$certificate'");
				$jmlData=$MstProfileCare->tampil_row();
				if($jmlData=='0')
				{
					$MstProfileCare->simpan($isiProfileCare);//masukin nilai OR nya.
				}else
				{
					$update = array('DEDUCTIBLE'=>$nilaiOR);
					$MstProfileCare->ubah($update,"where POLICYNO='$policyno' and CERTIFICATENO='$certificate'");
				}				
			}
			$sms->sendSms($phone,"Anda telah terdaftar dalam Casandra Apps. User ID anda : ".$email." Password anda : ".$password);
			$mail->SendMailRegister($email,$email,$password);
			//mail($to,$subject,$txt,$headers);
			$Cout3 = $query;
			if($query=='1'){
				$Cout4 = "User ID dan Password anda akan dikirimkan melalui SMS & Email sesaat lagi";
			}else{
				$Cout4 = "Register data gagal";
			}
			
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;
		}else
		{
			/*$Cout .='{"msg":"Register Failed"}';
			echo $Cout='{"data":'.$Cout.'}';*/
			$Cout3 = "0";
			$Cout4 = "Register Failed";
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;
		}
	}
	
	?>
