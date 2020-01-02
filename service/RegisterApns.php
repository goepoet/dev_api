<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
	$auth_key=$_REQUEST['auth_key'];
	$gcm_oken=$_REQUEST['apns_token'];
	//=======================================
	$Cass_MstUser = new Cass_MstUser;
	$Cass_MstUser->select("where token_id='$auth_key'");
	$tampilUser=$Cass_MstUser->tampil();
	$userId=$tampilUser['userid'];

	$Apns=new Cass_Gcm;
	$Apns->count("where user_id='$userId'");
	$tampilApns=$Apns->tampil();
	$jmlData=$tampilApns['total'];
	if($jmlData =='0')
	{

		if($auth_key=='' and $gcm_oken=='')
		{
			/*$Cout .='{"msg":"Register Apns Gagal"}';
			echo $Cout='{"data":'.$Cout.'}';*/
			$Cout4 = "Register Apns Gagal";
			$query="0";
		}else{
			$isinya = array(
				'user_id'=>$userId,
				'device_id'=>$gcm_oken,
				'create_date'=>date('Y-m-d H:m:s'),
				'last_update'=>date('Y-m-d H:m:s'),
				'active_status'=>"2",
				'auth_key'=>$auth_key
			);

			$query=$Apns->simpan($isinya);
			//echo ($query);
			if($query=='0')
			{
				$Cout4 = "Invalid query";
				$Cout = "{}";
			}else
			{
				$Cout4 = "Register Apns berhasil";
				$Cout = "{}";
			}
		}
	}else
	{
		/*$Cout .='{"msg":"Id anda telah terdaftar"}';
			echo $Cout='{"data":'.$Cout.'}';*/
		$updatenya = array(				
				'device_id'=>$gcm_oken,
				'active_status'=>"2",				
				'last_update'=>date('Y-m-d H:m:s')
			);

		$query=$Apns->updated($updatenya,"where user_id='$userId'");
			
		$Cout4 = "Id anda telah terdaftar";
		$query=$query;
		$Cout = "{}";
	}	
			$Cout3 = $query;	
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;	
?>
