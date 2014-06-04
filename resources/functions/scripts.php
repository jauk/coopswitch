<?php

/* Lets store scripts here to make our code more efficient. */

function print_majors() {
	$query="SELECT * FROM Majors";
	$result=mysql_query($query);
	$numMajors=mysql_num_rows($result);

	$i=0; while ($i < $numMajors) {
		$major_name=mysql_result($result, $i, "major_long");
		$major_ident=mysql_result($result, $i, id);

		if ($_SESSION['user_major'] == $major_ident)
			echo '<option selected="selected" value=' . $major_ident . '>' . $major_name . '</option> \n\t\t\t\t\t\t';
		else
			echo "<option value=" . $major_ident . ">" . $major_name . "</option> \n\t\t\t\t\t\t";

		$i++;
	}

	$major_ident = 0;
	$major_name = "";
}

// Not my function
function mysql_get_var($query,$y=0) {
   $res = mysql_query($query);
   $row = mysql_fetch_array($res);
   mysql_free_result($res);
   $rec = $row[$y];
   return $rec;
}

function get_match_info() {
	// Update user_matched_id in-case they were logged in when a matched happened.
	$_SESSION['user_matched_id'] = mysql_get_var("SELECT Matches_id FROM Users WHERE id = " . $_SESSION['user_id']);

	$query = "SELECT * FROM Matches WHERE id = " . $_SESSION['user_matched_id'] . "";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);

	$matched_data = array();
	$matched_data[0] = $row; // Save the match information into an array to pull data from

	// Get the ID of the logged in user's match.

	if ($matched_data[0]['userA'] == $_SESSION['user_id'])
		$other_user_match_id = $matched_data[0]['userB'];
	else if ($matched_data[0]['userB'] == $_SESSION['user_id'])
		$other_user_match_id = $matched_data[0]['userA'];
	else
		echo "BROKEN";

	$query = "SELECT * FROM Users WHERE id = " . $other_user_match_id;
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);

	$other_user_data = array();
	$other_user_data[0] = $row;

	return $other_user_data;	 
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = mysql_real_escape_string($data);
	return $data;
}

function login_user($user_data) {

		$_SESSION['login'] = "1";

		$_SESSION['user_id'] = $user_data[0]['id'];
		$_SESSION['user'] = $user_data[0]['email'];
		$_SESSION['user_name'] = $user_data[0]['name'];

		// Get the actual major name not the numerical representation
		$result = mysql_query("SELECT major_long FROM Majors WHERE id= " . $user_data[0]['major']);
		$row = mysql_fetch_array($result);
		$_SESSION['user_major_name'] = $row['major_long'];

		$_SESSION['user_major'] = $user_data[0]['major'];

		$_SESSION['user_cycle'] = $user_data[0]['cycle'];

		/* Cycle and program names not working yet. Fix that. */

		// Say what the cycle actually is
		if ($user_data[0]['cycle'] == '1')
			$_SESSION['user_cycle_name'] = "Fall-Winter";
		else
			$_SESSION['user_cycle_name'] ="Spring-Summer";

		$_SESSION['user_program'] = $user_data[0]['num_year_program'];

		// Say what the program actually is
		if ($user_data[0]['num_year_program'] == 1)
			$_SESSION['user_program_name'] = "1 co-op";
		else
			$_SESSION['user_program_name'] = "3 co-ops";

		$_SESSION['user_matched'] = $user_data[0]['matched']; // This will have to be updated or something when searches are done...
		$_SESSION['user_matched_id'] = $user_data[0]['Matches_id'];

		$_SESSION['user_dropped_matches'] = $user_data[0]['dropped_matches'];
}

function get_not_matched () {
	// Get all the peoples not matched...
	$query="SELECT * FROM Users WHERE matched = 0";
	$result=mysql_query($query);
	$num=mysql_num_rows($result);

	return $num;
}


?>