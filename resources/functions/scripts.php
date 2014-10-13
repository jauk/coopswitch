<?php

if(!isset($_SESSION)){ session_start(); }

switch ($_SERVER['QUERY_STRING']) :

	case 'g=majors' :
		$majors = print_majors();
		echo $majors;
		break;

endswitch;


/* Lets store scripts here to make our code more efficient. */

function print_majors() {

	include("connect.php");

	$sql = 'SELECT * FROM Majors';
	$result = $con->query($sql);

	$majorsDB = array();

	while ($row = $result->fetch_assoc()) {
		$majorsDB[] = $row;
	}

	$majors = array();
	$class = "";
	$selected = "";

	foreach ($majorsDB as $key => $major) {

		$class = ($major['noSwitch'] == 1 ? 'noSwitch' : '');
		$selected = ($_SESSION['user_major_name'] == $major['major_long'] ? "selected" : '');

		$majors[] = array(
			"key"=>$major['id'],
			"name"=>$major['major_long'],
			"class"=>$class,
			"selected"=>$selected 
		);

	}

	$json_majors = json_encode($majors, JSON_PRETTY_PRINT);
	return $json_majors;

}


function getPageName() {
	$pageName = ucfirst(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME)); 

	return $pageName;
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

	include "connect.php";

  $sql = 'SELECT major_long FROM Majors WHERE id= ' . $id;
	$result = $con->query($sql);
	$row = $result->fetch_row();
	$majorName = $row[0];

	return $majorName;
}

function get_match_info() {
	// Update user_matched_id in-case they were logged in when a matched happened.
	$_SESSION['user_matched_id'] = mysql_get_var("SELECT Matches_id FROM Users WHERE id = " . $_SESSION['user_id']);

	$query = "SELECT * FROM Matches WHERE id = " . $_SESSION['user_matched_id'] . "";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);

	$matched_data = array();
	$matched_data = $row; // Save the match information into an array to pull data from

	// Get the ID of the logged in user's match.
	$other_user_match_id = "";

	$other_user_match_id = ($matched_data['userA'] == $_SESSION['user_id'] ? $other_user_match_id = $matched_data['userB'] : $other_user_match_id = $matched_data['userA']);

	// if ($matched_data['userA'] == $_SESSION['user_id'])
	// 	$other_user_match_id = $matched_data['userB'];
	// else if ($matched_data['userB'] == $_SESSION['user_id'])
	// 	$other_user_match_id = $matched_data['userA'];
	// else {
	// 	print("BROKEN");
	// }

	if ($other_user_match_id == "") {
		die("Error");
	}	

	$query = "SELECT * FROM Users WHERE id = " . $other_user_match_id;
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);

	$other_user_data = array();
	$other_user_data = $row;

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

	include("connect.php");

	$user_data = array();
	// Get the user we are talking to and save them into a local array.
	$sql = 'SELECT * FROM Users WHERE id = "' . $id . '"';
	$result = $con->query($sql);

	if ($result == false) {
  	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->error, E_USER_ERROR);
 	}
	else {
		$user_data = $result->fetch_array(MYSQLI_ASSOC);
	}
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

function getName($type, $val) {

	switch ($type):

		case "cycle":
			$name = ($val == 1 ? FALLWINTER : SPRINGSUMMER);
			break;
		case "program":
			$name = ($val == 1 ? ONECOOP : THREECOOPS);
			break;

	endswitch;

	return $name;
}

?>