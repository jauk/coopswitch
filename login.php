<?php
	include_once('header.php');
	include_once('connect.php');
	
	$umail = htmlspecialchars($_POST['email']);
	$upass = htmlspecialchars($_POST['password']);

	if ($db_found) {

	}
	else {

		$errorMessage = "Error logging on. 1";
	}

	/* Learn about quote_smart funcion for sql injection protection! IMPORTANT! */
	// $umail = quote_smart($uname, $con);
	// $upass = quote_smart($upass, $con);

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

		$_SESSION['login'] = "1";

		$_SESSION['user'] = $user_data[0]['email'];
		$_SESSION['user_name'] = $user_data[0]['name'];

		// Get the actual major name not the numerical representation
		$result = mysql_query("SELECT major_long FROM Majors WHERE id= " . $user_data[0]['major']);
		$row = mysql_fetch_array($result);
		$_SESSION['user_major_name'] = $row['major_long'];

		$_SESSION['user_major'] = $user_data[0]['major'];

		$_SESSION['user_cycle'] = $user_data[0]['cycle'];

		/* Cycle and program names not working yet. Fix that. */

		// Say what the cycle actually is
		if ($_SESSION['user_cycle'] == 1)
			$_SESSION['user_cycle_name'] == "Fall-Winter";
		else
			$_SESSION['user_cycle_name'] == "Spring-Summer";

		$_SESSION['user_program'] = $user_data[0]['num_year_program'];

		// Say what the program actually is
		if ($_SESSION['user_program'] == 1)
			$_SESSION['user_program_name'] == "1 co-op";
		else
			$_SESSION['user_program_name'] == "3 co-ops";

		$_SESSION['user_matched'] = $user_data[0]['matched']; // This will have to be updated or something when searches are done...

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
		<div class="panel-heading">
			<h4><?php print "$errorMessage"; ?></h4>
		</div>	
	</div>

</div>

<?php
	include_once('footer.php');
?>