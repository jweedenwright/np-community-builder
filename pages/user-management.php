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
				<div class="pull-right">
					<a href="#" class="edit-details-btn" data-toggle="modal" data-target="#edit-details" onclick="return false;">
						<span>Edit</span>
					</a>
				</div>

				<h2 style="color: #00008B;"><?=$volunteer["first_name"]?> <?=$volunteer["last_name"]?></h2>
				<p>Email Address - <?=$volunteer["email"]?></p>
				<p>Emergency Contact - <?=$volunteer["emergency_contact_phone"]?></p>
				<p>Skills - <?=$volunteer["skills"]?></p>
				<p>Interests - <?=$volunteer["interests"]?></p>
				<p>Availability - <?=$volunteer["availability"]?></p>
				<p>How did you find out about us - <?=$volunteer["find_out_about_us"]?></p>

				<?php
					$email_dist = 'Yes';

					if($volunteer["include_email_dist"] == 0){
						$email_dist = 'No';
					}

					$volunteer_time = $vol_periods[0];
					$vol_start_date = date_parse_from_format ( $sql_date_format , $volunteer_time["check_in_time"]);
					$date1 = $vol_start_date["month"] . "-" . $vol_start_date["day"] . "-" . $vol_start_date["year"];
					$current_date = date("m-d-Y");
					//$vol_duration = date_diff($current_date, $date1);
				?>

				<p>Email Distribution - <?=$email_dist?></p>
				<p>Volunteer for <?=$vol_duration?></p>

				<?php
					$total_visits = sizeof($vol_periods);

					if ($total_visits > 0) {
						$total_time = 0;

						foreach ($vol_periods as $vol_period) {
							$total_time = $total_time + $vol_period["hours"];
						}
					}
				?>
				
				<p>Activity <?=$total_time?> hours and <?=$total_visits?> visits</p>
				
				<!-- Retrieve volunteer periods -->
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
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
						if (sizeof($vol_periods) > 0) {
							?>
							<?php
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
						<td>
							<a href="#" class="edit-period" data-id="<?=$vol_period["id"]?>" data-signin="<?=$vol_period["check_in_time"]?>" data-signout="<?=$vol_period["check_out_time"]?>" data-activity="<?=$vol_period["job_type_id"]?>" data-location="<?=$vol_period["location_id"]?>" data-org="<?=$vol_period["affiliation"]?>" data-toggle="modal" data-target="#edit-modal" onclick="editPeriod(this); return false;">
									<i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>
									<span class="sr-only">Edit</span>
							</a>
						</td>
						</tr>
							<?php
							}
							?>
							<?php
						}
					?>
				</tbody>
				</table>
				</div>
				</form>

				<!-- Volunteer Details Modal -->
				<div class="modal fade" id="edit-details" tabindex="-1" role="dialog" aria-labelledby="edit-label">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="edit-label">Edit Volunteer Details</h4>
							</div>
							<div class="modal-body">
								<form id="edit-details-form" method="POST" action="../app/manage.php">
									<input type="hidden" id="vol-id" name="vol-id" value="<?=$volunteer["id"]?>">
									<input type="hidden" id="type" name="type" value="volunteer">

									<div class="form-group">
										<label for="fn">First Name</label>
										<input class="form-control" type="text" id="fn" name="fn" value="<?=$volunteer["first_name"]?>">
									</div>
									<div class="form-group">
										<label for="ln">Last Name</label>
										<input class="form-control" type="text" id="ln" name="ln" value="<?=$volunteer["last_name"]?>">
									</div>
									<div class="form-group">
										<label for="email">Email Address</label>
										<input class="form-control" type="text" id="email" name="email" value="<?=$volunteer["email"]?>">
									</div>
									<div class="form-group">
										<label for="phone">Emergency Contact Number</label>
										<input class="form-control" type="text" id="phone" name="phone" value="<?=$volunteer["emergency_contact_phone"]?>">
									</div>
									<div class="form-group">
										<label for="skills">Skills</label>
										<input class="form-control" type="text" id="skills" name="skills" value="<?=$volunteer["skills"]?>">
									</div>
									<div class="form-group">
										<label for="interests">Interests</label>
										<input class="form-control" type="text" id="interests" name="interests" value="<?=$volunteer["interests"]?>">
									</div>
									<div class="form-group">
										<label for="availability">Availability</label>
										<input class="form-control" type="text" id="availability" name="availability" value="<?=$volunteer["availability"]?>">
									</div>
									<div class="form-group">
										<label for="email_dist">Include me in the email distribution</label>
										<input class="block" type="checkBox" id="email_dist" name="email_dist" value="<?=$volunteer["include_email_dist"]?>">
									</div>
									<button type="submit" class="btn btn-success">Save changes</button>
								</form>
							</div><!-- /modal-body -->
						</div><!-- /modal-content -->
					</div><!-- /modal-dialog -->
				</div><!-- /modal -->

				<!-- Volunteer Period Modal -->
				<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-label">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="edit-label">Edit Period</h4>
							</div>
							<div class="modal-body">
								<form id="edit-period-form" method="POST" action="../app/manage.php">
									<input type="hidden" id="vol-period-id" name="vol-period-id" value="">
									<input type="hidden" id="type" name="type" value="volunteer-period">

									<div class="form-group">
										<label for="datetime-picker">Sign In</label>
										<input type='text' class="form-control datetime-picker" id="signin-datetime-picker" data-format="yyyy-MM-dd hh:mm:00" name="signintime" placeholder="MM/DD/YYYY 12:01 AM" />
									</div>
									<div class="form-group">
										<label for="datetime-picker">Sign Out</label>
										<input type='text' class="form-control datetime-picker" id="signout-datetime-picker" data-format="yyyy-MM-dd hh:mm:00" name="signouttime" placeholder="MM/DD/YYYY 12:01 AM" />
									</div>
									<div class="form-group">
										<label for="activity">Activity</label>
										<select required class="form-control" id="task" name="task">
											<option disabled selected="true" value="">Please Select A Task</option>
											<?php
												foreach ($type_results as $row) {
													?>
														<option value="<?=$row['id']?>"><?=$row['job_type']?></option>
													<?php
												}
											?>
										</select>
									</div>
									<div class="form-group">
										<label for="location">Location</label>
										<select required class="form-control" id="location" name="location">
											<option disabled selected="true" value="">Please Choose A Location</option>
											<?php
												foreach ($location_results as $row) {
													?>
														<option value="<?=$row['id']?>"><?=$row['location_name']?></option>
													<?php
												}
											?>
										</select>
									</div>
									<div class="form-group">
										<label for="organization">Affiliation</label>
										<input class="form-control" type="text" id="organization" name="organization" value="">
									</div>
									<button type="submit" class="btn btn-success">Save changes</button>
								</form>
							</div><!-- /modal-body -->
						</div><!-- /modal-content -->
					</div><!-- /modal-dialog -->
				</div><!-- /modal -->

			<?php
		}
	}
	include_once '../footer.php';
?>