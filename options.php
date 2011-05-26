<?php
/*
ImprovCMS Project
    
    Name: Options.
    Description: A sort of UserCP.
	Last Update: 02 November 2010
    Author: Azareal

    Copyright © 2010 Azareal and Improv Software Group
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
define("IN_IMPROV","1");
$loc = 'options.php';
// This is where the magic begins with the pixies
require_once("./global.php");

// Need some permission to keep the guests out.
if(!$perms->check_perms("can_view_toolbox") || $imp->user['uid']==0)
{
	error("You do not have permission to view this page");
	exit;
}

// Check for incoming requests from the toolbox
if(!empty($_REQUEST['changeavatar']))
{
	// Check for any problems.
	if(($_FILES['avatar']['size'] < 200000))
	{
		if ($_FILES['avatar']['error'] > 0)
		{
			error("An internal error has occured, upload suspended");
		}
		$ext = '';
		if($_FILES['avatar']['type']=='image/jpeg')
		{
			$ext = '.jpg';
		}
		$exts = split("[/\\.]",$_FILES['avatar']['name']) ; 
		$n = count($exts)-1; 
		$ext = $exts[$n];
		$avi = "./images/uploads/avatars/".$imp->user['uid'].'.'.$ext;
		if (file_exists('./images/uploads/avatars/'.$imp->user['uid'].'.'.$ext))
		{
			unlink('./images/uploads/avatars/'.$imp->user['uid'].'.'.$ext);
			move_uploaded_file($_FILES['avatar']['tmp_name'],'./images/uploads/avatars/'.$imp->user['uid'].'.'.$ext);
			$db->query("UPDATE ".TABLE_PREFIX."users SET avatar='{$avi}' WHERE uid='{$imp->user[uid]}'");
			echo 'The upload was successful!';
		}
		else
		{
			move_uploaded_file($_FILES['avatar']['tmp_name'],'./images/uploads/avatars/'.$imp->user['uid'].'.'.$ext);
			$db->query("UPDATE ".TABLE_PREFIX."users SET avatar='{$avi}' WHERE uid='{$imp->user[uid]}'");
			echo 'The upload was successful!';
		}
	}
	else
	{
		error("An error has occured".$_FILES['avatar']['size']);
	}
}
else // Otherwise, this is run
{
	// Do the template stuff.
	$smarty->assign('name',$imp->user['username']);
	$smarty->display("db:usercp_page");
}
?>