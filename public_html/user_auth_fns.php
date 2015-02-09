<?php
	require_once('db_fns.php');
// register new person with db
// return true or error message
function register($username, $password, $department, $email)
{
	// connect to db
	$conn = db_connect();
	// check if username is unique 
	$statement = oci_parse($conn, "select * from forumuser where username='$username'");
	$result = oci_execute($statement);
	$nrows = oci_fetch_all($statement, $results);
	if($nrows > 0)
		throw new Exception('That username is taken. go back and choose another one.');
	//$password = sha1($password);
	//now try to insert the user info to the database
	$password = sha1($password);
	$statement = oci_parse($conn, "insert into forumuser(username, password, department, email, userid) values('$username', '$password', '$department', '$email', seq_forumuser.nextval)");	
	$result = oci_execute($statement);
	oci_free_statement($statement);
	oci_close($conn);
	if(!$result)
		throw new Exception('Could not register you in database, please try again later.');
	return true;
}
 
// check username and password with db
// if yes, return true
// else throw exception
function login($username, $password, $admin)
{
	if(isset($admin))
	{
		$conn = db_connect();
		$statement = oci_parse($conn, "select username, password from forumadmin where username= '$username' and password = '$password'");
		$result = oci_execute($statement);
		if(!$result)
			throw new Exception('Could not access the backend database server, please try again later');
		$nrows = oci_fetch_all($statement, $return);
	}
	else
	{
		// connect to db
		$conn = db_connect();

		$password = sha1($password);
		$statement = oci_parse($conn, "select username, password from forumuser where username = '$username' and password='$password'");
		$result = oci_execute($statement);
		if(!$result)
			throw new Exception('Could not access the backend database server, please try again later.');
		$nrows = oci_fetch_all($statement, $return);
	}
		oci_free_statement($statement);
		oci_close($conn);
		if ($nrows > 0)
			return true;
		else 
			throw new Exception('Could not log you in.');
}

// see if somebody is logged in and notify them if not
function check_valid_user()
{
	if (isset($_SESSION['valid_user']))
	{
		echo 'Logged in as '.$_SESSION['valid_user'].'.';
		echo '<br />';
		if(isset($_SESSION['admin']))
		{
			echo 'You are an administrator!';
			echo '<br />';
		}
	}
	else
	{
		// they are not logged in 
		//do_html_heading('Problem:');
		echo 'You are not logged in.<br />';
	//	do_html_url('login.php', 'Login');
		do_html_footer();
		exit;
	}  
}

// change password for username/old_password to new_password
// return true or false
function change_password($username, $old_password, $new_password)
{
	// if the old password is right 
	// change their password to new_password and return true
	// else throw an exception
	login($username, $old_password, $_SESSION['admin']);
	$conn = db_connect();
	$old_password = sha1($old_password);
	$new_password = sha1($new_password);

	$statement = oci_parse($conn, "update forumuser set password = '$new_password' where username = '$username'");
	$result = oci_execute($statement);
	oci_free_statement($statement);
	oci_close($conn);

	if(!$result)
		throw new Exception('Could not access the backend database server, please try again later.');	
	return true;  // changed successfully
}

// grab a random word from dictionary between the two lengths
// and return it
function get_random_word($min_length, $max_length)
{
	// generate a random word
	$word = '';
	// remember to change this path to suit your system
	$dictionary = '/cise/homes/pengjie/ispell/english.0';  // the ispell dictionary
	$fp = @fopen($dictionary, 'r');
	if(!$fp)
		return false; 
	$size = filesize($dictionary);

	// go to a random location in dictionary
	srand ((double) microtime() * 1000000);
	$rand_location = rand(0, $size);
	fseek($fp, $rand_location);

	// get the next whole word of the right length in the file
	while (strlen($word)< $min_length || strlen($word)>$max_length || strstr($word, "'"))
	{  
		if (feof($fp))   
		fseek($fp, 0);        // if at end, go to start
		$word = fgets($fp, 80);  // skip first word as it could be partial
		$word = fgets($fp, 80);  // the potential password
	};
	$word=trim($word); // trim the trailing \n from fgets
	return $word;  
}

// set password for username to a random value
// return the new password or false on failure
function reset_password($username)
{ 
	// get a random dictionary word b/w 6 and 13 chars in length
	$new_password = get_random_word(6, 13);
  
	if($new_password==false)
		throw new Exception('Could not generate new password.');
	// add a number  between 0 and 999 to it
	// to make it a slightly better password
	srand ((double) microtime() * 1000000);
	$rand_number = rand(0, 999); 
	$new_password .= $rand_number;

	//$new_password1 = sha1($new_password);
	// set user's password to this in database or return false
	//$new_password1 = sha1($new_password);
	$conn = db_connect();

	$statement = oci_parse($conn, "update forumuser set password = '$new_password' where username = '$username'");
	$result = oci_execute($statement);

	oci_free_statement($statement);
	oci_close($conn);

	if(!$result)
		throw new Exception('Could not change password.');	
	else 
		return $new_password;  // changed successfully
}

// notify the user that their password has been changed
function notify_password($username, $password, &$email)
{
	$conn = db_connect();
	$statement = oci_parse($conn, "select email from forumuser where username='$username'");
	$result = oci_execute($statement);
	
	
	if (!$result)
	{
		oci_free_statement($statement);
		oci_close($conn);
		throw new Exception('Could not find email address.');  
	}
	else if (!($row = oci_fetch_array($statement)))
	{
		oci_free_statement($statement);
		oci_close($conn);
		throw new Exception('Could not find email address.');   // username not in db
	}
	else
	{

		$email = $row[0];

		$from = "From: support@phpbookmark \r\n";
		$mesg = "Your Score My Teacher password has been changed to $password \r\n"."Please change it next time you log in. \r\n";

		if (mail($email, 'Score My Teacher login information', $mesg, $from))
			return true;      
		else
			throw new Exception('Could not send email.');

	}
} 

?>
