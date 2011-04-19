<?php
// MillionCMS Database Inserts

$create1 = "CREATE TABLE {$prefix}pages
	(
		pid mediumint(15) NOT NULL AUTO_INCREMENT,
		PRIMARY KEY(pid),
		title varchar(50) collate utf8_general_ci,
		nicetitle varchar(100) collate utf8_general_ci,
		content text collate utf8_general_ci,
		author int(15) NOT NULL,
		datecreated bigint(30) DEFAULT 0 NOT NULL,
		lastupdated bigint(30) DEFAULT 0 NOT NULL,
		views bigint(30) DEFAULT 0 NOT NULL,
		status smallint
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 
COLLATE=utf8_general_ci";

$create2 = "CREATE TABLE {$prefix}users
	(
		uid mediumint(15) NOT NULL AUTO_INCREMENT,
		PRIMARY KEY(uid),
		username varchar(225) collate utf8_general_ci,
		title varchar(100) collate utf8_general_ci,
		password varchar(225) collate utf8_general_ci,
		salt varchar(15) collate utf8_general_ci,
		email varchar(100) collate utf8_general_ci,
		gid int(15) DEFAULT 1 NOT NULL,
		activationkey mediumint(15) NOT NULL,
		status smallint DEFAULT 0,
		session varchar(50) DEFAULT 0 collate utf8_general_ci,
		adminsession varchar(50) collate utf8_general_ci,
		avatar varchar(50) collate utf8_general_ci,
		ipaddress varchar(50) collate utf8_general_ci,
		lastactive bigint(30) DEFAULT 0 NOT NULL,
		admin_style smallint(6) DEFAULT 0 NOT NULL,
		protect tinyint(3) DEFAULT 0 NOT NULL,
		superadmin tinyint(2) DEFAULT 0 NOT NULL,
		permissions mediumtext collate utf8_general_ci
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 
COLLATE=utf8_general_ci";

$create3 = "CREATE TABLE {$prefix}reports
	(
		rid mediumint(15) NOT NULL AUTO_INCREMENT,
		pid mediumint(15) DEFAULT 0 NOT NULL,
		PRIMARY KEY(rid),
		content text collate utf8_general_ci,
		uid int(15) DEFAULT 0 NOT NULL,
		status smallint DEFAULT 0
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 
COLLATE=utf8_general_ci";

$create4 = "CREATE TABLE {$prefix}settings
	(
		sid mediumint(15) NOT NULL AUTO_INCREMENT,
		PRIMARY KEY(sid),
		name varchar(50) collate utf8_general_ci,
		content text collate utf8_general_ci
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 
COLLATE=utf8_general_ci";

$create5 = "CREATE TABLE {$prefix}templates
	(
		tid mediumint(20) NOT NULL AUTO_INCREMENT,
		PRIMARY KEY(tid),
		name varchar(100) collate utf8_general_ci,
		content longtext collate utf8_general_ci,
		templateset int(11) DEFAULT 0
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 
COLLATE=utf8_general_ci";

$create6 = "CREATE TABLE {$prefix}usergroups
	(
		gid int(15) NOT NULL AUTO_INCREMENT,
		PRIMARY KEY(gid),
		name varchar(225) collate utf8_general_ci,
		description text collate utf8_general_ci,
		adminlevel int(10) DEFAULT 0 NOT NULL,
		permissions mediumtext collate utf8_general_ci
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 
COLLATE=utf8_general_ci";

$create7 = "CREATE TABLE {$prefix}comments
	(
		cid int(15) NOT NULL AUTO_INCREMENT,
		PRIMARY KEY(cid),
		pid mediumint(15) DEFAULT 0 NOT NULL,
		time bigint DEFAULT 0 NOT NULL,
		content text collate utf8_general_ci,
		author mediumint(15) DEFAULT 0 NOT NULL
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 
COLLATE=utf8_general_ci";

$create8 = "CREATE TABLE {$prefix}cache
	(
		cid int(15) NOT NULL AUTO_INCREMENT,
		PRIMARY KEY(cid),
		name varchar(50) collate utf8_general_ci,
		content mediumtext collate utf8_general_ci
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 
COLLATE=utf8_general_ci";

$insert1 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('page_create','<html>
<head><title>Create a Page</title>
{include file=\'db:header_includes\'}
</head>
{include file=\'db:header\'}
<small>A lowercase title</small>
<br />
<form action=\"create.php\" method=\"post\" />
Title: <input type=\"text\" name=\"title\" /><br /> 
    Subject: <input type=\"text\" name=\"subject\" /><br />
    <small>Please type your message below. <strong>BBCode and HTML are not allowed!</strong></small><br />
    Message: <textarea width=\"300\" height=\"300\" name=\"message\" /></textarea><br />
    <input type=\"submit\" value=\"Create!\" name=\"submit24\" />
</form>
{\$message}
{include file=\'db:footer\'}
</body>
</html>')";

$insert2 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('page_view','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<title>Viewing {\$pntitle}</title>
{include file=\'db:header_includes\'}
{\$commenthead}
</head>
{include file=\'db:header\'}
<div id=\"container\">
<table class=\"container\" border=\"0\" width=\"100%\">
<tr><td valign=\"top\">{\$sidebar}</td><td>
{\$rcontent}
{\$mcontent}
<!--Options Container-->
<table border=\"0\" width=\"100%\"><tr><td width=\"50%\">&nbsp;</td><td>
<div id=\"poptions\"></div></td></tr>
</table>
<!--End Options Container-->
</td><td valign=\"top\">{\$sidebar_r}</td></tr></table>
</div>
{include file=\'db:footer\'}
<div id=\"show_page_edit\" style=\"display: none;\">
<iframe src=\"{\$imp->settings.siteurl}/view.php?fetch=options&amp;pid={\$pid}\" width=\"100%\" height=\"100%\" style=\"border: 0px;\" frameborder=\"0\"></iframe>
<div class=\"iframeHelper\"></div></div>
</html>')";

$insert3 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('header','<body>
<div id=\"header\">
<div align=\"center\"><a href=\"index.php\"><img src=\"./images/logo.png\" alt=\"[{\$imp->settings.site_name} Logo]\" title=\"{\$imp->settings.site_name}\" /></a></div>
<div align=\"center\"><ul class=\"nav\">
<li><a class=\"nav\" href=\"index.php\">Home</a></li>
{\$header_guest}
{\$header_admin}
<li id=\"toolbox\"><a href=\"toolbox.php\" onclick=\"return false\" class=\"nav\">Toolbox</a></li>
{\$header_member}
</ul>
</div>
<div id=\"welcomeblock\">
<br />
<table border=\"1\" width=\"100%\" class=\"tborder\" cellspacing=\"0\">
<tr class=\"trow\"><td width=\"90\"><img src=\"{\$avatar}\" alt=\"{\$imp->user.username} Avatar\" title=\"{\$username} Avatar\" width=\"90\" /></td><td>Welcome, {\$username}!
<br />
<a href=\"options.php\">Your CP</a> | <a href=\"view.php?uid={\$imp->user.uid}\">Your Pages</a>
</td></tr></table></div>
</div>')";

$insert4 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('index','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head><title>{\$imp->settings.site_name} Index Page</title>
{include file=\'db:header_includes\'}
{\$commenthead}
</head>
{include file=\'db:header\'}
{\$topbar}
<!-- Navigation -->
<a href=\"index.php\">Home Page</a><br />
<!--Container-->
<table border=\"0\" width=\"100%\"><tr><td valign=\"top\">
<!-- Sidebar -->
<div align=\"left\"><table border=\"1\" class=\"tborder\" cellspacing=\"0\">
<tr class=\"trow\"><td><a href=\"view.php?pid=2\">Development Site</a></td></tr>
<tr class=\"trow\"><td><a href=\"anotherlink.php\">Another Link</a></td></tr>
<tr class=\"trow\"><td><a href=\"test.php\">Test Link</a></td></tr></table></div></td><td valign=\"top\">
<div align=\"center\">
{\$rcontent}
{\$mcontent}</div></td>
<td>{\$sidebar_r}</td></tr></table>
<!-- Footer -->
{include file=\'db:footer\'}
</body></html>')";

$insert5 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('sidebar_page','<div class=\"sidebar\">
<table border=\"1\">
<tr><th>Sidebar</th></tr>
<tr><td><a href=\"toolbox.php\" onclick=\"return false\"><img src=\"./images/options.png\" alt=\"[Options]\" title=\"Options\" />Options</a></td></tr>
<tr><td><a href=\"view.php?pid={\$pid}&amp;action=report\"><img src=\"./images/report-24.png\" alt=\"[Report]\" title=\"Report\" />Report</a></td></tr>
</table>
</div>')";

$insert5 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('options_page','{include file=\'db:header_includes\'}
<table border=\"1\">
<tr><th><img src=\"./images/options.png\" alt=\"[Options]\" title=\"Options\" />Options</th></tr>
<tr><td><a href=\"create.php?do=edit&amp;pid={\$pid}\"><img src=\"./images/edit.png\" alt=\"[Edit]\" title=\"Edit\" />Edit</a></td></tr>
<tr><td><a href=\"create.php?do=delete&amp;pid={\$pid}\"><img src=\"./images/delete-page.png\" alt=\"[Delete]\" title=\"Delete Page\" />Delete</a></td></tr>
<tr><td><a href=\"view.php?pid={\$pid}&amp;action=report\" target=\"_top\"><img src=\"./images/report-24.png\" alt=\"[Report]\" title=\"Report\" />Report</a></td></tr>
</table>')";

$insert6 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('footer','<div id=\"footer\" align=\"center\">
Powered by <a href=\"http://improvcms.com\">ImprovCMS</a><br />Copyright &copy; 2011 Improv Software Group
</div>
<div id=\"show_toolbox\" style=\"display: none;\">
<iframe src=\"{\$imp->settings.siteurl}/toolbox.php?mode=jquery\" width=\"100%\" height=\"100%\" style=\"border: 0px;\" frameborder=\"0\"></iframe>
<div class=\"iframeHelper\"></div></div>')";

$insert7 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('header_includes','<link href=\"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css\" rel=\"stylesheet\" type=\"text/css\"/>
<link rel=\"stylesheet\" type=\"text/css\" href=\"./styles/AeroWindow.css\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"./styles/default.css\" />
<link rel=\"shortcut icon\" href=\"{\$imp->settings.siteurl}/favicon.ico\" />
<script type=\"text/javascript\" src=\"./js/jquery/jquery-142.js\"></script>
<script type=\"text/javascript\" src=\"./js/jquery/jquery-ui-1.8.1.custom.min.js\"></script>
<script type=\"text/javascript\" src=\"./js/jquery/jquery.easing.1.3.js\"></script>
<script type=\"text/javascript\" src=\"./js/jquery/jquery-AeroWindow.js\"></script>
<script type=\"text/javascript\">
$(document).ready(function() {
	 $(\'#page_edit\').click(function() {
          $(\'#show_page_edit\').AeroWindow({
            WindowTitle:          \'Options\',
            WindowPositionTop:    \'center\',
            WindowPositionLeft:   \'center\',
            WindowWidth:          110,
            WindowHeight:         150,
            WindowResizable:      true,
            WindowAnimationSpeed: 1000,
            WindowDraggable:      true,
            WindowAnimation:      \'easeOutCubic\',
WindowClosable:       true 
          });
        });

$(\'#toolbox\').click(function() {
          $(\'#show_toolbox\').AeroWindow({
            WindowTitle:          \'Toolbox\',
            WindowPositionTop:    \'center\',
            WindowPositionLeft:   \'center\',
            WindowWidth:          700,
            WindowHeight:         250,
            WindowResizable:      true,
            WindowAnimationSpeed: 1000,
            WindowDraggable:      true,
            WindowAnimation:      \'easeOutCubic\',
WindowClosable:       true 
          });
        });
{\$extra}
	});
</script>
<script type=\"text/javascript\" src=\"./js/showoptions.js\"></script>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />')";

$insert8 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('page_toolbox','{if \$sneak}
<html>
<head>
<title>Toolbox</title>
{/if}
{include file=\'db:header_includes\'}
{if \$sneak}
<body>
{include file=\'db:header\'}
{/if}
<!--Start Container-->
<table border=\"0\" class=\"container\" width=\"100%\">
<tr>{include file=\'db:sidebar_toolbox\'}
<!--Start content-->
{include file=\"db:\$content\"}
{if isset(\$content2)}
{include file=\"db:\$content2\"}
{/if}
<!--End content-->
</tr>
</table>
<!--End Container-->')";

$insert9 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('toolbox_content_home','<td><table border=\"1\">
<tr><td>Welcome to your toolbox.<br />
Here, you can perform all kinds of tasks such as creating pages with ease or viewing reports.</td></tr></table></td>')";

$insert10 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('sidebar_toolbox','<td><table border=\"1\">
<tr><th><img src=\"./images/toolbox.png\" width=\"24\" height=\"24\" alt=\"[Toolbox Sidebar]\" title=\"Toolbox Sidebar\">Sidebar</th></tr>
<tr><td><a href=\"toolbox.php?page=home{\$sample}\"><img src=\"./images/home.png\" alt=\"[Toolbox Home]\" title=\"Toolbox Home\">Home</a></td></tr>
<tr><td><a href=\"toolbox.php?page=changeavatar{\$sample}\"><img src=\"./images/change.png\" alt=\"[Change Avatar]\" title=\"Change your avatar\">Change Avatar</a></td></tr>
<tr><td><a href=\"toolbox.php?page=createpage{\$sample}\"><img src=\"./images/create.gif\" alt=\"[Create Page]\" title=\"Create a new Page\">Create Page</a></td></tr>
<tr><td><a href=\"toolbox.php?page=listpage{\$sample}\"><img src=\"./images/list.png\" width=\"24\" height=\"24\" alt=\"[Page List]\" title=\"A list of all the pages\">Page List</a></td></tr>
{if \$can_manage_reports}
{include file=\'db:sidebar_toolbox_reportbit\'}
{/if}
</table></td>')";

$insert11 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('toolbox_create','<td><table border=\"1\" width=\"100%\">
<tr><td>
<form action=\"create.php\" method=\"post\" />
Title: <input type=\"text\" name=\"title\" /><br /> 
<small>A lowercase title</small><br />
Subject: <input type=\"text\" name=\"subject\" /><br />
<small>The name of the page</small><br />
Message: <textarea width=\"500\" height=\"500\" name=\"message\" /></textarea><br /><br />
<small>Please type your message above. <strong>HTML is not allowed!</strong></small><br />
    <input type=\"submit\" value=\"Create!\" name=\"submit24\" />
</form>
</td></tr></table></td>')";

$insert12 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('toolbox_plist','<td>
<table border=\"1\">
<tr class=\"thead\"><td colspan=\"2\">A list of all the pages</td></tr>
{\$plist}
</table>
</td>')";

$insert13 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('header_guest','<li><a class=\"nav\" href=\"login.php?action=register\">Register</a></li>
<li><a class=\"nav\" href=\"login.php\">Login</a></li>')";

$insert14 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('header_admin','<li><a class=\"nav\" href=\"./admin\">AdminCP</a></li>')";

$insert15 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('report_view','{\$headerinclude}
<table border=\"1\">
<tr><td>Report Page</td></tr>
<tr><td>
<form action=\"view.php?pid={\$pid}&amp;do=report\" method=\"post\"><table border=\"0\">
<tr><td>Reason:</td></tr>
<tr><td><textarea rows=\"8\" columns=\"80\"></textarea></td></tr>
<tr><td><small>Does this page contain hacking content or other inappropiate content?</small></td></tr>
</table></form></td></tr>
</table>')";

$insert16 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('page_view_report','<html>
<head>
<title>Viewing {\$pntitle}</title>
{include file=\'db:header_includes\'}
</head>
{include file=\'db:header\'}
<body>
<table class=\"container\" border=\"0\" width=\"100%\">
<tr><td>{\$sidebar}</td><td>
<table border=\"1\" width=\"100%\">
<tr class=\"tcat\"><td>{\$pntitle}</td></tr>
<tr><td>{\$pcontent}</td></tr>
</table>
<!--Options Container-->
<table border=\"0\" width=\"100%\"><tr><td width=\"50%\">&nbsp;</td><td>
<div id=\"poptions\"></div></td></tr>
</table>
<!--End Options Container-->
</td></tr></table>
{include file=\'db:footer\'}
<div id=\"show_page_edit\" style=\"display: none;\">
<iframe src=\"{\$imp->settings.siteurl}/view.php?fetch=options&amp;pid={\$pid}\" width=\"100%\" height=\"100%\" style=\"border: 0px;\" frameborder=\"0\"></iframe>
<div id=\"iframeHelper\"></div></div>
<div id=\"show_page_report\" style=\"display: none;\">{\$report}</div>')";

$insert17 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('report_view_toolbox','<iframe src=\"{\$imp->settings[siteurl]}/toolbox.php?mode=jquery&amp;page=report&amp;pid=$pid\" width=\"100%\" height=\"100%\" style=\"border: 0px;\" frameborder=\"0\"></iframe>
<div id=\"iframeHelper\"></div>')";

$insert18 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('toolbox_report_page','<td><table border=\"1\">
<tr><td>Report Page</td></tr>
<tr><td>
<form action=\"view.php?pid={\$pid}&amp;do=report\" method=\"post\"><table border=\"0\">
<tr><td>Reason:</td></tr>
<tr><td><textarea rows=\"8\" columns=\"80\" name=\"content\"></textarea></td></tr>
<tr><td><small>Does this page contain hacking content or other inappropiate content?</small></td></tr>
<tr><td><input type=\"submit\" value=\"Report\" /></td></tr>
</table></form></td></tr>
</table></td>')";

$insert19 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('toolbox_report_list','<td>
<table border=\"1\">
<tr class=\"thead\"><td colspan=\"2\">A list of all the reports</td></tr>
{\$reports}
</table>
</td>
<td><table border=\"1\">
<tr><th><img src=\"./images/admin-reports.png\" width=\"24\" height=\"24\" alt=\"[Reports Sidebar]\" title=\"Sidebar for navigating the reports section\">Reports</th></tr>
<tr><td><a href=\"toolbox.php?page=reportlist{\$sample}\"><img src=\"./images/list.png\" alt=\"[Report List]\" title=\"A list of the reports\">Report List</a></td></tr>
<tr><td><a href=\"toolbox.php?page=deletedreports{\$sample}\">
<img src=\"./images/trash.png\" width=\"24\" height=\"24\" alt=\"[Deleted Report List]\" title=\"A list of all the reports that have been deleted\">Deleted Reports</a></td></tr>
</table></td>')";

$insert20 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('toolbox_report_view','<td><table border=\"1\">
<tr><td colspan=\"2\">{\$title} Report</td></tr>
<tr><td>{\$name}</td>
<td>{\$content}</td></tr>
</table></td>')";

$insert21 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('header_member','<li><a class=\"nav\" href=\"./login.php?action=logout\">Logout</a></li>')";

$insert22 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('toolbox_options_avatar','<td><table border=\"1\">
<tr><td>Upload Avatar</td></tr>
<tr><td><form action=\"options.php\" method=\"post\" enctype=\"multipart/form-data\">
<label for=\"avatar\">Filename:</label><input type=\"file\" name=\"avatar\" id=\"file\" /><br />
<input type=\"submit\" name=\"changeavatar\" value=\"Upload\" /></form></td></tr>
</table></td>')";

$insert23 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('toolbox_edit','<td><table border=\"1\" width=\"100%\"><tr><td>
<form action=\"create.php\" method=\"post\" />
Subject: <input type=\"text\" name=\"subject\" /><br />
<div class=\"smallfont\">Below is the current message submitted for this page. <strong>HTML is not allowed!</strong></div><br />
Message: <textarea width=\"300\" height=\"300\" name=\"message\" /><br />
<input type=\"submit\" value=\"Edit!\" /></form>
</td></tr></table></td>')";

$insert24 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('usercp_page','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<title>User CP</title>
{include file=\'db:header_includes\'}
</head>
{include file=\'db:header\'}
<table border=\"1\" class=\"tborder\" cellspacing=\"0\">
<tr class=\"trow\"><td>Some Link</td></tr>
<tr class=\"trow\"><td>Another Link</td></tr>
</table>
<table border=\"1\" class=\"tborder\" cellspacing=\"0\">
<tr class=\"trow\"><td>Welcome</td></tr>
<tr class=\"trow\"><td>Welcome to your control panel. Here you can personalise your profile to your needs and set options that suit you.</td></tr></table>
{include file=\'db:footer\'}
</body>
</html>')";

$insert25 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('sidebar_toolbox_reportbit','<tr><td><a href=\"toolbox.php?page=reportlist{\$sample}\">
<img src=\"./images/admin-reports.png\" width=\"24\" height=\"24\">Reports</a></td></tr>')";

$insert26 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('login_login','<!DOCTYPE html PUBLIC \"//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<title>MillionCMS - Login</title>
<meta http-equiv=\"Content-Language\" content=\"English\" />
{include file=\'db:header_includes\'}
</head>
{include file=\'db:header\'}
{\$error}
<div align=\"center\">
<table border=\"1\">
<tr><td><div id=\"content\"><h2>Login</h2></td></tr>
<tr><td>
<form name=\"loginform\" method=\"post\" action=\"./login.php?action=do_login\">
Username: <input name=\"username\" type=\"text\" id=\"username\" /><br />
Password: <input name=\"password\" type=\"password\" id=\"password\" /><br />
<input type=\"submit\" name=\"Submit\" value=\"Login\" />
<a href=\"./login.php?action=lostpw\">Lost Password?</a>
</form></td></tr>
</table>
</div><br />
</div>
{include file=\'db:footer\'}
</body></html>')";

$insert27 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('page_contact','<html>
<head>
<title>{\$imp->settings[site_name]} - Contact Us Form</title>
{include file=\'db:header_includes\'}
</head>
{include file=\'db:header\'}
<form action=\'?action=success\' method=\'post\'>
Email: <input type=\'text\' name=\'email\' /><br />
Subject: <input type=\'text\' name=\'email_subj\' /><br />
Message: <input type=\'text\' size=\'250\' maxlength=\'250\' name=\'mess\' /><br />
<input type=\'submit\' value=\'Send Report\' /></form>
Please type in the details below. They will be sent to the administrator.<br /><br />
{\$success}
</body>
</html>')";

$insert28 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('view_uid','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head><title>Pages created by {\$uname}</title>
{include file=\'db:header_includes\'}
{\$commenthead}
</head>
{include file=\'db:header\'}
{eval var=\$table}
{include file=\'db:footer\'}
</body>
</html>')";

$insert29 = "INSERT INTO {$prefix}templates (name, content)
VALUES
('login_lostpw','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<title>MillionCMS - Lost Password</title>
<meta http-equiv=\"Content-Language\" content=\"English\" />
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\" media=\"screen\" />
{include file=\'db:header_includes\'}
</head>
<body>
{include file=\'db:header\'}
<div id=\"content\"><h2>Lost Password</h2>
{if empty(\$email)}
Please enter your email below to start off the process which will reset your process.<br /><br />
<form name=\"lostpw\" method=\"post\" action=\"./login.php?action=lostpw&submit=1\">
Username <input name=\"username\" type=\"text\" /><br />
Email: <input name=\"email\" type=\"text\" /><br />
<input type=\"submit\" /><br />
{/if}
{\$message}
</div></div>
{include file=\'db:footer\'}
</body></html>')";

$ugroup1 = "INSERT INTO {$prefix}usergroups (name, description)
VALUES
('Guests','The Default group which all unregistered users go in.')";

// Guest
$name = 'Guests';
$permissions['can_view_pages'] = 1;
$permissions['can_view_toolbox'] = 1;
$permissions['can_view_page_list'] = 1;
$permissions['can_create_pages'] = 0;
$permissions['can_view_deleted_pages'] = 0;
$perms = serialize($permissions);
$perms1 = "UPDATE {$prefix}usergroups SET permissions='{$perms}' WHERE name='{$name}'";

$ugroup2 = "INSERT INTO {$prefix}usergroups (name, description)
VALUES
('Registered','The group which registered users go in by default.')";

// Registered
$name = 'Registered';
$permissions['can_view_pages'] = 1;
$permissions['can_view_toolbox'] = 1;
$permissions['can_view_page_list'] = 1;
$permissions['can_create_pages'] = 1;
$permissions['can_edit_own_pages'] = 1;
$permissions['can_edit_pages'] = 0;
$permissions['can_delete_own_pages'] = 0;
$permissions['can_report_pages'] = 1;
$permissions['can_view_deleted_pages'] = 0;
$permissions['can_edit_all_pages'] = 0;
$permissions['can_create_comments'] = 1;
$perms = serialize($permissions);
$perms2 = "UPDATE {$prefix}usergroups SET permissions='{$perms}' WHERE name='{$name}'";

$ugroup3 = "INSERT INTO {$prefix}usergroups (name, description)
VALUES
('Contributor','Users who regularly contribute to the site.')";

// Contributors
$name = 'Contributor';
$permissions['can_view_pages'] = 1;
$permissions['can_view_toolbox'] = 1;
$permissions['can_view_page_list'] = 1;
$permissions['can_create_pages'] = 1;
$permissions['can_edit_own_pages'] = 1;
$permissions['can_edit_pages'] = 1;
$permissions['can_delete_own_pages'] = 1;
$permissions['can_report_pages'] = 1;
$permissions['can_view_deleted_pages'] = 1;
$permissions['can_edit_all_pages'] = 0;
$permissions['can_create_comments'] = 1;
$perms = serialize($permissions);
$perms3 = "UPDATE {$prefix}usergroups SET permissions='{$perms}' WHERE name='{$name}'";

$ugroup4 = "INSERT INTO {$prefix}usergroups (name, description)
VALUES
('Editor','Part of the staff, manages the pages and deals with users.')";

// Editor
$name = 'Editor';
$permissions['can_view_pages'] = 1;
$permissions['can_view_toolbox'] = 1;
$permissions['can_view_page_list'] = 1;
$permissions['can_create_pages'] = 1;
$permissions['can_create_staff_pages'] = 1;
$permissions['can_edit_own_pages'] = 1;
$permissions['can_edit_pages'] = 1;
$permissions['can_delete_own_pages'] = 1;
$permissions['can_report_pages'] = 1;
$permissions['can_view_deleted_pages'] = 1;
$permissions['can_edit_all_pages'] = 1;
$permissions['can_delete_pages'] = 1;
$permissions['can_delete_all_pages'] = 1;
$permissions['can_manage_reports'] = 1;
$permissions['can_undelete_pages'] = 1;
$permissions['can_warn_users'] = 1;
$permissions['can_create_comments'] = 1;
$permissions['can_edit_comments'] = 1;
$permissions['can_access_admincp'] = 0;
$perms = serialize($permissions);
$perms4 = "UPDATE {$prefix}usergroups SET permissions='{$perms}' WHERE name='{$name}'";

$ugroup5 = "INSERT INTO {$prefix}usergroups (name, description)
VALUES
('Administrator','The people who administrate the site.')";

// Administrators
$name = 'Administrator';
$permissions['can_view_pages'] = 1;
$permissions['can_view_toolbox'] = 1;
$permissions['can_view_page_list'] = 1;
$permissions['can_create_pages'] = 1;
$permissions['can_create_staff_pages'] = 1;
$permissions['can_edit_own_pages'] = 1;
$permissions['can_edit_pages'] = 1;
$permissions['can_delete_own_pages'] = 1;
$permissions['can_report_pages'] = 1;
$permissions['can_view_deleted_pages'] = 1;
$permissions['can_edit_all_pages'] = 1;
$permissions['can_delete_pages'] = 1;
$permissions['can_delete_all_pages'] = 1;
$permissions['can_manage_reports'] = 1;
$permissions['can_permanently_delete_reports'] = 1;
$permissions['can_undelete_pages'] = 1;
$permissions['can_warn_users'] = 1;
$permissions['can_access_admincp'] = 1;
$permissions['can_permanently_delete_pages'] = 1;
$permissions['can_edit_all_staff_pages'] = 1;
$permissions['can_change_page_status'] = 1;
$permissions['can_use_html'] = 1;
$permissions['can_use_page_block_bbcode'] = 1;
$permissions['can_delete_all_staff_pages'] = 1;
$permissions['can_ban_users'] = 1;
$permissions['can_edit_users'] = 1;
$permissions['can_create_comments'] = 1;
$permissions['can_edit_comments'] = 1;
$permissions['can_delete_comments'] = 1;
$permissions['can_view_offline'] = 1;
$permissions['admin:can_manage_pages'] = 1;
$permissions['admin:can_edit_users'] = 1;
$permissions['admin:can_view_adminlogs'] = 1;
$perms = serialize($permissions);
$perms5 = "UPDATE {$prefix}usergroups SET permissions='{$perms}' WHERE name='{$name}'";

$time = time();
$page1 = "INSERT INTO {$prefix}pages (title, nicetitle, content, status, author, datecreated, lastupdated)
VALUES
('index','{\$imp->settings[site_name]} Frontpage',
'[page=custom][content=pagelist][/content][/page]Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
'6','-1','{$time}','{$time}')";
$cache1 = "INSERT INTO {$prefix}cache (name)
VALUES
('gadgets')";
$cache2 = "INSERT INTO {$prefix}cache (name, content)
VALUES
('admin_notes','This is where you can leave notes which are shared with other administrators.')";
$regpermissions = array();
$regpermissions[] = "can_view_pages";
$regpermissions[] = "can_view_toolbox";
$regpermissions[] = "can_view_page_list";
$regpermissions[] = "can_create_pages";
$regpermissions[] = "can_create_staff_pages";
$regpermissions[] = "can_edit_own_pages";
$regpermissions[] = "can_edit_pages";
$regpermissions[] = "can_delete_own_pages";
$regpermissions[] = "can_report_pages";
$regpermissions[] = "can_view_deleted_pages";
$regpermissions[] = 'can_edit_all_pages';
$regpermissions[] = 'can_delete_pages';
$regpermissions[] = 'can_delete_all_pages';
$regpermissions[] = 'can_manage_reports';
$regpermissions[] = 'can_undelete_pages';
$regpermissions[] = 'can_warn_users';
$regpermissions[] = 'can_access_admincp';
$regpermissions[] = 'can_permanently_delete_reports';
$regpermissions[] = 'can_permanently_delete_pages';
$regpermissions[] = "can_edit_all_staff_pages";
$regpermissions[] = "can_change_page_status";
$regpermissions[] = "can_use_page_block_bbcode";
$regpermissions[] = "can_delete_all_staff_pages";
$regpermissions[] = "can_ban_users";
$regpermissions[] = "can_edit_users";
$regpermissions[] = "can_view_offline";
$regpermissions[] = "can_create_comments";
$regpermissions[] = "can_edit_comments";
$regpermissions[] = 'can_delete_comments';
$regperm = serialize($regpermissions);

$cache3 = "INSERT INTO {$prefix}cache (name, content)
VALUES
('regperms','{$regperm}')";

$adminpermissions[] = 'admin:can_manage_pages';
$adminpermissions[] = 'admin:can_edit_users';
$adminpermissions[] = 'admin:can_view_adminlogs';
$adminpermissions[] = 'admin:can_edit_adminperms';
$adminpermissions[] = 'admin:can_edit_adminlevels';
$adminpermissions[] = 'admin:can_edit_usergroups';
$adminperm = serialize($adminpermissions);

$cache4 = "INSERT INTO {$prefix}cache (name, content)
VALUES
('adminperms','{$adminperm}')";
$cache5 = "INSERT INTO {$prefix}cache (name)
VALUES
('lastadminlogins')";
$cache6 = "INSERT INTO {$prefix}cache (name, content)
VALUES
('cacheexpiry','300')";
?>