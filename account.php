<?php include('header.php'); 
	  include_once('connect.php');

	  $umail = htmlspecialchars($_POST['email']);
	  $upass = htmlspecialchars($_POST['password']);

	  if ($db_found) {

	  }
	  else {

	  	$errorMessage = "Error logging on.";
	  }

	// Learn about quote_smart funcion for sql injection protection! IMPORTANT!
	//$umail = quote_smart($uname, $con);
	//$upass = quote_smart($upass, $con);

	$sql = "SELECT * FROM Users WHERE email = $umail AND password = $upass";
	$result = mysql_query($sql);

	/*

	if ($result){

	}
	else {
		$errorMessage = "Error logging on.";
	}

	$num_rows = mysql_num_rows($result);

	if ($num_rows == 1) {
		errorMessage = "Logged on!";
	}
	else {
		errorMessage = "Invalid Logon.";
	}

	*/

?>

<div class="container-fluid">

	<?PHP print $errorMessage;?>

	<div class="row col-md-6 col-md-offset-3 text-center">
		<div class="panel-heading">
			<h2>Hello, <?php echo "$umail"; ?></h2>
		</div>
	</div>
</div>

<?php 
mysql_close($con);
include('footer.php'); 
?>