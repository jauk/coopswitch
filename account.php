<?php include('header.php'); 
	//   include_once('connect.php');

	if ($_SESSION['login'] == "")
		{
			header("Location: error.php"); // Temporary I guess
		}
	else if ($_SESSION['login'] == "1")
	{
		echo "Logged on.";
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