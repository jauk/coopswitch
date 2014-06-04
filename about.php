<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");
?>

<div class="jumbotron">
	<div class="container-fluid text-center">
		<div class="form-group row col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
			<h2>What is this website?</h2>
		</div>
	</div>
</div>

<div class="container-fluid text-center">
	<div class="form-group row col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">	
		<div class="bg-info well-lg">
			<p>Coopswitch was created to help Drexel students quickly and easily find someone to switch co-op cycles with.
				Drexel requires you to find someone in your major and this can be tough!
			</p>
			<p>Coopswitch allows you to automatically find someone with no hassle! The more people that use it,
				the more effective it will be!
			</p>
		</div>
	</div>
</div>

<?php
require_once(TEMPLATES_PATH . "/footer.php");
?>