 <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
    require_once(TEMPLATES_PATH . "/header.php");

    $msg = "";
    $error = "";

    if (isset($_GET['msg'])) {
      
      $msg = test_input($_GET['msg']);
        
      switch ($msg):
        case 1:
            $error = "Invalid email.";
            break;
        case 2:
            $error = "Invalid login.";
            break;
        case 3:
            $error = "No data sent.";
            break;
        case 4:
            $error = "Already logged in.";
            break;
        default:
            $error = "Unknown error.";
            break;
      endswitch;
      
    }
    else {
        $msg = "none";
        $error = "";
    }

    if (isset($_GET['action'])) {

        $action = test_input($_GET['action']);
    }
    else {
        $action = "none";
    }

?>
<div class="container-fluid">
	<div class="row col-md-6 col-md-offset-3 text-center">

		<p class="lead"> <?php echo "$error"; ?> </p>
			<br>
		<!-- <p>Please try again.</p> -->
        
        <?php if ($msg == 2) { ?>
            <br>
            <h4>Forgot your password?</h4>
            <a href="#"><button data-toggle="modal" data-target="#restPassModal" class="btn btn-info btn-lg" onclick="resetPassword()">Reset Password</button></a>
        <?php } ?>
	
	</div>
</div>

<div class="modal fade" id="restPassModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Reset Password</h2>
            </div>
            <div id="submitEmail" class="modal-body">
                <p class="lead">Please enter your email address.</p>
                <p id="isValidEmail" class="text-warning lead" style="display: none;">That is not a valid email.</p>
                <form id="resetForm" role="form" method="post" action="resetpass" onsubmit="return validateInput()">
                    <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                </form>
            </div>
            <div id="emailSubmitted" class="modal-body">
                <p class="lead">Email sent.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="goHome()">Close</button>
                <button id="submitBtn" type="submit" form="resetForm" class="btn btn-primary">Reset</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    window.onload = function () {

        id("emailSubmitted").style.display = 'none';
        
        message = "<?php echo $msg; ?>";
        action = "<?php echo $action; ?>";

        if (action == "resetsent") {

            $('#restPassModal').modal('show');
            id("submitEmail").style.display='none';
            id("emailSubmitted").style.display = '';
            id("submitBtn").style.display = 'none';

        }

    }


    resetPassword = function () {
        id("submitEmail").style.display = '';
        id("emailSubmitted").style.display = 'none';
        id("submitBtn").style.display = '';
    }

    goHome = function () {
        window.location.href = 'index.php';
    }

    validateInput = function () {

        // email = id("email").value;

        // email = email.trim();
        // email = email.toLowerCase();

        // var drexelEmail = "@drexel.edu";

        // var hasDrexelEmail = email.search("@drexel.edu");
        // var endEmail = email.indexOf("@drexel.edu");

        // if (hasDrexelEmail != -1) {

        //     var length = endEmail + drexelEmail.length;

        //     if (length != email.length) {

        //         emailRemove = email.slice(length, email.length);
        //         email = email.replace(emailRemove, "");
        //     }

        //     id("isValidEmail").style.display = 'none';
        //     alert("Test");
        //     return true;
        // }
        // else {
        //     id("email").value = "Not valid."
        // }

        // id("email").value = email;
        // id("isValidEmail").style.display = '';

        // return false;
    }




</script>

<?php
require_once(TEMPLATES_PATH . "/footer.php");
?>


<!-- 

For pass reset, ajax to submit stuff and 
use ajax to go back to same page, with message saying email sent?

 -->