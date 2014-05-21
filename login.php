<?php
	include_once('header.php');
	include_once('connect.php');
	
	htmlspecialchars($_POST['email']);
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

	if ($num_rows == 1) {
		$errorMessage = "Logged on!";
		session_start();
		$_SESSION['login']="1";
		header("Location: account.php");

	}
	else {
		$errorMessage = "Invalid Logon.";
		session_start();
		$_SESSION['login']="";
	}


	include_once('footer.php');
?>

<?php print $errorMessage;?>
