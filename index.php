<?php
include('header.php');
include_once('scripts.php');

// Some global CSS variables
$formGroupClass="form-group row-fluid col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3";
$notFormClass="row-fluid col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 text-center";

?>

<div class="container-fluid">

	<?php if ($_SESSION['login'] == "") { ?>

		<div class="row col-md-6 col-md-offset-3 text-center">
			<p class="lead">
				Find someone to trade co-op cycles with!
			</p>
		</div>

		<div class="row col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 text-center well">
			<h4>Registration Form</h4>
			<p>This is currently for <em>Drexel Freshman</em> only.</p>
		</div>
		<br>
			
		<div class="<?php echo "$notFormClass"; ?>">
			<span class="error"><strong><div class="alert alert-warning" id="formError"></div></strong></span>
		</div>

		<!-- Print out if there is an error with the form data. Right now it is just a universal one. Needs CSS formatting. -->

		<!-- Registration Form -->
		<form role="form" id="register" method="post" action="register.php" onchange="" onsubmit="return validate_submit();" id="register">

			<div class="<?php echo "$formGroupClass"; ?>">
				<label for="nameField">Name</label>
				<input type="text" class="form-control" id="user_name" name="name" placeholder="Enter your name" onchange="validate_name()">
				<span class="error"><div id="nameError"></div></span>
			</div>

			<div class="<?php echo "$formGroupClass"; ?>">
				<label for="emailField">Email</label> 
				<input type="text" class="form-control" id="user_email" name="email" placeholder="Enter your Drexel email" onchange="validate_email()">
				<span class="error"><div id="emailError"></div></span>					
			</div>

			<div class="<?php echo "$formGroupClass"; ?>">
				<label for="passwordField">Password<small><br /><em>Do not use your Drexel One password.</em></small></label> 
				<input type="password" class="form-control" id="user_pass" name="password" placeholder="Enter a password" onchange="validate_password()">
				<br><input type="password" class="form-control" id="user_pass_confirm" name="password2" placeholder="Confirm password" onchange="validate_password()">
				<span class="error"><div id="passwordError"></div></span>
			</div>

			<!-- 
			In the future, implement for other years. (IS THIS POSSIBLE FOR 5 YEAR PROGRAM?)
			<div class="form-group row-fluid col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
				<label for="gradyear">Graduation Year</label> 
				<select class="form-control" name="gradyear" data-size="10">
				<?php
				// Allow users to select from the next few years.
				?>
				</select>
			</div> 
			-->

			<div class="<?php echo "$formGroupClass"; ?>">

				<div class="form-group ">
					<label for="cycleField">Current Cycle</label>
					<select class="form-control selectpicker" id="cycle" name="cycle">
						<option value="1">Fall-Winter</option>
						<option value="2">Spring-Summer</option>
					</select>
				</div>

				<div class="form-group">
					<label for="numCoopsField">Current Program</label>
					<select class="form-control selectpicker" name="numCoops">
						<option value="1">4 Years, 1 Co-op</option>
						<option value="2">5 Years, 3 Co-op</option>
					</select>
				</div>

			</div>

			<div class="<?php echo "$formGroupClass"; ?>">
				<label for="majorField">Major</label>
				<select class="form-control selectpicker" name="major" data-live-search="true" data-size="5">

					<?php
					// Get the list of majors and display for user selection.
					  include_once('connect.php');
					  print_majors();
					  mysql_close($con);

					?>

				</select>
			</div>

			<!-- In the future, will implement the "fast-track" option.
			<div class="form-group row-fluid col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
				<label for="payment">Payment Amount <small>(Optional)</small></label>
				<input type="text" class="form-control" id="payment" name="payment" placeholder="Enter an amount ($5)">
			</div> 
			-->

			<div class="<?php echo "$formGroupClass"; ?>">
				 <div id="errorFree">
				 	<button type="submit" name="submit_form" value="Submit" id="submit_form" class="btn btn-default btn-lg btn-primary">Submit</button>
				 </div>
				<!-- <input type="button" name="submit_form" id="submit_form" value="Submit" /> -->
			</div>
		</form>
		<?php } else { ?>

		<div class="<?php echo "$notFormClass"; ?>"> <!-- Do this better why is it off center idk why are you asking me -->
			<h4>You are already registered, so here are some narwhales playing to fill the space.<br></h4>
			<img src="http://upload.wikimedia.org/wikipedia/commons/5/5c/Narwhals_breach.jpg" width="500" height="318">
		</div>

	<?php } ?>

</div>

<script type="text/javascript">


		// When the page loads, do something I guess
		//var $ = function (id) { return document.getElementById(id); }

		window.onload = function () {
			
			errorDiv = document.getElementById("formError");
			errorDiv.style.display = 'none';
			var errors = 0;
			window.hasEnteredAgain = false;

			window.hasErrors = true; //Start at true so cannot submit blank form.

			window.nameErr = 1;
			window.emailErr = 1;
			window.passwordErr = 1;

			window.errorClassVals = "alert alert-warning";

			//document.getElementById('email').onchange = validate_email;
			//$("submit_form").onclick = validate_data;

		}

		var validate_name = function () {

			name = document.getElementById("user_name").value;
			name = name.trim();

			var nameDiv = document.getElementById("nameError");

			if (name == "")
			{
				nameErr = 1;
				nameDiv.textContent = "You need a name.";
				nameDiv.style.display = '';
				nameDiv.className = window.errorClassVals;
			}
			else
			{
				nameErr = 0;
				//nameDiv.textContent = "Name exists.";
				document.getElementById("user_name").value = name;
				nameDiv.style.display = 'none';
				
				nameTest = name.toLowerCase();

				if (nameTest.indexOf("justin") > -1) {
					nameDiv.style.display = '';
					nameDiv.textContent = "Nice name!";
					nameDiv.className = 'alert alert-success';

					$("#nameError").fadeOut(500);
				}
			}

		}

		var validate_email = function () {

			var emailDiv = document.getElementById("emailError");

			var email = document.getElementById("user_email").value;

			email = email.trim();
			email = email.toLowerCase();

			var drexelEmail = "@drexel.edu";

		 	var hasDrexelEmail = email.search("@drexel.edu");
			var endEmail = email.indexOf("@drexel.edu");

			if (hasDrexelEmail != -1) {
				emailErr = 0;
				//emailDiv.textContent = "Valid email!";
				emailDiv.style.display = 'none';

				var length = endEmail+drexelEmail.length;
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


			}
			else
			{
				emailErr = 1;
				emailDiv.textContent = "That is not a Drexel email!";
				emailDiv.style.display = '';
				emailDiv.className = window.errorClassVals;
			}

			document.getElementById("user_email").value = email;
		}

		var validate_password = function () {

			var password = document.getElementById("user_pass").value;
			var password2 = document.getElementById("user_pass_confirm").value;

			var passwordDiv = document.getElementById("passwordError");

			if (password != password2)
			{
				if (password2 == "" && (hasEnteredAgain == false))
				{
					//alert("Test");
					hasEnteredAgain = true;
					return;
				}

				else
				{
					passwordErr = 1;
					passwordDiv.textContent = "Passwords do not match!";	
					passwordDiv.style.display = '';
					passwordDiv.className = window.errorClassVals;
				}	
			}

			//echo "beep";

			else
			{
				if (password.length < 6 && password.length > 0) 
				{
					passwordDiv.style.display = '';
					passwordDiv.className = window.errorClassVals;
					passwordDiv.textContent = "You should use a longer password.";

				}
				else
				{
					passwordDiv.style.display = 'none';
				}

				passwordErr = 0;
				//passwordDiv.textContent = "Passwords match.";
			}

		}

		var validate_submit = function () {

			errorDiv = document.getElementById("formError");

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
include('footer.php')
?>

<!--

== To Do ==

- Better password security 
- Email account confirmation (if try to login show message need to confirm)
- Better error reportng I guess? Like the error.php page
- Better emails for matches
- Better security I guess
- More db fields (ie. for acct confirmation)
- Etc

- Fast Track

-->