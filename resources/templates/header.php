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
	
	<!-- Get local bootstrap-select  via git? -->
	<!-- <link rel="stylesheet" type="text/css" media="screen" href="http://silviomoreto.github.io/bootstrap-select/stylesheets/bootstrap-select.css"> -->
	<link href="/css/bootstrap-select.css" rel="stylesheet" media="screen">

	<script src="/js/jquery-2.1.1.js"></script>
	<script src="/js/bootstrap.js"></script>
	<script src="/js/bootstrap-select.js"></script>
	<script src="/js/global.js"></script>

	<link href="https://fonts.googleapis.com/css?family=Cutive" rel="stylesheet" type="text/css">
	
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
			<div class="col-sm-10 col-sm-offset-1 text-center">
				<h1 class="page-title"><?php echo SITE_NAME; ?>
					<div id="subtitle"><small><?php echo SITE_SLOGAN; ?></small></div>
				</h1>
			</div>
		</div>


		<!-- Site Nav Main -->
		<div class="row">
			<div class="col-sm-7 col-sm-offset-3 col-xs-6 col-xs-offset-3 text-center lead">
				<ul id="mainNav" class="nav nav-pills nav-stackable nav-justified ">
					<li <?php if ($pageName == "Home") echo 'class="active"'; ?> >
						<a href="/">Home</a>
					</li>
					<li <?php if ($pageName == "About") echo 'class="active"'; ?> >
						<a href="/about">About</a>
					</li>
					<!--
			 		<li <?php if ($pageName == "Stats") echo 'class="active"'; ?> >
						<a href="/stats">Stats</a>
					</li> 
					-->
					<li <?php if ($pageName == "Switch") echo 'class="active"'; ?> >
						<a href="/switch">Switch</a>
					</li>
					<li>
						<div >
							<a class="btn  btn-info accountBtn"  <?php print (isset($_SESSION['login']) ? 'href="/account.php"' : 'id="loginBtn" href="#"'); ?>>My Account</a>
						</div>
					</li>
					<li >
						<div>
							<?php print (isset($_SESSION['login']) ? '<a href="/logout" id="logoutBtn" class="btn btn-danger accountBtn">Logout</a>' : ''); ?>
						</div>
					</li>
				</ul>

			</div>
		</div>


		<div class="row">
			<div class="col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 text-center">
					<?php if (!isset($_SESSION['login'])) { ?>

					<form id="loginForm" class="form-inline" role="form" name="login_form" method="post" action="/login.php">
						<fieldset>
							<div class="form-group">
					    	<label class="sr-only" for="email">Email address</label>
					   		<input type="email" class="form-control" name="email" id="email" placeholder="Email">
  						</div>
  						<div class="form-group">
					    	<label class="sr-only" for="password">Password</label>
					    	<input type="password" class="form-control" name="password" id="password" placeholder="Password">
							</div>
				   		<button type="submit" class="btn btn-default btn-info">Sign In</button>
					  </fieldset>
					</form>

					<?php } else { ?>



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

<script>
	id("loginForm").style.display = 'none';

	$('#loginBtn').click(function(e){    
		//$('#loginBtn').fadeOut('fast');
		if (id("loginForm").style.display == '' || id("loginForm").style.display == 'inline') {
			$('#loginForm').fadeOut('fast');
			id("loginForm").style.display = 'none';
		}
		else {
			$('#loginForm').fadeIn('fast');
		}
	});

	$("#submenu").hover(function(){
		$('.dropdown-toggle').dropdown('toggle');
		alert("test");
	})

</script>
