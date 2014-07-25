<?php

// TO DO: Better way of storing password.

require_once LIB_PATH . '/PHPMailer/PHPMailerAutoload.php';

$localMail = "coop@justinmaslin.com";
$localName = "Web Form";

function sendEmail($name, $email, $subject, $message, $replyTo = "'justin@coopswitch.com', 'Coopswitch'") {

	$mail = new PHPMailer;

	$mail->isSMTP();
	$mail->Host = "mail.privateemail.com";
	$mail->SMTPAuth = true;
	$mail->Username = 'justin@coopswitch.com';
	$mail->Password = 'coop_switch_mailer';

	$mail->Port = 465;
	$mail->SMTPSecure = 'ssl';

	$mail->From = 'justin@coopswitch.com';
	$mail->FromName = 'Coopswitch';
	$mail->addReplyTo($replyTo);

	$mail->WordWrap = 50;
	$mail->isHTML(true);

	$mail->Subject = $subject;
	$mail->Body = $message;
	$mail->addAddress($email, $name);

	if(!$mail->send()) {
	    echo 'Message could not be sent.';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
	}
	else {
		//echo 'Message sent.';
	}

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
	';

	sendEmail($userAName, $userAEmail, $subject, $message);
	sendEmail($userBName, $userBEmail, $subject, $message);
}

function send_init_email($name, $email, $verifyLink) {

	$subject = "Welcome to Coopswitch!";

	$message = '

	<h1>Coopswitch</h1>
	<hr>
	<br>
	Hi ' . $name . '! <br><br>

	Thank you for registering. <br><br>

	Please use the following link to verify your email so you are entered into the matching queue. <br>

	<a href="'. $verifyLink . '">Click Here</a> <br><br>

	';

	sendEmail($name, $email, $subject, $message);
}

function mail_user_dropper($name, $email) {

	$subject = "Your Coopswitch match was dropped.";

	$message = '

	Your match has been successfully dropped. The more you do this, the lower your odds of 
	finding a match will be.

	';

	$message = messageTemplate($name, $content);

	sendEmail($name, $email, $subject, $message);
}

function mail_user_dropped($name, $email) {

	$subject = "Your Coopswitch match was dropped.";

	$message = '

	The user you have matched with has dropped your match, and you have been entered back into the queue.
	Sorry about that, this should not happen often!

	';

	$message = messageTemplate($name, $content);

	sendEmail($name, $email, $subject, $message);
}

function reset_pass_email($name, $email, $resetLink) {

	$subject = "Coopswitch Password Reset";

	$message = '

	Please use the following link to reset your password: <br><br>'

	. $resetLink . '<br><br>

	If you did not request this, please ignore this email.
	';

	sendEmail($name, $email, $subject, $message);
}

function web_form_mail($replyTo, $subject, $message) {

	global $localName;
	global $localMail;

	sendEmail($localName, $localMail, $subject, $message, $replyTo);
}

?>

