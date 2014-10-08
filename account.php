<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");
include(FUNCTION_PATH . "/connect.php");

if ($_SESSION['login'] == "") {
	header("Location: /error.php"); // Temporary I guess maybe add like ?error=1
}

else if ($_SESSION['login'] == "1") {
}

$rowClass = "col-sm-6 col-sm-offset-3 text-center";
$userFieldClass = "col-sm-2 col-sm-offset-4 text-center";

$majorBeginClass = "";
$majorBeginEditClass = "";

$beginTextClass = "col-sm-3 col-sm-offset-3 col-xs-12";
$beginTextStyle = "padding-right: 0px; text-align: justify;";

?>
 <!-- On profile have option to decline (drop) match (change mind about switching cycles). Do this later. -->


<!-- Work on edit button location -->

<!-- <hr> -->

<div class="container">

  <!-- Make sure user has validated their email, else display this. -->
  <!-- Cool message saying "Email sent." Limit amount of times it can be sent. -->

<!-- Use ajax to call send page -->

  <?php if ($_SESSION['user_email_verified'] == 0) { ?>

    <div class="row">
			<div class="panel panel-default col-sm-8 col-sm-offset-2">
			  <div class="panel-body text-center">
        	<p class="lead text-danger ">	Your email has not been verified. Not eligible for a switch.</p>
        	<a href="resendverify.php"><button class="btn btn-info btn-sm">Resend Email</button></a>
			  </div>
			</div>
    </div>
    
  <?php } ?>

  <div class="row">
  	<div class="<?php echo $rowClass; ?>">
  		<div class="panel-heading">
  			<h2>Hey, 
  				<div style="display: inline-block;" class="text-primary">
  					<!-- <a href="#" id="userName" role="tooltip" data-toggle="tooltip" data-placement="bottom" title="Email" trigger="hover"> -->
  						<span class="name"></span>
  					<!-- </a> -->
  				</div>
  			</h2>
  		</div>
  	</div>
  </div>
  
  <div class="row">
  	<div class="<?php echo $rowClass; ?>">
  		<span><div id="droppedMatches"></div></span>
  	</div>
  </div>

	<!-- Should I add confirmations? "Sure you want to change/drop match, sure you want to change. Nice popup. Learn jquery -->

  <!-- Profile Fields Containter -->
 <?php if ($_SESSION['withdraw'] == 0) { ?>
 <!-- <form id="profileForm" name="profileForm" method="post" action="update.php" onsubmit="return saveChanges()"> -->
		<form id="profileForm" name="profileForm">

  	<!-- <div id="profileFields" name="profileFields" class="container col-md-6 col-md-offset-3 col-sm-9 col-sm-offset-1 col-xs-6 col-xs-offset-3" style="border: 0px solid black; padding: 5px;"> -->

  		<div class="row text-center" id="profileFieldsRow" style="">

  			<!-- Major -->
  			<div class="col-md-4 profileBox" >

  				<div class="circle">
	  				<h3 class="profileBoxHeading">Major</h3>
		      	<div class="profileBoxText" id="majorNameText"><span class="majorName"></span></div>
	        	<div id="testing">

	        	</div>
	        	<!-- For editing the major. -->
	        	<div id="majorSpan" class="profileBoxEditOff">
							<select id="selectMajor" class="form-control selectpicker" name="major" data-live-search="true" data-size="5" data-width="auto">

							</select>
	         	</div>

	         	<img src="/img/icon-book.png" class="img-responsive center-block profileBoxImg">
         	</div>

  			</div>

  			<!-- Cycle -->
  			<div class="col-md-4 profileBox">

   				<div class="circle" >

	  				<h3 class="profileBoxHeading">Cycle</h3>
		      	<div class="profileBoxText" id="cycleNameText"><span class="cycleName"></span></div>

		      	<!-- For editing the cycle. -->
	        	<div id="cycleSpan" class="profileBoxEditOff">
							<select id="selectCycle" class="form-control selectpicker" name="cycle" data-width="auto">
									<option <?php if ($_SESSION['user_cycle'] == 1) { echo "selected"; } ?> value="1"><?php echo FALLWINTER; ?></option>
									<option <?php if ($_SESSION['user_cycle'] == 2) { echo "selected"; } ?> value="2"><?php echo SPRINGSUMMER; ?></option>
							</select>
	          </div>

	         	<img src="/img/icon-cal.png" id="middleImg" class="img-responsive center-block profileBoxImg">

	         </div>

  			</div>

  			<!-- Program -->
  			<div class="col-md-4 profileBox">

  				<div class="circle">
	  				<h3 class="profileBoxHeading">Program</h3>
		      	<div class="profileBoxText" id="programNameText" ><span class="programName"></span></div>

		      	<!-- For editing the program. -->
	        	<div id="programSpan" class="profileBoxEditOff">
							<select id="selectProgram" class="form-control selectpicker" showSubtext="true" name="program" data-width="auto">
									<option <?php if ($_SESSION['user_program'] == 1) { echo "selected"; } ?> value="1" data-subtext=""><?php echo ONECOOP; ?></option>
									<option <?php if ($_SESSION['user_program'] == 2) { echo "selected"; } ?> value="2" data-subtext=""><?php echo THREECOOPS; ?></option>
							</select>
	        	</div>	     

	        	<img src="/img/icon-case.png" class="img-responsive center-block profileBoxImg">
	        </div>

  			</div>
        

  		</div>
      
			<div class="row">
				<div class="col-md-4 col-md-offset-4 text-center" id="profileButtonContainer">
					<button id="editbutton" type="button" class="btn btn-warning btn-sm profileButton">Edit</button>
					<button id="savebutton" class="btn btn-success btn-sm profileButtonEditMode">Save</button>
					<button id="cancelbutton" type="button" class="btn btn-info btn-sm profileButtonEditMode">Cancel</button>
				</div>
			</div>

 </form>


	<hr>

 <?php } else { // If the user has withdrawed from website. ?>

 		<div class="row">
 			<div class="<?php echo $rowClass; ?>">
 				<p class="lead">Your profile has been deactivated.</p>
 			</div>
 		</div>

 <?php } ?>

		<div class="row">
			<div class="<?php echo $rowClass; ?>">
				<div style="margin-top: 30px;">
				<?php if ($_SESSION['withdraw'] != 1) { ?>
					<button class="btn btn-danger" data-toggle="modal" data-target="#withdraw">Withdraw Account</button>
				<?php } else { ?>
					<button class="btn btn-success" data-toggle="modal" data-target="#activate">Reactivate Account</button>
				<?php } ?>
				</div>
			</div>
		</div>

</div>

<div class="modal fade" id="withdraw" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="goHome()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="modal-title">Withdraw from Coopswitch</h2>
			</div>
			<div class="modal-body">
				<p class="lead">Are you sure you want to withdraw?</p>
				<p>Withdrawing will remove you from the queue and drop any switches.</p> 
				<p>If you choose to reactivate your account, you will be put in the queue with the later date.</p>
				<p><strong>Some reasons to withdraw:</strong></p>
				<ul>
					<li>You are no longer interested in switching your coop cycle.</li>
					<li>You have found a switch outside the system (friend, classmate, etc.)
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="withdraw()">Withdraw</button>				
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="activate" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="goHome()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="modal-title">Reactivate Account</h2>
			</div>
			<div class="modal-body">
				<p class="lead">Are you sure you want to reactivate your account?</p>
				<p>You will be entered back into the switching queue.</p> 
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-success" data-dismiss="modal" onclick="reactivate()">Reactivate</button>				
			</div>
		</div>
	</div>
</div>

<?php
mysql_close($con);
require_once(TEMPLATES_PATH . "/footer.php");
?>


<script type="text/javascript">


	$(document).ready(function() {

		getUser(); 
		$('.noSwitch').prop('disabled', true);

		$('#savebutton').hide();
		$('#cancelbutton').hide();

		$('#majorSpan').hide();
		$('#cycleSpan').hide();
		$('#programSpan').hide();

		$("selectMajor").load("/majors.html");
		//getMajors();

	});

	function getMajors() {
		var majors = new Array();

		$.ajax({

			dataType: "json",
			url: "/resources/functions/scripts.php",
			data: "g=majors", 
			success: function(data) {

				majors = data;
				// console.log(majors[16]);

				var noSwitch = ' class="noSwitch" data-subtext="Not Available"';
				//var end = '">' + majors[x]["name"] + '</select>';

				for (var x=0; x<majors.length; x++) {

					var statement = '<option ' + majors[x]["selected"] + ' value="' + majors[x]["key"] + '" class="' + majors[x]["class"] + '" data-subtext="' + majors[x]["subtext"] + '">'+ majors[x]["name"] + '</select>';

					console.log(statement);
					$("#selectMajor").append(statement);

				}
			}

		});
	}

	function getUser() {

		var user = new Object();

		$.ajax({

			dataType: "json",
			url: "/resources/user.php",
			data: "user",
			success: function(data){

				user = data;
				setUserVars(user);
				checkWithdraw(user.withdraw);
			}

		});	
	}

	function setUserVars(user) {

		$('.name').html(user.name);
		$('.majorName').html(user.majorName);
		$('.cycleName').html(user.cycleName);
		$('.programName').html(user.programName);

		checkWithdraw(user.withdraw); // Move on to see withdraw status
	}

	function checkWithdraw(status) {

		if (status == 1) {
			// Do not show all fields and whatnot
		}
		else {
			// Okay to show profile
		}

	}

	$('#editbutton').click(function() {

		buttonToggle();

		if (check_if_dropped()) {
			toggleTexts();
			toggleEditFields();
		}


	});

	$('#cancelbutton').click(function() {

		buttonToggle();
		toggleTexts();
		toggleEditFields();
	});

	$(function() {
		$('#savebutton').click(function() {
			
			var major = $("#selectMajor").val();
			var cycle = $("#selectCycle").val();
			var program = $("#selectProgram").val();
			//console.log(major+" "+cycle+" "+program)

			profileElements = 'newMajorId=' + major + '&newCycleId=' + cycle + '&newProgramId=' + program;
			//console.log(profileElements);

			// Submit ajax update data 
			$.ajax({
				
				type: "POST",
				url: "update.php",
				data: profileElements,
				success: function() {
					console.log("Updated!");
					buttonToggle();
					toggleTexts();
					toggleEditFields();
					e.preventDefault();
				}

			});

		});
	}); // End submit function holder 


	function buttonToggle() {

		$('#editbutton').toggle();
		$('#savebutton').toggle();
		$('#cancelbutton').toggle();
	}

	function toggleTexts() {

		$('#majorNameText').toggle();
		$('#cycleNameText').toggle();
		$('#programNameText').toggle();
	}

	function toggleEditFields() {

		$('#majorSpan').toggle();
		$('#cycleSpan').toggle();
		$('#programSpan').toggle();
	}

	withdraw = "<?php echo $_SESSION['withdraw']; ?>";

	$('.selectpicker').selectpicker();

	if (withdraw != 1) {

		window.hasDroppedMatch = "<?php echo $_SESSION['user_dropped_matches']; ?>";

		if (hasDroppedMatch == "") {
			window.hasDroppedMatch = 0;
		}

		window.isMatched = "<?php echo $_SESSION['user_matched']; ?>";

		window.droppedMatches = id("droppedMatches");
		window.droppedMatches.style.display = 'none';

		window.errorClassVals = "alert alert-warning";

	}

	var check_if_dropped = function () {

		if (window.isMatched == 0) {
			//window.droppedMatches.textContent = "";
			window.droppedMatches.style.display = 'none';
			return true;
		}

		else if (window.isMatched == 1) {
			window.droppedMatches.textContent = "By editing your profile, your current match will be dropped. The more matches you drop, the lower you go in the queue."
			window.droppedMatches.className = 'alert alert-warning lead';
			window.droppedMatches.style.display = '';
			return true;
		}

	}

	var cancelEdit = function () {

		window.droppedMatches.style.display = 'none';
	}

	var withdraw = function () {

		window.location.href = 'withdraw.php?act=withdraw';
	}

	var reactivate = function () {

		window.location.href = 'withdraw.php?act=rejoin';
	}

</script>