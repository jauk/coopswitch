<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");
include(FUNCTION_PATH . "/connect.php");

$url = "http://" . $_SERVER['SERVER_NAME'];

if ($_SERVER['CONTENT_LENGTH'] == 0) {
	header("Location: " . $url . "/error.php?msg=3");
	die();
	//break;
	// Make a global "ERROR" variable that also sends to error page to choose which error to display?
}

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

global $email;

$email = test_input($_POST['email']);

$query = 'SELECT * FROM Users WHERE email = "' .$email. '"';
$result = mysql_query($query);

if (mysql_num_rows($result) != 0) {

	header("Location: " . $url . "/error.php?msg=1");
	die();
	//break;
}

else if (!$result) { // May not actually work since its not supposed to return results. Check when have db.

	header("Location: " . $url . "/error.php");
	die();
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

	// User has specified they have someone they want to switch with
	if (isset($_POST['otherUserEmail'])) {
		$otherUserEmail = test_input($_POST['otherUserEmail']);

		$query = 'SELECT * FROM Users WHERE email = "' .$otherUserEmail;
		$result = mysql_query($query);
 
		if (mysql_num_rows($result) != 0) { // Other user already signed up with that email

			$otherUser = array();
			$row = mysql_fetch_assoc($result);
			$otherUser = $row;

			// See if other user put this user's email down as potential manual switch
			if (isset($otherUser['manualMatchUser']) && $otherUser['manualMatchUser'] == $email) {
				// If both users have each other, double check their profile elements

				// If same major, same year program, opposite cycle.
				if ($majorVal == $otherUser['major'] && 
						$num_year_program == $otherUser['num_year_program'] &&
						$cycle != $otherUser['cycle']) {
							// Switch would work, put together

							// Need to verify email first tho!
						
				
				}
				else {
					// Profile fields not compatible for switch
					$manualSwitchMsg = "Sorry, the user you specified cannot be switch with. 
					Please make sure you have the same major, have the same number of coops, and are not in the same major.";
				}

			}

			// Else, did not set (yet?)
			else {

			}


		}
		else { 	// Other user has not even registered 


		}


	}

	$sql="INSERT INTO Users (name, password, email, cycle, num_year_program, major, register_date)
		VALUES ('$name','$password', '$email','$cycle', '$num_year_program', '$majorVal',
				'".date("Y-m-d H:i:s")."'
	 )";

	//$registerLinkBase = "http://coopswitch.com/verify?a=$email&b=";

	$verifyLink = getVerifyLink($name, $email, $cycle);

	if (!mysql_query($sql,$con)) {
	  	die('Error: ' . mysql_error());
	}

	else {
		send_init_email($name, $email, $verifyLink); // Success, user has been created.

		// Log in user for first time auto
		// $id = mysql_get_var("SELECT id FROM Users WHERE email = " . $email);
		// $user_data = getUserDataFromId($id);
		// login_user($user_data);
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