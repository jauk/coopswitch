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
		<form class="form-horizontal" role="form" id="register" method="post" action="register.php" onsubmit="return validate_submit();" id="register">

	  			<div id="nameDiv" class="form-group has-feedback">
	  				<label for="nameField">Name</label>
	  				<div>
		  				<input type="text" class="form-control input-lg" id="user_name" name="name" placeholder="Enter your name" onchange="validate_name()" data-toggle="tooltip" data-trigger="click" data-placement="right" title="">
	  					<span id="nameFeedback" class="glyphicon form-control-feedback"></span>
	  				</div>
	  				<div>
	  					<span class="help-block error"><div id="nameError"></div></span>
	  				</div>
	  			</div>
	  
	  			<div id="emailDiv" class="form-group has-feedback">
	  				<label for="emailField">Email</label>
	  				<div>
		  				<input type="email" class="form-control input-lg" id="user_email" name="email" placeholder="Enter your Drexel email" onchange="validate_email(1)">
	  					<span id="emailFeedback" class="glyphicon form-control-feedback"></span>	  			
	  				</div>
	  				<div>
		  				<span class="help-block error"><div id="emailError"></div></span>
					</div>	  				
	  			</div>

	  			<div id="passwordDiv" class="form-group has-feedback">
	  				<label for="passwordField">Password</label>
	  				<div>
	  					<input type="password" class="form-control input-lg" id="user_pass" name="password" placeholder="Enter a password" onchange="validate_password()">
		  				<input type="password" class="form-control input-lg" id="user_pass_confirm" name="password2" placeholder="Confirm password" onchange="passwordConfirm()">
	 	  				<span id="passwordFeedback" class="glyphicon form-control-feedback"></span> 				
	  				</div>
	  				<div>
		  				<span class="help-block error"><div id="passwordError"><p class="alert text-info bg-info">Do not use your Drexel One password.</p></div></span>
						</div>	 	  				
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
		  				<select class="form-control selectpicker input-lg" id="user_major" name="major" data-live-search="true" data-size="5" data-width="" onchange="checkmajor()">
		  					<?php
		  					// Get the list of majors and display for user selection.
		  					  print_majors();
		  					  mysql_close($con);
		  					?>
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
	  				 		<button type="submit" name="submit_form" value="Submit" id="submit_form" class="btn btn-block btn-default btn-lg btn-primary">Register</button>
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

	/* ON LOAD SET CLASSES */
	$( window ).ready(function() {

			$('form#register label').addClass(formLabelClass);
			$('form#register input').parent().addClass(formInputWidth);
			$('form#register span.error').parent().addClass(formErrorWidth);
			$('form#register #element').addClass(formElementClass);
			$('#formHeader').addClass(formElementClass+" text-primary formHeader");
			$('.normalRow').addClass(normalRowClass);
			
			$('.noSwitch').prop('disabled', false);

			console.log("Loaded.");
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


	// $('.selectpicker').selectpicker();
	$('.selectpicker').selectpicker({ 'selectedText': '',style:'btn-default btn-lg' });

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

		window.feedbackSuccess = "glyphicon glyphicon-ok form-control-feedback";
		window.feedbackWarning = "glyphicon glyphicon-warning-sign form-control-feedback";
		window.feedbackError = "glyphicon glyphicon-remove form-control-feedback";

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

	var validate_name = function () {

		var name = id("user_name").value;

		var nameDiv = id("nameDiv");
		var nameErrorDiv = id("nameError");
		var nameFeedback = id("nameFeedback");

		name = name.trim();

		regTest = /^[a-zA-Z\s]*$/;

		var validName = regTest.test(name);

		// Only checks if blank, add regex support.
		if (name == "" || !validName)
		{
			errors.name = 1;

			error = "Invalid name entered.";
			setError(nameDiv, nameErrorDiv, nameFeedback, error);
		}
		else
		{
			errors.name = 0;

			id("user_name").value = name;
			id("myName").innerHTML = ", " + name + ", ";

			removeError(nameDiv, nameErrorDiv, nameFeedback);
		}

		validate_form();
	}


	var validate_email = function (type) {

		if (type == 1) {
			// var emailErrorDiv = id("emailError");
			var emailDiv = id("emailDiv");
			var emailErrorDiv = id("emailError");
			var emailFeedback = id("emailFeedback");
			// var email = id("user_email");
			// var emailVal = id("user_email");

		}
		// else if (type == 2) {
		// 	var emailDiv = id("otherEmailMain");
		// 	var emailErrorDiv = id("otherEmailError");
		// 	var email = id("otherUserEmail").value;
		// 	var emailVal = id("otherUserEmail");

		// }
		else {
			console.log("ERROR WITH EMAIL.");
		}

		email = id("user_email").value;
		email = email.trim();
		email = email.toLowerCase();

		var drexelEmail = "@drexel.edu";
	 	var hasDrexelEmail = email.search("@drexel.edu");
		var endEmail = email.indexOf("@drexel.edu");

		if (hasDrexelEmail != -1) {

			console.debug("Has Drexel Email is true.")

			var length = endEmail + drexelEmail.length;

			if (length != email.length) {

				//emailRemove = email.slice(length, email.length);
				email = email.slice(0, length);
				//email = email.replace(emailRemove, "");

				// emailErrorDiv.textContent = "Extra characters removed.";
				// emailErrorDiv.className = 'alert alert-info';

				// $("#emailError").fadeOut(2000);

			}
			
			removeError(emailDiv, emailErrorDiv, emailFeedback);
			errors.emailPrimary = 0;

			// Check to make sure email does not repeat in either form.
			/*
			if (type == 1 && email == id("otherUserEmail").value) {

				error = "Same email as person switching with.";
				setError(emailDiv, emailErrorDiv, error);

				errors.emailPrimary = 1;

			}
			else if (type == 2 && email == id("user_email").value) {

				error = "Same email as person registering.";
				setError(emailDiv, emailErrorDiv, error);

				errors.emailSecondary = 1;
			}

			else {
				removeError(emailDiv, emailErrorDiv);
				if (type == 1)
					errors.emailPrimary = 0;
				else
					errors.emailSecondary = 0;
			}
			*/

		}
		else
		{
			if (email == "") {
				error = "You need an email.";
			}
			//email = "email";
			else {
				error = "Not a valid Drexel email.";
			}

			if (type == 1)
				errors.emailPrimary = 1;
			else
				errors.emailSecondary = 1;

			setError(emailDiv, emailErrorDiv, emailFeedback, error);
		}

		//id("user_email").value = email;
		id("user_email").value = email;

		validate_form();
	}

	var showConfirm = function () {
		id("user_pass_confirm").style.display = '';

	}

	var checkmajor = function () {

		// Have a modal come up explaining problem with that major, disable registration.

		// Array of IDs of majors which cannot switch.
		//nonSwitchMajorIds = ("", "", "", "", "");

		var major = id("user_major").value;
		var majorErrorDiv = id("majorError");
		var mainMajorDiv = id("mainMajorDiv");


		// if (nonSwitchMajorIds.indexOf(major) >= 0) {

		// 	$('#nonSwitchMajor').modal().show();
		// 	error = "You may not switch this major.";
		// 	setError(mainMajorDiv, majorErrorDiv, error);
		// 	errors.major = 1;
		// }
		if($("option:selected", "select[name=major]").hasClass('noSwitch')){
				$('#nonSwitchMajor').modal().show();
				error = 'Unswitchable major.';
				setError(mainMajorDiv, majorErrorDiv, "", error);
				errors.major = 1;
    	}
		else {

			removeError(mainMajorDiv, majorErrorDiv, "");
			errors.major = 0;
		}	

		validate_form();

	}

	var validate_form = function () {


	}


	var validate_submit = function () {

		errorDiv = id("formError");

		// Revalidate all fields to do a final check 
		validate_name();
		validate_email(1); // 1 is for main email. Not using other field currently.
		validate_password();
		passwordConfirm();
		checkmajor();

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