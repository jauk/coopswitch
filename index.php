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
		  			<div id="mainEmailDiv" class="<?php echo "$formElementClass"; ?>">
		  				<label for="emailField">Email</label>
		  				<input type="email" class="form-control" id="user_email" name="email" placeholder="Enter your Drexel email" onchange="validate_email()">
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
		    		<hr>
		    	</div>
		    </div>

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
		    		<hr>
		    	</div>
		    </div>

	      	<div class="row">
	      		<div class="<?php echo $formElementClass; ?>" id="acceptTerms">
	      			<div class="checkbox">
	      				<label>
	      					<input name="terms" id="terms" type="checkbox"> Please accept the <a href="#">terms and conditions.</a>
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

	// $("#getStarted").click(function(e) {
	// 	$(".starter").fadeOut('slow', funct);
	// 	$("#registerForm").fadeIn('fast');
	// });

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

	// When the page loads, do something I guess
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

		window.pageAlert = id("pageAlert");

		//id("registerForm").style.display = 'none';


		//id('email').onchange = validate_email;
		//id("submit_form").onclick = validate_data;

	}

	var showInfo = function(type) {

		// Tooltips should be used (to right with arrows look nice)
		// Make form look nicer, bigger labels, better font

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

		name = id("user_name").value;
		mainNameDiv = id("mainNameDiv");

		name = name.trim();

		var nameDiv = id("nameError");
		//var mainNameDiv = id("mainNameDiv");

		if (name == "")
		{
			nameErr = 1;
			nameDiv.textContent = "You need a name.";
			nameDiv.style.display = '';
			nameDiv.className = window.errorClassVals;

			mainNameDiv.className = window.mainDivClassError;
		}
		else
		{
			nameErr = 0;
			//nameDiv.textContent = "Name exists.";
			id("user_name").value = name;
			nameDiv.style.display = 'none';

			mainNameDiv.className = window.mainDivClassValid;
		}

	}


	var validate_email = function () {

		var emailDiv = id("emailError");
		var mainEmailDiv = id("mainEmailDiv");

		var email = id("user_email").value;

		email = email.trim();
		email = email.toLowerCase();

		var drexelEmail = "@drexel.edu";

	 	var hasDrexelEmail = email.search("@drexel.edu");
		var endEmail = email.indexOf("@drexel.edu");

		if (hasDrexelEmail != -1) {
			emailErr = 0;
			//emailDiv.textContent = "Valid email!";

			//emailDiv.className = window.
			emailDiv.style.display = 'none';

			var length = endEmail + drexelEmail.length;
			//alert(length);

			emailDiv.style.display = 'none';

			if (length != email.length) {

				emailRemove = email.slice(length, email.length);
				email = email.replace(emailRemove, "");

				emailDiv.style.display = '';
				emailDiv.textContent = "Extra characters removed.";
				emailDiv.className = 'alert alert-info';

				$("#emailError").fadeOut(2000);
			}

			mainEmailDiv.className = window.mainDivClassValid;
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

			//setError(email, error);
			emailErr = 1;
			emailDiv.textContent = error;
			emailDiv.style.display = '';
			emailDiv.className = window.errorClassVals;
			mainEmailDiv.className = window.mainDivClassError;
		}

		id("user_email").value = email;
	}

	var setError = function (field, error) {

		divName = field+"Div";
		divErr = field+"Err";

		var fieldDiv = id(divName);
		var fieldDivErr = id(divErr);

		divErr = 1;

		id(divName).style.display = '';
		// this['divName'].value.className = window.errorClassVals;



		//alert(fieldDiv);
	}

	var validate_password = function () {

		var password = id("user_pass").value;
		var password2 = id("user_pass_confirm").value;

		var passwordDiv = id("passwordError");
		var mainPasswordDiv = id("mainPasswordDiv");

		if (password == "" || password2 == "") {
			passwordErr = 1;
			passwordDiv.textContent = "You need a password.";
			passwordDiv.style.display = '';
			passwordDiv.className = window.errorClassVals;
		}

		else if (password != password2)
		{
			if (password2 == "" && (hasEnteredAgain == false))
			{
				hasEnteredAgain = true;
				return;
			}

			else
			{
				passwordErr = 1;

				passwordDiv.style.display = '';
				passwordDiv.className = window.errorClassVals;
				passwordDiv.textContent = "Passwords do not match!";
				mainPasswordDiv.className = window.mainDivClassError;
			}
		}

		else
		{
			if (password.length < 6 && password.length > 0)
			{
				passwordDiv.style.display = '';
				passwordDiv.className = window.errorClassVals;
				passwordDiv.textContent = "You should use a longer password.";
				mainPasswordDiv.className = window.mainDivClassWarning;

			}

			else
			{
				passwordDiv.style.display = 'none';
				mainPasswordDiv.className = window.mainDivClassValid;
			}

			passwordErr = 0;
			//passwordDiv.textContent = "Passwords match.";
		}

	}

	var checkmajor = function () {

		// Have a modal come up explaining problem with that major, disable registration.

		// Array of IDs of majors which cannot switch.
		//nonSwitchMajorIds = ("", "", "", "", "");

		var major = id("user_major").value;
		var majorDiv = id("majorError");
		var mainMajorDiv = id("mainMajorDiv");

		nonSwitchMajorIds = "87";

		if (major == nonSwitchMajorIds) {

			$('#nonSwitchMajor').modal().show();

			majorDiv.style.display = '';
			majorDiv.className = window.errorClassVals;
			majorDiv.textContent = "You may not switch this major.";
			mainMajorDiv.className = window.mainDivClassError;

			majorErr = 1;
		}
		else {

			mainMajorDiv.className = window.mainDivClassValid;
			majorDiv.style.display = 'none';
			majorErr = 0;
		}		


	}

	var validate_submit = function () {

		errorDiv = id("formError");

		validate_name();
		validate_email();
		validate_password();
		checkmajor();

		var totalErrors = nameErr + emailErr + passwordErr + majorErr;

		if (totalErrors == 0) {
			hasErrors = false;
		}
		else
			hasErrors = true;

		if (totalErrors == 0 && hasErrors == false)
		{
			return true;
		}
		
		else if (hasErrors == true)
		{
			errorDiv.style.display = '';
			errorDiv.textContent = "An error is preventing your registration."; // Probably change to recoloring the boxes later.
			return false;
		}

		return false;
	}

</script>

<?php
require_once(TEMPLATES_PATH . "/footer.php");
?>