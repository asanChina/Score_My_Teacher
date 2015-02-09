#!/usr/local/bin/php
<?php
	require_once('forum_fns.php');
	$username = $_POST['username'];
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	$department = $_POST['department'];
	$email = $_POST['email'];

	//start session which may be needed later
	//start it now because it must go before headers
	session_start();

	try
	{
		//check forms filled in
		if(!filled_out($_POST))
		{
			throw new Exception('You have not filled the form out correctly, please try again.');
		}
		//check email address
		if(!valid_email($email))
		{
			throw new Exception('That is not a valid email address. Please try again.');
		}
		//check whether two passwords are the same or not
		if($password1 != $password2)
		{
			throw new Exception('The passwords you entered do not match. Please try again.');
		}
		//check the password length
		if(strlen($password1) < 6)
		{
			throw new Exception('Your password must be at least 6 characters long. Please try again');
		}
		//check username length is ok
		if(strlen($username) > 16)
		{
			throw new Exception('Your username must be less than 17 characters long. Please try again.');
		}
		//now we try to register
		register($username, $password1, $department, $email);
		//register session variable
		$_SESSION['valid_user'] = $username;
		//provide link to index pages
		do_html_header('Log up successfully');
		echo '<p id="response">'.'You have successfully registered as a valid user'.'</p>';
		do_html_footer();
		echo "<meta http-equiv=\"refresh\" content=\"0.01;url='index.php'\">";
	}
	catch(Exception $e)
	{
		do_html_header('Error in Registering');
		echo '<p id="response">'.$e->getMessage().' Please try again!</p>';
		do_html_footer(); 
		echo "<meta http-equiv=\"refresh\" content=\"2;url='register_form.php'\">";
	}
?>
