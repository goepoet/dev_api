<?php
include '../service/MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type,X-Custom-Header");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

include '../conf/konek.php';
$data=json_decode(file_get_contents("php://input"));
	//$id=mysql_real_escape_string($data->id);
$status=$data->status;// jika val = 1 maka ambil data per user, tapi  jika val 2 = maka bisa ambil data dari cabng lain
$authKey=$data->auth_key;
$claimno=$data->claimno;
$ws_id=$data->ws_id;

$shield = new shield;
$shield2 = new shield;

$profile=new MST_PROFILE_CARE;
$user=new Cass_UserPanfic;
$rtf=new RTF;

	$datanya = array('RefTime' =>'' );
	$query=$shield->update_ref_claim($datanya,"where ClaimNo='07022319090255'");
echo $query;

?>
