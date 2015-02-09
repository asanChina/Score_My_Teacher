#!/usr/local/bin/php
<?php
	require_once('forum_fns.php');

	session_start();	
	if(!isset($_SESSION['valid_user']))
	{
		do_html_header('Not valid user');
		echo '<p id="response">You are not allowed to search the website since you are not logged in</p>';
		do_html_footer();
		echo "<meta http-equiv=\"refresh\" content=\"1;url='login_form.php'\">";
	}
	else
	{

		$searchtext = $_POST['searchtext'];
		if(isset($_SESSION['teacher_array']))
			unset($_SESSION['teacher_array']);
		if(isset($_SESSION['course_array']))
			unset($_SESSION['course_array']);

		$conn = db_connect();
		$statement = oci_parse($conn, "select teachername from forumteacher where upper(teachername) like upper('%$searchtext%')");
		$result = oci_execute($statement);
		if(!$result)
			throw new Exception('Error in executiing auto search function');
		$nrows = oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
		if($nrows <= 0)
		{
			$statement = oci_parse($conn, "select coursename from forumcourse where upper(coursename) like upper('%$searchtext%')");		
			$result = oci_execute($statement);
			if(!$result)
				throw new Exception('Error in executing auto search function');
			$nrows = oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);

			if($nrows <= 0)
			{
				oci_free_statement($statement);
				oci_close($conn);
				do_html_header('Found nothing');
				echo '<p id="response">Sorry, found nothing match what you search</p>';
				do_html_footer();
				echo "<meta http-equiv=\"refresh\" content=\"1;url='index.php'\">";
			}
			else
			{
				oci_free_statement($statement);
				oci_close($conn);	
				$_SESSION['course_array']=$res;
				do_html_header('Found match in course');
				echo '<p id="response">Found some matches in course<p>';
				do_html_footer();
				echo "<meta http-equiv=\"refresh\" content=\"1;url='index.php?page=1&search=1'\">";
			}			
		}
		else
		{
			oci_free_statement($statement);
			oci_close($conn);
/*
			$teacher = array();
			$i = 0;
			foreach($res as $row)
			{
				$teacher[$i] = $row['TEACHERNAME'];
				$i++;
			}
			$_SESSION['teacher_array'] = $teacher;
*/
			$_SESSION['teacher_array'] = $res;
			do_html_header('Found match in teacher');
			echo '<p id="response">Found match in teacher</p>';	
			do_html_footer();
			echo "<meta http-equiv=\"refresh\" content=\"1;url='index.php?page=1&search=0'\">";
		}
	}
?>
