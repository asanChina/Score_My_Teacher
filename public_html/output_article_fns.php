<?php

function display_articles($articles)
{	
	if(isset($_SESSION['admin']))
		echo "<form name='articlelist' action='delete_article.php' method='post'>";
?>
		<table id="articlelistform">
		<?php
			$color = "#cccccc";
			echo "<tr bgcolor='$color' width='5px'><td><strong>Articles</strong></td>";
			if(isset($_SESSION['admin']))
				echo "<td bgcolor='ffffff' colspan='4' align='right'><a href='#' onClick='articlelist.submit();'>Delete invalid articles</a></td>";
			echo "</tr>";
			echo "<tr bgcolor='#ff5621'>";
			if(isset($_SESSION['admin']))
				echo "<td width='5px'><strong>Delete?</strong></td>";
			echo "<td id='firstcol'>Title</td><td id='secondcol'>Author</td><td id='thirdcol'>Post Date</td><td id='fourthcol'>like/dislike</td>";
			foreach( $articles as $row)
			{
				// remember to call htmlspecialchars() when we are displaying user data					
				echo '<tr class="articlelist_tr">';
				$urlstring = "article_detail.php?username=".$row['USERNAME']."&teachername=".$row['TEACHERNAME']."&coursename=".$row['COURSENAME']."&articleid=".$row['ARTICLEID']."&overallrating=".$row['OVERALLRATING']."&articletitle=".$row['ARTICLETITLE'];
				//$urlstring = htmlspecialchars($urlstring);
				if(isset($_SESSION['admin']))
					echo "<td width='5px'><input type='checkbox' name=\"del_me[]\" value='".$row['ARTICLEID']."'></td>";
				echo "<td><a href ='".$urlstring."'>".$row['ARTICLETITLE']."</a></td>";
				echo "<td>".$row['USERNAME']."</td>";
				echo "<td>".$row['ARTICLEDATE']."</td>";
				echo "<td>".$row['LIKENUM']."/".$row['DISLIKENUM']."</td>";
				echo "</tr>"; 
			}
		?>
  		</table> 
<?php
		if(isset($_SESSION['admin']))
			echo "</form>";
}

function display_article_detail($username, $teachername, $coursename, $articleid, $overallrating)
{
	$articlecomment = get_articlebody($articleid);
	$reply = get_articlereply($articleid);
	if(isset($_SESSION['admin']))
		echo "<form name='articlereply' action='delete_reply.php' method='post'>";
?>
		<table id="articledetail">
		<?php
			$color = "#cccccc";
			echo "<tr bgcolor='$color'><td><strong>Article Details</strong></td>";
			if(isset($_SESSION['admin']))
				echo "<td bgcolor='ffffff' colspan='2' align='right'><a href='#' onClick='articlereply.submit();'>Delete invalid reply</a></td>";
			echo "</tr>";
			echo "<tr id='firstrow'>";
			if(isset($_SESSION['admin']))
				echo "<td width='5px'><strong>Delete?</strong></td>";
			echo "<td>Author</td><td>Details</td></tr>";
			echo "<tr id='secondrow'>";
			if(isset($_SESSION['admin']))
				echo "<td></td>";
			echo "<td class='firstcol'>".$username."</td>";
			echo "<td>I score ".$teachername."+".$coursename." ".$overallrating;
			echo "<br />";				
			foreach($articlecomment as $single)
			{
				echo $single['ARTICLECOMMENT'];
			}
			echo "</tr>";
			foreach($reply as $single)
			{
				if($color == "#cccccc")
					$color = "ffffff";
				else
					$color = "cccccc";
				echo "<tr bgcolor=".$color.">";
				if(isset($_SESSION['admin']))
					echo "<td width='5px'><input type='checkbox' name=\"del_me[]\" value='".$single['REPLYID']."'></td>";
				echo "<td class='firstcol'>".$single['AUTHOR']."</td>";
				echo "<td>".$single['REPLYCOMMENT']."</td>";
				echo "</tr>";
			}	
		?>
  		</table> 
<?php
	if(isset($_SESSION['admin']))
		echo "</form>";
}
?>
