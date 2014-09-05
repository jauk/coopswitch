<?php

/* Lets store scripts here to make our code more efficient. */

function print_majors() {

	$query = "SELECT * FROM Majors";
	$result = mysql_query($query);
	$numMajors = mysql_num_rows($result);

	$selected = "";
	$majorSubtext = "";

	$i=0; while ($i < $numMajors) {
		$major_name = mysql_result($result, $i, "major_long");
		$noSwitch = mysql_result($result, $i, "noSwitch");
		
		$major_ident=mysql_result($result, $i, "id");

		$business = "Business Administration";

		$businessMajorSubtext = "(All Majors)";

		if (isset($_SESSION['login']) && $_SESSION['user_major_name'] == $major_name) {
			$selected = "selected";
		}
		else {
			$selected = "";
		}

		if ($major_name == $business) {
			$majorSubtext = $businessMajorSubtext;
		}
		else {
			$majorSubtext = "";
		}

		if ($noSwitch == 1)
			print_r('<option class="noSwitch" value=' . $major_ident . ' data-subtext="Not Available" >' . $major_name . '</option>');
		else
			print_r('<option ' . $selected . ' value="' . $major_ident . '" data-subtext="' . $majorSubtext . '">' . $major_name . '</option>');

		$i++;
	}

	$major_ident = 0;
	$major_name = "";
}

// Useful function found online
function mysql_get_var($query,$y=0) {
   $res = mysql_query($query);
   $row = mysql_fetch_array($res);
   mysql_free_result($res);
   $rec = $row[$y];
   return $rec;
}

function getMajorName($id) {

	$query = "SELECT major_long FROM Majors WHERE id='$id'";
	$majorName = mysql_get_var($query);

	return $majorName;
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
	$other_user_match_id = "";

	if ($matched_data[0]['userA'] == $_SESSION['user_id'])
		$other_user_match_id = $matched_data[0]['userB'];
	else if ($matched_data[0]['userB'] == $_SESSION['user_id'])
		$other_user_match_id = $matched_data[0]['userA'];
	else {
		print("BROKEN");
	}

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
	//$data = mysql_real_escape_string($data);

	return $data;
}

function get_not_matched () {
	// Get all the peoples not matched...
	$query="SELECT * FROM Users WHERE matched = 0";
	$result=mysql_query($query);
	$num=mysql_num_rows($result);

	return $num;
}

function getVerifyLink ($name, $email, $cycle) {

	$registerLinkBase = "http://" . $_SERVER['SERVER_NAME'] . "/verify?a=$email&b=";

	$combo = $name . $email . $cycle;
	$link = hash('sha256', $combo);

	$verifyLink = $registerLinkBase . $link;

	return $verifyLink;
}

function getUserDataFromId ($id) {

	// Get the user we are talking to and save them into a local array.
	$query = "SELECT * FROM Users WHERE id = " . $id;
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);

	$user_data = $row;

	return $user_data;
}

function switchUsers ($idOne, $idTwo, $major) {

    // Update both users to be matched.
  $query = "UPDATE Users SET matched = 1 WHERE id = " . $idOne . " OR id = " . $idTwo . "";
  $result = mysql_query($query);

  /* *** Matches db need to add date matched, date completed, major val (to compare to when change major in profile, also for stats [ie. most popular majors]) */

  // Insert into the Matches database.
  $query = sprintf("INSERT INTO Matches (userA, userB, major, date_matched) VALUES (" . $idOne . ", " . $idTwo . ", " . $major . ", " .'date("Y-m-d H:i:s")' . " )");
  //$query = sprintf("INSERT INTO Matches (userA, userB) VALUES (" . $users_not_matched[$x]['id'] . ", " . $matched_user_data['id'] . ")");
  $result = mysql_query($query);

  // Grab the Id of the match from Matches table
  $newMatchId = mysql_get_var('SELECT id FROM Matches WHERE userA= ' . $idOne . ' OR userB= ' . $idTwo);

  // Add the Matched ID to the Users
  $query = "UPDATE Users SET Matches_id = " . $newMatchId . " WHERE id = " . $idOne . " OR id = " . $idTwo . "";
  $result = mysql_query($query);

}

?>