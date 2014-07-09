<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");
include(FUNCTION_PATH . "/connect.php");

if ($_SERVER['CONTENT_LENGTH'] == 0) {
	header('Location: /error.php?msg=3');
	// Make a global "ERROR" variable that also sends to error page to choose which error to display?
}

if (isset($_SESSION['login'])) {
	header('Location: /error.php?msg=4');
}

$email = test_input($_POST['email']);

$query = 'SELECT * FROM Users WHERE email = "' .$email. '"';
$result = mysql_query($query);

if (mysql_num_rows($result) != 0) {

	die("Email already registered.");
}

// Check against email existing, how have I not done this already oops.

else {

	// Sanitize post data
	$name = test_input($_POST['name']);
	$password = test_input($_POST['password']);
	$password = md5($password);
	$cycle = test_input($_POST['cycle']);
	$num_year_program = test_input($_POST['numCoops']);
	$majorVal = test_input($_POST['major']);

	$majorName = getMajorName($majorVal);

	$sql="INSERT INTO Users (name, password, email, cycle, num_year_program, major, register_date)
		VALUES ('$name','$password', '$email','$cycle', '$num_year_program', '$majorVal',
				'".date("Y-m-d H:i:s")."'
	 )";

	//$registerLinkBase = "http://coopswitch.com/verify?a=$email&b=";
	$registerLinkBase = "http://coop.localhost/verify?a=$email&b=";

	$combo = $name . $email . $cycle;
	$link = hash('sha256', $combo);

	$verifyLink = $registerLinkBase . $link;

	if (!mysql_query($sql,$con)) {
	  	die('Error: ' . mysql_error());
	  }

	else {
		send_init_email($name, $email, $verifyLink); // Success, user has been created.
	}

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