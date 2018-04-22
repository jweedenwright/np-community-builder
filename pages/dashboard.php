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
	<h1>Staff Dashboard</h1>
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
				<th class="text-center">Total Hours</th><th class="text-center">Count</th><th>Last Visit</th><th>First Visit</th><th>Name</th><th>Email</th>
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
				<td><?=$latest_date['month']."/".$latest_date['day']."/".$latest_date['year']?></td>
				<td><?=$first_date['month']."/".$first_date['day']."/".$first_date['year']?></td>
				<td><?=$result['name'] ?></td>
				<td><a href="/pages/manage-volunteers.php?email=<?= $result['email'] ?>"><?= $result['email'] ?></a></td>
			</tr>
		<?php
			}
		?>
		</tbody>
	</table>	
	<div class="pagination"></div>
</div>
<?php
	}
	include_once '../footer.php';
?>