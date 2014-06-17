<?php

defined("TEMPLATES_PATH")
    or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));

defined("FUNCTION_PATH")
	or define("FUNCTION_PATH", realpath(dirname(__FILE__) . '/functions'));

defined("DEV_PATH")
	or define("DEV_PATH", realpath(dirname(__FILE__) . '/dev'));

// define('DEBUG', 'false');

$GLOBALS['debug'] = True;


$config = array(
	"db" => array(
		"development" => array(
			"dbname" => "coop_dev",
			"dbuser" => "root",
			"dbpass" => "",
			"dbhost" => "localhost"
			),
		"production" => array(
			"dbname" => "coopswitch",
			"dbuser" => "coop",
			"dbpass" => "switch",
			"dbhost" => "justinmaslin.db"
			),
	),
	"urls" => array(
		"baseUrl" => "coopswitch.com",
		"devUrl" => "coop.localhost"
	)
);


?>