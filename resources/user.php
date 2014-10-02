<?php

	session_start();

	switch ($_SERVER['QUERY_STRING']) {

		case 'g=name' :
			$name = (isset($_SESSION['user_name'])) ? $_SESSION['user_name'] : "Error: No Name.";
			echo $name;
			break;

		case 'g=email' :
			$email = (isset($_SESSION['user'])) ? $_SESSION['user'] : "Error: No Email.";
			echo $email;
			break;

	}

	// if ($_GET["g"] == "name") {

	// 		if (!isset($_SESSION['user_name'])) {
	// 		//	throw new Exception('No name found. Is user logged in?');
	// 			echo("Error: No Name.");
	// 		}
	// 		else {
	// 			$name = $_SESSION['user_name'];
	// 			echo $name;
	// 		}
	// }


?>