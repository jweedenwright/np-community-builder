<?php
	include_once 'global.php';
	if (!isset($_SESSION['email'])) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
		//////////////////////
		// Manage Page for Staff
		// - Forms POST to this page
		//////////////////////

		// Error display
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		$return_message = "";

		// Only process if email was passed
		if(isset($_POST['type'])) {
			$manage_type = $_POST['type'];

////////////////////////////////////////////////////				
// MANAGE VOLUNTEER

			if ($manage_type == "volunteer") {
				// Make sure we have required values for a VOLUNTEER update

////////////////////////////////////////////////////				
// MANAGE VOLUNTEER PERIOD
// - TEST: type=volunteer-period&vol-id=1&signintime=03/15/2018 1:30 PM&signouttime=03/15/2018 3:30 PM&location=7&task=1&organization=HCA

			} elseif ($manage_type == "volunteer-period") {

				// Make sure we have required values for a VOLUNTEER PERIOD UPDATE
				if(!isset($_POST['vol-id'])) {
					$return_message = "Volunteer period id was not provided.";
				} elseif(!isset($_POST['signintime'])) {
					$return_message = "Sign in time was not provided.";
				} elseif(!isset($_POST['signouttime'])) {
					$return_message = "Sign out time was not provided.";
				} elseif(!isset($_POST['location'])) {
					$return_message = "Location id was not provided.";
				} elseif(!isset($_POST['task'])) {
					$return_message = "Task id was not provided.";
				} elseif(!isset($_POST['organization'])) {
					$return_message = "Organization was not provided.";
				} else {
					// Sanitize Strings
					$vol_period_id = filter_var ( $_POST['vol-id'], FILTER_SANITIZE_STRING);
					$signin_datetime = filter_var ( $_POST['signintime'], FILTER_SANITIZE_STRING);
					$signout_datetime = filter_var ( $_POST['signouttime'], FILTER_SANITIZE_STRING);
					$location_id = filter_var ( $_POST['location'], FILTER_SANITIZE_STRING);
					$task_id = filter_var ( $_POST['task'], FILTER_SANITIZE_STRING);
					$organization = filter_var ( $_POST['organization'], FILTER_SANITIZE_STRING);					
					
					// Format Dates
					$signin_date = date_parse_from_format ( $ui_date_format , $signin_datetime );
					$sign_in_time = $signin_date["year"] . "-" . $signin_date["month"] . "-" . $signin_date["day"] 
										. " " . $signin_date["hour"] . ":" . $signin_date["minute"] .":00";
					$signout_date = date_parse_from_format ( $ui_date_format , $signout_datetime );
					$sign_out_time = $signout_date["year"] . "-" . $signout_date["month"] . "-" . $signout_date["day"] 
										. " " . $signout_date["hour"] . ":" . $signout_date["minute"] .":00";

					// Update value in volunteer period
					$hours = calculateHours($signin_date, $signout_date);
					if ($hours < 0) {						
						?>For the date <?= $sign_out_time ?>, it looks like you didn't sign out after your <?= $sign_in_time ?> sign in.  We need  you to sign out of that day after the sign in time. Thanks!. <span class='hidden'>ERROR: Signing out on a day where they did not sign in.</span></p><?php 						
					} else {
						// Update String Query
						$update_string = "UPDATE volunteer_period
											SET check_out_time = '".$sign_out_time."'
												,hours = '".$hours."'
												,check_in_time = '".$sign_in_time."'
												,affiliation = '".$organization."'
												,job_type_id = '".$task_id."'
												,location_id = '".$location_id."'
										  	WHERE id = ".$vol_period_id;
						if ($db->executeStatement($update_string,[])) {
							// Success
							$return_message = "Successfully Updated Volunteer Period!";
						} else {
							// Failure
							$return_message = "Sorry! Was unable to update the volunteer period.";
						}
					}
				}
			} else {
				$return_message = "Sorry! You requested an unsupported action/type (type requested was <?=$manage_type?>).";
			}
		} else {
			$return_message = "Sorry! There was an issue with the action/type you attempted to take.";
		}

		if (strrpos($referring_url, "?")) {
			header("Location: " . $referring_url . "&message=".$return_message);	
		} else {
			header("Location: " . $referring_url . "?message=".$return_message);			
		}

	}
?>