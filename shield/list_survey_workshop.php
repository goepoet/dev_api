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
$workshop=new MST_BENGKEL;
$profile=new MST_PROFILE_CARE;
$user=new Cass_UserPanfic;
$rtf=new RTF;

$user->selectJoinUser("where auth_key_shield='$authKey'");
$view_user=$user->tampil();
$branch=$view_user["akses_cabang"];
if($branch==''){
	$branch="0";
}
if($ws_id==''){//untuk cek via bengkel
	$query=$shield->list_claim_workshop("where status='$status' and b.branch in($branch)");
}else{//via internal
	$query=$shield->list_claim_workshop("where status='$status' and workshop='$ws_id'");
}
$Cout="";
while($pecah=$shield->tampil()){
	if($Cout !=""){$Cout .=",";}
	$ws_id=$rtf->Text($pecah["WORKSHOP"]);	
	$nopol=$pecah["POLICY_NO"];
	$certificate=$pecah["CERTIFICATE_NO"];

	$workshop->Select("where ID='$ws_id'");
	$view_ws=$workshop->tampil();
	
	$profile->select_license(" where POLICYNO='$nopol' and CERTIFICATENO='$certificate' ");
	$view_prof=$profile->tampil();
	$Cout .='{"id":"'.$pecah["Row"].'",';
	$Cout .='"claimno":"'.$pecah["CLAIM_NO"].'",';
	$Cout .='"submit_date":"'.$rtf->Text($pecah["submit_date"]).'",';
	$Cout .='"policyno":"'.$rtf->Text($pecah["POLICY_NO"]."-".$pecah["CERTIFICATE_NO"]).'",';
	$Cout .='"ws_name":"'.$rtf->Text($view_ws["nama_bengkel"]).'",';
	
	$Cout .='"su_id":"'.$rtf->Text($pecah["SURVEY_ID"]).'",';
	$Cout .='"license_no":"'.$rtf->Text($view_prof["PHONE"]).'"}';
	$no=$no + 1;
}
$Cout='{"status":"'.$Cout3.'","msg":"'.$msg.'","total_data":"'.$no.'","data":['.$Cout.']}';
echo $Cout;


?>
