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
	return $data;
}

?>