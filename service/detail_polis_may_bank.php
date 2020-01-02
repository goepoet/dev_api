<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	//include '../conf/konekCare.php';
	//include '../conf/konek.php';
$data=json_decode(file_get_contents("php://input"));
ini_set('memory_limit', '-1');

	//$id=mysql_real_escape_string($data->email);
	//$nopol=$_REQUEST['policy_no'];
	//$certificateno=$_REQUEST['certificateno'];//$data->email;//dari data yang dilempar apps
$refno=$_REQUEST['refno'];
$auth_key=$_REQUEST['auth_key'];

$MstProfileCare=new MST_PROFILE_CARE;
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
$pclass=new PCLASS;
$surveyor=new SURVEYOR;
$rtf=new RTF;
$dAte=date('Y-m-d');
$Cout="";


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
		$acceptance->select("where REFNO ='$refno' and ASTATUS='I'");
		$pecahAccp=$acceptance->tampil();
		$id=$pecahAccp['AID'];
		$ano=$pecahAccp['ANO'];
		$cno=$pecahAccp['CNO'];
		$renewal=$pecahAccp['RENEWAL'];
		if($renewal=='0')
		{
			$renewal="Baru";
		}else
		{
			$renewal="Perpanjangan";
		}

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
	$Cout .='{"nama":"'.$pecahAccp['AName'].'",';	
	$Cout .='"policyno":"'.$pecahAccp['POLICYNO'].'",';
	$Cout .='"certificateno":"'.$pecahAccp['CERTIFICATENO'].'",';
	$Cout .='"no_polisi":"'.$detailVehicle['License_number'].'",';
	$Cout .='"status_polis":"'.$renewal.'",';
	$Cout .='"no_kontrak":"'.$pecahAccp['REFNO'].'",';
	$Cout .='"cabang":"'.$pecahAccp['Location'].'",';
	$Cout .='"alamat":"'.$pecahprofil['Address_1'].'",';
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
	$Cout .='"catatan_surveyor":"'.$tampil_catatan['REMARKS'].'",';
	$Cout .='"perlengkapan_tambahan":"",';				
	$Cout .='"mulai_polis":"'.date("d F Y",strtotime($pecahAccp["SDATE"])).'",';		
	$Cout .='"akhir_polis":"'.date("d F Y",strtotime($pecahAccp["EDATE"])).'",';
	while($pecah2=$Rcover->tampil()){
		if($Cout2 !=""){$Cout2 .=",";}		
		$Cout2 .='{"tipe_pertanggungan":"'.$pecah2["REMARK"].'",';
		$Cout2 .='"tgl_awal":"'.date("d F Y",strtotime($pecah2["SDATE"])).'",';				
		$Cout2 .='"tgl_akhir":"'.date("d F Y",strtotime($pecah2["EDATE"])).'"}';			
	}
	$Cout .='"jenis_pertanggungan":['.$Cout2.'],';

	while($pecah3=$accded->tampil()){
		if($Cout3 !=""){$Cout3 .=",";}		
		$Cout3 .='{"risiko":"'.$pecah3["REMARKS"].'"}';

	}
	$Cout .='"risiko_sendiri":['.$Cout3.'],';

	while($pecah4=$acccla->tampil()){
		if($Cout4 !=""){$Cout4 .=",";}
		//$test=str_replace('\\', '', "\%~}");
		$test=str_replace('\\', '', $rtf->Text($pecah4["Description_1"]));
		//$matches = array('"{\*?\\.+(;})|\s?\\[A-Za-z0-9]+|\s?{\s?\\[A-Za-z0-9]+\s?|\s?}\s?"');		
		$Cout4 .='{"klausul":"'.$pecah4["ShortDesc_1"].'",';
		$Cout4 .='"deskripsi":"'.$test.'"}';//$rtf->Text($pecah4["DESCRIPTION"])

	}
	$Cout .='"klausul_tambahan":['.$Cout4.'],';

	while($pecah5=$rcover2->tampil()){
		if($Cout5 !=""){$Cout5 .=",";}		
		$kode = $pecah5["CODE"];
		$pct = ($pecah5["PCTLOSS"] / 100);
		$si=$pclass->get_si($kode,$ano);

		$Cout5 .='{"tipe_pertanggungan":"'.$si["remark"].'",';
		$Cout5 .='"nilai":"'.$si["si"]*$pct.'",';	
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
