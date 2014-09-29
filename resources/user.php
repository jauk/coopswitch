<?php

	session_start();
	
	if ($_GET["g"] == "name") {

			if (!isset($_SESSION['user_name'])) {
			//	throw new Exception('No name found. Is user logged in?');
				echo("Error: No Name.");
			}
			else {
				$name = $_SESSION['user_name'];
				echo $name;
			}
	 	}


?>