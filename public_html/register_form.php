#!/usr/local/bin/php
<?php
	require_once('forum_fns.php');
	session_start();
	//first we test wether the user has logged in or not
	if(isset($_SESSION['valid_user']))
	{
		do_html_header('Bad action');
		echo '<p id="response">You are already a valid user and has logged in!!!!!</p>';
		do_html_footer();
		echo "<meta http-equiv=\"refresh\" content=\"1;url='index.php'\">";
	}
	else
	{
		do_html_header('User Register');
		display_register_form();
		do_html_footer();
	}
?>
