<?php

/* Lets store scripts here to make our code more efficient. */

function print_majors() {

	$query="SELECT * FROM Majors";
	$result=mysql_query($query);
	$numMajors=mysql_num_rows($result);
	
	//Debug
	//$numMajors = 10;

	$i=0; while ($i < $numMajors) {
		$major_name=mysql_result($result, $i, "major_long");
		
		//Debug (no db here)
		//$major_name = "Computer Science";
		
		$major_ident=mysql_result($result, $i, id);

		if (isset($_SESSION['login']) && $_SESSION['user_major'] == $major_ident)
			echo '<option selected="selected" value=' . $major_ident . '>' . $major_name . '</option> \n\t\t\t\t\t\t';
		else
			echo "<option value=" . $major_ident . ">" . $major_name . "</option> \n\t\t\t\t\t\t";

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

?>