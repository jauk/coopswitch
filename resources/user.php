<?php

	session_start();

	if (isset($_SESSION['login']) && $_SESSION['login'] == 1) {

		$user = new stdClass();

		$user->name = $_SESSION['user_name'];
		$user->email = $_SESSION['user'];
		$user->id = $_SESSION['user_id'];
		$user->verified = $_SESSION['user_email_verified'];

		$user->major = $_SESSION['user_major'];
		$user->majorName = $_SESSION['user_major_name'];

		$user->cycle = $_SESSION['user_cycle'];
		$user->cycleName = $_SESSION['user_cycle_name'];

		$user->program = $_SESSION['user_program'];
		$user->programName = $_SESSION['user_program_name'];

		$user->withdraw = $_SESSION['withdraw'];

		$user->isMatched = $_SESSION['user_matched'];
		$user->droppedMatchess = $_SESSION['user_dropped_matches'];


		$json_user = json_encode($user, JSON_PRETTY_PRINT);
		echo $json_user;

	}

	else {

		echo "No user logged in.";
		// die("Not logged in.");
	}

	// switch ($_SERVER['QUERY_STRING']) {

	// 	case 'g=name' :
	// 		$name = (isset($_SESSION['user_name'])) ? $_SESSION['user_name'] : "Error: No Name.";
	// 		echo $name;
	// 		break;

	// 	case 'g=email' :
	// 		$email = (isset($_SESSION['user'])) ? $_SESSION['user'] : "Error: No Email.";
	// 		echo $email;
	// 		break;

	// }

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