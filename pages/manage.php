<?php
	include_once 'app/global.php';

	//	Header
	$page_title = "Manage";
	include_once '../header.php';

	if (!isset($_SESSION['email'])) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
?>
<style type="text/css">
	.tab-content {
		border-left: 1px solid #e0e0e0;
		border-right: 1px solid #e0e0e0;
		border-bottom: 1px solid #e0e0e0;
		padding: 20px;
	}
</style>

<div id="npcb-report" class="container">
	<h1>Maintenance</h1>

	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active">
			<a href="#meals" aria-controls="meals" role="tab" data-toggle="tab">Meals</a>
		</li>
		<li role="presentation">
			<a href="#food-donations" aria-controls="food-donations" role="tab" data-toggle="tab">Food Donations</a>
		</li>
		<li role="presentation">
			<a href="#garden" aria-controls="garden" role="tab" data-toggle="tab">Garden</a>
		</li>
		<li role="presentation">
			<a href="#programs" aria-controls="programs" role="tab" data-toggle="tab">Programs</a>
		</li>
	</ul>
	<!-- Tab panes -->
	<div class="tab-content">
		<!-- Meals Form -->
		<div role="tabpanel" class="tab-pane active" id="meals">
			<h3>Meals</h3>
			<form id="meals-form">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="meals-month">Enter Month</label>
							<select name="meals-month" id="meals-month" class="form-control">
								<option value="">-- Select --</option>
								<option value="1">January</option>
								<option value="2">February</option>
								<option value="3">March</option>
								<option value="4">April</option>
								<option value="5">May</option>
								<option value="6">June</option>
								<option value="7">July</option>
								<option value="8">August</option>
								<option value="9">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="meals-total-shared">Total Meals Shared</label>
							<input type="number" class="form-control" name="meals-total-shared" id="meals-total-shared" placeholder="Total Meals Shared" max="30000" min="0">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="meals-total-reported">Total Meals Reported</label>
							<input type="number" class="form-control" name="meals-total-reported" id="meals-total-reported" placeholder="Total Meals Reported" max="30000" min="0">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="meals-total-non-program">Total Non-Program Meals</label>
							<input type="number" class="form-control" name="meals-total-non-program" id="meals-total-non-program" placeholder="Total Non-Program Meals" max="30000" min="0">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="meals-food-costs">Food Costs (in dollars)</label>
							<div class="input-group">
								<div class="input-group-addon">$</div>
								<input type="number" class="form-control" name="meals-food-costs" id="meals-food-costs" min="0" value="0" step="0.50">
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="meals-local-farm-investment">Local Farm Investment (in dollars)</label>
							<div class="input-group">
								<div class="input-group-addon">$</div>
								<input type="number" class="form-control" name="meals-local-farm-investment" id="meals-local-farm-investment" min="0" value="0" step="0.50">
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="meals-number-of-meal-distribution-partners">Number of Meal Distribution Partners</label>
							<input type="number-of-meal-distribution-partners" class="form-control" name="meals-number-of-meal-distribution-partners" id="meals-number-of-meal-distribution-partners" placeholder="Number of Meal Distribution Partners" max="1000" min="0">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="meals-location">Location</label>
							<select class="form-control" name="meals-location" id="meals-location">
								<option value="">-- Select --</option>
								<option value="1">Blackman Road Garden</option>
								<option value="2">Haywood Lane Garden</option>
								<option value="3">McGruder Garden</option>
								<option value="4">South Hall Kitchen</option>
								<option value="5">St Luke's Kitchen</option>
								<option value="6">Wedgewood Garden</option>
								<option value="7">Woodmont Garden</option>
								<option value="8">Wedgewood Garden Neighbors</option>
								<option value="9">Fall Hamilton</option>
								<option value="10">Cottage Cove</option>
								<option value="11">Harvest Hands</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<button type="submit" class="btn btn-default">Save</button>
					</div>
				</div>
			</form>
		</div>

		<!-- Food Donations Form -->
		<div role="tabpanel" class="tab-pane" id="food-donations">
			<form id="donation-form">
				<h3>Food Donations</h3>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="donation-datetime">Timestamp:</label>
							<input type="text" class="form-control datetime-picker" name="donation-datetime" id="donation-datetime" data-format="yyyy-MM-dd hh:mm:00" placeholder="MM/DD/YYYY 12:01 AM">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="donation-weight">Weight in lbs: </label>
							<input type="number" class="form-control" name="donation-weight" id="donation-weight" min="0" value="0" step="0.1">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="donation-food-metric">Food Metric: </label>
							<select class="form-control" name="donation-food-metric" id="donation-food-metric">
								<option value="">-- Select --</option>
								<option value="1">Grocery Store</option>
								<option value="2">Farm/Garden</option>
								<option value="3">Restaurant</option>
								<option value="4">Caterer</option>
								<option value="5">Individual</option>
								<option value="6">School</option>
								<option value="7">Other</option>
								<option value="8">Shared with Others</option>
								<option value="9">Compost</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</div>
			</form>
		</div>

		<!-- Garden Form -->
		<div role="tabpanel" class="tab-pane" id="garden">
			<form id="garden-form">
				<h3>Garden</h3>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="garden-datetime">Timestamp:</label>
							<input type="text" class="form-control datetime-picker" name="garden-datetime" id="garden-datetime" data-format="yyyy-MM-dd hh:mm:00" placeholder="MM/DD/YYYY 12:01 AM">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="garden-weight">Weight in Lbs</label>
							<input type="number" class="form-control" name="garden-weight" id="garden-weight" min="0" value="0" step="0.1">
						</div>
						<div class="form-group">
							<label for="garden-food-type">Food Type</label>
							<select class="form-control" name="garden-food-type" id="garden-food-type">
								<option value="">-- Select --</option>
								<option value="1">Fruit</option>
								<option value="2">Roots</option>
								<option value="3">Greens</option>
								<option value="4">Salad</option>
								<option value="5">Herbs</option>
								<option value="6">Eggs</option>
								<option value="7">Other</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<button type="submit" class="btn btn-default">Save</button>
					</div>
				</div>
			</form>
		</div>

		<!-- Programs Form -->
		<div role="tabpanel" class="tab-pane" id="programs">
			<form id="program-form">
				<h3>Programs</h3>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="program-participants">Participants:</label>
							<input type="number" class="form-control" name="program-participants" id="program-participants" min="0" value="0" step="1">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="program-datetime">Timestamp:</label>
							<input type="text" class="form-control datetime-picker" name="program-datetime" id="program-datetime" data-format="yyyy-MM-dd hh:mm:00" placeholder="MM/DD/YYYY 12:01 AM">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="program-name">Programs</label>
							<select class="form-control" name="program-name" id="program-name">
								<option value="">-- Select --</option>
								<option value="1">Nashville CARES</option>
								<option value="2">Community Garden</option>
								<option value="3">Market Gardens</option>
								<option value="4">Garden Education</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="program-location">Locations</label>
							<select class="form-control" name="program-location" id="program-location">
								<option value="">-- Select --</option>
								<option id="1">Blackman Road Garden</option>
								<option id="2">Haywood Lane Garden</option>
								<option id="3">Woodmont Garden</option>
								<option id="4">South Hall Kitchen</option>
								<option id="5">McGruder Garden</option>
								<option id="6">St Luke''s Kitchen</option>
								<option id="7">Wedgewood Garden</option>
								<option id="8">Wedgewood Garden Neighbors</option>
								<option id="9">Fall Hamilton</option>
								<option id="10">Cottage Cove</option>
								<option id="11">Harvest Hands</option>
							</select>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-default">Save</button>
			</form>
		</div>

	</div>
</div>
<?php
	}
	include_once '../footer.php';
?>