<?php
include '../service/MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type,X-Custom-Header");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

include '../conf/konek.php';
$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
$status=$data->status;
$authKey=$data->auth_key;
$claimno=$data->claimno;
$remarks=$data->remarks;
$ws_id=$data->ws_id;
$desc=$data->desc;

$shield = new shield;
$user_panfic=new Cass_UserPanfic;
if($remarks =='' || $remarks ==' '){
	$query="0";
	$msg="Mohon pilih Proses Pengerjaan / Info Sparepart terlebih dahulu.";
}else if($claimno =='' || $claimno ==' '){
	$query="0";
	$msg="Mohon pilih No claim yang ingin anda Update.";
}else{
	if($authKey !=''){
//=======================================
		$user_panfic->select("where auth_key_shield='$authKey'");
		$tampilkan= $user_panfic->tampil();
		$cek_user=$user_panfic->tampil_row();
		$user_id=$tampilkan['user_id'];
//=====================================
		$shield->select_history_claim("where claimno='$claimno' and status='$status'");
		$history=$shield->tampil_row();
		if($history ==0){
			$data_history = array('tgl' => date('Y-m-d H:i:s'),'claimno'=>$claimno,'status'=>$status,'remarks'=>$remarks,'user_update'=>$user_id);
			$query=$shield->simpan_history_claim($data_history);
			$msg="update berhasil";
		}else{
			$query="0";
			$msg="data sudah pernah update";
		}
	}else if($ws_id !=''){
		$data_history = array('tgl' => date('Y-m-d H:i:s'),'claimno'=>$claimno,'status'=>$status,'remarks'=>$remarks,'user_update'=>$ws_id,'description'=>$desc);
		$query=$shield->simpan_history_claim($data_history);
		if($query ==1){
			$msg="update berhasil";
		}else{
			$msg="update gagal";
		}
	}else{
		$query="0";
		$msg="anda tidak terdaftar " + $authKey;
	}
}

$Cout='{"status":"'.$query.'","msg":"'.$msg.'"}';  
echo $Cout;
?>
