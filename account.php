<?php 
include('header.php'); 
include_once('connect.php');

if ($_SESSION['login'] == "") {
	header("Location: error.php"); // Temporary I guess maybe add like ?error=1
}

else if ($_SESSION['login'] == "1") {
}

?>

<!-- <hr> -->

<div class="container-fluid">

	<div class="row-fluid col-md-6 col-md-offset-3 text-center">
		<div class="panel-heading">
			<h2>Hello, <?php echo "{$_SESSION['user_name']}" ?>!</h2>
		</div>
	</div>

	<div class="row-fluid col-sm-6 col-sm-offset-3 text-center">
		<span class="error"><div id="droppedMatches"></div></span>
	</div>

	<!-- Alight text left and edit buttons right eventually. -->
	<!-- Should I add confirmations? -->

	<!-- Code for user's major -->
	<div class="row-fluid col-sm-6 col-sm-offset-3 text-center">
		<h4>
			Your major is
			<span>
			<div style="display: inline-block;" id="majorName"><?php echo "{$_SESSION['user_major_name']}."; ?></div>
			<a id="majorEditBtn" href="#" class="btn btn-xs btn-warning" onclick="editMajor()">Edit</a>
			</span>
		</h4>
	</div>
	<div class="row col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-2 col-lg-offset-5 text-center">
			<span id="majorSpan" style="display: none;">
				<form id="majorForm" name="majorForm" method="post" action="update.php" onsubmit="return saveMajor();">
					<input type="hidden" name="newMajorId" id="newMajorId" value="">
					<select id="selectMajor" class="form-control selectpicker" name="major" data-live-search="true" data-size="5">
						<?php print_majors(); ?>
					</select>
					<div style="padding-top: 5px;"> <!-- Tmp inline style -->
					<button type="submit" name="majorSaveBtn" value="Submit" id="majorSaveBtn" class="btn btn-sm btn-success" style="display: none;">Save</button>
					<a id="majorCancelBtn" href="#" class="btn btn-sm btn-info" onclick="cancelEdit('major')" style="display: none;">Cancel</a>
					</div>
				</form>
			</span>
	</div>

	<!-- Code for user's cycle -->
	<div class="row-fluid col-sm-6 col-sm-offset-3 text-center">
		<h4>
			Your cycle is
			<span>
			<div style="display: inline-block;" id="cycleName"><?php echo "{$_SESSION['user_cycle_name']}."; ?></div>
			<a id="cycleEditBtn" href="#" class="btn btn-xs btn-warning" onclick="editCycle()">Edit</a>
			</span>
		</h4>
	</div>
	<div class="row col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-2 col-lg-offset-5 text-center">
		<span id="cycleSpan" style="display: none;">
			<form id="cycleForm" name="cycleForm" method="post" action="update.php" onsubmit="return saveCycle();">
				<input type="hidden" name="newCycleId" id="newCycleId" value="">
				<select id="selectCycle" class="form-control selectpicker" name="cycle"> 
				<!-- Makes no sense but ok. -->
					<?php if ($_SESSION['user_cycle'] == 1) { ?>
						<option selected="selected" value="1">Fall-Winter</option>
						<option value="2">Spring-Summer</option>
					<?php } else { ?>
						<option value="1">Fall-Winter</option>
						<option selected="selected" value="2">Spring-Summer</option>
					<?php } ?>
				</select>
				<div style="padding-top: 5px;"> <!-- Tmp inline style -->
				<button type="submit" name="cycleSaveBtn" value="Submit" id="cycleSaveBtn" class="btn btn-sm btn-success" style="display: none;">Save</button>
				<a id="cycleCancelBtn" href="#" class="btn btn-sm btn-info" onclick="cancelEdit('cycle')" style="display: none;">Cancel</a>
				</div>
			</form>
		</span>
	</div>

	<!-- Code for user's program -->
	<div class="row-fluid col-sm-6 col-sm-offset-3 text-center">
		<h4>
			Your program is
			<span>
			<div style="display: inline-block;" id="programName"><?php echo "{$_SESSION['user_program_name']}."; ?></div>
			<a id="programEditBtn" href="#" class="btn btn-xs btn-warning" onclick="editProgram()">Edit</a>
			</span>
		</h4>
	</div>
	<div class="row col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-2 col-lg-offset-5 text-center">
		<span id="programSpan" style="display: none;">
			<form id="programForm" name="programForm" method="post" action="update.php" onsubmit="return saveProgram();">
				<input type="hidden" name="newProgramId" id="newProgramId" value="">
				<select id="selectProgram" class="form-control selectpicker" name="cycle"> 
				<!-- Makes no sense but ok. -->
					<?php if ($_SESSION['user_program'] == 1) { ?>
						<option selected="selected" value="1">1 co-op</option>
						<option value="2">3 co-ops</option>
					<?php } else { ?>
						<option value="1">1 co-op</option>
						<option selected="selected" value="2">3 co-ops</option>
					<?php } ?>
				</select>
				<div style="padding-top: 5px;"> <!-- Tmp inline style -->
				<button type="submit" name="programSaveBtn" value="Submit" id="programSaveBtn" class="btn btn-sm btn-success" style="display: none;">Save</button>
				<a id="programCancelBtn" href="#" class="btn btn-sm btn-info" onclick="cancelEdit('program')" style="display: none;">Cancel</a>
				</div>
			</form>
		</span>
	</div>

	<?php
		// Get the latest user_matched status
		$_SESSION['user_matched'] = mysql_get_var("SELECT matched FROM Users WHERE id = " . $_SESSION['user_id'] . "");

		// If the user has a match, get the match's info and display it.
		if ($_SESSION['user_matched'] == 1) { 
			$other_user_data = get_match_info();
		?>

			<!-- <div class="row-fluid col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 text-center"> -->
			<div class="row-fluid col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-6 col-lg-offset-3 text-center">
				<br><hr><p class="lead">Hey, you have a match!</p>


				<!-- Display data for marking match as completed. 
				Add column to Users for Match_completed, if both users are 1, set as completed in Matches table and display code. 
				-->
			

			</div>

			<div class="row-fluid col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-6 col-lg-offset-3 text-center well">
				<p>You have matched with <strong> <?php echo $other_user_data[0]['name']; ?></strong>.</p>
				<p>You can email them at <strong> <?php echo $other_user_data[0]['email']; ?></strong></p>
			</div>
	
	<?php } else { // If the user does not have a match tell them they still do not. ?>
			<div class="row-fluid col-md-6 col-md-offset-3 text-center">
				<br><p class="lead">You do not have a match yet, but we will keep looking!</p>
			</div>
	<?php } ?>

</div>

<?php 

mysql_close($con);
include('footer.php'); 
?>

<script type="text/javascript">
	
	// Get some vars from PHP
	window.hasDroppedMatch = "<?php echo $_SESSION['user_dropped_matches']; ?>";
	if (hasDroppedMatch == "")
		window.hasDroppedMatch = 0;

	window.isMatched = "<?php echo $_SESSION['user_matched']; ?>";

	window.droppedMatches = document.getElementById("droppedMatches");

	// Major Window Vars
	window.majorSaveBtn = document.getElementById("majorSaveBtn");
	window.majorEditBtn = document.getElementById("majorEditBtn");
	window.majorCancelBtn = document.getElementById("majorCancelBtn");
	window.majorSpan = document.getElementById("majorSpan");
	window.majorDiv = document.getElementById("majorName");
	window.selectMajor = document.getElementById("selectMajor");

	// Cycle Window Vars
	window.cycleSaveBtn = document.getElementById("cycleSaveBtn");
	window.cycleEditBtn = document.getElementById("cycleEditBtn");
	window.cycleCancelBtn = document.getElementById("cycleCancelBtn");
	window.cycleSpan = document.getElementById("cycleSpan");
	window.cycleDiv = document.getElementById("cycleName");
	window.selectCycle = document.getElementById("selectCycle");

	// Program Window Vars
	window.programSaveBtn = document.getElementById("programSaveBtn");
	window.programEditBtn = document.getElementById("programEditBtn");
	window.programCancelBtn = document.getElementById("programCancelBtn");
	window.programSpan = document.getElementById("programSpan");
	window.programDiv = document.getElementById("programName");
	window.selectProgram = document.getElementById("selectProgram");	

	window.errorClassVals = "alert alert-warning";
	window.droppedMatches.style.display = 'none';


	var editMajor = function () {
		
		if (check_if_dropped()) {
			window.majorDiv.style.display = 'none';
			window.majorSpan.style.display = '';

			window.majorEditBtn.style.display = 'none';
			window.majorSaveBtn.style.display = '';
			window.majorCancelBtn.style.display = '';
		}

	} 

	// Replace each individ. save function is the hope, also so users can submit more than one edit.
	var saveValues = function () {



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

			window.cycleEditBtn.style.display = 'none';
			window.cycleSaveBtn.style.display = '';
			window.cycleCancelBtn.style.display = '';
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

			window.programEditBtn.style.display = 'none';
			window.programSaveBtn.style.display = '';
			window.programCancelBtn.style.display = '';	
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

		else if (window.isMatched == 1)
		{
			window.droppedMatches.textContent = "By editing your profile, your current match will be dropped. The more matches you drop, the lower you go in the queue.";	
			window.droppedMatches.className = 'alert alert-info';
			window.droppedMatches.style.display = '';
			return true;
		}
		else 
		{

		}

	}

	var cancelEdit = function (field) {

		if (field == "major") {
			window.majorSaveBtn.style.display = 'none';
			window.majorSpan.style.display = 'none';
			window.majorDiv.style.display = 'inline-block';
			window.majorCancelBtn.style.display = 'none';
			window.majorEditBtn.style.display = '';
		}
		else if (field == "cycle") {
			window.cycleSaveBtn.style.display = 'none';
			window.cycleSpan.style.display = 'none';
			window.cycleDiv.style.display = 'inline-block';
			window.cycleCancelBtn.style.display = 'none';
			window.cycleEditBtn.style.display = '';
		}
		else if (field == "program") {
			window.programSaveBtn.style.display = 'none';
			window.programSpan.style.display = 'none';
			window.programDiv.style.display = 'inline-block';
			window.programCancelBtn.style.display = 'none';
			window.programEditBtn.style.display = '';
		}

		window.droppedMatches.style.display = 'none';
	}

</script>


<!-- To Do For User Page 1

- Ability to change information (cycle, major, 4/5 year)
- Other misc. I guess