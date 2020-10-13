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
		Total volunteers is <?=$volunteer_results[0]['userCount']?>.
	</div>
</div>
<?php
	}
	include_once '../footer.php';
?>