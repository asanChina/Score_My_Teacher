#!/usr/local/bin/php
<?php
	include('forum_fns.php');
	session_start();
	$message = $_POST['message'];
	$user = $_SESSION['valid_user'];
	$articleid = $_SESSION['current_viewing_article'];
	$articleinfo = $_SESSION['articleinfo'];

	do_html_header();
	if(!isset($_SESSION['valid_user']))
	{
		echo '<p id="response">You haven\'t logged in, please log in first</p>';
		do_html_footer();
		echo "<meta http-equiv=\"refresh\" content=\"1;url='login_form.php'\">";
	}
	try
	{
		if($result = store_reply($user, $message, $articleid))
		{
			display_article_detail($articleinfo['username'], $articleinfo['teachername'], $articleinfo['coursename'], $articleinfo['articleid'], $articleinfo['overallrating']);
		}
		else
		{
			echo '<p id="response">failed to reply</p>';
		}
	}
	catch(Exception $e)
	{
		echo '<p id="response">'.$e->getMessage().'</p>';		
	}
	do_html_footer();
?>
