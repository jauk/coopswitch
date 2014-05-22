<?php
include('header.php')
?>
	<?php 

	// Some global CSS variables
	$formGroupClass="form-group row-fluid col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3";
	$notFormClass="row-fluid col-md-6 col-md-offset-3 text-center";

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
			
		<div class="<?php echo "$notFormClass"; ?>">
			<span class="error"><strong><div id="formError"></div></strong></span>
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
		
					  $query="SELECT * FROM Majors";
					  $result=mysql_query($query);
					  $numMajors=mysql_num_rows($result);

					  $i=0; while ($i < $numMajors)
					    {
					    	$major_name=mysql_result($result, $i, "major_long");
					    	$major_ident=mysql_result($result, $i, id);

					    	echo "<option value=" . $major_ident . ">" . $major_name . "</option> \n\t\t\t\t\t\t";

					    	$i++;
					    }

					    $major_ident = 0;
					    $major_name = "";

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
			<h4>You are already registered, so here are some narwhales playing.<br></h4>
			<img src="http://upload.wikimedia.org/wikipedia/commons/5/5c/Narwhals_breach.jpg" width="500" height="318">
		</div>

	<?php } ?>

</div>

<script type="text/javascript">


		// When the page loads, do something I guess

		//var $ = function (id) { return document.getElementById(id); }

		window.onload = function () {

			var errors = 0;
			window.hasEnteredAgain = false;

			window.hasErrors = true; //Start at true so cannot submit blank form.

			window.nameErr = 1;
			window.emailErr = 1;
			window.passwordErr = 1;

			//document.getElementById('email').onchange = validate_email;
			//$("submit_form").onclick = validate_data;

		}

		var validate_name = function () {

			name = document.getElementById("user_name").value;
			var nameDiv = document.getElementById("nameError");

			if (name == "")
			{
				nameErr = 1;
				nameDiv.textContent = "You need a name.";
			}
			else
			{
				nameErr = 0;
				nameDiv.textContent = "Name exists.";
			}

		}

		var validate_email = function () {


			email = document.getElementById("user_email").value;

			var testForDrexel = email.search("@drexel.edu");

			var emailDiv = document.getElementById("emailError");

			if (testForDrexel != -1)
			{
				emailErr = 0;
				emailDiv.textContent = "Valid email!";
			}
			else
			{
				emailErr = 1;
				emailDiv.textContent = "That is not a Drexel email!";
			}
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
				}	
			}

			else
			{
				passwordErr = 0;
				passwordDiv.textContent = "Passwords match.";
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

- Form Data Validation / Sanitizing
- Accounts
- Better Matching
- Email Matching
- Fast Track

-->