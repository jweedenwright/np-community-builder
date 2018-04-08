<?php
	include_once 'app/global.php';
	$page_title = "Logout";
	include_once '../header.php';
	session_unset();
	session_destroy();
	header("Location: " . $login_url);
?>