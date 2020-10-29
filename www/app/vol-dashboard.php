<?php
// Setup Globals
include_once 'global.php';
$is_individual = false;

// Individual Lookup / Manage
if (isset($_SESSION['email'])) {
    $email = filter_var($_SESSION['email'], FILTER_SANITIZE_STRING);
    $vol_query = "SELECT * FROM volunteer WHERE email = ?";
    $results = $db->executeStatement($vol_query, array($email))->fetchAll();
    $is_individual = true;

    // Get all Volunteer Periods
    $query_string = "SELECT *
							FROM volunteer v
							JOIN volunteer_period vp on vp.volunteer_id = v.id
							WHERE v.email = '" . $email . "'
							ORDER BY vp.check_in_time";
    $vol_periods = $db->executeStatement($query_string, [])->fetchAll();
    // Pull locations
    $query_string = "SELECT id, location_name
							FROM location
							ORDER BY location_name";
    $location_results = $db->executeStatement($query_string, [])->fetchAll();
    // Pull Job Types
    $query_string = "SELECT id, job_type
							FROM job_type
							ORDER BY job_type";
    $type_results = $db->executeStatement($query_string, [])->fetchAll();
}
?>