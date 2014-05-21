<?php include('header.php'); 
	  include_once('connect.php');


	  $uname = htmlspecialchars($_POST['email']);
	  $upass = htmlspecialchars($_POST['password']);

	  if ($con) {

	  }
	  else {

	  	$errorMessage = "Error logging on.";
	  }

	 // $uname = quote_smart($uname, $con);
	 //$upass = quote_smart($upass, $con);




?>

<div class="container-fluid">

	<?PHP print $errorMessage;?>

	<div class="row col-md-6 col-md-offset-3 text-center">
		<div class="panel-heading">
			<h2>Hello, <?php echo "$uname"; ?></h2>
		</div>
	</div>
</div>

<?php 
mysql_close($con);
include('footer.php'); 
?>