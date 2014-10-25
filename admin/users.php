<?php

	include "connect.php";

	$start = $_GET['start'];
	$rows = $_GET['rows'];

	$sql = 'SELECT * FROM Users WHERE hasWithdrawn = 0 AND userId > ' . $start . ' ORDER BY userId LIMIT ' . $rows;

	$result = $con->query($sql);

	if (!$result) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->error, E_USER_ERROR);		
	}
	else {
		$users = $result->fetch_all(MYSQLI_ASSOC);
	}

	echo json_encode($users);

?>