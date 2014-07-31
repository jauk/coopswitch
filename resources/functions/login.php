<?php

  function login_user($user_data) {
    
      // Set all session vars //
  
      // Set as user logged in
  		$_SESSION['login'] = "1";
  
      // Get basic user info
  		$_SESSION['user_id'] = $user_data[0]['id'];
  		$_SESSION['user'] = $user_data[0]['email'];
  		$_SESSION['user_name'] = $user_data[0]['name'];
  
      // See if user is verified
      $_SESSION['user_email_verified'] = $user_data[0]['verified'];

  		// Get the actual major name not the numerical representation
  		$result = mysql_query("SELECT major_long FROM Majors WHERE id= " . $user_data[0]['major']);
  		$row = mysql_fetch_array($result);
  		$_SESSION['user_major_name'] = $row['major_long'];
  
      // Get user major and cycle
  		$_SESSION['user_major'] = $user_data[0]['major'];
  		$_SESSION['user_cycle'] = $user_data[0]['cycle'];
  
  		// Get what the cycle actually is named
  		if ($user_data[0]['cycle'] == '1')
  			$_SESSION['user_cycle_name'] = "Fall-Winter";
  		else
  			$_SESSION['user_cycle_name'] = "Spring-Summer";
  
      // How many years user is student
  		$_SESSION['user_program'] = $user_data[0]['num_year_program'];
  
  		// Get what the program actually is named
  		if ($user_data[0]['num_year_program'] == 1)
  			$_SESSION['user_program_name'] = "1 co-op";
  		else
  			$_SESSION['user_program_name'] = "3 co-ops";
  
      // Get user matched info
  		$_SESSION['user_matched'] = $user_data[0]['matched']; // This will have to be updated or something when searches are done...
  		$_SESSION['user_matched_id'] = $user_data[0]['Matches_id'];
  		$_SESSION['user_dropped_matches'] = $user_data[0]['dropped_matches'];

      $_GLOBALS['login'] = True;
  		
  }

?>