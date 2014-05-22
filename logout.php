<?php

include_once('header.php');

echo 'Session destroyed maybe. <a href="index.php">Home</a>';


session_destroy();
$_SESSION = array();
//$_SESSION['login'] = "";

header("Location: index.php");

// Probably a better way to do this. Also unset all oher session variables.

?>