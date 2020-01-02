<?php
include '../service/MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
	//$branchId=$_REQUEST['branch'];
	
		$authKey=$data->auth_key;
		$type=$data->type;
	

	$userPanfic=new Cass_UserPanfic;
	$surveyor=new MST_MENU_PRIVILEDGE;
	$Survey_request=new Cass_survey_request;
	$userPanfic->selectJoinUser("where auth_key_shield='$authKey'");
	$TampilUser=$userPanfic->tampil();
	$branchId=$TampilUser['Branch'];
	$viewBranch=str_replace(",","','", $TampilUser['akses_cabang']) ;

	if ($type=='S'){//cari surveyor
		$query=$surveyor->select("where Branch='$branchId' and surveyor='Y'");
	}else{
		$query=$surveyor->select("where Branch in('$viewBranch') and estimator='Y' order by branch asc");
	}

	if($authKey=='')
	{
		$Cout4 = "Invalid authKey";
		$query="0";
	}else
	{
	$Cout="";
	while($pecah=$surveyor->tampil()){
		$bln=date('m');
		$blnThn=date('M-Y');
		$user=$pecah["ID"];
		//$Survey_request->totalSurvey("where MONTH(register_date)='$bln' and surveyor='$user'");
		$Survey_request->totalSurvey("where register_date between  DATEADD (day , -30 , GETDATE()) and GETDATE() and surveyor='$user'");
		$tampilsurvey=$Survey_request->tampil();
		if($Cout !=""){$Cout .=",";}		
		$Cout .='{"id":"'.$pecah["ID"].'",';	
		$Cout .='"name":"'.$pecah["Name"].'",';
		$Cout .='"phone":"'.$pecah["phone"].'",';
		$Cout .='"date":"'.$blnThn.'",';
		$Cout .='"task":"'.$tampilsurvey["total"].'",';
		$Cout .='"pic":"'.$pecah["pic"].'"}';		
		}
			if($query=='0'){
				$Cout4 = "Invalid query";
			}else
			{
				$Cout4="";
			}		
	}		
	
			$Cout3 = $query;			
			
			$Cout='{"status":"'.$Cout3.'","msg":"'.$viewBranch.'","data":['.$Cout.']}';
			echo $Cout;		
	
?>
