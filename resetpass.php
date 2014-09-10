
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");
include_once(FUNCTION_PATH . "/connect.php");

$baseUrl =  "https://" . $_SERVER['SERVER_NAME'] . "/resetpass?token=";

if (isset($_POST['email']) && $_POST['email'] != "") {
	
	$email = test_input($_POST['email']);

	$sql = 'SELECT * FROM Users WHERE email = "'.$email.'"';
	$result = mysql_query($sql);

	if (!$result || mysql_num_rows($result) != 1) {
		die("User not found.");
	}

	else {
		$row = mysql_fetch_assoc($result);

		$id = $row['id'];
		$name = $row['name'];

		mysql_free_result($result);

		$requestTime = time();
		$token = uniqid();

		$sql = "INSERT INTO PasswordResets (token, id, request_time) VALUES ('$token', '$id', '$requestTime')";

		if (!mysql_query($sql,$con)) {
		  	die('Error: ' . mysql_error());
		}
		else {

			$resetLink = $baseUrl . $token;
			reset_pass_email($name, $email, $resetLink);

			header("Location: /error?action=resetsent");
		}

	}

}

else if (isset($_POST['password']) && $_POST['password'] != "" && isset($_POST['password2']) && $_POST['password2'] != "" && isset($_POST['token']) && $_POST['token'] != "") {

	$password = test_input($_POST['password']);
	$password2 = test_input($_POST['password2']);

	$token = test_input($_POST['token']);

	if ($password == $password2) {
		$password = sha1($password);

		// Get the id of the user using token
		$sql = 'SELECT id FROM PasswordResets WHERE token = "'.$token.'"';
		$id = mysql_get_var($sql);

		$sql = 'UPDATE Users SET password = "'.$password.'" WHERE id = "'.$id.'"';
		$result = mysql_query($sql);

		if (!$result) {
			die("Password reset failed. Please contact an admin.");
		}
		else {

			// Delete the password reset from database
			$sql = 'DELETE FROM PasswordResets WHERE token = "'.$token.'"';
			$result = mysql_query($sql);

			die("Password reset success.");
		}

	}
	else {
		die("Passwords not equal.");
	}
}

else if (isset($_GET['token']) && $_GET['token'] != "") {

	$time = time();

	$token = test_input($_GET['token']);

	$sql = 'SELECT id FROM PasswordResets WHERE token = "'.$token.'"';
	$userId = mysql_get_var($sql);

	if ($userId != "") {

		$sql = 'SELECT request_time FROM PasswordResets WHERE token = "'.$token.'"';
		$requestTime = mysql_get_var($sql);

		// Make sure user is resetting within alloted time (one day).
		if ($time < strtotime('+1 day', $requestTime)) { ?>

		
			<div class="container">
				<div class="row text-center">
					<h2>Password Reset</h2> <br />

					<form class="form-horizontal" role="form" id="resetpasword" method="post" action="resetpass.php" onsubmit="return validate();">

			  			<div id="passwordDiv" class="form-group has-feedback">
			  				<label for="passwordField"></label>
			  				<div class="col-sm-8 col-sm-offset-2">
			  					<span class="help-block error"><div id="passwordError"><p class="alert text-info bg-info">Do not use your Drexel One password.</p></div></span>
							</div>	
			  				<div class="col-sm-8 col-sm-offset-2">
			  					<input type="password" class="form-control input-lg" id="user_pass" name="password" placeholder="Enter a password" onchange="validate_password()">
				  				<input type="password" class="form-control input-lg" id="user_pass_confirm" name="password2" placeholder="Confirm password" onchange="passwordConfirm()">
			 	  				<span id="passwordFeedback" class="glyphicon form-control-feedback"></span> 				
			  				</div>				
		  				</div>

		  				<input type="hidden" name="token" value="<?php echo $token; ?>">

		  				<div id="submit" class="form-group">
		  					<button id="submitReset" class="btn btn-info btn-lg">Submit</button>
		  				</div>


	  				</form>

				</div>
			</div>


 <?php }
		
		else {

			die("Expired token, please re-request email.");
		}

	}

	else {
		// Invalid token
		die("Invalid request.");
	}


}

else {
	header("Location: /");
}

mysql_close($con);

// header("Location: error.php?action=resetsent");

?>

<script>

	var errors = { password: 0 }; 

	var validate = function() { 

		//validate_password();
		var canSubmit = validate_password();

		if (canSubmit == 0 && id("user_pass_confirm").value != "") {

			console.log("Okay to submit.");
			return true;
		}

		return false;

	}

	var validate_form = function() {}

</script>