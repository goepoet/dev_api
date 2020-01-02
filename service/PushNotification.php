<?php
include '../service/MainFrame.php';
$SendNotif=new PushNotif;
$Cass_Gcm=new Cass_Gcm;
$Survey_request=new Cass_survey_request;

$sms=new Sms;

$Cass_Gcm->select("where user_id in('isit01','ulcl01')");
        $esti=array();
        while($viewApikey=$Cass_Gcm->tampil())
        {
            if($Apikey !=""){$Apikey .=",";}           
            array_push($esti, "".$viewApikey['device_id']."");
        }
//print_r($esti);
        
$Ap=array('dBqXMT36Zgg:APA91bHmKGDlfPT3NV2RqWhgfEhCy1BCTiFkXiiwKzFJLo8PmTCUtRIeD525gkdlwGOq7BgotyHa8Xhj-1tX_uaN0GbV-zTSXj72FRxDLjuA2ki4ZRQC75wi4l7ZildGA6I0Kg6F0ErH');        

$SendNotif->sendPushNotificationFCM("test ulul masuk ga.?", $Ap);

/*$esti = array('euH_637Dmq4:APA91bGefqItTFWPZN6Hn9NVOCDXesgW8WiTHaQwCGnDVOPemT8RWJVWuLyI7UPurUkzVptwbwwyaM0wNVt0CfWFRA9i1q2cxCERycGDiRSPW9WKJIHtLweZ1vBBqR148dyxaiKrN7yG');
*/
//$SendNotif->sendPushNotification("Survey akan di proses pada jam kerja", $Ap);
//$SendNotif->sendPushNotificationEsti("test notification bang cobra",$esti);
//$SendNotif->sendPushiOS("brobot bot bot","30bb39c7d07cbcdb69b2ecd2fd578a864b5af365e7d0834fdea10c00cd8a32ba");

/*$msg_payload = array (
        'mtitle' => 'Casandra',
        'mdesc' => 'Percobaan',
    );
$deviceToken = '436541f09465a208cd21105754ecb85f6795821d1fbe80470eaea84366d83d4c';

$query=$SendNotif->sendPushiOS("percobaan ke 2",$deviceToken);
echo $query;
$sms->sendSms('6285692554749','Agent survey kami sudah sampai di lokasi anda');*/

// Provide the Host Information.
//$tHost = 'gateway.sandbox.push.apple.com';

?>