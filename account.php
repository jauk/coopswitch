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

		<p>Welcome to your profile. Profile stuff goes here.</p><br>
	</div>

	<div class="row-fluid col-md-6 col-md-offset-3">
		<!-- Use Javascript with PHP to allow users to edit these fields. -->
		<h4>Your major is <?php echo "{$_SESSION['user_major_name']}"; ?>.</h4> 
		<h4>Your cycle is <?php echo "{$_SESSION['user_cycle_name']}"; ?>.</h4>
		<h4>Your program is <?php echo "{$_SESSION['user_program_name']}"; ?>.</h4>

		<!-- Lets let people edit those fields... -->

		<!-- Fix this: when match is made it shows both if statements ... -->

		<br>


		<?php 

			if ($_SESSION['user_matched'] == 1) { 

				$match_info = array();
				$other_user_data = get_match_info();
				// Return match's info in an array? Name, email. 


			?>

			<div class="row-fluid col-md-6 col-md-offset-3 text-center">
				<p class="lead">Hey, you have a match!</p>
			</div>

			<div class="row-fluid col-md-6 col-md-offset-3 text-center well">
				<p>You have matched with <strong> <?php echo $other_user_data[0]['name']; ?></strong>.</p>
	    		<p>You can email them at <strong> <?php echo $other_user_data[0]['email']; ?></strong></p>
			</div>



			<?php

			}
			else if ($_SESSION['user_matched'] == 0) { 
				// Get user's updated match status each time they view  their profile.
				$_SESSION['user_matched'] = mysql_get_var("SELECT matched FROM Users WHERE id = " . $_SESSION['user_id']);
				
				// If matched == 1, get Matched_id too.
				if ($_SESSION['user_matched'] == 1)
				{
					$_SESSION['user_matched_id'] = mysql_get_var("SELECT Matches_id FROM Users WHERE id = " . $_SESSION['user_id']);
					get_match_info();
				}
				else
					echo '<p class="lead">You do not have a match yet, but we will keep looking!</p>';
			}	
		?>
		<!-- If user does not have a match, code here. -->

		<!-- If user has a match, display information about it. -->



	</div>



</div>

<?php 

mysql_close($con);
include('footer.php'); 
?>

<!-- To Do For User Page 

- Ability to change information (cycle, major, 4/5 year)
- Other misc. I guess
