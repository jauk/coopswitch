<?php
include('header.php')
?>

<br />
<div class="container-fluid">

<?php

include_once('connect.php');

$rowClass = "row-fluid col-md-6 col-md-6-offset-3 col-sm-6 col-sm-offset-3 text-center";

/* Actual Work Start */

// Get all the peoples not matched.

$query="SELECT * FROM Users WHERE matched = 0";
$result=mysql_query($query);
$num=mysql_numrows($result);

?>

<div class="$rowClass">
  <p>There are <?php echo $num; ?> people who have not been matched.</p>
</div>

<?php

$users_not_matched = array();

$index = 0;
while ($row = mysql_fetch_array($result))
{
  $users_not_matched[$index] = $row; // Save the users into an array.
}

// Go through each person and look for a match.

$x = 0; 
$y = 0;


while ($x < count($users_not_matched)) // Less than number of people in the array.
  {
    // Select people with the same major who are not the person we are searching for.
    $queryN = "SELECT * FROM Users WHERE major = " . $users_not_matched[$x]['major'] . " AND id != " . $users_not_matched[$x]['id'] . " AND cycle != " . $users_not_matched[$x]['cycle'] . " AND num_year_program = " . $users_not_matched[$x]['num_year_program'] . "";

    $resultN = mysql_query($queryN);

    if (mysql_num_rows($resultN) > 0)
      {
        echo "Looks like we found a match!\n\n";

        $matched_user_data = array();

        /* For right now, only need first row since matches are done first-come, first-serve. Do not need to store all matches, just the first. Loop not needed. */
        //$index = 0;
        //while ($row = mysql_fetch_array($resultN))
        //{
          $matched_user_data[$index] = $row; // Save the user's info in an array.
        //}

      }
    else
      echo "No one has registered with that major yet.";


    $x += 1;

    /*


  	$majorA=mysql_result($result, $x, "major"); // Pick the major of the person we will be searching.
  	
  	while ($y < $num) // Right now, go through each major for each person. Not efficient. Better way?
  	  {

  	  	if ($y == $x) // Skip the person we are searching for?
  	  		$y++;

  	  	$majorB=mysql_result($result, $y, "major"); // Major of the second person.


  	  	if ($majorA == $majorB)  // Same major! Opposite cycles? 
  	  	{  	  		
          // Get the cycle from each person.
  	  		$cycleA=mysql_result($result, $x, "cycle");
  	  		$cycleB=mysql_result($result, $y, "cycle");

  	  		if ($cycleA != $cycleB) // If they opposite cycles (we want this).
  	  			{

              // Use getElementById instead of this foolishness.

              ?>

  	  				<div class="$rowClass">
  	  				<p class="lead">We found a match!</p>'
              </div>"

              <?php

              $userAIdent = mysql_result($result, $x, "id");
              $userBIdent = mysql_result($result, $y, "id");

  	  				$query = sprintf("INSERT INTO Matches (userA, userB) VALUES ('$userAIdent', '$userBIdent')");
              $result = mysql_query($query);

  	  			  $query = sprintf("UPDATE Users SET matched=1 WHERE id='$userAIdent'");
              $result = mysql_query($query);

  	  				$query = sprintf("UPDATE Users SET matched=1 WHERE id='$userBIdent'");
              $result = mysql_query($query);

              $query = mysql_query("SELECT id FROM Matches WHERE userA='$userAIdent' AND userB='$userBIdent'");
              $result = mysql_fetch_array($query);
              $NewMatchId = $result['id'];

              // Add the Matched ID to the Users //
              $query = sprintf("UPDATE Users SET Matches_id='$NewMatchId' WHERE id='$userAIdent'");
              $result = mysql_query($query);
              $query = sprintf("UPDATE Users SET Matches_id='$NewMatchId' WHERE id='$userBIdent'");
              $result = mysql_query($query);

  	  				//break;

              // Maybe just use PHP or something to update JS to display crap in foreground while PHP does background stuff.
  	  			}
  	  	} 

  	  	$y++;
  	  }
	 
  	  $x++;
  	  $y=0;

      */
  }

/* Actual Work End */

mysql_close($con);

?>

</div>

<br />
<?php
include('footer.php')

// Add to Matches table, set matched val to 1, connect with each other.
// Matches table: id, personA id, personB id, isFinished val, date.

// After a match is made it will show up on users profile and they will get an email.

?>