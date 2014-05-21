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

	// Learn about quote_smart funcion for sql injection protection! IMPORTANT!
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

	if ($num_rows == 1) {

		$row = mysql_fetch_row($result);

		echo "$row[0]";
		echo "$row[1]";
		echo "$row[2]";


		$errorMessage = "Logged on!"; // Hooray, we are logged on.

		/* Get information from user's row and save in session variables */

		//session_start();
		$_SESSION['login'] = "1";
		$_SESSION['user'] = $umail;
		$_SESSION['user_name'] = "";
		$_SESSION['user_major'] = "";



		//echo "$_SESSION['login']";
		header("Location: account.php");

	}
	else {
		$errorMessage = "Invalid Login.";
		//session_start();
		$_SESSION['login']="";
	}

	echo "$errorMessage";
	echo "Hi {$_SESSION['login']}";

	include_once('footer.php');
?>