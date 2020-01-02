<?php
	// $client=new SoapClient("http://192.168.0.234/carewebservice/dataaccess.asmx?WSDL");
	// $result=$client->GetAuthorize(array('_dbUser'=>'isit01','_dbPassword'=>'4'));
	// $cihuy = $result->GetAuthorizeResult->GetAuthorizeResult;
	include '../conf/konek.php';
	include '../service/MainFrame.php';
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	
	$data=json_decode(file_get_contents("php://input"));
	ini_set('memory_limit', '-1');
	//$userid=mysql_real_escape_string($data->userid);
	//$password=mysql_real_escape_string($data->password);
	$auth_key=$_REQUEST['auth_key'];//$data->auth_key;
	//=======================================================
	$acceptance=new ACCEPTANCE;
	

	$Cass_MstUser=new Cass_MstUser;
	$Rcover=new RCOVER;
	$Cass_MstUser->select("where token_id='$auth_key'");
	$cek=$Cass_MstUser->tampil_row();
	$pecah=$Cass_MstUser->tampil();
	$idnya=$pecah["userid"]; 
	$dataUser=new Cass_MstDataUser;

	$query=$dataUser->select("where userid='$idnya' order by id asc");
	
	$Cout="";
	$Cout2="";
	$Cout3="";
	$dAte=date("Y-m-d");
	$rangkanya=array();
	$tampungan=array();
	
	if ($auth_key !='')
	{
			$jmlData=$dataUser->tampil_row();
			while($pecah2=$dataUser->tampil())
			{
				array_push($tampungan, "".$pecah2['chasis_number']."");//tampung datanya dulu ke array buat update
			}
			//fungsi buat update jenis coverage dari masing-masing polis.======================================
			/*for($i=0;$i<=$jmlData-1;$i++)
			{
				$kerangka=$tampungan[$i];
				$acceptance->select("where VALUEDESC like'%$kerangka%'");
				$pecahAccp=$acceptance->tampil();
				$aNo=$pecahAccp['ANO'];
				$Rcover->select("where ANO='$aNo' and SDATE <= '$dAte' and EDATE >= '$dAte' and CATEGORY='M'");
				$TampilCover=$Rcover->tampil();
				$coverage=$TampilCover["REMARK"];
				if($coverage =='')
				{
					$coverage="Policy Expired";
				}
				$datany=array('coverage'=>$coverage);
				$dataUser->ubah($datany,"where chasis_number='$kerangka'");
			}*/
			//end fungsi buat update jenis coverage dari masing-masing polis.==================================
			$dataUser->select("where userid='$idnya' order by id asc");//di query lagi karena udah di update di atas
			while($pecah3=$dataUser->tampil())
			{
				$rangkanya[] = array(
				 	"id" => $pecah3['ID'],
				 	//"chasis_number" => $pecah3['chasis_number'], 
				 	"policy_number" => $pecah3['policyno'],
				 	"policy_type" => $pecah3['coverage'], 
				 	"car_type" =>$pecah3["vehicle_brand"]." ".$pecah3["vehicle_model"],
				 	"car_number" => $pecah3['license_no'],
				 	"frame_number" => $pecah3['chasis_number'],
				 	"owner_name" => $pecah3['claimant'],
				 	"certificate" => $pecah3['certificateno'],
				 	"register_timestamp" => $pecah3['start_date'],
				 	"expired_timestamp" => $pecah3['end_date']
				);
			}			
			$Cout .='{"id":"'.$pecah["userid"].'",';
			$Cout .='"name":"'.$pecah["name"].'",';	
			$Cout .='"email":"'.$pecah["mail"].'",';
			$Cout .='"phone":"'.$pecah["phone"].'",';
			$Cout .='"lat":"",';
			$Cout .='"lon":"",';
			for($i=0;$i<=$jmlData-1;$i++)
			{				
				if($Cout2 !=""){$Cout2 .=",";}
				$Cout2 .='{"id":"'.$rangkanya[$i][id].'",';
				$Cout2 .='"policy_number":"'.$rangkanya[$i][policy_number].'",';
				$Cout2 .='"policy_type":"'.$rangkanya[$i][policy_type].'",';			
				$Cout2 .='"car_type":"'.$rangkanya[$i][car_type].'",';	
				$Cout2 .='"car_number":"'.$rangkanya[$i][car_number].'",';
				$Cout2 .='"frame_number":"'.$rangkanya[$i][frame_number].'",';
				$Cout2 .='"owner_name":"'.$rangkanya[$i][owner_name].'",';	
				$Cout2 .='"certificate":"'.$rangkanya[$i][certificate].'",';	
				$Cout2 .='"register_timestamp":"'.$rangkanya[$i][register_timestamp].'",';	
				$Cout2 .='"expired_timestamp":"'.$rangkanya[$i][expired_timestamp].'"}';
			}
			$Cout .='"policy":['.$Cout2.']}';
			$Cout3 = $query;
			if($query=='0'){
				$Cout4 = "Invalid query";
			}else
			{
				$Cout4 = "";
			}
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;
			print_r($tampungan);
			print_r($rangkanya);			
	}else
	{				
			$Cout3 = "0";			
			$Cout4 = "Invalid AUTH key";
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;		
	}
	
?>
