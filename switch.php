<?php
require_once(__DIR__ . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");
//include('mail.php');
/* Have a cron job run this page every minute so checks are always done. FOR PRODUCTION SERVER. */

if (isset($_GET['msg'])) {
  $msg = test_input($_GET['msg']);
}

if (isset($_GET['check'])) {
  $check = test_input($_GET['check']);
}
else {
  $check = 0;
}

$matches = 0;

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

/*
$(function()){
  $('#manualCheck').click(function(){
    $.ajax({

    });
  });
});
*/
</script>

<?php

$rowClass = "col-sm-6 col-sm-offset-3 text-center";

include(FUNCTION_PATH . "/connect.php");

// Filter out not verifieds.

// How many users have a match:
$query = "SELECT * FROM Users WHERE matched = 1";
$usersMatched = mysql_num_rows(mysql_query($query));

// How many users do not have a match: (USED IN ARRAY)
$query="SELECT * FROM Users WHERE matched = 0 AND verified = 1 AND withdraw != 1 ORDER BY dropped_matches ASC, new_date ASC";
$result=mysql_query($query);

if ($result) {
  $num=mysql_num_rows($result); // ...It's this many
  $notMatched = $num; 
}
else {
  $notMatched = 0;
  $num = 0;
  $matches = 0;
}

?>

              
<!-- User Switch Code -->
<?php if (isset($_SESSION['login'])) { ?>

<div class="container">
  <div id="switchStatus" class="col-sm-6 col-sm-offset-3 text-center">
  <h2><strong>Coopswitch Status</strong></h2>

  <?php
    // Get the latest user_matched status
    $_SESSION['user_matched'] = mysql_get_var('SELECT matched FROM Users WHERE id = ' . $_SESSION['user_id']);

    // If the user has a match, get the match's info and display it.
    if ($_SESSION['user_matched'] == 1) {
      
      $other_user_data = get_match_info();

      // Code to calc difference incase user wants to drop the switch and re-enter queue

      $matchStatus = mysql_get_var('SELECT isFinished FROM Matches WHERE id = ' . $other_user_data['Matches_id']);

      // $canDrop = False;

      if ($matchStatus == 0) {

        list($firstName) = explode(' ', trim($other_user_data['name']));

        $daysBeforeDrop = 2;

        $switchedDate = mysql_get_var('SELECT date_matched FROM Matches WHERE id = ' . $other_user_data['Matches_id']);
        $switchedDate = date_create_from_format('Y-m-d H:i:s', $switchedDate);

        $today = new DateTime();

        $difference = $switchedDate->diff($today);

        $days = $difference->format('%d');

        $timeLeft = $daysBeforeDrop - $days;

        if ($days > $daysBeforeDrop) { 
          $canDrop = True;
          // Can drop 
        }
        else {
          $canDrop = False; 
          // Must wait ($daysBeforeDrop - $days) days. (SHOULD I CALC HOURS INSTEAD?)
        }

        $status = "In Progress";
      }

      else if ($matchStatus == 1) {
        $status = "Completed";
      }


  ?>


      <?php 

        // First name of other person

        // echo $days;

        if ($days > $daysBeforeDrop) {
          // echo "Can drop.";
        }
        else {
          // echo "Cannot drop yet. " . ($daysBeforeDrop - $days) . " days left.";
        }

      ?>

      <div class="row">
        <div id="matchStatusTrue">
          <p class="lead">You have a coop switch!</p>
          <hr>
        </div>
      </div>

      <br>

      <!-- Switch persons info for contact -->
      <div class="row">
        <form class="form-horizontal" role="form">
          <div class="form-group">
            <label class="col-sm-2 col-sm-offset-2 control-label">Name</label>
            <div class="col-sm-8">
              <p class="form-control-static lead text-primary"><?php echo $other_user_data['name']; ?></p>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-offset-2 control-label">Email</label>
            <div class="col-sm-8">
              <p class="form-control-static lead text-primary"><?php echo $other_user_data['email']; ?></p>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-offset-2 control-label">Status</label>
            <div class="col-sm-8">
              <p class="form-control-static lead text-primary"><?php echo $status; ?></p>
            </div>
          </div>
        </form>    
      </div>

      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <hr class="style-three" />
            <button id="unresponsive" class="btn btn-info" onclick="checkCanDrop()">Is <?php echo $firstName; ?> unresponsive?</button>
            <div id="unresponsive-msg"></div>
        </div>
      </div>


  <?php } else { // If the user does not have a match tell them they still do not. ?>

          <div class="row">
            <div id="matchStatusFalse">
              <?php print ($_SESSION['withdraw'] == 1 ? '<p class="lead">Your account is withdrawn.</p>' : '<p class="lead">You do not have a switch yet, but we will keep looking!</p>'); ?>
            </div>
          </div>

  <?php } ?>
  </div>
</div>
<?php } ?>

<div class="container">

  <div class="row">
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
          if ($num == 0) echo "No switches need to be made.<br><br>";
          else if ($num == 1) echo 'There is <span class="text-info">one</span> person that needs to switch.';
          else { ?>
              There are <span class="text-info"><?php echo $notMatched ?></span> people who need to be switched, or <span class="text-info"><?php echo $percentNotMatched ?>%</span> of verified users.
        <?php  } ?>
      </p>

      <?php if ($debug_db) { ?>
      <button id="generate_records" type="button" class="btn btn-warning">Generate Records</button>
      <button id="delete_records" type="button" class="btn btn-danger">Delete Records</button>
      <?php } ?>
    </div>
  </div>

<?php
  
  // I need to order both arrays by number of dropped matches? Less = first.

  if ($num > 0 && $check == 1) {// If there are people not matched, run this.
   
      $users_not_matched = array(); // Array of those who are not matched.
      $matches = 0; // Lets see how many matches are made this round. Maybe save value later? Stats, stats, stats.

      $index = 0;
      while ($row = mysql_fetch_array($result)) {
  
        $users_not_matched[$index] = $row; // Save the users into the array.
        $index++; // KIND OF NEED THIS...
      }

      for ($x = 0; $x < $index; $x++) {// Why doesn't count() work for array?

      /* 
      Select people with the same major who are not the person we are searching for.
      Criteria: Not switched, email verified, not withdrawn, same major, not the same ID, opposite cycle.
      Order: First by dropped matches, then by new_date (users who have not redrawn have no new date).
      */

          $query = " SELECT * FROM Users WHERE matched = 0 AND verified = 1 AND withdraw != 1 AND major = " . $users_not_matched[$x]['major'] .
                   " AND id != " . $users_not_matched[$x]['id'] . " AND cycle != " . $users_not_matched[$x]['cycle'] .
                   " AND num_year_program = " . $users_not_matched[$x]['num_year_program'] .
                   " ORDER BY dropped_matches ASC, new_date ASC";

          $result = mysql_query($query);

          if ((mysql_num_rows($result) > 0) && ($users_not_matched[$x]['matched'] != 1)) {// We found people who match the guy inside $users_not_matched. NEED TO UPDATE $users_not_matched after a match is made. Remove from array after matched.
        
              $matched_user_data = array(); // Reset the array.

              $row = mysql_fetch_array($result);
              $matched_user_data = $row; // Save the user's info in an array. 

              /* Put the users into the Matches table and set equaled to matched. */

              $users_not_matched[$x]['matched'] = 1;

              // Find where $matched_user_data is in $users_not_matched and set matched = 1 so that it stops dupes.
              // Learn how to foreach loops and MAKE MORE EFFICIENT.
              for ($i = 0; $i < count($users_not_matched); $i ++) {
                if ($users_not_matched[$i]['id'] == $matched_user_data['id']) {
                    $users_not_matched[$i]['matched'] = 1;
                    break;
                  }
              }

              $userA = $users_not_matched[$x]['id'];
              $userB = $matched_user_data['id'];
              $major = $users_not_matched[$x]['major'];

              switchUsers($userA, $userB, $major);
          
              $matches ++;

              // Send names and emails to mail script to mail users that they have been matched.
              if (!$send_match_mail) {
                //mail_matched_users($users_not_matched[$x]['name'], $users_not_matched[$x]['email'], $matched_user_data['name'], $matched_user_data['email']);
              }

          } // End If Statement (If match)

        } // End For Loop
    } // End Main If Statement (If there is even a reason to run through all this code)

?>

<?php 

  $query = "select * from Matches ORDER BY id DESC LIMIT 10";
  $result = mysql_query($query) OR die(mysql_error());

  $last_matches = array();
  $index = 0;

  while ($row = mysql_fetch_array($result)) {

      $last_matches[$index] = $row; // Save the users into the array.
      $last_matches[$index]['major_name'] = mysql_get_var("SELECT major_long from Majors WHERE id = " . $last_matches[$index]['major']);

      if ($index == 0) {
        $lastMatch = $last_matches[$index]['date_matched'];
      }
      
      $index++;
  }

?>

<?php if ($check == 1) { ?>

  <div class="modal fade" id="checkmatches" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h2 class="modal-title">Manual Switch Check</h2>
          </div>
          <div class="modal-body">

              <?php 

                if ($matches > 0) {
                  echo '<p class="lead">There were ' . $matches . ' switches made!</p>';
                } 
                else {
                  echo '<p class="lead">No switches were made.</p>';
                  if (isset($lastMatch)) { 
                    echo '<p class="lead">The last switch was on <span class="text-info">' . $lastMatch . '</span>.</p>'; 
                  }
                } 

              ?>

          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
  </div>
 
<?php } ?>

  <!-- Show last 10 switches completed. -->
  <div class="row" style="margin-top: 35px;">
    <div class="<?php echo $rowClass; ?>">

      <ul class="list-group">
            <h2 class="list-group-item-heading" style="padding-bottom: 10px;">Last 10 Switches</h2>

              <?php

                $max = sizeof($last_matches);
                if ( $max == 0) { 
                echo '<p class="lead">No recent switches found.</p>';
                }
                else {

                  for ($x = 0; $x < $max; $x++) {
                    echo '<li class="list-group-item lastMatch" data-toggle="tooltip" data-trigger="hover" data-placement="right" title="' . $last_matches[$x]['date_matched'] . '">' . $last_matches[$x]['major_name'] . '</li>';
                    if ($debug) {
                      echo '<li class="list-group-item"> ' . $last_matches[$x]['id'] .' ' . $last_matches[$x]['userA'] . ' ' . $last_matches[$x]['userB'] . '</li>'; 
                    }
                  }

                }

              ?>
      
      </ul>
    </div>
  </div>

  <div class="row">
    <div class="<?php echo $rowClass; ?>">
      <a href="?check=1"><button class="btn">Manual Switch Check</button></a>
    </div>
  </div>

</div>

<br />

<?php
  mysql_close($con);
  require_once(TEMPLATES_PATH . "/footer.php");
?>

<script>

  manualCheck = "<?php echo $check; ?>";

  if (manualCheck == 1) {
      $('#checkmatches').modal('show');
  }

  $('.lastMatch').tooltip();

  var checkCanDrop = function () {

    var canDrop = <?php echo ($canDrop) ? "true" : "false"; ?>;

    id("unresponsive").className = "hide";
    id("unresponsive-msg").innerHTML = "Please wait at least <?php echo $timeLeft; ?> days before finding another switch.";

  }

</script>