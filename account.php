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
		<br>
		<?php if ($_SESSION['user_matched'] == 0) { 

			// Get user's updated match status each time they view  their profile.
			$_SESSION['user_matched'] = mysql_get_var("SELECT matched FROM Users WHERE id = " . $_SESSION['user_id']);
			
			// If matched == 1, get Matched_id too.
			if ($_SESSION['user_matched'] == 1)
			{
				$_SESSION['user_matched_id'] = mysql_get_var("SELECT Matches_id FROM Users WHERE id = " . $_SESSION['user_id']);
			}
		?>
		<!-- If user does not have a match, code here. -->
		<p class="lead">You do not have a match yet, but we will keep looking!</p>

		<?php } if ($_SESSION['user_matched'] == 1) { ?>
		<!-- If user has a match, display information about it. -->

		<div class="row-fluid col-md-6 col-md-offset-3 text-center well">

		<p class="lead">Hey, you have a match!</p>

		<?php

		echo $_SESSION['user_matched_id'];
		$query = "SELECT * FROM Matches WHERE id = " . $_SESSION['user_matched_id'] . "";
		$result = mysql_query($query);

		$matched_data = array();
	    $row = mysql_fetch_array($result);
	    $matched_data[0] = $row; // Save the match information into an array to pull data from

	    //echo $result;
	    //echo "{$_SESSION['user_matched_id']}";

	    // Get the ID of the logged in user's match
	    if ($matched_data[0]['userA'] == $_SESSION['user_id'])
	    	$other_user_match_id = $matched_data[0]['userB'];
	    else
	    	$other_user_match_id = $matched_data[0]['userA'];


	    $query = "SELECT * FROM Users WHERE id = " . $other_user_match_id;
	    $result = mysql_query($query);

	    $other_user_data = array();
	    $row = mysql_fetch_array($result);
	    $other_user_data[0] = $row;

	    echo "You have matched with <strong>" . $other_user_data[0]['name'] . "</strong>.<br>";
	    echo "You can email them at <strong>" . $other_user_data[0]['email'] . "</strong>.";

		} ?>

		</div>

	</div>



</div>

<?php 

mysql_close($con);
include('footer.php'); 
?>

<!-- To Do For User Page 

- Ability to change information (cycle, major, 4/5 year)
- Other misc. I guess
