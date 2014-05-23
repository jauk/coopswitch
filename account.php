<?php 
include('header.php'); 
include_once('connect.php');

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

	</div>

	<div class="row-fluid col-md-6 col-md-offset-3 text-center">
		<!-- Use Javascript with PHP to allow users to edit these fields. -->
		<!-- Have the fields clickable, when you click a dropdown box
			 appears that allows you to change it (from register form). 
			 Too ambitious? Naaah. -->

		<h4>Your major is <?php echo "{$_SESSION['user_major_name']}"; ?>.</h4> 
		<h4>Your cycle is <?php echo "{$_SESSION['user_cycle_name']}"; ?>.</h4>
		<h4>Your program is <?php echo "{$_SESSION['user_program_name']}"; ?>.</h4>
	</div>

	<?php 
		if ($_SESSION['user_matched'] == 0)
		{
			$_SESSION['user_matched'] = mysql_get_var("SELECT matched FROM Users WHERE id = " . $_SESSION['user_id']);
		}

		// If the user has a match, get the match's info and display it.
		if ($_SESSION['user_matched'] == 1) { 

			$other_user_data = array();
			$other_user_data = get_match_info();
	?>

	<div class="row-fluid col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 text-center">
		<br><hr><p class="lead">Hey, you have a match!</p>
	</div>

	<div class="row-fluid col-md-6 col-md-offset-3 text-center well">
		<p>You have matched with <strong> <?php echo $other_user_data[0]['name']; ?></strong>.</p>
		<p>You can email them at <strong> <?php echo $other_user_data[0]['email']; ?></strong></p>
	</div>
	
	<?php } else { // If the user does not have a match tell them they still do not. ?>
		<div class="row-fluid col-md-6 col-md-offset-3 text-center">
			<br><hr><p class="lead">You do not have a match yet, but we will keep looking!</p>
		</div>
	<?php } ?>

</div>

<?php 

mysql_close($con);
include('footer.php'); 
?>

<!-- To Do For User Page 

- Ability to change information (cycle, major, 4/5 year)
- Other misc. I guess
