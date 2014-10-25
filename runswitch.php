<?php

	/* 
 	 * Filename: runswitch.php
 	 * Purpose: Perform switches.
 	 * This is the code that will perform the actual switches. 
 	 * Run script every X hours via a cronjob.
 	 * TODO: Save last script runtime, only run if greater than threshhold. Prevent someone running script repeadedly to crash site.
 	 */

	session_start();

	include $_SERVER['DOCUMENT_ROOT'] . "/resources/functions/connect.php";

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

	}

	//runFindSwitches($con);

	function getUserSwitch($con) {

		include $_SERVER['DOCUMENT_ROOT'] . "/resources/functions/scripts.php";

    $sql = 'SELECT matched FROM Users WHERE id = ' . $_SESSION['user_id'];
    $status = getVar($con, $sql);
    // $status = $_SESSION['user_matched'];
    return $status;
	}

	function getUnswitchedUsers($con) {

		$sql = 'SELECT * FROM Users WHERE verified = 1 AND matched = 0 AND withdraw = 0';
		$result = $con->query($sql);
		$num = $result->num_rows;

		return $num;
	}

	function getTotalUsers($con) {

		$sql = 'SELECT * FROM Users WHERE verified = 1 AND withdraw = 0';
		$result = $con->query($sql);
		$num = $result->num_rows;

		return $num;
	}

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

	// See if there are enough users to run the findSwitches() function.
	function findSwitchableUsers($con) {

		global $switchableUsers;
		$switchableUsers = "";

		$sql = 'SELECT * FROM Users 
						WHERE verified = 1 AND matched = 0 AND withdraw = 0
						ORDER BY register_date ASC';
						
		$result = $con->query($sql);
		$numUsersNotSwitched = $result->num_rows;

		echo $numUsersNotSwitched . "<br><br>";

		if ($numUsersNotSwitched > 1) {

			$switchableUsers = $result->fetch_all(MYSQLI_ASSOC);

			debug($con);

			findSwitches($con);
			echo "<br><hr><b>SWITCHES: </b>".$switches=getNumSwitches()."<hr><br>";

			debug($con);

		}

		else {
			die("Less than two users, cannot run switch check.");
		}

	}

	function debug($con) {
		
			include_once $_SERVER['DOCUMENT_ROOT'] . "/resources/functions/scripts.php";

			global $switchableUsers;

			$sql = 'SELECT `major`,
             	COUNT(`major`) AS `value_occurrence` 
    					FROM     `Users`
    					GROUP BY `major`
    					ORDER BY `value_occurrence` DESC
    					LIMIT    1';

    	$major = getVar($con, $sql);

			// DEBUG //
			echo "<b>DEBUG MAJOR </b>". $major ."<br>";
			echo "<hr>One Coop, Cycle One: <hr>";
			foreach ($switchableUsers as $user) {
				if ($user['major'] == $major && $user['cycle'] == 1 && $user['num_year_program'] == 1)
					echo $user['id'] . " ";
			}
			echo "<hr>One Coop, Cycle Two: <hr>";
			foreach ($switchableUsers as $user) {
				if ($user['major'] == $major && $user['cycle'] == 2 && $user['num_year_program'] == 1)
					echo $user['id'] . " ";
			}
			echo "<br><hr>Three Coop, Cycle One: <hr>";
			foreach ($switchableUsers as $user) {
				if ($user['major'] == $major && $user['cycle'] == 1 && $user['num_year_program'] == 2)
					echo $user['id'] . " ";
			}
			echo "<hr>Three Coop, Cycle Three: <hr>";
			foreach ($switchableUsers as $user) {
				if ($user['major'] == $major && $user['cycle'] == 2 && $user['num_year_program'] == 2)
					echo $user['id'] . " ";
			}
			echo "<hr><b>END DEBUG</b><br>";
			// END DEBUG //
	}

	// Find potential switches.
	function findSwitches($con) {

		global $switchableUsers;

		foreach ($switchableUsers as $key => $user) {

			foreach ($switchableUsers as $secondaryKey => $secondaryUser) {

				if ($user['id'] != $secondaryUser['id']) {
					if ($user['major'] == $secondaryUser['major']) {
						if ($user['cycle'] != $secondaryUser['cycle'] && $user['num_year_program'] == $secondaryUser['num_year_program']) {
							// If all conditions are met, send users to switchUsers() to make switch in db. Then, remove both users from $switchableUsers.
							switchUsers($user['id'], $secondaryUser['id'], $user['major'], $con);

							// Remove both users from our array of switchable users.
							foreach($switchableUsers as $removeKey => $removeUser) {
								if ($removeUser['id'] == $secondaryUser['id'] || $removeUser['id'] == $user['id']) {
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

		$sql = 'UPDATE Users SET matched = 1 WHERE id = ' . $userId . ' OR id = ' . $secondaryUserId;

		if (!$con->query($sql)) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->error, E_USER_ERROR);		
		}

		$time = time();
		$sql = 'INSERT INTO Matches (userA, userB, major, timeSwitchCreated) VALUES ('.$userId.','.$secondaryUserId.','.$major.','.$time.')';

		if (!$con->query($sql)) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->error, E_USER_ERROR);					
		}

		else {
			$switchId = $con->insert_id;
			$sql = 'UPDATE Users SET Matches_id = '.$switchId.' WHERE id = '.$userId.' OR id = '.$secondaryUserId;

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