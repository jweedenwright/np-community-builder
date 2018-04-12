<?php
	include_once 'app/global.php';

	//	Header
	$page_title = "Bulk";
	include_once '../header.php';

	// Pull locations
	$query_string = "SELECT id, location_name
						FROM location
						WHERE internal = 0
						ORDER BY location_name";			
	$location_results = $db->executeStatement($query_string,[])->fetchAll();

	// Pull Job Types
	$query_string = "SELECT id, job_type
						FROM job_type
						ORDER BY job_type";
	$type_results = $db->executeStatement($query_string,[])->fetchAll();

	if (!isset($_SESSION['email'])) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
?>
	<div class="danger"></div>
	<form id="bulk-import">
		<div class="row">
			<div class="col-xs-12">
				<h1>
					Bulk Import
					<span class="req-field-warning badge">
						<i class="glyphicon glyphicon-asterisk"></i> indicates a required field
					</span>
				</h1>
			</div>
			<div class="form-group col-sm-3">
				<div class="input-group signin-time">
					<label for="signintime" class="sr-only">Date *</label>
					<input type='text' class="form-control" id="datetime-picker" data-format="yyyy-MM-dd hh:mm:00" name="signintime" placeholder="MM/DD/YYYY 12:01 AM" />
					<span class='input-group-addon field-error'><i class='glyphicon glyphicon-asterisk'></i></span>
				</div>
			</div>
			<div class="form-group col-sm-3">
				<div class="input-group organization">
					<label for="organization" class="sr-only">Organization *</label>
					<input class="form-control" id="organization" name="organization" placeholder="Affiliation, i.e. Company A, Organization B" type="text">
					<span class='input-group-addon field-error'><i class='glyphicon glyphicon-asterisk'></i></span>
				</div>
			</div>
			<div class="form-group col-sm-3">
				<label for="task" class="sr-only">Volunteer Project Task *</label>
				<div class="input-group task">
					<select required class="form-control" id="task" name="task">
						<option required disabled selected="true" value="">Please Select A Task</option>
						<?php
							foreach ($type_results as $row) {
								?>
									<option value="<?=$row['id']?>"><?=$row['job_type']?></option>
								<?php
							}
						?>
					</select>
					<span class='input-group-addon field-error'><i class='glyphicon glyphicon-asterisk'></i></span>
				</div>
			</div>
			<div class="form-group col-sm-3">
				<label for="location" class="sr-only">Location *</label>
				<div class="input-group location">
					<select required class="form-control" id="location" name="location">
						<option required disabled selected="true" value="">Please Choose A Location</option>
						<?php
							foreach ($location_results as $row) {
								?>
									<option value="<?=$row['id']?>"><?=$row['location_name']?></option>
								<?php
							}
						?>
					</select>
					<span class='input-group-addon field-error'><i class='glyphicon glyphicon-asterisk'></i></span>
				</div>
			</div>
		</div><!-- /row -->

		<h2>Attendees</h2>
		<div class="attendee-wrap"></div>
	</form>
	<button type="button" class="add btn btn-info">Add a field</button>
	<button type="button" class="save btn btn-success pull-right" onclick="bulkImport();">Save</button>
<?php
	}
	include_once '../footer.php';
?>

<script type="text/javascript">
	$(document).ready(function() {
		$(".add").on("click", function() {
			var attendee_count = document.getElementsByClassName("attendee").length,
				attendee_wrapper = $("#bulk-import .attendee-wrap"),
				attendee_field_wrapper = $("<div id=\"attendee" + attendee_count + "\" class=\"row attendee\">"),
				attendee_email = $("<div class=\"form-group col-sm-3\"><label for=\"email\">Email</label><input type=\"text\" class=\"form-control\" id=\"quick-sign-in-name\" name=\"email\" autocomplete=\"on\" placeholder=\"Enter an email\"></div>"),
				attendee_first_name = $("<div class=\"form-group col-sm-3\"><label for=\"firstName\">First Name</label><input type=\"text\" class=\"form-control\" id=\"firstName\" name=\"firstName\" autocomplete=\"on\" placeholder=\"First Name\"></div>"),
				attendee_last_name = $("<div class=\"form-group col-sm-3\"><label for=\"lastName\">Last Name</label><input type=\"text\" class=\"form-control\" id=\"lastName\" name=\"lastName\" autocomplete=\"on\" placeholder=\"Last Name\"></div>"),
				attendee_first_time = $("<div class=\"form-group col-sm-2\"><div class=\"checkbox\"><label><input type=\"checkbox\" name=\"first-time\"> First Time</label></div></div>")
				attendee_removal = $("<div class=\"pull-left\"><button type=\"button\" class=\"remove btn btn-default active\"><i class='glyphicon glyphicon-minus' aria-hidden=\"true\"></i><span class=\"sr-only\">Remove a field</span></button></div>");

			attendee_field_wrapper.append(attendee_email);
			attendee_field_wrapper.append(attendee_first_name);
			attendee_field_wrapper.append(attendee_last_name);
			attendee_field_wrapper.append(attendee_first_time);
			attendee_field_wrapper.append(attendee_removal);
			attendee_wrapper.append(attendee_field_wrapper);

			$(".remove").on("click", function() {
				$(this).parents(".attendee").remove();
			});
		});
	});
</script>
