<?php

include_once('header.php');

echo 'Session destroyed maybe. <a href="index.php">Home</a>';

$_SESSION['login'] = "";

// Probably a better way to do this. Also unset all oher session variables.

?>