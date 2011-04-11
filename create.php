<?php
/*
	MillionCMS Project
    
	Name: Page Creation
	Version: Development
	Description: Contains the data for pages.
	Last Update: 09 October 2010

	Author: Kyuubi & Azareal


	Copyright Kyuubi, Azareal and the MillionCMS Group (C) 2010


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

// Define the location.
$loc = 'create.php';

// Yes, this is a front-end file not an include.
define("IN_MILLION","1");

// Include Important Scripts
require("global.php");


###############################################
############### START OF SCRIPT ###############
###############################################

// Prepare Conditional.
require_once("inc/functions_pages.php");
// At first, there won't be a response message.
$message = '';
// Check if someone is attempting to create a page.
if (isset($_REQUEST['submit24']))
{
	if($perms->check_perms("can_create_pages"))
	{
		$message = $_REQUEST['message'];
		if(!$perms->check_perms("can_use_page_block_bbcode"))
		{
			$message = preg_replace("#\[page=custom\](.*)\[\/page\]#iUs","",$_REQUEST['message']);
		}
		$result = create_page($_REQUEST['title'],$_REQUEST['subject'],$message,$mcms->user['uid'],0);
		if(!$result)
		{
			$message = "There was an error creating this page";
		}
		else
		{
			$message = "The page was successfully created";
		}
		redirect("view.php?pid={$db->last_id()}");
	}
	else
	{
		error("You do not have permission to view this area");
		exit;
	}
}
elseif (isset($_REQUEST['submit36'])) // Perhaps their trying to edit a page?
{
	$status = fetch_status($_REQUEST['selection']);
	if(!$status)
	{
		$valid = is_status($_REQUEST['selection']);
		if(!$valid)
		{
			error("Something went wrong with the status");
		}
	}
	$result = edit_page($_REQUEST['pid'],$_REQUEST['title'],$_REQUEST['subject'],$_REQUEST['message'],$status);
	if(!$result)
	{
		$message = "There was an error editting this page";
	}
	else
	{
		$message = "The page was successfully editted";
	}
	redirect("view.php?pid=".intval($_REQUEST['pid']));
}
if($_GET['do'] == 'create' || !isset($_GET['do']))
{
	$smarty->display("db:page_create");
}
elseif($_GET['do'] == 'edit')
{
	$smarty->display("db:page_edit");
}
elseif($_GET['do'] == 'delete')
{
	$smarty->display("db:page_del");
}
?>