<?php
/*
MillionCMS Project
    
    Name: AdminCP Table Inserts
    Description: Contains the data to create/insert data for the ACP.

    Author: Kyuubi, Azareal and Damian

    Copyright (c) 2010 Kyuubi, Azareal and MillionCMS Group
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

	File should read like this:
	$create_admin_template (used for creating the Admin Templates table
	$insert1 (increment the number for no of templates)
*/

$create1 = "CREATE TABLE {$prefix}admin_templates
	(
		tid mediumint(20) NOT NULL AUTO_INCREMENT,
		PRIMARY KEY(tid),
		name varchar(100) collate utf8_general_ci,
		content longtext collate utf8_general_ci,
		templateset int(11) DEFAULT 0
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 
COLLATE=utf8_general_ci";

$create2 = "CREATE TABLE {$prefix}admin_styles
	(
		setid mediumint(20) NOT NULL AUTO_INCREMENT,
		PRIMARY KEY(setid),
		name varchar(50) collate utf8_general_ci,
		stylesheet longtext collate utf8_general_ci,
		fname varchar(80) collate utf8_general_ci,
		is_default tinyint(2) DEFAULT 0 NOT NULL
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 
COLLATE=utf8_general_ci";

$create3 = "CREATE TABLE {$prefix}admin_logs
	(
		logid bigint(30) NOT NULL AUTO_INCREMENT,
		PRIMARY KEY(logid),
		time bigint(30) DEFAULT 0 NOT NULL,
		script varchar(50) collate utf8_general_ci,
		uid mediumint(20) DEFAULT 0 NOT NULL,
		ipaddress varchar(50) collate utf8_general_ci,
		action varchar(40) collate utf8_general_ci,
		itable varchar(50) collate utf8_general_ci,
		detail text collate utf8_general_ci
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 
COLLATE=utf8_general_ci";

$insert1 = "INSERT INTO {$prefix}admin_templates (name, templateset, content)
VALUES
('admin_index','2','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<title>ACP Login | MillionCMS</title>
<meta name=\"description\" content=\"\" />
<meta name=\"keywords\" content=\"\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"css/login_style.css\" title=\"style\" media=\"screen\" /> 


    <script type=\"text/javascript\" src=\"js/jquery-1.4.2.js\"></script> 
    <script type=\"text/javascript\" src=\"js/jquery-ui-1.8.1.custom.min.js\"></script> 
    <script type=\"text/javascript\" src=\"js/jquery.easing.1.3.js\"></script>         
    <script type=\"text/javascript\" src=\"js/jquery-AeroWindow.js\"></script>        
    <script type=\"text/javascript\" src=\"js/twitter_alert.js\"></script>
	
	<script type=\"text/javascript\">
	/* <![CDATA[ */
	\$(document).ready(function(){
			\$(\".block\").fadeIn(1000);  
			\$(\".idea\").fadeIn(1000);
			\$(\'.idea\').supersleight();
			\$(\'#username\').example(\'Username\');
			\$(\'#password\').example(\'Password\');
	});
	/* ]]> */
	</script>
	<script type=\"text/javascript\">
		if (top.location != location)
		{
			top.location.href = document.location.href ;
		}
	</script>
	<script type=\"text/javascript\" src=\"js/jquery.jgrowl.js\"></script>
	<link rel=\"stylesheet\" href=\"js/jquery.jgrowl.css\" type=\"text/css\"/> 

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<style type=\"text/css\">
a:link {
	color: #FFF;
}
a:visited {
	color: #FFF;
}
a:hover {
	color: #CCC;
}
a:active {
	color: #FFF;
}
</style>
</head>
<body>

<!-- Error System (Messages) -->
{\$no_user_specified}
{\$no_pass_specified}
{\$login_fail}
<div id=\"wrap\">
            <div class=\"idea\">
            <img src=\"images/info.png\" alt=\"\"/>
            <p>Welcome to MillionCMS! Please enter your details below...</p>
            </div>
            
            <div class=\"error\">
            <img src=\"images/error_2.png\" alt=\"\"/>
            <p>Alpha Two Admin Control Panel now baking...</p>
            </div>
<div class=\"block\">
            <form action=\"?\" method=\"post\">
            <div class=\"left\"></div>
            <div class=\"right\">
                <div class=\"div-row\">{literal}
                	<input type=\"text\" id=\"username\" name=\"username\"  onfocus=\"this.value=\'\';\" onblur=\"if (this.value==\'\') {this.value=\'Username\';}\" value=\"Username\" />
									</div>
				<div class=\"div-row\">
					<input type=\"password\" id=\"password\" name=\"password\" onfocus=\"this.value=\'\';\" onblur=\"if (this.value==\'\') {this.value=\'************\';}\" value=\"************\" />
				</div>{/literal}
				<div class=\"rm-row\">
					<input type=\"checkbox\" value=\"c\" name=\"rm\" id=\"remember\"/> <label for=\"remember\">Remember me?</label>
				</div>
                <div class=\"send-row\">
                    <button id=\"login\" value=\"adminlogin\" type=\"submit\" name=\"login\"></button>
                </div>
            </div>
            </form>
        </div>
  <center><a href=\"{\$mcms->settings.homeurl}\"><img src=\"images/logo.png\" width=\"312\" height=\"600\" /></a><br /></center>
    <div id=\"copyright\" align=\"center\"><span style=\"color:#FFF; margin:3px 0;\">Copyright&copy; 2010 MillionCMS - <a href=\"http://millioncms.com\">Home Page</a> - <a href=\"http://millioncms.com/forums\">Support</a></span></div>
    </div>
</body>
</html>')";

// Now to begin inserting the normal view style.
$normal_view = "INSERT INTO {$prefix}admin_styles (name, fname, setid)
VALUES
('normal_view','Normal View','1')";

$setid = 1;

$ntemplate1 = "INSERT INTO {$prefix}admin_templates (name, templateset, content)
VALUES
('admin_start','{$setid}','<html>
  <head>
    <title>Admin Center | MillionCMS</title>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
    <link href=\"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css\" rel=\"stylesheet\" type=\"text/css\" />    
    <link href=\"../css/AeroWindow.css?r=123\" rel=\"stylesheet\" type=\"text/css\" />
    <script type=\"text/javascript\" src=\"../js/jquery-1.4.2.min.js\"></script> 
    <script type=\"text/javascript\" src=\"../js/jquery-ui-1.8.1.custom.min.js\"></script> 
    <script type=\"text/javascript\" src=\"../js/jquery.easing.1.3.js\"></script>         
    <script type=\"text/javascript\" src=\"../js/jquery-AeroWindow.js\"></script>        
    <script type=\"text/javascript\" src=\"../js/twitter_alert.js\"></script>
    
    <script type=\"text/javascript\">
    \$(document).ready(function() {
	 \$(\'#home\').click(function() {
          \$(\'#home_app\').AeroWindow({
            WindowTitle:          \'Home | MillionCMS\',
            WindowPositionTop:    \'center\',
            WindowPositionLeft:   \'center\',
            WindowWidth:          1100,
            WindowHeight:         500,
            WindowAnimation:      \'easeOutCubic\'
          });
        });
		
        \$(\'#pages\').click(function() {
          \$(\'#pages_app\').AeroWindow({
            WindowTitle:          \'Pages | MillionCMS\',
            WindowPositionTop:    \'center\',
            WindowPositionLeft:   \'center\',
            WindowWidth:          1100,
            WindowHeight:         500,
            WindowAnimation:      \'easeOutCubic\'
          });
        });
		
        \$(\'#settings\').click(function() {
          \$(\'#settings_app\').AeroWindow({
            WindowTitle:          \'Settings | MillionCMS\',
            WindowPositionTop:    \'center\',
            WindowPositionLeft:   \'center\',
            WindowWidth:          1100,
            WindowHeight:         500,
            WindowAnimation:      \'easeOutCubic\'
          });
        });
		
        \$(\'#members\').click(function() {
          \$(\'#members_app\').AeroWindow({
            WindowTitle:          \'Members | MillionCMS\',
            WindowPositionTop:    \'center\',
            WindowPositionLeft:   \'center\',
            WindowWidth:          1100,
            WindowHeight:         500,
            WindowAnimation:      \'easeOutCubic\'
          });
        });
		
        \$(\'#help\').click(function() {
          \$(\'#help_app\').AeroWindow({
            WindowTitle:          \'Help &amp; Support | MillionCMS\',
            WindowPositionTop:    \'center\',
            WindowPositionLeft:   \'center\',
            WindowWidth:          1100,
            WindowHeight:         500,
            WindowAnimation:      \'easeOutCubic\'
          });
        });
		
        \$(\'#change_bg\').click(function() {
          \$(\'#change_bg_app\').AeroWindow({
            WindowTitle:          \'Change Background | MillionCMS\',
            WindowPositionTop:    \'center\',
            WindowPositionLeft:   \'center\',
            WindowWidth:          1100,
            WindowHeight:         500,
            WindowAnimation:      \'easeOutCubic\'
          });
        });
	});
    </script>
    <style>
      body {
        background: #000 url(../images/backgrounds/normal_view_bg.jpg);
      }
      #iconContainer {
        position: absolute;
        top:      10px;
        left:     5px;
        width:    auto;
        height:   auto;
      }
      #iconContainer div {
        width:    70px;
        height:   70px;
        margin-bottom: 10px;
      }
    </style>
  </head>
  <body>
  
  <!-- Message\'s for User -->
  <div id=\"msg_welcome\" style=\"display:none;\"> Welcome to MillionCMS! Your Session is loading...</div>
  <div id=\"msg_error\" style=\"display:none;\"> Warning: There has been an error - #xxxx</div>
  <div id=\"msg_saved\" style=\"display:none;\"> Setting\'s Saved</div>
  <div id=\"msg_loading\" style=\"display:none;\"> Loading...</div>
  <!-- End Message\'s for User -->
  
  <script type=\"text/javascript\">
	\$(document).ready(function () {
					\$(\'#msg_welcome\').twitter_alert({
				fadeout_time: 3500
			});
		});
</script>
<div id=\"wrap_normal\">
	<div id=\"extra\" align=\"right\">
		<a href=\"../logout.php\"><img id=\"logout\" border=\"0\" src=\"../images/normal_view/logout.png\"></a>
	</div>
	<div id=\"logo_wrap\">
		<a href=\"{\$mcms->settings[\'homeurl\']}\"><img style=\"position:absolute;bottom:25;\" src=\"../images/normal_view/logo.png\"></a>
		<a href=\"#\"><img id=\"change_bg\" style=\"position:absolute;bottom:0;\" border=\"0\" src=\"../images/normal_view/bg_change.png\"></a>
	</div>
	<div id=\"iconContainer\">
		<div id=\"home\"><img src=\"../images/normal_view/home.png\"></div>
		<div id=\"pages\"><img src=\"../images/normal_view/pages.png\"></div>
		<div id=\"settings\"><img src=\"../images/normal_view/settings.png\"></div>
		<div id=\"members\"><img src=\"../images/normal_view/members.png\"></div>
		<div id=\"blank\"><img src=\"../images/normal_view/blank.png\"></div>
		<div id=\"help\"><img src=\"../images/normal_view/help.png\"></div>
	</div>
	<!-- Home -->
	<div id=\"home_app\" style=\"display: none;\">
	<iframe src=\"home_main.php\" width=\"100%\" height=\"100%\" style=\"border: 0px;\" frameborder=\"0\"></iframe>
	<div id=\"iframeHelper\"></div>
	</div>
	<!-- Pages -->
	<div id=\"pages_app\" style=\"display: none;\">
		<iframe src=\"add_article.php\" width=\"100%\" height=\"100%\" style=\"border: 0px;\" frameborder=\"0\"></iframe>
		<div id=\"iframeHelper\"></div>
	</div>
	<!-- Settings -->
	<div id=\"settings_app\" style=\"display: none;\">
		<iframe src=\"general_settings.php\" width=\"100%\" height=\"100%\" style=\"border: 0px;\" frameborder=\"0\"></iframe>
		<div id=\"iframeHelper\"></div>
	</div>
	<!-- Members -->
	<div id=\"members_app\" style=\"display: none;\">
		<iframe src=\"users.php\" width=\"100%\" height=\"100%\" style=\"border: 0px;\" frameborder=\"0\"></iframe>
		<div id=\"iframeHelper\"></div>
	</div>
	<!-- Help -->
	<div id=\"help_app\" style=\"display: none;\">
		<iframe src=\"help.php\" width=\"100%\" height=\"100%\" style=\"border: 0px;\" frameborder=\"0\"></iframe>
		<div id=\"iframeHelper\"></div>
	</div>
	<!-- Change Background -->
		<div id=\"change_bg_app\" style=\"display: none;\">
			<iframe src=\"visual_preferences.php\" width=\"100%\" height=\"100%\" style=\"border: 0px;\" frameborder=\"0\"></iframe>
			<div id=\"iframeHelper\"></div>
		</div>
	</div>
	</body>  
</html>')";

// Now to begin inserting the normal view style.
$advance_view = "INSERT INTO {$prefix}admin_styles (name, fname, is_default, setid)
VALUES
('advance_view','Advanced View','1','2')";

$setid2 = 2;

$atemplate1 = "INSERT INTO {$prefix}admin_templates (name, templateset, content)
VALUES
('admin_redirect','{$setid2}','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<title>ACP Login | MillionCMS</title>
<meta name=\"description\" content=\"\" />
<meta name=\"keywords\" content=\"\" />
<meta http-equiv=\"refresh\" content=\"5;url=modules/home_main.php\">
<link rel=\"stylesheet\" type=\"text/css\" href=\"css/login_style.css\" title=\"style\" media=\"screen\" />
</head>
<body>
<div id=\"wrap\">
        <div class=\"idea\">
            <img src=\"images/info.png\" alt=\"Information\"/>
            <p>Going to the Admin Control Panel...</p>
        </div>

        <div class=\"block\">
            <div class=\"left\"></div>
            <div class=\"right\" align=\"center\"><br /><br />
            <img align=\"absmiddle\" src=\"images/loader_bar.gif\"><br />&nbsp;Processing your Request...
          </div>
        </div>
  <center><a href=\"{\$mcms->settings.homeurl}\"><img src=\"images/logo.png\" alt=\"MillionCMS\" width=\"312\" height=\"600\" /></a><br /></center>
    <div id=\"copyright\" align=\"center\"><span style=\"color:#FFF; margin:3px 0;\">Copyright&copy; 2010 MillionCMS - <a href=\"http://millioncms.com\">Home Page</a> - <a href=\"http://millioncms.com/forums\">Support</a></span></div>
    </div>        
</div>
</body>
</html>')";

$atemplate2 = "INSERT INTO {$prefix}admin_templates (name, templateset, content)
VALUES
('admin_start','{$setid2}','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>Welcome | MillionCMS ACP</title>
<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/admin.css\"/>
<script type=\"text/javascript\" src=\"../js/jquery-1.4.2.js\"></script> 
<script type=\"text/javascript\" src=\"../js/jquery-ui-1.8.1.custom.min.js\"></script> 
<script type=\"text/javascript\" src=\"../js/jquery.easing.1.3.js\"></script>         
<script type=\"text/javascript\" src=\"../js/jquery-AeroWindow.js\"></script>        
<script type=\"text/javascript\" src=\"../js/twitter_alert.js\"></script>
<script src=\"../js/categories.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
<script src=\"../js/lists.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
<script src=\"../js/current_date.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
<script type=\"text/javascript\" src=\"../../js/jquery.jgrowl.js\"></script>
<link rel=\"stylesheet\" href=\"../../js/jquery.jgrowl.css\" type=\"text/css\"/>
<style>
a:link {
	color: #000;
}
a:visited {
	color: #000;
}
a:hover {
	color: #000;
}
a:active {
	color: #000;
}
</style>

</head>
<body style=\"argin-left: auto; margin-right: auto; text-align: center; vertical-align: center; height:100%; background:url(../images/silhouette_building.png); background-position:center; background-repeat:no-repeat;\">

<!-- Message\'s for User -->
  <div id=\"msg_welcome\" style=\"display:none;\"> Welcome to the {\$mcms->settings.site_name} Admin Control Panel! Your Session is loaded.</div>
<!-- End Message\'s for User -->
<script type=\"text/javascript\">
	\$(document).ready(function () {
					\$(\'#msg_welcome\').twitter_alert({
						fadeout_time: 3500
			});
		});
</script>
	<!-- Because the person whom made this page is a total idiot, he has no idea how to align this div in the center of a screen, and then make the background resize with the screen res... -->
	<div style=\"height:1000px;\">
	<img src=\"../images/welcome_logo.png\" width=\"800\" height=\"350\" />
	<br />
	<span style=\"color:#000; font-weight:3000;\">{\$mcms->settings.site_name}</span>
	<br /><br />
	<span style=\"color:#000; font-weight:3000;\">Your version of MillionCMS is up-to-date!</span>
	<br /><br />
	<span style=\"color:#000; font-weight:3000; font-size:30px;\"><u><a href=\"home_main.php\">Enter your Admin Control Panel &gt;</a></u></span>
	</div>
</body>
</html>')";

$atemplate3 = "INSERT INTO {$prefix}admin_templates (name, templateset, content)
VALUES
('header_includes','{$setid2}','<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/admin.css\"/>
<script type=\"text/javascript\" src=\"../js/jquery-1.4.2.js\"></script> 
<script type=\"text/javascript\" src=\"../js/jquery-ui-1.8.1.custom.min.js\"></script> 
<script type=\"text/javascript\" src=\"../js/jquery.easing.1.3.js\"></script>         
<script type=\"text/javascript\" src=\"../js/jquery-AeroWindow.js\"></script>        
<script type=\"text/javascript\" src=\"../js/twitter_alert.js\"></script>
<script src=\"../js/categories.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
<script src=\"../js/lists.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
<script src=\"../js/current_date.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
<script type=\"text/javascript\" src=\"../../js/jquery.jgrowl.js\"></script>
<link rel=\"stylesheet\" href=\"../../js/jquery.jgrowl.css\" type=\"text/css\"/>')";

$atemplate4 = "INSERT INTO {$prefix}admin_templates (name, templateset, content)
VALUES
('header','{$setid2}','<div id=\"header\">
		<div id=\"logo\">{\$mcms->settings.site_name}<span class=\"slogan\">Admin Panel</span>
	</div>
	<div id=\"info\">
		<div id=\"forum-name\">
			Welcome to MillionCMS
		</div>
	</div>
<ul id=\"navigation\">
	<li><a href=\"home_main.php\">Admin Home</a></li>
	<li class=\"right\"><a href=\"../../../index.php\">Return to your Site &raquo;</a></li>
	<li class=\"user\">You are logged in as {\$mcms->user.username} - <a href=\"../logout.php\" >Log Out?</a></li>
	</ul>
</div>')";

$atemplate5 = "INSERT INTO {$prefix}admin_templates (name, templateset, content)
VALUES
('sidebar','{$setid2}','<ul id=\"category\">
          	<li class=\"first heading\"><a href=\"javascript:void(0)\"><img src=\"../icons/application_double.png\" width=\"16\" height=\"16\" border=\"0\" /> Home</a></li>
               <ul>
                    <li><a href=\"home_main.php\"><img src=\"../icons/application_double.png\" width=\"16\" height=\"16\" border=\"0\" /> Admin Home</a></li>
                    <li><a href=\"admin_options.php\"><img src=\"../icons/cog.png\" width=\"16\" height=\"16\" border=\"0\" /> Admin Options</a></li>
                    <li><a href=\"visual_preferences.php\"><img src=\"../icons/script_palette.png\" width=\"16\" height=\"16\" border=\"0\" /> Visual Preferences</a></li>
               </ul>
          </ul>
          <ul id=\"category\">
          	<li class=\"heading\"><a href=\"javascript:void(0)\"><img src=\"../icons/page_gear.png\" width=\"16\" height=\"16\" border=\"0\" /> Articles/Categories</a></li>
               <ul>
                    <li><a href=\"add_article.php\"><img src=\"../icons/page_add.png\" width=\"16\" height=\"16\" border=\"0\" /> Add a New Article</a></li>
                    <li><a href=\"#\"><img src=\"../icons/page_edit.png\" width=\"16\" height=\"16\" border=\"0\" /> Manage Articles</a></li>
                    <li><a href=\"#\"><img src=\"../icons/page_gear.png\" width=\"16\" height=\"16\" border=\"0\" /> Article Settings</a></li>
					<br />
                    <li><a href=\"#\"><img src=\"../icons/table_add.png\" width=\"16\" height=\"16\" border=\"0\" /> Add a New Category</a></li>
                    <li><a href=\"#\"><img src=\"../icons/table_go.png\" width=\"16\" height=\"16\" border=\"0\" /> Manage Categories</a></li>                    
                    <li><a href=\"#\"><img src=\"../icons/table_multiple.png\" width=\"16\" height=\"16\" border=\"0\" /> Manage Sections</a></li>
                    <li><a href=\"#\"><img src=\"../icons/table_gear.png\" width=\"16\" height=\"16\" border=\"0\" /> Category Settings</a></li>
                    <br />
                    <li><a href=\"#\"><img src=\"../icons/bin.png\" width=\"16\" height=\"16\" border=\"0\" /> Article Trash</a></li>
                    <li><a href=\"#\"><img src=\"../icons/layout_sidebar.png\" width=\"16\" height=\"16\" border=\"0\" /> Front Page Settings</a></li>
               </ul>
          </ul>
          <ul id=\"category\">
          	<li class=\"heading\"><a href=\"javascript:void(0)\"><img src=\"../icons/palette.png\" width=\"16\" height=\"16\" border=\"0\" /> Look and Feel</a></li>
               <ul>
                    <li><a href=\"template_m_home.php\"><img src=\"../icons/palette.png\" width=\"16\" height=\"16\" border=\"0\" /> Template Manager</a></li>
                    <li><a href=\"template_m_editor.php\"><img src=\"../icons/palette_edit.png\" width=\"16\" height=\"16\" border=\"0\" /> Theme Editor</a></li>
                    <li><a href=\"#\"><img src=\"../icons/disk.png\" width=\"16\" height=\"16\" border=\"0\" /> Import and Export</a></li>
               </ul>
          </ul>
          <ul id=\"category\">
          	<li class=\"heading\"><a href=\"javascript:void(0)\"><img src=\"../icons/application_xp_terminal.png\" width=\"16\" height=\"16\" border=\"0\" /> Extensions</a></li>
               <ul>
					<li><a href=\"ext_manage.php\"><img src=\"../icons/application_view_tile.png\" width=\"16\" height=\"16\" border=\"0\" /> Extension Manager</a></li>
					<li><a href=\"ext_install.php\"><img src=\"../icons/application_xp_terminal.png\" width=\"16\" height=\"16\" border=\"0\" /> Install/Uninstall</a></li>
					<li><a href=\"ext_plugins.php\"><img src=\"../icons/plugin.png\" width=\"16\" height=\"16\" border=\"0\" /> Plugins</a></li>
					<li><a href=\"ext_gadgets.php\"><img src=\"../icons/plugin.png\" width=\"16\" height=\"16\" border=\"0\" /> Gadgets</a></li>
					<li><a href=\"ext_bridge.php\"><img src=\"../icons/arrow_switch.png\" width=\"16\" height=\"16\" border=\"0\" /> Bridge Manager</a></li>
					<li><a href=\"ext_official.php\"><img src=\"../icons/asterisk_orange.png\" width=\"16\" height=\"16\" border=\"0\" /> MillionCMS Official</a></li>
               </ul>
          </ul>
          <ul id=\"category\">
          	<li class=\"heading\"><a href=\"javascript:void(0)\"><img src=\"../icons/cup.png\" width=\"16\" height=\"16\" border=\"0\" /> Settings</a></li>
               <ul>
                    <li><a href=\"general_settings.php\"><img src=\"../icons/brick.png\" width=\"16\" height=\"16\" border=\"0\" /> General Settings</a></li>
                    <li><a href=\"user_settings.php\"><img src=\"../icons/cog_add.png\" width=\"16\" height=\"16\" border=\"0\" /> User Settings</a></li>
                    <li><a href=\"#\"><img src=\"../icons/cup.png\" width=\"16\" height=\"16\" border=\"0\" /> User Creation</a></li>
                    <li><a href=\"#\"><img src=\"../icons/door_in.png\" width=\"16\" height=\"16\" border=\"0\" /> System</a></li>
                    <li><a href=\"server.php\"><img src=\"../icons/drive.png\" width=\"16\" height=\"16\" border=\"0\" /> Server</a></li>
                    <li><a href=\"backup.php\"><img src=\"../icons/computer_add.png\" width=\"16\" height=\"16\" border=\"0\" /> Backup System</a></li>
                    <br />
                    <li><a href=\"adminlogs.php\"><img src=\"../icons/application_view_columns.png\" width=\"16\" height=\"16\" border=\"0\" /> Admin Logs</a></li>
                    <li><a href=\"sql_inject.php\"><img src=\"../icons/import.png\" width=\"16\" height=\"16\" border=\"0\" /> SQL Inject</a></li>
                    <li><a href=\"#\"><img src=\"../icons/email_add.png\" width=\"16\" height=\"16\" border=\"0\" /> Send Mass Mail</a></li>
               </ul>
          </ul>
          <ul id=\"category\">
          	<li class=\"heading\"><a href=\"javascript:void(0)\"><img src=\"../icons/user.png\" width=\"16\" height=\"16\" border=\"0\" /> Users</a></li>
               <ul>
                    <li><a href=\"users.php\"><img src=\"../icons/user.png\" width=\"16\" height=\"16\" border=\"0\" /> Account Manager</a></li>
                    <li><a href=\"add_member.php\"><img src=\"../icons/user_add.png\" width=\"16\" height=\"16\" border=\"0\" /> Add a User</a></li>
                    <li><a href=\"#\"><img src=\"../icons/user_delete.png\" width=\"16\" height=\"16\" border=\"0\" /> Delete a User</a></li>
                    <br />
                    <li><a href=\"usergroups.php\"><img src=\"../icons/group.png\" width=\"16\" height=\"16\" border=\"0\" /> User Groups</a></li>
               </ul>
          </ul>
          <ul id=\"category\">
   	  <li class=\"heading\"><a href=\"javascript:void(0)\"><img src=\"../icons/bullet_orange.png\" width=\"16\" height=\"16\" border=\"0\" /> Million Manager</a></li>
               <ul>
                    <li><a href=\"manager.php?action=menu\"><img src=\"../icons/bullet_green.png\" width=\"16\" height=\"16\" border=\"0\" /> Menu Manager</a></li>
                    <li><a href=\"manager.php?action=files\"><img src=\"../icons/bullet_orange.png\" width=\"16\" height=\"16\" border=\"0\" /> Files Manager</a></li>
                    <li><a href=\"manager.php?action=language\"><img src=\"../icons/bullet_pink.png\" width=\"16\" height=\"16\" border=\"0\" /> Language Manager</a></li>
                    <br />
                    <li><a href=\"manager.php?action=backup\"><img src=\"../icons/bullet_purple.png\" width=\"16\" height=\"16\" border=\"0\" /> Backup Manager</a></li>
                    <li><a href=\"manager.php?action=cache\"><img src=\"../icons/bullet_red.png\" width=\"16\" height=\"16\" border=\"0\" /> Cache Manager</a></li>
               </ul>
          </ul>')";
$atemplate6 = "INSERT INTO {$prefix}admin_templates (name, templateset, content)
VALUES
('admin_main_content','{$setid2}','<br />
<br />
<table width=\"100%\" border=\"0\">
  <tr>
    <td width=\"25%\">
      <img src=\"../icons/cog_edit.png\" width=\"16\" height=\"16\" /> 
      <a href=\"#\">Edit System Settings
      </a>
    </td>
    <td width=\"25%\">
      <img src=\"../icons/comments.png\" width=\"16\" height=\"16\" /> 
      <a href=\"#\">Manage Articles
      </a>
    </td>
    <td width=\"25%\">
      <img src=\"../icons/key.png\" width=\"16\" height=\"16\" /> 
      <a href=\"general_settings.php\">Turn Website On/Off
      </a>
    </td>
    <td width=\"25%\">
      <img src=\"../icons/palette.png\" width=\"16\" height=\"16\" /> 
      <a href=\"template_m_home.php\">Theme Manager
      </a>
    </td>
  </tr>
  <tr>
    <td width=\"25%\">
      <img src=\"../icons/group.png\" width=\"16\" height=\"16\" /> 
      <a href=\"usergroups.php\">Manage User Groups
      </a>
    </td>
    <td width=\"25%\">
      <img src=\"../icons/user_add.png\" width=\"16\" height=\"16\"/> 
      <a href=\"users.php\">Manage Users
      </a>
    </td>
    <td width=\"25%\">
      <img src=\"../icons/database_refresh.png\" width=\"16\" height=\"16\" /> 
      <a href=\"sql_inject.php\">Run Direct SQL Code
      </a>
    </td>
    <td width=\"25%\">
      <img src=\"../icons/emoticon_grin.png\" width=\"16\" height=\"16\"/> 
      <a href=\"manager.php?action=cache\">Cache Manager
      </a>
    </td>
  </tr>
</table>
<br/>
<table width=\"100%\" border=\"0\">
  <tr>
    <td width=\"50%\">
      <table width=\"100%\" border=\"0\">
        <tr>
          <td width=\"47.5%\">
            <span class=\"section-title\">Quick Admin Search
            </span>
            <br/>
            <table width=\"100%\" border=\"0\">
              <tr>
                <td width=\"50%\">
                  <span class=\"bold\">Member Search
                  </span>
                </td>
                <td width=\"50%\">
                  <form id=\"search_tools\" method=\"post\" action=\"\">
                    <label for=\"member_search\">
                    </label>
                    <input class=\"input\" type=\"text\" name=\"textfield\" id=\"textfield\" />
                  </form>
                </td>
              </tr>
              <tr>
                <td width=\"50%\">
                  <span class=\"bold\">Setting Search
                  </span>
                </td>
                <td width=\"50%\">
                  <label for=\"setting_search\">
                  </label>
                  <input class=\"input\" type=\"text\" name=\"textfield2\" id=\"textfield2\"/> 
                </form>
                </td>
              </tr>
              <tr>
                <td width=\"50%\">
                  <span class=\"bold\">IP Addresses Search
                  </span>
                </td>
                <td width=\"50%\">
                  <label for=\"ip_search\">
                  </label>
                  <input class=\"input\" type=\"text\" name=\"ip_search\" id=\"textfield3\" /> 
                </form>
                </td>
              </tr>
            </table>
            <p align=\"center\">
              <input class=\"input\" name=\"search\" type=\"submit\" value=\"Start Search\" />
            </p>
          </form>
          </td>
        </tr>
        <tr>
          <td>
            <span class=\"section-title\">Admin Notes
            </span>
            <br/>
            <form action=\"{\$_SERVER['PHP_SELF']}\" method=\"post\">
              <textarea class=\"notes\" name=\"admin_notes\" id=\"textarea\" rows=\'12\' cols=\'50\'>{\$adminnotes}</textarea>
                <br/>
                <input class=\"input\" name=\"insert_notes\" type=\"submit\" value=\"Save Notes\"/>
              </form>
          </td>
        </tr>
      </table>
    </td>
    <td width=\"50%\">
      <span class=\"section-title\">Website Infomation Center
      </span>
      <br/>
      <table width=\"100%\" border=\"0\">
        <tr>
          <td width=\"50%\">
            <span class=\"bold\">
              <u>Member Infomation
              </u>
            </span>
          </td>
          <td width=\"50%\">&nbsp;
          </td>
        </tr>
        <tr>
          <td width=\"50%\">
            <span class=\"text\">Total Members:
            </span>
          </td>
          <td width=\"50%\">
            <span class=\"text\"><a href=\"./users.php\">{\$totalusers}</a>
            </span>
          </td>
        </tr>
        <tr>
          <td width=\"50%\">
            <span class=\"text\">Online Members:
            </span>
          </td>
          <td width=\"50%\">
            <span class=\"text\"><a href=\"./users.php?status=online\">{\$onlineusers}</a>
            </span>
          </td>
        </tr>
        <tr>
          <td width=\"50%\">
            <span class=\"text\">Awaiting Validation:
            </span>
          </td>
          <td width=\"50%\">
            <span class=\"text\"><a href=\"./users.php?status=inactive\">{\$inactive}</a>
            </span>
          </td>
        </tr>
        <tr>
          <td width=\"50%\">&nbsp;
          </td>
          <td width=\"50%\">&nbsp;
          </td>
        </tr>
        <tr>
          <td width=\"50%\">
            <span class=\"bold\">
              <u>Article Infomation
              </u>
            </span>
          </td>
          <td width=\"50%\">&nbsp;
          </td>
        </tr>
        <tr>
          <td width=\"50%\">
            <span class=\"text\">Total Articles:
            </span>
          </td>
          <td width=\"50%\">
            <span class=\"text\">{\$totalpages}
            </span>
          </td>
        </tr>
        <tr>
          <td width=\"50%\">
            <span class=\"text\">Total Drafts:
            </span>
          </td>
          <td width=\"50%\">
            <span class=\"text\">Draft\'s not yet created...
            </span>
          </td>
        </tr>
        <tr>
          <td width=\"50%\">&nbsp;
          </td>
          <td width=\"50%\">&nbsp;
          </td>
        </tr>
        <tr>
          <td width=\"50%\">
            <span class=\"bold\">
              <u>Article Comment Infomation
              </u>
            </span>
          </td>
          <td width=\"50%\">&nbsp;
          </td>
        </tr>
        <tr>
          <td width=\"50%\">
            <span class=\"text\">Total Comments:
            </span>
          </td>
          <td width=\"50%\">
            <span class=\"text\">{\$totalcomments)
            </span>
          </td>
        </tr>
		<tr>
          <td width=\"50%\">&nbsp;
          </td>
          <td width=\"50%\">&nbsp;
          </td>
        </tr>
		<tr>
          <td width=\"50%\">
            <span class=\"bold\">
              <u>Technical Statistics :
              </u>
            </span>
          </td>
          <td width=\"50%\">&nbsp;
          </td>
        </tr>
		<tr>
          <td width=\"50%\">
            <span class=\"text\">Server Load:
            </span>
          </td>
          <td width=\"50%\">
            <span class=\"text\">{\$serverload}
            </span>
          </td>
        </tr>
      </table>
      <p>
        <span class=\"section-title\">
        Latest Admin Login\'s
        </span>
        <br/>
        1. {\$lastlogin}
        <br />
        2. -
        <br />
        3. -
        <br />
        4. -
        <br/>
      </p>
</table>
</td>
</tr>
</table>
<br/><br/>
<span class=\"section-title\">The Development Team at MillionCMS
</span>
<span class=\"bold\">
  <br/>
  <table width=\"100%\" border=\"0\">
    <tr>
      <td width=\"20%\">
        <strong>Management Members
        </strong>
      </td>
      <td width=\"20%\">
        <strong>Developer Team Members
        </strong>
      </td>
      <td width=\"20%\">
        <strong>Support Team Members
        </strong>
      </td>
      <td width=\"20%\">
        <strong>SQA  Team Members</strong>
      </td>
	  <td width=\"20%\">
		<strong>Public Relations</strong>
	  </td>
    </tr>
    <tr>
      <td width=\"20%\"><i>Gordon Hughes</i></td>
      <td width=\"20%\"><span title=\"Damian\">Damian Sharpe</span></td>
      <td width=\"20%\">Josh R.</td>
	  <td width=\"20%\">Austin</td>
	  <td width=\"20%\"><i><span title=\"Chaos\">Derek M</span></i></td>
      </tr>
    <tr>
      <td width=\"20%\"><i>Azareal</i></td>
      <td width=\"20%\"><span title=\"Raninf\">Steven Shao</span></td>
      <td width=\"20%\"><i><span title=\"Darkly\">Justin L.</span></i></td>
      <td width=\"20%\"><span title=\"Dimon\">Aashik Poonja</span></td>
    </tr>
    <tr>
	 <td width=\"20%\">Tom Holmes</td>
     <td width=\"20%\"><span title=\"Poiuyt580\">Steven</span></td>
      <td width=\"20%\">&nbsp;</td>
      <td width=\"20%\">amon91</td>
    </tr>
    <tr>
      <td width=\"20%\"><span title=\"Polarbear541\">Kieran Dunbar</span></td>
      <td width=\"20%\"><span title=\"Malietjie\">Andre Merwe</span></td>
      <td width=\"20%\">&nbsp;</td>
      <td width=\"20%\">&nbsp;</td>
    </tr>
    <tr>
      <td width=\"20%\">&nbsp;</td>
      <td width=\"20%\">Lee Merriman</td>
      <td width=\"20%\">&nbsp;</td>
      <td width=\"20%\">&nbsp;</td>
    </tr>   
    <tr>
      <td width=\"20%\">&nbsp;</td>
      <td width=\"20%\"></td>
      <td width=\"20%\">&nbsp;</td>
      <td width=\"20%\">&nbsp;</td>
    </tr>
  </table>
</span>
</div>')";
?>