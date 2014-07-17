<?php

// error_reporting(0);
// @ini_set('display_errors', 0);
// Same as error_reporting(E_ALL);
//ini_set('error_reporting', E_ALL);
ob_start();

session_start();
session_regenerate_id(true);


//include('/var/www/scripts.php');

// Include useful scripts so I do not have to on each page.
foreach (glob($_SERVER['DOCUMENT_ROOT'] . "/resources/functions/*.php") as $filename) {
    
    // Ignore connect.php because we will use it when necessary only, avoid unnecessary connections
    if (strpos($filename, 'connect.php') != TRUE) {
    	include $filename;
    }
    // echo $filename;
}

?>

<html lang="en">

<head>

	<?php 

	$pageName = ucfirst(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME)); 

    $restOfURL = $_SERVER['REQUEST_URI'];
    $restOfURL = trim($restOfURL, "/");

    if ($pageName == "Index" && $restOfURL == "") {
    	$pageName = "Home";
    }
    else if (strpos($restOfURL,"stats") !== false) {
    	$pageName = "Stats";
    }

	?>
 
	<title><?php echo SITE_NAME . " | $pageName"; ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta content="utf-8" http-equiv="encoding">
	<link href="/css/bootstrap.css" rel="stylesheet">
	<link href="/css/other.css" rel="stylesheet">
	
	<link rel="stylesheet" type="text/css" media="screen" href="http://silviomoreto.github.io/bootstrap-select/stylesheets/bootstrap-select.css">
	<script src="/js/jquery-2.1.1.js"></script>
	<script src="/js/bootstrap.js"></script>
	<script src="/js/bootstrap-select.js"></script>
	<script src="/js/global.js"></script>

	<link href="http://fonts.googleapis.com/css?family=Cutive" rel="stylesheet" type="text/css">

	<style>
		.page-title {
			font-family: 'Cutive';
			font-size: 48px;
		}
	</style>
	
	<!-- <script src="../js/bootstrap-select.js"></script> -->
	
	<!-- <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script> -->

</head>

<body style="">
	<div class="container">

		<!-- Page Alert: Span width and gradient, have X or disappear on own? On top of title, etc. -->
		<div id="pageAlert" style="display: none; position: fixed;" class="row">
			<div class="text-center bg-warning text-warning lead" style="padding: 25px;">
				Testing Error 123
			</div>
		</div>

		<!-- Site Title -->
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2 text-center">
				<h1 class="page-title"><?php echo SITE_NAME; ?></h1>
				<h4><?php echo SITE_SLOGAN; ?> </h4>
			</div>
		</div>

		<!-- Site Nav Main -->
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3 col-xs-12 text-center">
				<ul class="nav nav-justified lead">
					<li <?php if ($pageName == "Home") echo 'class="active"'; ?> >
						<a href="/">Home</a>
					</li>
					<li <?php if ($pageName == "About") echo 'class="active"'; ?> >
						<a href="/about">About</a>
					</li>
					<li <?php if ($pageName == "Stats") echo 'class="active"'; ?> >
						<a href="/stats">Stats</a>
					</li>
					<li <?php if ($pageName == "Check") echo 'class="active"'; ?> >
						<a href="/check">Matches</a>
					</li>
				</ul>
			</div>
		</div>


		<div class="row">
			<div class="text-center" style="padding-top: 20px;">
				<div class="">
					<?php if (!isset($_SESSION['login'])) { ?>

					<form class="form-inline" role="form" name="login_form" method="post" action="/login.php">
						<fieldset>
							<div class="form-group">
						    	<label class="sr-only" for="email">Email address</label>
						   		<input type="email" class="form-control" name="email" id="email" placeholder="Email">
	  						</div>
	  						<div class="form-group">
						    	<label class="sr-only" for="password">Password</label>
						    	<input type="password" class="form-control" name="password" id="password" placeholder="Password">
							</div>
					   		<button type="submit" class="btn btn-default btn-success">Sign In</button>
					    </fieldset>
					</form>

					<?php } else { ?>
				</div>

				<p class="lead">
					Hey, <?php echo $_SESSION['user_name']; ?>.&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="/account.php"><button type="button" class="btn btn-primary" >Profile</button></a>
					<a href="/logout.php"><button type="button" class="btn btn-danger">Logout</button></a>
				</p>

				<?php } ?>

			</div>

		</div>

		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<hr class="style-one">
			</div>
		</div>
	
		<!-- <hr> -->

	</div> <!-- End Header Container -->
