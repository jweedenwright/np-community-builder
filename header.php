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
	<body class="home-page">
		<header>
			<div class="jumbotron">
				<div class="container">
					<div class="staff-log-out">
						<a href="<?=$root_dir?>/pages/logout.php">
							Staff log out
						</a>
					</div>
					<div class="hero-image">
						<a href="<?=$root_dir?>/index.php"><img src="<?=$root_dir?>/img/knockout-logo.png" title="<?=$org_name?> Logo"/></a>
					</div>
					<nav id="main-nav" role="navigation">
						<ul>
							<li>
								<a href="<?=$root_dir?>/pages/dashboard.php">
									Staff dashboard
								</a>
							</li>
							<li>
								<a href="<?=$root_dir?>/pages/user-management.php">
									Manage
								</a>
							</li>
							<li>
								<a href="<?=$root_dir?>/pages/bulk.php">
									Bulk signin
								</a>
							</li>
							<li>
								<a href="<?=$root_dir?>/pages/sign-in.php" class="nav-signin-btn">
									Volunteer sign-in/out
								</a>
							</li>
						</ul>
					</nav>
				</div>
			</div>
			<!--div id="nav-items" class="clearfix">
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
			</div-->
		</header>
		<?php
			if(isset($_GET['message'])) {
				$special_msg = filter_var ( $_GET['message'], FILTER_SANITIZE_STRING);
				$message_class = "alert alert-danger";
				if (strrpos($special_msg, "uccess")) {
					$message_class = "alert alert-success";					
				}
		?>
			<div id="message-container"><p class='<?=$message_class?>'><?=$special_msg?></p></div>
		<?php
			}
		?>