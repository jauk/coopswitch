<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");
include_once(FUNCTION_PATH . "/connect.php");

// Some global CSS variables. Need to fix these names, organize, move to separate class file
$formGroupClass="form-group row-fluid col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3";

$notFormClass="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 text-center";
$otherClassMaybe="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 text-center";

// For now, typical row class that will center items on page and take up 50% of width (6 columns)
$typicalRowClass = "col-sm-6 col-sm-offset-3 text-center";

// Form specific
//$formHeaderClass = "col-sm-4 col-sm-offset-4 text-center well";
//$formElementClass = "col-sm-4 col-sm-offset-4 text-center";

$formElementClass = "col-md-10 col-md-offset-1 col-sm-12 text-center";
$formHeaderClass = $formElementClass . " bg-info lead text-info";

$formMainErrClass = $formElementClass;

$formElementErrClass = "";

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
		<div class="<?php echo $typicalRowClass; ?>">
				<p class="lead">Find someone to trade co-op cycles with!</p>
			</div>
	</div>

    <div id="stockPhoto" class="row">
  		<div class="<?php echo $typicalRowClass; ?>">
  			<img src="/img/stockphoto.jpeg"
  				 class="img-responsive img-rounded center-block" max-width: 100%; height: auto;>
  			<!-- <div class="caption">Friends having fun on Coopswitch.</div>  -->
  	 	<br><br>
  		</div>
  	</div>

  	<div class="row">
  		<div class="<?php echo $typicalRowClass; ?>">
  			<button class="btn btn-lg btn-success" id="getStarted" style="width: 85%;"><h2>Get Started</h2></button>
  		</div> 
  	</div>
<!-- onclick="expandForm()"  -->
</div>

  	<!-- REGISTER FORM START -->
	<div id="registerForm" class="container col-sm-6 col-sm-offset-3">
	    <div class="row">
	  		<div class="<?php echo $formHeaderClass; ?>" style="padding: 20px;">
	  			<h3><strong>Registration Form</strong></h3>
	  			<!-- <p>This is currently for <em>Drexel Freshman</em> only.</p> -->
	  		</div>
	  	</div>
		
			<!-- Print out if there is an error with the form data. -->
		<div class="row">
	  		<div class="<?php echo $formMainErrClass; ?>">
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
		<form role="form" id="register" method="post" action="register.php" onsubmit="return validate_submit();" id="register">

			<div id="userElements" class="">
		     	<div class="row">
		  			<div id="mainNameDiv" class="<?php echo "$formElementClass"; ?>">
		  				<label for="nameField">Name</label>
		  				<input type="text" class="form-control" id="user_name" name="name" placeholder="Enter your name" onchange="validate_name()" data-toggle="tooltip" data-trigger="click" data-placement="right" title="">
		  				<span class="help-block error"><div id="nameError"></div></span>
		  			</div>
		  		</div>
		  
		     	 <div class="row">
		  			<div id="emailDiv" class="<?php echo "$formElementClass"; ?>">
		  				<label for="emailField">Email</label>
		  				<input type="email" class="form-control" id="user_email" name="email" placeholder="Enter your Drexel email" onchange="validate_email(1)">
		  				<span class="help-block error"><div id="emailError"></div></span>
		  			</div>
		  		</div>
		  
		     	 <div class="row">
		  			<div id="mainPasswordDiv" class="<?php echo "$formElementClass"; ?>">
		  				<label for="passwordField">Password<!-- <small><br /><em>Do not use your Drexel One password.</em></small> --></label>
		  			</div>
		  		</div>
		  		
		  		<div class="row">
		  		  <div class="col-md-5 col-md-offset-1 col-sm-6">
		  				<input type="password" class="form-control" id="user_pass" name="password" placeholder="Enter a password" onchange="validate_password()"  data-toggle="popover" data-trigger="" data-placement="auto" title="Warning" data-content="Please do not use your Drexel One password.">
		  			</div>
		  			<div class="col-md-5 col-sm-6">
		  				<input type="password" class="form-control" id="user_pass_confirm" name="password2" placeholder="Confirm password" onchange="validate_password()">
		  			</div>
		  			<div class="<?php echo "$formElementClass"; ?>">
		  				<span class="help-block error"><div id="passwordError"></div></span>
		        	</div>
		      	</div>
		    </div>


		    <div class="row">
		    	<div class="<?php echo $formElementClass; ?>">
		    		<hr class="style-three">
		    	</div>
		    </div>
		    
		    <?php if ($testHaveSwitch) { ?>

		    <div class="row">
		    	<div class="<?php echo $formElementClass; ?>" id="mainRegisterTypeDiv">
					<div class="radio-inline">
						<label>
							<input checked type="radio" name="registerType" id="registerType1" onchange="registerTypeCheck()" value="1">
							Find a switch.
						</label>
					</div>
					<div class="radio-inline">
						<label>
							<input  type="radio" name="registerType" id="registerType2" onchange="registerTypeCheck()" value="2">
							I have a switch. <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Choose this if you already have someone to switch with." id="registerTypeHelp"></span>
							</label>

					</div>
		    	</div>
		    </div>

		    <div class="row">
	    		<div class="<?php echo $formElementClass; ?>" id="otherEmailMain" style="display: none;">
	    			<input type="email" class="form-control" name="otherUserEmail" id="otherUserEmail" placeholder="Student's Drexel email" onchange="validate_email(2)">	
	    		</div>
    			<div class="<?php echo "$formElementClass"; ?>">
	  				<span class="help-block error"><div id="otherEmailError"></div></span>
	        	</div>
		    </div>

		    <div class="row">
		    	<div class="<?php echo $formElementClass; ?>">
		    		<hr class="style-three">
		    	</div>
		    </div>		   

		    <?php } ?>


	      	<div id="profileElements" class="">
		      	<div class="row">
		  			<div class="<?php echo $formElementClass; ?>" id="mainMajorDiv">
		  				<label for="majorField">Major</label>
		  				<select class="form-control selectpicker" id="user_major" name="major" data-live-search="true" data-size="5" onchange="checkmajor()">
		  					<?php
		  					// Get the list of majors and display for user selection.
		  					  print_majors();
		  					  mysql_close($con);
		  					?>
		  				</select>
		  			</div>
		  			<div class="<?php echo $formElementClass; ?>">
		  				<span class="help-block error"><div id="majorError"></div></span>
		  			</div>
		      	</div>
		      	<div class="row">
		  			<div class="col-md-5 col-md-offset-1 col-sm-6 text-center">
		  				<label for="cycleField">Current Cycle</label>
		  				<select class="form-control selectpicker" id="cycle" name="cycle">
		  					<option value="1">Fall-Winter</option>
		  					<option value="2">Spring-Summer</option>
		  				</select>
		  			</div>

		  			<div class="col-md-5 col-sm-6 text-center">
		  				<label for="numCoopsField">Current Program</label>
		  				<select class="form-control selectpicker" name="numCoops">
		  					<option value="1">1 co-op</option>
		  					<option value="2">3 co-ops</option>
		  				</select>
		  			</div>
		      	</div>

	      	</div>

		    <div class="row">
		    	<div class="<?php echo $formElementClass; ?>">
		    		<hr class="style-three">
		    	</div>
		    </div>
 
	      	<div class="row">
	      		<div class="<?php echo $formElementClass; ?>" id="acceptTerms">
	      			<div class="checkbox">
	      				<label>
	      					<input name="terms" id="terms" type="checkbox"> I<span id="myName"></span> accept the <a href="#">terms and conditions.</a>
	      				</label>
	      			</div>
	      		</div>
	      	</div>
	  			
	      	<br>
	      
	      	<div class="row">
	  			<div class="<?php echo "$formElementClass"; ?> text-center">
	  				 <div id="errorFree">
	  				 	<button type="submit" name="submit_form" value="Submit" id="submit_form" class="btn btn-block btn-default btn-lg btn-primary">Register</button>
	  				 </div>
	  			</div>
	     	</div>
	      
		</form>
	</div>
		<!-- USER IS LOGGED IN, MAKE THIS BETTER -->
		
		<?php } else {
		
			$fun = array(
				array("http://upload.wikimedia.org/wikipedia/commons/5/5c/Narwhals_breach.jpg", "Here are some narwhals playing."),
				array("http://www.graphics99.com/wp-content/uploads/2012/07/funny-giraffe-tongue-image-for-friendster.jpg", "Here is a silly giraffe."),
				array("http://www.funnyzone.org/wp-content/uploads/2009/06/635_bear-and-panda.jpg", "Here is a group of penguins."),
				array("http://twistedsifter.files.wordpress.com/2012/05/funny-baby-elephant-4.jpg", "Here is an elephant playing soccer.")
			);

			$option = rand(0, 3);

		?>

		    <div class="row">
		  		<div class="<?php echo $typicalRowClass; ?>">
		  			<p class="lead">
		  			Coopswitch switches more co-op cycles than any other website.
		  			</p>
		  		</div>
			</div> 

		<?php } ?>


<div class="modal fade" id="nonSwitchMajor" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="goHome()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h2 class="modal-title">Sorry, you cannot switch that major.</h2>
			</div>
			<div class="modal-body">
				<p class="lead">Your major is not able to switch coop cycles.</p>
				<p>For more information, please contact the Steinbright Career Development Center.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<!-- </div> -->
<script>
	id("registerForm").style.display = 'none';

	$('#getStarted').click(function(e){    
	    $('#begin').fadeOut('fast', function(){
	        $('#registerForm').fadeIn('fast');
	    });
	});
</script>

<script type="text/javascript">

	$('.selectpicker').selectpicker();
	$('#user_name').tooltip();
	$('#user_pass').popover();

	$('#registerTypeHelp').tooltip();

	// When the page loads, do this
	window.onload = function () {
		
		errorDiv = id("formError");
		errorDiv.style.display = 'none';

		var errors = 0;
		window.hasEnteredAgain = false;

		window.hasErrors = true; //Start at true so cannot submit blank form.

		window.nameErr = 1;
		window.emailErr = 1;
		window.passwordErr = 1;

		window.errorClassVals = "alert alert-warning";

		window.mainDivClass = "<?php echo $formElementClass; ?>";
		window.mainDivClassError = mainDivClass + " has-error";
		window.mainDivClassValid = mainDivClass + " has-success";
		window.mainDivClassWarning = mainDivClass + " has-warning";
		window.mainDivClassFeedback = mainDivClass + " has-feedback";

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

	var setError = function(fieldMainDiv, fieldErrorDiv, errorMessage) {

		var mainDiv = fieldMainDiv;
		var errorDiv = fieldErrorDiv;
		var error = errorMessage;

		errorDiv.textContent = error;
		errorDiv.style.display = '';
		errorDiv.className = window.errorClassVals;
		mainDiv.className = window.mainDivClassError;

	}

	var removeError = function(fieldMainDiv, fieldErrorDiv) {

		var mainDiv = fieldMainDiv;
		var errorDiv = fieldErrorDiv;

		mainDiv.className = window.mainDivClassValid;
		errorDiv.style.display = 'none';

	}

	var calcErrors = function(type) {


	}

	var validate_name = function () {

		var name = id("user_name").value;

		var nameDiv = id("mainNameDiv");
		var nameErrorDiv = id("nameError");

		name = name.trim();

		regTest = /^[a-zA-Z]+$/;

		var validName = regTest.test(name);

		// Only checks if blank, add regex support.
		if (name == "" || !validName)
		{
			errors.name = 1;

			error = "Invalid name entered.";
			setError(nameDiv, nameErrorDiv, error);
		}
		else
		{
			errors.name = 0;

			id("user_name").value = name;
			id("myName").innerHTML = ", " + name + ", ";

			removeError(nameDiv, nameErrorDiv)
		}

		validate_form();
	}


	var validate_email = function (type) {

		if (type == 1) {
			var emailErrorDiv = id("emailError");
			var emailDiv = id("emailDiv");
			var email = id("user_email").value;
			var emailVal = id("user_email");

		}
		else if (type == 2) {
			var emailDiv = id("otherEmailMain");
			var emailErrorDiv = id("otherEmailError");
			var email = id("otherUserEmail").value;
			var emailVal = id("otherUserEmail");

		}
		else {
			alert("ERROR.");
		}

		email = email.trim();
		email = email.toLowerCase();

		var drexelEmail = "@drexel.edu";
	 	var hasDrexelEmail = email.search("@drexel.edu");
		var endEmail = email.indexOf("@drexel.edu");

		if (hasDrexelEmail != -1) {

			console.debug("Has Drexel Email is true.")

			var length = endEmail + drexelEmail.length;

			if (length != email.length) {

				emailRemove = email.slice(length, email.length);
				email = email.replace(emailRemove, "");

				emailErrorDiv.textContent = "Extra characters removed.";
				emailErrorDiv.className = 'alert alert-info';

				$("#emailError").fadeOut(2000);

				removeError(emailDiv, emailErrorDiv);
			}

			// Check to make sure email does not repeat in either form.
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

		}
		else
		{
			if (email == "") {
				error = "You need an email.";
			}
			//email = "email";
			else {
				error = "That is not a valid Drexel email.";
			}

			if (type == 1)
				errors.emailPrimary = 1;
			else
				errors.emailSecondary = 1;

			setError(emailDiv, emailErrorDiv, error);
		}

		//id("user_email").value = email;
		emailVal.value = email;

		validate_form();
	}

	var validate_password = function () {

		var password = id("user_pass").value;
		var password2 = id("user_pass_confirm").value;

		var passwordErrorDiv = id("passwordError");
		var mainPasswordDiv = id("mainPasswordDiv");

		if (password == "" || (password2 == "" && hasEnteredAgain)) {

			errors.password = 1;
			error = "You need a password.";
			setError(mainPasswordDiv, passwordErrorDiv, error);	
		}

		else if (password != password2) {

			if (password2 == "" && !window.hasEnteredAgain) {
				window.hasEnteredAgain = true;
			}

			else {
				errors.password = 1;

				error = "Passwords do not match.";
				setError(mainPasswordDiv, passwordErrorDiv, error);
			}

		}

		else {

			if (password.length < 6 && password.length > 0) {
				passwordErrorDiv.style.display = '';
				passwordErrorDiv.className = window.errorClassVals;
				passwordErrorDiv.textContent = "You should use a longer password.";
				mainPasswordDiv.className = window.mainDivClassWarning;
			}

			else {
				removeError(mainPasswordDiv, passwordErrorDiv);
			}

			errors.password = 0;
		}

		validate_form();

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
				error = "You may not switch this major.";
				setError(mainMajorDiv, majorErrorDiv, error);
				errors.major = 1;
    }
		else {

			removeError(mainMajorDiv, majorErrorDiv);
			errors.major = 0;
		}	

		validate_form();

	}

	var validate_form = function () {

		errorDiv = id("formError");

		// Revalidate all fields to do a final check 
		validate_name();

		validate_email(1);

		validate_password();
		checkmajor();

		if (!id("terms").checked) {
			console.debug("Terms and Conditions have not been checked.");
		}		

		var totalErrors = errors.name + errors.emailPrimary + errors.password + errors.major;

		if (id("registerType2").checked) {
			validate_email(2);
			console.debug("Registration type two being used.");
		}
		else {
			errors.emailSecondary = 0;
			console.debug("Registration type one being used.");
		}

		totalErrors += errors.emailSecondary;

		if (totalErrors <= 0) {
			hasErrors = false;
			console.debug("Form submitted with no errors.");
		}
		else {
			hasErrors = true;
			console.debug("Total Errors: "+totalErrors);
			console.debug("Name Error: "+errors.name+" | Email Error: "+errors.emailPrimary+ " | Email Secondary Error: "+errors.emailSecondary +" | Password Error: "+errors.password+" | Major Error: "+errors.major);
		}

		if (totalErrors == 0 && hasErrors == false) {
			return true;
			$("submit_form").disabled = false;
		}
		
		else if (hasErrors == true)
		{
			errorDiv.style.display = '';
			if (totalErrors == 1) {
				errorDiv.textContent = "An error is preventing your registration."; // Probably change to recoloring the boxes later.
			}
			else {
				errorDiv.textContent = "Multiple errors are preventing your registration.";
			}
			return false;
		}

		return false;
		$("submit_form").disabled = true;
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