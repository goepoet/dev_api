<?php
	$id=$_GET['param'];
		if($id=='register')
		{
			include 'register_user.php';			
		}
		elseif($id=='register_polis')
		{
			include 'register_user_polis.php';
		}
		elseif($id=='request_survey')
		{
			include 'request_survey.php';
		}
		elseif($id=='request_road')
		{
			include 'request_road.php';
		}
		elseif($id=='request_towing')
		{
			include 'request_towing.php';
		}
		elseif($id=='show_banner')
		{
			include 'selectBanner.php';
		}
		elseif($id=='branch_list')
		{
			include 'selectBranch.php';
		}
		elseif($id=='workshop_list')
		{
			include 'selectBengkel.php';
		}
		elseif($id=='show_profile')
		{
			include 'show_profile.php';
		}
		elseif($id=='profile_update')
		{
			include 'updatePassword.php';
		}
		elseif($id=='add_policy')
		{
			include 'tambahKendaraan.php';
		}
		elseif($id=='change_schedule')
		{
			include 'changeSchedule.php';
		}
		elseif($id=='delete_policy')
		{
			include 'RemovePolicy.php';
		}
		elseif($id=='survey_detail')
		{
			include 'SurveyDetail.php';
		}
		elseif($id=='towing_detail')
		{
			include 'TowingDetail.php';
		}
		elseif($id=='towing_list')
		{
			include 'select_towing.php';
		}
		elseif($id=='road_detail')
		{
			include 'RoadDetail.php';
		}
		elseif($id=='history_list')
		{
			include 'HistoryList.php';
		}
		elseif($id=='col_list')
		{
			include 'ColList.php';
		}
		elseif($id=='road_list')
		{
			include 'RoadAsstList.php';
		}
		elseif($id=='register_gcm')
		{
			include 'RegisterGcm.php';
		}
		elseif($id=='register_gcm_internal')
		{
			include 'RegisterGcmInternal.php';
		}
		elseif($id=='register_apns')
		{
			include 'RegisterApns.php';
		}
		elseif($id=='show_notification')
		{
			include 'selectNotification.php';
		}
		elseif($id=='save_notification')
		{
			include 'saveNotification.php';
		}
		elseif($id=='read_notification')
		{
			include 'ReadNotification.php';
		}
		elseif($id=='give_rating')
		{
			include 'GiveRating.php';
		}
		elseif($id=='surveyor_list')
		{
			include 'surveyorList.php';
		}
		elseif($id=='panfic_profil')
		{
			include 'profilPanfic.php';
		}
		elseif($id=='ubah_nama')
		{
			include 'updateNama.php';
		}
		elseif($id=='decline_schedule')
		{
			include 'declineSchedule.php';
		}
		elseif($id=='update_car_number')
		{
			include 'updateNopolisi.php';
		}
		elseif($id=='update_location_agent')
		{
			include 'updateLatLonAgent.php';
		}
		elseif($id=='push_ws')
		{
			include 'notificationWorkshop.php';
		}
		elseif($id=='push_internal')
		{
			include 'notificationInternal.php';
		}
		elseif($id=='acc_claim')
		{
			include 'AccClaim.php';
		}
		elseif($id=='remind_me')
		{
			include 'remind_me.php';
		}
		elseif($id=='detail_polis')
		{
			include 'detail_polis.php';
		}
		else
		{

		}

	?>