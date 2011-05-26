<?php
//Require the Global Loader
define("IN_IMPROV", "1");
define("IN_ADMIN","1");
require_once('../global.php');
// Before the user can do anything here, check if the user is actually an administrator
if (!$is_admin) {
	die($error->perms(20));
}
// Eat the cookies
setcookie("madminsession","",time()-3600);
setcookie("mcmsuid","",time()-3600);
// Remove the session.
$db->query("UPDATE ".TABLE_PREFIX."users SET adminsession='0' WHERE uid='{$imp->user['uid']}'");
// Redirect to the index page.
redirect("./index.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ACP Login | ImprovCMS</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<link rel="stylesheet" type="text/css" href="css/login_style.css" title="style" media="screen" />

<meta http-equiv="refresh" content="5;url=index.php">

<script type="text/javascript">
/* <![CDATA[ */
	$(document).ready(function(){
			$(".block").fadeIn(1000);
			$(".idea").fadeIn(1000);
			$('.idea').supersleight();
			$('#username').example('Username');
			$('#password').example('Password');
	});
/* ]]> */
</script>
</head>

<body>
	<div id="wrap">
		<div class="idea">
		<img src="images/info.png" alt=""/>
		<p>Ending your session...</p>
	</div>
        
	<div class="block">
		<div class="left"></div>
			<div class="right" align="center"><br /><br />
				<img align="absmiddle" src="images/loader_bar.gif"><br />&nbsp;Processing your Request...
			</div>
		</div>
		<center><a href="<?php echo $imp->settings['homeurl'] ?>"><img src="images/logo.png" alt="" width="312" height="600" /></a><br /></center>
		<div id="copyright" align="center"><span style="color:#FFF; margin:3px 0;">Copyright&copy; 2010 ImprovCMS - <a href="http://improvcms.com">Home Page</a> - <a href="http://improvcms.com/forums">Support</a></span></div>
	</div>
</body>
</html>
