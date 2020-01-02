<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	
	$auth_key=$_REQUEST['auth_key'];
	$notifId=$_REQUEST['notification_id'];
	//=============================================
	$MstUser=new Cass_MstUser;
	$MstUser->select("where token_id='$auth_key'");
	$TampilUser=$MstUser->tampil();
	$userId=$TampilUser['userid'];

	if($auth_key =='' || $notifId =='')
	{	
		/*$Cout .='{"msg":"Something went wrong. Please try again later."}';
		echo $Cout='{"data":'.$Cout.'}';*/
		$Cout4 = "Auth key dan notification ID tidak boleh kosong";
		$query ="0";
	}else{
		$notif=new Cass_notification;
		$query=$notif->ubahData($userId,$notifId);
		//echo $query;
			if($query=='0')
			{
				$Cout4 = "Invalid query";
			}else
			{
				$Cout4 = "Ubah Password Berhasil";
			}
	}
			$Cout3 = $query;			
			//$Cout4 = "Invalid AUTH key";
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;	
?>
