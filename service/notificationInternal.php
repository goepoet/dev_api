<?php
include '../service/MainFrame.php';
$SendNotif=new PushNotif;
$Cass_Gcm=new Cass_Gcm;
$Survey_request=new Cass_survey_request;
$sms=new Sms;
$menuPreviledge=new MST_MENU_PRIVILEDGE;

$branch_id=$_REQUEST['branch'];
//$usernya=$_REQUEST['usernya'];
$pesan=$_REQUEST['message'];//message yang ada di push notifnya
$divisi=$_REQUEST['divisi']; // menntukan push notif buat siapa di kirim 1 buat estimator 2 buat surveyor
$user=$_REQUEST['user_id'];
/*
    $menuPreviledge->select("where branch='$branch_id' and estimator ='Y'");
    $tampilEstimator=$menuPreviledge->tampil();
    $estimator=$tampilEstimator['ID'];
    


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
*/
if($divisi=='1')
{
    //========Cari GCM estimator======================================================
        $Cass_Gcm->gcm_internal("where branch='$branch_id' and estimator ='Y'");
        $ids = array();
        while($viewApikey=$Cass_Gcm->tampil())
        {
            if($Apikey !=""){$Apikey .=",";}    
            //$Apikey .="'".$viewApikey['device_id']."'";
            array_push($ids, "".$viewApikey['device_id']."");
        }               
    //=====================================================================     
    $SendNotif->sendPushNotificationEsti($pesan,$ids);
}else
{
    //========Cari GCM surveyor======================================================
        $Cass_Gcm->gcm_internal("where user_id='$user'");
       
        $ids = array();
        while($viewApikey=$Cass_Gcm->tampil())
        {
            if($Apikey !=""){$Apikey .=",";}    
            //$Apikey .="'".$viewApikey['device_id']."'";
            array_push($ids, "".$viewApikey['device_id']."");
        }  
  
    //=====================================================================     
    $SendNotif->sendPushNotificationSurveyor($pesan,$ids);
}        
?>