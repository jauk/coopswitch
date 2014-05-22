<?php include('header.php'); 
	//   include_once('connect.php');

	if ($_SESSION['login'] == "")
	{
		header("Location: error.php"); // Temporary I guess maybe add like ?error=1
	}
	else if ($_SESSION['login'] == "1")
	{
		//echo "Logged on.";
	}

?>

<hr>

<div class="container-fluid">

	<?php print $errorMessage;?>

	<div class="row-fluid col-md-6 col-md-offset-3 text-center">
		<div class="panel-heading">
			<h2>Hello, <?php echo "{$_SESSION['user_name']}" ?>!</h2>
		</div>	

		<p>Welcome to your profile. Profile stuff goes here.</p>
	</div>

	<div class="row-fluid col-md-6 col-md-offset-3">
		<!-- Use Javascript with PHP to allow users to edit these fields. -->
		<h4>Your major is <?php echo "{$_SESSION['user_major_name']}"; ?>.</h4>
		<h4>Your cycle is <?php echo "{$_SESSION['user_cycle_name']}"; ?>.</h4>
		<h4>Your program is <?php echo "{$_SESSION['user_program_name']}"; ?>.</h4>
		<br>
		<?php if ($_SESSION['user_matched'] == 0) { ?>
		<!-- If user does not have a match, code here. -->

		<?php } else { ?>
		<!-- If user has a match, display information about it. -->

		<?php } ?>

	</div>



</div>

<?php 
//mysql_close($con);
include('footer.php'); 
?>

<!-- To Do For User Page 

- Ability to change information (cycle, major, 4/5 year)
- Other misc. I guess
