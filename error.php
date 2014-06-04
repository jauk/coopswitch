<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");

if (isset($_GET['msg']))
  $msg = test_input($_GET['msg']);

?>

<div class="container-fluid">
	<div class="row col-md-6 col-md-offset-3 text-center">

		<?php 

		if (isset($msg)) {
			if ($msg == 1) { 
				$error="Invalid email.";
			}
			else {
				$error = "Unknown error!";
			}
		}
		else { 
			$error = "Generic error!";
		}

		?>

		<p class="lead"> <?php echo "$error"; ?> </p>
			<br> 
		<p>Please try again.</p>
	
	</div>
</div>

<?php
require_once(TEMPLATES_PATH . "/footer.php");
?>