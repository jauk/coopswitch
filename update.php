<?php
include('header.php');
include('connect.php');

// Need to tell which value is being updated too.

if (isset($_POST['newMajorId']))
	$newUserMajor = test_input($_POST['newMajorId']);
else
	$newUserMajor = "";

if (isset($_POST['newCycleId']))
	$newUserCycle = test_input($_POST['newCycleId']);
else
	$newUserCycle = "";

if (isset($_POST['newProgramId']))
	$newUserProgram = test_input($_POST['newProgramId']);
else
	$newUserProgram = "";

// ON ALL UPDATES UNDO THE MATCHES (For both users). IMP. Also verify major actually changes in db.


//echo $newUserMajor;

// Get the user we are talking to and save them into a local array.
/* Probably do not need this, use session vars since they are from db. */

$query = "SELECT * FROM Users WHERE id = " . $_SESSION['user_id'];
$result = mysql_query($query);
$user_data = array(); 
$row = mysql_fetch_array($result);
$user_data[0] = $row;

// Update Majors
if ($user_data[0]['major'] != $newUserMajor && $newUserMajor != "")
{
	$query = "UPDATE Users SET major = " . $newUserMajor . " WHERE id = " . $_SESSION['user_id'];
	$_SESSION['user_major'] = $newUserMajor;

	// Update user's major name too.
	$result = mysql_query("SELECT major_long FROM Majors WHERE id = " . $_SESSION['user_major']);
	$row = mysql_fetch_array($result);
	$_SESSION['user_major_name'] = $row['major_long'];

	header("Location: account.php"); // Send back (ACCOUNT UPDATED) message?
}

// Update Cycles
else if ($user_data[0]['cycle'] != $newUserCycle && $newUserCycle != "")
{
	$query = "UPDATE Users SET cycle = " . $newUserCycle . " WHERE id = " . $_SESSION['user_id'];
	$_SESSION['user_cycle'] = $newUserCycle;

	if ($newUserCycle == 1)
		$_SESSION['user_cycle_name'] = "Fall-Winter";
	else if ($newUserCycle == 2)
		$_SESSION['user_cycle_name'] = "Spring-Summer";

	header("Location: account.php");
}

/// Update Programs
else if ($user_data[0]['num_year_program'] != $newUserProgram && $newUserProgram != "")
	$query = "UPDATE Users SET num_year_program = " . $newUserProgram . " WHERE id = " . $_SESSION['user_id'];
	$_SESSION['user_program'] = $newUserProgram;

	if ($newUserProgram == 1)
		$_SESSION['user_program_name'] = "1 co-op";
	else if ($newUserProgram == 2)
		$_SESSION['user_program_name'] = "3 co-ops";

	header("Location: account.php");
}

// Just in case submit nothing or something.
else
	header("Location: account.php");

//

if (!mysql_query($query,$con)) {
	die('Error: ' . mysql_error());
}

else {
}

	// Use header location thing go back account page display "UPDATED" message
	


mysql_close($con);


include('footer.php');
?>