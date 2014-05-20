<?php include('header.php'); 
	  include_once('connect.php');
?>

<?php

// Get User Info //

//$query = mysql_query("SELECT name WHERE ")

?>

<div class="container-fluid">

	<div class="row col-md-6 col-md-offset-3 text-center">
		<div class="panel-heading">
			<h2>Hello, <?php echo "$_SERVER[user]"; ?></h2>
		</div>
	</div>
</div>

<?php 
mysql_close($con);
include('footer.php'); ?>