<?php
//Require the Global Loader
define("IN_MILLION","1");
define("IN_ADMIN","1");
require_once('../global.php');
if ($perms->check_perms("can_access_admincp") && $_GET['loggedin']!='1') 
{
	header("Location: index.php?loggedin=1");
}
// This is the login script:

if($_REQUEST['login']=='adminlogin')
{
	if(empty($_POST['username']))
	{
		$no_user_specified =  '<script>$.jGrowl("Username not specified! Check your username and try agian...");</script>';
	}
	elseif(empty($_POST['password']))
	{
		$no_pass_specified =  '<script>$.jGrowl("Password not specified! Check your password and try agian...");</script>';
	}
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
	
	if ($count == 1 && $perms->cross_check("can_access_admincp",$row2['uid']))
	{
		$session = random_str(10);
		$end = time()+60*60;
		$end2 = time()+60*60*24*31;
		setcookie("madminsession","{$session}",$end,"/");
		setcookie("mcmsuid",$row2['uid'],$end2,"/");
		$db->new_update('users','adminsession='.$session,'uid='.$row2['uid'],null,false);
		$llogin['name'] = $row2['username'];
		$llogin['time'] = time();
		$db->new_update('cache','content='.serialize($llogin),'name=lastadminlogins',get_cache('lastadminlogins'),false);
		// Temp Redirect to Advanced while Style Choser is being made...
		header("Location: index.php?loggedin=1");
		exit;
	}
	else
	{
		// Need an error to be outputted.
		$login_fail = '<script>$.jGrowl("Username or Password Incorect! Please check your details and try again.");</script>';
	}
}
if($_GET['loggedin']=='1' && $perms->check_perms("can_access_admincp"))
{
	$smarty->display("db:admin_redirect");
}
else
{
	$smarty->assign('login_fail',$login_fail);
	$smarty->assign('no_user_specified',$no_user_specified);
	$smarty->assign('no_pass_specified',$no_pass_specified);
	$smarty->display("db:admin_index");
}
?>