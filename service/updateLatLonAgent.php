<?php	
	include 'MainFrame.php';
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");	
	$data=json_decode(file_get_contents("php://input"));
	ini_set('memory_limit', '512');
	$dataUser=new Cass_MstUser;  
	$Cass_pickup=new Cass_pickUp_survey;
	$Cass_location=new Cass_agent_location;
	$Survey=new Cass_survey_request;

	//=================================================	
	$auth_Key=$_REQUEST['auth_key'];//"1a1dfc19396ba8ce1e687880e4cc89de";
	$Request_id=$_REQUEST['request_id'];//'Bambang';
	$Agentlat=$_REQUEST['agent_lat'];
	$Agentlon=$_REQUEST['agent_lon'];
	//=========================================
	$Survey->select("where survey_id='$Request_id'");
	$baris=$Survey->tampil();
	$surveyor=$baris['surveyor'];
	$Cass_location->select("where user_id='$surveyor'");
	$jmlData=$Cass_location->tampil_row();
	if($auth_Key =='')
	{
		$Cout4 = "Invalid auth key";
		$query ="0";
	}else
	{
		$datanya = array('lat' =>$Agentlat,'lon'=>$Agentlon );
		$query=$Cass_pickup->updateLatLon($datanya,"where survey_id='$Request_id'");
		if($jmlData=='0')//buat update lokasi si user
		{	
			$DaLokasi=array('user_id'=>$surveyor,'lat_agent'=>$Agentlat,'lon_agent'=>$Agentlon);
			$Cass_location->simpan($DaLokasi);
		}else
		{
			$DaLokasi=array('user_id'=>$surveyor,'lat_agent'=>$Agentlat,'lon_agent'=>$Agentlon);
			$Cass_location->ubah($DaLokasi,"where user_id='$surveyor'");
		}

	}	
			$Cout3 = $query;			
			$Cout4 = "Agent location Updated";
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;
?>
