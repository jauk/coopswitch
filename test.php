<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");

$name = "John Fry";
$email = "fry@drexel.edu";
$verifyLink = "google.com";

send_init_email($name, $email, $verifyLink);

echo "Test email sent.";

?>