<?php	
	include 'MainFrame.php';
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");	
	$data=json_decode(file_get_contents("php://input"));
	ini_set('memory_limit', '512');
	$dataUser = new Cass_MstDataUser;
	$UserId = new Cass_MstUser;

	//=================================================
	//$auth_Key=$data->auth_key;
	//$id=$data->policy_id;
	
	$auth_Key=$_REQUEST['auth_key'];//"1a1dfc19396ba8ce1e687880e4cc89de";
	$id=$_REQUEST['policy_id'];//"1";

	$UserId->select("where token_id='$auth_Key'");
	$tampilUser=$UserId->tampil();
	$user=$tampilUser['userid'];
	$dataUser->count("where userid='$user'");
	$tampilDatauser=$dataUser->tampil();
	$total=$tampilDatauser['total'];
	//=========================================
	$Cout="";
	if($total > '1')
	{
		if($auth_key=='' and $id=='')
		{
			//$Cout='{"data":[{"msg":"Hapus Polis Gagal.."}]}';
			//$Cout='{"data":[{"msg":"Hapus Polis Gagal.."}]}';
			//echo $Cout;
			$query="0";//false
			$Cout4 = "Hapus Polis Gagal..";
		}else{
			$query = $dataUser->hapus("where ID='$id'");	
			//echo $query;
			if($query=='1')//true
			{
				$Cout4 = "Hapus polis berhasil";
			}else
			{
				$Cout4 = "Invalid query";
			}
		}
	}
	else
	{
		//$Cout='{"data":[{"msg":"Anda dapat menghapus data polis, jika jumlah polis terdaftar lebih dari satu"}]}';
		//echo $Cout;
		$query="0";	
		$Cout4 ="Anda dapat menghapus data polis, jika jumlah polis terdaftar lebih dari satu";	
	}
			$Cout3 = $query;			
			//$Cout4 = "Invalid AUTH key";
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;	

?>
