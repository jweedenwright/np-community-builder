<?php	
	// Setup Globals
	include_once 'global.php';

	// Check for Filter Posts and grab to change queries	
	$task_filter = (isset($_POST['task']) && $_POST['task'] != "") ? filter_var ( $_POST['task'], FILTER_SANITIZE_STRING) : "";
	$location_filter = (isset($_POST['location']) && $_POST['location'] != "") ? filter_var ( $_POST['location'], FILTER_SANITIZE_STRING) : "";
	$start_date_parsed = (isset($_POST['starttime']) && $_POST['starttime'] != "") ? date_parse_from_format ( $ui_date_format, filter_var ( $_POST['starttime'], FILTER_SANITIZE_STRING)) : "";
	if ($start_date_parsed != "") {
		$start_filter = $start_date_parsed["year"] . "-" . $start_date_parsed["month"] . "-" . $start_date_parsed["day"] 
						. " " . $start_date_parsed["hour"] . ":" . $start_date_parsed["minute"] .":00";	
	} else {
		$start_filter = "";
	}
	$end_date_parsed = (isset($_POST['endtime']) && $_POST['endtime'] != "") ? date_parse_from_format ( $ui_date_format, filter_var ( $_POST['endtime'], FILTER_SANITIZE_STRING)) : "";
	if ($end_date_parsed != "") {
		$end_filter = $end_date_parsed["year"] . "-" . $end_date_parsed["month"] . "-" . $end_date_parsed["day"] 
						. " " . $end_date_parsed["hour"] . ":" . $end_date_parsed["minute"] .":00";
	} else {
		$end_filter = "";
	}

	// Setup query - Task Filter
	$filter_query = ($task_filter != "") ? " where jt.id = '".$task_filter."'" : "";
	// Setup query - Location Filter
	if ($filter_query != "") {
		$filter_query = ($location_filter != "") ? $filter_query." and l.id = '".$location_filter."'" : $filter_query;
	} else {
		$filter_query = ($location_filter != "") ? " where l.id = '".$location_filter."'" : "";
	}
	// Setup query - start date
	if ($filter_query != "") {
		$filter_query = ($start_filter != "") ? $filter_query." and vp.check_in_time > '".$start_filter."'" : $filter_query;
	} else {
		$filter_query = ($start_filter != "") ? " where vp.check_in_time > '".$start_filter."'" : "";
	}
	// Setup query - end date
	if ($filter_query != "") {
		$filter_query = ($end_filter != "") ? $filter_query." and vp.check_in_time < '".$end_filter."'" : $filter_query;
	} else {
		$filter_query = ($end_filter != "") ? " where vp.check_in_time < '".$end_filter."'" : "";
	}
	
	// Check for which set of charts to show
	$chart_filter = "";
	if (isset($_GET['chart-filter'])) {
		 $chart_filter = filter_var ( $_GET['chart-filter'], FILTER_SANITIZE_STRING);
	 }

	// Get All Users
	$all_users = "SELECT COUNT(DISTINCT(v.id)) as 'userCount' FROM volunteer v
					JOIN volunteer_period vp on vp.volunteer_id = v.id
					JOIN job_type jt on jt.id = vp.job_type_id
					JOIN location l on l.id = vp.location_id"
					.$filter_query;

	$volunteer_results = $db->executeStatement($all_users,[])->fetchAll();

	// Get All Volunteer Visits and Volunteer Hours
	$all_periods = "SELECT count(vp.id) as 'volVisits', sum(vp.hours) as 'volHours' FROM volunteer_period vp
					JOIN job_type jt on jt.id = vp.job_type_id
					JOIN location l on l.id = vp.location_id"
					.$filter_query;
	$vol_periods = $db->executeStatement($all_periods,[])->fetchAll();

	// Get locations
	$query_string = "SELECT id, location_name
						FROM location
						WHERE internal = 0
						ORDER BY location_name";			
	$location_results = $db->executeStatement($query_string,[])->fetchAll();

	// Get Job Types
	$query_string = "SELECT id, job_type
						FROM job_type
						ORDER BY job_type";
	$type_results = $db->executeStatement($query_string,[])->fetchAll();

	// Get Volunteer Data for Full List
	$volunteer_query = "SELECT v.email as 'email', concat(concat(v.first_name, ' '), v.last_name) as 'name', sum(vp.hours) as 'hours', count(vp.id) as 'num',  MIN(check_in_time) as 'first', MAX(check_in_time) as 'latest'
						FROM volunteer_period vp
						JOIN volunteer v on v.id = vp.volunteer_id
						JOIN job_type jt on jt.id = vp.job_type_id
						JOIN location l on l.id = vp.location_id"
						.$filter_query
						. " GROUP BY v.email, v.first_name, v.last_name ORDER BY hours desc";

	// Chart values for % of visits by location and job type
	$location_query = "";
	$job_type_query = "";
	if ($chart_filter == "visits") {
		$location_query = "SELECT CONVERT(DECIMAL(10,2),((count(vp.location_id)/1.0) / (select count(location_id) from volunteer_period) * 100)) as 'percent', vp.location_id as 'id', l.location_name as 'name'
							FROM volunteer_period vp
							JOIN location l on l.id = vp.location_id
							JOIN job_type jt on jt.id = vp.job_type_id"
							.$filter_query
							. " GROUP BY vp.location_id, l.location_name ORDER BY 'percent' desc";
		$job_type_query = "SELECT CONVERT(DECIMAL(10,2),((count(vp.job_type_id)/1.0) / (select count(job_type_id) from volunteer_period) * 100)) as 'percent', vp.job_type_id as 'id', jt.job_type as 'name'
							FROM volunteer_period vp
							JOIN location l on l.id = vp.location_id
							JOIN job_type jt on jt.id = vp.job_type_id"
							.$filter_query
							. " GROUP BY vp.job_type_id, jt.job_type ORDER BY 'percent' desc";

	// DEFAULT - Chart values for % of hours by location and job type
	} else {
		$location_query = "SELECT CONVERT(DECIMAL(10,2),(sum(vp.hours) / (select sum(hours) from volunteer_period) * 100)) as 'percent', vp.location_id as 'id', l.location_name as 'name'
							FROM volunteer_period vp
							JOIN location l on l.id = vp.location_id
							JOIN job_type jt on jt.id = vp.job_type_id"
							.$filter_query
							. " GROUP BY vp.location_id, l.location_name ORDER BY 'percent' desc";
		$job_type_query = "SELECT CONVERT(DECIMAL(10,2),(sum(vp.hours) / (select sum(hours) from volunteer_period) * 100)) as 'percent', vp.job_type_id as 'id', jt.job_type as 'name'
							FROM volunteer_period vp
							JOIN location l on l.id = vp.location_id
							JOIN job_type jt on jt.id = vp.job_type_id"
							.$filter_query
							. " GROUP BY vp.job_type_id, jt.job_type ORDER BY 'percent' desc";
	}

	// Get Chart Values
	$location_percentages = $db->executeStatement($location_query,[])->fetchAll();
	$job_type_percentages = $db->executeStatement($job_type_query,[])->fetchAll();
	$volunteer_query_results = $db->executeStatement($volunteer_query,[])->fetchAll();
?>