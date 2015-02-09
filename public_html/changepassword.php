#!/usr/local/bin/php
<?php
	require_once('forum_fns.php');
	session_start();
 
	// create short variable names
	$old_password = $_POST['old_password'];
	$new_password1 = $_POST['new_password1'];
	$new_password2 = $_POST['new_password2'];
	try
	{
//		check_valid_user();
		if (!filled_out($_POST))
			throw new Exception('You have not filled out the form completely. Please try again.');
		if ($new_password1!=$new_password2)
			throw new Exception('Passwords entered were not the same.  Not changed.');
		if(strlen($new_password1)>16 || strlen($new_password1)<6)
			throw new Exception('New password must be between 6 and 16 characters.  Try again.');
		// attempt update
		change_password($_SESSION['valid_user'], $old_password, $new_password1);

		do_html_header('Successfully change the password');
		echo '<p id="response">Password changed successfully.</p>';
		do_html_footer();
		//jump to the index.php
		echo "<meta http-equiv=\"refresh\" content=\"1;url='index.php'\">";
	}
	catch (Exception $e)
	{
		do_html_header('Error in changing password');
		echo '<p id="response">'.$e->getMessage().'</p>';
		do_html_footer();
		echo "<meta http-equiv=\"refresh\" content=\"1;url='index.php'\">";
	}
?>
