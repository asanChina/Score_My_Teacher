#!/usr/local/bin/php
<?php
	require_once('forum_fns.php');
	session_start();
	
	$del_me = $_POST['del_me'];
	$valid_user = $_SESSION['valid_user'];
	$username = $_SESSION['articleinfo']['username'];
	$teachername = $_SESSION['articleinfo']['teachername'];
	$coursename = $_SESSION['articleinfo']['coursename'];
	$articleid = $_SESSION['articleinfo']['articleid'];
	$overallrating = $_SESSION['articleinfo']['overallrating'];
	
	if(!filled_out($_POST))
	{
		do_html_header('Deleting Invalid Replies');
		echo '<p>You didn\'t choose any reply to delete</p>';
		display_article_detail($username, $teachername, $coursename, $articleid, $overallrating);
		do_html_footer();
		exit;	
	}
	else
	{
		do_html_header('Deleting Invalid Replies');
		if(count($del_me) > 0)
		{
			try{
				foreach($del_me as $replyid)
					delete_reply($replyid);
				echo '<p id="response">Successfully delete replies</p>';
			}
			catch(Exception $e)
			{
				echo '<p id="response">Somehitng error in access the database, try again later</p>';
			}
		}
		else
			echo '<p id="response">No article selected for deletion</p>';
		display_article_detail($username, $teachername, $coursename, $articleid, $overallrating);
		do_html_footer();
	}
?>
