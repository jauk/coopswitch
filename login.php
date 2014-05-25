<?php
	include_once('header.php');
	include_once('connect.php');
	
	$umail = test_input($_POST['email']);
	$upass = test_input($_POST['password']);

	if ($db_found) {
	}
	else {
		$errorMessage = "Error logging on. 1";
	}

	/* Learn about quote_smart funcion for sql injection protection! IMPORTANT! */
	// $umail = quote_smart($uname, $con);
	// $upass = quote_smart($upass, $con);

	// Will make more secure...later.
	$upass=md5($upass);

	$sql = "SELECT * FROM Users WHERE email = '$umail' AND password = '$upass'";
	$result = mysql_query($sql);

	if ($result){

	}
	else {
		die(mysql_error());
		$errorMessage = "Error logging on. 2";
	}

	$num_rows = mysql_num_rows($result);

	//session_destroy();

	if ($num_rows == 1) { // Because there should only be one result or there is a big problem.

		$user_data = array();

		$index = 0;
		while ($row = mysql_fetch_array($result))
		{
			$user_data[$index] = $row; // Save the user's info in an array.
		}

		// echo $user_data[0]['email'];

		$errorMessage = "Logged on!"; // Hooray, we are logged on.

		/* Get information from user's row and save in session variables */

		login_user($user_data);

		header("Location: account.php"); 
	}
	else {
		$errorMessage = "Invalid Login.";
		//session_start();
		$_SESSION['login']="";
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
	include_once('footer.php');
?>