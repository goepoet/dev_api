<?php
include '../service/MainFrame.php';
$SendNotif=new PushNotif;
$Cass_Gcm=new Cass_Gcm;
$Survey_request=new Cass_survey_request;
$sms=new Sms;
$survey_id=$_REQUEST['survey_id'];
$pesan=$_REQUEST['message'];

$Survey_request->select("where survey_id='$survey_id'");
$row=$Survey_request->tampil();
$idnya=$row['user_id'];

        $Cass_Gcm->select("where user_id='$idnya'");
        $Ap=array();
        while($viewApikey=$Cass_Gcm->tampil())
        {
            if($Apikey !=""){$Apikey .=",";}           
            array_push($Ap, "".$viewApikey['device_id']."");
        }
//print_r($Ap);
//$Ap=array('fuPG3xtbZcc:APA91bEDJ8nXGsLMooyraHZkHWbHlHobNr2nEk0XcapA_n7WMYGvrgmf-mYo81XwNMnXiNvQWTdMolXcyRWXVA51e1D_VJcyLcXl_HywnSUyPeIAidaXrOnM3OCnu-yknbg-X62tvOGN');        
echo "<br/><br/>";
//print_r($ids);

$SendNotif->sendPushNotification($pesan,$Ap);

/*$msg_payload = array (
        'mtitle' => 'Casandra',
        'mdesc' => 'Percobaan',
    );
$deviceToken = '436541f09465a208cd21105754ecb85f6795821d1fbe80470eaea84366d83d4c';

$query=$SendNotif->sendPushiOS("percobaan ke 2",$deviceToken);
echo $query;
$sms->sendSms('6285692554749','Agent survey kami sudah sampai di lokasi anda');*/
?>