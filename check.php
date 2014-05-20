<?php
include('header.php')
?>

<br />
<div class="container-fluid">

<?php

include_once('connect.php');

/* Actual Work Start */

// Get all the peoples not matched.

$query="SELECT * FROM Users WHERE matched = 0";
$result=mysql_query($query);
$num=mysql_numrows($result);

echo '<div class="row-fluid col-md-6 col-md-6-offset-3 col-sm-6 col-sm-offset-3 text-center">';
echo "<p>There are " . $num . " people who have not been matched.</p>";
echo "</div>";

// Go through each person and look for a match.

$x = 0; $y = 0; 

while ($x < $num)
  {
  	$majorA=mysql_result($result, $x, "major");
  	
  	while ($y < $num)
  	  {
  	  	if ($y == $x)
  	  		$y++;


  	  	$majorB=mysql_result($result, $y, "major");

  	  	// Same major! Opposite cycles? 

  	  	if ($majorA == $majorB)
  	  	{  	  		
  	  		$cycleA=mysql_result($result, $x, "cycle");
  	  		$cycleB=mysql_result($result, $y, "cycle");
  	  		if ($cycleA != $cycleB) 
  	  			{
  	  				echo '<div class="row-fluid col-md-6 col-md-6-offset-3 col-sm-6 col-sm-offset-3 text-center">';
  	  				echo '<p class="lead">We found a match!</p>'; 

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

  	  				echo "</div>";

  	  				//break;
  	  			}
  	  	} 

  	  	$y++;
  	  }
	 
  	  $x++;
  	  $y=0;
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
?>