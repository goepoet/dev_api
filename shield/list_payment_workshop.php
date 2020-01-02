<?php
include '../service/MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type,X-Custom-Header");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

include '../conf/konek.php';
$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
$status=$data->status;// jika val = 1 maka ambil data per user, tapi  jika val 2 = maka bisa ambil data dari cabng lain
$authKey=$data->auth_key;
$claimno=$data->claimno;
$ws_id=$data->ws_id;

$shield = new shield;
$shield2 = new shield;

$profile=new MST_PROFILE_CARE;
$user=new Cass_UserPanfic;
$rtf=new RTF;


	$query=$shield->list_payment_workshop("where WS_ID='$ws_id' order by NO desc");

$Cout="";

while($pecah=$shield->tampil()){
	if($Cout !=""){$Cout .=",";}
	$claimno=$pecah["NO_CLAIM"];		
	$shield2->list_in_workshop("where A.CLAIM_NO='$claimno'"); //cari no polis dari tabel calls log
	$view=$shield2->tampil();
	$nopol=$view["POLICY_NO"];
	$certi=$view["CERTIFICATE_NO"];
	$reg_id=$view["REG_ID"];
	 $profile->select("where POLICYNO='$nopol' and CERTIFICATENO='$certi'");
	 $view_prof=$profile->tampil();
	 if(date_format(date_create($pecah["PAYMENT_DATE"]),"d M Y")=='01 Jan 1900'){
	 	$tgl_byr="-";
	 }else{
	 	$tgl_byr=date_format(date_create($pecah["PAYMENT_DATE"]),"d M Y");
	 }
	$Cout .='{"id":"'.$no.'",';
	$Cout .='"claimno":"'.$claimno.'",';
	$Cout .='"submit_date":"'.$rtf->Text(date_format(date_create($pecah["INCOMING_DATE"]),"d M Y")).'",';
	$Cout .='"payment_date":"'.$rtf->Text($tgl_byr).'",';
	$Cout .='"policyno":"'.$rtf->Text($nopol."-".$certi).'",';	
	$Cout .='"reg_id":"'.$rtf->Text($reg_id).'",';	
	$Cout .='"nominal":"'.number_format($pecah["NOMINAL"],0).'",';
	$Cout .='"license_no":"'.$rtf->Text($view_prof["PHONE"]).'"}';
	$no=$no + 1;
}
$Cout='{"status":"'.$Cout3.'","msg":"'.$msg.'","total_data":"'.$no.'","data":['.$Cout.']}';
echo $Cout;

?>
