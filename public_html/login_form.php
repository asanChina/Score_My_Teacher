#!/usr/local/bin/php
<?php
	require_once('forum_fns.php');
	session_start();

	if(isset($_SESSION['valid_user']))
	{
		do_html_header('Error in log in');
		echo '<p id="response">You have logged in!!!!</p>';
		do_html_footer();
		//now jump to the index.php
		echo "<meta http-equiv=\"refresh\" content=\"1;url='index.php'\">";
	}
	else
	{
		do_html_header('User Log In');
		display_login_form();
		do_html_footer();
	}
?>
