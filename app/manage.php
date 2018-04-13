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
			if ($manage_type == "volunteer") {
				
			} elseif ($manage_type == "volunteer-period") {
				// Make sure we have required values
				if(!isset($_POST['vol-id'])) {
					$return_message = "<p class='alert alert-danger'>Volunteer period id was not provided. <span class='hidden'>ERROR: Missing field</span></p>";
				} elseif(!isset($_POST['signin-datetime'])) {
					$return_message = "<p class='alert alert-danger'>Sign in time was not provided. <span class='hidden'>ERROR: Missing field</span></p>";
				} elseif(!isset($_POST['signout-datetime'])) {
					$return_message = "<p class='alert alert-danger'>Sign out time was not provided. <span class='hidden'>ERROR: Missing field</span></p>";
				} elseif(!isset($_POST['location-id'])) {
					$return_message = "<p class='alert alert-danger'>Location id was not provided. <span class='hidden'>ERROR: Missing field</span></p>";
				} elseif(!isset($_POST['task-id'])) {
					$return_message = "<p class='alert alert-danger'>Task id was not provided. <span class='hidden'>ERROR: Missing field</span></p>";
				} elseif(!isset($_POST['organization'])) {
					$return_message = "<p class='alert alert-danger'>Organization was not provided. <span class='hidden'>ERROR: Missing field</span></p>";
				} else {
					// Sanitize Strings
					$vol_period_id = filter_var ( $_POST['vol-id'], FILTER_SANITIZE_STRING);
					$signin_datetime = filter_var ( $_POST['signin-datetime'], FILTER_SANITIZE_STRING);
					$signout_datetime = filter_var ( $_POST['signout-datetime'], FILTER_SANITIZE_STRING);
					$location_id = filter_var ( $_POST['location-id'], FILTER_SANITIZE_STRING);
					$task_id = filter_var ( $_POST['task-id'], FILTER_SANITIZE_STRING);
					$organization = filter_var ( $_POST['organization'], FILTER_SANITIZE_STRING);					
					
					// Format Dates
					$signin_date = date_parse_from_format ( $ui_date_format , $signin_datetime );
					$sign_in_time = $signin_date["year"] . "-" . $signin_date["month"] . "-" . $signin_date["day"] 
										. " " . $signin_date["hour"] . ":" . $signin_date["minute"] .":00";
					$signout_date = date_parse_from_format ( $ui_date_format , $signout_datetime );
					$sign_out_time = $signout_date["year"] . "-" . $signout_date["month"] . "-" . $signout_date["day"] 
										. " " . $signout_date["hour"] . ":" . $signout_date["minute"] .":00";

					// Update value in volunteer period
					$hours = calculateHours($sign_in_time, $sign_out_time);
					if ($hours < 0) {						
						?><p class='alert alert-danger'>For the date <?= $sign_out_time ?>, it looks like you didn't sign out after your <?= $sign_in_time ?> sign in.  We need  you to sign out of that day after the sign in time. Thanks!. <span class='hidden'>ERROR: Signing out on a day where they did not sign in.</span></p><?php 						
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
							$return_message = "<p>Successfully Updated Volunteer Period!</p><span class='hidden'>SUCCESS</p>";
						} else {
							// Failure
							$return_message = "<p class='alert alert-danger'>Sorry! Was unable to update the volunteer period. <span class='hidden'>ERROR: <?= $db->errorInfo() ?> </span></p>";
						}
					}
				}
			} else {
				$return_message = "<p class='alert alert-danger'>Sorry! You requested an unsupported action.  <span class='hidden'>ERROR: Type passed in POST did not match a supported type. Type was: <?=$manage_type?>.</span></p>";
			}
		} else {
			$return_message = "<p class='alert alert-danger'>Sorry! There was an issue with the action you attempted to take.  <span class='hidden'>ERROR: Did not pass type in POST to signal type of update.</span></p>";
		}	
		header("Location: " . $referring_url . "&message=".$return_message);
	}
?>