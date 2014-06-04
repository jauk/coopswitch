<?php

function login_user($user_data) {

		$_SESSION['login'] = "1";

		$_SESSION['user_id'] = $user_data[0]['id'];
		$_SESSION['user'] = $user_data[0]['email'];
		$_SESSION['user_name'] = $user_data[0]['name'];

		// Get the actual major name not the numerical representation
		$result = mysql_query("SELECT major_long FROM Majors WHERE id= " . $user_data[0]['major']);
		$row = mysql_fetch_array($result);
		$_SESSION['user_major_name'] = $row['major_long'];

		$_SESSION['user_major'] = $user_data[0]['major'];

		$_SESSION['user_cycle'] = $user_data[0]['cycle'];

		/* Cycle and program names not working yet. Fix that. */

		// Say what the cycle actually is
		if ($user_data[0]['cycle'] == '1')
			$_SESSION['user_cycle_name'] = "Fall-Winter";
		else
			$_SESSION['user_cycle_name'] ="Spring-Summer";

		$_SESSION['user_program'] = $user_data[0]['num_year_program'];

		// Say what the program actually is
		if ($user_data[0]['num_year_program'] == 1)
			$_SESSION['user_program_name'] = "1 co-op";
		else
			$_SESSION['user_program_name'] = "3 co-ops";

		$_SESSION['user_matched'] = $user_data[0]['matched']; // This will have to be updated or something when searches are done...
		$_SESSION['user_matched_id'] = $user_data[0]['Matches_id'];

		$_SESSION['user_dropped_matches'] = $user_data[0]['dropped_matches'];
}

?>