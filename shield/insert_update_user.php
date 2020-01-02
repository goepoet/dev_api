<?php
include '../service/MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type,X-Custom-Header");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");


	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);

	$ws_id=$data->ws_id;
	$nama_bengkel=$data->ws_name;
	$user_id=$data->user;
	$pass=$data->pass;
	$bengkel=new MST_BENGKEL;
	$mst_user= new MST_USER;
	
	$mst_user->select("where ID='$ws_id'");
	$bengkel=$mst_user->tampil_row();
	if($bengkel==1){
		$datanya = array('UserPassword' =>$pass , );
		$query=$mst_user->ubah($datanya,"where ID='$ws_id'");
		$msg="update berhasil";
	}else{
		$datanya = array('UserPassword' =>$pass ,'UserID'=>$user_id,
			'FullName'=>'Workshop',
			'IDMsGroupUser'=>'2','FlagActive'=>'Y','ID'=>$ws_id,'ID_SOB'=>$ws_id );
		$query=$mst_user->simpan($datanya);
		$msg="Simpan berhasil";
	}

	//$mst_user->simpan

			//$Cout3 = $query;
			$Cout4 = "";
			//$Cout = "{}";
			$Cout='{"status":"'.$query.'","msg":"'.$msg.'"}';
			echo $Cout;	
?>
