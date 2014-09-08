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
	$password = md5($password);
}
else {
	die("Passwords do not match.");
}

$cycle = test_input($_POST['cycle']);
$num_year_program = test_input($_POST['numCoops']);
$majorVal = test_input($_POST['major']);

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
VALUES ('$name','$password', '$email','$cycle', '$num_year_program', '$majorVal',
		'".date("Y-m-d H:i:s")."'
	)";

$verifyLink = getVerifyLink($name, $email, $cycle);

if (!mysql_query($sql,$con)) {
  	die('Error: ' . mysql_error());
}

else {
	send_init_email($name, $email, $verifyLink); // Success, user has been created.
}


mysql_close($con);

?>

<br />
<div class="container">

	<div class="row">
		<div class="col-sm-6 col-sm-offset-3 text-center">
			<div class="panel panel-default">
				<div class="panel-heading">
					<p class="lead">Hi, <?php echo $name; ?>!</p>
				</div>
				<div class="text-info bg-info lead" style="padding: 10px;">
					<p>Please check your email to verify your account.</p>
				</div>
				<div class="panel-body">
					<p>Your Drexel email address is: <?php echo $email; ?></p>

					<p>
					<?php
						if ($num_year_program == 1)
							echo "You are in the 4 year, 1 co-op program.";
						else
							echo "You are in the 5 year, 3 co-op program";
					?>
					</p>

					<p>
					<?php
						if ($cycle == 1)
							echo "You <strong>want</strong> a Spring-Summer co-op cycle.";
						else
							echo "You <strong>want</strong> a Fall-Winter co-op cycle.";
					?>
					</p>

					<p>
					We need to find other <strong><?php echo "$majorName"; ?></strong> majors!
					</p>
				</div>
			</div>
		</div>
	</div>
	
</div>

<?php
require_once(TEMPLATES_PATH . "/footer.php");
?>