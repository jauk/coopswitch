<?php

$dbserver = "localhost";
$dbuser = "root";
$dbpass = "";
$database = "coop_dev";

$con = mysql_connect("$dbserver","$dbuser","$dbpass");

if (!$con)
  {
	die('Could not connect: ' . mysql_error());
  }

$db_found = mysql_select_db($database, $con);

?>