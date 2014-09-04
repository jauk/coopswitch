<?php

defined("TEMPLATES_PATH")
    or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));

defined("FUNCTION_PATH")
	or define("FUNCTION_PATH", realpath(dirname(__FILE__) . '/functions'));

defined("DEV_PATH")
	or define("DEV_PATH", realpath(dirname(__FILE__) . '/dev'));

defined("LIB_PATH")
	or define("LIB_PATH", realpath(dirname(__FILE__) . '/library'));


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
		"vps" => array(
			"dbname" => 'coopswitch',
			"dbuser" => 'root',
			"dbpass" => 'c00pswitch',
			"dbhost" => 'localhost'
			)
	),
	"urls" => array(
		"baseUrl" => "coopswitch.com",
		"baseUrl2" => "www.coopswitch.com",
		"devUrl" => "coop.localhost"
	)
);

/* Text Variables */

// Main Vars
define('SITE_NAME', 'Coopswitch');
define('SITE_SLOGAN', 'A simple way to switch co-ops.');

// Header Vars
define('LOGIN_GREETING', 'Hey, ');

// Names of each co-op cycle
define('FALLWINTER', 'Fall Winter');
define('SPRINGSUMMER', 'Spring Summer');

// Names of how many co-ops
define('ONECOOP', 'One Coop');
define('THREECOOPS', 'Three Coops');


/* Debug Variables */

$GLOBALS['debug'] = False;

// If want to simulate logged in user.
$GLOBALS['debug_login'] = False;

// Stop match mail spam while testing
$GLOBALS['send_match_mail'] = False;

$GLOBALS['debug_db'] = False;

// Test new feature on production?
if ($_SERVER['SERVER_NAME'] == $config['urls']['baseUrl'])
	$GLOBALS['testHaveSwitch'] = False;
else 
	$GLOBALS['testHaveSwitch'] = False;





?>