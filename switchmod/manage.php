<?php

	include "connect.php";

	if (isset($_POST['yId'])) {

		$userId = $_POST['yId'];
		$sql = 'UPDATE Users SET hasWithdrawn = 0 WHERE userId = ' . $userId;

		if (!$con->query($sql)) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->error, E_USER_ERROR);
		}
		else {
			echo "1";
		}

	}

	if (isset($_POST['nId'])) {

		$userId = $_POST['nId'];
		$sql = 'UPDATE Users SET hasWithdrawn = 1 WHERE userId = ' . $userId;

		if (!$con->query($sql)) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->error, E_USER_ERROR);
		}
		else {
			echo "1|";
		}

		$sql = 'SELECT switchId FROM Users WHERE userId = ' . $userId;
		$result = $con->query($sql);
		$row = $result->fetch_assoc();

		if ($row['switchId'] != 0) {
			$sql = 'UPDATE Users SET hasSwitched = 0, switchId = 0 WHERE switchId = ' . $row['switchId'];

			if (!$con->query($sql)) {
			  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->error, E_USER_ERROR);
			}

			$sql = 'DELETE FROM Switches WHERE switchId = ' . $row['switchId'];
			if (!$con->query($sql)) {
			  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->error, E_USER_ERROR);
			}	

		}

	}


?>