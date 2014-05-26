<?php 
// if (!isset($_SESSION['login']))
// 	$_SESSION['login'] = "";

session_start();
session_regenerate_id(true);

include('scripts.php');

//
//if (!isset($_SESSION['user_name']))
//	$_SESSION['user_name'] = "";

$title = "Coopswitch";
$slogan = "A simple way to switch co-ops." //Get on the right cycle! Ha.

?>

<html lang="en">
<head>
	<title><?php echo "$title"; ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" media="screen" href="http://silviomoreto.github.io/bootstrap-select/stylesheets/bootstrap-select.css">
	

	<link href='http://fonts.googleapis.com/css?family=Cutive+Mono' rel='stylesheet' type='text/css'>
	
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

	<?php include_once("tracking.php") ?>
	
</head>
<body>
	<div class="container-fluid"> 
		<div class="row col-md-6 col-md-offset-3 text-center">
			<h1><?php echo "$title"; ?></h1>
			<h4><i><?php echo "$slogan"; ?></i></h4>
		</div>	
		<div class="row col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 text-center">
			<ul class="nav nav-pills nav-justified">
				<li>
					<a href="index.php">Home</a>
				</li>
				<li>
					<a href="about.php">About</a>
				</li>
				<li>
					<a href="list.php">List</a>
				</li>
				<li>
					<a href="check.php">Matches</a>
				</li>
			</ul>
		</div>	

			<!-- <div class="panel panel-default"> <br /> -->
		<br><br>

				<?php if ($_SESSION['login'] == "") { ?>
				<div class="row-fluid col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 text-center">
					<br><form class="form-inline" role="form" name="login_form" method="post" action="login.php">
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
				</div>
				<?php } else { ?>

					<div class="row-fluid col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 text-center">
						<br><p class="lead">
							Hey, <?php echo $_SESSION['user_name']; ?>.&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="account.php"><button type="button" class="btn btn-primary" >Profile</button></a>
							<a href="logout.php"><button type="button" class="btn btn-danger">Logout</button></a>
						</p>
					</div>

					<?php }

				?>
		<!--	</div> -->
		</div>
	</div>