<?php	
	// Setup Globals
	include_once 'global.php';
	if (!isset($_SESSION['email'])) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
		// Get All Users
		$all_users = "SELECT COUNT(DISTINCT(v.id)) as 'userCount' FROM volunteer v";
		$volunteer_results = $db->executeStatement($all_users,[])->fetchAll();

		//Get All Volunteer Data
		
		$query_string = "SELECT *
							FROM volunteer v
							JOIN volunteer_period vp on vp.volunteer_id = v.id
							ORDER BY vp.check_in_time";		
		$vol_periods = $db->executeStatement($query_string,[])->fetchAll();

		$query_string = "SELECT id, location_name
							FROM location
							ORDER BY location_name";			
		$location_results = $db->executeStatement($query_string,[])->fetchAll();

		$query_string = "SELECT id, job_type
							FROM job_type
							ORDER BY job_type";
		$type_results = $db->executeStatement($query_string,[])->fetchAll();
	}
?>