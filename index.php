<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");

// Some global CSS variables. Need to fix these names, organize, move to separate class file
$formGroupClass="form-group row-fluid col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3";

$notFormClass="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 text-center";
$otherClassMaybe="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 text-center";

// For now, typical row class that will center items on page and take up 50% of width (6 columns)
$typicalRowClass = "col-sm-6 col-sm-offset-3 text-center";

// Form specific
//$formHeaderClass = "col-sm-4 col-sm-offset-4 text-center well";
//$formElementClass = "col-sm-4 col-sm-offset-4 text-center";
$formHeaderClass = " col-sm-10 col-sm-offset-1 text-center well";
$formElementClass = "col-sm-10 col-sm-offset-1 text-center";

$formMainErrClass = "col-sm-10 col-sm-offset-1 text-center";
$formElementErrClass = "";


$pageName = "Test";

?>

<div class="container">

	  
	<!-- IF NOT LOGGED IN -->
	
	<?php if (!isset($_SESSION['login'])) { // if ($_SESSION['login'] == "") { ?>

		<div class="row">
		  <div class="<?php echo $typicalRowClass; ?>">
  			<p class="lead">
  				Find someone to trade co-op cycles with!
  			</p>
  		</div>
		</div>

    <div class="row">
  		<div class="<?php echo $typicalRowClass; ?>">
  			<img src="http://ak1.picdn.net/shutterstock/videos/2365601/preview/stock-footage-happy-friends-laughing-in-front-of-a-laptop-in-a-bright-living-room.jpg"
  				 class="img-responsive img-rounded center-block" max-width: 100%; height: auto;>
  			<!-- <div class="caption">Friends having fun on Coopswitch.</div>  -->
  	 	<br><br>
  		</div>
  	</div>
  	
  	<!-- REGISTER FORM START -->
	<div class="container col-sm-6 col-sm-offset-3">
	    <div class="row">
	  		<div class="<?php echo $formHeaderClass; ?> well">
	  			<h3>Registration Form</h3>
	  			<p>This is currently for <em>Drexel Freshman</em> only.</p>
	  		</div>
	  	</div>
		
			<!-- Print out if there is an error with the form data. -->
		<div class="row">
	  		<div class="<?php echo $formMainErrClass; ?>">
	  			<span class="error">
	  				<strong><div class="alert alert-warning lead" id="formError"></div></strong>
	  			</span>
	  		</div>
	  	</div>

			<!-- Registration Form -->
		<form role="form" id="register" method="post" action="register.php" onchange="" onsubmit="return validate_submit();" id="register">

			<div id="userElements" class="">
		     	<div class="row">
		  			<div id="mainNameDiv" class="<?php echo "$formElementClass"; ?>">
		  				<label for="nameField">Name</label>
		  				<input type="text" class="form-control" id="user_name" name="name" placeholder="Enter your name" onchange="validate_name()">
		  				<span class="help-block error"><div id="nameError"></div></span>
		  			</div>
		  		</div>
		  
		     	 <div class="row">
		  			<div id="mainEmailDiv" class="<?php echo "$formElementClass"; ?>">
		  				<label for="emailField">Email</label>
		  				<input type="text" class="form-control" id="user_email" name="email" placeholder="Enter your Drexel email" onchange="validate_email()">
		  				<span class="help-block error"><div id="emailError"></div></span>
		  			</div>
		  		</div>
		  
		     	 <div class="row">
		  			<div id="mainPasswordDiv" class="<?php echo "$formElementClass"; ?>">
		  				<label for="passwordField">Password<small><br /><em>Do not use your Drexel One password.</em></small></label>
		  			</div>
		  		</div>
		  		
		  		<div class="row">
		  		  <div class="col-sm-5 col-sm-offset-1">
		  				<input type="password" class="form-control" id="user_pass" name="password" placeholder="Enter a password" onchange="validate_password()">
		  			</div>
		  			<div class="col-sm-5">
		  				<input type="password" class="form-control" id="user_pass_confirm" name="password2" placeholder="Confirm password" onchange="validate_password()">
		  			</div>
		  			<div class="<?php echo "$formElementClass"; ?>">
		  				<span class="help-block error"><div id="passwordError"></div></span>
		        	</div>
		      	</div>
		    </div>

	      	<div id="profileElements" class="">
		      	<div class="row">
		  			<div class="<?php echo "$formElementClass"; ?>">
		  				<label for="majorField">Major</label>
		  				<select class="form-control selectpicker" name="major" data-live-search="true" data-size="5">
		  					<?php
		  					// Get the list of majors and display for user selection.
		  					  print_majors();
		  					  mysql_close($con);
		  					?>
		  				</select>
		  			</div>
		      	</div>
		      
		      <br>

		      	<div class="row">
		  			<div class="col-sm-5 col-sm-offset-1 text-center">
		  				<label for="cycleField">Current Cycle</label>
		  				<select class="form-control selectpicker" id="cycle" name="cycle">
		  					<option value="1">Fall-Winter</option>
		  					<option value="2">Spring-Summer</option>
		  				</select>
		  			</div>

		  			<div class="col-sm-5 text-center">
		  				<label for="numCoopsField">Current Program</label>
		  				<select class="form-control selectpicker" name="numCoops">
		  					<option value="1">4 Years, 1 Co-op</option>
		  					<option value="2">5 Years, 3 Co-op</option>
		  				</select>
		  			</div>
		      	</div>
	      	</div>
	  			<!-- In the future, will implement the "fast-track" option.
	  			<div class="form-group row-fluid col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
	  				<label for="payment">Payment Amount <small>(Optional)</small></label>
	  				<input type="text" class="form-control" id="payment" name="payment" placeholder="Enter an amount ($5)">
	  			</div>
	  			-->
	  			
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
  			<h4>You are already registered.
  			<?php echo $fun[$option][1]; ?>
  			<br></h4>
  			<img src="<?php echo $fun[$option][0]; ?>" max-width: 100%; height: auto; class="img-responsive img-circle center-block">
  		</div>
	</div> 
	<?php } ?>

</div>

<script type="text/javascript">

	// When the page loads, do something I guess
	//var $ = function (id) { return id(id); }\
	
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


		//id('email').onchange = validate_email;
		//id("submit_form").onclick = validate_data;

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
			email = "email";
			error = "That is not a valid Drexel email.";

			//setError(email, error);
			emailErr = 1;
			emailDiv.textContent = "That is not a Drexel email!";
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

		alert(id(divName));

		id(divName).style.display = '';
		// this['divName'].value.className = window.errorClassVals;



		alert(fieldDiv);
	}

	var validate_password = function () {

		var password = id("user_pass").value;
		var password2 = id("user_pass_confirm").value;

		var passwordDiv = id("passwordError");
		var mainPasswordDiv = id("mainPasswordDiv");

		if (password == "" && password2 == "") {
			passwordErr = 1;
		}

		if (password != password2)
		{
			if (password2 == "" && (hasEnteredAgain == false))
			{
				hasEnteredAgain = true;
				return;
			}

			else
			{
				passwordErr = 1;
				passwordDiv.textContent = "Passwords do not match!";
				passwordDiv.style.display = '';
				passwordDiv.className = window.errorClassVals;
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

	var validate_submit = function () {

		errorDiv = id("formError");

		validate_name();
		validate_email();
		validate_password();

		var totalErrors = nameErr + emailErr + passwordErr;

		if (totalErrors == 0)
			hasErrors = false;
		else
			hasErrors = true;

		if (totalErrors == 0 && hasErrors == false)
		{
			return true;
		}
		
		else if (hasErrors == true)
		{
			errorDiv.style.display = '';
			errorDiv.textContent = "Hey, you have a problem on your form!"; // Probably change to recoloring the boxes later.
			return false;
		}
	}

</script>

<?php
require_once(TEMPLATES_PATH . "/footer.php");
//include('footer.php')
?>

<!--

== To Do ==

- Better password security
- Email account confirmation (if try to login show message need to confirm)
- Better error reportng I guess? Like the /error.php page
- Better emails for matches
- Better security I guess
- More db fields (ie. for acct confirmation)

- * Complete match code (see accounts for more details)

- Fast Track


How do I prevent abuse of match dropping
- If someone is locked into their second match, that hurts who they are matched with
- Maybe after they drop two matches, they are set as matched and just not allowed
	to match with anyone else unless manually switched or something.
- That way they are excluded from matching pool.

* The more matches you decline, the lower your priority gets. - Thanks Tyler
* This should work but should do some more testing.


* Email other user if match dropped to warn them still looking

-->