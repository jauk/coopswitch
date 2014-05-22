<?php
include('header.php');

include_once('connect.php');

$limit = 100;
$name = "";
$password = "";
$email = "";


for ($x = 0; $x < $limit; $x++) {

	$cycle = rand(1,2);
	$num_year_program = rand(1,2);
	$majorVal = rand(2,87);
	$email = "$x@drexel.edu";

	$sql="INSERT INTO Users (name, password, email, cycle, num_year_program, major, register_date)
		  VALUES ('$name','$password', '$email','$cycle', '$num_year_program', '$majorVal',
				'".date("Y-m-d H:i:s")."'
		)";

	$resutl=mysql_query($sql);


}

mysql_close($con);

echo "Records generated.";

include('footer.php');


?>