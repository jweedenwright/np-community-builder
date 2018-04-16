<?php	
	// Setup Globals
	include_once 'global.php';

	// Check for arguments
	$chart_filter = "";
	if (isset($_GET['chart-filter'])) {
		 $chart_filter = filter_var ( $_GET['chart-filter'], FILTER_SANITIZE_STRING);
	 }
		
	// Get All Users
	$all_users = "SELECT * FROM volunteer";
	$volunteer_results = $db->executeStatement($all_users,[])->fetchAll();
	
	// Get All Volunteer Visits
	$all_periods = "SELECT * FROM volunteer_period";
	$vol_periods = $db->executeStatement($all_periods,[])->fetchAll();
		
	// Get All Volunteer hours
	$all_hours = "SELECT hours FROM volunteer_period";
	$vol_hours = $db->executeStatement($all_hours,[])->fetchAll();

	// Get the values for the charts
	if ($chart_filter != "") {
		
	} else {
		// Pie chart of all locations/tasks with % of hours worked at each location/task
		
	}

?>