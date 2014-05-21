<?php include('header.php'); 
	//   include_once('connect.php');

	//   $umail = htmlspecialchars($_POST['email']);
	//   $upass = htmlspecialchars($_POST['password']);

	//   if ($db_found) {

	//   }
	//   else {

	//   	$errorMessage = "Error logging on. 1";
	//   }

	// // Learn about quote_smart funcion for sql injection protection! IMPORTANT!
	// // $umail = quote_smart($uname, $con);
	// // $upass = quote_smart($upass, $con);

	// $sql = "SELECT * FROM Users WHERE email = '$umail' AND password = '$upass'";
	// $result = mysql_query($sql);


	// if ($result){

	// }
	// else {
	// 	die(mysql_error());
	// 	$errorMessage = "Error logging on. 2";
	// }

	// $num_rows = mysql_num_rows($result);

	// if ($num_rows == 1) {
	// 	$errorMessage = "Logged on!";
	// 	session_start();
	// 	$_SESSION['login']="1";
	// 	header("")

	// }
	// else {
	// 	$errorMessage = "Invalid Logon.";
	// }


	if ($_SESSION['login'] == "")
		{
			header("Location: error.php"); // Temporary I guess
		}


?>

<div class="container-fluid">

	<?php print $errorMessage;?>

	<div class="row col-md-6 col-md-offset-3 text-center">
		<div class="panel-heading">
			<h2>Hello, <?php echo "$umail"; ?></h2>
		</div>
		<?php echo "$upass"; ?>
	</div>
</div>

<?php 
//mysql_close($con);
include('footer.php'); 
?>