<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");
//include('header.php');

// Some global CSS variables. Need to fix these names.
$formGroupClass="form-group row-fluid col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3";

$notFormClass="row-fluid col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 text-center";
$otherClassMaybe="row-fluid col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 text-center";

$pageName = "Test";


?>

<div class="container-fluid">

<!-- <hr>
 -->
	<?php if (!isset($_SESSION['login'])) { // if ($_SESSION['login'] == "") { ?>

		<div class="row col-md-6 col-md-offset-3 text-center">
			<p class="lead">
				Find someone to trade co-op cycles with!
			</p>
		</div>

		<div class="<?php echo "$otherClassMaybe"; ?>">
			<img src="http://ak1.picdn.net/shutterstock/videos/2365601/preview/stock-footage-happy-friends-laughing-in-front-of-a-laptop-in-a-bright-living-room.jpg" 
				 class="img-responsive img-rounded center-block" max-width: 100%; height: auto;>
			<!-- <div class="caption">Friends having fun on Coopswitch.</div>  -->
	 	<br><br>	
		</div>

		<div class="row col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 text-center well">
			<h4>Registration Form</h4>
			<p>This is currently for <em>Drexel Freshman</em> only.</p>
		</div>
		<br>
			
		<!-- Print out if there is an error with the form data. Right now it is just a universal one. Needs CSS formatting. -->
		<div class="row col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 text-center">
			<span class="error">
				<strong><div class="alert alert-warning" id="formError"></div></strong>
			</span>
		</div>


		<br><br>
		<!-- Registration Form -->
		<form role="form" id="register" method="post" action="register.php" onchange="" onsubmit="return validate_submit();" id="register">

			<div id="mainNameDiv" class="<?php echo "$formGroupClass"; ?>">
				<label for="nameField">Name</label>
				<input type="text" class="form-control" id="user_name" name="name" placeholder="Enter your name" onchange="validate_name()">
				<span class="help-block error"><div id="nameError"></div></span>
			</div>

			<div id="mainEmailDiv" class="<?php echo "$formGroupClass"; ?>">
				<label for="emailField">Email</label> 
				<input type="text" class="form-control" id="user_email" name="email" placeholder="Enter your Drexel email" onchange="validate_email()">
				<span class="help-block error"><div id="emailError"></div></span>					
			</div>

			<div id="mainPasswordDiv" class="<?php echo "$formGroupClass"; ?>">
				<label for="passwordField">Password<small><br /><em>Do not use your Drexel One password.</em></small></label> 
				<input type="password" class="form-control" id="user_pass" name="password" placeholder="Enter a password" onchange="validate_password()">
				<br><input type="password" class="form-control" id="user_pass_confirm" name="password2" placeholder="Confirm password" onchange="validate_password()">
				<span class="help-block error"><div id="passwordError"></div></span>
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
				<label for="cycleField">Current Cycle</label>
				<select class="form-control selectpicker" id="cycle" name="cycle">
					<option value="1">Fall-Winter</option>
					<option value="2">Spring-Summer</option>
				</select>
			</div>

			<div class="<?php echo "$formGroupClass"; ?>">
				<label for="numCoopsField">Current Program</label>
				<select class="form-control selectpicker" name="numCoops">
					<option value="1">4 Years, 1 Co-op</option>
					<option value="2">5 Years, 3 Co-op</option>
				</select>
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

			<div class="<?php echo "$formGroupClass"; ?> text-center">
				 <div id="errorFree">
				 	<button type="submit" name="submit_form" value="Submit" id="submit_form" class="btn btn-block btn-default btn-lg btn-primary">Register</button>
				 </div>
				<!-- <input type="button" name="submit_form" id="submit_form" value="Submit" /> -->
			</div>
		</form>
		<?php } else { 

			// Move this to scripts later 
		
				$images = array(
				"http://upload.wikimedia.org/wikipedia/commons/5/5c/Narwhals_breach.jpg",
				"http://www.graphics99.com/wp-content/uploads/2012/07/funny-giraffe-tongue-image-for-friendster.jpg",
				"http://www.funnyzone.org/wp-content/uploads/2009/06/635_bear-and-panda.jpg",
				"http://twistedsifter.files.wordpress.com/2012/05/funny-baby-elephant-4.jpg",
					);

				$descriptions = array (
					"Here are some narwhals playing.",
					"Here is a silly giraffe.", // Her favorite animal is giraffes.
					"Here is a group of penguins.",
					"Here is an elephant playing soccer.",
					);

				$option = rand(0, 3);
			?>


		<div class="row-fluid col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 text-center">
			<h4>You are already registered.
			<?php echo "$descriptions[$option]"; ?>
			<br></h4>
			<img src="<?php echo $images[$option]; ?>" max-width: 100%; height: auto; class="img-responsive img-circle center-block">
		</div>

	<?php } ?>

<!--  so here are some narwhals playing to fill the space. -->
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

			window.mainDivClass = "<?php echo $formGroupClass; ?>";
			window.mainDivClassError = mainDivClass + " has-error";
			window.mainDivClassValid = mainDivClass + " has-success";
			window.mainDivClassWarning = mainDivClass + " has-warning";


			//document.getElementById('email').onchange = validate_email;
			//$("submit_form").onclick = validate_data;

		}

		var validate_name = function () {

			name = document.getElementById("user_name").value;
			mainNameDiv = document.getElementById("mainNameDiv");

			name = name.trim();

			var nameDiv = document.getElementById("nameError");
			//var mainNameDiv = document.getElementById("mainNameDiv");

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
				document.getElementById("user_name").value = name;
				nameDiv.style.display = 'none';

				mainNameDiv.className = window.mainDivClassValid;
				
				//nameTest = name.toLowerCase();
				// if (nameTest.indexOf("justin") > -1) {
				// 	nameDiv.style.display = '';
				// 	nameDiv.textContent = "Nice name!";
				// 	nameDiv.className = 'alert alert-success';

				// 	$("#nameError").fadeOut(500);
				// }
			}

		}

		var validate_email = function () {

			var emailDiv = document.getElementById("emailError");
			var mainEmailDiv = document.getElementById("mainEmailDiv");

			var email = document.getElementById("user_email").value;

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

				mainEmailDiv.className = window.mainDivClassValid;
			}
			else
			{
				emailErr = 1;
				emailDiv.textContent = "That is not a Drexel email!";
				emailDiv.style.display = '';
				emailDiv.className = window.errorClassVals;
				mainEmailDiv.className = window.mainDivClassError;
			}

			document.getElementById("user_email").value = email;
		}

		var validate_password = function () {

			var password = document.getElementById("user_pass").value;
			var password2 = document.getElementById("user_pass_confirm").value;

			var passwordDiv = document.getElementById("passwordError");
			var mainPasswordDiv = document.getElementById("mainPasswordDiv");

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


-->