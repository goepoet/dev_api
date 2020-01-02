<?php	
	include 'MainFrame.php';
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");	
	$data=json_decode(file_get_contents("php://input"));
	ini_set('memory_limit', '512');
	$dataUser=new Cass_MstDataUser;
	//=================================================
	//$noPolisi=mssql_real_escape_string($data->no_polisi);
	//$nama=mssql_real_escape_string($data->nama);
	//$id="";
	$noPolisi= "B 1264 OK";
	$nama='Bambang';
	$id="23RU081";
	//=========================================
	$isinya = array
	(
		'license_no'=>$noPolisi,
		'claimant'=>$nama
		
	);		
		foreach ( $isinya as $kolom =>$value)
			{				
				$i;
				if($i >'0'){$k =",";}				
				$nilai = "'".$value."'";
				$field= $field.$k.$kolom."=".$nilai;				
				//$hasil=$nilai;				
				$i++;				
			}
	echo $dataUser->ubah($isinya,"where userid='$id'");	
?>
