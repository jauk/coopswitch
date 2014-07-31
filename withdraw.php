<?php
require_once(__DIR__ . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");

// Include for the check_for_match function, move to functions.php eventually
include_once("update.php");

include(FUNCTION_PATH . "/connect.php");

$action = test_input($_GET['act']);

if ($_SESSION['login'] == 1) {


	if ($action == "withdraw") {

		// Set withdraw = 1
		$query = 'UPDATE Users SET withdraw = "1" WHERE id = ' . $_SESSION['user_id'];
		$result = mysql_query($query);
		$_SESSION['withdraw'] = 1;

		$user_data = getUserDataFromId($_SESSION['user_id']);

		// If matched, drop the match, update vars, email users.
		check_for_match($user_data, "1");
	}

	else if ($action == "rejoin") {

		$query = 'UPDATE Users SET withdraw = "0" WHERE id = ' . $_SESSION['user_id'];
		$result = mysql_query($query);
		$_SESSION['withdraw'] = 0;

		// Set new date
		$_SESSION['user_reactivated_date'] = date("Y-m-d H:i:s");
		
		$query = 'UPDATE Users SET new_date = ' . $_SESSION['user_reactivated_date'];
		$result = mysql_query($query);

	}

	mysql_close($con);

	header("Location: account.php?withdraw=1");
}


?>