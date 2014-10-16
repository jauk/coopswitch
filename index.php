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
</div>

  	<!-- REGISTER FORM START -->
	<div id="registerForm" class="container col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
	    <div class="row">
	  		<div id="formHeader">
	  			<h3><strong>Registration</strong></h3>
	  		</div>
	  	</div>
		
			<!-- Print out if there is an error with the form data. -->
			<!-- TODO: Better main form error display.
			<div class="row">
	  		<div id="element">
	  			<span class="error">
	  				<strong>
	  					<div class="alert alert-warning lead" id="formError">
	  					</div>
	  				</strong>
	  			</span>
	  		</div>
	  	</div>
	  	-->

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
					<input type="password" class="form-control input-lg" id="user_pass" name="password" placeholder="Enter a password">
  				<input type="password" class="form-control input-lg" id="user_pass_confirm" name="password2" placeholder="Confirm password">
	  			<span id="passwordFeedback" class="glyphicon form-control-feedback"></span> 				
				</div>
				<!-- TODO: Better initial message format (info via jquery). -->
  			<div id="passwordError" class="help-block error"><!-- <p id="initPassMsg" class="alert text-warning bg-infook">Do not use your Drexel One password.</p> --></div>
			</div>

	    <div class="form-group">
	    	<div id="element">
	    		<hr class="style-three">
	    	</div>
	    </div>
		    
			<div id="majorDiv" class="form-group has-feedback">
				<label for="majorField">Major</label>
				<div class="col-sm-6">			  			
	  				<select class="form-control selectpicker input-lg" id="user_major" name="major" data-live-search="true" data-size="5">

	  				</select>
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
  				 		<button id="submitRegisterBtn" class="btn btn-block btn-default btn-lg btn-primary">Register</button>
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

	$('#user_name').tooltip();
	$('#user_pass').popover();
	$('#registerTypeHelp').tooltip();

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

	firstEnter = false;

	errors = {
	  name: 1,
	  email: 1,
	  password: 1,
	  major: 0
	}; 

	/* ON LOAD SET CLASSES */
	$( window ).ready(function() {

			$('#registerForm').hide();

			$('form#register label').addClass(formLabelClass);
			$('form#register input').parent().addClass(formInputWidth);
			$('form#register span.error').parent().addClass(formErrorWidth);
			$('form#register #element').addClass(formElementClass);
			$('#formHeader').addClass(formElementClass+" text-primary formHeader");
			$('.normalRow').addClass(normalRowClass);
			$('div.form-control-feedback').addClass('form-group glyphicon');

			$('div.help-block').addClass(errorClass);
			$('div.help-block').toggle();

			$('.noSwitch').prop('disabled', false);

			getMajors();
			console.log("Loaded.");
			$('.selectpicker').selectpicker({ 'selectedText': '', style:'btn-default btn-lg' });
	});

	$('#getStarted').click(function(e){    
	    $('#begin').fadeOut('fast', function(){
	        $('#registerForm').fadeIn('fast');
	    });
	});

	$('.form-control').change(function() {

		switch (this.id) {
			case 'user_name':
				validateName(this.value);
				break;
			case 'user_email':
				validateEmail(this.value);
				break;
			case 'user_pass':
				validatePassword();
				break;
			case 'user_pass_confirm':
				validatePassword();
				break;
			case 'user_major':
				validateMajor(this.value);
				break;
		}
	});

	$('#submitRegisterBtn').click(function(e) {

		var formErrors = 0;
		for (var errorType in errors) {
			formErrors += errors[errorType];
		}

		if (formErrors != 0) {
			console.log("Cannot submit: errors.");
		}
		else {
			$.ajax({
				type: "POST", 
				url: "register.php", 
				data: $('#register').serialize(),
				success: function(data) {
					
				}
			});
		}
		
		e.preventDefault();

	});

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
		errors.name = 1;
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

	function validatePassword() {

		passwordInitial = $('#user_pass').val();
		passwordConfirmed = $('#user_pass_confirm').val();

		if (!firstEnter) {
			firstEnter = true; 
		}

		else {
			isValid = false;
			errors.password = 1;
			helpBlockText = "";

			if (passwordConfirmed == passwordInitial) {
				if (passwordConfirmed.length > 6) {
					isValid = true;
					errors.password = 0;
				}
				else if (passwordConfirmed.length > 0) {
					helpBlockText = "You should use a longer password.";
					errors.password = 0;
				}
				else {
					helpBlockText = "Password cannot be left blank.";
				}
			}
			else {
				helpBlockText = "Passwords do not match.";
			}

			$('#passwordError').html(helpBlockText);
			toggleFeedback('#passwordDiv', isValid);
		
		}
	}


	function validateEmail(email) {

		isValid = false;
		errors.email = 1;
		helpBlockText = "";

		email = email.toLowerCase();

		var regex = /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/;

		if (regex.test(email)) {
			// Valid email true, now check domain.
			if (email.indexOf('@drexel.edu', email.length - '@drexel.edu'.length) !== -1) {
				errors.email = 0;
				isValid = true;
				$('#user_email').value = email;
			}
			else {
				helpBlockText = "Not a Drexel email.";
			}
		}
		else {
			helpBlockText = "Invalid email format.";
		}

		$('#emailError').html(helpBlockText);
		toggleFeedback('#emailDiv', isValid);

	}

	function validateMajor(major) {

		isValid = false;

		if($("option:selected", "select[name=major]").attr("data-canSwitch") == 0){
			$('#nonSwitchMajor').modal().show();
			error = 'Unswitchable major.';
			errors.major = 1;
	  }
		else {
			errors.major = 0;
			isValid = true;
		}	

		toggleFeedback('#majorDiv', isValid);
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

	var validate_submit = function () {


		if (totalErrors == 1) {
			errorDiv.textContent = "An error is preventing your registration."; // Probably change to recoloring the boxes later.
		}
		else {
			errorDiv.textContent = "Multiple errors are preventing your registration.";
		}

	}

</script>

<?php
require_once(TEMPLATES_PATH . "/footer.php");
?>