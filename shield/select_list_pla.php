<?php
include '../service/MainFrame.php';
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Headers: Content-Type,X-Custom-Header");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

include '../conf/konek.php';
$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
$val=$data->val;// jika val = 1 maka ambil data per user, tapi  jika val 2 = maka bisa ambil data dari cabng lain
$authKey=$data->auth_key;
$claimno=$data->claimno;

$tr_survey_log = new tr_survey_log;
$fu_activity= new fu_activity;
$rtf=new RTF;
$userPanfic=new Cass_UserPanfic;
$menuPreviledge=new MST_MENU_PRIVILEDGE;

$userPanfic->selectJoinUser("where auth_key_shield='$authKey'");
$TampilUser=$userPanfic->tampil();
$branch_id=$TampilUser['Branch'];
$surveyor=$TampilUser['ID'];

//============== ini hanya utuk estimator
/*$menuPreviledge->select("where branch='$branch_id' and estimator ='Y'");
$tampilEstimator=$menuPreviledge->tampil();
$estimator=$tampilEstimator['ID'];*/

//$surveyor="ansv01";
if($val=='1'){//ini untuk menambilkan permasing-masing user
	$query=$tr_survey_log->select(" where status='1' and surveyor = '$surveyor' and estimator <> '' and estimator<>'1'");
	$Cout="";
	while($pecah=$tr_survey_log->tampil()){
		if($Cout !=""){$Cout .=",";}
		$claim=$pecah["CLAIMNO"];
		$fu_activity->select("where no_claim='$claim'");
		$pecah_fu=$fu_activity->tampil();
		$fu=$pecah_fu["REG_ID"];
		$Cout .='{"id":"'.$pecah["SURVEY_ID"].'",';
		$Cout .='"claimno":"'.$pecah["CLAIMNO"].'",';
		$Cout .='"survey_date":"'.$pecah["SURVEY_DATE"].'",';
		$Cout .='"fu":"'.$fu.'",';
		$Cout .='"surveyor":"'.$pecah["surveyor"].'",';	
		$Cout .='"lokasi":"'.$rtf->Text($pecah["ADDRESS"]." ".$pecah["CITY"]." ".$pecah["PROVINCE"]).'"}';
		$no=$no + 1;
	}	
	$Cout3 = $query;
	if($query=='0')
	{
		$Cout4 = "Invalid query";
		$Cout = "{}";
	}else
	{
		$Cout4 = "";

	}
	if($no !=''){
		$msg="Data ditemukan..";
	}else{
		$msg="Data tidak ditemukan..";
	}
}else{//ini untuk mengambil data perus
	$menuPreviledge->select("where ID='$surveyor' and estimator ='Y'");
	$tampilEstimator=$menuPreviledge->tampil();
	$estimator=$tampilEstimator['ID'];
	if($estimator == ''){
		$msg="Anda tidak terdaftar sebagai estimator ( Jika anda adalah estimator silahkan login kembali )";
	}else{
		//$msg="Anda terdaftar sebagai estimator";
		if($claimno == ''){
			$msg="Silahkan masukan no claim yang ingin anda cari";
		}else{
			$query=$tr_survey_log->select(" where status='1' and claimno = '$claimno'");
			$Cout="";
			while($pecah=$tr_survey_log->tampil()){
				if($Cout !=""){$Cout .=",";}
				$claim=$pecah["CLAIMNO"];
				$fu_activity->select("where no_claim='$claim'");
				$pecah_fu=$fu_activity->tampil();
				$fu=$pecah_fu["REG_ID"];
				$Cout .='{"id":"'.$pecah["SURVEY_ID"].'",';
				$Cout .='"claimno":"'.$pecah["CLAIMNO"].'",';
				$Cout .='"survey_date":"'.$pecah["SURVEY_DATE"].'",';
				$Cout .='"fu":"'.$fu.'",';
				$Cout .='"surveyor":"'.$pecah["surveyor"].'",';	
				$Cout .='"lokasi":"'.$rtf->Text($pecah["ADDRESS"]." ".$pecah["CITY"]." ".$pecah["PROVINCE"]).'"}';
				$no=$no + 1;
			}	
			$Cout3 = $query;
			if($query=='0')
			{
				$Cout4 = "Invalid query";
				$Cout = "{}";
			}else
			{
				$Cout4 = "";

			}
			if($no !=''){
				$msg="Data ditemukan..";
			}else{
				$msg="Data tidak ditemukan..";
			}
		}
	}
}			//$Cout = "{}";
$Cout='{"status":"'.$Cout3.'","msg":"'.$msg.'","total_data":"'.$no.'","data":['.$Cout.']}';
echo $Cout;


?>
