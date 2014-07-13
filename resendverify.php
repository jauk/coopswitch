<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");

$name = $_SESSION['user_name'];
$email = $_SESSION['user'];
$cycle = $_SESSION['user_cycle'];

$link = getVerifyLink($name, $email, $cycle);

send_init_email($name, $email, $link);

header("Location: account.php");

?>