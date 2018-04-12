<?php
	include_once 'app/global.php';

	//	Header
	$page_title = "User Management";
	include_once '../header.php';

	if (!isset($_SESSION['email'])) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
?>
	<h1><?=$page_title?></h1>
<?php
		// Logic
		include_once '../app/user-management.php';
		
		// HTML
		// If on the individual page
		if ($is_individual) {
		?>
			<a href="?">Back</a>
		<?php
		}
		if (sizeof($results) > 1) {
		?>
			<table>
				<thead>
					<tr>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Email</th>
						<th>Skills</th>
						<th>Emergency Contact #</th>
						<th>Interests</th>
						<th>Availability</th>
						<th>Find Out About Us</th>
						<th>Include Email Distribution</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($results as $volunteer) {
					?>
					<tr>
						<td><?=$volunteer["first_name"]?></td>
						<td><?=$volunteer["last_name"]?></td>
						<td><a href="?email=<?=$volunteer["email"]?>"><?=$volunteer["email"]?></a></td>
						<td><?=$volunteer["skills"]?></td>
						<td><?=$volunteer["emergency_contact_phone"]?></td>
						<td><?=$volunteer["interests"]?></td>
						<td><?=$volunteer["availability"]?></td>
						<td><?=$volunteer["find_out_about_us"]?></td>
						<td><?=$volunteer["include_email_dist"]?></td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		<?php
		} elseif (sizeof($results) == 1)  {
			$volunteer = $results[0];
			?>
				<form id="volunteer-management-form">
					<h3>Volunteer Fields</h3>
					<ul>
						<li><?=$volunteer["id"]?></li>
						<li><?=$volunteer["first_name"]?></li>
						<li><?=$volunteer["last_name"]?></li>
						<li><a href="?email=<?=$volunteer["email"]?>"><?=$volunteer["email"]?></a></li>
						<li><?=$volunteer["skills"]?></li>
						<li><?=$volunteer["emergency_contact_phone"]?></li>
						<li><?=$volunteer["interests"]?></li>
						<li><?=$volunteer["availability"]?></li>
						<li><?=$volunteer["find_out_about_us"]?></li>
						<li><?=$volunteer["include_email_dist"]?></li>
					</ul>
					<h3>Volunteer Time Periods</h3>
					<?php
						if (sizeof($vol_periods) > 0) {
							?><ul><?php
							foreach ($vol_periods as $vol_period) {
								// QUERY JOB AND LOCATION
						
							?>
								<li>ID: <?=$vol_period["id"]?>: <?=$vol_period["check_in_time"]?> - <?=$vol_period["check_out_time"]?> = <?=$vol_period["hours"]?> 
									| <?=$vol_period["first_time"]?>
									| <?=$vol_period["health_release"]?>
									| <?=$vol_period["check_in_time"]?>
									| <select>
										<option value="">Please Select A Task</option>
										<?php
											foreach ($type_results as $row) {
												$selected = "";
												if ($row['id'] == $vol_period["job_type_id"]) {
													$selected = "selected='selected'";
												}
												?>
													<option value="<?=$row['id']?>" <?=$selected?>><?=$row['job_type']?></option>
												<?php
											}
										?>
									</select>
									| <select>
										<option value="">Please Choose A Location</option>
										<?php
											foreach ($location_results as $row) {
												$selected = "";
												if ($row['id'] == $vol_period["location_id"]) {
													$selected = "selected='selected'";
												}
												?>
													<option value="<?=$row['id']?>" <?=$selected?>><?=$row['location_name']?></option>
												<?php
											}
										?>
									</select>
									| <?=$vol_period["community_service_hours"]?>
								</li>
							<?php
							}
							?></ul><?php
						}
					?>
				</form>
			<?php
		}
	}
	include_once '../footer.php';
?>
	
