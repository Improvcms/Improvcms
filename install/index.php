<?php
/*
ImprovCMS Project
    
    Name: Installer
    Description: Main Installer File

    Author: Kieran D, Gaara

    Copyright © 2010 Gaara, Kieran D and Improv Software Group
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

require_once("./resources/functions.php");
error_reporting(0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="./style.css" media="screen" />
	<title>ImprovCMS Install</title>
</head>
<body>

   <div id="wrapper">
   
		<div id="header">
			<img src="../images/logo.png" alt="ImprovCMS Installer" />		 
		</div>
		
		<?php
		$action = $_REQUEST['action'];	 

		if(file_exists('lock'))
		{
			$action = "locked";
		}
		
		switch ($action)
		{
			case 'licence':			
			echo "<div id='navigation'>Overview - <b>Licence</b> - DB Details - Creating Admin - Settings - Admin Details - Finish</div>";			
			echo "<div id='content'>";
			licence();
			break;			
			
			case 'database':			
			echo "<div id='navigation'>Overview - Licence - <b>DB Details</b> - Creating Admin - Settings - Admin Details - Finish</div>";			
			echo "<div id='content'>";
			database();
			break;		
			
			case 'do_database':			
			echo "<div id='navigation'>Overview - Licence - <b>DB Details</b> - Settings - Admin Details - Finish</div>";			
			echo "<div id='content'>";
			do_database();
			break;
			
			case 'do_database_admin':			
			echo "<div id='navigation'>Overview - Licence - DB Details - <b>Creating Admin</b> - Settings - Admin Details - Finish</div>";			
			echo "<div id='content'>";
			do_database_admin();
			break;
			
			case 'settings':			
			echo "<div id='navigation'>Overview - Licence - DB Details - <b>Settings</b> - Admin Details - Finish</div>";			
			echo "<div id='content'>";
			settings();
			break;
			
			case 'do_settings':			
			echo "<div id='navigation'>Overview - Licence - DB Details - <b>Settings</b> - Admin Details - Finish</div>";			
			echo "<div id='content'>";
			do_settings();
			break;
			
			case 'admin':			
			echo "<div id='navigation'>Overview - Licence - DB Details - Settings - <b>Admin Details</b> - Finish</div>";			
			echo "<div id='content'>";
			admin();
			break;
			
			case 'do_admin':			
			echo "<div id='navigation'>Overview - Licence - DB Details - Settings - <b>Admin Details</b> - Finish</div>";			
			echo "<div id='content'>";
			do_admin();
			break;
			
			case 'finish':			
			echo "<div id='navigation'>Overview - Licence - DB Details - Settings - Admin Details - <b>Finish</b></div>";			
			echo "<div id='content'>";
			finish();
			break;	
			
			case 'locked':
			echo "<div id='navigation'><b>Error - Installer Locked</b></div>";			
			echo "<div id='content'>";
			locked();
			break;
			
			default:			
			echo "<div id='navigation'><b>Overview</b> - Licence - DB Details - Settings - Admin Details - Finish</div>";			
			echo "<div id='content'>";
			overview();
			break;
		}
		
		function overview()
		{
			$nextpage = "licence";
			
			//Welcome Text
			echo "<p>Welcome to your ImprovCMS installation. This wizard will guide you through the license agreement, database configuration and creation of an administrator account.
			<br /><br />We hope you enjoy this software and remember if you ever have any problems with it feel free to submit it to the 
			<a href='http://improvcms.com/forums'>General Support Board</a>. <br />Also remember as this is a Alpha release please submit any bugs
			you find to the <a href='http://tracker.improvcms.com/projects/improv/issues'>ImprovCMS Bug Tracker.</a>.<br /><br />";	
			
			//Installation Overview
			echo "Below is an outline of what will happen during this installation:
			<ul>
			<li>ImprovCMS Licence Agreement</li>
			<li>Requirements Check</li>
			<li>Configuration of database and creation of database tables</li>
			<li>Creation of an administrator account to manage the ideas</li>
			</ul>
			After each step has successfully been completed, click Next to move on to the next step.";		
			
			//Next Button
			echo "<br />Click 'Next' to view the ImprovCMS Licence and start the install.</p><br />
			<form method='POST' action='./index.php'>
			<input type='hidden' name='action' value='{$nextpage}' />
			<input type='submit' value='Next' />
			</form>";
		}		
		
		function licence()
		{
			$nextpage = "database";		
			
			//Licence Intro
			echo "ImprovCMS is released under the GNU General Public License v3 (GNU GPLv3) as shown below:<br />";
			
			//Licence Text
			echo "<br /><div id='licence'><pre>";
			require("resources/license.php");
			echo $license;
			echo "</pre></div><br />";
			
			//Next Button
			echo "By clicking 'Next' you agree to the terms stated in the licence above.<br />
			<form method='POST' action='./index.php'>
			<input type='hidden' name='action' value='{$nextpage}' />
			<input type='submit' value='Next' />
			</form>";
		}				
		
		function database()		
		{			
			$nextpage = "do_database";						
			
			//DB Intro and Fields	
			echo "<form method='POST' action='./index.php'>";
			echo "Enter your DB Hostname, User, Password and Database below to continue ImprovCMS's installation.<br /><br />";			
			echo "<table border='0'><tr><td><img src='./images/database.png'></td><td>
			Hostname: <br /><input type='text' name='hostname' /><br />";
			$db_list = " 
			<select name='db_type'>
				<option value='mysqli'>MySQLi</option>
				<option value='mysql'>MySQL</option>
				<option value='pgsql'>PostgreSQL</option>
			</select>";
			echo "Database Type: <br />{$db_list}<br />";
			echo "Username: <br /><input type='text' name='username' /><br />";
			echo "Password: <br /><input type='password' name='password' /><br />";
			echo "Database: <br /><input type='text' name='database' /><br />";
			echo "Table Prefix: <br /><input type='text' name='table_prefix' value='imp_' />
			</td></tr></table><br /><br />";
			
			//Next Button
			echo "Click 'Next' to continue.<br />
			<input type='hidden' name='action' value='{$nextpage}' />
			<input type='submit' value='Next' />
			</form>";
		}
		
		function do_database()
		{
			$nextpage="do_database_admin";
			
			//Init Variables
			// $dbtype = $_POST['db_type'];
			$hostname = $_POST['hostname'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$database = $_POST['database'];
			$prefix = $_POST['table_prefix'];
			
			if (empty($hostname)) //If hostname empty set message and redirect
			{
				error("You must provide a hostname!");
				database();
			}
			
			elseif (empty($username)) //If username empty set message and redirect
			{
				error("You must provide a username!");
				database();
			}
			
			elseif (empty($database)) //If database empty set message and redirect
			{
				error("You must provide a database name!");
				database();
			}
			
			else
			{
				$connect = mysql_connect("{$hostname}","{$username}","{$password}");
				$select = mysql_select_db("{$database}");
				
				if (!$connect && !$select)
				{	
					error("Cannot connect to host or database");
					database();
				}
				
				elseif (!$connect)
				{
					error("Cannot connect to host");
					database();
				}
				
				elseif (!$select)
				{
					error("Cannot connect to database");
					database();
				}
				
				else
				{
					//Echo stuff and run queries to create basic tables
					echo "Connected Successfully.<br />Running Queries...<br /><br />";
					include ("./resources/tables.php");
					
					echo "Adding Pages Table...";
					$delete1 = mysql_query("DROP table if exists {$prefix}pages") or error("Failed to execute query - " . mysql_error());
					$result1 = mysql_query($create1) or error("Failed to add pages table into DB - " . mysql_error());
					
					echo "Adding Users Table...";
					$delete2 = mysql_query("DROP table if exists {$prefix}users") or error("Failed to execute query - " . mysql_error());
					$result2 = mysql_query($create2) or error("Failed to add users table into DB - " . mysql_error());
					
					echo "Adding Reports Table...";
					$delete3 = mysql_query("DROP table if exists {$prefix}reports") or error("Failed to execute query - " . mysql_error());
					$result3 = mysql_query($create3) or error("Failed to add reports table into DB - " . mysql_error());
					
					echo "Adding Settings Table...";
					$delete4 = mysql_query("DROP table if exists {$prefix}settings") or error("Failed to execute query - " . mysql_error());
					$result4 = mysql_query($create4) or error("Failed to add settings table into DB - " . mysql_error());
					
					echo "Adding Templates Table...";
					$delete5 = mysql_query("DROP table if exists {$prefix}templates") or error("Failed to execute query - " . mysql_error());
					$result5 = mysql_query($create5) or error("Failed to add templates table into DB - " . mysql_error());
					
					echo "<small>Inserted page_create template...</small>";
					$result6 = mysql_query($insert1) or error("Failed to insert page_create template into DB - " . mysql_error());
					
					echo "<small>Inserted page_view template...</small>";
					$result7 = mysql_query($insert2) or error("Failed to insert page_view template into DB - " . mysql_error());
					
					echo "<small>Inserted header template...</small>";
					$result8 = mysql_query($insert3) or error("Failed to insert header template into DB - " . mysql_error());
					
					echo "<small>Inserted index template...</small>";
					$result9 = mysql_query($insert4) or error("Failed to insert index template into DB - " . mysql_error());
					
					echo "<small>Inserted options_page template...</small>";
					$result10 = mysql_query($insert5) or error("Failed to insert options_page template into DB - " . mysql_error());
					
					echo "<small>Inserted footer template...</small>";
					$result11 = mysql_query($insert6) or error("Failed to insert footer template into DB - " . mysql_error());
					
					echo "<small>Inserted header_includes template...</small>";
					$result12 = mysql_query($insert7) or error("Failed to insert header_includes template into DB - " . mysql_error());
					
					echo "<small>Inserted page_toolbox template...</small>";
					$result13 = mysql_query($insert8) or error("Failed to insert page_toolbox template into DB - " . mysql_error());
					
					echo "<small>Inserted toolbox_content_home template...</small>";
					$result14 = mysql_query($insert9) or error("Failed to insert toolbox_content_home template into DB - " . mysql_error());
					
					echo "<small>Inserted sidebar_toolbox template...</small>";
					$result15 = mysql_query($insert10) or error("Failed to insert sidebar_toolbox template into DB - " . mysql_error());
					
					echo "<small>Inserted toolbox_create template...</small>";
					$result16 = mysql_query($insert11) or error("Failed to insert toolbox_create template into DB - " . mysql_error());
					
					echo "<small>Inserted toolbox_plist template...</small>";
					$result17 = mysql_query($insert12) or error("Failed to insert toolbox_plist template into DB - " . mysql_error());
					
					echo "<small>Inserted header_guest template...</small>";
					$result18 = mysql_query($insert13) or error("Failed to insert header_guest template into DB - " . mysql_error());
					
					echo "<small>Inserted header_admin template...</small>";
					$result19 = mysql_query($insert14) or error("Failed to insert header_admin template into DB - " . mysql_error());
					
					echo "<small>Inserted report_view template...</small>";
					$result20 = mysql_query($insert15) or error("Failed to insert report_view template into DB - " . mysql_error());
					
					echo "<small>Inserted page_view_report template...</small>";
					$result21 = mysql_query($insert16) or error("Failed to insert page_view_report template into DB - " . mysql_error());
					
					echo "<small>Inserted report_view_toolbox template...</small>";
					$result22 = mysql_query($insert17) or error("Failed to insert report_view_toolnox template into DB - " . mysql_error());
					
					echo "<small>Inserted toolbox_report_page template...</small>";
					$result23 = mysql_query($insert18) or error("Failed to insert toolbox_report_page template into DB - " . mysql_error());
					
					echo "<small>Inserted toolbox_report_list template...</small>";
					$result24 = mysql_query($insert19) or error("Failed to insert toolbox_report_list template into DB - " . mysql_error());
					
					echo "<small>Inserted toolbox_report_view template...</small>";
					$result25 = mysql_query($insert20) or error("Failed to insert toolbox_report_view template into DB - " . mysql_error());
					
					echo "<small>Inserted header_member template...</small>";
					$result26 = mysql_query($insert21) or error("Failed to insert header_member template into DB - " . mysql_error());
					
					echo "<small>Inserted toolbox_options_avatar template...</small>";
					$result27 = mysql_query($insert22) or error("Failed to insert toolbox_options_avatar template into DB - " . mysql_error());
					
					echo "Adding Usergroups Table...";
					$result28 = mysql_query($create6) or error("Failed to add usergroups table into DB - " . mysql_error());
					
					echo "<small>Inserted Guests usergroup...</small>";
					$result29 = mysql_query($ugroup1) or error("Failed to insert Guests usergroup into DB - " . mysql_error());
					
					echo "<small>Generated Guests usergroup permissions...</small>";
					$result30 = mysql_query($perms1) or error("Failed to insert Guests usergroup permissions into DB - " . mysql_error());
					
					echo "<small>Inserted Registered usergroup...</small>";
					$result31 = mysql_query($ugroup2) or error("Failed to insert Registered usergroup into DB - " . mysql_error());
					
					echo "<small>Generated Registered usergroup permissions...</small>";
					$result32 = mysql_query($perms2) or error("Failed to insert Registered usergroup permissions into DB - " . mysql_error());
					
					echo "<small>Inserted Contributor usergroup...</small>";
					$result33 = mysql_query($ugroup3) or error("Failed to insert Contributer usergroup into DB - " . mysql_error());
					
					echo "<small>Generated Contributor usergroup permissions...</small>";
					$result34 = mysql_query($perms3) or error("Failed to insert Contributor usergroup permissions into DB - " . mysql_error());
					
					echo "<small>Inserted Editor usergroup...</small>";
					$result35 = mysql_query($ugroup4) or error("Failed to insert Editor usergroup into DB - " . mysql_error());
					
					echo "<small>Generated Editor usergroup permissions...</small>";
					$result36 = mysql_query($perms4) or error("Failed to insert Editor usergroup permissions into DB - " . mysql_error());
					
					echo "<small>Inserted Administrator usergroup...</small>";
					$result37 = mysql_query($ugroup5) or error("Failed to insert Administrator usergroup into DB - " . mysql_error());

					echo "<small>Generated Administrator usergroup permissions...</small>";
					$result38 = mysql_query($perms5) or error("Failed to insert Administrator usergroup permissions into DB - " . mysql_error());

					echo "<small>Inserted default index page...</small>";
					$result39 = mysql_query($page1) or error("Failed to insert default index page into DB - " . mysql_error());
					
					echo "<small>Inserted toolbox_edit template...</small>";
					$result40 = mysql_query($insert23) or error("Failed to insert toolbox_edit template into DB - " . mysql_error());

					echo "<small>Inserted usercp_page template...</small>";
					$result41 = mysql_query($insert24) or error("Failed to insert usercp_page template into DB - " . mysql_error());

					echo "<small>Inserted sidebar_toolbox_reportbit template...</small>";
					$result42 = mysql_query($insert25) or error("Failed to insert sidebar_toolbox_reportbit template into DB - " . mysql_error());

					echo "Adding Comments Table...";
					$delete6 = mysql_query("DROP table if exists {$prefix}comments") or error("Failed to execute query - " . mysql_error());
					$result43 = mysql_query($create7) or error("Failed to add comments table into DB - " . mysql_error());

					echo "Adding Cache Table...";
					$delete7 = mysql_query("DROP table if exists {$prefix}cache") or error("Failed to execute query - " . mysql_error());
					$result44 = mysql_query($create8) or error("Failed to add cache table into DB - " . mysql_error());

					echo "<small>Inserted login_login template...</small>";
					$result45 = mysql_query($insert26) or error("Failed to insert login_login template into DB - " . mysql_error());

					echo "<small>Inserted gadgets cache...</small>";
					$result46 = mysql_query($cache1) or error("Failed to insert gadgets cache into DB - " . mysql_error());
					
					echo "<small>Inserted admin_notes cache...</small>";
					$result47 = mysql_query($cache2) or error("Failed to insert admin_notes cache into DB - " . mysql_error());
					
					echo "<small>Inserted page_contact template...</small>";
					$result48 = mysql_query($insert27) or error("Failed to insert page_contact template into DB - " . mysql_error());
					
					echo "<small>Inserted view_uid template...</small>";
					$result49 = mysql_query($insert28) or error("Failed to insert view_uid template into DB - " . mysql_error());

					echo "<small>Inserted regperms cache...</small>";
					$result50 = mysql_query($cache3) or error("Failed to insert regperms cache into DB - " . mysql_error());

					echo "<small>Inserted adminperms cache...</small>";
					$result51 = mysql_query($cache4) or error("Failed to insert adminperms cache into DB - " . mysql_error());

					echo "<small>Inserted lastadminlogins cache...</small>";
					$result52 = mysql_query($cache5) or error("Failed to insert lastadminlogins cache into DB - " . mysql_error());
					
					echo "<small>Inserted cacheexpiry cache...</small>";
					$result53 = mysql_query($cache6) or error("Failed to insert cacheexpiry cache into DB - " . mysql_error());

					echo "<small>Inserted login_lostpw template...</small>";
					$result54 = mysql_query($insert29) or error("Failed to insert login_lostpw template into DB - " . mysql_error());

					echo "Creating Config File...<br /><br />";
					
					//Create Config
					$config = "<?php
/*
ImprovCMS Project
    
Name: Configuration File (config.php)
Version: 
Description: config.php manages the connection to the database and 
other important details.

Author: Kyuubi, added to installer by Azareal


Copyright © 2010 ImprovCMS Group


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

// Database Name
// This is the name of your database. On shared hosts, this will be
// prefixed by your account name.
\$config['db']['name'] = '{$database}';

// Database Username
// This is the username that is used to connect to your database. This
// will also be prefixed by your account name.
\$config['db']['uname'] = '{$username}';

// Database Password
// The password used to access the database. This is NOT prefixed with
// your account name.
\$config['db']['pass'] = '{$password}';

// Database Host
// Where the MySQL database system is located. On many hosts, this will
// be the default below, so you will not need to change the settings.
// ONLY CHANGE THIS IF YOUR HOST REQUIRES YOU TO DO SO.
\$config['db']['host'] = '{$hostname}';
\$config['host_port'] = '3306';

// Database Type
// The type of database that you use.
\$config['db']['type'] = 'mysql';

// Table Prefix
// A name you can give your tables in the database. You don't need to
// provide a table prefix, but some people do this if they are 
// restricted in the number of database's they can create. The default
// prefix is ifcms_.
\$config['table_prefix'] = '{$prefix}';

// Super Administrator
// The id's of user's below will have permanent admin access, and can't
// be removed of admin permissions. For security reasons, you should
// leave this at id 1.
\$config['super_admins'] = '1';

// Unalterable
// Users in this variable are immortal to all other administrators.
// You can use this on as many users as you want, but we recommend that
// you use this on administrators only.
\$config['unalterable'] = '1';

// Datacache Systems
// If you have a Datacache system installed on your server (eg Memcache)
// then you can use these to speed up your site.
\$config['php_accelerator'] = '';
\$config['database_accelerator'] = '';

// Admin Control Panel Directory
// If you wish to change the name of the directory 
// in which the acp is situated for security reasons change this variable.
// Note you will also have to manually rename the folder called admin to match
// what is provided here.
// The default setting is admin.
\$config['admin_dir'] = 'admin';
?>";
					$file = fopen('../inc/config.php', 'w');
					fwrite($file, $config);
					fclose($file);
					echo "Done.<br />";
					
					
					//Next Button
					echo "Click 'Next' to continue.<br />
					<form method='POST' action='./index.php'>
					<input type='hidden' name='action' value='{$nextpage}' />
					<input type='submit' value='Next' /></form>";
					redirect("index.php?action={$nextpage}",3);
				}
			}
		}

		function do_database_admin()
		{
			$nextpage="settings";
			sql_connect();
			// Echo stuff and run queries to create admin tables.
			echo "The installer will now create the AdminCP Templates...<br /><br />";
			require("../inc/config.php");
			$prefix = $config['table_prefix'];
			$badquery = false;
			include ("./resources/tables_admin.php");
			// Admin Templates Table
			echo "Adding Admin Templates Table...";
			$delete1 = mysql_query("DROP table if exists ".TABLE_PREFIX."admin_templates") or error("Failed to execute query - " . mysql_error()).$badquery = true;
			$result1 = mysql_query($create1) or error("Failed to add admin_templates table into DB - " . mysql_error()).$badquery = true;
			// Admin Styles Table
			echo "Adding Admin Styles Table...";
			$delete2 = mysql_query("DROP table if exists {$prefix}admin_styles") or error("Failed to execute query - " . mysql_error()).$badquery = true;
			$result2 = mysql_query($create2) or error("Failed to add admin_styles table into DB - " . mysql_error()).$badquery = true;
			// Admin Logs Table (yes, we have one now)
			echo "Adding Admin Logs Table...";
			$delete3 = mysql_query("DROP table if exists {$prefix}admin_logs") or error("Failed to execute query - " . mysql_error()).$badquery = true;
			$result3 = mysql_query($create3) or error("Failed to add admin_logs table into DB - " . mysql_error()).$badquery = true;
			
			// Default admin index template
			echo "<small>Adding admin_index admin template..</small>";
			$result1 = mysql_query($insert1) or error("Failed to add admin_index into DB - " . mysql_error()).$badquery = true;
			
			// Normal View Queries
			$nresult1 = mysql_query($normal_view) or error("Failed to add normal view style into DB - " . mysql_error()).$badquery = true;
			$nresult2 = mysql_query($ntemplate1) or error("Failed to add admin_start normal view template into DB - " . mysql_error()).$badquery = true;

			// Advance View Queries
			$aresult1 = mysql_query($advance_view) or error("Failed to add advance view style into DB - " . mysql_error()).$badquery = true;
			$aresult2 = mysql_query($atemplate1) or error("Failed to add admin_redirect advance view template into DB - " . mysql_error()).$badquery = true;
			$aresult3 = mysql_query($atemplate2) or error("Failed to add admin_start advance view template into DB - " . mysql_error()).$badquery = true;
			$aresult4 = mysql_query($atemplate3) or error("Failed to add header_includes advance view template into DB - " . mysql_error()).$badquery = true;
			$aresult5 = mysql_query($atemplate4) or error("Failed to add header advance view template into DB - " . mysql_error()).$badquery = true;
			$aresult6 = mysql_query($atemplate5) or error("Failed to add sidebar advance view template into DB - " . mysql_error()).$badquery = true;

			echo "Done.<br />";

			// Only show this if nothing has gone wrong.
			if(!$badquery)
			{
				echo "Click 'Next' to continue.<br />
				<form method='POST' action='./index.php'>
				<input type='hidden' name='action' value='{$nextpage}' />
				<input type='submit' value='Next' /></form>";
				redirect("index.php?action={$nextpage}",2);
			}
		}

		function settings()
		{
			$nextpage = "do_settings";
			if ($_SERVER['HTTPS'] != NULL)
			{
				$s = "s";
			}
			
			$url = 'http'. $s .'://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$url = dirname(dirname($url));

			if($_GET['error'] == 'email')
			{
				$email_error = error("You have entered an invalid email address. Please check that the entered email is valid.");
				echo $email_error;
			}
			// DB Intro and Fields	
			echo "<form method='POST' action='./index.php'>";
			echo "Enter your desired settings below to continue ImprovCMS's installation.<br /><br />";			
			echo "<table border='0'><tr><td><img src='./images/configure.png'></td><td>
			Site URL: <br /><input type='text' name='siteurl' value='{$url}' /><br />";	
			echo "Home URL: <br /><input type='text' name='homeurl' value='".'http'.$s.'://'.$_SERVER['HTTP_HOST']."' /><br />
			<small>Do not include the trailing slash '/'</small>";
			echo "Webmaster Email: <br /><input type='text' name='wemail' value='webmaster@{$_SERVER['HTTP_HOST']}' /><br />
			Site Name: <br /><input type='text' name='sitename' value='Default Install' /></td>
			</tr></table><br /><br />";
			echo "Click 'Next' to continue.<br />
			<input type='hidden' name='action' value='{$nextpage}' />
			<input type='submit' value='Next' /></form>";
		}
		
		function do_settings()
		{
			$nextpage = "admin";
			sql_connect();
			$siteurl = mysql_real_escape_string($_POST['siteurl']);
			$homeurl = mysql_real_escape_string($_POST['homeurl']);
			$wemail = mysql_real_escape_string($_POST['wemail']);
			$sitename = mysql_real_escape_string($_POST['sitename']);
			$terror = 0;

			if (empty($siteurl) || empty($homeurl) || empty($wemail) || empty($sitename))
			{
				error("Please fill in all the fields!");
			}
			elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$wemail))
			{ 
				$email_error = error("You have entered an invalid email address. Please check that the entered email is valid.");
				$terror = 1;
				redirect("index.php?action=settings&error=email",0);
			}
			else
			{
				$addsettings = mysql_query("INSERT into ".TABLE_PREFIX."settings(name, content) VALUES ('siteurl','{$siteurl}')");
				$addsettings2 = mysql_query("INSERT into ".TABLE_PREFIX."settings(name, content) VALUES ('homeurl','{$homeurl}')");
				$addsettings3 = mysql_query("INSERT into ".TABLE_PREFIX."settings(name, content) VALUES ('site_email','{$wemail}')");
				$addsettings4 = mysql_query("INSERT into ".TABLE_PREFIX."settings(name, content) VALUES ('site_name','{$sitename}')");
				$addsettings5 = mysql_query("INSERT into ".TABLE_PREFIX."settings(name, content) VALUES ('avatar_maxheight','125')");
				$addsettings6 = mysql_query("INSERT into ".TABLE_PREFIX."settings(name, content) VALUES ('avatar_maxwidth','125')");
				$addsettings7 = mysql_query("INSERT into ".TABLE_PREFIX."settings(name, content) VALUES ('site_message','0')");
				$addsettings8 = mysql_query("INSERT into ".TABLE_PREFIX."settings(name, content) VALUES ('site_switch','1')");

				if (!$addsettings)
				{
					error("Failed to insert siteurl setting into DB - " . mysql_error());
					$terror = 1;
				}
				
				if (!$addsettings2)
				{
					error("Failed to insert homeurl setting into DB - " . mysql_error());
					$terror = 1;
				}
				
				if (!$addsettings3)
				{
					error("Failed to insert site_email setting into DB - " . mysql_error());
					$terror = 1;
				}
				
				if (!$addsettings4)
				{
					error("Failed to insert site_name setting into DB - " . mysql_error());
					$terror = 1;
				}
				
				if (!$addsettings5)
				{
					error("Failed to insert avatar_maxheight setting into DB - " . mysql_error());
					$terror = 1;
				}
				
				if (!$addsettings6)
				{
					error("Failed to insert avatar_maxwidth setting into DB - " . mysql_error());
					$terror = 1;
				}
				
				if (!$addsettings7)
				{
					error("Failed to insert site_message setting into DB - " . mysql_error());
					$terror = 1;
				}
				
				if (!$addsettings8)
				{
					error("Failed to insert site_switch setting into DB - " . mysql_error());
					$terror = 1;
				}
				
				if($terror!=1)
				{
					echo "Inserting Settings into DB...<br /><br />";
					echo "Done.<br />";
					
					// Next Button
					echo "Click 'Next' to continue.<br />
					<form method='POST' action='./index.php'>
					<input type='hidden' name='action' value='{$nextpage}' />
					<input type='submit' value='Next' /></form>";
					redirect("index.php?action={$nextpage}",3);
				}
			}
		}
		
		function admin()
		{
			$nextpage = "do_admin";
			if($_GET['error'] == 'email')
			{
				$email_error = error("You have entered an invalid email address. Please check that the entered email is valid.");
				echo $email_error;
			}
			//DB Intro and Fields	
			echo "<form method='POST' action='./index.php'>";
			echo "Enter your wanted Admin Details below to continue ImprovCMS's installation.<br /><br />";			
			echo "<table border='0'><tr><td><img src='./images/admin.png'></td><td>Username: <br />
			<input type='text' name='username' /><br />";	
			echo "Password: <br /><input type='password' name='password' /><br />";
			echo "Email: <br /><input type='text' name='email' /></td></tr></table><br /><br />";
			
			//Next Button
			echo "Click 'Next' to continue.<br />
			<input type='hidden' name='action' value='{$nextpage}' />
			<input type='submit' value='Next' /></form>";
		}
		
		function do_admin()
		{
			$nextpage = "finish";
			sql_connect();
			$username = mysql_real_escape_string($_POST['username']);
			$password = mysql_real_escape_string($_POST['password']);
			$email = mysql_real_escape_string($_POST['email']);

			if (empty($username) || empty($password) || empty($email))
			{
				error("Please fill in all the fields!");
			}
			
			elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$email))
			{ 
				$email_error = error("You have entered an invalid email address. Please check that the entered email is valid.");
				$terror = 1;
				redirect("index.php?action=admin&error=email",0);
			}		
			
			else
			{
				// Encrypt password with existing salt
				$salt = random_str(10);
				$epassword = md5($salt.md5($password.$salt));
				$epassword = md5($epassword);
				
				$addadmin = mysql_query("INSERT into ".TABLE_PREFIX."users(username, password, salt, email, gid) VALUES ('{$username}','{$epassword}','{$salt}','{$email}','5')");
			
				if (!$addadmin)
				{
					error("Failed to add admin account into DB - " . mysql_error());
				}
			
				else
				{
					echo "Inserting Admin Account into DB...<br /><br />";
					echo "Done.<br />";
					
					//Next Button
					echo "Click 'Finish' to complete ImprovCMS's installation.<br />
					<form method='POST' action='./index.php'>
					<input type='hidden' name='action' value='{$nextpage}' />
					<input type='submit' value='Finish' /></form>";
					redirect("index.php?action={$nextpage}",3);
				}
			}
		}
		
		function finish()
		{
			$lock = @fopen('./lock', 'w');
			$written = @fwrite($lock, 'locked');
			@fclose($lock);
		
			echo "<h2>Congratulations! ImprovCMS has been installed successfully!</h2>";
			echo "<table border='0'><tr><td><img src='./images/success.png'></td><td>Your installer has also been locked to prevent unauthorised reinstalls or updates.<br />";
			echo "To start using ImprovCMS click <a href='../index.php'>here</a> and you will be taken directly to the homepage where you can login to your admin account.<br /><br />";
			echo "Please remember if you have any problems with our software please make a support request over at our <a href='http://improvcms.com/forums'>Support Forums</a>.<br />";
			echo "If you happen to encounter any bugs with ImprovCMS (which may be likely as this is a Preview release) please report them onto our <a href='http://tracker.improvcms.com/projects/improv/issues'>ImprovCMS Development Site
			</a>.</td></tr></table>";
		}
		
		function locked()
		{
			echo "<table border='0'><tr><td><img src='./images/lock.png'></td><td>";
			error("The Installer is Locked and therefore cannot continue. Please remove the 'lock' file to continue and refresh.");
			echo "If this problem continues please feel free to make a support request over at our 
			<a href='http://improvcms.com/forums'>Support Forums</a>.</td></tr></table>";
		}
		?>		
		</div>		
		 <div id="footer">
			&copy; <?php 
			$copyYear = 2010; 
			$curYear = date('Y'); 
			echo $copyYear . (($copyYear != $curYear) ? '-' . $curYear : ''); ?>
			Powered by <a href="http://improvcms.com/forums">ImprovCMS</a> Alpha 3 Dev
	     </div>		 
</div>
</body>
</html>