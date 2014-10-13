<?php

	require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
	require_once(TEMPLATES_PATH . "/header.php");
	include(FUNCTION_PATH . "/connect.php");
	
	if (!isset($_POST['email']) || $_POST['email'] == "") { die("No email. "); } 
	if (!isset($_POST['password']) || $_POST['password'] == "") { die("No password. "); } 

	$umail = test_input($_POST['email']);
	$upass = test_input($_POST['password']);

  // Make sure it is a valid email address
	// if (!filter_var($umail, FITLER_VALIDATE_EMAIL)) {
	// 	header("Location: /error.php?msg=1");
	// }


	/* Learn about quote_smart funcion for sql injection protection! IMPORTANT! */
	// $umail = quote_smart($uname, $con);
	// $upass = quote_smart($upass, $con);

	// Switch password to md5 version for db checking
	$upass=sha1($upass);

	$sql = "SELECT * FROM Users WHERE email = '$umail' AND password = '$upass'";
	$result = $con->query($sql);

	if (!$result) {
		die(mysql_error());
		$errorMessage = "Error logging on. 2";
	}

	$num_rows = $result->num_rows;

	if ($num_rows == 1) { // Because there should only be one result or there is a big problem.

    // Init blank array for user
		$user_data = array();

    // Grab the row with user data and save into array.
	  $user_data = $result->fetch_assoc();

	  //$user_data = $row; // Save the user's info in an array.

		$errorMessage = "Logged on!"; // Hooray, we are logged on.

		/* Get information from user's row and save in session variables */
		login_user($user_data);

		// Var names
		// TODO: foreach for all session vars
    $_SESSION['user_major_name'] = getMajorName($user_data['major']);
    $_SESSION['user_cycle_name'] = getName("cycle", $user_data['cycle']);
    $_SESSION['user_program_name'] = getName("program", $user_data['num_year_program']);


    // Redirect to accounts page
		header("Location: /account.php");
	}
	else {
		header("Location: /error.php?msg=2");
	}

?>

<div class="container-fluid">

	<div class="row-fluid col-md-6 col-md-offset-3 text-center">
		<div class="panel-heading alert alert-warning">
			<h4><?php print "$errorMessage"; ?></h4>
		</div>
	</div>

</div>

<?php
require_once(TEMPLATES_PATH . "/footer.php");
?>