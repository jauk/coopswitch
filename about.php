<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");
?>

<div class="container">
	<div class="col-sm-6 col-sm-offset-3">
		<div class="row">
			<div class="text-center text-primary">
				<h2>What is this website?</h2>
			</div>
		</div>

		<div class="row">
			<div class="lead text-center">
				<p>Coopswitch automates the co-op switch process to save Drexel students time.</p>
			</div>
		</div>

		<div class="row">	
			<div class="bg-info text-center" style="padding: 20px; font-size: 135%; line-height: 200%;">
				<p>Coopswitch was created to help Drexel students quickly and easily find someone to switch co-op cycles with.</p>
				<br>
				<p>As more people register, the match frequency will be higher.</p>
			</div>
		</div>
	</div>
</div>

<!-- Add Contact Form -->

<br>
<?php
require_once(TEMPLATES_PATH . "/footer.php");
?>