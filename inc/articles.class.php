<?php
/*
MillionCMS Project

	Name: Articles Class
	Description: Where all kinds of content are parsed, processed and returned to the calling script.
	
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

class articles
{
	public $add = 2;
	function generate_comments($input,$type)
	{
		global $db, $perms, $mcms;
		// Initial query to start things off.
		$qtest = $db->query("SELECT cid FROM ".TABLE_PREFIX."comments WHERE pid='{$input}'");
		// Fetch the number of comments.
		$rows = $db->num($qtest);
		// Limit the number of comments that are called by the main query.
		$limit = "LIMIT 0, 10";
		// Get the page title.
		$gettitle = $db->query("SELECT title FROM ".TABLE_PREFIX."pages WHERE pid='{$input}'");
		$getresult = $db->fetch_array($gettitle);
		$title = $getresult['title'];
		// If theres more than 10 comments then, run multipage.
		if($rows>10)
		{
			// Check which page we're on.
			if (empty($_REQUEST['cpage'])) 
			{ 
				$page = 1; 
			}
			else
			{
				$page = $_REQUEST['cpage'];
			}
			// Number of rows which appear on each page
			$prows = 10;
			// The number of the last page.
			$last = ceil($rows/$prows);
			// Calculate the current page number, dealing with silly numbers.
			if ($page<1) 
			{ 
				$page = 1; 
			} 
			elseif ($page>$last) 
			{ 
				$page = $last; 
			}
			else
			{
				$page = $page;
			}
			// Where to start the limit.
			$start = ($page-1)*$prows;
			// Generate a new limit.
			$limit = "LIMIT {$start},{$prows}";
			$output = $input;
			if($type=='title')
			{
				$output = $title;
			}
			for ($pi=2; $pi<=$last; $pi++)
			{
				if ($pi!=$page)
				{
					$pagi .= "<a href='{$_SERVER[PHP_SELF]}?{$type}={$output}&amp;cpage={$pi}'>{$pi}</a>&nbsp;";
				}
				else
				{
					$pagi .= "{$page}&nbsp;";
				}
			}
			if ($page==1)
			{
				$pagination = "Pages ({$last}):&nbsp;
				{$page}&nbsp;{$pagi}
				<a href='{$_SERVER[PHP_SELF]}?{$type}={$output}&amp;cpage=".($page+1)."'>Next &raquo;</a>";
			}
			elseif ($page>1 && $page==$last)
			{
				$pagination = "Pages ({$last}):&nbsp;
				<a href='{$_SERVER[PHP_SELF]}?{$type}={$output}&amp;cpage=".($page-1)."'>&laquo; Previous</a>&nbsp;
				1
				{$pagi}</div>";
			}
			elseif ($page>1)
			{
				$pagination = "Pages ({$last}):&nbsp;
				<a href='{$_SERVER[PHP_SELF]}?{$type}={$output}&amp;cpage=".($page-1)."'>&laquo; Previous</a>&nbsp;
				<a href='{$_SERVER[PHP_SELF]}?{$type}={$output}&amp;cpage=1'>1</a>&nbsp;
				{$pagi}
				<a href='{$_SERVER[PHP_SELF]}?{$type}={$output}&amp;cpage=".($page+1)."'>Next &raquo;</a></div>";
			}
			unset($pagi);
			unset($page);
			unset($start);
			unset($gettitle);
			// Table structure for pagination
			$pagination = "<tr class='trow'><td>{$pagination}</td></tr>";
		}
		// Fetches the comemnts, themselves.
		$query = $db->query("SELECT * FROM ".TABLE_PREFIX."comments WHERE pid='{$input}' ORDER BY time DESC {$limit}");
		// Make the result, loopable.
		$result = $db->loop2array($query);
		// Construct the comments table.
		$comments .= "<br /><table border='1' class='tborder' cellspacing='0' width='100%'>
		<tr><th>Comments</th></tr>";
		if($db->num($query)!=0)
		{
			require_once(ROOT."/inc/functions_parser.php");
			foreach($result as $row)
			{
				$username = getcname($row['author']);
				$settings['bbcode'] = 1;
				$settings['smilies'] = 1;
				$settings['allowhtml'] = 0;
				$content = parser($settings,$row['content']);
				$get_avatar = getavatar($row['author']);
				if(!empty($get_avatar))
				{
					$info = getimagesize("{$get_avatar}");
					$maxheight = intval($mcms->settings['avatar_maxheight']);
					$maxwidth = intval($mcms->settings['avatar_maxwidth']);
					if(empty($maxheight) || empty($maxwidth))
					{
						$maxheight = 500;
						$maxwidth = 500;
					}
					if($info['0']>=$maxwidth || $info['1']>=$maxheight)
					{
						$dim = resize_image($info['1'],$info['0'],$maxheight,$maxwidth);
						$height = $dim['height'];
						$width = $dim['width'];
						$limits = " width='{$width}' height='{$height}'";
					}
					$avatar = "<img src='{$get_avatar}'{$limits} alt='{$username} Avatar' title='{$username} Avatar' />";
				}
				$group = getgroup($row['author']);
				if($perms->check_perms("can_edit_comments"))
				{
					global $loc;
					$editbutton = "<a href=\"#\" onclick='editcomment(\"{$row['cid']}\",\"{$loc}\");return false' value='Edit'>
					<img src='./images/buttons/edit.png' width='38' height='21' alt='Edit' /></a>";
				}
				if($perms->super_admin($mcms->user['uid']) || $perms->check_perms("can_delete_comments"))
				{
					$deletebutton = "<form method='post' action='{$_SERVER['PHP_SELF']}?title={$title}'>
									 <!--<input type='submit' onClick='javascript:return confirm(\"Are you sure you want to permanently delete this comment?\")' value='Delete'>-->
									 <input type='hidden' value='{$row['cid']}' name='delcid' />
									 <input type='image' alt='Delete' src='./images/buttons/delete.png' onClick='return confirm(\"Are you sure you want to permanently delete this comment?\")' />
									 </form>";
				}
				if(isset($editbutton) || isset($deletebutton))
				{
					$controlbuttons = "<td valign='top'><table border='0'><tr><td valign='top'>
					{$editbutton}</td><td valign='top'>{$deletebutton}</td></tr></table></td>";
				}
				if(empty($avatar))
				{
					if(is_readable("./images/groups/".strtolower($group['name']).".png"))
					{
						$strgroup = strtolower($group['name']);
						$avatar = "<img src='./images/groups/{$strgroup}.png' alt='{$username} Avatar' title='{$username} Avatar' />";
					}
					else
					{
						$avatar = "<img src='./images/groups/registered.png' alt='{$username} Avatar' title='{$username} Avatar' />";
					}
				}
				$uusername = "<a href='./view.php?uid={$row['author']}'>{$username}</a>";
				$utitle = getutitle($row['author']);
				$comments .= "<tr class='trow'>
				<td><table border='0' cellspacing='0'>
				<tr><td width='30%'>{$avatar}</td><td><b>{$uusername}</b><br />
				{$utitle}<br />
				<b>Group:</b> <span title='{$group['description']}'>{$group['name']}</span></td>{$controlbuttons}</tr>
				<tr><td colspan='4' id='comment{$row['cid']}'>{$content}</td></tr>
				</table></td></tr>";
				unset($avatar);
				unset($editbutton);
				unset($group);
				unset($limits);
				unset($get_avatar);
			}
		}
		else
		{
			$comments .= "<tr class='trow'><td>There are currently no comments on this page</td></tr>";
		}
		if($this->add==1)
		{
			$comments .= "<tr class='trow'><td colspan='4'>Successfully created comment!</td></tr>";
		}
		elseif($this->add==0)
		{
			$comments .= "<tr class='trow'><td colspan='4'>Failed to create comment!</td></tr>";
		}
		$comments .= "{$pagination}";
		$comments .= "</table>";
		// Then, theres the stuff for creating comments.
		if($perms->check_perms("can_create_comments"))
		{
			$sample = "?{$type}={$title}";
			$comments .= "<table border='0' class='tborder' cellspacing='0'>
			<tr class='trow'><td>Add Comment</td></tr>
			<tr><td><form action='{$_SERVER['PHP_SELF']}{$sample}' method='post'>
			<textarea rows='5' cols='50' name='ccontent'></textarea></td></tr>
			<tr><td><input type='submit' value='Submit' /></form></td></tr>
			</table>";
		}
		return $comments;
	}
	function get_comment($cid)
	{
		global $db, $perms;
		$query = $db->query("SELECT * FROM ".TABLE_PREFIX."comments WHERE cid='{$cid}'");
		$result = $db->fetch_array($query);
		$return = "<form action='{$_SERVER[PHP_SELF]}?title={$result['title']}' method='post'>
		<textarea name='uccontent' cols='40'>".$result['content']."</textarea><br />
		<input type='hidden' name='cid' value='{$cid}' />
		<input type='submit' value='Update' />
		</form>";
		return $return;
	}
	function add_comment($pid,$content)
	{
		global $db, $perms, $mcms;
		if(empty($content))
		{
			return false;
		}
		if(!$perms->check_perms("can_create_comments"))
		{
			return false;
		}
		$content = $db->sanitise($content);
		$time = time();
		$author = $mcms->user['uid'];
		$query = $db->query("INSERT INTO ".TABLE_PREFIX."comments (pid,time,content,author) 
				VALUES ('{$pid}','{$time}','{$content}','{$author}') ");
		if($query)
		{
			$this->add = 1;
			return true;
		}
		else
		{
			$this->add = 0;
			return false;
		}
	}
	function update_comment($cid,$content)
	{
		global $db, $perms;
		if(empty($content))
		{
			return false;
		}
		if(empty($cid))
		{
			return false;
		}
		if(!$perms->check_perms("can_edit_comments"))
		{
			return false;
		}
		$cid = intval($cid);
		$content = $db->sanitise($content);
		if(!$this->is_comment($cid))
		{
			return false;
		}
		$query = $db->query("UPDATE ".TABLE_PREFIX."comments SET content='{$content}' WHERE cid='{$cid}'");
		if($query)
		{
			return true;
		}
		return false;
	}
	function delete_comment($cid)
	{
		global $db, $perms, $mcms;
		if(empty($cid))
		{
			return false;
		}
		if(!$perms->super_admin($mcms->user['uid']) && !$perms->check_perms("can_delete_comments"))
		{
			return false;
		}
		if(!$this->is_comment($cid))
		{
			return false;
		}
		$cid = intval($cid);
		$query = $db->query("DELETE FROM ".TABLE_PREFIX."comments WHERE cid='{$cid}'");
		if($query)
		{
			return true;
		}
		return false;
	}
	// Check if this comment exists.
	function is_comment($cid)
	{
		global $db;
		$cid = intval($cid);
		$query = $db->query("SELECT cid FROM ".TABLE_PREFIX."comments WHERE cid='{$cid}'");
		$count = $db->num($query);
		if($count=='0')
		{
			return false;
		}
		return true;
	}
	// Another content type, this time it's a pagelist.
	function generate_pagelist($exc = 0, $cutoff = 250)
	{
		global $db, $mcms; // Global the database class and core class so we can use them.
		// Check if any statuses are being excluded.
		if($exc==0) // If it's 0 then, nothing is being excluded.
		{
			$query = $db->query("SELECT * FROM ".TABLE_PREFIX."pages ORDER BY pid DESC LIMIT 0, 10");
		}
		else // Otherwise, something is being excluded.
		{
			$query = $db->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE status='{$exc}' ORDER BY pid DESC LIMIT 0, 10");
		}
		$result = $db->loop2array($query);
		// Default value.
		$notable = false;
		// If there are no pages.
		if(!is_array($result))
		{
			$result = array(); // Then, we set this as an array as a bugfix.
			// Shows there are no results.
			$notable = true;
		}
		// Require the parser include.
		require_once(ROOT."/inc/functions_parser.php");
		// Make the page list look better.
		$table .= "<br /><table border='1' class='tborder' cellspacing='0' width='100%'>
		<tr><th>Page List</th></tr>";
		// Since there are no results.
		if($notable)
		{
			$table .= "<tr class='trow'><td>There are currently no pages</td></tr>";
		}
		// Loop through the pages.
		foreach($result as $row)
		{
			// Specify the settings for the parser.
			$settings['bbcode'] = 1; // Do we want BBcode?
			$settings['allowhtml'] = 0; // What about HTML?
			// If the content is too big.
			if(strlen($row['content'])>=$cutoff)
			{
				// Don't want this advanced page BBcode showing.
				$tcontent = preg_replace("#\[page=custom\](.*)\[\/page\]#iUs","",$row['content']); // So we remove it.
				$content .= parser($settings,substr($tcontent,0,$cutoff)); // Parse the page content properly.
				$content .= "... <a href='./view.php?pid={$row['pid']}'>More</a>"; // Link to the page.
			}
			else // Content is a good size
			{
				// Don't want this advanced page BBcode showing.
				$tcontent = preg_replace("#\[page=custom\](.*)\[\/page\]#iUs","",$row['content']);
				$content = parser($settings,$tcontent);
			}
			// Time to build the table.
			$table .= "<tr class='trow'><td><table border='0' width='100%' cellspacing='0'>
			<tr><td><a href='view.php?pid={$row['pid']}'>{$row['nicetitle']}</a></td></tr>
			<tr><td>{$content}</td></tr></table></td></tr>";
			// Saves memory.
			unset($content);
			unset($tcontent);
		}
		// Close the table.
		$table .= "</table>";
		// Eval wants everything to be escaped.
		$table = addslashes($table);
		// Run eval.
		eval("\$table = \"$table\";");
		$table = stripslashes($table);
		return $table;
	}
}
?>