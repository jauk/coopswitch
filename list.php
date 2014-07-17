<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php");
include_once(FUNCTION_PATH . "/connect.php");
?>

<br />
<div class="container">

	<div class="row">
		<div class="col-sm-10 col-sm-offset-1 text-center">

			<p>This page needs to be updated and made more efficient.</p><hr><br> 

			<table class="table table-striped">
				<tr>
					<td><strong>User</strong></td>
					<td><strong>Cycle</strong></td>
					<td><strong>Major</strong></td>
					<td><strong>Program</strong></td>
					<td><strong>Switched</strong></td>
				</tr>

			<?php


				if (!isset($_GET['startrow']) or !is_numeric($_GET['startrow'])) {
					$startrow=0;
				}
				else {
					$startrow = (int)$_GET['startrow'];
				}
				if (!isset($_GET['sort']) or !is_numeric($_GET['sort'])) {
					$sort = "id";
				}
				else {
					$sort = test_input($_GET['sort']);
				}

				$numRows=mysql_num_rows(mysql_query("SELECT * FROM Users"));

				$query="SELECT * FROM Users LIMIT $startrow, 10";
				$result=mysql_query($query);

				$num=mysql_num_rows($result);

				$user = array();
				$i = 0;

				while ($row = mysql_fetch_array($result)) {
					$user[$i] = $row;
					$user[$i]['majorName'] = mysql_get_var("SELECT major_long FROM Majors WHERE id = " . $user[$i]['major']);
					
					$i++;

					// How to sort php arrays?
				}

				for ($i = 0; $i < $num; $i++) {

					echo "<tr>\n";

					// Random number instead of name
					echo "<td>" . ($startrow+$i+1) . "</td>";

					// Co-op cycle
					if ($user[$i]['cycle'] == 1) {
					  echo "\t<td>Fall-Winter</td>\n";
					}
					else {
					  echo "\t<td>Spring-Summer</td>\n";
					}

					// Major 
					echo "\t<td>" . $user[$i]['majorName'] . "</td>\n";

					// Number of co-ops
					if ($user[$i]['num_year_program'] == 1) {
						echo "\t<td>1 co-op (4yr)</td>\n";
					}
					else {	
						echo "\t<td>3 co-ops (5yr)</td>\n";
					}

					// Do they have a match
					if ($user[$i]['matched'] == 1) {
						echo "\t<td>Yes</td>\n";
					}
					else {
						echo "\t<td>No</td>\n";
					}
				
					echo "</tr>\n";
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
	</div>

	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 text-center">
			<p>*Names have been removed for user privacy.</p>
		</div>
	</div>

</div>

<?php
require_once(TEMPLATES_PATH . "/footer.php");
?>