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

function messageTemplate($name, $content) {

	$message = '

	<h1>Coopswitch</h1>
	<hr>
	<br>
	Hi ' . $name . '! <br><br>'

	. $content . 

	'<br><br>Good luck, <br><br>

	Justin <br>
	Coopswitch Founder

	';

	return $message;

}

function mail_matched_users($userAName, $userAEmail, $userBName, $userBEmail) {
	$subject = "A co-op switch match has been made for you!";
	$toAccount = "http://coopswitch.com/account";

	$message = '

	<h1>Coopswitch</h1>
	<hr>
	<br>
	Hi ' . $userAName . '! <br><br>

	We have found someone to trade cycles with! <br><br>

	Please login to see their information, or click below. <br>

	<a href="'. $toAccount . '">Click Here</a> <br><br>

	Good luck, <br><br>

	Justin <br>
	Coopswitch Founder

	';

	$headers = getHeaders();

	mail($userAEmail, $subject, $message);
	mail($userBEmail, $subject, $message);
	//mail('justin@localhost', $subject, $message, $headers);

}

function send_init_email($name, $email, $verifyLink) {

	$subject = "Welcome to Coopswitch!";

	$headers = getHeaders();

	$message = '

	<h1>Coopswitch</h1>
	<hr>
	<br>
	Hi ' . $name . '! <br><br>

	Thank you for registering. <br><br>

	Please use the following link to verify your email so you are entered into the matching queue. <br>

	<a href="'. $verifyLink . '">Click Here</a> <br><br>

	Good luck, <br><br>

	Justin <br>
	Coopswitch Founder

	';


	mail($email, $subject, $message, $headers);
	// Include verify link
}

function mail_user_dropper($name, $email) {

	$subject = "Your Coopswitch match was dropped.";

	$headers = getHeaders();

	$content = '

	Your match has been successfully dropped. The more you do this, the lower your odds of 
	finding a match will be.

	';

	$message = messageTemplate($name, $content);

	mail($email, $subject, $message, $headers);

}

function mail_user_dropped($name, $email) {

	$subject = "Your Coopswitch match was dropped.";

	$headers = getHeaders();

	$content = '

	The user you have matched with has dropped your match, and you have been entered back into the queue.
	Sorry about that, this should not happen often!

	';

	$message = messageTemplate($name, $content);

	mail($email, $subject, $message, $headers);
}

?>