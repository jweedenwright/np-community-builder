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

	// Get Volunteer Data for list
	$volunteer_query = "select v.email as 'email', concat(concat(v.first_name, ' '), v.last_name) as 'name', sum(vp.hours) as 'hours', count(vp.id) as 'num',  MIN(check_in_time) as 'first', MAX(check_in_time) as 'latest'"
						. " from volunteer_period vp"
						. " join volunteer v on v.id = vp.volunteer_id"
						. " group by v.email, v.first_name, v.last_name"
						. " order by hours desc";

	// Chart values for % of visits by location and job type
	$location_query = "";
	$job_type_query = "";
	if ($chart_filter == "visits") {
		$location_query = "select CONVERT(DECIMAL(10,2),((count(vp.location_id)/1.0) / (select count(location_id) from volunteer_period) * 100)) as 'percent', vp.location_id as 'id', l.location_name as 'name'"
							. " from volunteer_period vp"
							. " join location l on l.id = vp.location_id"
							. " group by vp.location_id, l.location_name"
							. " order by 'percent' desc";
		$job_type_query = "select CONVERT(DECIMAL(10,2),((count(vp.job_type_id)/1.0) / (select count(job_type_id) from volunteer_period) * 100)) as 'percent', vp.job_type_id as 'id', j.job_type as 'name'"
							. " from volunteer_period vp"
							. " join job_type j on j.id = vp.job_type_id"
							. " group by vp.job_type_id, j.job_type"
							. " order by 'percent' desc";

	// DEFAULT - Chart values for % of hours by location and job type
	} else {
		$location_query = "select CONVERT(DECIMAL(10,2),(sum(vp.hours) / (select sum(hours) from volunteer_period) * 100)) as 'percent', vp.location_id as 'id', l.location_name as 'name'"
							. " from volunteer_period vp"
							. " join location l on l.id = vp.location_id"
							. " group by vp.location_id, l.location_name"
							. " order by 'percent' desc";
		$job_type_query = "select CONVERT(DECIMAL(10,2),(sum(vp.hours) / (select sum(hours) from volunteer_period) * 100)) as 'percent', vp.job_type_id as 'id', j.job_type as 'name'"
							. " from volunteer_period vp"
							. " join job_type j on j.id = vp.job_type_id"
							. " group by vp.job_type_id, j.job_type"
							. " order by 'percent' desc";
	}

	// Get Chart Values
	$location_percentages = $db->executeStatement($location_query,[])->fetchAll();
	$job_type_percentages = $db->executeStatement($job_type_query,[])->fetchAll();
	$volunteer_query_results = $db->executeStatement($volunteer_query,[])->fetchAll();
?>