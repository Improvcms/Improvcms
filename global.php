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
function __autoload ($class)
{
	$file = ROOT."/inc/".str_replace('_',DIRECTORY_SEPARATOR,$class).'.class.php';
	$file2 = ROOT."inc/class_{$class}.php';
	if(file_exists($file))
	{
		require_once($file);
	}
	elseif(file_exists($file2))
	{
		require_once($file2);
	}
	
	class $class
	{
		function __construct()
		{
			echo "<b>Something has gone wrong! The class could not be loaded!</b>";
			exit;
		}
	}
}

$error = new error;
$globstart = microtime(true);
$loc = 'global.php';
// Check if the configuration file exists.
if (!file_exists(ROOT."/inc/config.php"))
{	
	$error->internal(40);
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
require_once(ROOT."/inc/functions.php");
// Check the configuration
require_once(ROOT."/inc/config.php");
// Define the table prefix
define("TABLE_PREFIX",$config['table_prefix']);
// Load the database class
if(file_exists(ROOT."/inc/{$config['db']['type']}.class.php"))
{
	$db_type = $config['db']['type'];
}
else
{
	$db_type = 'mysql';
}
// Instantiate the class
$db = new $db_type($config);
// Wake up our pixies.
$imp = new core;
unset($config);
// Setup siteurl
$siteurl = $imp->settings['siteurl'];
// Check the user's session
if(!defined("IN_ADMIN"))
{
	check_session();
}
else
{
	check_adminsession();
}
$gid = $imp->user['gid'];
// Start up the class
$perms = new permissions($gid);
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
// Give smarty access to $imp variable.
$smarty->assign('imp',$imp);
// Shorthand way of fetching username.
$smarty->assign('username',$imp->user['username']);
// Quick way to check if someones an administrator.
$is_admin = $perms->check_perms("can_access_admincp");
$smarty->assign('is_admin',$is_admin);
// Now to get global to parse the global templates.
$header = $templates->fetch("header");
$header = addslashes($header);
if($imp->user['uid']=='0')
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
	$db->query("UPDATE ".TABLE_PREFIX."users SET ipaddress='{$_SERVER[REMOTE_ADDR]}' WHERE uid='{$imp->user[uid]}'");
	$db->query("UPDATE ".TABLE_PREFIX."users SET lastactive='{$timenow}' WHERE uid='{$imp->user[uid]}'");
}
else
{
	$header_member = $templates->fetch("header_member");
	$smarty->assign('header_member',$header_member);
	$db->query("UPDATE ".TABLE_PREFIX."users SET ipaddress='{$_SERVER[REMOTE_ADDR]}' WHERE uid='{$imp->user[uid]}'");
	$db->query("UPDATE ".TABLE_PREFIX."users SET lastactive='{$timenow}' WHERE uid='{$imp->user[uid]}'");
}
$username = $imp->user['username'];
$avatar = $imp->user['avatar'];
if(empty($avatar))
{
	$gname = getgroup($imp->user['uid']);
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
$header = stripslashes($header);
$header = str_replace($imp->config['db']['uname'],"Guest",$header);
unset($username);
$headerincludes = $templates->fetch("header_includes");
$headerincludes = addslashes($headerincludes);
$headerincludes = stripslashes($headerincludes);
$footer = $templates->fetch("footer");
$footer = addslashes($footer);
$gadgets = new gadgets;
?>