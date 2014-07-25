<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");

$rowClass = "col-sm-6 col-sm-offset-3";
?>

<div class="container">

		<div class="row":>
			<div class="<?php echo $rowClass; ?> text-center">
				<ul class="nav nav-tabs nav-justified" role="tablist" id="aboutTabs" data-tabs="tab">
					<li class="active" role="tab" id="infoTab" data-toggle="tab"><a href="#info">Info</a></li>
					<li role="tab" id="contactTab" data-toggle="tab"><a href="#contact">Contact</a></li>
				</ul>
			</div>
		</div>

		<div class="tab-content">

			<div class="tab-pane fade in active" id="info">
				<div class="row">
					<div class="<?php echo $rowClass; ?>">
						<div class="text-center text-primary">
							<h2>What is this website?</h2>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="<?php echo $rowClass; ?>">
						<div class="lead text-center">
							<p>Coopswitch automates the co-op switch process to save Drexel students time.</p>
						</div>
					</div>
				</div>

				<div class="row">	
					<div class="<?php echo $rowClass; ?>">
						<div class="bg-info text-center" style="padding: 20px; font-size: 135%; line-height: 200%;">
							<p>Coopswitch was created to help Drexel students quickly and easily find someone to switch co-op cycles with.</p>
							<br>
							<p>As more people register, the match frequency will be higher.</p>
						</div>
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="contact">

				<div class="row">
					<div class="<?php echo $rowClass; ?>">
						<div class="text-center text-primary">
							<h2>Contact Us</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="<?php echo $rowClass; ?> text-center">
						<p class="lead">Feedback is always appreciated!</p>
					</div>
				</div>

				<div class="row">
					<div class="<?php echo $rowClass ?> text-center">
						<form role="form" iid="emailUs" method="post" action="mailsite.php">

							<div class="row">
				  				<label for="nameField">Name</label>
				  				<input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" onchange="validate(name)">
				  				<span class="help-block error"><div id="errorName"></div></span>
		  					</div>

							<div class="row">
				  				<label for="emailField">Email</label>
				  				<input type="text" class="form-control" id="email" name="email" placeholder="Enter your contact email" onchange="validate(email)">
				  				<span class="help-block error"><div id="errorEmail"></div></span>
		  					</div>

		  					<div class="row">
		  						<label for="reasonField">Subject</label>
		  						<select class="form-control selectpicker" name="subject" title="Please choose a subject">
		  							<option value="Comment">Comment</option>
		  							<option value="Question">Question</option>
		  							<option value="Site Problem">Site Problem</option>
		  							<option value="Advertising">Advertising</option>
		  							<option value="Other">Other</option>
		  						</select>
		  					</div>
		  					<div class="row">
		  						<label for="bodyField">Message</label>
		  						<textarea class="form-control" rows="5" id="message" name="message" placeholder="What would you like to say?"></textarea>
		  					</div>
		  					<div class="row" style="padding-top: 15px;">
		  						<button class="btn btn-lg btn-success" type="submit" value="Submit">Send</button>
		  					</div>
						</form>

					</div>
				</div>

			</div>

		</div>
</div>

<script>
     $('.selectpicker').selectpicker();

	$('#infoTab a').click(function (e) {
		e.preventDefault()
		$(this).tab('show')
	})
	$('#contactTab a').click(function (e) {
		e.preventDefault()
		$(this).tab('show')
	})
</script>

<br>
<?php
require_once(TEMPLATES_PATH . "/footer.php");
?>