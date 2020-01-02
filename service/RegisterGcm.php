<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
	$auth_key=$_REQUEST['auth_key'];
	$gcm_token=$_REQUEST['gcm_token'];
	//=======================================
	$Cass_MstUser = new Cass_MstUser;
	$userInternal= new Cass_UserPanfic;
	$Cass_MstUser->select("where token_id='$auth_key'");
	$tampilUser=$Cass_MstUser->tampil();
	$userId=$tampilUser['userid'];

	if ($userId=='')
	{
		$userInternal->select("where auth_key='$auth_key'");
		$rowInter=$userInternal->tampil();
		$userId=$rowInter['user_id'];
	}
	$Gcm=new Cass_Gcm;	
	$Gcm->count("where user_id='$userId'");
	$tampilGcm=$Gcm->tampil();
	$jmlData=$tampilGcm['total'];
	if($jmlData =='0')
	{

		if($auth_key=='' and $gcm_token=='')
		{
			/*$Cout .='{"msg":"Register GCM Gagal"}';
			echo $Cout='{"data":'.$Cout.'}';*/
			$Cout4 = "Register GCM Gagal";
			$query="0";
		}else{
			$isinya = array(
				'user_id'=>$userId,
				'device_id'=>$gcm_token,
				'create_date'=>date('Y-m-d H:m:s'),
				'last_update'=>date('Y-m-d H:m:s'),
				'active_status'=>1,//android
				'auth_key'=>$auth_key
			);

			$query=$Gcm->simpan($isinya);
			
			
			if($query=='0')
			{
				$Cout4 = "Invalid query";
				$Cout = "{}";
			}else
			{
				$Cout4 = "Register Gcm berhasil";
				$Cout = "{}";
			}

		}
	}else
	{
		//$Cout .='{"msg":"Id anda telah terdaftar"}';
		$updatenya = array(				
				'device_id'=>$gcm_token,
				'create_date'=>date('Y-m-d H:m:s'),
				'active_status'=>1,//android
				'last_update'=>date('Y-m-d H:m:s'),
				'auth_key'=>$auth_key
			);

		$query=$Gcm->updated($updatenya,"where user_id='$userId'");

		$Cout4 = "Id anda telah terdaftar";
		$query=$query;
		$Cout = "{}";
		//$Cout3 = $query;
			//echo $Cout='{"data":'.$Cout.'}';
	}
			$Cout3 = $query;	
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;	
?>
