<?php // fungsi ini buat cetak polis yang pake parameter no polis
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

	//include '../conf/konekCare.php';
	//include '../conf/konek.php';
$data=json_decode(file_get_contents("php://input"));
ini_set('memory_limit', '-1');

	//$id=mysql_real_escape_string($data->email);
	//$nopol=$_REQUEST['policy_no'];
	//$certificateno=$_REQUEST['certificateno'];//$data->email;//dari data yang dilempar apps
$polis=$_REQUEST['policyno'];
$sertifikat=$_REQUEST['certificateno'];

if($polis=="")
{
	$polis=$data->policyno;
	$sertifikat=$data->certificateno;
}

$MstProfileCare=new PROFILE;
$acceptance=new ACCEPTANCE;
$accded= new ACCDED;
$Rcover=new RCOVER;
$cass_MstUser= new Cass_MstUser;
$ainfo=new Ainfo;
$profil=new PROFILE;
$acccla=new ACCCLA;
$Cass_MstDataUser= new Cass_MstDataUser;
$icover=new ICOVER;	
$sms=new Sms;
$mail=new Mailer;
$rcover2=new RCOVER;
$rcover3=new RCOVER;
$pclass=new PCLASS;
$surveyor=new SURVEYOR;
$rtf=new RTF;
$pembayaran=new GETPembayaran;
$accbs=new ACCBS;
$dAte=date('Y-m-d');
$Cout="";


$nopol_cert=$polis."-".$sertifikat;
if($sertifikat==''){
	$nopol_cert=$polis;
}
/*$cass_MstUser->select("where token_id='$auth_key'");
$datanya=$cass_MstUser->tampil_row();
$idnya=$cass_MstUser->tampil();
$puser=$idnya['userid'];
if($datanya=='0')//cek login
{
	$Cout=$Cout .='{"msg":"Silahkan Login terlebih dahulu"}';
}
else
{*/
	/*$Cass_MstDataUser->select("where chasis_number='$norangka'");
	$kendaraan=$Cass_MstDataUser->tampil_row();
	if($kendaraan=='0'){
		$Cout=$Cout .='{"msg":"no rangka ini tidak terdaftar pada id anda"}';
	}else{*/

		//$acceptance->select("where VALUEDESC like'%$norangka%'");
		$pembayaran->GetBayar("where A_PolicyNo='$nopol_cert' and subject='Premium' and Type='DI' ");
		$pecahBayar=$pembayaran->tampil();
		$payment=$pecahBayar['Payment_CC'];
		$premi=$pecahBayar['Nominal'];
		$outstanding=$premi-$payment;
		$pdate=$pecahBayar['PDATE'];

		$acceptance->select("where POLICYNO='$polis' and CERTIFICATENO='$sertifikat' and ASTATUS='I'");
		$pecahAccp=$acceptance->tampil();
		$id=$pecahAccp['AID'];
		$ano=$pecahAccp['ANO'];
		$cno=$pecahAccp['CNO'];
		$transtype=$pecahAccp['ATYPE'];
		$renewal=$pecahAccp['RENEWAL'];
		$autolaps=$pecahAccp['REMARKS'];
		$Sourcenya=$pecahAccp['Source'];
		if($renewal=='0')
		{
			$renewal="Baru";
		}else
		{
			$renewal="Perpanjangan";
		}
		if ($transtype=="N")
		{
			$transtype="NEW";
		}elseif($transtype=="E"){
			$transtype="Endorsement";
		}elseif($transtype=="C")
		{
			$transtype="Cancellation";
		}

		$MstProfileCare->select("where id='$Sourcenya'");
		$tampilProfil=$MstProfileCare->tampil();

		$accbs->select("where ano='$ano'");
		$tampilAccbs=$accbs->tampil();

		$icover->select("where ano='$ano' and TOI='M09'");
		$tampilCover=$icover->tampil();

		// $rcover3->select("where ANO='$ano' and CODE in('KBM-01','CMP-01','CMP-13','SKBM-01','CMP-15','CMP-16','CMP-14','CMP-17','CMP-18') and SDATE <= 'date()' and EDATE >= 'date()'");
		// $tampilrcover3=$rcover3->tampil();

	$toc=substr($pecahAccp['POLICYNO'],2,4);//cari TOC
	$detailVehicle = $ainfo->detailvehicle($pecahAccp['ANO'],$toc );//ambil detail kendaan
	$profil->select("where id='$id'");
	$pecahprofil=$profil->tampil();
	$Rcover->select("where ANO='$ano'");
	$accded->select("where ANO='$ano'");
	$acccla->select("where ANO='$ano' ");
	$rcover2->select("where ANO='$ano'");
	$surveyor->select("where CNO='$cno'");
	$tampil_catatan=$surveyor->tampil();
	if($Cout !=""){$Cout .=",";}	
	$Cout .='{"nama":"'.str_replace('\\', '', $rtf->Text($pecahAccp['AName'])).'",';	
	$Cout .='"policyno":"'.$pecahAccp['POLICYNO'].'",';
	$Cout .='"certificateno":"'.$pecahAccp['CERTIFICATENO'].'",';
	$Cout .='"no_polisi":"'.$detailVehicle['License_number'].'",';
	$Cout .='"ano":"'.$ano.'",';
	$Cout .='"status_polis":"'.$renewal.'",';
	$Cout .='"no_kontrak":"'.$pecahAccp['REFNO'].'",';
	$Cout .='"cabang":"'.$pecahAccp['Location'].'",';
	$Cout .='"alamat":"'.str_replace('\\', '', $rtf->Text($pecahprofil['Address_1'])).'",';
	$Cout .='"merk_mobil":"'.$detailVehicle['Brand'].'",';
	$Cout .='"tipe_mobil":"'.$detailVehicle['Vehicle_type'].'",';
	$Cout .='"model_mobil":"'.$detailVehicle['Vehicle_model'].'",';
	$Cout .='"warna":"'.$detailVehicle['Color'].'",';
	$Cout .='"tahun":"'.$detailVehicle['Year'].'",';
	$Cout .='"no_rangka":"'.$detailVehicle['Chasis_number'].'",';
	$Cout .='"no_mesin":"'.$detailVehicle['Machine_number'].'",';
	$Cout .='"bpkb":"'.$detailVehicle['Bpkb'].'",';
	$Cout .='"seat_capacity":"'.$detailVehicle['Capacity'].'",';
	$Cout .='"penggunaan":"'.$detailVehicle['Functionn'].'",';	
	$Cout .='"kondisi_kendaraan":"'.$detailVehicle['Condition'].'",';
	$Cout .='"lokasi_kendaraan":"'.$detailVehicle['Location'].'",';
	$Cout .='"wilayah_kendaraan":"'.$detailVehicle['Area'].'",';
	$Cout .='"tipe_transaksi":"'.$transtype.'",';
	$Cout .='"wilayah_kendaraan":"'.$detailVehicle['Area'].'",';
	$Cout .='"sob":"'.str_replace('\\', '', $rtf->Text($tampilProfil['Name'])).'",';	
	$Cout .='"fee":"'.str_replace('\\', '', $rtf->Text($tampilAccbs['Fee'])).'",';	
	$Cout .='"disc":"'.str_replace('\\', '', $rtf->Text($tampilAccbs['Discount'])).'",';	
	$Cout .='"autolaps":"'.str_replace('\\', '', $rtf->Text($autolaps)).'",';
	$Cout .='"premi":"'.number_format($premi).'",';
	$Cout .='"payment":"'.number_format($payment).'",';
	$Cout .='"tagihan":"'.number_format($outstanding).'",';
	$Cout .='"tsi":"'.number_format($tampilCover['SI']).'",';
	$Cout .='"towing_limit":"'.number_format($tampilCover['SI'] * (0.5/100)).'",';
	$Cout .='"tgl_bayar":"'.date("d F Y",strtotime($pdate)).'",';
	$Cout .='"catatan_surveyor":"'.str_replace('\\', '', $rtf->Text($tampil_catatan['REMARKS'])).'",';
	$Cout .='"perlengkapan_tambahan":"",';				
	$Cout .='"mulai_polis":"'.date("d F Y",strtotime($pecahAccp["SDATE"])).'",';		
	$Cout .='"akhir_polis":"'.date("d F Y",strtotime($pecahAccp["EDATE"])).'",';
	while($pecah2=$Rcover->tampil()){
		if($Cout2 !=""){$Cout2 .=",";}		
		$Cout2 .='{"tipe_pertanggungan":"'.str_replace('\\', '', $rtf->Text($pecah2["REMARK"])).'",';
		$Cout2 .='"tgl_awal":"'.date("d F Y",strtotime($pecah2["SDATE"])).'",';				
		$Cout2 .='"tgl_akhir":"'.date("d F Y",strtotime($pecah2["EDATE"])).'"}';			
	}
	$Cout .='"jenis_pertanggungan":['.$Cout2.'],';

	while($pecah3=$accded->tampil()){
		if($Cout3 !=""){$Cout3 .=",";}		
		$Cout3 .='{"risiko":"'.str_replace('\\', '', $rtf->Text($pecah3["REMARKS"])).'",';
		$Cout3 .='"tgl_awal":"'.date("d F Y",strtotime($pecah3["SDate"])).'",';	
		$Cout3 .='"tgl_akhir":"'.date("d F Y",strtotime($pecah3["EDate"])).'",';	
		$Cout3 .='"kode":"'.str_replace('\\', '', $rtf->Text($pecah3["DCODE"])).'"}';

	}
	$Cout .='"risiko_sendiri":['.$Cout3.'],';

	while($pecah4=$acccla->tampil()){
		if($Cout4 !=""){$Cout4 .=",";}
		//$test=str_replace('\\', '', "\%~}");
		$test=str_replace('\\', '', $rtf->Text($pecah4["Description_1"]));
		//$matches = array('"{\*?\\.+(;})|\s?\\[A-Za-z0-9]+|\s?{\s?\\[A-Za-z0-9]+\s?|\s?}\s?"');		
		$Cout4 .='{"klausul":"'.str_replace('\\', '', $rtf->Text($pecah4["ShortDesc_1"])).'",';
		$Cout4 .='"deskripsi":"'.$test.'"}';//$rtf->Text($pecah4["DESCRIPTION"])

	}
	$Cout .='"klausul_tambahan":['.$Cout4.'],';

	while($pecah5=$rcover2->tampil()){
		if($Cout5 !=""){$Cout5 .=",";}		
		$kode = $pecah5["CODE"];
		$pct = ($pecah5["PCTLOSS"] / 100);
		$si=$pclass->get_si($kode,$ano);

		$Cout5 .='{"tipe_pertanggungan":"'.str_replace('\\', '', $rtf->Text($si["remark"])).'",';
		$Cout5 .='"nilai":"'.$si["si"]*$pct.'",';	
		$Cout5 .='"rate":"'.$pecah5["RATE"].'",';	
		$Cout5 .='"tgl_awal":"'.date("d F Y",strtotime($pecah5["SDATE"])).'",';				
		$Cout5 .='"tgl_akhir":"'.date("d F Y",strtotime($pecah5["EDATE"])).'"}';			
	}
	$Cout .='"harga_pertanggungan":['.$Cout5.']}';

		//$Cout .='"akhir_polisi":"'.date("d-M-Y",strtotime($pecahAccp["EDATE"])).'"}';		
//}
//}



	$Cout='{"data":'.$Cout.'}';
	echo ($Cout);
//print_r($puser);

	?>
