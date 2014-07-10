<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
	require_once(TEMPLATES_PATH . "/header.php");
	include(FUNCTION_PATH . "/connect.php");

	$limit = 101;
	$names = array("apple", "banana", "mango", "blueberry", "grape");
	$password = "";
	$email = "";
	$dropped_matches = "";


	for ($x = 1; $x < $limit; $x++) {

		$name = $names[array_rand($names)];
		$password = md5($x);
		$cycle = rand(1,2);
		$num_year_program = rand(1,2);
		$majorVal = rand(2,87);
		//$majorVal = rand(2,4);
		$email = "$name$x@drexel.edu"; 
		$dropped_matches = rand(0, 4);

		$date = date('Y-m-d', strtotime("+$x days"));

		// $sql="INSERT INTO Users (name, password, email, cycle, num_year_program, major, dropped_matches, register_date)
		// 	  VALUES ('$name','$password', '$email','$cycle', '$num_year_program', '$majorVal', '$dropped_matches',
		// 			'".date("Y-m-d H:i:s")."'
		// 	)";

		$sql="INSERT INTO Users (name, password, email, cycle, num_year_program, major, dropped_matches, register_date, verified)
			  VALUES ('$name','$password', '$email','$cycle', '$num_year_program', '$majorVal', '$dropped_matches', '$date', '1')";
	 
		//echo "$name $email <br>";

		$resutl=mysql_query($sql);

	}

	mysql_close($con);

	echo '<div class="text-center">';
	echo "Records generated.";
	echo '</div>';

	require_once(TEMPLATES_PATH . "/footer.php");
?>