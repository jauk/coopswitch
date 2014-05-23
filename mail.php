<?php

/* Send both users an email that they have beenn matched. 
   For now, just tell them to check profile for user information.
   This promotes website use, too. Can havve pre-written message on site to send. */

/* On profile have option to decline match (change mind). Do this later. */

function mail_matched_users($userAName, $userAEmail, $userBName, $userBEmail)
{
	$subject = "A co-op switch match has been made for you!";

	$message = "Hello, a match has been made for you!
				\nLogin to view it!";

	//mail($userAEmail, $subject, $message);
	//mail($userBEmail, $subject, $message);
	mail('root@JustinBook', $subject, $message);

}



?>