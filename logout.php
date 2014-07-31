<?php

session_start();

$_SESSION = array();

session_destroy();
session_unset();

$_GLOBALS['login'] = False;

header("Location: index.php");

?>