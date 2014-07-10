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
      $error = "No error set.";
    }

?>
<div class="container-fluid">
	<div class="row col-md-6 col-md-offset-3 text-center">

		<p class="lead"> <?php echo "$error"; ?> </p>
			<br>
		<p>Please try again.</p>
        
        <?php if ($msg == 2) { ?>
            <br>
            <h4>Forgot your password?</h4>
            <a href="#"><button class="btn btn-info btn-lg">Reset Password</button></a>
        <?php } ?>
	
	</div>
</div>

<?php
require_once(TEMPLATES_PATH . "/footer.php");
?>