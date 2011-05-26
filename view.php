<?php
/*
MillionCMS Project
    
    Name: View Page
    Description: Scripts that displays pages to the end-user.
	Last Update: 02 November 2010
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

// Yes, this is a front-end file not an include.
define("IN_IMPROV","1");

// This is where the magic begins with the pixies
require_once("./global.php");
$loc = 'view.php';
// Before the user can do anything here, check if they can actually view pages
if(!$perms->check_perms("can_view_pages"))
{
	error("You do not have permission to view this page");
	exit;
}
// Convert the page id into an integer for security reasons.
$pid = intval($_REQUEST['pid']);
$title = strtolower($_REQUEST['title']);

// Continue if the page id is valid
// Fetch gets processed first now
if(isset($_GET['fetch']))
{
	if($_GET['fetch']=='options')
	{
		$smarty->assign('pid',$pid);
		$smarty->display("db:options_page");
	}
	elseif($_GET['fetch']=='comments')
	{
		require_once(ROOT."/inc/articles.class.php");
		if(!is_object($articles))
		{
			$articles = new articles;
			echo $articles->get_comment($_REQUEST['cid']);
		}
	}
}
elseif($_GET['uid'] || $_GET['user'])
{
	if(!empty($_GET['uid']))
	{
		$uid = $db->sanitise($_GET['uid']);
	}
	else
	{
		$uid = getuid($db->sanitise($_GET['user']));
		if(!$uid)
		{
			error("This user does not exist");
			exit;
		}
		$uname = $_GET['user'];
	}
	$cutoff = 250;
	if(!empty($_GET['uid']))
	{
		$uname = getname($uid);
		if($uname=='Guest')
		{
			error("This user does not exist");
			exit;
		}
	}
	$query = $db->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE author='{$uid}' ORDER BY pid DESC LIMIT 0, 10");
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
	<tr><th>Pages by {$uname}</th></tr>";
	// Since there are no results.
	if($notable)
	{
		$table .= "<tr class='trow'><td>There are currently no pages created by {$uname}</td></tr>";
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
		<tr><td><a href='view.php?title={$row['title']}'>{$row['nicetitle']}</a></td></tr>
		<tr><td>{$content}</td></tr></table></td></tr>";
		// Saves memory.
		unset($content);
		unset($tcontent);
	}
	// Close the table.
	$table .= "</table>";
	$smarty->assign('uname',$uname);
	$smarty->assign('commenthead',$commenthead);
	$smarty->assign('table',$table);
	$smarty->display("db:view_uid");
}
elseif($_REQUEST['action']=='report')
{
	if($perms->check_perms("can_report_pages"))
	{
		$view = $templates->fetch("page_view_report");
		$sidebar = "&nbsp;";
		if(!empty($title))
		{
			$title = $db->sanitise($title);
			$query = $db->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE title='{$title}'");
		}
		else
		{
			$query = $db->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE pid='{$pid}'");
		}
		$count = $db->num($query);
		if($count=='0')
		{
			error("This page does not exist");
			exit;
		}
		$page = $db->fetch_array($query);
		if($page['status']=='5' && !$perms->check_perms("can_view_deleted_pages"))
		{
			error("This page does not exist");
			exit;
		}
		elseif($page['title']=='index')
		{
			header("Location: index.php");
			error("You may not directly navigate to this page, please visit index.php");
			exit;
		}
		$sidebar = $gadgets->retrieve_sidebar('left');
		$pntitle = $page['nicetitle'];
		$pcontent = $page['content'];
		require_once(ROOT."/inc/functions_parser.php");
		// Let's run a check to see if this has a custom page block.
		$check = preg_match("#\[page=custom\](.*)\[\/page\]#iUs",$page['content'],$custom);
		if($check)
		{
			// Hide page block BBcode from open view.
			$pcontent = preg_replace("#\[page=custom\](.*)\[\/page\]#iUs","",$pcontent);
			$p_parser = page_parser($custom['0']);
			if($p_parser['sidebar'])
			{
				if($p_parser['sidebar_left'])
				{
					$sidebar = $p_parser['sidebar_left'];
				}
				if($p_parser['sidebar_right'])
				{
					$sidebar_r = $p_parser['sidebar_right'];
				}
			}
			if($p_parser['pagelist'])
			{
				require_once(ROOT."/inc/articles.class.php");
				if(!is_object($articles))
				{
					$articles = new articles;
				}
				if($p_parser['pagelist_cutoff_bool'])
				{
					$mcontent .= $articles->generate_pagelist(0,$p_parser['pagelist_cutoff']);
				}
				else
				{
					$mcontent .= $articles->generate_pagelist(0);
				}
			}
			if($p_parser['comments'])
			{
				require_once(ROOT."/inc/articles.class.php");
				$commenthead = "<script type='text/javascript' src='./js/editcomment.js'></script>";
				if(!is_object($articles))
				{
					$articles = new articles;
				}
				if(isset($_POST['ccontent']))
				{
					$articles->add_comment($page['pid'],$_POST['ccontent']);
				}
				elseif(isset($_REQUEST['delcid']))
				{
					$cdelete = $articles->delete_comment($_REQUEST['delcid']);
					if(!$cdelete)
					{
						error("Something went wrong!");
					}
				}
				elseif(isset($_POST['uccontent']))
				{
					$update = $articles->update_comment($_POST['cid'],$_POST['uccontent']);
					if(!$update)
					{
						error("Something went wrong!");
					}
				}
				$mcontent .= $articles->generate_comments($page['pid']);
			}
			if($p_parser['rmcontent'])
			{
				$rcontent = ' ';
			}
		}
		$settings['bbcode'] = 1;
		$settings['allowhtml'] = 0;
		$pcontent = parser($settings,$pcontent);
		if(!isset($rcontent))
		{
			$rcontent = '<table border="1" width="100%" class="tborder" cellspacing="0">
			<tr class="tcat"><th>'.$pntitle.'<div id="socialbuttons" style="float:right;">
<iframe src="http://www.facebook.com/plugins/like.php?href='.urlencode($imp->settings['siteurl'].'/view.php?title='.$page['title']).'&amp;layout=button_count&amp;show_faces=false&amp;width=100&amp;action=recommend&amp;font=tahoma&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true">
			</iframe><a href="http://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a>
			<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div></th></tr>
			<tr class="trow"><td>'.$pcontent.'</td></tr></table>';
		}
		$view = addslashes($view);
		$header = str_replace('<div id="toolbox"><li><a href="#" onclick="return false" class="nav">Toolbox</a>','<div id="page_edit"><li><a href="#" onclick="return false" class="nav">Options</a></li></div>
		<div id="toolbox"><li><a href="#" onclick="return false" class="nav">Toolbox</a>',$header);
		$extra = str_replace('$(document).ready(function() {','$(document).ready(function() {
		$(\'#show_page_report\').AeroWindow({
			WindowTitle:          \'Test\',
			WindowPositionTop: \'center\',
			WindowWidth:          750,
			WindowHeight:         450,
			WindowAnimation:      \'easeOutBounce\'        
			});',$headerincludes);
		$smarty->assign('pid',$pid);
		if($perms->check_perms("can_view_toolbox"))
		{
			$report = $templates->fetch("report_view_toolbox");
			$report = addslashes($report);
			eval("\$report = \"$report\";");
		}
		else
		{
			$report = $templates->fetch("report_view");
			$report = addslashes($report);
			eval("\$report = \"$report\";");
		}
		$smarty->assign('pntitle',$pntitle);
		$smarty->assign('sidebar',$sidebar);
		$smarty->assign('pcontent',$pcontent);
		$smarty->assign('report',$report);
		$smarty->display("db:page_view_report");
	}
	else
	{
		error("You do not have permission to view this page");
		exit;
	}
}
elseif($_REQUEST['do']=='report')
{
	if($perms->check_perms("can_report_pages"))
	{
		$report = true;
		$content = $db->sanitise($_REQUEST['content']);
		if(!empty($title))
		{
			$title = $db->sanitise($title);
			$query = $db->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE title='{$title}'");
		}
		else
		{
			$query = $db->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE pid='{$pid}'");
		}
		$check = $db->num($test);
		if($check!='1')
		{
			error("The page does not exist");
			exit;
		}
		$query = $db->query("SELECT * FROM ".TABLE_PREFIX."reports WHERE pid='{$pid}'");
		$count = $db->num($query);
		if($count!='0')
		{
			$report = false;
			echo 'This page has already been reported';
		}
		if($report!=false)
		{
			if(empty($_REQUEST['content']))
			{
				error("No content specified");
				exit;
			}
			$db->query("INSERT INTO ".TABLE_PREFIX."reports (pid,content,uid,status) VALUES ('{$pid}','{$content}','{$imp->user['uid']}',0) ");
			echo 'The page has successfully been reported';
			exit;
		}
		error("Something went wrong!");
		exit;
	}
	else
	{
		error("You do not have permission to view this page");
		exit;
	}
}
elseif(!empty($pid) || !empty($title))
{
	$sidebar = "&nbsp;";
	if(!empty($title))
	{
		$title = $db->sanitise($title);
		$query = $db->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE title='{$title}'");
	}
	else
	{
		$query = $db->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE pid='{$pid}'");
	}
	$count = $db->num($query);
	if($count=='0')
	{
		error("This page does not exist");
		exit;
	}
	$page = $db->fetch_array($query);
	if($page['status']=='5' && !$perms->check_perms("can_view_deleted_pages"))
	{
		error("This page does not exist");
		exit;
	}
	elseif($page['title']=='index')
	{
		header("Location: index.php");
		error("You may not directly navigate to this page, please visit index.php");
		exit;
	}
	$sidebar = $gadgets->retrieve_sidebar('left');
	$pntitle = $page['nicetitle'];
	$pcontent = $page['content'];
	// Set default value for right sidebar.
	$sidebar_r = "&nbsp;";
	$topbar = "";
	$topbar = $gadgets->retrieve_sidebar('top');
	$sidebar_r = $gadgets->retrieve_sidebar('right');
	require_once(ROOT."/inc/functions_parser.php");
	// Let's run a check to see if this has a custom page block.
	$check = preg_match("#\[page=custom\](.*)\[\/page\]#iUs",$page['content'],$custom);
	if($check)
	{
		// Hide page block BBcode from open view.
		$pcontent = preg_replace("#\[page=custom\](.*)\[\/page\]#iUs","",$pcontent);
		$p_parser = page_parser($custom['0']);
		if($p_parser['sidebar'])
		{
			if($p_parser['sidebar_left'])
			{
				$sidebar = $p_parser['sidebar_left'];
			}
			if($p_parser['sidebar_right'])
			{
				$sidebar_r = $p_parser['sidebar_right'];
			}
		}
		if($p_parser['pagelist'])
		{
			require_once(ROOT."/inc/articles.class.php");
			if(!is_object($articles))
			{
				$articles = new articles;
			}
			if($p_parser['pagelist_cutoff_bool'])
			{
				$mcontent .= $articles->generate_pagelist(0,$p_parser['pagelist_cutoff']);
			}
			else
			{
				$mcontent .= $articles->generate_pagelist(0);
			}
		}
		if($p_parser['comments'])
		{
			require_once(ROOT."/inc/articles.class.php");
			$commenthead = "<script type='text/javascript' src='./js/editcomment.js'></script>";
			if(!is_object($articles))
			{
				$articles = new articles;
			}
			if(isset($_POST['ccontent']))
			{
				$articles->add_comment($page['pid'],$_POST['ccontent']);
			}
			elseif(isset($_REQUEST['delcid']))
			{
				$cdelete = $articles->delete_comment($_REQUEST['delcid']);
				if(!$cdelete)
				{
					error("Something went wrong!");
				}
			}
			elseif(isset($_POST['uccontent']))
			{
				$update = $articles->update_comment($_POST['cid'],$_POST['uccontent']);
				if(!$update)
				{
					error("Something went wrong!");
				}
			}
			if(!empty($title))
			{
				$mcontent .= $articles->generate_comments($page['pid'],'title');
			}
			else
			{
				$mcontent .= $articles->generate_comments($page['pid'],'pid');
			}
		}
		if($p_parser['rmcontent'])
		{
			$rcontent = ' ';
		}
	}
	$settings['bbcode'] = 1;
	$settings['smilies'] = 1;
	if($perms->cross_check("can_use_html",$page['author']))
	{
		$settings['allowhtml'] = 1;
	}
	else
	{
		$settings['allowhtml'] = 0;
	}
	$pcontent = parser($settings,$pcontent);
	if(!isset($rcontent))
	{
		$rcontent = '<table border="1" width="100%" class="tborder" cellspacing="0">
			<tr class="tcat"><th>'.$pntitle.'<div id="socialbuttons"style="float:right;">
<iframe src="http://www.facebook.com/plugins/like.php?href='.urlencode($imp->settings['siteurl'].'/view.php?title='.$page['title']).'&amp;layout=button_count&amp;show_faces=false&amp;width=100&amp;action=recommend&amp;font=tahoma&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true">
			</iframe><a href="http://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a>
			<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div></th></tr>
			<tr class="trow"><td>'.$pcontent.'</td></tr></table>';
	}
	//$header = str_replace('<li id="toolbox">','<li id="page_edit"><a href="#" onclick="return false" class="nav">Options</a></li>
	$smarty->assign('commenthead',$commenthead);
	$smarty->assign('topbar',$topbar);
	$smarty->assign('rcontent',$rcontent);
	$smarty->assign('mcontent',$mcontent);
	$smarty->assign('sidebar',$sidebar);
	$smarty->assign('sidebar_r',$sidebar_r);
	$smarty->assign('commenthead',$commenthead);
	$smarty->display("db:page_view");
	// Do these tasks after the page has been sent to the end-user.
	$newview = $page['views']+1;
	$db->query("UPDATE ".TABLE_PREFIX."pages SET views='{$newview}' WHERE pid='{$page['pid']}'");
}
else
{
	header('Location: index.php');
}

?>