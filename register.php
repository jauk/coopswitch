<?php
include('header.php')
?>

<?php

include_once('connect.php');

$query = mysql_query("SELECT * FROM Users WHERE email = '$_POST[email]'");
$result = mysql_fetch_array($query);

function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

if ($result != 0)
{
	header('Location: error.php'); 
	// Make a global "ERROR" variable that also sends to error page to choose which error to display?
}

else
{
	$name = test_input($_POST[name]);
	$email = test_input($_POST[email]);

	$sql="INSERT INTO Users (name, email, cycle, major, register_date, num_year_program)
		VALUES ('$name','$email',
				'$_POST[cycle]','$_POST[major]',
				'".date("Y-m-d H:i:s")."','$_POST[numCoops]'
	 )";

	$_SERVER['user'] = $_POST['email'];

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

			<!--
			<p>
			Your cycle is <?php echo $_POST["cycle"]; ?>
			</p> 
			-->

				<p>
				<?php
					if ($_POST["cycle"] == 1)
						echo "You <strong>want</strong> a Spring-Summer co-op cycle.";
					else
						echo "You <strong>want</strong> a Fall-Winter co-op cycle.";
				?>
				</p>

				<p>
				We need to find other <strong><?php echo "$majorName"; ?></strong> majors who
				are willing to trade co-op cycles!
				</p>
			</div>
		</div>
	</div>
</div>

<?php
include('footer.php')
?>