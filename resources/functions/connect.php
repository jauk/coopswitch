<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");


// // Need to store these vals more securely. Also, dev vs production db
// $dbserver = "localhost";
// $dbuser = "root";
// $dbpass = "";
// $database = "coop_dev";

// What database should we use

$config = getConfig();

if ($_SERVER['SERVER_NAME'] == $config['urls']['baseUrl'] || $_SERVER['SERVER_NAME'] == $config['urls']['baseUrl2'] ) {
	$db_in_use = 'vps';
}
else {
	$db_in_use = 'development';
}
// echo $config['db']['development']['dbname'];

// Est connection to database.
// $con = mysql_connect(
// 				$config['db'][$db_in_use]['dbhost'], 
// 				$config['db'][$db_in_use]['dbuser'],
// 				$config['db'][$db_in_use]['dbpass']
// 			);
// if (!$con)
//   {
// 	die('Could not connect: ' . mysql_error());
//   }

//$db_found = mysql_select_db($config['db'][$db_in_use]['dbname'], $con);

	$con = new mysqli(
		$config['db'][$db_in_use]['dbhost'], 
		$config['db'][$db_in_use]['dbuser'],
		$config['db'][$db_in_use]['dbpass'],
		$config['db'][$db_in_use]['dbname']
	);


if ($con->connect_error) {
	trigger_error('Database connection failed: ' . $con->connect_error, E_USER_ERROR);
}
else {
	// echo "Connected.";
}

?>