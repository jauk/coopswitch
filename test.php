<script type="text/javascript">

var notEmpty = function () {
	var myTextField = document.getElementById("myText");
	alert(myTextField.value);
	
}

</script>

<form role="form" id="register" method="post" action="" onchange="" onsubmit="this.action=validate_submit()" id="register">
	<div class="form-group row-fluid col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
		<input type="password" class="hi" name="myText" id="myText" value="test" onchange="notEmpty()" />
	</div>
</form>