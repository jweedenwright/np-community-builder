<?php
	// Error display
	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);
	include_once 'app/global.php';

	//	Header
	$page_title = "Program Management";
	include_once '../header.php';

	if (!isset($_SESSION['email'])) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
		// Logic
		include_once '../app/manage-programs.php';
		
/////////////////////////////////////
// Ensure tasks are returned
		if (sizeof($results) > 1) {
?>
			<div class="container">
				<h1>Programs Listing</h1>
				<form id="program-search">
					<div class="form-group col-sm-2">
						<a href="#" class="btn btn-primary create-program" data-id="new"
													data-toggle="modal" 
													data-target="#edit-details" 
													onclick="editProgram(this); return false;">
							<span><i class="glyphicon glyphicon-plus manage-action" aria-hidden="true"></i>Add New</span>
						</a>
					</div>
					<div class="form-group col-sm-10">
						<label for="search-programs" class="sr-only">Search Programs</label>
						<input class="form-control" id="search-programs" name="search-programs" placeholder="Search Programs" type="text" onkeyup="filterItems(this);return true;">
					</div>
				</form>

				<table class="table table-striped table-responsive">
					<thead>
						<tr>
							<th>ID</th>
							<th>Program Name</th>
							<th>Is Active</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($results as $program) {
						?>
						<tr class="search-row" data-search="<?=$program["program"]?>">
							<td><?=$program["id"]?></td>
							<td><?=$program["program"]?></td>
							<td><?=$program["active"]?></td>
							<td>
								<a href="#" class="edit-program manage-action" data-id="<?=$program["id"]?>" 
															data-name="<?=$program["program"]?>" 
															data-toggle="modal" 
															data-target="#edit-details" 
															onclick="editProgram(this); return false;">
										<i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>
										<span class="sr-only">Edit</span>
								</a>
								<?php if ($program["active"] == 1) { ?>
									<a href="#" class="deactivate-program manage-action" data-id="<?=$program["id"]?>" 
																data-type='program'
																onclick="deactivate(this); return false;">
											<i class="glyphicon glyphicon-ban-circle" aria-hidden="true"></i>
											<span class="sr-only">Deactivate</span>
									</a>
								<?php } else { ?>
									<a href="#" class="activate-program manage-action" data-id="<?=$program["id"]?>" 
																data-type='program'
																onclick="activate(this); return false;">
											<i class="glyphicon glyphicon-certificate" aria-hidden="true"></i>
											<span class="sr-only">Activate</span>
									</a>
								<?php } ?>
							</td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>	

			<!-- Program Detail Modal -->
			<div class="modal fade" id="edit-details" tabindex="-1" role="dialog" aria-labelledby="edit-label">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="edit-label">Program Details</h4>
						</div>
						<div class="modal-body">
							<form id="edit-details-form" method="POST" action="../app/manage.php">
								<input type="hidden" id="program-id" name="program-id" value="">
								<input type="hidden" id="type" name="type" value="program">

								<div class="form-group">
									<label for="program-name">Program Name</label>
									<input class="form-control" type="text" id="program-name" name="program-name" value="">
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