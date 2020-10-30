<?php
// Setup Globals
include_once 'global.php';

// Individual Lookup / Manage
if (isLoggedIn()) {
    $email = getLoggedInUserEmail();
    $vol_query = "SELECT * FROM volunteer WHERE email = ?";
    $results = $db->executeStatement($vol_query, array($email))->fetchAll();

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

    $vol_address_query = "SELECT * FROM address WHERE address.volunteer_id = ?";
    $vol_addresses = $db->executeStatement($vol_address_query, array($results[0]['id']))->fetchAll();

    // address fields
    $street_one = '';
    $street_two = '';
    $city = '';
    $state = '';
    $zip = '';

    if (isset($vol_address_query[0])) {
        $street_one = filter_var($vol_addresses[0]['street_one'], FILTER_SANITIZE_STRING);
        $street_two = filter_var($vol_addresses[0]['street_two'], FILTER_SANITIZE_STRING);
        $city = filter_var($vol_addresses[0]['city'], FILTER_SANITIZE_STRING);
        $state = filter_var($vol_addresses[0]['state'], FILTER_SANITIZE_STRING);
        $zip = filter_var($vol_addresses[0]['zip'], FILTER_SANITIZE_STRING);
    }

    $emergency_contact_query = "SELECT * FROM emergency_contact WHERE emergency_contact.volunteer_id = ?";
    $emergency_contacts = $db->executeStatement($emergency_contact_query, array($results[0]['id']))->fetchAll();

    // emergency contact fields
    $ec_first_name = '';
    $ec_last_name = '';
    $ec_phone = '';
    
    if (isset($emergency_contacts[0])) {
        $ec_first_name = filter_var($emergency_contacts[0]['first_name'], FILTER_SANITIZE_STRING);
        $ec_last_name = filter_var($emergency_contacts[0]['last_name'], FILTER_SANITIZE_STRING);
        $ec_phone = filter_var($emergency_contacts[0]['phone'], FILTER_SANITIZE_STRING);
    }

}
?>