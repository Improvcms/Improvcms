<?php
/*
ImprovCMS
    
    Name: Global
    Description: Includes and Inits stuff which is needed on all pages
	Last Update: 11 April 2011
    Authors: Polarbear541 & Azareal

    Copyright © 2010 Polarbear541, Azareal and the Improv Software Group
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

// Wait... Where are these pixies you talk about?

define("ROOT", dirname(__FILE__));
error_reporting(E_ALL ^ E_NOTICE);
$globstart = microtime(true);
$loc = 'global.php';
// Check if the configuration file exists.
if (!file_exists(ROOT."/inc/config.php"))
{	
	header("Location: install/");
}

// config.php needs CHMOD 666
if(!is_writable(ROOT."/inc/config.php"))
{
	require(ROOT."/styles/default.css");
	error("config.php does not have 666 CHMOD permissions. ImprovCMS cannot run.");
	exit;
}
  
// What is the current time?
$timenow = time();
// Include Functions
require_once(ROOT . "/inc/functions.php");
// Check the configuration
require_once(ROOT."/inc/config.php");
// Define the table prefix
define("TABLE_PREFIX",$config['table_prefix']);
// Load the database class
if(file_exists(ROOT."/inc/{$config['db']['type']}/database.class.php"))
{
	$db_type = $config['db']['type'];
}
else
{
	$db_type = 'mysql';
}
require_once(ROOT."/inc/{$db_type}/database.class.php");
// Instantiate the class
$db = new database($config);
// Generate the core
require_once(ROOT."/inc/core.class.php");
// Wake up our pixies.
$mcms = new core;
unset($config);
// Setup siteurl
$siteurl = $mcms->settings['siteurl'];
// Class for controlling permissions
require_once(ROOT."/inc/permissions.class.php");
// Check the user's session
if(!defined("IN_ADMIN"))
{
	check_session();
}
else
{
	check_adminsession();
}
$gid = $mcms->user['gid'];
// Start up the class
$perms = new permissions($gid);
// Get the class for dealing with templates
require_once(ROOT."/inc/templates.class.php");
// Templates class instantiation.
$templates = new templates;
// Get the smarty functions.
require_once(ROOT.'/inc/functions_smarty.php');
// Get smarty.
require_once(ROOT.'/inc/libs/Smarty.class.php');
// Start up the smarty class.
$smarty = new Smarty();
// Assign Smarty variables.
$smarty->compile_dir = ROOT.'/cache/compile';
$smarty->config_dir = ROOT.'/inc/config';
$smarty->cache_dir = ROOT.'/cache/templates';
$smarty->template_dir = ROOT.'/cache';
// Register the resource here.
$smarty->registerResource("db",array("db_get_template","db_get_timestamp","db_get_secure","db_get_trusted"));
// Start up template caching
$smarty->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
// Give smarty access to $mcms variable.
$smarty->assign('mcms',$mcms);
// Shorthand way of fetching username.
$smarty->assign('username',$mcms->user['username']);
// Quick way to check if someones an administrator.
$is_admin = $perms->check_perms("can_access_admincp");
$smarty->assign('is_admin',$is_admin);
// Now to get global to parse the global templates.
$header = $templates->fetch("header");
$header = addslashes($header);
if($mcms->user['uid']=='0')
{
	$header_guest = $templates->fetch("header_guest");
	$smarty->assign('header_guest',$header_guest);
}
elseif($perms->check_perms("can_access_admincp"))
{
	$header_admin = $templates->fetch("header_admin");
	$smarty->assign('header_admin',$header_admin);
	$header_member = $templates->fetch("header_member");
	$smarty->assign('header_member',$header_member);
	$db->query("UPDATE ".TABLE_PREFIX."users SET ipaddress='{$_SERVER[REMOTE_ADDR]}' WHERE uid='{$mcms->user[uid]}'");
	$db->query("UPDATE ".TABLE_PREFIX."users SET lastactive='{$timenow}' WHERE uid='{$mcms->user[uid]}'");
}
else
{
	$header_member = $templates->fetch("header_member");
	$smarty->assign('header_member',$header_member);
	$db->query("UPDATE ".TABLE_PREFIX."users SET ipaddress='{$_SERVER[REMOTE_ADDR]}' WHERE uid='{$mcms->user[uid]}'");
	$db->query("UPDATE ".TABLE_PREFIX."users SET lastactive='{$timenow}' WHERE uid='{$mcms->user[uid]}'");
}
$username = $mcms->user['username'];
$avatar = $mcms->user['avatar'];
if(empty($avatar))
{
	$gname = getgroup($mcms->user['uid']);
	if(is_readable("./images/groups/".strtolower($group['name']).".png"))
	{
		$strgroup = strtolower($gname['name']);
		$avatar = "./images/groups/{$strgroup}.png";
	}
	else
	{
		$avatar = "./images/groups/registered.png";
	}
	unset($gname);
	unset($strgroup);
}
$smarty->assign('avatar',$avatar);
//eval("\$header = \"$header\";");
$header = stripslashes($header);
$header = str_replace($mcms->config['db']['uname'],"Guest",$header);
unset($username);
$headerincludes = $templates->fetch("header_includes");
$headerincludes = addslashes($headerincludes);
//eval("\$headerincludes = \"$headerincludes\";");
$headerincludes = stripslashes($headerincludes);
$footer = $templates->fetch("footer");
$footer = addslashes($footer);
//eval("\$footer = \"$footer\";");
// Now, to start up the gadgets.
require_once(ROOT."/inc/gadgets.class.php");
$gadgets = new gadgets;
class error_class
{
	public $seterrors = 0;
}
$error_class = new error_class;
?>