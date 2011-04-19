<?php
//===========================================================================
//    ImprovCMS Project
//    
//    Name: Advanced Admin Control Panel Setting Inserting Script
//    Version: Pre-Alpha
//    Discription: Pixies give the page settings, then it add them to DB.
//    Last Update: 20th of November, 2010.
//
//    Author: Damian Sharpe (The Pure Australian, thank you very much!)
//
//    Copyright (C) 2010
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program.  If not, see <http://www.gnu.org/licenses/>.
//===========================================================================

//===========================================================================
// All the files mentioned here are in the */admin/modules/* folder...
// Please note the comments for editing the way setings work...
//===========================================================================

//Require the Global Loader
define("IN_MILLION", "1");
define("IN_ADMIN","1");
require_once('../../../global.php');
// Before the user can do anything here, check if the user is actually an administrator...
// Because if he is a normal member, he should not be here!
if (!$is_admin) 
{
	header('Location: ../../index.php');
	error("You do not have permission to view this page");
	exit;
}

//===========================================================================
// GENERAL SETTINGS PAGE (general_settings.php)
//===========================================================================

// The current time.
$time = time();
if(isset($_POST['general_settings'])) 
{ 
	// Site On/Off Switch
	$site_switch_output = $db->sanitise($_POST['site_switch_input']);
	if(!empty($site_switch_output))
	{
		$query = $db->query("UPDATE ".TABLE_PREFIX."settings SET content='{$site_switch_output}' WHERE name='site_switch'");
		if($imp->settings['site_switch']!=$site_switch_output)
		{
			$detail['prev'] = $imp->settings['site_switch'];
			$detail['field'] = 'content';
			$detail['record'] = 'site_switch';
			$detail['post'] = $site_switch_output;
			$detail['where'] = 'name';
			$details = serialize($detail);
			$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','general_settings.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','settings','{$details}') ");
		}
	}
	// Site Message
	$site_message_output = $db->sanitise($_POST['site_message_input']);
	if(!empty($site_message_output))
	{
		$query = $db->query("UPDATE ".TABLE_PREFIX."settings SET content='{$site_message_output}' WHERE name='site_message'");
		if($imp->settings['site_message']!=$site_message_output)
		{
			$detail['prev'] = $imp->settings['site_message'];
			$detail['field'] = 'content';
			$detail['record'] = 'site_message';
			$detail['post'] = $site_message_output;
			$detail['where'] = 'name';
			$details = serialize($detail);
			$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','general_settings.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','settings','{$details}') ");
		}
	}
	// Site URL
	$site_url_output = $db->sanitise($_POST['site_url_input']);
	if(!empty($site_url_output))
	{
		$query = $db->query("UPDATE ".TABLE_PREFIX."settings SET content='{$site_url_output}' WHERE name='siteurl'");
		if($imp->settings['siteurl']!=$site_url_output)
		{
			$detail['prev'] = $imp->settings['siteurl'];
			$detail['field'] = 'content';
			$detail['record'] = 'siteurl';
			$detail['post'] = $site_url_output;
			$detail['where'] = 'name';
			$details = serialize($detail);
			$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','general_settings.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','settings','{$details}') ");
		}
	}
	// Home URL
	$home_url_output = $db->sanitise($_POST['home_url_input']);
	if(!empty($home_url_output))
	{
		$query = $db->query("UPDATE ".TABLE_PREFIX."settings SET content='{$home_url_output}' WHERE name='homeurl'");
		if($imp->settings['homeurl']!=$home_url_output)
		{
			$detail['prev'] = $imp->settings['homeurl'];
			$detail['field'] = 'content';
			$detail['record'] = 'homeurl';
			$detail['post'] = $home_url_output;
			$detail['where'] = 'name';
			$details = serialize($detail);
			$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','general_settings.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','settings','{$details}') ");
		}
	}
	// Master eMail
	$master_email_output = $db->sanitise($_POST['master_email_input']);
	if(!empty($master_email_output))
	{
		$query = $db->query("UPDATE ".TABLE_PREFIX."settings SET content='{$master_email_output}' WHERE name='site_email'");
		if($imp->settings['site_email']!=$master_email_output)
		{
			$detail['prev'] = $imp->settings['site_email'];
			$detail['field'] = 'content';
			$detail['record'] = 'site_email';
			$detail['post'] = $master_email_output;
			$detail['where'] = 'name';
			$details = serialize($detail);
			$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','general_settings.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','settings','{$details}') ");
		}
	}
	// Website Name
	$site_name_output = $db->sanitise($_POST['site_name_input']);
	if(!empty($site_name_output))
	{
		$query = $db->query("UPDATE ".TABLE_PREFIX."settings SET content='{$site_name_output}' WHERE name='site_name'");
		if($imp->settings['site_name']!=$site_name_output)
		{
			$detail['prev'] = $imp->settings['site_name'];
			$detail['field'] = 'content';
			$detail['record'] = 'site_name';
			$detail['post'] = $site_name_output;
			$detail['where'] = 'name';
			$details = serialize($detail);
			$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','general_settings.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','settings','{$details}') ");
		}
	}
	if(!isset($_FILES['favicon_upload']))
	{
		// Favicon Changer/Uploader...
		move_uploaded_file($_FILES["favicon_upload"]["tmp_name"],"../../../"."favicon");
		$detail['file'] = 'favicon';
		$detail['tmpname'] = $_FILES["favicon_upload"]["tmp_name"];
		$details = serialize($detail);
		$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','general_settings.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','upload','0','{$details}') ");
	}
	
	// Redirect and Exit
	header('Location: ../general_settings.php?action=done');
	exit;
}

//===========================================================================
// USER SETTINGS PAGE (general_settings.php)
//===========================================================================

if(isset($_POST['user_settings'])) 
{
	// Avatar Max Width
	$avatar_maxwidth_output = $db->sanitise($_POST['avatar_maxwidth']);
	if(!empty($avatar_maxwidth_output))
	{
		$query = $db->query("UPDATE ".TABLE_PREFIX."settings SET content='{$avatar_maxwidth_output}' WHERE name='avatar_maxwidth'");
		if($imp->settings['avatar_maxwidth']!=$avatar_maxwidth_output)
		{
			$detail['prev'] = $imp->settings['avatar_maxwidth'];
			$detail['field'] = 'content';
			$detail['record'] = 'avatar_maxwidth';
			$detail['post'] = $avatar_maxwidth_output;
			$detail['where'] = 'name';
			$details = serialize($detail);
			$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','user_settings.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','settings','{$details}') ");
		}
	}
	// Avatar Max Height
	$avatar_maxheight_output = $db->sanitise($_POST['avatar_maxheight_input']);
	if(!empty($avatar_maxheight_output))
	{
		$query = $db->query("UPDATE ".TABLE_PREFIX."settings SET content='{$avatar_maxheight_output}' WHERE name='avatar_maxheight'");
		if($imp->settings['avatar_maxheight']!=$avatar_maxheight_output)
		{
			$detail['prev'] = $imp->settings['avatar_maxheight'];
			$detail['field'] = 'content';
			$detail['record'] = 'avatar_maxheight';
			$detail['post'] = $avatar_maxheight_output;
			$detail['where'] = 'name';
			$details = serialize($detail);
			$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','user_settings.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','settings','{$details}') ");
		}
	}
	
	// Redirect and Exit
	header('Location: ../user_settings.php?action=done');
	exit;
}

//===========================================================================
// VISUAL PREFERENCES (visual_preferences.php)
//===========================================================================

if(isset($_POST['visual_preferences'])) 
{
	// Favicon Changer/Uploader...
	if (!empty($_FILES))
	{
		move_uploaded_file($_FILES["bg_change"]["tmp_name"], "../../images/backgrounds/" . "normal_view_bg.jpg");
		$detail['file'] = 'normal_view_bg.jpg';
		$detail['tmpname'] = $_FILES["bg_change"]["tmp_name"];
		$details = serialize($detail);
		$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','general_settings.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','upload','0','{$details}') ");
	}
	
	// Redirect and Exit
	header('Location: ../visual_preferences.php?action=done');
	exit;
}

//===========================================================================
// USER ACCOUNT EDITING PAGE (users_edit.php)
//===========================================================================

if(isset($_POST['user_edit']) && $perms->check_perms("can_edit_users"))
{
	$user_id_user_edit = intval($_POST['user_list_id']); // Only want integer values.
	// Declare it here so we don't need to query the database everytime.
	$prevuser = getuser($user_id_user_edit);
	// Is this person authorised to edit this user?
	if($perms->level_check($imp->user['uid'],$user_id_user_edit) || $imp->user['uid']==$user_id_user_edit)
	{
		// Username
		$user_account_name_output = $db->sanitise($_POST['user_account_name_input']);
		if(!empty($user_account_name_output))
		{
			$detail['prev'] = $prevuser['username'];
			$query = $db->query("UPDATE ".TABLE_PREFIX."users SET username='{$user_account_name_output}' WHERE uid='{$user_id_user_edit}'");
			if($detail['prev']!=$user_account_name_output)
			{
				$detail['field'] = 'username';
				$detail['record'] = $user_id_user_edit;
				$detail['post'] = $user_account_name_output;
				$detail['where'] = 'uid';
				$details = serialize($detail);
				$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','users_edit.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','users','{$details}') ");
				unset($detail);
			}
		}
		// Password
		$user_account_password_output = $db->sanitise($_POST['user_account_password_input']);
		if(!empty($user_account_password_output) && $user_account_password_output!='*****')
		{
			$newpassword = md5($prevuser['salt'].md5($user_account_password_output.$prevuser['salt']));
			$newpassword = md5($newpassword);
			$query = $db->query("UPDATE ".TABLE_PREFIX."users SET password='{$newpassword}' WHERE uid='{$user_id_user_edit}'");
			if($userpass!=$prevuser['password'])
			{
				$detail['field'] = 'password';
				$detail['record'] = $user_id_user_edit;
				$detail['post'] = $newpassword;
				$detail['where'] = 'uid';
				$details = serialize($detail);
				$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','users_edit.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','users','{$details}') ");
				unset($detail);
			}
		}
		// Email
		$user_account_email_output = $db->sanitise($_POST['user_account_email_input']);
		if(!empty($user_account_email_output))
		{
			$query = $db->query("UPDATE ".TABLE_PREFIX."users SET email='{$user_account_email_output}' WHERE uid='{$user_id_user_edit}'");
			if($prevuser['email']!=$user_account_email_output)
			{
				$detail['prev'] = $prevuser['email'];
				$detail['field'] = 'email';
				$detail['record'] = $user_id_user_edit;
				$detail['where'] = 'uid';
				$detail['post'] = $user_account_email_output;
				$details = serialize($detail);
				$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','users_edit.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','users','{$details}') ");
				unset($detail);
			}
		}
		// Usertitle
		$user_account_title_output = $db->sanitise($_POST['user_account_title_input']);
		if(!empty($user_account_title_output))
		{
			$prevtitle = $prevuser['title'];
			$query = $db->query("UPDATE ".TABLE_PREFIX."users SET title='{$user_account_title_output}' WHERE uid='{$user_id_user_edit}'");
			if($prevtitle!=$user_account_title_output)
			{
				$detail['prev'] = $prevtitle;
				$detail['field'] = 'title';
				$detail['record'] = $user_id_user_edit;
				$detail['where'] = 'uid';
				$detail['post'] = $user_account_title_output;
				$details = serialize($detail);
				$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','users_edit.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','users','{$details}') ");
				unset($detail);
			}
		}
		// Protect User
		$user_account_protect_output = intval($_POST['user_account_protect_input']);
		if(isset($user_account_protect_output) && ($user_account_protect_output==1 || $user_account_protect_output==0))
		{
			$query = $db->query("UPDATE ".TABLE_PREFIX."users SET protect='{$user_account_protect_output}' WHERE uid='{$user_id_user_edit}'");
			if($prevuser['protect']!=$user_account_protect_output)
			{
				$detail['prev'] = $prevuser['protect'];
				$detail['field'] = 'protect';
				$detail['record'] = $user_id_user_edit;
				$detail['where'] = 'uid';
				$detail['post'] = $user_account_protect_output;
				$details = serialize($detail);
				$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','users_edit.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','users','{$details}') ");
				unset($detail);
			}
		}
		// Super Admin
		$user_account_superadmin_output = $db->sanitise(intval($_POST['user_account_superadmin_input']));
		if(isset($user_account_superadmin_output) && $perms->founder($imp->user['uid']))
		{
			if($prevuser['superadmin'])
			{
				$sadmin = 1;
			}
			else
			{
				$sadmin = 0;
			}
			$query = $db->query("UPDATE ".TABLE_PREFIX."users SET superadmin='{$user_account_superadmin_output}' WHERE uid='{$user_id_user_edit}'");
			if($sadmin!=$user_account_superadmin_output)
			{
				$detail['prev'] = $sadmin;
				$detail['field'] = 'superadmin';
				$detail['record'] = $user_id_user_edit;
				$detail['where'] = 'uid';
				$detail['post'] = $user_account_superadmin_output;
				$details = serialize($detail);
				$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','users_edit.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','users','{$details}') ");
				unset($detail);
			}
		}
		// Registration IP
		$user_account_regip_output = $db->sanitise($_POST['user_account_regip_input']);
		if(!empty($user_account_regip_output))
		{
			$query = $db->query("UPDATE ".TABLE_PREFIX."users SET ipaddress='{$user_account_regip_output}' WHERE uid='{$user_id_user_edit}'");
			if($prevuser['ipaddress']!=$user_account_regip_output)
			{
				$detail['prev'] = $prevuser['ipaddress'];
				$detail['field'] = 'ipaddress';
				$detail['record'] = $user_id_user_edit;
				$detail['where'] = 'uid';
				$detail['post'] = $user_account_regip_output;
				$details = serialize($detail);
				$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','users_edit.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','users','{$details}') ");
				unset($detail);
			}
		}
		// Avatar URL
		$user_account_avatar_output = $db->sanitise($_POST['user_account_avatar_input']);
		if(!empty($user_account_avatar_output))
		{
			$query = $db->query("UPDATE ".TABLE_PREFIX."users SET avatar='{$user_account_avatar_output}' WHERE uid='{$user_id_user_edit}'");
			if($prevuser['avatar']!=$user_account_avatar_output)
			{
				$detail['prev'] = $prevuser['avatar'];
				$detail['field'] = 'avatar';
				$detail['record'] = $user_id_user_edit;
				$detail['where'] = 'uid';
				$detail['post'] = $user_account_avatar_output;
				$details = serialize($detail);
				$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','users_edit.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','users','{$details}') ");
				unset($detail);
			}
		}
		// Admin Style
			// To be added later when the style system is created...
		// About Me Info
			// Added later when user profile is created...
		// User Status
			// Added later when user profile is created...
		// Is the target user staff or not?
		$user_account_staff_output = intval($_POST['user_account_staff_input']);
		if($user_account_staff_output==1 || $user_account_staff_output==0)
		{
			$query = $db->query("UPDATE ".TABLE_PREFIX."users SET status='{$user_account_staff_output}' WHERE uid='{$user_id_user_edit}'");
			if($prevuser['status']!=$user_account_staff_output)
			{
				$detail['prev'] = $prevuser['status'];
				$detail['field'] = 'status';
				$detail['record'] = $user_id_user_edit;
				$detail['where'] = 'uid';
				$detail['post'] = $user_account_staff_output;
				$details = serialize($detail);
				$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','users_edit.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','users','{$details}') ");
				unset($detail);
			}
		}
		// Primary Usergroup
		$user_account_groupid_output = intval($_POST['user_account_groupid_input']);
		if(isset($user_account_groupid_output))
		{
			if($perms->level_check($imp->user['gid'],$user_account_groupid_output,'gid')===true || $perms->super_admin($imp->user['uid']))
			{
				$prevgroup = $prevuser['gid'];
				$query = $db->query("UPDATE ".TABLE_PREFIX."users SET gid='{$user_account_groupid_output}' WHERE uid='{$user_id_user_edit}'");
				if($prevuser['gid']!=$user_account_groupid_output)
				{
					$detail['prev'] = $prevuser['gid'];
					$detail['field'] = 'gid';
					$detail['record'] = $user_id_user_edit;
					$detail['where'] = 'uid';
					$detail['post'] = $user_account_groupid_output;
					$details = serialize($detail);
					$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','users_edit.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','users','{$details}') ");
					unset($detail);
				}
			}
			else
			{
				$bad = "&error=grouplev";
			}
		}
		// Secondary Usergroup
			// To be added when the Secondary Usergroup function is created...
		// Admin Control Panel Access
			// To be added at a later time...
	}
	regenerate_cache('users',$user_id_user_edit);
	// Redirect and Exit
	header("Location: ../users.php?action=done{$bad}");
	exit;
}

//===========================================================================
// USERGROUP EDITTING PAGE (usergroups_edit.php)
//===========================================================================

if(isset($_POST['usergroup_edit']) && $perms->check_perms("admin:can_edit_usergroups"))
{
	// Group ID
	$usergroup_id = intval($_POST['usergroup_id']);
	$prevgroup = getgroup($usergroup_id);
	$loc = 'usergroups_edit.php';
	// Group Name
	$usergroup_name = $db->sanitise($_POST['group_name']);
	if(isset($usergroup_name) && $prevgroup['name']!=$usergroup_name)
	{
		$db->new_update('usergroups','name='.$usergroup_name,'gid='.$usergroup_id,$prevgroup['name']);
	}
	
	// Group Description
	$usergroup_desc = $db->sanitise($_POST['group_description']);
	if(isset($usergroup_desc) && $prevgroup['description']!=$usergroup_desc)
	{
		$db->new_update('usergroups','description='.$usergroup_desc,'gid='.$usergroup_id,$prevgroup['description']);
	}
	
	// Administrator Level
	$usergroup_alevel = intval($_POST['group_admin_level']);
	if(isset($usergroup_alevel) && $perms->check_perms("can_edit_adminlevels") && $prevgroup['adminlevel']!=$usergroup_alevel)
	{
		$db->new_update('usergroups','adminlevel='.$usergroup_alevel,'gid='.$usergroup_id,$prevgroup['adminlevel']);
	}
	
	// Public Permissions
	if($perms->level_check($imp->user['gid'],$usergroup_id,'gid')===true || $perms->super_admin($imp->user['uid']))
	{
		$prevperms = $perms->fetch_perms('usergroup',$usergroup_id);
		include_once("../../../cache/permlist.php");
		// Gather all of the permissions using a master permissions list.
		foreach($regpermissions as $row)
		{
			$postrow = $row;
			if(!isset($_POST[$postrow]) || $_POST[$postrow]=='')
			{
				$_POST[$postrow] = $prevperms[$row];
			}
			$regperms[$postrow] = intval($_POST[$postrow]);
		}
		$regperm = serialize($regperms);
		if($regperms!=$prevperms)
		{
			$db->new_update('usergroups','permissions='.$regperm,'gid='.$usergroup_id,serialize($prevperms));
		}
	}
	else
	{
		$bad = "&error=grouplev";
	}
	// Admin Permissions
	if(($perms->check_perms("can_edit_adminperms") && $perms->level_check($imp->user['gid'],$usergroup_id,'gid')===true) || $perms->super_admin($imp->user['uid']))
	{
		$prevperms = $perms->fetch_perms('usergroup',$usergroup_id);
		include_once("../../../cache/permlist.php");
		// Gather all of the permissions using a master permissions list.
		foreach($adminpermissions as $row)
		{
			$postrow = $row;
			if(!isset($_POST[$postrow]) || $_POST[$postrow]=='')
			{
				$_POST[$postrow] = $prevperms[$row];
			}
			$regperms[$postrow] = intval($_POST[$postrow]);
		}
		$regperm = serialize($regperms);
		$query = $db->query("UPDATE ".TABLE_PREFIX."usergroups SET permissions='{$regperm}' WHERE gid='{$usergroup_id}'");
		if($regperms!=$prevperms)
		{
			$db->new_update('usergroups','permissions='.$regperm,'gid='.$usergroup_id,serialize($prevperms));
		}
	}
	else
	{
		$bad = "&error=grouplev";
	}
	regenerate_cache('groups',$usergroup_id);
	// Redirect and Exit
	header("Location: ../usergroups.php?action=done{$bad}");
	exit;
}

// *Error Message*
// If user has been taken here with no expectation of editing settings...
echo 'Wow! It seems like you have been directed here without any reason to edit settings!<br />';
echo 'If you have been taken here by a form, contact the owner of this site; or if you are here because of browser problems, click back below and try again!<br />';
echo '<input type="button" value="Click here to go Back" onClick="history.go(-1);return true;">';

?>