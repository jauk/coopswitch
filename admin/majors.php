<?php

	if (isset($_GET['majorName'])) {
		getMajorName($_GET['majorName']);
	}

	function getMajorName($majorId) {
		
		include "connect.php";

		$sql = 'SELECT major_long FROM Majors WHERE id = ' . $majorId;

		$result = $con->query($sql);
		$row = $result->fetch_row();

		echo $row[0];
	}

	function printMajors() {
		
		include "connect.php";

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

			if (isset($_SESSION['login']))
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

?>