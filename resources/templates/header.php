<?php

// error_reporting(0);
// @ini_set('display_errors', 0);
// Same as error_reporting(E_ALL);
// ini_set('error_reporting', E_ALL);
ob_start();

if (isset($_SESSION['login']))
	session_regenerate_id(true);

session_start();

// Include useful scripts so I do not have to on each page.

foreach (glob($_SERVER['DOCUMENT_ROOT'] . "/resources/functions/*.php") as $filename) {
    
    // Ignore connect.php because we will use it when necessary only, avoid unnecessary connections
    if (strpos($filename, 'connect.php') != TRUE) {
    	include $filename;
    }
}

?>

<html lang="en">

<head>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="encoding">
	<meta charset="UTF-8">
	
	<meta name="description" content="Coopswitch: A simpler way to switch coops.">
	<meta name="keywords" content="coop, switch">
	<meta name="author" content="Coopswitch">

	<?php 

		// $pageName = ucfirst(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME)); 
		$pageName = getPageName();

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
	<link href="/css/bootstrap.css" rel="stylesheet">
	<link href="/css/other.css" rel="stylesheet">
	
	<!-- Get local bootstrap-select  via git? -->
	<!-- <link rel="stylesheet" type="text/css" media="screen" href="http://silviomoreto.github.io/bootstrap-select/stylesheets/bootstrap-select.css"> -->
	<link href="/css/bootstrap-select.css" rel="stylesheet" media="screen">

	<script src="/js/jquery-2.1.1.js"></script>
	<script src="/js/bootstrap.js"></script>
	<script src="/js/bootstrap-select.js"></script>
	<script src="/js/global.js"></script>

	<link href="https://fonts.googleapis.com/css?family=Cutive" rel="stylesheet" type="text/css">

</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3" id="header-container"> 
				<!-- Page Alert: Span width and gradient, have X or disappear on own? On top of title, etc. -->
			<!-- 	<div id="pageAlert" style="display: none; position: fixed;" class="row">
					<div class="text-center bg-warning text-warning lead" style="padding: 25px;">
						Testing Error 123
					</div>
				</div> -->


				<!-- Site Title -->
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1 text-center">
						<h1 class="page-title "><?php echo SITE_NAME; ?>
							<div id="subtitle"><small><?php echo SITE_SLOGAN; ?></small></div>
						</h1>
					</div>
				</div> 

				<!-- Site Nav Main -->
				<div class="row" style="margin: auto;">
					<div class="col-md-12 col-sm-12 col-sm-offset-0 col-xs-offset-0">
						<ul id="mainNav" class="nav nav-pills nav-stackable siteNav">
							<li <?php if ($pageName == "Home") echo 'class="active"'; ?> >
								<a href="/">
								<img src="/img/header/icon-home.png" class="img-responsive headerImg img-rounded" />
								Home</a>
							</li>
							<li <?php if ($pageName == "About") echo 'class="active"'; ?> >							
								<a href="/about">
								<img src="/img/header/icon-info.png" class="img-responsive headerImg img-rounded" />
								About</a>
							</li>
							<li <?php if ($pageName == "Switch") echo 'class="active"'; ?> >
								<a href="/switch">
								<img src="/img/header/icon-time.png" class="img-responsive headerImg img-rounded" />
								Switch</a>
							</li>
							<li <?php if ($pageName == "Account") echo 'class="active"'; ?> >
									<a href="#" <?php print (isset($_SESSION['login']) ? 'id="loggedInBtn"' : 'id="loginBtn"'); ?>> 
									<img <?php print (isset($_SESSION['login']) ? 'src="/img/header/icon-user-loggedin.png"' : 'src="/img/header/icon-user.png"'); ?> class="img-responsive headerImg img-rounded">
									Account</a>
							</li>
						</ul>

					</div>
				</div>


				<div class="row-fluid">
					<div id="loginFormDiv" class="col-sm-10 col-sm-offset-1">
							<?php if (!isset($_SESSION['login'])) { ?>

							<form id="loginForm" class="form-inline" role="form" name="login_form" method="post" action="/login.php">
									<div class="form-group">
							    	<label class="sr-only" for="email">Email address</label>
							   		<input type="email" class="form-control" name="email" id="email" placeholder="Email">
		  						</div>
		  						<div class="form-group">
							    	<label class="sr-only" for="password">Password</label>
							    	<input type="password" class="form-control" name="password" id="password" placeholder="Password">
									</div>
									<div class="form-group">
						   			<button id="signInHeader" type="submit" class="btn btn-default btn-info text-center">Sign In</button>
							  	</div>
							</form>

					</div>
				</div>
							<?php } else { ?>

							<div class="row center-header" id="loggedInHeader">
								<div class="col-sm-10 col-sm-offset-1 col-xs-8 col-xs-offset-2 text-center">
									<p class="lead">Welcome back, <?php echo $_SESSION['user_name'] ?>. 									
									<a href="/account" id="profileBtn" class="btn btn-primary accountBtn">Account</a>
									<a href="/logout" id="logoutBtn" class="btn btn-danger accountBtn">Logout</a>
									</p>
								</div>
							</div>

						<?php } ?>


<!-- 
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<hr class="style-one">
					</div>
				</div> -->
	
		<!-- <hr> -->
			</div>
		</div>
	</div> <!-- End Header Container -->

<script>

	<?php if (!isset($_SESSION['login'])) echo 'id("loginForm").style.display = "none";' ?>

	<?php if (isset($_SESSION['login'])) echo 'id("loggedInHeader").style.display = "none";' ?>

	$('#loginBtn').click(function(e){ 
		//$('#loginBtn').fadeOut('fast');
		if (id("loginForm").style.display == '' || id("loginForm").style.display == 'inline') {
			$('#loginForm').fadeOut('fast');
			id("loginForm").style.display = 'none';
			$('#loginBtn').blur();
			e.preventDefault();
		}
		else {
			$('#loginForm').fadeIn('fast');
			e.preventDefault();
		}
	});

	$('#loggedInBtn').click(function(e){    
		if (id("loggedInHeader").style.display == '' || id("loggedInHeader").style.display == 'inline') {
			$('#loggedInHeader').fadeOut('fast');
			id("loggedInHeader").style.display = 'none';
			$('#loggedInBtn').blur();
			e.preventDefault();
		}
		else {
			$('#loggedInHeader').fadeIn('fast');
				e.preventDefault();
		}
	});

	$("#submenu").hover(function(){
		$('.dropdown-toggle').dropdown('toggle');
		alert("test");
	})

</script>
