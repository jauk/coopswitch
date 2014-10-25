<?php

if (!isset($_SESSION['login'])) {
  if ($debug_login) {
    $_SESSION['login'] = 1;
    $_SESSION['user_name'] = "Test User";
  	$_SESSION['user_major_name'] = "Computer Science";
  	$_SESSION['user_cycle_name'] = "Spring-Summer";
  	$_SESSION['user_program_name'] = "3 co-ops";
  	$_SESSION['user_matched'] = 0;
    $_SESSION['user_email_verified'] = 1;
    $_SESSION['user_dropped_matches'] = 0;

    echo "<!-- USER LOGIN DEBUGGING IS ENABLED. -->\n";

  }
}


?>