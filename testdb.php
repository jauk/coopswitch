<?php
include('header.php');
?>

<div class="container-fluid">

	<div class="row text-center">

<?php

include_once('connect.php');



$limit = 101;
$names = array("apple", "banana", "mango", "blueberry", "grape");
$password = "";
$email = "";


for ($x = 1; $x < $limit; $x++) {

	$name = $names[array_rand($names)];
	$password = "$x";
	$cycle = rand(1,2);
	$num_year_program = rand(1,2);
	$majorVal = rand(2,87);
	$email = "$name$x@drexel.edu"; 

	$sql="INSERT INTO Users (name, password, email, cycle, num_year_program, major, register_date)
		  VALUES ('$name','$password', '$email','$cycle', '$num_year_program', '$majorVal',
				'".date("Y-m-d H:i:s")."'
		)";

	//echo "$name $email <br>";

	$resutl=mysql_query($sql);

}

mysql_close($con);

echo "Records generated.";

header('Location: update.php');

?>

	</div>

</div>

<?php
include('footer.php');


?>