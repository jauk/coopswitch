<?php
include('scripts.php');
include('mail.php');
/* Have a cron job run this page every minute so checks are always done. FOR PRODUCTION SERVER. */

$debug = 0;

include_once('connect.php');

$num = get_not_matched();


  if ($num > 0) // If there are people not matched, run this.
   {
      $users_not_matched = array(); // Array of those who are not matched.
      $matches = 0; // Lets see how many matches are made this round. Maybe save value later? Stats, stats, stats.

      $index = 0;
      while ($row = mysql_fetch_array($result))
      {
        $users_not_matched[$index] = $row; // Save the users into the array.
        $index++; // KIND OF NEED THIS...
      }

      for ($x = 0; $x < $index; $x++) // Why doesn't count() work for array?
        {
          // Select people with the same major who are not the person we are searching for. Forgot the matched = 0

         // $IdsGoneThrough = array(); // Save the Ids gone through and do not let them be compared again? Wait no .

          $query = "SELECT * FROM Users WHERE matched = 0 AND major = " . $users_not_matched[$x]['major'] . " AND id != " . $users_not_matched[$x]['id'] . " AND cycle != " . $users_not_matched[$x]['cycle'] . " AND num_year_program = " . $users_not_matched[$x]['num_year_program'] . "";
          $result = mysql_query($query);

          //  
          if ((mysql_num_rows($result) > 0) && ($users_not_matched[$x]['matched'] != 1)) // We found people who match the guy inside $users_not_matched. NEED TO UPDATE $users_not_matched after a match is made. Remove from array after matched.
            {
              $matched_user_data = array(); // Reset the array.

              /* For right now, only need first row since matches are done first-come, first-serve. Do not need to store all matches, just the first. Loop not needed. */
              //$index = 0;
              //while ($row = mysql_fetch_array($result))
              //{
              $row = mysql_fetch_array($result);
              $matched_user_data[0] = $row; // Save the user's info in an array. Temp for now to do stuff easier
              //}

              // Testing

              /* Put the users into the Matches table and set equaled to matched. */

              // Update both users to be matched.
              $query = "UPDATE Users SET matched = 1 WHERE id = " . $users_not_matched[$x]['id'] . " OR id = " . $matched_user_data[0]['id'] . ""; 
              $users_not_matched[$x]['matched'] = 1;

              // Find where $matched_user_data[0] is in $users_not_matched and set matched = 1 so that it stops dupes.
              // Learn how to foreach loops and MAKE MORE EFFICIENT.

              for ($i = 0; $i < count($users_not_matched); $i ++)
              {
                if ($users_not_matched[$i]['id'] == $matched_user_data[0]['id'])
                  {
                    $users_not_matched[$i]['matched'] = 1;
                    break;
                  }
              }

              //$query = "INSERT INTO Users (id, matched) VALUES (" . $users_not_matched[$x]['matched'] . ",1),(" . $matched_user_data[0]['id'] . ",1)";
              $result = mysql_query($query);


              /* *** Matches db need to add date matched, date completed, major val (to compare to when change major in profile, also for stats [ie. most popular majors]) */

              // Insert into the Matches database.
              $query = sprintf("INSERT INTO Matches (userA, userB, major, date_matched) VALUES (" . $users_not_matched[$x]['id'] . ", " . $matched_user_data[0]['id'] . ", " . $users_not_matched[$x]['major'] . ")");
             //$query = sprintf("INSERT INTO Matches (userA, userB) VALUES (" . $users_not_matched[$x]['id'] . ", " . $matched_user_data[0]['id'] . ")");
              $result = mysql_query($query);

              // Grab the Id of the match from Matches table
              $query = mysql_query("SELECT id FROM Matches WHERE userA= " . $users_not_matched[$x]['id'] . " OR userB= " . $matched_user_data[0]['id'] . "");
              $result = mysql_fetch_array($query);
              $newMatchId = $result['id'];
              //echo "Match ID: " . $newMatchId . "<br>";

              // Add the Matched ID to the Users
              $query = "UPDATE Users SET Matches_id = " . $newMatchId . " WHERE id = " . $users_not_matched[$x]['id'] . " OR id = " . $matched_user_data[0]['id'] . "";
              $result = mysql_query($query);
          
              $matches ++;

              // Send names and emails to mail script to mail users that they have been matched.
              mail_matched_users($users_not_matched[$x]['name'], $users_not_matched[$x]['email'], $matched_user_data[0]['name'], $matched_user_data[0]['email']);

              if ($debug == 1)
              {
                 echo "<hr><em>Looks like we found a match!</em><br>";
                 // IDs of matched people.
                 echo $users_not_matched[$x]['id'] . " and " . $matched_user_data[0]['id'] . "<br>";
                 // Is the matched value set?
                 echo $users_not_matched[$x]['matched'] . " and " . $matched_user_data[0]['matched'] . "<br>";

              }

              // Need to update user sessions if logged in and a match happens.
              // Best way to do that?


            } // End If Statement (If match)
          else
            {
            }
        } // End For Loop
    } // End Main If Statement (If there is even a reason to run through all this code)

mysql_close($con);

//header("Location: check.php");

?>