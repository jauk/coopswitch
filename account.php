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
 <form id="profileForm" name="profileForm" method="post" action="update.php" onsubmit="return saveChanges()">


  	<!-- <div id="profileFields" name="profileFields" class="container col-md-6 col-md-offset-3 col-sm-9 col-sm-offset-1 col-xs-6 col-xs-offset-3" style="border: 0px solid black; padding: 5px;"> -->

  		<div class="row text-center" id="profileFieldsRow" style="">

  			<!-- Major -->
  			<div class="col-md-4 profileBox" >

  				<div class="circle">
	  				<h3 class="profileBoxHeading">Major</h3>
		      	<div class="profileBoxText" id="majorNameText"><span class="majorName"></span></div>
	        	
	        	<!-- For editing the major. -->
	        	<div id="majorSpan" class="profileBoxEditOff">
							<input type="hidden" name="newMajorId" id="newMajorId" value="">
							<select id="selectMajor" class="form-control selectpicker" name="major" data-live-search="true" data-size="5" data-width="auto">
								<?php print_majors(); ?>
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
						<input type="hidden" name="newCycleId" id="newCycleId" value="">
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
							<input type="hidden" name="newProgramId" id="newProgramId" value="">
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
					<button type="button" id="editMainBtn" class="btn btn-warning btn-sm profileButton" onclick="editProfile()">Edit</button>
					<button id="saveMainBtn" class="btn btn-success btn-sm profileButtonEditMode" onclick="saveChanges()">Save</button>
					<button type="button" id="cancelMainBtn" class="btn btn-info btn-sm profileButtonEditMode" onclick="cancelChanges()">Cancel</button>
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


	});

	function getUser() {

			var user = new Object();

			$.ajax({

				dataType: "json",
				type: "POST",
				url: "/resources/user.php",
				data: "user",
				success: function(data){

						user = data;
						setUserVars(user);

						// console.log("User: " + user.toSource());
						// console.log(user.name+ " Hi");


				}

			});	
	}

	function setUserVars(user) {

		// console.log(user.toSource());

		$('.name').html(user.name);
		$('.majorName').html(user.majorName);
		$('.cycleName').html(user.cycleName);
		$('.programName').html(user.programName);

		checkWithdraw(user.withdraw); // Move on to see withdraw status
	}

	function checkWithdraw(status) {

		if (status != 1) {

		}

	}

console.log(user.toSource());


withdraw = "<?php echo $_SESSION['withdraw']; ?>";
// console.log(window.user.toSource() + " woo ");
// alert(window.user);

$('.selectpicker').selectpicker();
	
	// $('#userName').tooltip();

	// Get some vars from PHP

	if (withdraw != 1) {

		window.hasDroppedMatch = "<?php echo $_SESSION['user_dropped_matches']; ?>";
		if (hasDroppedMatch == "") {
			window.hasDroppedMatch = 0;
		}

		window.isMatched = "<?php echo $_SESSION['user_matched']; ?>";

		window.droppedMatches = id("droppedMatches");
		window.droppedMatches.style.display = 'none';

		// Main Profile Buttons

		window.editMainBtn = id("editMainBtn");
		window.saveMainBtn = id("saveMainBtn");
		window.cancelMainBtn = id("cancelMainBtn");

		window.saveMainBtn.style.display = 'none';
		window.cancelMainBtn.style.display = 'none';

		// Major Window Vars

		window.majorSaveBtn = id("majorSaveBtn");
		window.majorEditBtn = id("majorEditBtn");
		window.majorCancelBtn = id("majorCancelBtn");
		window.majorSpan = id("majorSpan");
		window.majorDiv = id("majorNameText");
		window.selectMajor = id("selectMajor");
		window.majorBeginText = id("majorBeginText");

		// Cycle Window Vars
		window.cycleSaveBtn = id("cycleSaveBtn");
		window.cycleEditBtn = id("cycleEditBtn");
		window.cycleCancelBtn = id("cycleCancelBtn");
		window.cycleSpan = id("cycleSpan");
		window.cycleDiv = id("cycleNameText");
		window.selectCycle = id("selectCycle");

		// Program Window Vars
		window.programSaveBtn = id("programSaveBtn");
		window.programEditBtn = id("programEditBtn");
		window.programCancelBtn = id("programCancelBtn");
		window.programSpan = id("programSpan");
		window.programDiv = id("programNameText");
		window.selectProgram = id("selectProgram");

		window.errorClassVals = "alert alert-warning";

	}

  var editProfile = function () {
    
    window.editMainBtn.style.display ='none';

    window.saveMainBtn.style.display = '';
    window.cancelMainBtn.style.display = '';
    
    editMajor();
    editCycle();
    editProgram();
    
    return false;
    
  }
  
  var cancelChanges = function () {
    
    window.editMainBtn.style.display = '';
    window.saveMainBtn.style.display = 'none';
    window.cancelMainBtn.style.display = 'none';
    
    cancelEdit();
    
  }
  
  var saveChanges = function () {
    
    
    saveMajor();
    saveCycle();
    saveProgram();
    
    //alert("Test");
    
  }

	var editMajor = function () {
		
		if (check_if_dropped()) {
			window.majorDiv.className = 'profileBoxEditOff'
			//window.majorDiv.innerHTML = "";
			window.majorSpan.className = 'profileBoxEditOn';

		// 	window.majorEditBtn.style.display = 'none';
		// 	window.majorSaveBtn.style.display = '';
		// 	window.majorCancelBtn.style.display = '';
			
		//	window.majorBeginText.className = 'col-sm-2 col-sm-offset-3';
			
		}

	}

	var saveMajor = function () {

		var i = window.selectMajor.selectedIndex;
		var newId = window.selectMajor[i].value;

		//document.majorForm.newCycleId.value = newId;
		//document.profileForm.newMajorId.value = newId;
		id("newMajorId").value = newId;

		//return true;
	}

	var editCycle = function () {
		
		if (check_if_dropped()) {
			window.cycleDiv.className = 'profileBoxEditOff';
			window.cycleSpan.className = 'profileBoxEditOn';

		// 	window.cycleEditBtn.style.display = 'none';
		// 	window.cycleSaveBtn.style.display = '';
		// 	window.cycleCancelBtn.style.display = '';
		}
		
	}

	var saveCycle = function () {

		var i = window.selectCycle.selectedIndex;
		var newId = window.selectCycle[i].value;

		//document.cycleForm.newCycleId.value = newId;
		//document.profileForm.newCycleId.value = newId;
    	id("newCycleId").value = newId;
    
		//return true;
	}


	var editProgram = function () {
		
		if (check_if_dropped()) {
			window.programDiv.className = 'profileBoxEditOff';
			window.programSpan.className = 'profileBoxEditOn';

		// 	window.programEditBtn.style.display = 'none';
		// 	window.programSaveBtn.style.display = '';
		// 	window.programCancelBtn.style.display = '';
		}

	}

	var saveProgram = function () {

		var i = window.selectProgram.selectedIndex;
		var newId = window.selectProgram[i].value;

		//document.programForm.newProgramId.value = newId;
		//document.profileForm.newProgramId.value = newId;
		id("newProgramId").value = newId;

		//return true;
	}

	var check_if_dropped = function () {

		if (window.isMatched == 0) {
			//window.droppedMatches.textContent = "";
			window.droppedMatches.style.display = 'none';
			return true;
		}

		// else if (hasDroppedMatch > 0) {
		// 	setTimeout(1000);
		// 	window.droppedMatches.textContent = "You cannot edit your profile and drop another match.";
		// 	window.droppedMatches.className = window.errorClassVals;
		// 	window.droppedMatches.style.display = '';
		// 	return false;
		// }

		else if (window.isMatched == 1) {
			window.droppedMatches.textContent = "By editing your profile, your current match will be dropped. The more matches you drop, the lower you go in the queue."
			window.droppedMatches.className = 'alert alert-warning lead';
			window.droppedMatches.style.display = '';
			return true;
		}
		else {

		}

	}

	var cancelEdit = function () {

		//if (field == "major") {
		//window.majorSaveBtn.style.display = 'none';
			window.majorSpan.className = 'profileBoxEditOff';
			window.majorDiv.className = 'profileBoxEditOn';
		// 	window.majorCancelBtn.style.display = 'none';
		// 	window.majorEditBtn.style.display = '';
		//}
		//else if (field == "cycle") {
	  //window.cycleSaveBtn.style.display = 'none';
			window.cycleSpan.className = 'profileBoxEditOff';
			window.cycleDiv.className = 'profileBoxEditOn';
		// 	window.cycleCancelBtn.style.display = 'none';
		// 	window.cycleEditBtn.style.display = '';
		//}
		//else if (field == "program") {
		//window.programSaveBtn.style.display = 'none';
			window.programSpan.className = 'profileBoxEditOff';
			window.programDiv.className = 'profileBoxEditOn';
		// 	window.programCancelBtn.style.display = 'none';
		// 	window.programEditBtn.style.display = '';
		//}

		window.droppedMatches.style.display = 'none';
	}

	var withdraw = function () {

		window.location.href = 'withdraw.php?act=withdraw';
	}

	var reactivate = function () {

		window.location.href = 'withdraw.php?act=rejoin';
	}

</script>