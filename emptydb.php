<?php
include('header.php');
?>

<div class="container-fluid">

	<div class="row text-center">

<?php

include_once('connect.php');

$sql = "DELETE FROM Users";
$result = mysql_query($sql);

$sql = "DELETE FROM Matches";
$result = mysql_query($sql);

$sql = "ALTER TABLE Users AUTO_INCREMENT = 1";
$result = mysql_query($sql);

$sql = "ALTER TABLE Matches AUTO_INCREMENT = 1";
$result = mysql_query($sql);

mysql_close($con);

echo "Records deleted.";

?>

	</div>

</div>

<?php
include('footer.php');


?>