<?php
/*
	MillionCMS Project
    
	Name: Page Creation Functions
	Description: Has the functions related to creating pages
	Last Update: 09 October 2010
	Author: Azareal

    Copyright © 2010 Azareal and MillionCMS Group
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
// Stops unauthorised users accessing this
if(!defined("IN_MILLION"))
{
	die("Access Denied");
}

function create_page($title,$nicetitle,$content,$uid,$status = 1)
{
	global $db;
	$test = $db->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE title='{$title}'");
	$count = $db->num($test);
	if($count!=0)
	{
		error("This page already exists");
		return false;
	}
	if(empty($title) || empty($nicetitle) || empty($content))
	{
		if(empty($title))
		{
			error("No title specified!");
		}
		elseif(empty($nicetitle))
		{
			error("No nice title specified!");
		}
		elseif(empty($content))
		{
			error("There is no content in this page!");
		}
		return false;
	}
	$title = $db->sanitise($title);
	$nicetitle = $db->sanitise($nicetitle);
	$content = $db->sanitise($content);
	$status = intval($status);
	$time = time();
	$db->query("INSERT INTO ".TABLE_PREFIX."pages (title,nicetitle,content,status,author,datecreated,lastupdated) 
	VALUES ('{$title}','{$nicetitle}','{$content}','{$status}','{$uid}','{$time}','{$time}') ");
	return true;
}

function edit_page($pid,$title,$nicetitle,$content,$status)
{
	global $db;
	$test = $db->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE pid='{$pid}'");
	$count = $db->num($test);
	if($count==0)
	{
		error("This page does not exist");
		return false;
	}
	if(empty($title) || empty($nicetitle) || empty($content))
	{
		if(empty($title))
		{
			error("No title specified!");
		}
		elseif(empty($nicetitle))
		{
			error("No nice title specified!");
		}
		elseif(empty($content))
		{
			error("There is no content in this page!");
		}
		return false;
	}
	$result = $db->fetch_array($test);
	// Check if anything has actually been changed
	if($title==$result['title'] && $nicetitle==$result['nicetitle'] && 
	$content==$result['content'] && $status==$result['status'])
	{
		// If nothing is changed then, report it as been successfully updated.
		return true;
	}
	$updated = false;
	// Otherwise, look for what things have been changed.
	if($title!=$result['title'])
	{
		$title = $db->sanitise($title);
		$db->query("UPDATE ".TABLE_PREFIX."pages SET title='{$title}' WHERE pid='{$pid}'");
		$updated = true;
	}
	// Using if instead of elseif incase multiple things were changed.
	if($nicetitle!=$result['nicetitle'])
	{
		$nicetitle = $db->sanitise($nicetitle);
		$db->query("UPDATE ".TABLE_PREFIX."pages SET nicetitle='{$nicetitle}' WHERE pid='{$pid}'");
		$updated = true;
	}
	// Probably the most likely thing to change.
	if($content!=$result['content'])
	{
		$content = $db->sanitise($content);
		$db->query("UPDATE ".TABLE_PREFIX."pages SET content='{$content}' WHERE pid='{$pid}'");
		$updated = true;
	}
	if($status!=$result['status'])
	{
		$status = intval($status);
		$db->query("UPDATE ".TABLE_PREFIX."pages SET status='{$status}' WHERE pid='{$pid}'");
		$updated = true;
	}
	if($updated)
	{
		$currenttime = time();
		$db->query("UPDATE ".TABLE_PREFIX."pages SET lastupdated='{$currenttime}' WHERE pid='{$pid}'");
	}
	return true;
}
function delete_page($pid,$soft,$reason=null)
{
	global $db;
	$test = $db->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE pid='{$pid}'");
	$count = $db->num($test);
	if($count==0)
	{
		error("This page does not exist in the first place");
		return false;
	}
	elseif(empty($pid))
	{
		error("No Page ID specified!");
		return false;
	}
	$soft = intval($soft);
	if($soft==0)
	{
		$db->query("DELETE FROM ".TABLE_PREFIX."pages WHERE pid='{$pid}'");
		return true;
	}
	elseif($soft==1)
	{
		// Set the soft-delete status.
		$db->query("UPDATE ".TABLE_PREFIX."pages SET status='5' WHERE pid='{$pid}'");
		return true;
	}
	else
	{
		// Something went wrong if it went to else so..
		return false;
	}
}
function fetch_status($string)
{
	switch ($x)
	{
		case "featured":
			$status = 6;
		break;
	
		case "normal":
			$status = 1;
		break;
		
		case "staff":
			$status = 3;
		break;
		
		case "hide":
			$status = 4;
		break;
		
		default:
			return false;
	}
	return $status;
}
// Function for checking if a status is valid
function is_status($status)
{
	/*
	1 is a normal page
	2 is unused
	3 is for staff pages
	4 is for hidden pages
	5 is for soft-deleted pages
	6 is for featured pages
	*/
	$status = intval($status);
	if($status==1 || $status==3 || $status==4 || $status==5 || $status==6)
	{
		return true;
	}
	return false;
}
?>