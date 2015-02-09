<?php

function display_search_result($teachers, $courses)
{	
?>
		<div id="search_result_div">
		<table id="search_result_table">
		<tr><td colspan="5">Search Result</td></tr>
		<tr><td>Teacher</td><td>Course</td><td>Semester</td><td>Vote number</td><td>Average rating</td></tr>
		<?php
			if(isset($teachers) && !empty($teachers))
			{
				$records = get_teachercourse($teachers);	
			}
			else if(isset($courses) && !empty($courses))
			{
				$records = get_courseteacher($courses);
			}
			foreach($records as $row)
			{
				echo "<tr>";
				echo '<td>'.$row['TEACHERNAME'].'</td>';
				echo '<td>'.$row['COURSENAME'].'</td>';
				echo '<td>'.$row['SEMESTER'].'</td>';
				echo '<td>'.$row['VOTENUM'].'</td>';
				echo '<td>'.$row['AVGRATING'].'</td>';
				echo "</tr>";
			}
		?>
		</table>
		</div>
<?php
}
?>
