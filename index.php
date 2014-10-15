<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");
include_once(FUNCTION_PATH . "/connect.php");

/*

== To Do ==

- Better password security
- Better error reportng I guess? Like the /error.php page
- Password resets
- ToS Page
- ToS Validation (Check it is checked)

- Is JS form validation enough, or do php validation too?

*/

?>

<div class="container" id="begin">
  
	<!-- IF NOT LOGGED IN -->
	
<?php if (!isset($_SESSION['login'])) { // if ($_SESSION['login'] == "") { ?>

	<div id="startText" class="row">
		<div class="normalRow">
			<h2>Find someone to trade coop cycles with!</h2>
		</div>
	</div>

    <div id="stockPhoto" class="row">
  		<div class="normalRow">
  			<img src="/img/stockphoto.jpeg"
  				 class="img-responsive img-thumbnail center-block">
  			<!-- <div class="caption">Friends having fun on Coopswitch.</div>  -->
  	 	<br><br>
  		</div>
  	</div>

  	<div class="row">
  		<div class="normalRow">
  			<button class="btn btn-lg btn-success" id="getStarted" style="width: 85%;"><h2>Get Started</h2></button>
  		</div> 
  	</div>
<!-- onclick="expandForm()"  -->
</div>

  	<!-- REGISTER FORM START -->
	<div id="registerForm" class="container col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
	    <div class="row">
	  		<div id="formHeader">
	  			<h3><strong>Registration Form</strong></h3>
	  			<!-- <p>This is currently for <em>Drexel Freshman</em> only.</p> -->
	  		</div>
	  	</div>
		
			<!-- Print out if there is an error with the form data. -->
			<div class="row">
	  		<div id="element">
	  			<span class="error">
	  				<strong>
	  					<div class="alert alert-warning lead" id="formError">
	  						<!-- <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> -->
	  					</div>
	  				</strong>
	  			</span>
	  		</div>
	  	</div>

			<!-- Registration Form -->
			<!-- method="post" action="register.php" onsubmit="return validate_submit();" id="register" -->
		<form class="form-horizontal" id="register">

			<div id="nameDiv" class="form-group has-feedback">
				<label for="nameField">Name</label>
				<div>
  				<input type="text" class="form-control input-lg" id="user_name" name="name" placeholder="Enter your name" data-toggle="tooltip" data-trigger="click" data-placement="right" title="">
					<span id="nameFeedback" class="glyphicon form-control-feedback"></span>
				</div>
				<div id="nameError" class="help-block error"></div>
			</div>

			<div id="emailDiv" class="form-group has-feedback">
				<label for="emailField">Email</label>
				<div>
  				<input type="email" class="form-control input-lg" id="user_email" name="email" placeholder="Enter your Drexel email">
					<span id="emailFeedback" class="glyphicon form-control-feedback"></span>	  			
				</div>
				<div id="emailError" class="help-block error"></div>	  				
			</div>

			<div id="passwordDiv" class="form-group has-feedback">
				<label for="passwordField">Password</label>
				<div>
					<input type="password" class="form-control input-lg" id="user_pass" name="password" placeholder="Enter a password" onchange="validate_password()">
  				<input type="password" class="form-control input-lg" id="user_pass_confirm" name="password2" placeholder="Confirm password" onchange="passwordConfirm()">
	  				<span id="passwordFeedback" class="glyphicon form-control-feedback"></span> 				
				</div>
				<!-- TODO: Better initial message format (info via jquery). -->
  			<div id="passwordError" class="help-block error"><p id="initPassMsg" class="alert text-warning bg-infook">Do not use your Drexel One password.</p></div>
			</div>

	    <div class="form-group">
	    	<div id="element">
	    		<hr class="style-three">
	    	</div>
	    </div>
		    
		  <?php if ($testHaveSwitch) { require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/dev/haveSwitch.html"); } ?>

  			<div class="form-group" id="mainMajorDiv">
  				<label for="majorField">Major</label>
					<div class="col-sm-6">			  			
		  				<select class="form-control selectpicker input-lg" id="user_major" name="major" data-live-search="true" data-size="5">

		  				</select>
	  			</div>
  				<div>
  					<span class="help-block error"><div id="majorError"></div></span>
  				</div>
  			</div>

	    	<div class="form-group">
	  				<label for="cycleField">Current Cycle</label>
	  				<div class="col-sm-4">
		  				<label class="radio-inline formLabelRadio lead">
							  <input checked="checked" type="radio" name="cycle" id="cycle" value="1"><span class="fallwinter">Fall Winter</span>
							</label>
						</div>
						<div class="col-sm-4">
							<label class="radio-inline formLabelRadio lead">
							  <input type="radio" name="cycle" id="cycle" value="2"><span class="springsummer">Spring Summer</span>
							</label>
		  			</div>
	  		</div>

	  		<div class="form-group">
	  				<label for="numCoopsField">Coops</label>
	  				<div class="col-sm-4">
		  				<label class="radio-inline formLabelRadio lead">
							  <input checked="checked" type="radio" name="numCoops" id="numCoops" value="1"><span class="onecoop">One Coop</span>
							</label>
						</div>
						<div class="col-sm-4">
							<label class="radio-inline formLabelRadio lead">
							  <input type="radio" name="numCoops" id="numCoops" value="2"><span class="threecoop">Three Coops</span>
							</label>		  			
	  				</div>
	    	</div>


		    <div class="form-group">
		    	<div id="element">
		    		<hr class="style-three">
		    	</div>
		    </div>
 
      	<div class="form-group" id="acceptTerms">
      		<div class="col-sm-offset-2 col-sm-8 text-center lead">
      			<div class="checkbox">
      					<input name="terms" id="terms" type="checkbox"> I<span id="myName"></span> accept the <a href="#">terms and conditions.</a>
      			</div>
      		</div>
      	</div>
  			
      	<br>
      
      	<div class="form-group">
	  			<div id="element">
	  				 <div id="errorFree">
	  				 		<button id="submitRegisterBtn" type="submit" value="Submit" class="btn btn-block btn-default btn-lg btn-primary">Register</button>
	  				 </div>
	  			</div>
     		</div>
	      
		</form>
	</div>
		<!-- USER IS LOGGED IN, MAKE THIS BETTER -->
		
		<?php } else {	header("Location: /switch"); } ?>

<div class="modal fade" id="nonSwitchMajor" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="goHome()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="modal-title">Sorry, you cannot switch that major.</h2>
			</div>
			<div class="modal-body">
				<p class="lead">Your major is not able to switch coop cycles.</p>
				<p>For more information, please contact the Steinbright Career Development Center or 
					<a target="_blank" href="https://www.drexel.edu/scdc/co-op/undergraduate/policies-procedures/cycles/">click here</a>
						for more information.
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- // New JQuery Code! // -->
<script type="text/javascript">

	/* CSS CLASS VARS */
	formLabelClass = "col-sm-2 col-sm-offset-0 control-label formLabel";
	formInputWidth = "col-sm-6";
  formErrorWidth = "formError col-sm-3";
  formElementClass = "col-md-10 col-md-offset-1 col-sm-12 text-center";
  normalRowClass = "col-sm-6 col-sm-offset-3 text-center";

	feedbackSuccess = " glyphicon-ok";
	feedbackWarning = " glyphicon-warning-sign";
	feedbackError = " glyphicon-remove";

	errorClass = "formError col-sm-3 alert alert-danger";

	/* ON LOAD SET CLASSES */
	$( window ).ready(function() {

			$('form#register label').addClass(formLabelClass);
			$('form#register input').parent().addClass(formInputWidth);
			$('form#register span.error').parent().addClass(formErrorWidth);
			$('form#register #element').addClass(formElementClass);
			$('#formHeader').addClass(formElementClass+" text-primary formHeader");
			$('.normalRow').addClass(normalRowClass);
			$('div.form-control-feedback').addClass('form-group glyphicon');

			$('div.help-block').addClass(errorClass);
			$('div.help-block').toggle();
			$('#passwordError').toggle();

			$('.noSwitch').prop('disabled', false);

			getMajors();
			console.log("Loaded.");
			$('.selectpicker').selectpicker({ 'selectedText': '', style:'btn-default btn-lg' });
	});

	$('.form-control').change(function() {

		// console.log(this.id);
		switch (this.id) {
			case 'user_name':
				validateName(this.value);
				break;
			case 'user_email':
				validateEmail(this.value);
				break;
			case 'user_pass':
				validatePassword(this.value);
				break;
			case 'user_pass_confirm':
				validatePasswordConfirm(this.value);
			case 'user_major':
				validateMajor(this.value);
				break;
		}
	});

	$('#submitRegisterBtn').click(function(e) {

		validRegister = false;
		
		console.log("Register submit.");

		if (!validRegister) {
			e.preventDefault();		
		}

	});

</script>

<script>
	
	id("registerForm").style.display = 'none';
	 // id("registerForm").style.display = '';
	 // id("begin").style.display = 'none';

	$('#getStarted').click(function(e){    
	    $('#begin').fadeOut('fast', function(){
	        $('#registerForm').fadeIn('fast');
	    });
	});
</script>

<script type="text/javascript">

	function toggleFeedback(formGroup, isValid) {

		selector = 'div'+formGroup+' .form-control-feedback';

		if (isValid) {
			console.log("Valid.");
			$(selector).addClass(feedbackSuccess);
			$(selector).removeClass(feedbackError);
			$(formGroup).addClass('has-success');
			$(formGroup).removeClass('has-error');
			$(formGroup+ " .help-block").hide();
		}
		else if (!isValid) {
			console.log("Not valid.");
			$(selector).addClass(feedbackError);
			$(selector).removeClass(feedbackSuccess);
			$(formGroup).addClass('has-error');
			$(formGroup).removeClass('has-success');
			$(formGroup+ " .help-block").show();
		}
		else {
			console.log("No valid state, show warning.");
		}

	}


	function validateName(name) {

		isValid = false;
		helpBlockText = "";

		name = name.trim();
		regTest = /^[a-zA-Z\s]*$/;

		var validName = regTest.test(name);

		if (!validName || name.length == 0) {
			errors.name = 1;
			helpBlockText = "Invalid characters in name.";
		}
		else {
			errors.name = 0;
			isValid = true;
		}

		$('#nameError').html(helpBlockText);
		toggleFeedback('#nameDiv', isValid);
	}

	function validateEmail(email) {

		isValid = false;
		helpBlockText = "";

		email = email.toLowerCase();

		var regex = /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/;

		if (regex.test(email)) {
			// Valid email true, now check domain.
			if (email.indexOf('@drexel.edu', email.length - '@drexel.edu'.length) !== -1) {
				errors.emailPrimary = 0;
				isValid = true;
				$('#user_email').value = email;
			}
			else {
				helpBlockText = "Not a Drexel edu email.";
			}
		}
		else {
			helpBlockText = "Invalid email format.";
		}

		$('#emailError').html(helpBlockText);
		toggleFeedback('#emailDiv', isValid);


	}

	function getMajors() {
		var majors = new Array();

		idName = "#user_major";

		$.ajax({

			dataType: "json",
			url: "/resources/functions/scripts.php",
			data: "g=majors", 
			success: function(data) {

				majors = data;

				//for (var x=0; x<majors.length; x++) {
				$.each(majors, function() {

					var statement = '<option value="' + this.key + '" class="' + this.class + '">'+ this.name + '</select>';

					$('#user_major').append(statement);

					if (this.class == "noSwitch") {
						$('#user_major option:last-child').attr("data-canSwitch", "0");
						$('#user_major option:last-child').attr("data-subtext", "Not Available");
					}

					if (this.name == "Business Administration") {
						$('#user_major option:last-child').attr("data-subtext", "(All Business Majors)");
					}

				});

				$('.selectpicker').selectpicker('refresh');

			}
		});

	}

	var validateMajor = function (major) {

		console.log("Test!");
		// var major = $("#user_major").val();

		var majorErrorDiv = id("majorError");
		var mainMajorDiv = id("mainMajorDiv");

		console.log($("option:selected", "select[name=major]").attr("data-canSwitch"));

		if($("option:selected", "select[name=major]").attr("data-canSwitch") == 0){

			$('#nonSwitchMajor').modal().show();
			error = 'Unswitchable major.';
			setError(mainMajorDiv, majorErrorDiv, "", error);
			errors.major = 1;
	  }
		else {
			removeError(mainMajorDiv, majorErrorDiv, "");
			errors.major = 0;
		}	

	}

	// $('.selectpicker').selectpicker();

	$('#user_name').tooltip();
	$('#user_pass').popover();

	$('#registerTypeHelp').tooltip();

	// When the page loads, do this
	window.onload = function () {
		
		formErrorDiv = id("formError");
		formErrorDiv.style.display = 'none';

		var errors = 0;
		window.hasEnteredAgain = false;

		window.hasErrors = true; //Start at true so cannot submit blank form.

		window.nameErr = 1;
		window.emailErr = 1;
		window.passwordErr = 1;

		window.errorClassVals = "alert alert-danger";

		window.mainDivClass = "";
		window.mainDivClassError = mainDivClass + " has-error";
		window.mainDivClassValid = mainDivClass + " has-success";
		window.mainDivClassWarning = mainDivClass + " has-warning";
		window.mainDivClassFeedback = mainDivClass + " has-feedback";

		// window.feedbackSuccess = "glyphicon glyphicon-ok form-control-feedback";
		// window.feedbackWarning = "glyphicon glyphicon-warning-sign form-control-feedback";
		// window.feedbackError = "glyphicon glyphicon-remove form-control-feedback";

		window.pageAlert = id("pageAlert");

		window.hasEnteredAgain = false;

		window.errors = {
		    name: 0,
		    emailPrimary: 0,
		    password: 0,
		    major: 0,
		    emailSecondary: 0
		}; 

	}

	var expandForm = function () {

		id("getStarted").style.display = 'none';
		id("registerForm").style.display = '';
		id("stockPhoto").style.display = 'none';
		id("startText").style.display = 'none';

		//id("formInfo").style.display = '';
		// Scroll to form on page and have it fade in/down or something.
	}



	var showConfirm = function () {
		id("user_pass_confirm").style.display = '';

	}



	var validate_submit = function () {

		errorDiv = id("formError");

		// Revalidate all fields to do a final check 
		validate_name();
		validate_email(1); // 1 is for main email. Not using other field currently.
		validate_password();
		passwordConfirm();
		checkMajor();

		if (!id("terms").checked) {
			console.debug("Terms and Conditions have not been checked.");
		}		

		var totalErrors = errors.name + errors.emailPrimary + errors.password + errors.major;

		/*
		if (id("registerType2").checked) {
			validate_email(2);
			console.debug("Registration type two being used.");
		}
		else {
			errors.emailSecondary = 0;
			console.debug("Registration type one being used.");
		}

		totalErrors += errors.emailSecondary;
		*/


		if (totalErrors <= 0) {
			hasErrors = false;
			console.debug("Form submitted with no errors.");

			return true;
		}

		else {
			var hasErrors = true;

			console.debug("Total Errors: "+totalErrors);
			console.debug("Name Error: "+errors.name+" | Email Error: "+errors.emailPrimary+ " | Email Secondary Error: "+errors.emailSecondary +" | Password Error: "+errors.password+" | Major Error: "+errors.major);

			errorDiv.style.display = '';

			if (totalErrors == 1) {
				errorDiv.textContent = "An error is preventing your registration."; // Probably change to recoloring the boxes later.
			}
			else {
				errorDiv.textContent = "Multiple errors are preventing your registration.";
			}
		}

		return false;
	}

	var registerTypeCheck = function() {

		if (id("registerType1").checked) {
			id("otherEmailMain").style.display = 'none';
		}
		else if (id("registerType2").checked) {
			id("otherEmailMain").style.display = '';
		}
	}

</script>

<?php
require_once(TEMPLATES_PATH . "/footer.php");
?>