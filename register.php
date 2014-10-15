<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
// require_once(TEMPLATES_PATH . "/header.php");
include(FUNCTION_PATH . "/connect.php");
include(FUNCTION_PATH . "/scripts.php");

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

$userData = $_POST;

$submitData = count($userData);

if ($submitData != 7) {
	die("Invalid registration submission.");
}

else {
	foreach ($userData as $key => $value) {
		$userData[$key] = test_input($value);
		if ($value == "") {
			die("Error: " . $key . " cannot be null.");
		}
	}
}

$password = test_input($_POST['password']);
$password2 = test_input($_POST['password2']);

if ($userData['password'] == $userData['password2']) {
	$password = sha1($userData['password']);
}
else {
	die("Passwords do not match.");
}

// See if email is already in use
$sql = 'SELECT * FROM Users WHERE email = "' .$userData['email']. '"';
$result = $con->query($sql);

// Not 0 means the email already exists.
if ($result->num_rows != 0) {
	header("Location: /error?msg=emailinuse");
	die();
}


// Add user to db
// TODO: UPDATE VARS TO USE OBJ
$sql="INSERT INTO Users (name, password, email, cycle, num_year_program, major, register_date)
VALUES ('$name','$password', '$email','$cycle', '$num_year_program', '$major',
		'".time()."'
	)";


if (!$con->query($sql)) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->error, E_USER_ERROR);
}

else {
	$verifyLink = getVerifyLink($name, $email, $cycle);
	send_init_email($name, $email, $verifyLink); // Success, user has been created.
	echo "Registration successful!";
}

// $majorName = getMajorName($major);

$formGroupLabel = "col-sm-4 col-sm-offset-1";
$formGroupItem = "text-primary col-sm-7";

?>

<!--
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
 -->


<?php
require_once(TEMPLATES_PATH . "/footer.php");
?>

<script type="text/javascript">



</script>