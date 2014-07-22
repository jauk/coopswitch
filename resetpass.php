<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");
include_once(FUNCTION_PATH . "/connect.php");




if (isset($_POST['email'])) {
	
	echo $_POST['email'];

	$email = test_input($_POST['email']);

	$name = mysql_get_var('SELECT name FROM Users WHERE email = ' . $email);

	if (isset($name) && $name != "") {
		reset_pass_email($name, $email);
	}
	else {

	}

}

header("Location: error.php?action=resetsent"); // Also have "Email sent message"

?>