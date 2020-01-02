<?php
include 'MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	include '../conf/konek.php';
	$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
	$auth_key=$_REQUEST['auth_key'];
	
	$surveyor_id=$_REQUEST['content_id'];
	$rating=$_REQUEST['rating'];
	$request_id=$_REQUEST['request_id'];
	$comment=$_REQUEST['comment'];
	$rating_type=$_REQUEST['rating_type'];
	//=======================================

	$Cass_rating = new Cass_rating;
	$MstUser=new Cass_MstUser;
	$Survey_request=new Cass_survey_request;
	$Survey_request->select("where survey_id='$request_id'");
	$tampilReq=$Survey_request->tampil();
	if($rating_type=='2')
	{
		$surveyor_id=$tampilReq['workshop'];
	}else
	{
		$surveyor_id=$tampilReq['surveyor'];
	}
	
	$MstUser->select("where token_id='$auth_key'");
	$TampilUser=$MstUser->tampil();
	$userId=$TampilUser['userid'];

	if($rating=='' || $rating=='0')
	{
		/*$Cout ='{"msg":"Mohon untuk tidak mengosongkan nilai Rating"}';
		echo $Cout='{"data":'.$Cout.'}';*/
		$Cout4 = "Mohon untuk tidak mengosongkan nilai Rating";
		$query ="0";
	}elseif($comment=='')
	{
		/*$Cout ='{"msg":"Silahkan masukan komentar anda untuk dapat memperbaiki layanan kami"}';
		echo $Cout='{"data":'.$Cout.'}';*/
		$Cout4 = "Silahkan masukan komentar anda untuk dapat memperbaiki layanan kami";
		$query ="0";
	}else{
		$datauser = array(
				'user_id'=>$userId,
				'surveyor_id'=>$surveyor_id,//note di ganti pake di cariin via data data request survey  aja
				'request_id'=>$request_id,
				'rating'=>$rating,
				'comment'=>$comment,
				'rating_type'=>$rating_type,
				'reg_date'=>date("Y-m-d H:m:s")
			);

		$query=$Cass_rating->simpan($datauser);
		//echo ($query);
		if($query=='0')
			{
				$Cout4 = "Invalid query";
			}else
			{
				$Cout4 = "Terima kasih untuk partisipasi anda pada layanan kami";
			}
	}
			$Cout3 = $query;			
			//$Cout4 = "Invalid AUTH key";
			$Cout = "{}";
			$Cout='{"status":"'.$Cout3.'","msg":"'.$Cout4.'","data":'.$Cout.'}';
			echo $Cout;	
?>
