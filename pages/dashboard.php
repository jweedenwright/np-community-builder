<?php
	include_once 'app/global.php';

	//	Header
	$page_title = "Dashboard";
	include_once '../header.php';
	include_once '../app/dashboard-util.php'; 

	if (!isset($_SESSION['email'])) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
?>
<div class="container">
	<h1><strong>Staff Dashboard<strong></h1>
	<div class="row">
		<div id="total-vols-display-wrapper" class="col-sm-4 stat-item text-center">
			<div id="total-vols-display" class="card boom">
				<div class="stat-label">Total Volunteers</div>
				<span class="value"><?=sizeof($volunteer_results)?></span>
			</div>
		</div>
		<div id="total-hours-display-wrapper" class="col-sm-4 stat-item text-center">
			<div id="total-hours-display" class="card boom">
				<div class="stat-label">Total Hours</div>
				<span class="value"><?=sizeof($vol_periods)?></span>
			</div>
		</div>
		<div id="total-times-display-wrapper" class="col-sm-4 stat-item text-center">
			<div id="total-times-display" class="card boom">
				<div class="stat-label">Total Visits</div>
				<span class="value"><?=count($vol_hours)?></span>
			</div>
		</div>
	</div>
	<h2>Program Stats
		<span class="program-chart-options">
			<a href="?chart-filter=hours">Hours</a>
			<a href="?chart-filter=volunteers">Volunteers</a>
			<a href="?chart-filter=visits">Visits</a>
		</span>
	</h2>
	<div class="row">
		<div id="location-stats-wrapper" class="col-sm-6 stat-item">
			<div id="location-stats" class="card">
				Pie chart of all locations with % of hours worked at each location
			</div>
		</div>
		<div id="task-stats-wrapper" class="col-sm-6 stat-item">
			<div id="task-stats" class="card">
				Pie chart of all tasks with % of hours worked at each task
			</div>
		</div>
	</div>
	
	<h2>Volunteer Data</h2>
	<table id="report-table" class="table table-condensed table-striped table-hover sortable">					
		<thead>
			<tr>
				<th>Email</th><th>Name</th><th class="text-center">Hours</th><th class="text-center">Count</th><th class="hidden">Skills</th><th  class="hidden">Emer Phone</th><th  class="hidden">Interests</th><th  class="hidden">Found Out</th><th class="hidden">Email Include</th><th class="hidden">Latest Vounteer Date</th><th class="hidden">First Volunteer Date</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$total_hours = 0;
			$total_vol_count = 0;
			//Need to find out the SQL query for results
			$total_vols = sizeOf($results);
			foreach ($results as $result) {
				$hours = $result['hours'];
				$total_hours = $total_hours + $hours;
				$vol_count = $result['vol_count'];
				$total_vol_count = $total_vol_count + $vol_count;
		?>
		<tr>
			<td><?= $result['email'] ?></td>
			<td><?=$result['last_name'] ?>, <?= $result['first_name'] ?></td>
			<td class="text-center"><?= $hours ?></td>
			<td class="text-center"><?= $vol_count ?></td>
			<td class="hidden"><?= $result['skills'] ?></td>
			<td class="hidden"><?= $result['emergency_contact_phone'] ?></td>
			<td class="hidden"><?= $result['interests'] ?></td>
			<td class="hidden"><?= $result['find_out_about_us'] ?></td>
			<td class="hidden">
		<?php
			if ($result['include_email_dist'] == "1") {
		?>
			Yes
		<?php } else { ?>
			No
		<?php 
		}
		?>
		</td>
		<!--<td class="hidden"><?= $result['latest'] ?></td>
		<td class="hidden"><?= $result['first'] ?></td> -->
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