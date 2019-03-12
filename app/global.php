<?php
//////////////////////
// Checkin Page for Volunteers
// - Form POSTS to this page
//////////////////////

	// Error display
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Organization Variables
	$GLOBALS['org_name'] = "The Nashville Food Project";
	$GLOBALS['org_short_name'] = "TNFP";
	$GLOBALS['org_url'] = "thenashvillefoodproject.org";
	$GLOBALS['org_address'] = "5904 California Ave";
	$GLOBALS['org_city_state'] = "Nashville, TN 37209";
	$GLOBALS['org_phone'] = "(615) 460-0172";
	$GLOBALS['org_phone_tel'] = "6154600172";
	$GLOBALS['liability_release'] = "I understand that as a volunteer for The Nashville Food Project I may be involved in physical activities that have a potential risk of injury. I assume this risk. I agree that I will perform activities that I am comfortable doing and follow instructions as provided. I hereby release and discharge The Nashville Food Project, its community service partners, officers, directors, employees,agents and volunteers from any claim, demand or cause of action that may be asserted by or on behalf of me as a result of my volunteering. I agree to be responsible for my behavior and to indemnify and hold harmless The Nashville Food Project, its community service partner, officers, directors, employees, agents and volunteers from any damages or liabilities arising out of my volunteer activities.";
	$GLOBALS['health_release'] = "I understand that I may not volunteer in The Nashville Food Project's meals program if I have experienced a fever, sore throat, vomiting, diarrhea within the last 24 hours. By checking this box I agree that I have not experienced any of these symptoms in the last 24 hours.";
	$GLOBALS['photo_release'] = "I grant The Nashville Food Project and its partners the irrevocable right to use photographs and video or audio recordings of me made while volunteering. I understand that I will not be compensated for the use of my image in any medium.";
	$GLOBALS['give_url'] = "https://thenashvillefoodproject.kindful.com/";
	$GLOBALS['give_desc'] = "And continue this important work to cultivate community<br>and alleviate hunger in our city.";
	$GLOBALS['sendgrid_api_key'] = $_SERVER['SEND_GRID_KEY'];

	// Prod Database
	$GLOBALS['prod_protocol'] = "https";
	$GLOBALS['prod_domain'] = "thenashvillefoodproject.azurewebsites.net";
	$GLOBALS['prod_db_hostname'] = "tnfp.database.windows.net";
	$GLOBALS['prod_db_port'] = "1433";
	$GLOBALS['prod_db_name'] = $_SERVER['PROD_DB_NAME'];
	$GLOBALS['prod_db_user'] = $_SERVER['PROD_DB_USER'];
	$GLOBALS['prod_db_password'] = $_SERVER['PROD_DB_PASSWORD'];
	
	// QA Database
	$GLOBALS['qa_protocol'] = "https";
	$GLOBALS['qa_domain'] = "tnfp-dev.azurewebsites.net";
	$GLOBALS['qa_db_hostname'] = "tnfp-dev.database.windows.net";
	$GLOBALS['qa_db_port'] = "1433";
	$GLOBALS['qa_db_name'] = $_SERVER['QA_DB_NAME'];
	$GLOBALS['qa_db_user'] = $_SERVER['QA_DB_USER'];
	$GLOBALS['qa_db_password'] = $_SERVER['QA_DB_PASSWORD'];

	// Dev Database
	$GLOBALS['dev_protocol'] = "https";
	$GLOBALS['dev_domain'] = "tnfp-future.azurewebsites.net";
	$GLOBALS['dev_db_hostname']= "tnfp-dev.database.windows.net";	
	$GLOBALS['dev_db_port'] = "1433";	
	$GLOBALS['dev_db_name'] = $_SERVER['DEV_DB_NAME'];
	$GLOBALS['dev_db_user'] = $_SERVER['DEV_DB_USER'];
	$GLOBALS['dev_db_password'] = $_SERVER['DEV_DB_PASSWORD'];

	// Start the session
	session_start();

	// Setup the db
	include_once 'db-util.php';
	$db = new pdo_dblib_mssql();

	// Setup email
	include_once 'email-util.php';
	$email_util = new comm_builder_send_email();

	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	
	// Retrieve all form fields in POST
	date_default_timezone_set('America/Chicago'); // Set to CST
	// Standard PHP date format
	$date_format = "m-d-Y g:i A";
	// Format for reporting page dates
	$report_date_format = "Y-m-d";
	// UI date format - 02/07/2017 6:48 PM
	$ui_date_format = "m/d/Y g:i A";
	// SQL Server Date format - 2016-11-14 14:00:00
	$sql_date_format = "Y-m-d g:i:s"; // 2016-10-13 07:00:00
	// Variables
	$root_dir = "";
	$dashboard_url = "https://".$GLOBALS['current_domain'] . $root_dir . "/pages/dashboard.php";
	$login_url = "https://".$GLOBALS['current_domain'] . $root_dir . "/pages/login.php";
	$logout_url = "https://".$GLOBALS['current_domain'] . $root_dir . "/pages/logout.php";
	$signout_url = "https://".$GLOBALS['current_domain'] . $root_dir . "/pages/sign-out.php";
	$current_url = "https://".$GLOBALS['current_domain'] . $root_dir . $_SERVER['REQUEST_URI'];
	$referring_url = "https://".$GLOBALS['current_domain'] . $root_dir . "/index.php";
	if (isset($_SERVER['HTTP_REFERER'])) {
		$referring_url = $_SERVER['HTTP_REFERER'];
	}
	$reset_url = "https://".$GLOBALS['current_domain'] . $root_dir . "/pages/reset.php";
	
	// Global Functions
	function calculateHours($in_time, $out_time) {			
		$hours = $out_time["hour"] - $in_time["hour"];
		if ($in_time["minute"] != $out_time["minute"]) {
			$minutes = (60 - $in_time["minute"]) + $out_time["minute"];
			// If the difference in minutes is negative, need to subtract 1 hour
			if ($out_time["minute"] - $in_time["minute"] < 0) {
				// Subtract an hour (less than an hour worked in minutes) 
				if ($hours > 0) {
					$hours = $hours - 1;
				}
				if ($minutes >= 30) {
					$hours = $hours + 1;
				} else if ($minutes > 0) {
					$hours = $hours + .5;
				}
			} else {
				if ($minutes >= 30) {
					$hours = $hours + .5;
				}
			}
			
		}
		return $hours;
	}
?>