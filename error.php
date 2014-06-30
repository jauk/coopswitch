 <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
    require_once(TEMPLATES_PATH . "/header.php");

    if (isset($_GET['msg'])) {
      
      $msg = test_input($_GET['msg']);
        
      switch ($msg):
        case 1:
            $error = "Invalid email.";
            break;
        case 2:
            $error = "Invalid login.";
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
	
	</div>
</div>

<?php
require_once(TEMPLATES_PATH . "/footer.php");
?>