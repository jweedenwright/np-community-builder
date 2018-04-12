<?php
	include_once 'app/global.php';

	//	Header
	$page_title = "Data Management";
	include_once '../header.php';

	if (!isset($_SESSION['email'])) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
?>
	<h1>Data Management</h1>
<?php
	}
	include_once '../footer.php';
?>
	
