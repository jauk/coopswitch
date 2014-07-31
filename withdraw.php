<?php
require_once(__DIR__ . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");

// Include for the check_for_match function, move to functions.php eventually
include_once("update.php");

include(FUNCTION_PATH . "/connect.php");

if ($_SESSION['login'] == 1) {

	// Set withdraw = 1
	$query = 'UPDATE Users SET withdraw = "1" WHERE id = ' . $_SESSION['user_id'];
	$result = mysql_query($query);
	$_SESSION['withdraw'] = 1;

	$user_data = getUserDataFromId($_SESSION['user_id']);

	// If matched, drop the match, update vars, email users.
	check_for_match($user_data);
	mysql_close($con);

	header("Location: account.php?withdraw=1");
}


?>