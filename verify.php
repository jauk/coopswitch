<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");

$email = test_input($_GET['a']);
$submitHash = test_input($_GET['b']);

include_once(FUNCTION_PATH . "/connect.php");

$query = 'SELECT * FROM Users WHERE email = "' . $email . '"';
$result = mysql_query($query);

$user = array();
$user = mysql_fetch_array($result);

$combo = $user['name'] . $user['email'] . $user['cycle'];
$userHash = hash('sha256', $combo);

if ($user['verified'] == 1) {

	die("Email already verified.");
}

else if ($userHash == $submitHash) {

	$sql = 'UPDATE Users SET verified = 1 WHERE email = "' . $email . '"';
    $result = mysql_query($sql);

    if (isset($_SESSION['login'])) {

    	if ($_SESSION['email'] == $email) {
    		$_SESSION['user_email_verified'] = 1;
    	}
    }

    header("Location: account.php");
}

else {
	header("Location: error.php?msg=5");	
}

mysql_close($con);

?>
