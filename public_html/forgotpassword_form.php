#!/usr/local/bin/php
<?php
	require_once('forum_fns.php');
	do_html_header('Reset password');
 
	display_forgotpassword_form();

	do_html_footer();
?>
