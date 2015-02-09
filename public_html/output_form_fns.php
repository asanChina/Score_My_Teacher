<?php

function display_login_form()
{
?>
<form method="post" action="login.php">
	<table id="loginform" >
		<tr>
			<td colspan = "2"><a href='register_form.php'>Not a member?</a></td>
		</tr>
		<tr>
			<td colspan=2>Members log in here:</td>
		</tr>
		<tr>
			<td>Username:</td>
			<td><input type="text" name="username"/></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="password"/><td>
		</tr>
		<tr>
			<td colspan="2" id="buttoncenter"><input type="submit" value="Log in" /></td>
		</tr>
	</table>
</form>
<?php
}

function display_administrator_form()
{
?>
<form method="post" action="login.php?admin=1">
	<table id="administratorform" >
		<tr>
			<td colspan=2>Welcome! administrator</td>
		</tr>
		<tr>
			<td>Username:</td>
			<td><input type="text" name="username"/></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="password"/><td>
		</tr>
		<tr>
			<td colspan="2" id="buttoncenter"><input type="submit" value="Log in" /></td>
		</tr>
	</table>
</form>
<?php
}


function display_register_form()
{
?>
<form method="post" action="register.php">
	<table id="registerform">
		<tr>
			<td>Username <br />(max 40 chars):</td>
			<td><input type="text" name="username" size="40" maxlength="40"/></td>
		</tr>
		<tr>
			<td>Password<br />(between 6 and 16 chars):</td>
			<td><input type="password" name="password1" size="40" maxlength="40"/></td>
		</tr>
		<tr>
			<td>Confirm Password:</td>
			<td><input type="password" name="password2" size="40" maxlength="40"/></td>
		</tr>
		<tr>
			<td>Department:</td>
			<td><input type="text" name="department" size="40" maxlength="40"/></td>
		</tr>
		<tr>
			<td>Email:</td>
			<td><input type="text" name="email" size="40" maxlength="40"/></td>
		</tr>
		<tr>
			<td colspan="2" id="buttoncenter"><input type="submit" value="Register" /></td>
		</tr>
	</table>
</form>
<?php 

}

function display_reply_form()
{
?>
	<form action='reply.php' method = 'post'>
		<table id="replyform">
			<tr>
				<td><textarea name="message" rows="8" cols="50"></textarea></td>
			</tr>
			<tr>
				<td><input type="submit" value="reply" /></td>
			</tr>
		</table>
	</form>
<?php	
}

function display_changepassword_form()
{
	// display html change password form
?>
	<br />
	<form action='changepassword.php' method='post'>
		<table id="changepasswordform">
			<tr>
				<td>Old password:</td>
				<td><input type='password' name='old_password' size=16 maxlength=16></td>
			</tr>
			<tr>
				<td>New password:</td>
				<td><input type='password' name='new_password1' size=16 maxlength=16></td>
			</tr>
			<tr>
				<td>Repeat new password:</td>
				<td><input type='password' name='new_password2' size=16 maxlength=16></td>
			</tr>
			<tr>
				<td colspan=2 align='center'><input type='submit' value='Change password'></td>
			</tr>
		</table>
	</form>
   	<br />
<?php
};

function display_forgotpassword_form()
{
  // display HTML form to reset and email password
?>
	<br />
	<form action='forgotpassword.php' method='post'>
		<table id="forgotpasswordform">
			<tr>
				<td>Enter your username:</td>
       				<td><input type='text' name='username' size=16 maxlength=16></td>
			</tr>
			<tr>
				<td colspan=2 align='center'><input type='submit' value='Change password'></td>
			</tr>
		</table>
   	<br />
<?php
}//;echo 'Logged in as '.$_SESSION['valid_user'].'.';
//		echo '<br />';


function display_newpost_form()
{
	if(($_SESSION['valid_user']))
		$poster = $_SESSION['valid_user'];
	
?>
	<form method="post" action="newpost.php">
		<table id="newpostform">
			<tr>	
				<td>Your Name:</td>
				<td><input type="txet" name="poster" value="<?php echo $poster;?>" /></td>
			</tr>
			<tr>
				<td>Course:</td>
				<td>
					<select name="course">
						<?php
							$courses = get_courses();
							foreach($courses as $coursename)
							{
								foreach($coursename as $item)
									echo "<option value='".$item."'>".$item."</option>";
							}
						?>
					</select>					
				</td>
			</tr>
			<tr>
				<td>Teacher:</td>
				<td>
					<select name="teacher">
						<?php
							$teachers = get_teachers();
							foreach($teachers as $teachername)
							{
								foreach($teachername as $item)
									echo "<option value='".$item."'>".$item."</option>";
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>How much do you score the teacher+course?"</td>
				<td>
					<select name="score">	
						<?php
							for($i = 1; $i < 11; $i++)
								echo "<option value='".$i."'>".$i."</option>";
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Message Title:</td>
				<td><input type="text" name="title" /></td>
			</tr>
			<tr>
				<td>Which semester have you been taught by the teacher?</td>
				<td>
					<select name="semester">
						<option value="2014spring">2014spring</option>
						<option value="2013fall">2013fall</option>
						<option value="2013summserA">2013summserA</option>
						<option value="2013summserB">2013summserB</option>
						<option value="2013summserC">2013summserC</option>
						<option value="2013spring">2013spring</option>
						<option value="2012fall">2012fall</option>
						<option value="2012summserA">2012summserA</option>
						<option value="2012summserB">2012summserB</option>
						<option value="2012summserC">2012summserC</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<textarea name="message" rows="10" cols="55"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan=2 align='center'><input type='submit' value='Post'></td>
			</tr>
		</table>
	</form>
<?php
}
?>
