#!/usr/local/bin/php
<?php
	require_once('forum_fns.php');
	$v = $_POST['value'];
	$conn = db_connect();
	$statement = oci_parse($conn, "select coursename from forumcourse where upper(coursename) like upper('%$v%')");
	$result = oci_execute($statement);
	if(!$result)
		throw new Exception('Error in executiing auto search function');
	if(oci_num_rows($statement) <= 0)
	{
		$statement = oci_parse($conn, "select teachername from forumteacher where upper(teachername) like upper('%$v%')");		
		$result = oci_execute($statement);
		if(!$result)
			throw new Exception('Error in executing auto search function');
		if(oci_num_rows($statement) <= 0)
			exit('0');
		echo '<ul>';
		while($ro = oci_fetch_array($statement))
			echo '<li><a href="">'.$ro['TEACHERNAME'].'</a></li>';

		echo '<li><a href="javascript:;" onclick="$(this).parent().parent().parent().fadeOut(100)">CLOSE</a& amp;gt;</li>';
		echo '</ul>';
	}
	else
	{
		echo '<ul>';
		while($ro = oci_fetch_array($statement))
			echo '<li><a href="">'.$ro['COURSENAME'].'</a></li>';

		echo '<li><a href="javascript:;" onclick="$(this).parent().parent().parent().fadeOut(100)">CLOSE</a& amp;gt;</li>';
		echo '</ul>';
	}
	oci_free_statement($statement);
	oci_close($conn);
?>
