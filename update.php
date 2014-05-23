<?php
include('header.php');
include('connect.php');

// Need to tell which value is being updated too.

if (isset($_POST['newMajorId']))
	$newUserMajor = test_input($_POST['newMajorId']);
else
	$newUserMajor = "-1";


//newCycle is not getting passed in properly
if (isset($_POST['newCycleId']))
	$newUserCycle = test_input($_POST['newCycleId']);
else
	$newUserCycle = "-1";

// ON ALL UPDATES UNDO THE MATCHES (For both users). IMP. Also verify major actually changes in db.


//echo $newUserMajor;

// Get the user we are talking to and save them into a local array.
/* Probably do not need this, use session vars since they are from db. */

$query = "SELECT * FROM Users WHERE id = " . $_SESSION['user_id'];
$result = mysql_query($query);
$user_data = array(); 
$row = mysql_fetch_array($result);
$user_data[0] = $row;

if ($user_data[0]['major'] != $newUserMajor && $newUserMajor != "-1")
{
	$query = "UPDATE Users SET major = " . $newUserMajor . " WHERE id = " . $_SESSION['user_id'];
	$_SESSION['user_major'] = $newUserMajor;

	// Update user's major name too.
	$result = mysql_query("SELECT major_long FROM Majors WHERE id = " . $_SESSION['user_major']);
	$row = mysql_fetch_array($result);
	$_SESSION['user_major_name'] = $row['major_long'];

	//echo $_SESSION['user_major_name'];
	header("Location: account.php"); // Send back (ACCOUNT UPDATED) message?
}

else if ($user_data[0]['cycle'] != $newUserCycle && $newUserCycle != "-1")
{
	echo "New $newUserCycle";

	$query = "UPDATE Users SET cycle = " . $newUserCycle . " WHERE id = " . $_SESSION['user_id'];
	$_SESSION['user_cycle'] = $newUserCycle;

	if ($newUserCycle == 1)
		$_SESSION['user_cycle_name'] = "Fall-Winter";
	else if ($newUserCycle == 2)
		$_SESSION['user_cycle_name'] = "Spring-Summer";

	//echo $_SESSION['user_cycle_name'];

	header("Location: account.php");
}


if (!mysql_query($query,$con)) {
	die('Error: ' . mysql_error());
}

else {
}

	// Use header location thing go back account page display "UPDATED" message
	


mysql_close($con);


include('footer.php');
?>