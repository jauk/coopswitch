<?php
include('header.php')
?>
	<div class="container-fluid">
		<div class="row col-md-6 col-md-offset-3 text-center">
			<p class="lead">
				Find someone to trade co-op cycles with!
			</p>
		</div>

		<?php 

		$name = $nameErr = $email = $emailErr = $cycle = $cycleErr = $major = $majorErr  = $numCoops = "";

		$formMainClass="form-group row-fluid col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3";
		$formGroupClass="form-group row-fluid col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3";
		// if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
		// 	if (empty($_POST["name"])) {
		// 		$nameErr = "Missing";
		// 	}
		// 	else {
		// 		$name = $_POST["name"];
		// 	}

		// 	if (empty($_POST["email"])) {
		// 		$emailErr = "Missing";
		// 	}
		// 	else {
		// 		$email = $_POST["email"];
		// 	}

		// }

		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		?>

		

		<div class="row col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 text-center well">
			<h4>Registration Form</h4>
			<p>This is currently for <em>Freshman</em> only.</p>
		</div>


		<div class="<?php echo "$formMainClass"; ?>">
		
		<span class="error"><div id="formError"></div></span>

			<form role="form" id="register" method="post" action="" onchange="" onsubmit="return validate_submit()" id="register">
<!--			<form role="form" method="post" action="register.php" id="register"> 			-->
				<div class="<?php echo "$formGroupClass"; ?>">
					<label for="nameField">Name</label>
					<input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" onchange="validate_name()">
					<span class="error"> <?php echo "$nameErr"; ?> </span>
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

						<?php // Get the list of majors and display for user selection.

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
				<!--
				<div class="form-group row-fluid col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
					<label for="payment">Payment Amount <small>(Optional)</small></label>
					<input type="text" class="form-control" id="payment" name="payment" placeholder="Enter an amount ($5)">
				</div> -->
				<div class="form-group row-fluid col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
					 <div id="errorFree">
					 	<button type="submit" name="submit_form" value="Submit" id="submit_form" class="btn btn-default btn-lg btn-primary">Submit</button>
					 </div>
					<!-- <input type="button" name="submit_form" id="submit_form" value="Submit" /> -->
				</div>
			</form>
		</div>
	</div>

<?php

/* Lets try validation via javascript?
if (isset($_POST["submit"])) {


	echo 'User submitted.<br />';
	echo 'Name: ' . test_input($name) . '<br />';
	echo 'Email: ' . $email . '<br />';
	echo 'Cycle: ' . $cycle . '<br />';
	echo 'Major: ' . $major_ident . '';
}
*/
?>

<script type="text/javascript">


		// When the page loads, do something I guess

		//var $ = function (id) { return document.getElementById(id); }

		window.onload = function () {

			var errors = 0;
			window.hasEnteredAgain = false;

			window.hasErrors = true; //Start at true so cannot submit blank form.

			window.nameErr = 0;
			window.emailErr = 0;
			window.passwordErr = 0;

			//document.getElementById('email').onchange = validate_email;
			//$("submit_form").onclick = validate_data;

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

			//alert(hasEnteredAgain);


			// Boolean does not work right now.


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
				//errorDiv.textContent = "No problems!";
				return "register.php";
			}
			
			else if (hasErrors == true)
			{
				errorDiv.textContent = "Hey, you have a problem!";
				//alert("You need to fix something!")
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