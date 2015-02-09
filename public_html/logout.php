#!/usr/local/bin/php
<?php
	// include function files for this application
	require_once('forum_fns.php'); 
	session_start();
	$old_user = $_SESSION['valid_user'];  
	//store to test if they *were* logged in
	unset($_SESSION['valid_user']);
	if(isset($_SESSION['admin']))
		unset($_SESSION['admin']);
	if(isset($_SESSION['current_viewing_article']))
		unset($_SESSION['current_viewing_article']);
	if(isset($_SESSION['articleinfo']))
		unset($SESSION['articleinfo']);
	if(isset($_SESSION['teacher_array']))
		unset($_SESSION['teacher_array']);
	if(isset($_SESSION['course_array']))
		unset($_SESSION['course_array']);

	$result_dest = session_destroy();

	if (!empty($old_user))
	{
  		if ($result_dest)
  		{
			do_html_header('Successfully log out');
    			// if they were logged in and are now logged out
    			echo '<p id="response">Logged out.</p>';
			do_html_footer();

			echo "<meta http-equiv=\"refresh\" content=\"2;url='index.php'\">";
  		}
  		else
  		{
   			// they were logged in and could not be logged out
			do_html_header('Error in logging out');
    			echo '<p id="response">Could not log you out.</p>';
			do_html_footer();
			echo "<meta http-equiv=\"refresh\" content=\"2;url='index.php'\">";
  		}
	}
	else
	{
		do_html_header('Not logged user');
  		// if they weren't logged in but came to this page somehow
  		echo '<p id="response">You were not logged in, and so have not been logged out.</p>';
		do_html_footer();
  		//do_html_url('login.php', 'Login');
		echo "<meta http-equiv=\"refresh\" content=\"2;url='index.php'\">";
	}
?>
