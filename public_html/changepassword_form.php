#!/usr/local/bin/php
<?php
	require_once('forum_fns.php');
	session_start();
	if(isset($_SESSION['admin']))
	{
		do_html_header('main page');
		echo '<p id="response">You are an administrator, please contact the website owner to change your password</p>';
		do_html_footer();
		echo "<meta http-equiv=\"refresh\" content=\"1;url='index.php'\">";
	}
	else
	{
		do_html_header('Change password');
		display_changepassword_form();
		do_html_footer();
	}
?>
