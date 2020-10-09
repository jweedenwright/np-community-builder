<?php
	include_once '../app/global.php';

	if (!isset($_SESSION['email'])) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
		//	Header
		$page_title = "Manage";
		include_once '../header.php';
?>

<div id="npcb-report" class="container">
	<h1>Website Management</h1>
	<ul>
		<li><a href="/pages/manage-volunteers.php">Manage Volunteers</a></li>
		<li><a href="/pages/manage-locations.php">Manage Locations</a></li>
		<li><a href="/pages/manage-tasks.php">Manage Tasks</a></li>
	</ul>
	
</div>
<?php
	}
	include_once '../footer.php';
?>