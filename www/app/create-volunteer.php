<?php
// Logic for ALL Management Pages
include_once 'global.php';
if (!isLoggedIn()) {
    //	Session variable not set - redirect to login
    header("Location: " . $login_url);
} else {
    //////////////////////
    // Manage Page for Staff
    // - Forms POST to this page
    //////////////////////

    // Error display
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $return_message = "";

    // Mark: CREATE VOLUNTEER
    // Make sure we have required values for a VOLUNTEER update
    if(!isset($_POST['fn'])) {
        $return_message = "Must provide first name for volunteer.";
    } elseif(!isset($_POST['ln'])) {
        $return_message = "Must provide last name for volunteer.";
    } elseif(!isset($_POST['middle_name'])) {
        $return_message = "Must provide middle name for volunteer.";
    } elseif(!isset($_POST['email'])) {
        $return_message = "Must provide email for volunteer.";
    } elseif(!isset($_POST['dob'])) {
        $return_message = "Must provide dob for volunteer.";
    } elseif(!isset($_POST['suffix'])) {
        $return_message = "Must provide suffix for volunteer.";
    } elseif(!isset($_POST['phone'])) {
        $return_message = "Must provide phone for volunteer.";
    } else
    // Sanitize Strings
    $vol_fn = filter_var ( $_POST['fn'], FILTER_SANITIZE_STRING);
    $vol_ln = filter_var ( $_POST['ln'], FILTER_SANITIZE_STRING);
    $vol_email = filter_var ( $_POST['email'], FILTER_SANITIZE_STRING);
    $vol_phone = filter_var ( $_POST['phone'], FILTER_SANITIZE_STRING);
    $vol_dob = filter_var($_POST['dob'], FILTER_SANITIZE_STRING);
    $formatted_dob = date('Y-m-d', strtotime($vol_dob));
    echo($formatted_dob);
    $vol_dob_array = explode("/", $vol_dob);
    $vol_dob_formatted = "${vol_dob_array[2]}-${vol_dob_array[0]}-${vol_dob_array[1]}";
    $vol_dob = str_replace("/", "", $vol_dob);

    $vol_middle_name = filter_var ( $_POST['middle_name'], FILTER_SANITIZE_STRING);
    $vol_suffix = filter_var ( $_POST['suffix'], FILTER_SANITIZE_STRING);

    // Update String Query
    $insert_string = "INSERT INTO volunteer (email, first_name, last_name, dob, middle_name, suffix, phone)
                                VALUES (email = '".$vol_email."'
                                    ,first_name = '".$vol_fn."'
                                    ,last_name = '".$vol_ln."'
                                    ,dob = '".$formatted_dob."'
                                    ,middle_name = '".$vol_middle_name."'
                                    ,suffix = '".$vol_suffix."'
                                    ,phone = '".$vol_phone."')";

    echo($insert_string);
//    die();

    $createFailed = false;
    if ($db->executeStatement($insert_string,[])) {
        // Success
        echo('inserted successfully');
        $return_message = "Successfully Created Volunteer!";
    } else {
        // Failure
        $return_message = "Sorry! Was unable to create the volunteer.";
        $createFailed = true;
    }

    if (!$createFailed) {
        // get volunteer id
        $volunteer_id_query = "SELECT id FROM volunteer WHERE email = ?";
        $results = $db->executeStatement($volunteer_id_query, array($vol_email))->fetchAll();
        if (isset($results[0])) {
            $vol_id = $results[0]['id'];
        }

        $volunteerUpdated = false;
        $update_string = "UPDATE volunteer
                            SET ";
        // Optional fields
//        if(isset($_POST['phone'])) {
//            $vol_phone = filter_var ( $_POST['phone'], FILTER_SANITIZE_STRING);
//            $update_string = $update_string . "emergency_contact_phone = '".$vol_phone."',";
//            $volunteerUpdated = true;
//        }
        if(isset($_POST['skills'])) {
            $vol_skills = filter_var ( $_POST['skills'], FILTER_SANITIZE_STRING);
            $update_string = $update_string . "skills = '".$vol_skills."',";
            $volunteerUpdated = true;
        }
        if(isset($_POST['interests'])) {
            $vol_interests = filter_var ( $_POST['interests'], FILTER_SANITIZE_STRING);
            $update_string = $update_string . "interests = '".$vol_interests."',";
            $volunteerUpdated = true;
        }
        if(isset($_POST['availability'])) {
            $availability = filter_var ( $_POST['availability'], FILTER_SANITIZE_STRING);
            $update_string = $update_string . "availability = '".$availability."',";
            $volunteerUpdated = true;
        }
        if(isset($_POST['find_out_about_us'])) {
            $vol_find_out_about_us = filter_var ( $_POST['find_out_about_us'], FILTER_SANITIZE_STRING);
            $update_string = $update_string . "find_out_about_us = '".$vol_find_out_about_us."',";
            $volunteerUpdated = true;
        }
        if(isset($_POST['email_dist'])) {
            $email_dist = filter_var ( $_POST['email_dist'], FILTER_SANITIZE_STRING);
            $update_string = $update_string . "email_dist = '".$email_dist."',";
            $volunteerUpdated = true;
        }

        $update_string = substr($update_string, 0, -1); // remove extra comma
        $update_string = $update_string . "WHERE id = ".$vol_id;

        // update address fields
        $addressUpdated = false;
        $update_address_string = "UPDATE address
                                            SET ";
        if(isset($_POST['street_one'])) {
            $vol_street_one = filter_var ( $_POST['street_one'], FILTER_SANITIZE_STRING);
            $update_address_string = $update_address_string . "street_one = '".$vol_street_one."',";
            $addressUpdated = true;
        }
        if(isset($_POST['street_two'])) {
            $vol_street_two = filter_var ( $_POST['street_two'], FILTER_SANITIZE_STRING);
            $update_address_string = $update_address_string . "street_two = '".$vol_street_two."',";
            $addressUpdated = true;
        }
        if(isset($_POST['city'])) {
            $vol_city = filter_var ( $_POST['city'], FILTER_SANITIZE_STRING);
            $update_address_string = $update_address_string . "city = '".$vol_city."',";
            $addressUpdated = true;
        }
        if(isset($_POST['state'])) {
            $vol_state = filter_var ( $_POST['state'], FILTER_SANITIZE_STRING);
            $update_address_string = $update_address_string . "state = '".$vol_state."',";
            $addressUpdated = true;
        }
        if(isset($_POST['zip'])) {
            $vol_zip = filter_var ( $_POST['zip'], FILTER_SANITIZE_STRING);
            $update_address_string = $update_address_string . "zip = '".$vol_zip."',";
            $addressUpdated = true;
        }
        $update_address_string = substr($update_address_string, 0, -1); // remove extra comma
        $update_address_string = $update_address_string . " WHERE volunteer_id = ".$vol_id;

        // update emergency contact fields
        $ecUpdated = false;
        $update_ec_string = "UPDATE emergency_contact
                                                SET ";
        if(isset($_POST['ec_first_name'])) {
            $ec_first_name = filter_var ( $_POST['ec_first_name'], FILTER_SANITIZE_STRING);
            $update_ec_string = $update_ec_string . "first_name = '".$ec_first_name."',";
            $ecUpdated = true;
        }
        if(isset($_POST['ec_last_name'])) {
            $ec_last_name = filter_var ( $_POST['ec_last_name'], FILTER_SANITIZE_STRING);
            $update_ec_string = $update_ec_string . "last_name = '".$ec_last_name."',";
            $ecUpdated = true;
        }
        if(isset($_POST['ec_phone'])) {
            $ec_phone = filter_var ( $_POST['ec_phone'], FILTER_SANITIZE_STRING);
            $update_ec_string = $update_ec_string . "phone = '".$ec_phone."',";
            $ecUpdated = true;
        }
        $update_ec_string = substr($update_ec_string, 0, -1); // remove extra comma
        $update_ec_string = $update_ec_string . " WHERE volunteer_id = ".$vol_id;

        // update Volunteer table
        $updatedFailed = false;
        if ($db->executeStatement($update_string,[])) {
            if ($addressUpdated) {
                // update Address table
                if ($db->executeStatement($update_address_string,[])) {
                    if ($ecUpdated) {
                        // update Emergency Contact table
                        if ($db->executeStatement($update_ec_string,[])) {
                            $return_message = "Successfully Updated Volunteer!";
                        } else {
                            $updatedFailed = true;
                        }
                    }
                } else {
                    $updatedFailed = true;
                }
            }
        } else {
            $updatedFailed = true;
        }

        if ($updatedFailed) {
            $return_message = "Sorry! Was unable to update the volunteer.";
        }
    }
    if (strrpos($referring_url, "?")) {
        if (strrpos($referring_url, "&message=")) {
            // Message already in alert, remove and replace
            $referring_url = preg_replace('/message=.*/', "message=".$return_message, $referring_url);
            header("Location: " . $referring_url);
        } else {
            header("Location: " . $referring_url . "&message=".$return_message);
        }
    } else {
        header("Location: " . $referring_url . "?message=".$return_message);
    }
}
?>