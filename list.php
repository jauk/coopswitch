<?php
include('header.php')
?>

<br />
<div class="container-fluid">

	<div class="row col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 text-center">
		<table class="table table-striped">
			<tr><td><strong>Name<small>*</small></strong></td>
				<td><strong>Cycle</strong></td>
				<td><strong>Major</strong></td>
				<td><strong>Matched?</strong></td>
			</tr>

		<?php

			include_once('connect.php');

			if (!isset($_GET['startrow']) or !is_numeric($_GET['startrow'])) {
				$startrow=0;
			}
			else {
				$startrow = (int)$_GET['startrow'];
			}

			$numRows=mysql_numrows(mysql_query("SELECT * FROM Users"));

			$query="SELECT * FROM Users LIMIT $startrow,10";
			$result=mysql_query($query);
			$num=mysql_numrows($result);

			$i=0; while ($i < $num) 
			  {
				$name=mysql_result($result, $i,"name");
				$cycle=mysql_result($result, $i, "cycle");
				$major=mysql_result($result, $i, "major");

				$majorName=mysql_fetch_assoc(mysql_query("SELECT major_long FROM Majors WHERE id=$major"));
				//echo $majorName["major_long"];

				$isMatched=mysql_result($result, $i, "matched");

				echo "<tr>";

				// echo "<td>$name</td>";
				echo "<td>" . rand(1,99) . "</td>";

				if ($cycle == 1)
				  echo "<td>Fall-Winter</td>";
				else
				  echo "<td>Spring-Summer</td>";

				echo "<td>$majorName[major_long]</td>";

				echo "<td>";
				if ($isMatched == 1)
				  echo "Yes";
				else
					echo "No";
				echo "</td>";

				echo "</tr>";

				$i++;
			  }

			echo "</table>";

			echo '<div class="btn-group">';

			if ($startrow > 0)
			  echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.($startrow-10).'" <button type="button" class="btn btn-default">Previous</button></a>';
			if ($startrow+10 < $numRows)
			  echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.($startrow+10).'" <button type="button" class="btn btn-default">Next</button></a>';

			echo '</div>';

			mysql_close($con);

		?>
			<br /><br />

	</div>

	<div class="row col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 text-center well">
		<p>*I am aware that the name field just shows random numbers. This is because
			the actual site will be completely private and only connect you once a match
			has been made. </p>
	</div>

</div>

<?php
include('footer.php')
?>