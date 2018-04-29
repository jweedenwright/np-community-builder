<?php	
	// Setup Globals
	include_once 'global.php';
	$all_mts = "SELECT * FROM measure_type ORDER BY id";
	$all_mt_results = $db->executeStatement($all_mts,[])->fetchAll();

	$all_mcs = "SELECT * FROM metric_category ORDER BY id";
	$all_mc_results = $db->executeStatement($all_mcs,[])->fetchAll();

	$all_metrics = "SELECT m.id as 'id', m.metric_name as 'metric_name', 
						mc.metric_category as 'metric_category', mc.id as 'mc_id',
						mt.measure_type as 'measure_type', mt.id as 'mt_id'
					FROM metric m
					JOIN metric_category mc on mc.id = m.metric_category_id
					JOIN measure_type mt on mt.id = m.measure_type_id
					ORDER BY id";
	$all_metric_results = $db->executeStatement($all_metrics,[])->fetchAll();
?>