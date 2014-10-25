<?php

	$dbHost = "localhost";
	$dbUser = "root";
	$dbPass = "";
	$dbName = "coopDev";

	$con = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

	if ($con->connect_error) {
		trigger_error("Cannot connect: " . $con->connect_error, E_USER_ERROR);
	}

	if (isset($_GET['g']))
		initTables($con);

	function initTables($con) {

		$sql = 'CREATE TABLE IF NOT EXISTS Users 
			(userId INT AUTO_INCREMENT PRIMARY KEY, 
			 name VARCHAR(255) NOT NULL,
			 email VARCHAR(255) NOT NULL, 
			 registerDate INT(255) NOT NULL,
			 cycle INT(255) NOT NULL, 
			 program INT(255) NOT NULL, 
			 major INT(255) NOT NULL, 
			 hasSwitched INT(255) NOT NULL,
			 switchId INT(255) NOT NULL, 
			 hasWithdrawn INT(255) NOT NULL
		)';
	
		createTable($con, $sql);

		$sql = 'CREATE TABLE IF NOT EXISTS Switches
			(switchId INT AUTO_INCREMENT PRIMARY KEY,
			 userA VARCHAR(255) NOT NULL, 
			 userB VARCHAR(255) NOT NULL, 
			 major VARCHAR(255) NOT NULL,
			 status VARCHAR(255) NOT NULL,
			 switchPairTime VARCHAR(255) NOT NULL, 
			 switchFinishTime VARCHAR(255) NOT NULL
		)';

		createTable($con, $sql);

	}


	function createTable($con, $sql) {

		if (!$con->query($sql)) {
			echo "Table creation failed.<br>";
		}

		else {
			echo "Table created!<br>";
		}
	}

?>