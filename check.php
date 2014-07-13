<?php
require_once(__DIR__ . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");
//include('mail.php');
/* Have a cron job run this page every minute so checks are always done. FOR PRODUCTION SERVER. */

if (isset($msg))
  $msg = test_input($_GET['msg']);

?>


<script>
$(function(){
    $('#generate_records').click(function(){
        $.ajax({
            url: '/resources/dev/testdb.php',
            success: function(data) { // data is the response from your php script
                // This function is called if your AJAX query was successful
                //alert("Response is: " + data);
                window.location.href = 'check.php?msg=1';
            },
            error: function() {
                // This callback is called if your AJAX query has failed
                alert("Error!");
            }
        });
    });
});

$(function(){
    $('#delete_records').click(function(){
        $.ajax({
            url: '/resources/dev/emptydb.php',
            success: function(data) { // data is the response from your php script
                // This function is called if your AJAX query was successful
                //alert("Response is: " + data);
                window.location.href = 'check.php?msg=2';
            },
            error: function() {
                // This callback is called if your AJAX query has failed
                alert("Error!");
            }
        });
    });
});

</script>

<div class="container-fluid">

<?php

$rowClass = "row-fluid col-md-6 col-md-6-offset-3 col-sm-6 col-sm-offset-3 text-center";

include(FUNCTION_PATH . "/connect.php");

// Filter out not verifieds.

// How many users have a match:
$query = "SELECT * FROM Users WHERE matched = 1";
$usersMatched = mysql_num_rows(mysql_query($query));

// How many users do not have a match:
$query="SELECT * FROM Users WHERE matched = 0 AND verified = 1 ORDER BY dropped_matches ASC";
$result=mysql_query($query);

if ($result) {
  $num=mysql_num_rows($result); // ...It's this many
  $notMatched = $num; 
}



?>
  
  <div class="<?php echo $rowClass; ?>">
    <?php
    if (isset($msg)) {
      if ($msg == 1)
          echo "<strong>Records generated.</strong><br><br>";
      else if ($msg == 2)
          echo "<strong>Database cleared.</strong><br><br>";

      $msg = 0;
    }

    ?>
    <p class="lead">
    <?php 

    if ($notMatched+$usersMatched > 0) {
      $percentNotMatched = $notMatched/($notMatched+$usersMatched)*100;
      $percentNotMatched = number_format((float)$percentNotMatched, 2, '.', '');
    }

      if ($num == 0) echo "Hooray, everyone is matched!<br><br>";
      else { ?>
          There are still <?php echo $notMatched ?> people who still need to be matched, or <?php echo $percentNotMatched ?>% of verified users.
    </p>
    <p class="lead">
    Will now attempt to manually match.
    </p>
    <?php } ?>

    <?php if ($debug_db) { ?>
    <button id="generate_records" type="button" class="btn btn-warning">Generate Records</button>
    <button id="delete_records" type="button" class="btn btn-danger">Delete Records</button>
    <?php } ?>
  </div>

<?php
  
  // I need to order both arrays by number of dropped matches? Less = first.

  if ($num > 0) {// If there are people not matched, run this.
   
      $users_not_matched = array(); // Array of those who are not matched.
      $matches = 0; // Lets see how many matches are made this round. Maybe save value later? Stats, stats, stats.

      $index = 0;
      while ($row = mysql_fetch_array($result)) {
  
        $users_not_matched[$index] = $row; // Save the users into the array.
        $index++; // KIND OF NEED THIS...
      }

      echo "<br><br>";

      for ($x = 0; $x < $index; $x++) {// Why doesn't count() work for array?

          // Select people with the same major who are not the person we are searching for. Forgot the matched = 0

         // $IdsGoneThrough = array(); // Save the Ids gone through and do not let them be compared again? Wait no .

          $query = " SELECT * FROM Users WHERE matched = 0 AND verified = 1 AND major = " . $users_not_matched[$x]['major'] .
                   " AND id != " . $users_not_matched[$x]['id'] . " AND cycle != " . $users_not_matched[$x]['cycle'] .
                   " AND num_year_program = " . $users_not_matched[$x]['num_year_program'] .
                   " ORDER BY dropped_matches ASC";

          $result = mysql_query($query);

          //
          if ((mysql_num_rows($result) > 0) && ($users_not_matched[$x]['matched'] != 1)) {// We found people who match the guy inside $users_not_matched. NEED TO UPDATE $users_not_matched after a match is made. Remove from array after matched.
        
              $matched_user_data = array(); // Reset the array.

              $row = mysql_fetch_array($result);
              $matched_user_data = $row; // Save the user's info in an array. 

              /* Put the users into the Matches table and set equaled to matched. */

              // Update both users to be matched.
              $query = "UPDATE Users SET matched = 1 WHERE id = " . $users_not_matched[$x]['id'] . " OR id = " . $matched_user_data['id'] . "";
              $users_not_matched[$x]['matched'] = 1;

              // Find where $matched_user_data is in $users_not_matched and set matched = 1 so that it stops dupes.
              // Learn how to foreach loops and MAKE MORE EFFICIENT.
              for ($i = 0; $i < count($users_not_matched); $i ++) {
                if ($users_not_matched[$i]['id'] == $matched_user_data['id']) {
                    $users_not_matched[$i]['matched'] = 1;
                    break;
                  }
              }

              //$query = "INSERT INTO Users (id, matched) VALUES (" . $users_not_matched[$x]['matched'] . ",1),(" . $matched_user_data['id'] . ",1)";
              $result = mysql_query($query);


              /* *** Matches db need to add date matched, date completed, major val (to compare to when change major in profile, also for stats [ie. most popular majors]) */

              // Insert into the Matches database.
              $query = sprintf("INSERT INTO Matches (userA, userB, major, isFinished, date_matched) VALUES (" . $users_not_matched[$x]['id'] . ", " . $matched_user_data['id'] . ", " . $users_not_matched[$x]['major'] . ", 0, " .'date("Y-m-d H:i:s")' . " )");
              //$query = sprintf("INSERT INTO Matches (userA, userB) VALUES (" . $users_not_matched[$x]['id'] . ", " . $matched_user_data['id'] . ")");
              $result = mysql_query($query);

              // Grab the Id of the match from Matches table
              $query = mysql_query("SELECT id FROM Matches WHERE userA= " . $users_not_matched[$x]['id'] . " OR userB= " . $matched_user_data['id'] . "");
              $result = mysql_fetch_array($query);
              $newMatchId = $result['id'];
              //echo "Match ID: " . $newMatchId . "<br>";

              // Add the Matched ID to the Users
              $query = "UPDATE Users SET Matches_id = " . $newMatchId . " WHERE id = " . $users_not_matched[$x]['id'] . " OR id = " . $matched_user_data['id'] . "";
              $result = mysql_query($query);
          
              $matches ++;

              // Send names and emails to mail script to mail users that they have been matched.
              if (!$send_match_mail) {
                //mail_matched_users($users_not_matched[$x]['name'], $users_not_matched[$x]['email'], $matched_user_data['name'], $matched_user_data['email']);
              }


          } // End If Statement (If match)

        } // End For Loop
    } // End Main If Statement (If there is even a reason to run through all this code)




?>

  <div class="<?php echo $rowClass; ?>">
    <br>

    <?php if ($matches > 0) { ?>
    <p class="lead">There were <?php echo "$matches"; ?> matches made!</p>
    <?php } ?>

    <br>
    <?php

    $query = "select * from Matches ORDER BY id DESC LIMIT 10";
    $result = mysql_query($query) OR die(mysql_error());
    //$row = mysql_fetch_array($result);

    $last_matches = array();
    $index = 0;

    ?>

    <ul class="list-group">
          <h2 class="list-group-item-heading" style="padding-bottom: 10px;">Last 10 Matches</h2>
    <?php

    if (!$result) { ?>
    <p class="lead">No recent matches found.</p>

    <?php
    else
      while ($row = mysql_fetch_array($result))
      {
        $last_matches[$index] = $row; // Save the users into the array.
        $last_matches[$index]['major_name'] = mysql_get_var("SELECT major_long from Majors WHERE id = " . $last_matches[$index]['major']);
        // $last_matches[$index]['userA'] = mysql_get_var("SELECT userA FROM Matches WHERE id = " . $last_matches[$index]['id']);
        // $last_matches[$index]['userB'] = mysql_get_var("SELECT userB FROM Matches WHERE id = " . $last_matches[$index]['id']);
        ?>
        <li class="list-group-item lastMatch" data-toggle="tooltip" data-trigger="hover" data-placement="right" title="<?php echo $last_matches[$index]['date_matched']; ?>"><?php echo $last_matches[$index]['major_name']; ?></li>
        <?php
        // Show the IDs of the matched users.

        if ($debug) {
          echo '<li class="list-group-item"> ' . $last_matches[$index]['id'] .' ' . $last_matches[$index]['userA'] . ' ' . $last_matches[$index]['userB'] . '</li>';
        }
        $index++; // KIND OF NEED THIS...
      }


    ?>
    
  </div>

</div>

<br />
<?php

mysql_close($con);

require_once(TEMPLATES_PATH . "/footer.php");
// Add to Matches table, set matched val to 1, connect with each other.
// Matches table: id, personA id, personB id, isFinished val, date.

// After a match is made it will show up on users profile and they will get an email.

?>

<script>
  $('.lastMatch').tooltip();
</script>