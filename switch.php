<?php
require_once(__DIR__ . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");

/* Have a cron job run this page every minute so checks are always done. FOR PRODUCTION SERVER. */

include(FUNCTION_PATH . "/connect.php");

$canDrop = False;

?>

              
<!-- User Switch Code -->
<?php if (isset($_SESSION['login'])) { ?>

<div class="container">
  <div class="row">
    <div id="switchStatus" class="rowClass">

      <?php

        // Get the latest user_matched status
        // $sql = 'SELECT matched FROM Users WHERE id = ' . $_SESSION['user_id'];
        // $_SESSION['user_matched'] = getVar($con, $sql);

        // If the user has a match, get the match's info and display it.
        if ($_SESSION['user_matched'] == 1) {
          
          $other_user_data = get_match_info();

          // Code to calc difference incase user wants to drop the switch and re-enter queue

          $sql = 'SELECT isFinished FROM Matches WHERE id = ' . $other_user_data['Matches_id'];
          $matchStatus = getVar($con, $sql);

          // $canDrop = False;

          // Update this to use UNIX time instead - more reliable // (Currenty not working with proper message)
          if ($matchStatus == 0) {

            list($firstName) = explode(' ', trim($other_user_data['name']));

            $daysBeforeDrop = 2;

            $sql = 'SELECT timeSwitchCreated FROM Matches WHERE id = ' . $other_user_data['Matches_id'];
            $switchedDate = getVar($con, $sql);
            $switchedDate = date("F j, Y, g:i a");

            // $today = new DateTime();

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

          else if ($matchStatus == 2) { $status = "SCDC Contacted"; }

          else if ($matchStatus == 3) { $status = "Switch failed. Reason: <?php echo $failReason ?>"; }

          else if ($matchStatus == 4) { $status = "Switch complete!"; }

          else { $status = "Searching"; }

      ?>

      <?php

          if (isset($_SESSION['login']) && isset($_GET['drop']) && $_GET['drop'] == 1) {
            if ($canDrop) {

              // Include for the check_for_match function, move to functions.php eventually
              include_once("update.php");

              $user_data = getUserDataFromId($_SESSION['user_id']);

              // Function is just named this, we know they are matched. Get a better function name.
              check_for_match($user_data, "2");

            }
            else {
              echo '<div class="alert alert-danger"><strong>Cannot drop switch.</strong> Please wait '.$timeLeft.' day(s) before trying again.</div>';
            }

        }
    
    ?>

      <div id="switchStatusError" class="alert alert-info alert-dismissable fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert">
          <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </button>
        <div id="dropFalse" class="hide"> 
          <p><strong>You cannot drop this switch yet.</strong><br /> <hr /> 
          You may drop this switch in <strong><?php echo $timeLeft; ?> day(s)</strong> and enter back into the queue. <br /><br />
          Email <strong><?php echo $firstName; ?></strong> to finish your switch!</p>
        </div>
        <div id="dropTrue" class="hide">
          <p><strong>Are you sure you want to drop this switch?</strong><br />You will be entered back into the queue.</p>
          <a href="/switch?drop=1"><button class="btn btn-warning dropTrueBtn">Yes</button></a>
          <a href="#"><button id="dropNo" class="btn btn-success dropTrueBtn">No</button></a>
          <!-- YES | NO buttons. -->
        </div>
      </div>

      <h2><strong>Coopswitch Status</strong></h2>

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

      <!-- Hide this if SCDC adds to switch queue? -->
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <hr class="style-three" />
            <button id="unresponsive" class="btn btn-info" onclick="checkCanDrop()">Is <?php echo $firstName; ?> unresponsive?</button>
            <div id="unresponsive-msg"></div>
        </div>
      </div>

  <?php } else { // If the user does not have a match tell them they still do not. ?>

          <div class="row">
            <div id="matchStatusFalse" style="padding: 5px;">
              <?php print ($_SESSION['withdraw'] == 1 ? '<p class="lead">Your account is withdrawn.</p>' : '<p class="lead">You do not have a switch yet, but we will keep looking!</p>'); ?>
            </div>
          </div>

  <?php } ?>
    </div>
  </div>
</div>
<?php } ?>
<!-- END OF USER LOGGED IN CODE -->

<div class="container">

<!-- SWITCH MESSAGE TO BE DISPLAYED AT TOP. -->
<!-- TODO: REPLACE ECHO ROW CLASS WITH JQUERY. -->
  <div class="row">
    <div class="rowClass">
      <div id="numSwitchMessage">
        <p class="lead">
          <div id="noSwitchNeeded">No switches need to be made.</div>
          <div id="oneSwitchNeeded">There is <span class="text-info">one</span> person that needs to switch.</div>
          <div id="multipleSwitchesNeeded">There are <span id="notSwitchedNumber" class="text-info"></span> people who need to be switched, or <span id="notSwitchedPercent" class="text-info">%</span> of verified users.</div>
        </p>
      </div>
    </div>
  </div>

<!-- MANUAL SWITCH CHECK MODULE POPUP -->
<!-- TODO: REMOVE PHP, SET VALUES VIA JQUERY, LOADING ANIMATION SO FLASH THING DOES NOT HAPPEN -->
<div class="modal fade" id="checkSwitchesModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h2 class="modal-title">Manual Switch Check</h2>
        </div>
        <div class="modal-body">

          <p class="lead">
            <span id="switchesTrue">There were <span id="numSwitches" class="text-info"></span> switches.</span>
            <span id="switchesFalse">No switches were made.</span>
          </p>

          <p class="lead">
            <span id="lastSwitch">The last switch was: <span id="lastSwitchDate" class="text-info"></span></span>
          </p>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
 

<!-- LAST 10 SWITCHES VIEW -->
<!-- TODO: REMOVE PHP, DISPLAY VIA JQUERY, ADD A REFRESH AJAX ELEMENT -->
  <!-- Show last 10 switches completed. -->
  <div class="row" style="margin-top: 35px;">
    <div class="rowClass">
      <h2 class="list-group-item-heading" style="padding-bottom: 10px;">Last <span class="text-info">10</span> Switches
      <!-- <span><button id="refreshLastSwitchesBtn" class="btn btn-info btn-xs">Refresh</button> -->
      </h2>
      <ul id="lastSwitches" class="list-group">

      </ul>
    </div>
  </div>

  <!-- TODO: REPLACE THIS WITH JQUERY I GUESS. -->
  <?php // echo ($max == 0) ? '<div style="padding-bottom: 10em;"></div>' : ''; ?>

  <div class="row">
    <div class="rowClass">
      <button id="manualCheckBtn" class="btn">Manual Switch Check</button>
    </div>
  </div>

</div>

<br />

<?php require_once(TEMPLATES_PATH . "/footer.php"); ?>

<script type="text/javascript">
  
  $(document).ready(function() {

    hideInit();
    clearMessages();
    showSwitchNeededMessage();
    showLastSwitches();

    $('.rowClass').addClass("col-sm-6 col-sm-offset-3 text-center");

  });

  function hideInit() {

    $('#noSwitchNeeded').toggle();
    $('#oneSwitchNeeded').toggle();
    $('#multipleSwitchesNeeded').toggle();
  }

  function clearMessages() {
    
    $('#switchesTrue').hide();
    $('#switchesFalse').hide();    
  }

  $('#manualCheckBtn .close').click(function() {
    // TODO: MAKE WORK
    console.log("TEST");
  });

  $('#manualCheckBtn').click(function() {

    $.ajax({
      type: "GET", 
      url: "runswitch.php", 
      data: "s=switchcheck", 
      success: function(data) {
        switches = data;
        if (switches > 0) {
          $('#switchesTrue').show();
          $('#numSwitches').html(switches);
        }
        else if (switches == 0) {
          $('#switchesFalse').show();
        }
        $('#checkSwitchesModal').modal('show');
      }
    });

  });


  function showSwitchNeededMessage() {

    $.ajax({
      type: "GET", 
      url: "runswitch.php", 
      data: "n=data", 
      dataType: 'json', 
      success: function(data) {
        if (data['unswitched'] > 0) {
          $('#multipleSwitchesNeeded').toggle();
          $('#notSwitchedNumber').html(data['unswitched']);
          percent = ((data['unswitched']/data['total']) * 100).toFixed(2);
          $('#notSwitchedPercent').html(percent+"%");
        }
        else if (data['unswitched'] == 1) {
          $('#oneSwitchNeeded').toggle();
        }
        else {
          $('#noSwitchNeeded').toggle();
        }
      }
    });

  }

  function showLastSwitches() {

    getLastSwitch = false;

    $.ajax({

      type: "GET", 
      url: "runswitch.php", 
      data: "n=last", 
      dataType: "json", 
      success: function(data) {

        if (data.length == 0) {
          $('#lastSwitches').append('<p class="lead">No recent switches found.</p>');
        }
        $.each(data, function(index, thisSwitch) {
          if (!getLastSwitch) {
            $('#lastSwitchDate').html(thisSwitch.timeInit);
            getLastSwitch = true;
          }
          statement = '<li class="list-group-item lastSwitch" data-toggle="tooltip" data-trigger="hover" data-placement="right" title="' + thisSwitch.timeInit + '">' + thisSwitch.major + '</li>';
          $('#lastSwitches').append(statement);
          // TODO: Show date under major or to side, in a lighter (gray) color.
        });

      }

    });

    $('#refreshLastSwitchesBtn').click(function(e) {
      // TODO: Make sure repeatedly clicking this will not overload database (cache that updates!).
      // TODO: Make this actually work (is appending for some reason).
      console.log("Refresh last switches.");
      $('.lastSwitch').remove();
      showLastSwitches();
      //e.preventDefault();

    });


  }

</script>




<script>

  $('.lastSwitch').tooltip();

  // $("#switchStatusError").alert();

  // $('#switchStatusError .close').click(function(e) {
  //   $('#switchStatusError').fadeTo('fast', 2);
  //   console.log("Fade out.");
  // });

  $('#dropNo').click(function() {
    $('#switchStatusError').slideUp(500, function() {
      $('#switchStatusError').remove();

    });
  }); 

  $('.close').click(function() {
    //$('#switchStatusError').slideUp(500, function() {
      //$('#switchStatusError').remove();

    //});
  }); 


  var checkCanDrop = function () {

    var canDrop = <?php echo ($canDrop) ? "true" : "false"; ?>;

    $('#switchStatusError').fadeTo('fast', 2);

    if (!canDrop) {
      id("dropTrue").className = 'show';
    }
    else {
      id("dropFalse").className = 'show';
    }

  }

</script>