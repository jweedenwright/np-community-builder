<?php	
	// Setup Globals
	include_once 'global.php';
	$all_mts = "SELECT * FROM measure_type";
	$all_mt_results = $db->executeStatement($all_mts,[])->fetchAll();

	$all_mcs = "SELECT * FROM metric_category";
	$all_mc_results = $db->executeStatement($all_mcs,[])->fetchAll();

	$all_metrics = "SELECT * FROM metric";
	$all_metric_results = $db->executeStatement($all_metrics,[])->fetchAll();
?>