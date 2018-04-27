<?php	
	// Setup Globals
	include_once 'global.php';
	$all_programs = "SELECT * FROM program";
	$results = $db->executeStatement($all_programs,[])->fetchAll();
?>