<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");
include(FUNCTION_PATH . "/connect.php");

if ($_SESSION['login'] != "1") {
	header("Location: /error.php"); // Temporary I guess maybe add like ?error=1
}


?>


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
  	<div class="rowClass">
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
  	<div class="rowClass">
  		<span><div class="alert alert-warning lead" id="hasDroppedMatch">By editing your profile, your current match will be dropped. The more matches you drop, the lower you go in the queue.</div></span>
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
					<button id="savebutton" type="button" class="btn btn-success btn-sm profileButtonEditMode">Save</button>
					<button id="cancelbutton" type="button" class="btn btn-info btn-sm profileButtonEditMode">Cancel</button>
				</div>
			</div>

 </form>


	<hr>

 <?php } else { // If the user has withdrawed from website. ?>

 		<div class="row">
  		<div class="rowClass">
 				<p class="lead">Your profile has been deactivated.</p>
 			</div>
 		</div>

 <?php } ?>

		<div class="row">
  		<div class="rowClass">
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
				<button id="withdrawBtn" type="button" class="btn btn-danger" data-dismiss="modal">Withdraw</button>				
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
				<button id="reactivateBtn" type="button" class="btn btn-success" data-dismiss="modal">Reactivate</button>				
			</div>
		</div>
	</div>
</div>

<?php
require_once(TEMPLATES_PATH . "/footer.php");
?>


<script type="text/javascript">

	$(document).ready(function() {

		$('.rowClass').addClass("col-sm-6 col-sm-offset-3 text-center");

		$('#savebutton').hide();
		$('#cancelbutton').hide();

		$('#majorSpan').hide();
		$('#cycleSpan').hide();
		$('#programSpan').hide();

		$('#hasDroppedMatch').hide();

		getUser(); 
		getMajors("#selectMajor");
	});

	$('#editbutton').click(function() {

		if (window.isMatched == 1) {
			$('#hasDroppedMatch').toggle();
		}

		buttonToggle();

		toggleTexts();
		toggleEditFields();
	});

	$('#cancelbutton').click(function() {

		if (window.isMatched == 1) {
			$('#hasDroppedMatch').toggle();
		}

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

			profileElements = 'major=' + major + '&cycle=' + cycle + '&num_year_program=' + program;

			// Submit ajax update data 
			$.ajax({
				
				type: "POST",
				url: "update.php",
				data: profileElements,
				success: function(data) {
					buttonToggle();
					toggleTexts();
					toggleEditFields();
					getUser();
					getMajors("#selectMajor");
				}

			});
		});

	}); // End submit function holder 

	$('#withdrawBtn').click(function() {
		window.location.href = 'withdraw.php?act=withdraw';
	});

	$('#reactivateBtn').click(function() {
		window.location.href = 'withdraw.php?act=rejoin';
	});

	function getMajors(selectName) {
		
		var majors = new Array();

		$.ajax({

			dataType: "json",
			url: "/resources/functions/scripts.php",
			data: "g=majors", 
			success: function(data) {

				majors = data;

				//for (var x=0; x<majors.length; x++) {
				$.each(majors, function() {

					var statement = '<option value="' + this.key + '" class="' + this.class + '">'+ this.name + '</select>';

					$(selectName).append(statement);

					if (this.class == "noSwitch") {
						$(selectName+' option:last-child').attr("data-canSwitch", "0");
						$(selectName+' option:last-child').attr("data-subtext", "Not Available");
						$(selectName+' option:last-child').prop('disabled', true);					
					}

					if (this.name == "Business Administration") {
						$(selectName+' option:last-child').attr("data-subtext", "(All Business Majors)");
					}

					if (this.selected == "selected") {
						$(selectName+' option:last-child').prop('selected', true);
					}

				});

				$(selectName).selectpicker('refresh');
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

		window.isMatched = user.isMatched;

		window.hasDroppedMatch = user.droppedMatches;

		checkWithdraw(user); // Move on to see withdraw status
	}

	function checkWithdraw(user) {

		if (user.withdraw == 1) {
			// Do not show all fields and whatnot because withdrawed.
		}
		else {

		}

	}

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

</script>