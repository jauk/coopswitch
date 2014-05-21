<?php

$dbserver = "localhost";
$dbuser = "root";
$dbpass = "";

$con = mysql_connect("$dbserver","$dbuser","$dbpass");
if (!$con)
  {
	die('Could not connect: ' . mysql_error());
  }

mysql_select_db("coop_dev", $con);

?>