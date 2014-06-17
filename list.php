<?php
include('header.php')
?>

<br />
<div class="container-fluid">

	<div class="row col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 text-center">

		<p>This page needs to be updated and made more efficient.</p><hr><br> 
		<!-- Manage user data in one big array like other pages. (check) -->

		<table class="table table-striped">
			<tr><td><strong>Name<small>*</small></strong></td>
				<td><strong>Cycle</strong></td>
				<td><strong>Major</strong></td>
				<td><strong>Number Co-ops</strong></td>
				<td><strong>Matched?</strong></td>
			</tr>

		<?php

			include(FUNCTION_PATH . "/connect.php");

			if (!isset($_GET['startrow']) or !is_numeric($_GET['startrow'])) {
				$startrow=0;
			}
			else {
				$startrow = (int)$_GET['startrow'];
			}

			$numRows=mysql_num_rows(mysql_query("SELECT * FROM Users"));

			$query="SELECT * FROM Users LIMIT $startrow,10";
			$result=mysql_query($query);
			$num=mysql_num_rows($result);

			$i=0; while ($i < $num) 
			{
			  	$user_info = array();

				$name=mysql_result($result, $i,"name");
				$cycle=mysql_result($result, $i, "cycle");
				$major=mysql_result($result, $i, "major");
				$numCoops=mysql_result($result, $i, "num_year_program");

				$majorName=mysql_fetch_assoc(mysql_query("SELECT major_long FROM Majors WHERE id=$major"));
				//echo $majorName["major_long"];

				$isMatched=mysql_result($result, $i, "matched");

				echo "<tr>\n";

				// Random number instead of name
				echo "\t<td>" . rand(1,99) . "</td>\n";

				// Co-op cycle
				if ($cycle == 1)
				  echo "\t<td>Fall-Winter</td>\n";
				else
				  echo "\t<td>Spring-Summer</td>\n";

				// Major 
				echo "\t<td>$majorName[major_long]</td>\n";

				// Number of co-ops
				if ($numCoops == 1)
					echo "\t<td>1 co-op (4yr)</td>\n";
				else
					echo "\t<td>3 co-ops (5yr)</td>\n";

				// Do they have a match
				echo "\t<td>\n";
				if ($isMatched == 1)
				  echo "Yes";
				else
					echo "No";
				echo "\t</td>\n";

				echo "</tr>\n";

				$i++;
			}

		?>

		</table>

		<div class="btn-group">

			<?php

				// Buttons for switching the page of people if you are really that interested
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