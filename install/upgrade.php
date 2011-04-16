<?php
/*
ImprovCMS Project
    
    Name: Upgrader
    Description: This file is used to upgrade an older version of Improv to a newer and more secure version.

    Author: Kyuubi

    Copyright (c) 2010 Kyuubi and Improv Software Group
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

// require_once("./resources/functions_upgrade.php");
error_reporting(0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="./style.css" media="screen" />
	<title>ImprovCMS Upgrader</title>
</head>
<body>

   <div id="wrapper">
   
		<div id="header">
			<img src="../images/logo.png" alt="ImprovCMS Upgrader" />		 
		</div>
		
		<?php
		$action = $_REQUEST['action'];	 

		if(file_exists('lock'))
		{
			$action = "locked";
		}
		
		switch ($action)
		{
			case 'version':			
			echo "<div id='navigation'>Overview - <b>Select Version</b> - Begin Upgrade - Updating AdminCP - Updating Settings - Updating Styles - Finish</div>";			
			echo "<div id='content'>";
			version();
			break;			
			
			case 'update':			
			echo "<div id='navigation'>Overview - Select Version - <b>Begin Upgrade</b> - Updating AdminCP - Updating Settings - Updating Styles - Finish</div>";			
			echo "<div id='content'>";
			update();
			break;		
			
			case 'admin_update':			
			echo "<div id='navigation'>Overview - Select Version - Begin Upgrade - <b>Updating AdminCP</b> - Updating Settings - Updating Style - Finish</div>";			
			echo "<div id='content'>";
			admin_update();
			break;
			
			case 'settings_update':			
			echo "<div id='navigation'>Overview - Select Version - Begin Upgrade - Updating AdminCP - <b>Updating Settings</b> - Updating Style - Finish</div>";			
			echo "<div id='content'>";
			settings_update();
			break;
			
			case 'style_update':			
			echo "<div id='navigation'>Overview - Select Version - Begin Upgrade - Updating AdminCP - Updating Settings - <b>Updating Style</b> - Finish</div>";			
			echo "<div id='content'>";
			style_update();
			break;
			
			case 'finish':			
			echo "<div id='navigation'>Overview - Select Version - Begin Upgrade - Updating AdminCP - Updating Settings - Updating Style - <b>Finish</b></div>";			
			echo "<div id='content'>";
			finish();
			break;	
			
			case 'locked':
			echo "<div id='navigation'><b>Error - Upgrader Locked</b></div>";			
			echo "<div id='content'>";
			locked();
			break;
			
			default:			
			echo "<div id='navigation'><b>Overview</b> - Select Version - Begin Upgrade - Updating AdminCP - Updating Settings - Updating Styles - Finish</div>";			
			echo "<div id='content'>";
			overview();
			break;
		}
		
		function overview()
		{
			$next = "version";
			
			// Welcome text
			echo "Welcome to the Upgrade System for ImprovCMS! This script will take you through the process of updating your version of ImprovCMS to the version you have uploaded to the server<br /><br />";
			echo "<b>Please make sure you have taken backups and disabled all plugins and gadgets before upgrading! You never know what might happen when upgrading.</b>";
			
			// Next Button
			echo "<br />Click 'Next' to select the version you are upgrading from.</p><br />
			<form method='POST' action='./upgrade.php'>
			<input type='hidden' name='action' value='{$next}' />
			<input type='submit' value='Next' />
			</form>";
		}
		
		function version()
		{
			$next = "update";
			require("../inc/core.class.php");
			global $imp;
			
			// Select version
			echo "Before we can continue, we need to select the version you are currently running.";
			echo "<br />";
			echo "You are currently running v"; echo $imp->fversion; echo ". The latest version is:"; echo $version; echo".";
			
			
		}
		
		function update()
		{
			$next = "admin_update";
		}
		
		function admin_update()
		{
			$next = "settings_update";
		}
		
		function settings_update()
		{
			$next = "style_update";
		}
		
		function style_update()
		{
			$next = "finish";
		}
		
		function finish()
		{
			$lock = @fopen('./lock', 'w');
			$written = @fwrite($lock, 'locked');
			@fclose($lock);
		}
		
		function locked()
		{
			echo "The upgrader cannot continue until you have deleted the lock file from this directory.";
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