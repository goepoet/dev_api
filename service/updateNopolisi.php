<?php	
	include 'MainFrame.php';
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");	
	$data=json_decode(file_get_contents("php://input"));
	ini_set('memory_limit', '512');
	$dataUser=new Cass_MstDataUser;  
	//=================================================
	//$auth_Key=$data->auth_key;
	//$NewPass=$data->new_password;
	//$OldPass=$data->old_password;
	//$phone=$data->phone;
	
	$auth_Key=$_REQUEST['auth_key'];//"1a1dfc19396ba8ce1e687880e4cc89de";
	$Nopolisi=$_REQUEST['car_number'];
	$policy_id=$_REQUEST['policy_id'];
	/*$NewPass=$_REQUEST['new_password'];//'Bambang';
	$OldPass=$_REQUEST['old_password'];//"0912206";
	$phone=$_REQUEST['phone'];*/
	//$id="23RU081";
	//=========================================
	$datanya = array('license_no' =>$Nopolisi );
	if($Nopolisi =='')
	{
		/*$Cout='{"data":[{"msg":"Ubah Password gagal"}]}';
		echo $Cout;*/
		$Cout4 = "Invalid Car number";
		$query ="0";
	}elseif($auth_Key=='')
	{
		$Cout4 = "Invalid Auth key";
		$query ="0";
	}elseif($policy_id=='')
	{
		$Cout4 = "Invalid Policy ID";
		$query ="0";
	}
	else
	{
	/*$dataUser->select("where token_id='$auth_Key'");
	$pecah=$dataUser->tampil_row();
		if($pecah)
		{*/
			$query=$dataUser->ubah($datanya,"where ID='$policy_id'");
			//$Cout='{"data":[{"msg":"Ubah Password Berhasil"}]}';
			if($query=='0')
			{
				$Cout4 = "Invalid query";
			}else
			{
				$Cout4 = "Ubah No polisi Berhasil";
			}
		/*}else
		{
			//$Cout='{"data":[{"msg":"Ubah Password gagal"}]}';
			$query ="0";
			$Cout4 = "Ubah  No polisi gagal";
		}*/
		//echo $Cout;

			
	}	
			$Cout3 = $query;			
			//$Cout4 = "Invalid AUTH key";
			$Cout = "{}";			
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;	
?>
