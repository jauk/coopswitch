<?php
include('header.php')


?>

<br />
<div class="container-fluid">

<?php

$rowClass = "row-fluid col-md-6 col-md-6-offset-3 col-sm-6 col-sm-offset-3 text-center";

include_once('connect.php');


/* Actual Work Start */

// Get all the peoples not matched.

$query="SELECT * FROM Users WHERE matched = 0";
$result=mysql_query($query);
$num=mysql_num_rows($result);

?>

<div class="<?php echo $rowClass; ?>">
  <p>There are <?php echo $num; ?> people who have not been matched.</p>
  <?php if ($num == 0) echo "Hooray!" ?>
</div>

<?php

$users_not_matched = array(); // Array of those who are not matched.

$index = 0;
while ($row = mysql_fetch_array($result))
{
  $users_not_matched[$index] = $row; // Save the users into the array.
}

$x = 0; 

while ($x < count($users_not_matched)) // Less than number of people in the array.
//for (var $x = 0; $x < count(users_not_matched);)
  {
    // Select people with the same major who are not the person we are searching for.
    $query = "SELECT * FROM Users WHERE major = " . $users_not_matched[$x]['major'] . " AND id != " . $users_not_matched[$x]['id'] . " AND cycle != " . $users_not_matched[$x]['cycle'] . " AND num_year_program = " . $users_not_matched[$x]['num_year_program'] . "";
    $result = mysql_query($query);

    if (mysql_num_rows($result) > 0)
      {
        echo "Looks like we found a match!\n\n";

        $matched_user_data = array();

        /* For right now, only need first row since matches are done first-come, first-serve. Do not need to store all matches, just the first. Loop not needed. */
        //$index = 0;
        //while ($row = mysql_fetch_array($result))
        //{
        $row = mysql_fetch_array($result);
        $matched_user_data[0] = $row; // Save the user's info in an array.
        //}
        echo $matched_user_data[0]['email'];

        /* Put the users into the Matches table and set equaled to matched. */

        // Update both users to be matched.
        $query = "UPDATE Users SET matched = 1 WHERE id = " . $users_not_matched[$x]['id'] . " OR id = " . $matched_user_data[0]['id'] . "";
        $result = mysql_query($query);

        // Insert into the database. WORKS
        $query = sprintf("INSERT INTO Matches (userA, userB) VALUES (" . $users_not_matched[$x]['id'] . ", " . $matched_user_data[0]['id'] . ")");
        $result = mysql_query($query);

        // Grab the Id of the match from Matches table
        $query = mysql_query("SELECT id FROM Matches WHERE userA= " . $users_not_matched[$x]['id'] . " AND userB= " . $matched_user_data[0]['id'] . "");
        $result = mysql_fetch_array($query);
        $newMatchId = $result['id'];

        // Add the Matched ID to the Users
        $query = "UPDATE Users SET Matches_id = " . $newMatchId . " WHERE id = " . $users_not_matched[$x]['id'] . " OR id = " . $matched_user_data[0]['id'] . "";
        $result = mysql_query($query);

      }
    else
      echo "No match for user " . $x . ". :(";


    $x += 1;

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