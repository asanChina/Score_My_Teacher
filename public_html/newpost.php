#!/usr/local/bin/php
<?php
	include('forum_fns.php');
	session_start();

	try{
		if($id = store_new_post($_POST))
		{
			//if successfully post a new article, we just to the index.php
			do_html_header('Successfully post a new article');
			echo '<p id="response">You have successfully post a new article.</p>';
			do_html_footer();
			echo "<meta http-equiv=\"refresh\" content=\"1;url='index.php'\">";
		}	
		else
		{
			do_html_header('Problem in post a new article');
			echo '<p id="response">failled to post a new article</p>';
			do_html_footer();
			echo "<meta http-equiv=\"refresh\" content=\"1;url='index.php'\">";
		}
	}catch(Exception $e)
	{
		do_html_header('Promblem in post a new article');
		echo '<p id="response">'.$e->getMessage().'</p>';
		do_html_footer();
		echo "<meta http-equiv=\"refresh\" content=\"1;url='index.php'\">";
	}
?>
