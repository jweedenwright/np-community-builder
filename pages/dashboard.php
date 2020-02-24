<?php
	include_once '../app/global.php';

	if (!isset($_SESSION['email'])) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
		//	Header
		$page_title = "Dashboard";
		include_once '../header.php';
		include_once '../app/dashboard-util.php'; 
?>
<div class="container">
	<h1>Staff Dashboard</h1>
	<div class="row">
		<div id="filter-section" class="col-sm-12">
			<form id="data-filter" method="POST">
				<blockquote><strong>Please Note:</strong> When filtering on task or location, you will also need to select dates.</blockquote>
				<div class="form-group col-sm-3">
					<label for="datetime-picker">Start Date</label>
					<input type='text' class="form-control datetime-picker" id="start-datetime-picker" data-format="yyyy-MM-dd hh:mm:00" name="starttime" placeholder="MM/DD/YYYY 12:01 AM" />
					<input type="hidden" id="startdate-default" value="<?=$start_filter?>">
				</div>
				<div class="form-group col-sm-3">
					<label for="datetime-picker">End Date</label>
					<input type='text' class="form-control datetime-picker" id="end-datetime-picker" data-format="yyyy-MM-dd hh:mm:00" name="endtime" placeholder="MM/DD/YYYY 12:01 AM" />
					<input type="hidden" id="enddate-default" value="<?=$end_filter?>">
				</div>
				<div class="form-group col-sm-3">
					<label for="activity">Activity</label>
					<select class="form-control" id="task" name="task">
						<option selected="true" value="">Please Select A Task</option>
						<?php
							foreach ($type_results as $row) {
								?>
									<option <?php if ($task_filter == $row['id']) { echo "selected=selected"; } ?>
									 value="<?=$row['id']?>"><?=$row['job_type']?></option>
								<?php
							}
						?>
					</select>
				</div>
				<div class="form-group col-sm-3">
					<label for="location">Location</label>
					<select class="form-control" id="location" name="location">
						<option selected="true" value="">Please Choose A Location</option>
						<?php
							foreach ($location_results as $row) {
								?>
									<option <?php if ($location_filter == $row['id']) { echo "selected=selected"; } ?>
									value="<?=$row['id']?>"><?=$row['location_name']?></option>
								<?php
							}
						?>
					</select>
				</div>
				<div class="form-group col-sm-12 text-right">
					<button type="button" class="btn btn-danger pull-left" onclick="signout(); return false;">Signout All Volunteers</button>
					<div class="btn-group pull-right" role="group" aria-label="Search Actions">
						<button type="submit" class="btn btn-primary">Search</button>
						<button type="button" class="btn btn-default" onclick="getCsv();return false;">Download Volunteers</button>
						<button type="button" class="btn btn-default" onclick="getFeedbackCsv();return false;">Download Feedback</button>
						<button type="button" class="btn btn-default" onclick="resetDashboard();return false;">Reset Filters</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<h2>By the Numbers</h2>
	<div class="row">
		<div id="total-vols-display-wrapper" class="col-sm-4 stat-item text-center">
			<div id="total-vols-display" class="card boom">
				<div class="stat-label">Total Volunteers</div>
				<span class="value"><?=$volunteer_results[0]['userCount']?></span>
			</div>
		</div>
		<div id="total-hours-display-wrapper" class="col-sm-4 stat-item text-center">
			<div id="total-hours-display" class="card boom">
				<div class="stat-label">Total Hours</div>
				<span class="value"><?=$vol_periods[0]['volHours']?></span>
			</div>
		</div>
		<div id="total-times-display-wrapper" class="col-sm-4 stat-item text-center">
			<div id="total-times-display" class="card boom">
				<div class="stat-label">Total Visits</div>
				<span class="value"><?=$vol_periods[0]['volVisits']?></span>
			</div>
		</div>
	</div>
	<h2>Program Stats
		<span class="program-chart-options">
			<a href="?chart-filter=hours">Hours</a>
			<a href="?chart-filter=visits">Visits</a>
		</span>
	</h2>
	<div class="row">
		<div id="location-stats-wrapper" class="col-sm-6 stat-item">
			<div id="location-stats" class="card">
				<?php
					foreach ($location_percentages as $location_percentage) {
						echo "<input class='location-chart-metric' type='hidden' name='".$location_percentage['name']."' value='".$location_percentage['percent']."'>";
					}
				?>
				<canvas id="location-chart"></canvas>
			</div>
		</div>
		<div id="task-stats-wrapper" class="col-sm-6 stat-item">
			<div id="task-stats" class="card">
				<?php									 
					foreach ($job_type_percentages as $job_type_percentage) {
						echo "<input class='task-chart-metric' type='hidden' name='".$job_type_percentage['name']."' value='".$job_type_percentage['percent']."'>";
					}	
				?>
				<canvas id="task-chart"></canvas>
			</div>
		</div>
	</div>
	
	<h2>Volunteer Data</h2>
	<table id="report-table" class="table table-condensed table-striped table-hover sortable">
		<thead>
			<tr>
				<th class="text-center">Total Hours</th><th class="text-center">Count</th><th>First Visit</th><th>Latest Visit</th><th>Name</th><th>Email</th>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach ($volunteer_query_results as $result) {
				// format dates
				$first_date = date_parse_from_format ( $sql_date_format , $result['first']  );
				$latest_date = date_parse_from_format ( $sql_date_format , $result['latest']  );
		?>
			<tr class="paginate-row">
				<td class="text-center"><?= $result['hours'] ?></td>
				<td class="text-center"><?= $result['num'] ?></td>
				<td><?=$first_date['month']."/".$first_date['day']."/".$first_date['year']?></td>
				<td><?=$latest_date['month']."/".$latest_date['day']."/".$latest_date['year']?></td>
				<td><?=$result['name'] ?></td>
				<td><a href="/pages/manage-volunteers.php?email=<?= $result['email'] ?>"><?= $result['email'] ?></a></td>
			</tr>
		<?php
			}
		?>
		</tbody>
	</table>	
	<div class="pagination"></div>
	
	<h2>Feedback</h2>
	<table id="feedback-table" class="table table-condensed table-striped table-hover sortable">
		<thead>
			<tr>
				<th class="text-center">Check In Date</th><th>Volunteer Email</th><th>Feedback</th>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach ($feedback_query_results as $result) {
				$checkin_date = date_parse_from_format ( $sql_date_format , $result['check_in_time']  );
		?>
			<tr>
				<td class="text-center"><?=$checkin_date['month']."/".$checkin_date['day']."/".$checkin_date['year']?></td>
				<td><?= $result['email'] ?></td>
				<td><?= $result['feedback'] ?></td>
			</tr>
		<?php
			}
		?>
		</tbody>
	</table>
</div>
<?php
	}
	include_once '../footer.php';
?>