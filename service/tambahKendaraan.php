<?php
	include 'MainFrame.php';
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	//include '../conf/konekCare.php';
	//include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	ini_set('memory_limit', '-1');
	// $auth_key =$data->auth_key;
	// $policyno =$data->policy_number;
	// $norangka =$data->frame_number;	
	
	$auth_key =$_REQUEST['auth_key'];//"1a1dfc19396ba8ce1e687880e4cc89de";
	$policyno =$_REQUEST['policy_number'];//"06022314080037";
	$norangka =$_REQUEST['frame_number'];//"MHYHMP31SFJ123310";

	//================================================
	$mstUser=new Cass_MstUser;
	$Cass_MstDataUser= new Cass_MstDataUser;
	$acceptance=new ACCEPTANCE;
	$ainfo=new Ainfo;
	$Rcover=new RCOVER;
	
	$dAte=date('Y-m-d');

	$mstUser->select("where token_id = '$auth_key'");
	$tampilUser = $mstUser->tampil();
	$usernya=$tampilUser['userid'];

	$jml_polis=strlen($policyno);//ngitung jumlah nomor polis
	
	$Cass_MstDataUser->select("where chasis_number='$norangka'");//dek rangka udah di pernah di daftarin belon
	$tampilDataUser = $Cass_MstDataUser->tampil();
	$acceptance->select("where VALUEDESC like'%$norangka%' order by ANO desc");
	$pecahAccp=$acceptance->tampil();

	$cekacceptance=	$pecahAccp['ANO'];
	$cekRangkaTerdaftar=$tampilDataUser['chasis_number'];
	$toc=substr($pecahAccp['POLICYNO'],2,4);//cari TOC
	$ano=$pecahAccp['ANO'];
	$detailVehicle = $ainfo->detailvehicle($ano,$toc );
	//================================================
	if($auth_key=='')
	{
			$Cout3 = "0";
			$Cout4 = "Invalid AUTH key";//auth key ga sesuai
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;
	}
	elseif($usernya=='')
	{
			$Cout3 = "0";
			$Cout4 = "Invalid AUTH key";//user ga ada
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;
	}
	elseif($jml_polis < 15)
	{
			$Cout3 = "0";
			$Cout4 = "Invalid Data";//nomor polis kurang dari 15 digit
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;
	}
	elseif($cekacceptance=='')
	{
			$Cout3 = "0";
			$Cout4 = "No Rangka anda tidak di temukan pada sistem kami";
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;
	}elseif($cekRangkaTerdaftar !='')
	{//cek no rangka kalo ada atau ga di care
			$Cout3 = "0";
			$Cout4 = "Nomor Rangka anda telah terdaftar";
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;
	}
	else
	{
		$Rcover->select("where ANO='$ano' and SDATE <= '$dAte' and EDATE >= '$dAte' and CATEGORY='M'");
		$TampilCover=$Rcover->tampil();
		$Rcoverage=$TampilCover["REMARK"];//coverage saat terdaftar
		if($Rcoverage=='')
		{
			$Rcoverage="No Coverage";
		}else
		{
			$Rcover->select("where ANO='$ano' and CODE='KBM-17'");
			$barisan=$Rcover->tampil_row();
			if($barisan=='0')
			{
				$otoriz="(Non Authorized)";
			}else
			{
				$otoriz="(Authorized)";
			}
		}
		$coverage=$Rcoverage ." ". $otoriz;

		$datadetail = array(
			'userid'=>$tampilUser['userid'],
			'policyno'=>$pecahAccp['POLICYNO'],
			'certificateno'=>$pecahAccp['CERTIFICATENO'],
			'claimant'=>$pecahAccp['AName'],
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
		if($policyno=='' and $norangka=='')
		{
			$Cout3 = "0";
			$Cout4 = "Tambah Polis Gagal";
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			//$Cout='{"data":{"msg":"Tambah Polis Gagal"}}';
			echo $Cout;
		}else
		{
			$Cass_MstDataUser->select("where chasis_number='$norangka'");
			$row=$Cass_MstDataUser->tampil_row();
			if ($row=='0'){
				$query =$Cass_MstDataUser->simpan($datadetail);//insert data kendaraan user
			}else
			{
				$query ="1";
			}
			
			$Cass_MstDataUser->select("where chasis_number='$norangka'");
			while($pecah2=$Cass_MstDataUser->tampil()){
			if($Cout2 !=""){$Cout2 .=",";}		
			$Cout2 .='{"id":"'.$pecah2["ID"].'",';
			$Cout2 .='"policy_number":"'.$pecah2["policyno"].'",';	
			$Cout2 .='"policy_type":"'.$pecah2["coverage"].'",';	
			$Cout2 .='"car_type":"'.$pecah2["vehicle_brand"]." ".$pecah2["vehicle_model"].'",';	
			$Cout2 .='"car_number":"'.$pecah2["license_no"].'",';	
			$Cout2 .='"owner_name":"'.$pecah2["claimant"].'",';
			$Cout2 .='"frame_number":"'.$pecah2["chasis_number"].'",';
			$Cout2 .='"certificate":"'.$pecah2["certificateno"].'",';
			$Cout2 .='"register_timestamp":"'.$pecah2["start_date"].'",';
			$Cout2 .='"expired_timestamp":"'.$pecah2["end_date"].'"}';			
			}
			$Cout3 = $query;
			if ($query=='0')
			{
				$Cout4 = "Tambah kendaraan gagal";
			}else
			{
				$Cout4 = "Tambah kendaraan baru berhasil";
			}
			
			//$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout2.'}';
			echo $Cout;
		}
	}
?>
