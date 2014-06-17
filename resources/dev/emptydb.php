<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
	require_once(TEMPLATES_PATH . "/header.php");
	include(FUNCTION_PATH . "/connect.php");

	$result = mysql_query($sql);

	$sql = "DELETE FROM Matches";
	$result = mysql_query($sql);

	$sql = "ALTER TABLE Users AUTO_INCREMENT = 1";
	$result = mysql_query($sql);

	$sql = "ALTER TABLE Matches AUTO_INCREMENT = 1";
	$result = mysql_query($sql);

	mysql_close($con);

	echo "Records deleted.";

	require_once(TEMPLATES_PATH . "/footer.php");
?>