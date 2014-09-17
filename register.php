<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");
include(FUNCTION_PATH . "/connect.php");

$url = "https://" . $_SERVER['SERVER_NAME'];

// No post data sent.
if ($_SERVER['CONTENT_LENGTH'] == 0) {
	header("Location: " . $url . "/error.php?msg=3");
	die();
}


// User already logged in.
else if (isset($_SESSION['login'])) {
	header("Location: " . $url . "/error.php?msg=4");
	die();
	//break;
}

else if (!isset($_POST['name']) || !isset($_POST['password']) || !isset($_POST['email'])) {
	header("Location: " . $url . "/error.php?msg=4");
	die();
	//break;
}



if (!isset($_POST['name']) || $_POST['name'] == "") { die("No name."); }
if (!isset($_POST['email']) || $_POST['email'] == "") { die("No email. "); } 
if (!isset($_POST['password']) || $_POST['password'] == "") { die("No password one. "); } 
if (!isset($_POST['password2']) || $_POST['password2'] == "") { die("No password two. "); } 
if (!isset($_POST['cycle']) || $_POST['cycle'] == "") { die("No cycle. "); } 
if (!isset($_POST['numCoops']) || $_POST['numCoops'] == "") { die("No numCoops. "); } 
if (!isset($_POST['major']) || $_POST['major'] == "") { die("No major. "); } 

// Run post data through test_input function 	header("Location: " . $url . "/error.php?msg=nodata");
$name = test_input($_POST['name']);
$email = test_input($_POST['email']);

$password = test_input($_POST['password']);
$password2 = test_input($_POST['password2']);

if ($password == $password2) {
	$password = sha1($password);
}
else {
	die("Passwords do not match.");
}

$cycle = test_input($_POST['cycle']);
$currentCycleText = ($cycle == "1" ? "Fall-Winter" : "Spring-Summer");
$num_year_program = test_input($_POST['numCoops']);
$currentProgramText = ($num_year_program == "1" ? "One Coop" : "Three Coops");
$major = test_input($_POST['major']);

// See if email is already in use
$query = 'SELECT * FROM Users WHERE email = "' .$email. '"';
$result = mysql_query($query);

// Not 0 means the email already exists.
if (mysql_num_rows($result) != 0) {

	header("Location: /error?msg=emailinuse");
	die();
}


// Add user to db

$sql="INSERT INTO Users (name, password, email, cycle, num_year_program, major, register_date)
VALUES ('$name','$password', '$email','$cycle', '$num_year_program', '$major',
		'".date("Y-m-d H:i:s")."'
	)";

$verifyLink = getVerifyLink($name, $email, $cycle);

if (!mysql_query($sql,$con)) {
  	die('Error: ' . mysql_error());
}

else {
	send_init_email($name, $email, $verifyLink); // Success, user has been created.
}

$majorName = getMajorName($major);
mysql_close($con);

$formGroupLabel = "col-sm-4 col-sm-offset-1";
$formGroupItem = "text-primary col-sm-7";

?>

<div class="container">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 formHeader text-center">



					<div class="row">
						<h2>Welcome to Coopswitch, <span class="text-primary"><?php echo $name; ?></span>!</h2>
						<br />
					</div>
					<div class="row">
						<div class="text-warning bg-warning lead" style="padding: 12px;">
							<p class=""><strong>Please check your email to verify your account.</strong></p>
						</div>
					</div>

					<div class="row">
						<form id="registeredForm" class="form-horizontal" role="form">
							<div class="form-group">
								<label class="control-label <?php echo $formGroupLabel; ?>">Email</label>
								<div class="<?php echo $formGroupItem; ?>">
									<p class="form-control-static"><?php echo $email; ?></p>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label <?php echo $formGroupLabel; ?>">Major</label>
								<div class="<?php echo $formGroupItem; ?>">
									<p class="form-control-static"><?php echo $majorName; ?></p>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label <?php echo $formGroupLabel; ?>">Current Program</label>
								<div class="<?php echo $formGroupItem; ?>">
									<p class="form-control-static"><?php echo $currentProgramText; ?></p>								
								</div>
							</div>

							<div class="form-group">
								<label class="control-label <?php echo $formGroupLabel; ?>">Current Cycle</label>
								<div class="<?php echo $formGroupItem; ?>">
									<p class="form-control-static"><?php echo $currentCycleText; ?></p>								
								</div>
							</div>
						</form>
					</div>

		</div>
	</div>
</div>

<?php
require_once(TEMPLATES_PATH . "/footer.php");
?>

<script type="text/javascript">



</script>