<?php

/* Send both users an email that they have beenn matched. 
   For now, just tell them to check profile for user information.
   This promotes website use, too. Can havve pre-written message on site to send. */

/* On profile have option to decline match (change mind). Do this later. */

function mail_matched_users($userAName, $userAEmail, $userBName, $userBEmail) {
	$subject = "A co-op switch match has been made for you!";

	$message = "Hello, a match has been made for you!
				\nLogin to view it!";

	//mail($userAEmail, $subject, $message);
	//mail($userBEmail, $subject, $message);
	mail('justin@localhost', $subject, $message);

}

function send_init_email($name, $email, $verifyLink) {

	$subject = "Welcome to Coopswitch!";

	$message = '
	
	Hi ' . $name . '! 

	Thank you for registering.

	Please use the following link to verify your email so you are entered into the matching queue.

	<a href="'. $verifyLink . '">Click Here</a>

	';


	mail('justin@localhost', $subject, $message);
	// Include verify link
}


?>