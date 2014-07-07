<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");
include(FUNCTION_PATH . "/connect.php");

if ($_SESSION['login'] == "") {
	header("Location: /error.php"); // Temporary I guess maybe add like ?error=1
}

else if ($_SESSION['login'] == "1") {
}

$rowClass = "col-md-6 col-md-offset-3 text-center";
$userFieldClass = "col-sm-2 col-sm-offset-4 text-center";

$majorBeginClass = "";
$majorBeginEditClass = "";

?>

<!-- <hr> -->

<div class="container-fluid">

  <div class="row">
  	<div class="<?php echo $rowClass; ?>">
  		<div class="panel-heading">
  			<h2>Hello, <?php echo "{$_SESSION['user_name']}" ?>!</h2>
  		</div>
  	</div>
  </div>
  
  <div class="row">
    <div class="col-sm-2 col-sm-offset-5">
      <button id="editMainBtn" class="btn btn-warning btn-sm" onclick="editProfile()">Edit</button>
      <button id="saveMainBtn" class="btn btn-success btn-sm" onclick="submitChanges()">Save</button>
      <button id=cancelMainBtn class="btn btn-info btn-sm" onclick="cancelChanges()">Cancel</button>
    </div>
  </div>

  <br>
  
  <div class="row">
  	<div class="<?php echo $rowClass; ?>">
  		<span class="error"><div id="droppedMatches"></div></span>
  	</div>
  </div>

	<!-- Alight text left and edit buttons right eventually. -->
	
	<!-- Add MAIN EDIT btn which shows the indivd edit buttons and realigns elements so centered.
	      Different centering for diff modes due to btns
	      Get rid of indivd save/cancel buttons? Would make things easier...?
	      
	      * Ie. if user changes two fields, maybe just have one main save/cancel button, indivd edit btns.
	      
	      * Js to go to location to stop jumping, may not be necessary with master edit btn
	      
	      Left/right align
	 
	 -->
	      
	<!-- Should I add confirmations? "Sure you want to change/drop match, sure you want to change. Nice popup. Learn jquery -->

	<!-- MAJOR FIELD -->
	<div class="row">
	
	    <!-- Major Begin Text -->
  	<div id="majorBeginText" class="col-sm-2 col-sm-offset-3" style="padding-right: 0px; text-align: right;">
  		<h4>Your major is</h4>
  	</div>
  	
  	  <!-- Major Name -->
  	<div id="majorNameText" class="col-sm-2" style="text-align: left; padding-left: 5px;">
  	  <h4>
  	   	<div style="display: inline-block;"><?php echo "{$_SESSION['user_major_name']}."; ?></div>
  		</h4>
  	</div>

	    <!-- Major Field Editable -->
    <form id="majorForm" name="majorForm" method="post" action="update.php" onsubmit="return saveMajor();">
      <!-- Dropdown of majors -->
    	<div id="majorSpan" style="display: none; padding-left: 5px;" class="col-sm-3">
				<input type="hidden" name="newMajorId" id="newMajorId" value="">
				<select id="selectMajor" class="form-control selectpicker" name="major" data-live-search="true" data-size="5">
					<?php print_majors(); ?>
				</select>
      </div>
      
        <!-- Major Btns
      <div id="majorBtns" class="col-sm-2" style="text-align: left">
      	<a id="majorEditBtn" href="#" class="btn btn-sm btn-warning" onclick="editMajor()">Edit</a>
  			<button type="submit" name="majorSaveBtn" value="Submit" id="majorSaveBtn" class="btn btn-sm btn-success" style="display: none;">Save</button>
  			<a id="majorCancelBtn" href="#" class="btn btn-sm btn-info" onclick="cancelEdit('major')" style="display: none;">Cancel</a>
    	</div>
    	-->
    	
  	</form>
  	
	</div>

	<!-- CYCLE FIELD -->
	<div class="row">
	
	  <div id="cycleBeginText" class="col-sm-2 col-sm-offset-3" style="padding-right: 0px; text-align: right;">
  		<h4>Your cycle is</h4>
  	</div>
  	
  	<div id="cycleNameText" class="col-sm-2" style="text-align: left; padding-left: 5px;">
  	  <h4>
  	   	<div style="display: inline-block;"><?php echo "{$_SESSION['user_cycle_name']}."; ?></div>
  		</h4>
  	</div>
  	
    <form id="cycleForm" name="cycleForm" method="post" action="update.php" onsubmit="return saveCycle();">
    	<div id="cycleSpan" style="display: none; padding-left: 5px;" class="col-sm-2">
				<input type="hidden" name="newCycleId" id="newCycleId" value="">
				<select id="selectCycle" class="form-control selectpicker" name="cycle" data-live-search="true" data-size="5">
					<?php if ($_SESSION['user_cycle'] == 1) { ?>
						<option selected="selected" value="1">Fall-Winter</option>
						<option value="2">Spring-Summer</option>
					<?php } else { ?>
						<option value="1">Fall-Winter</option>
						<option selected="selected" value="2">Spring-Summer</option>
					<?php } ?>
				</select>
      </div>
      
      <!--
      <div id="cycleBtns" class="col-sm-2" style="text-align: left">
      	<a id="cycleEditBtn" href="#" class="btn btn-sm btn-warning" onclick="editCycle()">Edit</a>
  			<button type="submit" name="cycleSaveBtn" value="Submit" id="cycleSaveBtn" class="btn btn-sm btn-success" style="display: none;">Save</button>
  			<a id="cycleCancelBtn" href="#" class="btn btn-sm btn-info" onclick="cancelEdit('cycle')" style="display: none;">Cancel</a>
    	</div>
    	-->
    	
  	</form>
  	
	</div>

	<!-- User Program Field -->
	<div class="row">
	
	 <div id="programBeginText" class="col-sm-2 col-sm-offset-3" style="padding-right: 0px; text-align: right;">
  		<h4>You will have</h4>
  	</div>
  	
  	<div id="programNameText" class="col-sm-2" style="text-align: left; padding-left: 5px;">
  	  <h4>
  	   	<div style="display: inline-block;"><?php echo "{$_SESSION['user_program_name']}"; ?></div>
  		</h4>
  	</div>
  	
    <form id="programForm" name="programForm" method="post" action="update.php" onsubmit="return saveProgram();">
    	<div id="programSpan" style="display: none; padding-left: 5px;" class="col-sm-2">
				<input type="hidden" name="newProgramId" id="newProgramId" value="">
				<select id="selectProgram" class="form-control selectpicker" name="program" data-live-search="true" data-size="5">
					<?php if ($_SESSION['user_program'] == 1) { ?>
						<option selected="selected" value="1">1 co-op</option>
						<option value="2">3 co-ops</option>
					<?php } else { ?>
						<option value="1">1 co-op</option>
						<option selected="selected" value="2">3 co-ops</option>
					<?php } ?>
				</select>
      </div>
      
      <!--
      <div id="programBtns" class="col-sm-2" style="text-align: left">
      	<a id="programEditBtn" href="#" class="btn btn-sm btn-warning" onclick="editProgram()">Edit</a>
  			<button type="submit" name="programSaveBtn" value="Submit" id="programSaveBtn" class="btn btn-sm btn-success" style="display: none;">Save</button>
  			<a id="programCancelBtn" href="#" class="btn btn-sm btn-info" onclick="cancelEdit('program')" style="display: none;">Cancel</a>
    	</div>
    	-->
    	
  	</form>

  </div>
  
	<?php
		// Get the latest user_matched status
		$_SESSION['user_matched'] = mysql_get_var("SELECT matched FROM Users WHERE id = " . $_SESSION['user_id']);

		// If the user has a match, get the match's info and display it.
		if ($_SESSION['user_matched'] == 1) {
			$other_user_data = get_match_info();
		?>
      
      <div class="row">
  			<div class="row-fluid col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-6 col-lg-offset-3 text-center">
  				<br><hr><p class="lead">Hey, you have a match!</p>
  			</div>
      </div>
      
      <div class="row">
  			<div class="row-fluid col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-6 col-lg-offset-3 text-center well">
  				<p>You have matched with <strong> <?php echo $other_user_data[0]['name']; ?></strong>.</p>
  				<p>You can email them at <strong> <?php echo $other_user_data[0]['email']; ?></strong></p>
  			</div>
			</div>
	
	<?php } else { // If the user does not have a match tell them they still do not. ?>
			
			<div class="row">
  			<div class="row-fluid col-md-6 col-md-offset-3 text-center">
  				<br><p class="lead">You do not have a match yet, but we will keep looking!</p>
  			</div>
			</div>
			
	<?php } ?>

</div>

<?php
mysql_close($con);
require_once(TEMPLATES_PATH . "/footer.php");
?>

<script type="text/javascript">
	
	// Get some vars from PHP
	window.hasDroppedMatch = "<?php echo $_SESSION['user_dropped_matches']; ?>";
	if (hasDroppedMatch == "") {
		window.hasDroppedMatch = 0;
	}

	window.isMatched = "<?php echo $_SESSION['user_matched']; ?>";

	window.droppedMatches = $("droppedMatches");
	window.droppedMatches.style.display = 'none';

  // Main Profile Buttons
  
  window.editMainBtn = $("editMainBtn");
  window.saveMainBtn = $("saveMainBtn");
  window.cancelMainBtn = $("cancelMainBtn");
  
  window.saveMainBtn.style.display = 'none';
  window.cancelMainBtn.style.display = 'none';

	// Major Window Vars
	
	window.majorSaveBtn = $("majorSaveBtn");
	window.majorEditBtn = $("majorEditBtn");
	window.majorCancelBtn = $("majorCancelBtn");
	window.majorSpan = $("majorSpan");
	window.majorDiv = $("majorNameText");
	window.selectMajor = $("selectMajor");
	window.majorBeginText = $("majorBeginText");

	// Cycle Window Vars
	window.cycleSaveBtn = $("cycleSaveBtn");
	window.cycleEditBtn = $("cycleEditBtn");
	window.cycleCancelBtn = $("cycleCancelBtn");
	window.cycleSpan = $("cycleSpan");
	window.cycleDiv = $("cycleNameText");
	window.selectCycle = $("selectCycle");

	// Program Window Vars
	window.programSaveBtn = $("programSaveBtn");
	window.programEditBtn = $("programEditBtn");
	window.programCancelBtn = $("programCancelBtn");
	window.programSpan = $("programSpan");
	window.programDiv = $("programNameText");
	window.selectProgram = $("selectProgram");

	window.errorClassVals = "alert alert-warning";

  var editProfile = function () {
    
    window.saveMainBtn.style.display = '';
    window.cancelMainBtn.style.display = '';
    
    editMajor();
    editCycle();
    editProgram();
    
  }
  
  var cancelChanges = function () {
    
    window.saveMainBtn.style.display = 'none';
    window.cancelMainBtn.style.display = 'none';
    
    cancelEdit();
    
  }

	var editMajor = function () {
		
		if (check_if_dropped()) {
			window.majorDiv.style.display = 'none';
			//window.majorDiv.innerHTML = "";
			window.majorSpan.style.display = '';

		// 	window.majorEditBtn.style.display = 'none';
		// 	window.majorSaveBtn.style.display = '';
		// 	window.majorCancelBtn.style.display = '';
			
			window.majorBeginText.className = 'col-sm-2 col-sm-offset-3';
			
		}

	}

	var saveMajor = function () {

		var i = window.selectMajor.selectedIndex;
		var newId = window.selectMajor[i].value;

		document.majorForm.newMajorId.value = newId;

		return true;
	}

	var editCycle = function () {
		
		if (check_if_dropped()) {
			window.cycleDiv.style.display = 'none';
			window.cycleSpan.style.display = '';

		// 	window.cycleEditBtn.style.display = 'none';
		// 	window.cycleSaveBtn.style.display = '';
		// 	window.cycleCancelBtn.style.display = '';
		}
		
	}

	var saveCycle = function () {

		var i = window.selectCycle.selectedIndex;
		var newId = window.selectCycle[i].value;

		document.cycleForm.newCycleId.value = newId;
		
		return true;
	}


	var editProgram = function () {
		
		if (check_if_dropped()) {
			window.programDiv.style.display = 'none';
			window.programSpan.style.display = '';

		// 	window.programEditBtn.style.display = 'none';
		// 	window.programSaveBtn.style.display = '';
		// 	window.programCancelBtn.style.display = '';
		}

	}

	var saveProgram = function () {

		var i = window.selectProgram.selectedIndex;
		var newId = window.selectProgram[i].value;

		document.programForm.newProgramId.value = newId;
		
		return true;
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
			window.droppedMatches.textContent = "By editing your profile, your current match will be dropped. The more matches you drop, the lower you go in the queue.";
			window.droppedMatches.className = 'alert alert-info';
			window.droppedMatches.style.display = '';
			return true;
		}
		else {

		}

	}

	var cancelEdit = function () {

		//if (field == "major") {
		//window.majorSaveBtn.style.display = 'none';
			window.majorSpan.style.display = 'none';
			window.majorDiv.style.display = 'inline-block';
		// 	window.majorCancelBtn.style.display = 'none';
		// 	window.majorEditBtn.style.display = '';
		//}
		//else if (field == "cycle") {
	  //window.cycleSaveBtn.style.display = 'none';
			window.cycleSpan.style.display = 'none';
			window.cycleDiv.style.display = 'inline-block';
		// 	window.cycleCancelBtn.style.display = 'none';
		// 	window.cycleEditBtn.style.display = '';
		//}
		//else if (field == "program") {
		//window.programSaveBtn.style.display = 'none';
			window.programSpan.style.display = 'none';
			window.programDiv.style.display = 'inline-block';
		// 	window.programCancelBtn.style.display = 'none';
		// 	window.programEditBtn.style.display = '';
		//}

		window.droppedMatches.style.display = 'none';
	}

</script>


<!-- To Do For User Page 1

- Ability to change information (cycle, major, 4/5 year)
- Other misc. I guess