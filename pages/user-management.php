<?php
    // Error display
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);
	include_once 'app/global.php';

	//	Header
	$page_title = "User Management";
	include_once '../header.php';

	if (!isset($_SESSION['email'])) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
?>

<?php
		// Logic
		include_once '../app/user-management.php';
		
		// HTML
		// If on the individual page
		if ($is_individual) {
		?>
			<a href="?">Back</a>
			<h1 align = "center"><font color = "#32CD32"><?=$page_title?></font></h1>
		<?php
		}
/////////////////////////////////////
// Not individual - list of volunteers page
		if (sizeof($results) > 1) {
		?>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
					    <th>ID</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($results as $volunteer) {
					?>
					<tr>
						<td><?=$volunteer["id"]?></td>
						<td><?=$volunteer["first_name"]?></td>
						<td><?=$volunteer["last_name"]?></td>
						<td><a href="?email=<?=$volunteer["email"]?>"><?=$volunteer["email"]?></a></td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>	
		<?php
/////////////////////////////////////
//  Individual - Page
		} elseif (sizeof($results) == 1)  {
			$volunteer = $results[0];
			?>
				<!--<h3>Can use the variable edit_mode (pass the value 'edit' in URL as a parameter) as a flag between edit mode and not edit mode</h3>-->
				<!--<h4>Edit Mode? <?=$edit_mode?></h4>-->
				<form id="volunteer-management-form">
					<h1><font color ="#00008B"><?=$volunteer["first_name"]?>&nbsp;<?=$volunteer["last_name"]?></font></h1>
					<div class="pull-right">
					<a href="#" class="edit-period" data-toggle="modal" data-target="#edit-modal" onclick="editDetails(this); return false;">
	                <i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>
	                <span>Edit</span></a>
					</div>
					<h4><?=$volunteer["email"]?></h4>
					<h4><?=$volunteer["emergency_contact_phone"]?></h4>
					<?php
					$volunteer_time = $vol_periods[0];
					$vol_start_date = date_parse_from_format ( $sql_date_format , $volunteer_time["check_in_time"]);
					//$monthNum  = $vol_start_date["month"];
					?>
					<h4>Volunteer since <?=$vol_start_date["month"]." ".$vol_start_date["day"]." ".$vol_start_date["year"]?></h4>
					<?php
					$total_visits = sizeof($vol_periods);
					if ($total_visits > 0) {
						$total_time = 0;
						foreach ($vol_periods as $vol_period) {
							$total_time = $total_time + $vol_period["hours"];
						}
					}
					?>
				<h4>Activity <?=$total_time?> hours and <?=$total_visits?> visits</h4>
				<div class="table-responsive">
				<table class="table table-striped">
				<thead>
					<tr>
					    <th>ID</th>
						<th>Date</th>
						<th>Time</th>
						<th>Duration</th>
						<th>Activity</th>
						<th>Location</th>
						<th>Affiliation</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if (sizeof($vol_periods) > 0) {
							?><ul><?php
							foreach ($vol_periods as $vol_period) {
								// QUERY JOB AND LOCATION
						
							?>
						<tr>
						    <td><?=$vol_period["id"]?></td>
							<?php
							$checkin_date = date_parse_from_format ( $sql_date_format , $vol_period["check_in_time"]);
							$checkedin_date = $checkin_date["month"] . "-" . $checkin_date["day"] . "-" . $checkin_date["year"]; 
							if($checkin_date["minute"] == 0)
							$checkedin_time = $checkin_date["hour"] . ":00" . ":00";
							else
							$checkedin_time = $checkin_date["hour"] . ":" . $checkin_date["minute"]. ":00";	
							?>
							<td><?=$checkedin_date?></td>
							<td><?=$checkedin_time?></td>
							<td><?=$vol_period["hours"]?></td>
						<?php
						foreach ($type_results as $job_type_row) {
							if ($job_type_row['id'] == $vol_period["job_type_id"]) {
								?>
								<td><?=$job_type_row["job_type"]?></td>
								<?php
							}
					}
						foreach ($location_results as $location_row) {
							if ($location_row['id'] == $vol_period["location_id"]) {
								?>
								<td><?=$location_row["location_name"]?></td>
								<?php
							}
					}				
					?>
						<td><?=$vol_period["affiliation"]?></td>
						</tr>
							<?php
							}
							?></ul><?php
						}
					?>
				</tbody>
				</table>
				</div>
				</form>
			<?php
		}
	}
	include_once '../footer.php';
?>
	
