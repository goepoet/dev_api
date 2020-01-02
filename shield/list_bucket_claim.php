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
//$ws_id=$data->ws_id;


$mst_user = new MST_MENU_PRIVILEDGE;
$bkl= new MST_BENGKEL;
$shield= new shield;
$user=new Cass_UserPanfic;
$fu_act= new fu_activity;

$rtf=new RTF;

$user->selectJoinUser("where auth_key_shield='$authKey'");
$view_user=$user->tampil();
$branch=$view_user["Branch"];
if($branch==''){
	$branch="0";
}
$shield->list_bucket($branch);
while($pecah=$shield->tampil()){
	if($Cout !=""){$Cout .=",";}
	$noClaim=$pecah["claimno"];
	$fu_act->select("where no_claim='$noClaim'");
	$v_ws=$fu_act->tampil();
	$ws_id=$v_ws["workshop"];
	$bkl->Select("where ID='$ws_id'");
	$v_bkl=$bkl->tampil();
	$ws_name=$v_bkl["nama_bengkel"];
	if( $ws_id ==' '){
		$ws_name="CS Belum input ID bengkel";
	}elseif($ws_name==''){
		$ws_name="ID bengkel yang dipakai tidak terdaftar di Shield";
	}

	$Cout .='{"calls_id":"'.$pecah["calls_id"].'",';
	$Cout .='"tgl_survey":"'.$pecah["tanggal"].'",';	
	$Cout .='"branch":"'.$pecah["branch"].'",';
	$Cout .='"name":"'.$pecah["names"].'",';	
	$Cout .='"reg_id":"'.$pecah["reg_id"].'",';	
	$Cout .='"survey_id":"'.$pecah["survey_id"].'",';		
	$Cout .='"survey_date":"'.date_format(date_create($pecah["survey_date"]),"d-M-Y").'",';	
	$Cout .='"policyno":"'.$pecah["policyno"].'",';	
	$Cout .='"claimno":"'.$pecah["claimno"].'",';	
	$Cout .='"alamat":"'.$pecah["address"].'",';	
	$Cout .='"city":"'.$pecah["city"].'",';	
	$Cout .='"workshop":"'.$ws_name.'",';	
	$Cout .='"cs":"'.$pecah["name"].'"}';	
	$no=$no + 1;
}
$Cout='{"status":"'.$Cout3.'","msg":"'.$msg.'","total_data":"'.$no.'","data":['.$Cout.']}';
echo $Cout;

/*$shield->get_user_care("where ID='isit01'");
$hasil=$shield->tampil();
echo $hasil["CT"];*/
?>
