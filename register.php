<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");
include(FUNCTION_PATH . "/connect.php");
$result = mysql_fetch_array($query);

if ($result != 0 || isset($_SESSION['login'])) {
	header('Location: /error.php'); 
	// Make a global "ERROR" variable that also sends to error page to choose which error to display?
}

else {
	// Declare actual variables instead of using "$_POST" everywhere. That gets freaking annoying. I hate PHP.
	$name = test_input($_POST['name']);
	$email = test_input($_POST['email']);
	$password = test_input($_POST['password']);
	$password = md5($password);
	$cycle = test_input($_POST['cycle']);
	$num_year_program = test_input($_POST['numCoops']);
	$majorVal = test_input($_POST['major']);

	$sql="INSERT INTO Users (name, password, email, cycle, num_year_program, major, register_date)
		VALUES ('$name','$password', '$email','$cycle', '$num_year_program', '$majorVal',
				'".date("Y-m-d H:i:s")."'
	 )";

	//$_SESSION['user_name'] = $name; // For when implementing profiles I guess?
	//$_SESSION['user_email'] = $email;

	if (!mysql_query($sql,$con))
	  {
	  	die('Error: ' . mysql_error());
	  }

	else
	  {
		 $query = mysql_query("SELECT major_long FROM Majors WHERE id='$_POST[major]'");
		 $result = mysql_fetch_array($query);
		 $majorName = $result['major_long'];
	  }

}

mysql_close($con)

?>

<br />
<div class="container-fluid">

	<div class="row col-md-6 col-md-offset-3 text-center">
		<div class="panel panel-default">
			<div class="panel-heading">
				<p class="lead">Hi, <?php echo $name; ?>!</p>
			</div>
			<div class="panel-body">
				<p>Your Drexel email address is: <?php echo $email; ?></p>

				<p>
				<?php
					if ($num_year_program == 1)
						echo "You are in the 4 year, 1 co-op program.";
					else
						echo "You are in the 5 year, 3 co-op program";
				?>
				</p>

				<p>
				<?php
					if ($_POST["cycle"] == 1)
						echo "You <strong>want</strong> a Spring-Summer co-op cycle.";
					else
						echo "You <strong>want</strong> a Fall-Winter co-op cycle.";
				?>
				</p>

				<p>
				We need to find other <strong><?php echo "$majorName"; ?></strong> majors!
				</p>
			</div>
		</div>
	</div>
</div>

<?php
require_once(TEMPLATES_PATH . "/footer.php");
?>