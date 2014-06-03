<?php

// Need to store these vals more securely. Also, dev vs production db
$dbserver = "localhost";
$dbuser = "root";
$dbpass = "";
$database = "coop_dev";

// Est connection to database.
$con = mysql_connect("$dbserver","$dbuser","$dbpass");
//$con = new PDO("mysql:host=$host;dbname=$database", "$dbuser", "dbpass");


if (!$con)
  {
	die('Could not connect: ' . mysql_error());
  }

$db_found = mysql_select_db($database, $con);

?>