<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
	require_once(TEMPLATES_PATH . "/header.php");
	include(FUNCTION_PATH . "/connect.php");

	// Get the user we are talking to and save them into a local array.
	/* Probably do not need this, use session vars since they are from db. */
	$query = "SELECT * FROM Users WHERE id = " . $_SESSION['user_id'];
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);

	$user_data = $row;

	// Need to tell which value is being updated too
	// Update for one master form soon

	if (isset($_POST['newMajorId'])) {
		$newUserMajor = test_input($_POST['newMajorId']);

		updateField("major", $newUserMajor);
	}

	if (isset($_POST['newCycleId'])) {
		$newUserCycle = test_input($_POST['newCycleId']);

		updateField("cycle", $newUserCycle);
	}

	if (isset($_POST['newProgramId'])) {
		$newUserProgram = test_input($_POST['newProgramId']);

		updateField("num_year_program", $newUserProgram);
	}

	// ON ALL UPDATES UNDO THE MATCHES (For both users). IMP. Also verify major actually changes in db.

	check_for_match();
	header("Location: account.php");

	function updateField($field, $newFieldVal) {

		global $user_data;

		// Update the field.
		if ($user_data[$field] != $newFieldVal) {
			$query = 'UPDATE Users SET ' . $field . ' = ' . $newFieldVal . ' WHERE id = ' . $_SESSION['user_id'];

			$result = mysql_query($query);

			// Change session vars.
			switch ($field):
				case "major":
					$_SESSION['user_major'] = $newFieldVal;
					$_SESSION['user_major_name'] = getMajorName($newFieldVal);
					break;
				case "cycle":
					$_SESSION['user_cycle'] = $newFieldVal;
					if ($newFieldVal == 1)
						$_SESSION['user_cycle_name'] = "Fall-Winter";
					else if ($newFieldVal == 2)
						$_SESSION['user_cycle_name'] = "Spring-Summer";
					break;
				case "num_year_program":
					$_SESSION['user_program'] = $newFieldVal;
					if ($newFieldVal == 1)
						$_SESSION['user_program_name'] = "1 co-op";
					else if ($newFieldVal == 2)
						$_SESSION['user_program_name'] = "3 co-ops";
					break;
			endswitch;	
		}
	}

	function check_for_match() {

		$user_data = array();
		$user_data = $GLOBALS["user_data"];
		//echo "ID: " . $user_data['id'] . "<br>Matched? " . $user_data['matched'] . "<hr>";
		//echo '$GLOBALS["user_data['id']"]';

		/* Create dropped_match var for users, only let them drop one match.
			Warn before editing profile vals when match in progress.
			- If not currently matched, does not matter. */

		// Should check if matched first before going through code
		if ($user_data['matched'] == 1) {
			// Get the ID of the other user.
			$other_user_id = mysql_get_var("SELECT id FROM Users WHERE Matches_id = " . $user_data['Matches_id'] . " AND id != " . $user_data['id']);

			// Reset the match vars for both users
			$query = "UPDATE Users SET matched = 0 WHERE id = " . $user_data['id'] . " OR id = " . $other_user_id;
		    $result = mysql_query($query);

		    $query = "UPDATE Users SET Matches_id = 0 WHERE id = " . $user_data['id'] . " OR id = " . $other_user_id;
		    $result = mysql_query($query);

		    // Should we delete row from Matches or keep for historical purposes? Delete for now.
		   	$query = "DELETE FROM Matches WHERE id = " . $user_data['Matches_id'];
		   	$result = mysql_query($query);
		   
		   	// Add the dropped match to db for user dropping (add to current)
		   	$query = "UPDATE Users SET dropped_matches = " . ($user_data['dropped_matches']+1) . " WHERE id = " . $user_data['id'];
		   	$result = mysql_query($query);

		   	//Lets reset those session vars, too.

		   	$_SESSION['user_matched'] = 0;
		   	$_SESSION['Matched_id'] = 0;
		   	$_SESSION['user_dropped_matches'] += 1;

		   	echo "Match dropped.";
		  	//echo "<br>Matched? " . $_SESSION['user_matched'];
		}

	}


	// Update Majors
	/*
	if (isset($newUserMajor) && ($user_data['major'] != $newUserMajor))
	{
		$query = "UPDATE Users SET major = " . $newUserMajor . " WHERE id = " . $_SESSION['user_id'];
		$_SESSION['user_major'] = $newUserMajor;

		// Update user's major name too. OLD WAY
		$result = mysql_query("SELECT major_long FROM Majors WHERE id = " . $_SESSION['user_major']);
		$row = mysql_fetch_array($result);
		$_SESSION['user_major_name'] = $row['major_long'];

		 // Send back (ACCOUNT UPDATED) message?
	}

	// Update Cycles
	else if (isset($newUserCycle) && ($user_data['cycle'] != $newUserCycle))
	{
		$query = "UPDATE Users SET cycle = " . $newUserCycle . " WHERE id = " . $_SESSION['user_id'];
		$_SESSION['user_cycle'] = $newUserCycle;

		if ($newUserCycle == 1)
			$_SESSION['user_cycle_name'] = "Fall-Winter";
		else if ($newUserCycle == 2)
			$_SESSION['user_cycle_name'] = "Spring-Summer";

	}

	/// Update Programs
	else if (isset($newUserProgram) && ($user_data['num_year_program'] != $newUserProgram)) {
		$query = "UPDATE Users SET num_year_program = " . $newUserProgram . " WHERE id = " . $_SESSION['user_id'];
		$_SESSION['user_program'] = $newUserProgram;

		if ($newUserProgram == 1)
			$_SESSION['user_program_name'] = "1 co-op";
		else if ($newUserProgram == 2)
			$_SESSION['user_program_name'] = "3 co-ops";

	}
	*/




	if (!mysql_query($query,$con)) {
		die('Error: ' . mysql_error());
	}

	else {
	}

	// Use header location thing go back account page display "UPDATED" message
	// Use a session var for now that resets after displaying message, not very efficient. Maybe use GET eventually
	
	mysql_close($con);
?>

<!-- start: 150 lines -->