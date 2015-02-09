#!/usr/local/bin/php
<?php
	require_once('forum_fns.php');
	session_start();
	if(isset($_SESSION['valid_user']))
	{
		do_html_header('Post New Article');
		display_newpost_form();
		do_html_footer();
	}
	else
	{
		do_html_header('Login');
		echo '<p id="response">You must log in in order to post new article</p>';
		do_html_footer();
		echo "<meta http-equiv=\"refresh\" content=\"2;url='login_form.php'\">";
	}
?>
