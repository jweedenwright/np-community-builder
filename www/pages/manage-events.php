<?php
	// Error display
	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);
	include_once '../app/global.php';

	//	Header
	$page_title = "Event Management";
	include_once '../header.php';

	if (!isLoggedIn()) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
		// Logic
		include_once '../app/manage-events.php';
		
/////////////////////////////////////
// Ensure events are returned
		if (sizeof($results) > 0) {
?>
			<div class="container">
				<h1>Event Listing</h1>
				<form id="event-search">
					<div class="form-group col-sm-2">
						<a href="#" class="btn btn-primary create-event" data-id="new"
													data-toggle="modal" 
													data-target="#edit-details" 
													onclick="editevent(this); return false;">
							<span><i class="glyphicon glyphicon-plus manage-action" aria-hidden="true"></i>Add New</span>
						</a>
					</div>
					<div class="form-group col-sm-10">
						<label for="search-events" class="sr-only">Search Events</label>
						<input class="form-control" id="search-events" name="search-events" placeholder="Search events" type="text" onkeyup="filterItems(this);return true;">
					</div>
				</form>

				<table class="table table-striped table-responsive">
					<thead>
						<tr>
							<th>ID</th>
							<th>Event Name</th>
							<th>Event Date</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($results as $event) {
						?>
						<tr class="search-row" data-search="<?=$event["job_type"]?>">
							<td><?=$event["id"]?></td>
							<td><?=$event["event_name"]?></td>
							<td><?=$event["event_date"]?></td>
							<td>							
								<a href="#" class="edit-event manage-action" data-id="<?=$event["id"]?>" 
															data-name="<?=$event["event_name"]?>" 
															data-toggle="modal" 
															data-target="#edit-details" 
															onclick="editevent(this); return false;">
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

			<!-- event Detail Modal -->
			<div class="modal fade" id="edit-details" tabindex="-1" role="dialog" aria-labelledby="edit-label">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="edit-label">Event Details</h4>
						</div>
						<div class="modal-body">
							<form id="edit-details-form" method="POST" action="../app/manage.php">
								<input type="hidden" id="event-id" name="event-id" value="">
								<input type="hidden" id="type" name="type" value="job_type">

								<div class="form-group">
									<label for="event-name">Event Name</label>
									<input class="form-control" type="text" id="event-name" name="event-name" value="">
                </div>
                
                <div class="form-group">
									<label for="event-name">Event Name</label>
									<input class="form-control" type="text" id="event-name" name="event-name" value="">
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