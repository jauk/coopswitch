<?php

	/* 
 	 * Filename: runswitch.php
 	 * Purpose: Perform switches.
 	 * This is the code that will perform the actual switches. 
 	 * Run script every X hours via a cronjob.
 	 * TODO: Save last script runtime, only run if greater than threshhold. Prevent someone running script repeadedly to crash site.
 	 */

	include "connect.php";

	global $switches;
	global $switchableUsers;

	switch($_SERVER['QUERY_STRING']) {

		case 'n=data':
			$unswitchedUsers = getUnswitchedUsers($con);
			$totalUsers = getTotalUsers($con);
			$numbers = array(
				"unswitched" => $unswitchedUsers, 
				"total" => $totalUsers
			);
			echo json_encode($numbers);
			break;

		case 'n=last':
			$lastSwitches = getLastSwitches($con);
			echo json_encode($lastSwitches);
			break;

		case 's=switchcheck':
			findSwitchableUsers($con);
			$numSwitches = getNumSwitches();
			echo $numSwitches;
			break;

		case 's=userstatus':
			$status = getUserSwitch($con);
			echo $status;
			break;

		case 's=1':
			showPairedUsers($con);
			break;
	}

	if (isset($_GET['id'])) {

		$sql = 'SELECT * FROM Switches WHERE switchId = ' . $_GET['id'];
		$result = $con->query($sql);
		$row = $result->fetch_assoc();

		$rowA = getUserRow($con, $row['userA']);
		$rowB = getUserRow($con, $row['userB']);

		$switchInfo[] = array(
			"switchId" => $row['switchId'], 
			"major" => $row['major'], 
			"status" => $row['status'],
			"timePaired" => $row['switchPairTime'],
			"userA"	=>	$rowA, 
			"userB"	=>	$rowB
		);

		echo json_encode($switchInfo);

	}

	/*
	function getLastSwitches($con) {

		include $_SERVER['DOCUMENT_ROOT'] . "/resources/functions/scripts.php";

	  $sql = 'select * from Matches ORDER BY id DESC LIMIT 10';
	  $result = $con->query($sql);

	  $lastSwitches = array();

	  while ($row = $result->fetch_assoc()) {

	     // $lastSwitches[$index] = $row; // Save the users into the array.

	      $sql = 'SELECT major_long from Majors WHERE id = ' . $row['major'];
	      $majorName = getVar($con, $sql);

	      $timeInit = $row['timeSwitchCreated'];
	      $timeInit = date("F j, Y, g:i a");

	      $lastSwitches[] = array(
	      	"major" => $majorName, 
	      	"timeInit" => $timeInit
	      );

	  }

	  return $lastSwitches;
	}
	*/

	function showPairedUsers($con) {

		$sql = 'SELECT * FROM Switches';
		$result = $con->query($sql);

		$switchesNotFinal = $result->fetch_all(MYSQLI_ASSOC);

		$switchesInProgress = array();

		foreach ($switchesNotFinal as $row) {

			$rowA = getUserRow($con, $row['userA']);
			$rowB = getUserRow($con, $row['userB']);

			$switchesInProgress[] = array(
				"switchId" => $row['switchId'], 
				"major" => $row['major'], 
				"status" => $row['status'],
				"timePaired" => $row['switchPairTime'],
				"userA"	=>	$rowA, 
				"userB"	=>	$rowB
			);

		}

		echo json_encode($switchesInProgress);

	}

	function getUserRow($con, $id) {

			$row = "";

			$sql = 'SELECT * FROM Users WHERE userId = ' . $id;
			$result = $con->query($sql);

			if ($result) {
				$row = $result->fetch_assoc();			
			}

			return $row;
	}

	function finalizeSwitch($con) {
		// Updated status to 1, hasSwitched to 1. Switch is actually done at this point.
	}

	// See if there are enough users to run the findSwitches() function.
	function findSwitchableUsers($con) {

		global $switchableUsers;
		$switchableUsers = "";

		$sql = 'SELECT * FROM Users 
						WHERE  hasSwitched = 0 AND hasWithdrawn = 0 AND switchId = 0
						ORDER BY registerDate ASC';
						
		$result = $con->query($sql);
		$numUsersNotSwitched = $result->num_rows;

		// echo $numUsersNotSwitched . "<br><br>";

		if ($numUsersNotSwitched > 1) {

			$switchableUsers = $result->fetch_all(MYSQLI_ASSOC);
			findSwitches($con);
		}

		else {
			die("Less than two users, cannot run switch check.");
		}

	}

	function getMajorName($con, $majorId) {
		$sql = 'SELECT major_long FROM Majors WHERE id = ' . $majorId;

		$result = $con->query($sql);
		$row = $result->fetch_row();

		echo $row[0];
	}

	function debug($con) {
		
			global $switchableUsers;

			$sql = 'SELECT `major`,
             	COUNT(`major`) AS `value_occurrence` 
    					FROM     `Users`
    					GROUP BY `major`
    					ORDER BY `value_occurrence` DESC
    					LIMIT    1';

    	$result = $con->query($sql);
    	$row = $result->fetch_row();
    	$major = $row[0];

			// DEBUG //
			echo "<b>DEBUG MAJOR </b>". $major ."<br>";
			echo "<hr>One Coop, Cycle One: <hr>";
			foreach ($switchableUsers as $user) {
				if ($user['major'] == $major && $user['cycle'] == 1 && $user['program'] == 1)
					echo $user['userId'] . " ";
			}
			echo "<hr>One Coop, Cycle Two: <hr>";
			foreach ($switchableUsers as $user) {
				if ($user['major'] == $major && $user['cycle'] == 2 && $user['program'] == 1)
					echo $user['userId'] . " ";
			}
			echo "<br><hr>Three Coop, Cycle One: <hr>";
			foreach ($switchableUsers as $user) {
				if ($user['major'] == $major && $user['cycle'] == 1 && $user['program'] == 2)
					echo $user['userId'] . " ";
			}
			echo "<hr>Three Coop, Cycle Three: <hr>";
			foreach ($switchableUsers as $user) {
				if ($user['major'] == $major && $user['cycle'] == 2 && $user['program'] == 2)
					echo $user['userId'] . " ";
			}
			echo "<hr><b>END DEBUG</b><br>";
			// END DEBUG //
	}

	// Find potential switches.
	function findSwitches($con) {

		global $switchableUsers;

		foreach ($switchableUsers as $key => $user) {

			foreach ($switchableUsers as $secondaryKey => $secondaryUser) {

				if ($user['userId'] != $secondaryUser['userId']) {
					if ($user['major'] == $secondaryUser['major']) {
						if ($user['cycle'] != $secondaryUser['cycle'] && $user['program'] == $secondaryUser['program']) {
							// If all conditions are met, send users to switchUsers() to make switch in db. Then, remove both users from $switchableUsers.
						 	switchUsers($user['userId'], $secondaryUser['userId'], $user['major'], $con);
							// Remove both users from our array of switchable users.
							foreach($switchableUsers as $removeKey => $removeUser) {
								if ($removeUser['userId'] == $secondaryUser['userId'] || $removeUser['userId'] == $user['userId']) {
									unset($switchableUsers[$removeKey]);
								}
							}

							break;
						}
					}
				}
			}

		} // End main foreach.

	}

	function switchUsers($userId, $secondaryUserId, $major, $con) {

		global $switches;

		// $sql = 'UPDATE Users SET hasSwitched = 1 WHERE userId = ' . $userId . ' OR userId = ' . $secondaryUserId;

		// if (!$con->query($sql)) {
		// 	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->error, E_USER_ERROR);		
		// }

		$time = time();
		$sql = 'INSERT INTO Switches (userA, userB, major, switchPairTime) VALUES ('.$userId.','.$secondaryUserId.','.$major.','.$time.')';

		if (!$con->query($sql)) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->error, E_USER_ERROR);					
		}

		else {
			$switchId = $con->insert_id;
			$sql = 'UPDATE Users SET switchId = '.$switchId.' WHERE userId = '.$userId.' OR userId = '.$secondaryUserId;

			if (!$con->query($sql)) {
				trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->error, E_USER_ERROR);		
			}
			else {
				// TODO: BETTER MAILING
			  //mail_matched_users($users_not_matched[$x]['name'], $users_not_matched[$x]['email'], $matched_user_data['name'], $matched_user_data['email']);
				$switches++;

			}
		}

	}

	function getNumSwitches() {

		global $switches;
		if ($switches == "") {
			$switches = 0;
		}
		return $switches;
	}
	
?>