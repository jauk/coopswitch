<?php

  function login_user($user_data) {
    
      // Set all session vars //
  
      // Set as user logged in
  		$_SESSION['login'] = "1";
  
      // Get basic user info
  		$_SESSION['user_id'] = $user_data['id'];
  		$_SESSION['user'] = $user_data['email'];
  		$_SESSION['user_name'] = $user_data['name'];
  
      // See if user is verified
      $_SESSION['user_email_verified'] = $user_data['verified'];

  		// Get the actual major name not the numerical representation
  		$result = mysql_query("SELECT major_long FROM Majors WHERE id= " . $user_data['major']);
  		$row = mysql_fetch_array($result);
  		$_SESSION['user_major_name'] = $row['major_long'];
  
      // Get user major and cycle
  		$_SESSION['user_major'] = $user_data['major'];
  		$_SESSION['user_cycle'] = $user_data['cycle'];
  
  		// Get what the cycle actually is named
  		if ($user_data['cycle'] == '1')
  			$_SESSION['user_cycle_name'] = FALLWINTER;
  		else
  			$_SESSION['user_cycle_name'] = SPRINGSUMMER;
  
      // How many years user is student
  		$_SESSION['user_program'] = $user_data['num_year_program'];
  
  		// Get what the program actually is named
  		if ($user_data['num_year_program'] == 1)
  			$_SESSION['user_program_name'] = ONECOOP;
  		else
  			$_SESSION['user_program_name'] = THREECOOPS;
  
      // Get user matched info
  		$_SESSION['user_matched'] = $user_data['matched']; // This will have to be updated or something when searches are done...
  		$_SESSION['user_matched_id'] = $user_data['Matches_id'];
  		$_SESSION['user_dropped_matches'] = $user_data['dropped_matches'];

      // Dealing with user withdraws or re-enables
      $_SESSION['withdraw'] = $user_data['withdraw'];
      $_SESSION['user_reactivated_date'] = $user_data['new_date'];

      $_GLOBALS['login'] = True;
  		
  }

?>