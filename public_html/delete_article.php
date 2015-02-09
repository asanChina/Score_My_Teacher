#!/usr/local/bin/php
<?php
	require_once('forum_fns.php');
	session_start();
	
	$del_me = $_POST['del_me'];
	$valid_user = $_SESSION['valid_user'];
	if(!filled_out($_POST))
	{
		do_html_header('Deleting Invalid Articles');
		echo '<p id="response">You didn\'t choose any article to delete</p>';
		do_html_footer();
		echo "<meta http-equiv=\"refresh\" content=\"1;url='index.php'\">";
	}
	else
	{
		if(count($del_me) > 0)
		{
			try{
				foreach($del_me as $articleid)
					delete_article($articleid);
				do_html_header('Successfully delete invalid articles');
				echo '<p id="response">Successfully delete articles</p>';
				do_html_footer();
				echo "<meta http-equiv=\"refresh\" content=\"1;url='index.php'\">";
			}
			catch(Exception $e)
			{
				do_html_header('Error in deleting the articles');
				echo '<p id="response">Something error in accessing the database server, please try again later</p>';
				do_html_footer();
				echo "<meta http-equiv=\"refresh\" content=\"1;url='index.php'\">";
			}
		}
		else
		{
			do_html_header('No article is chose');
			echo '<p id="response">No article selected for deletion</p>';
			do_html_footer();
			echo "<meta http-equiv=\"refresh\" content=\"1;url='index.php'\">";
		}
	}
?>
