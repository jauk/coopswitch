<?php

/* Send both users an email that they have beenn matched. 
   For now, just tell them to check profile for user information.
   This promotes website use, too. Can havve pre-written message on site to send. */

/* On profile have option to decline match (change mind). Do this later. */

function getHeaders() {

	global $headers;

	$coopMail = "justin@coopswitch.com";

	$headers  = "From: " . $coopMail . " \r\n";
	$headers .= "Reply-To: " . $coopMail . "\r\n";
	$headers .= "BCC: justin@localhost\r\n"; // This line temporary for testing!
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	return $headers;
}

function mail_matched_users($userAName, $userAEmail, $userBName, $userBEmail) {
	$subject = "A co-op switch match has been made for you!";

	$message = "Hello, a match has been made for you!
				\nLogin to view it!";

	$headers = getHeaders();

	//mail($userAEmail, $subject, $message);
	//mail($userBEmail, $subject, $message);
	mail('justin@localhost', $subject, $message, $headers);

}

function send_init_email($name, $email, $verifyLink) {

	$subject = "Welcome to Coopswitch!";

	$headers = getHeaders();

	$message = '
	
	Hi ' . $name . '! 

	Thank you for registering.

	Please use the following link to verify your email so you are entered into the matching queue.

	<a href="'. $verifyLink . '">Click Here</a>

	';


	mail('justin@localhost', $subject, $message, $headers);
	// Include verify link
}


?>