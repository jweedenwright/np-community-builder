<?php
	// Error display
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	// Setup Globals and connections
	include_once 'app/global.php';
?>
<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
		<title><?=$page_title ?> | <?=$org_name?></title>
	 	<meta content="<?= $page_title ?> for <?=$org_name?> Volunteers" name="description">
	 	<meta content="width=device-width, initial-scale=1" name="viewport">
	 	<meta name="robots" content="NOINDEX,NOFOLLOW,NOARCHIVE,NOSNIPPET">

	 	<!-- Latest compiled and minified CSS -->
	 	<link href="<?=$root_dir?>/css/app.min.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	</head>
	<body class="home-page container">
		<header class="row">
			<div class="jumbotron">
				<div class="row">
					<div class="col-md-12">
						<div class="hero-image">
							<a href="<?=$root_dir?>/index.php"><img src="<?=$root_dir?>/img/knockout-logo.png" title="<?=$org_name?> Logo"/></a>
						</div>
					</div>
				</div>
			</div>
			<div id="nav-items" class="clearfix">
				<div class="col-sm-3 text-center">
					<a href="<?=$root_dir?>/pages/sign-in.php" class="sign-in line-link"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Sign In</a>
				</div>
				<div class="col-sm-3 text-center">
					<a href="<?=$root_dir?>/pages/sign-out.php" class="sign-out line-link"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Sign Out</a>
				</div>
				<div class="col-sm-3 text-center">
					<a href="<?=$root_dir?>/pages/dashboard.php" class="sign-out line-link"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Dashboard</a>
				</div>
				<div class="col-sm-3 text-center">
					<a href="<?=$root_dir?>/pages/manage.php" class="sign-out line-link"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Manage</a>
				</div>
			</div>
		</header>