<?php
/*
MillionCMS Project
    
    Name: Login
    Description: Login System
	Last Update: 02 November 2010
    Author: Polarbear541

    Copyright © 2010 Polarbear541 and MillionCMS Group
	All Rights Reserved

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// Yes, this is a front-end file not an include.
define("IN_MILLION","1");

// Pixie Stuff
require_once("./global.php");
$loc = 'login.php';
// Some variables for login.
$action = $_GET['action'];
$error = $_GET['error'];
session_start();
$username = $_SESSION['user_name'];

// Go through all the valid actions.
switch($action)
{

case "profile":
	if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true)
	{
		// Not logged in, throw guest to login page
		redirect("./login.php?action=login");
		exit();
	}

	// Run query to get current user profile info.
	$query = $db->query("SELECT * FROM ".TABLE_PREFIX."users WHERE username='{$username}'");
	$row = $db->fetch_array($query);
	
	if ($error == 1)
	{
		$error = "Please fill in all the fields!";
		error($error);
	}
	elseif ($error == 2)
	{				
		$error = "Old Password Incorrect!";
		error($error);
	}
	elseif ($error == 3)
	{
		$error = "New and Confirm Passwords do not Match!";
		error($error);
	}
	// Shouldn't this stuff be in templates?
	echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
	<html xmlns='http://www.w3.org/1999/xhtml'>
	<head>
	<title>MillionCMS - Edit Profile</title>
	<meta http-equiv='Content-Language' content='English' />
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<link rel='stylesheet' type='text/css' href='style.css' media='screen' />
	</head>
	<body>
	<div id='content'><h2>Edit Profile</h2><form name='profile' method='post' action='./login.php?action=edit_profile'>
	Email: <input name='email' type='text' size='25' value='{$row['email']}' /><br /><br /><br /><br />
	<fieldset style='width: 400px;'><legend>Change Password: (Leave blank if not changing)</legend>
	Current Password: <br /><input name='pass' type='password' /><br />
	New Password: <br /><input name='npass' type='password' /><br />
	Confirm New Password: <br /><input name='cpass' type='password' />
	</fieldset><br />
	<input type='submit' name='submit' value='Submit' /></form><br /></div></div></body></html>";
break;

case "edit_profile":
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>MillionCMS - Edit Profile</title>
	<meta http-equiv="Content-Language" content="English" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
	</head>
	<body>
	<div id="content"><h2>Edit Profile</h2>';
	
	// Sanitise standard variables
	$email = $db->sanitise($_POST['email']);
	
	//Sanitise password variables
	$pass = $db->sanitise($_POST['pass']);
	$npass = $db->sanitise($_POST['npass']);
	$cpass = $db->sanitise($_POST['cpass']);
	
	if (empty($email))
	{
		redirect("./login.php?action=profile&error=1");
	}
	
	elseif (!empty($pass) && !empty($npass) && !empty($cpass))
	{	
		$getuserinfo = $db->query("SELECT * from ".TABLE_PREFIX."users WHERE username='{$username}'");
		$userinfo = $db->fetch_array($getuserinfo);
		$salt = $userinfo['salt'];
		
		$pass = md5($salt.md5($pass.$salt));
		$pass = md5($pass);
		
		if ($cpass != $npass)
		{
			redirect("./login.php?action=profile&error=3");
		}
		elseif ($userinfo['password'] == $pass)
		{
			$salt = random_str(10);
			$npass = md5($salt.md5($npass.$salt));
			$npass = md5($npass);
			
			// Else run update queries.
			$query = $db->query("UPDATE ".TABLE_PREFIX."users SET password='{$npass}',salt='{$salt}',email='{$email}' WHERE username='{$username}'");
		
			if(!$query) // If query fails show error.
			{		
				error("Your query failed. " . mysql_error());
			}
			else // Else show success message.
			{
				echo "Profile Edited Successfully! <br />";
				echo "<a href='./login.php?action=profile'>Click here to go back if not redirected</a><br />";
				redirect("./login.php?action=profile", 2);
			}
		}
		else
		{
			redirect("./login.php?action=profile&error=2");
		}
	}

	else
	{		
		// Else run update queries.
		$query = $db->query("UPDATE ".TABLE_PREFIX."users SET email='{$email}' WHERE username='{$username}'");
		
		if(!$query) // If query fails show error.
		{
			error("Your query failed. " . mysql_error());
		}
		else // Else show success message.
		{
			$message = "Profile Saved Successfully! <br />";
			echo "<a href='./login.php?action=profile'>Click here to go back if not redirected</a><br />";
			redirect("./login.php?action=profile", 2);
		}
	}
	echo '</div></div></body></html>';
break;

case "register":
	// Declare the page?
	$page = "register";
	// Fields aren't all filled in.
	if ($error == 1)
	{
		$error = "Please fill in all the fields!";
		$errorz = inline_error($error);
	}
	elseif ($error == 2)
	{
		// Passwords don't match.
		$error = "Passwords do not match!";
		$errorz = inline_error($error);
	}
	elseif ($error == 3)
	{
		// Username already exists.
		$error = "Username already in use!";
		$errorz = inline_error($error);
	}
	elseif ($error == 4)
	{
		// Someone else is also using this email.
		$error = "Email already in use!";
		$errorz = inline_error($error);
	}
	echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
	<html xmlns='http://www.w3.org/1999/xhtml'>
	<head>
	<title>MillionCMS - Register</title>
	<meta http-equiv='Content-Language' content='English' />
	<link rel='stylesheet' type='text/css' href='style.css' media='screen' />";
	$smarty->display("db:header_includes");
	$smarty->display("db:header");
	echo "</head>
	<body>
	<div id='content'><h2>Register</h2>
	{$errorz}
	<form name='register' method='post' action='./login.php?action=do_register'>
	Username: <input name='username' type='text' />
	Email: <input name='email' type='text' size='25' /><br />
	Password: <input name='password' type='password' />
	Confirm Password: <input name='confirm' type='password' /><br /><br />
	<input type='submit' name='submit' value='Submit' /></form><br />
	</div></div></body></html>";
break;

case "do_register":
	echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
	<html xmlns='http://www.w3.org/1999/xhtml'>
	<head>
	<title>MillionCMS - Register</title>
	<meta http-equiv='Content-Language' content='English' />
	<link rel='stylesheet' type='text/css' href='style.css' media='screen' />";
	$smarty->display("db:header_includes");
	echo "</head>
	<body>";
	
	// Sanitise everything to make it safe.
	$username = $db->sanitise($_POST['username']);
	$password = $db->sanitise($_POST['password']);
	$confirm = $db->sanitise($_POST['confirm']);
	$email = $db->sanitise($_POST['email']);
	
	$userdupe = $db->query("SELECT * from ".TABLE_PREFIX."users WHERE username='{$username}'");
	$emaildupe = $db->query("SELECT * from ".TABLE_PREFIX."users WHERE email='{$email}'");
	
	// If the user hasn't entered anything in any field.
	if (empty($username) || empty($password) || empty($confirm) || empty($email) || $username=='Guest')
	{
		redirect("./login.php?action=register&error=1");
	}
	elseif ($password != $confirm)
	{
		// If the passwords are NOT the same. Again display an error message and redirect.
		redirect("./login.php?action=register&error=2");
	}
	elseif ($db->num($userdupe) != 0)
	{
		redirect("./login.php?action=register&error=3");
	}
	elseif ($db->num($emaildupe) != 0)
	{
		redirect("./login.php?action=register&error=4");
	}
	
	$salt = random_str(10);
	$password = md5($salt.md5($password.$salt));
	$password = md5($password);
	
	$activationkey = random_str(10);
	$timenow = time();
	$query = $db->query("INSERT INTO `".TABLE_PREFIX."users` VALUES (NULL, '{$username}','0', '{$password}', '{$salt}', '{$email}', '2', '{$activationkey}','0','0','0','0','{$_SERVER['REMOTE_ADDR']}','{$timenow}','0','0','0','0')");
	
	if(!$query)
	{
		error("Your query failed. " . mysql_error());
	}
	else
	{
		$message = "Dear {$username},
		
	To complete the registration process you will need to go to the URL below in your web browser.

	{$_SERVER['HTTP_HOST']}/login.php?action=activate&email={$email}&key={$activationkey}

	If the above link does not work correctly, go to

	{$_SERVER['HTTP_HOST']}/login.php?action=activate

	You will need to enter the following:
	Email: {$email}
	Activation Key: {$activationkey}

	Thanks, MillionCMS Team.";
		$from = $settings['sendmail'];
		$subject = "Account Activation for MillionCMS";
				
		mail($email, $subject, $message, "From: {$from}");
		echo "Thank you for registering. An email has been sent with an activation key, please check your email to complete registration. <br />";
		echo "<a href='./login.php?action=login'>Click here to go back if not redirected</a><br />";
		redirect("./login.php?action=login", 2);
	}
	echo '</div></div></body></html>';
break;

case "activate":
	$page = "register";
	echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
	<html xmlns='http://www.w3.org/1999/xhtml'>
	<head>
	<title>MillionCMS - Activate Account</title>
	<meta http-equiv='Content-Language' content='English' />";
	$smarty->display("db:header_includes");
	echo "<link rel='stylesheet' type='text/css' href='style.css' media='screen' />
	</head>
	<body>
	<div id='content'><h2>Activate Account</h2>";

	$key = $db->sanitise($_REQUEST['key']);
	$email = $db->sanitise($_REQUEST['email']);
	
	if (empty($key) || empty($email))
	{
		$message = "Please fill in the fields below with your email and activation key to complete your registration.<br /><form action='./login.php?action=activate' method='post'>Email: <input type='text' name='email' /><br />Key: <input type='text' name='key' /><br /><input type='submit' value='Activate' /></form>";
	}
	else
	{
		$check = $db->query("SELECT * from ".TABLE_PREFIX."users WHERE email = '{$email}' AND activationkey = '{$key}'");
		$row = $db->fetch_array($check);
		
		if ($row['activationkey']==0)
		{
			$message = "Account Already Activated!";
		}
		elseif ($db->num($check)==1)
		{
			$activate = $db->query("UPDATE ".TABLE_PREFIX."users SET activationkey = '0' WHERE uid = '{$row['id']}'");
			$message = "Account Activated Successfully!";
		}
		else
		{
			$message = "Invalid Key/Email!";
		}
	}
	
	echo "{$message}
	</div></div></body></html>";
break;

case "lostpw":
	$page = "login";
	$username = $db->sanitise($_POST['username']);
	$email = $db->sanitise($_POST['email']);
	$smarty->assign('email',$email);
	$userinfo = $db->query("SELECT * from ".TABLE_PREFIX."users WHERE username='{$username}' AND email='{$email}'");
	if($_GET['submit']=='1')
	{
		if($db->num($userinfo) == 1)
		{
			$key = random_str(10);
			$insertkey = $db->query("UPDATE ".TABLE_PREFIX."users SET activationkey = '{$key}' WHERE username = '{$username}'");
			$message = "Dear {$username},
			
			You (or someone else possessing your username and email) have requested a password reset.
			To confirm that this is you please click the link below. If you did not request this reset, feel free to ignore this email.
			
			{$_SERVER['HTTP_HOST']}/login.php?action=do_lostpw&email={$email}&user={$username}&key={$key}
			
			Thanks, MillionCMS Team.";
			$from = $settings['sendmail'];
			$subject = "Password Reset for {$username} on MillionCMS";
			mail($email, $subject, $message, "From: {$from}");
			$sysmess = "An email has been sent to; {$email} along with instructions on how to reset your password.<br />";
		}
		else
		{
			$sysmess = error("Invalid Username/Email!");
		}
	}
	$smarty->assign('message',$sysmess);
	$smarty->display("db:login_lostpw");
break;

case "do_lostpw":
	$page = "login";
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>MillionCMS - Lost Password</title>
	<meta http-equiv="Content-Language" content="English" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="style.css" media="screen" />';
	$smarty->display("db:header_includes");
	echo '</head>
	<body>';
	$smarty->display("db:header");
	echo '<div id="content"><h2>Lost Password</h2>';
	
	$email = $db->sanitise($_GET['email']);
	$username = $db->sanitise($_GET['user']);
	$key = $db->sanitise($_GET['key']);
	
	$checkinfo = $db->query("SELECT * from ".TABLE_PREFIX."users WHERE username = '{$username}' AND email = '{$email}' AND activationkey = '{$key}'");
	
	if ($db->num($checkinfo) == 1)
	{
		$pass = random_str(10);
		$salt = random_str(10);
		$npass = md5($salt.md5($pass.$salt));
		$npass = md5($npass);
		$changepass = $db->query("UPDATE ".TABLE_PREFIX."users SET password = '{$npass}', salt = '{$salt}'");
		
		$message = "Hi {$username},

	Your password has been successfully reset upon your request. Your new password is: {$pass}

	Thanks, MillionCMS Team.";
		$from = $settings['sendmail'];
		$subject = "Password Reset for {$username} on MillionCMS";
		
		mail($email, $subject, $message, "From: {$from}");
		
		echo "Password successfully reset! Please check your email for your new password.<br />";
	}
	echo '</div></div>';
	$smarty->display("db:footer");
	echo '</body></html>';
break;

case "logout":
	// Eat the cookies
	setcookie("millionsession","",time()-3600);
	setcookie("mcmsuid","",time()-3600);
	// Remove the session.
	$db->query("UPDATE ".TABLE_PREFIX."users SET session='0' WHERE uid='{$mcms->user['uid']}'");
	// Redirect to the index page.
	redirect("./index.php");
break;

case "login":
	$page = "login";
	if ($error == 1)
	{
		$error = "Incorrect Username/Password";
		$errorz = inline_error($error);
	}
	$smarty->assign('error',$errorz);
	$smarty->display("db:login_login");
break;

case "do_login":
	$username = $db->sanitise($_POST['username']);
	$password = $db->sanitise($_POST['password']);

	$getsalt = $db->query("SELECT * FROM ".TABLE_PREFIX."users WHERE username='{$username}'");
	$row = $db->fetch_array($getsalt);
	$salt = $row['salt'];
	$password = md5($salt.md5($password.$salt));
	$password = md5($password);

	$checklogin = $db->query("SELECT * FROM ".TABLE_PREFIX."users WHERE username='{$username}' and password='{$password}'");
	$count = $db->num($checklogin);
	$row2 = $db->fetch_array($checklogin);

	if ($count == 1)
	{
		$session = random_str(10);
		$end = time()+60*60*24*31;
		setcookie("millionsession","{$session}",$end,"/");
		setcookie("mcmsuid",$row2['uid'],$end,"/");
		$db->query("UPDATE ".TABLE_PREFIX."users SET session='{$session}' WHERE uid='{$row2['uid']}'");
		redirect("./index.php");
	}

	else
	{
		redirect("./login.php?action=login&error=1");
	}
break;

default:
	redirect("./login.php?action=login");
break;
}
?>
