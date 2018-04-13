<?php
	include_once 'app/global.php';

	//	Header
	$page_title = "Dashboard";
	include_once '../header.php';

	if (!isset($_SESSION['email'])) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
?>
<div class="container">
	<h1>Here we go</h1>
</div><!-- /container -->
<?php
	}
	include_once '../footer.php';
?>
	
