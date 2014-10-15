<?php

$userData = $_POST;
$submitData = count($userData);

echo $submitData;
foreach ($userData as $key => $value) {
	echo $key . ": " . $value . "\n";
}

?> 