<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");

$name = test_input($_POST['name']);
$email = test_input($_POST['email']);
$subject = test_input($_POST['subject']);
$message = test_input($_POST['message']);

$subject = $subject . " | Coopswitch WebForm";

$replyTo = "'" . $email . "', '" . $name . "'";

web_form_mail($replyTo, $subject, $message);

header("Location: about.php#about?msg=sent");

?>