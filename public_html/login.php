#!/usr/local/bin/php
<?php
	// include function files for this application
	require_once('forum_fns.php'); 
	session_start();
	
	//create short variable names
	$username = $_POST['username'];
	$password = $_POST['password'];
	$admin = $_GET['admin'];
	// they have just tried logging in
	if ($username && $password)
	{
		try
		{
			login($username, $password, $admin);
			// if they are in the database register the user id
			$_SESSION['valid_user'] = $username;
			if(isset($admin))
				$_SESSION['admin'] = $admin;
			do_html_header('Successfully log in');
			echo '<p id="response">Welcome! '.$_SESSION['valid_user'].'</p>';
			do_html_footer();
			//after login in, we jump to the index.php page
			echo "<meta http-equiv=\"refresh\" content=\"1;url='index.php'\">";
		}
		catch(Exception $e)
		{
			// unsuccessful login
			do_html_header('Problem:');
			echo '<p id="response">Could not log you in now. You must be logged in to view this page.</p>';
			do_html_footer();
			echo "<meta http-equiv=\"refresh\" content=\"2;url='login_form.php'\">";
		}      
	}
?>
