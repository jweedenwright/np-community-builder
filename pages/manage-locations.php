<?php
	// Error display
	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);
	include_once 'app/global.php';

	//	Header
	$page_title = "Location Management";
	include_once '../header.php';

	if (!isset($_SESSION['email'])) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
		// Logic
		include_once '../app/manage-locations.php';
		
/////////////////////////////////////
// Ensure locations are returned
		if (sizeof($results) > 1) {
?>
			<div class="container">
				<h1>Location Listing</h1>
			
				<form id="vol-search">
					<div class="form-group">
						<label for="search-locs" class="sr-only">Search Locations</label>
						<input class="form-control" id="search-locs" name="search-locs" placeholder="Search Locations" type="text" onkeyup="filterItems(this);return true;">
					</div>
				</form>

				<table class="table table-striped table-responsive">
					<thead>
						<tr>
							<th>ID</th>
							<th>Location Name</th>
							<th>Internal Use Only</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($results as $location) {
						?>
						<tr class="search-row" data-search="<?=$location["location_name"]?>">
							<td><?=$location["id"]?></td>
							<td><?=$location["location_name"]?></td>
							<td><?=$location["internal"]?>
							<td>							
								<a href="#" class="edit-location" data-id="<?=$location["id"]?>" 
															data-name="<?=$location["location_name"]?>" 
															data-internal="<?=$location["internal"]?>"
															data-toggle="modal" 
															data-target="#edit-details" 
															onclick="editLocation(this); return false;">
										<i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>
										<span class="sr-only">Edit</span>
								</a>
							</td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>	

			<!-- Location Detail Modal -->
			<div class="modal fade" id="edit-details" tabindex="-1" role="dialog" aria-labelledby="edit-label">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="edit-label">Edit Location Details</h4>
						</div>
						<div class="modal-body">
							<form id="edit-details-form" method="POST" action="../app/manage.php">
								<input type="hidden" id="loc-id" name="loc-id" value="">
								<input type="hidden" id="type" name="type" value="location">

								<div class="form-group">
									<label for="loc-name">Location Name</label>
									<input class="form-control" type="text" id="loc-name" name="loc-name" value="">
								</div>
								<div class="form-group">
									<label for="loc-internal">Internal Use Only? (0 = Volunteers can Use to Book Time / 1 = Internal Only)</label>
									<input class="form-control" type="text" id="loc-internal" name="loc-internal" value="">
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