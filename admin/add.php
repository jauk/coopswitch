<?php

	include "connect.php";
	
	$userData = array();
	$valid = true;

	foreach ($_POST as $key => $value) {

		if ($value == null) {
			$value = "null";
			echo $key . ", ";
			$valid = false;
		}

		$userData[$key] = $value;
	}

	if ($valid) {

		$sql = 'INSERT INTO Users (name, email, registerDate, cycle, program, major) '.
					 'VALUES ("'.$userData['userName'].'", "'.$userData['userEmail'].'", "'.time().'", "'
								 			.$userData['userCycle'].'", "'.$userData['userCoops'].'", "'.$userData['userMajor'].'"
		)';

		if (!$con->query($sql)) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->error, E_USER_ERROR);
		}
		else {
			echo "1";
		}

	}

?>