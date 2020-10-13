<?php	
	// Setup Globals
	include_once 'global.php';

	// Get All Users
	$all_users = "SELECT COUNT(DISTINCT(v.id)) as 'userCount' FROM volunteer v";
	$volunteer_results = $db->executeStatement($all_users,[])->fetchAll();
?>