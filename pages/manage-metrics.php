<?php
	// Error display
	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);
	include_once 'app/global.php';

	//	Header
	$page_title = "Metrics Management";
	include_once '../header.php';

	if (!isset($_SESSION['email'])) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
		// Logic
		include_once '../app/manage-metrics.php';
?>
		<div class="container">
			<h1>Metric Management</h1>

			<div class="card clearfix">
				<div class="col-md-5">
					<h2>Metric Categories</h2>
					<div class="form-group">
						<a href="#" class="btn btn-primary create-location" data-id="new"
													data-toggle="modal" 
													data-target="#edit-mc" 
													onclick="editMetricCategory(this); return false;">
							<span><i class="glyphicon glyphicon-plus manage-action" aria-hidden="true"></i>Add New</span>
						</a>
					</div>
					<table class="table table-striped table-responsive">
						<thead>
							<tr>
								<th>ID</th>
								<th>Category</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($all_mc_results as $mc_result) {
							?>
							<tr class="search-row">
								<td><?=$mc_result["id"]?></td>
								<td><?=$mc_result["metric_category"]?></td>
								<td>
									<a href="#" class="edit-location manage-action" data-id="<?=$mc_result["id"]?>" 
																data-name="<?=$mc_result["metric_category"]?>" 
																data-toggle="modal" 
																data-target="#edit-mc" 
																onclick="editMetricCategory(this); return false;">
											<i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>
											<span class="sr-only">Edit</span>
								</td>
							</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>

				<div class="col-md-7 clearfix">
					<h2>Measure Types</h2>
					<div class="form-group">
						<a href="#" class="btn btn-primary create-location" data-id="new"
													data-toggle="modal" 
													data-target="#edit-mt" 
													onclick="editMeasureType(this); return false;">
							<span><i class="glyphicon glyphicon-plus manage-action" aria-hidden="true"></i>Add New</span>
						</a>
					</div>
					<table class="table table-striped table-responsive">
						<thead>
							<tr>
								<th>ID</th>
								<th>Category</th>
								<th>Type of Data</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($all_mt_results as $mt_result) {
							?>
							<tr class="search-row">
								<td><?=$mt_result["id"]?></td>
								<td><?=$mt_result["measure_type"]?></td>
								<td><?=$mt_result["measure_data_type"]?></td>
								<td>
									<a href="#" class="edit-location manage-action" data-id="<?=$mt_result["id"]?>" 
																data-name="<?=$mt_result["measure_type"]?>"
																data-type="<?=$mt_result["measure_data_type"]?>" 
																data-toggle="modal" 
																data-target="#edit-mt" 
																onclick="editMeasureType(this); return false;">
											<i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>
											<span class="sr-only">Edit</span>
								</td>
							</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>

			<h2>Metric</h2>
			<table class="table table-striped table-responsive">
				<thead>
					<tr>
						<th>ID</th>
						<th>Metric Name</th>
						<th>Metric Category</th>
						<th>Measure Type</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($all_metric_results as $metric) {
					?>
					<tr class="search-row">
						<td><?=$metric["id"]?></td>
						<td><?=$metric["metric_name"]?></td>
						<td><?=$metric["metric_category"]?></td>
						<td><?=$metric["measure_type"]?></td>
						<td>
							<a href="#" class="edit-location manage-action" data-id="<?=$metric["id"]?>" 
														data-name="<?=$metric["metric_name"]?>"
														data-mcId="<?=$metric["mc_id"]?>" 
														data-mtId="<?=$metric["mt_id"]?>" 
														data-toggle="modal" 
														data-target="#edit-metric" 
														onclick="editMetric(this); return false;">
									<i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>
									<span class="sr-only">Edit</span>
						</td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>

			<!-- Metric Categories Modal -->
			<div class="modal fade" id="edit-mc" tabindex="-1" role="dialog" aria-labelledby="edit-label">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="edit-label">Metric Category Details</h4>
						</div>
						<div class="modal-body">
							<form id="edit-details-form" method="POST" action="../app/manage.php">
								<input type="hidden" id="mc-id" name="mc-id" value="">
								<input type="hidden" id="type" name="type" value="metric_category">

								<div class="form-group">
									<label for="mc-name">Metric Category</label>
									<input class="form-control" type="text" id="mc-name" name="mc-name" value="">
								</div>
								<button type="submit" class="btn btn-success">Save changes</button>
							</form>
						</div><!-- /modal-body -->
					</div><!-- /modal-content -->
				</div><!-- /modal-dialog -->
			</div><!-- /modal -->
			
			<!-- Measure Type Modal -->
			<div class="modal fade" id="edit-mt" tabindex="-1" role="dialog" aria-labelledby="edit-label">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="edit-label">Measurement Type Details</h4>
						</div>
						<div class="modal-body">
							<form id="edit-details-form" method="POST" action="../app/manage.php">
								<input type="hidden" id="mt-id" name="mt-id" value="">
								<input type="hidden" id="type" name="type" value="measure_type">

								<div class="form-group">
									<label for="mt-name">Measure Type Name</label>
									<input class="form-control" type="text" id="mt-name" name="mt-name" value="">
								</div>
								<div class="form-group">
									<label for="mt-type">Measure Data Type</label>
									<select required class="form-control" id="mt-type" name="mt-type">
										<option value="">Please Select A Data Type</option>
										<option value="decimal">decimal (2.33, $1.99)</option>
										<option value="number">number (0, 10, 22)</option>
										<option value="string">string (abc, cake, apple)</option>
									</select>

								</div>
								<button type="submit" class="btn btn-success">Save changes</button>
							</form>
						</div><!-- /modal-body -->
					</div><!-- /modal-content -->
				</div><!-- /modal-dialog -->
			</div><!-- /modal -->
			
		</div>
<?php
	}
	include_once '../footer.php';
?>