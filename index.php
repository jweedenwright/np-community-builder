<?php
	$page_title = "Welcome";
	include_once 'header.php';
?>
		<div class="row">
			<div id="mission-statement" class="col-sm-push-2 col-sm-8 card text-center">
				<p>Bringing people together to grow, cook and share nourishing food, with the goals of cultivating community and alleviating hunger in our city.</p>
			</div>
		</div>
		<div class="row">
			<div id="preferences" class="col-sm-push-3 col-sm-6 col-xs-12">
				<h4>Choose Location</h4>
				<div class="form-group">
					<label for="location" class="sr-only">Location *</label>
					<select required class="form-control npcb-service" id="location" name="location" data-npcb-service="locations" data-npcb-callback="locationCallback">
						<option required disabled selected="true" value="">Please Choose A Location</option>
					</select>
				</div>
				<div class="form-group text-center">
					<div id="prefs-set" class="success text-success"></div>
					<div id="prefs-failed" class="danger text-danger"></div>
					<a class="submit line-link" onclick="setPreferences();"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Set Location Preference</a>
				</div>
			</div>
		</div>
<?php
	include_once 'footer.php';
?>