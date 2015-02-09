#!/usr/local/bin/php
<?php
	require_once('forum_fns.php');
	session_start();

	if(isset($_SESSION['valid_user']))
	{
		do_html_header('Error in log in');
		echo '<p id="response">There is already a user in!!!!!</p>';
		do_html_footer();
		echo "<meta http-equiv=\"refresh\" content=\"1;url='index.php'\">";
	}
	else
	{
		do_html_header('User Log In');
		display_administrator_form();
		do_html_footer();
	}
?>
