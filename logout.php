<?php

//include_once('header.php');

session_start();

echo 'Session destroyed maybe. <a href="index.php">Home</a>';

$_SESSION = array();

// if (isset($_SESSION['user'])) {
session_destroy();
session_unset();

// echo "User exists.";
// }

//$_SESSION['login'] = "";

header("Location: index.php");

// Probably a better way to do this. Also unset all oher session variables.

?>