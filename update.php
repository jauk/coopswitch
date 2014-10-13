<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
	require_once(TEMPLATES_PATH . "/header.php");
	include(FUNCTION_PATH . "/connect.php");
	// include(FUNCTION_PATH . "/scripts.php");


	// Get the user we are talking to and save them into a local array.
	// $query = "SELECT * FROM Users WHERE id = " . $_SESSION['user_id'];
	// $result = mysql_query($query);
	// $row = mysql_fetch_array($result);

	$user_data = array();
	$user_data = getUserDataFromId($_SESSION['user_id']);

	foreach ($_POST as $key => $value) {
			$key = test_input($key);
			$value = test_input($value);
		  updateField($key, $value);
	}

	check_for_match();

	// ON ALL UPDATES UNDO THE MATCHES (For both users). IMP. Also verify major actually changes in db.

	//echo $newUserMajor;



	function updateField($field, $newFieldVal) {

		global $user_data;
		global $con;

		// Update the field.
		//if ($user_data[$field] != $newFieldVal) {
			$sql = 'UPDATE Users SET ' . $field . ' = "' . $newFieldVal . '" WHERE id = ' . $_SESSION['user_id'];

			if (!$con->query($sql)) {
		  	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->error, E_USER_ERROR);		
			}

			// Change session vars.
			switch ($field):
				case "major":
					$_SESSION['user_major'] = $newFieldVal;
					$_SESSION['user_major_name'] = getMajorName($newFieldVal);
					break;
				case "cycle":
					$_SESSION['user_cycle'] = $newFieldVal;
					$_SESSION['user_cycle_name'] = getName("cycle", $newFieldVal);
					break;
				case "num_year_program":
					$_SESSION['user_program'] = $newFieldVal;
					$_SESSION['user_program_name'] = getName("program", $newFieldVal);
					break;
			endswitch;	
	//	}
	}

	function check_for_match($user_data = NULL, $withdraw = NULL) {

		if ($user_data == NULL) {
			$user_data = array();
			$user_data = $GLOBALS["user_data"];
		}

		// If user is matched, drop the match
		if ($user_data['matched'] == 1) {

			// Get the ID of the other user.
			$other_user_id = mysql_get_var("SELECT id FROM Users WHERE Matches_id = " . $user_data['Matches_id'] . " AND id != " . $user_data['id']);

			$sql = "SELECT * FROM Users WHERE id = " . $other_user_id;
			$result = $con->query($sql);
			$other_user_data = $result->fetch_array(MYSQLI_ASSOC);

			// Reset the match vars for both users
			$sql = "UPDATE Users SET matched = 0 WHERE id = " . $user_data['id'] . " OR id = " . $other_user_data['id'];
	    $result = $con->query($sql);

	    $sql = "UPDATE Users SET Matches_id = 0 WHERE id = " . $user_data['id'] . " OR id = " . $other_user_data['id'];
	    $result = $con->query($sql);

	    // Should we delete row from Matches or keep for historical purposes? Delete for now.
	   	$sql = "DELETE FROM Matches WHERE id = " . $user_data['Matches_id'];
	    $result = $con->query($sql);
	   
	   	// Add the dropped match to db for user dropping (add to current)
	   	// Do not add dropped match if reason = user unresponsive (unsure of actual situation).
	   	if ($withdraw != 2) {
	   		$sql = "UPDATE Users SET dropped_matches = " . ($user_data['dropped_matches']+1) . " WHERE id = " . $user_data['id'];
	    	$result = $con->query($sql);
	   	}


		   	//Lets reset those session vars, too.

		   	$_SESSION['user_matched'] = 0;
		   	$_SESSION['Matched_id'] = 0;
		   	$_SESSION['user_dropped_matches'] += 1;

		   	echo "Match dropped.";
		  	//echo "<br>Matched? " . $_SESSION['user_matched'];

		   	// Email both users to let them know.
		   	if ($withdraw == 0) {
			   	mail_user_dropper($user_data['name'], $user_data['email']);
			   	mail_user_dropped($other_user_data['name'], $other_user_data['email']);		   		
		   	}
		   	else if ($withdraw == 1) {
		   		// User has withdrawed their account. Other user needs to be notified their match is being dropped.
		   		// Email the user who is getting dropped. User withdrawing will get different email.


		   	}
		   	else if ($withdraw == 2) {
		   		// Withdraw is done because: user B is not responsive. 
		   		// User A is put back into queue. User B is marked as withdrawn and sent email.

		   		// Set as withdrawn.
		   		$sql = 'UPDATE Users SET withdraw = 1 WHERE id = '.$other_user_data['id'];
		    	$result = $con->query($sql);

		   		

		   	}

		}

	}


	// Use header location thing go back account page display "UPDATED" message
	// Use a session var for now that resets after displaying message, not very efficient. Maybe use GET eventually
	
	//mysql_close($con);
?>

<!-- start: 150 lines -->