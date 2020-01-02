<?php	
	include 'MainFrame.php';
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");	
	$data=json_decode(file_get_contents("php://input"));
	ini_set('memory_limit', '512');
	$dataUser=new Cass_MstUser;
	//=================================================
	//$auth_Key=$data->auth_key;
	//$NewPass=$data->new_password;
	//$OldPass=$data->old_password;
	//$phone=$data->phone;
	
	$auth_Key=$_REQUEST['auth_key'];//"1a1dfc19396ba8ce1e687880e4cc89de";
	$NewPass=$_REQUEST['new_password'];//'Bambang';
	$OldPass=$_REQUEST['old_password'];//"0912206";
	$phone=$_REQUEST['phone'];
	//$id="23RU081";
	//=========================================
	
	if($auth_Key =='' || $NewPass =='' || $OldPass=='')
	{
		/*$Cout='{"data":[{"msg":"Ubah Password gagal"}]}';
		echo $Cout;*/
		$Cout4 = "Ubah Password gagal";
		$query ="0";
	}else
	{
	$dataUser->select("where token_id='$auth_Key' and password ='$OldPass'");
	$pecah=$dataUser->tampil_row();
		if($pecah)
		{
			$query=$dataUser->ubahPass($NewPass,$OldPass,$auth_Key);
			//$Cout='{"data":[{"msg":"Ubah Password Berhasil"}]}';
			if($query=='0')
			{
				$Cout4 = "Invalid query";
			}else
			{
				$Cout4 = "Ubah Password Berhasil";
			}
		}else
		{
			//$Cout='{"data":[{"msg":"Ubah Password gagal"}]}';
			$query ="0";
			$Cout4 = "Ubah Password gagal";
		}
		//echo $Cout;
			$Cout3 = $query;			
			//$Cout4 = "Invalid AUTH key";
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;	
	}	
?>
