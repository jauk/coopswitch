// Shorthand for getting elements
function id(input) {

	output = document.getElementById(input);
	return output;
}

var setError = function(fieldMainDiv, fieldErrorDiv, fieldFeedbackDiv, errorMessage) {

	var mainDiv = fieldMainDiv;
	var errorDiv = fieldErrorDiv;

	if (fieldFeedbackDiv != "") {
		var feedbackDiv = fieldFeedbackDiv;
		feedbackDiv.className = window.feedbackError;
	}

	var error = errorMessage;

	errorDiv.textContent = error;
	errorDiv.style.display = '';
	errorDiv.className = window.errorClassVals;

	mainDiv.className = "form-group has-feedback has-error";

}

var removeError = function(fieldMainDiv, fieldErrorDiv, fieldFeedbackDiv) {

	var mainDiv = fieldMainDiv;
	var errorDiv = fieldErrorDiv;

	if (fieldFeedbackDiv != "") {
		var feedbackDiv = fieldFeedbackDiv;
		feedbackDiv.className = window.feedbackSuccess;
	}

	mainDiv.className = "form-group has-feedback has-success";

 	errorDiv.style.display = 'none';

}

var validate_password = function () {

	var password = id("user_pass").value;
	var password2 = id("user_pass_confirm").value;

	var passwordErrorDiv = id("passwordError");
	//var passwordErrorDiv = "";
	var passwordDiv = id("passwordDiv");
	var passwordFeedback = id("passwordFeedback");

	if (password == "" || (password2 == "" && window.hasEnteredAgain)) {

		errors.password = 1;
		error = "You need a password.";
		setError(passwordDiv, passwordErrorDiv, passwordFeedback, error);	
		// console.log("This first if");
	}

	else if ((password != password2) && window.hasEnteredAgain) {

		// if (password2 == "" && !window.hasEnteredAgain) {
		// 	window.hasEnteredAgain = true;
		// }

		// else {
			errors.password = 1;

			error = "Passwords do not match.";
			setError(passwordDiv, passwordErrorDiv, passwordFeedback, error);

			console.log(error);
//		}

	}

	else {

		if (password.length < 6 && password.length > 0) {

		 	passwordErrorDiv.style.display = '';
		 	passwordErrorDiv.className = 'alert text-warning bg-warning';
			// passwordErrorDiv.className = window.errorClassVals;
			passwordErrorDiv.textContent = "You should use a longer password.";

			passwordDiv.className = "form-group has-feedback has-warning";
			passwordFeedback.className = window.feedbackWarning;
			console.log("Pass warning. (Length)");
		}

		else {
			removeError(passwordDiv, passwordErrorDiv, passwordFeedback);
		}

		errors.password = 0;
	}

	return errors.password;
	validate_form();

}

var passwordConfirm = function () {

	window.hasEnteredAgain = true;
	console.log("Password 2 entered.");

	validate_password();
}