<?php
/*
	MillionCMS Project
    
	Name: The Toolbox
	Description: All kinds of moderation things.
	Last Update: 10 October 2010
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
$loc = 'toolbox.php';
// Before the user can do anything here, check if they can actually view this script
if(!$perms->check_perms("can_view_toolbox"))
{
	error("You do not have permission to view this page");
	exit;
}
// Are we viewing this through jquery?
if($_REQUEST['mode']=='jquery')
{
	$sample = "&amp;mode=jquery";
}
// First, we figure what Toolbox page is being viewed.
if(empty($_REQUEST['page']))
{
	$location = 'home';
}
elseif($_REQUEST['page']=='home')
{
	$location = 'home';
}
elseif($_REQUEST['page']=='createpage')
{
	$location = 'createpage';
}
elseif($_REQUEST['page']=='listpage')
{
	$location = 'listpage';
}
elseif($_REQUEST['page']=='report')
{
	$location = 'reportpage';
}
elseif($_REQUEST['page']=='reportlist')
{
	$location = 'listreports';
}
elseif($_REQUEST['page']=='viewreport')
{
	$location = 'viewreport';
}
elseif($_REQUEST['page']=='deletereport')
{
	$location = 'deletereport';
}
elseif($_REQUEST['page']=='undeletereport')
{
	$location = 'undeletereport';
}
elseif($_REQUEST['page']=='deletedreports')
{
	$location = 'deletedreports';
}
elseif($_REQUEST['page']=='changeavatar')
{
	$location = 'changeavatar';
}
// Now, select the content based on the location.
if($location=='home')
{
	$ctemplate = 'toolbox_content_home';
}
elseif($location=='createpage')
{
	if($perms->check_perms("can_create_pages"))
	{
		$ctemplate = 'toolbox_create';
	}
	else
	{
		error("You do not have permission to view this area");
		exit;
	}
}
elseif($location=='listpage')
{
	if($perms->check_perms("can_view_page_list"))
	{
		$query = $db->query("SELECT * FROM ".TABLE_PREFIX."pages");
		$count = $db->num($query);
		if($count!='0')
		{
			$result = $db->loop2array($query);
			$plist .= '<tr><td>Subject</td><td>Controls</td></tr>';
			foreach($result as $row)
			{
				if($row['status']==5)
				{
					if($perms->check_perms("can_view_deleted_pages"))
					{
						if($perms->check_perms("can_undelete_pages"))
						{
							$undelete = "Undelete";
						}
						// Check if the user has edit access on that page.
						if($perms->page_check("edit",$row['pid']))
						{
							$edit = "Edit";
						}
						if(!isset($undelete) && !isset($edit))
						{
							$none = "None";
						}
						$plist .= "<tr><td><s><a target=\"_top\" href=\"view.php?pid={$row['pid']}\">{$row['nicetitle']}</s></td>
						<td>{$edit} {$undelete} {$none}</td></tr>";
					}
				}
				elseif($row['status']==3)
				{
					if($perms->page_check("delete",$row['pid']))
					{
						$sdelete = "Delete";
					}
					// Check if the user has edit access on that page.
					if($perms->page_check("edit",$row['pid']))
					{
						$sedit = "Edit";
					}
					if(!isset($sdelete) && !isset($sedit))
					{
						$snone = "None";
					}
					$plist .= "<tr><td><a target=\"_top\" href=\"view.php?pid={$row['pid']}\">
					<img src=\"./images/page-official.png\">{$row['nicetitle']}</td>
						<td>{$sedit} {$sdelete} {$snone}</td></tr>";
				}
				elseif($row['title']=='index')
				{
					// Check if the user has edit access on that page.
					if($perms->page_check("edit",$row['pid']))
					{
						$sedit = "Edit";
					}
					if(!isset($sedit))
					{
						$snone = "None";
					}
					eval("\$row[nicetitle] = \"$row[nicetitle]\";");
					$plist .= "<tr><td><a target=\"_top\" href=\"view.php?pid={$row['pid']}\">
					<img src=\"./images/page-official.png\">{$row['nicetitle']}</td>
						<td>{$sedit} {$snone}</td></tr>";
				}	
				else
				{
					if($perms->page_check("delete",$row['pid']))
					{
						$delete = "Delete";
					}
					// Check if the user has edit access on that page.
					if($perms->page_check("edit",$row['pid']))
					{
						$edit = "Edit";
					}
					if(!isset($delete) && !isset($edit))
					{
						$none = "None";
					}
					$plist .= "<tr><td><a target=\"_top\" href=\"view.php?pid={$row['pid']}\">
					<img src=\"./images/page.png\">{$row['nicetitle']}</td>
					<td>{$edit} {$delete} {$none}</td></tr>";
				}
			}
		}
		else
		{
			$plist = '<tr><td>There currently aren\'t any pages';
		}
		$smarty->assign('plist',$plist);
		$ctemplate = 'toolbox_plist';
		if($perms->check_perms("can_create_pages"))
		{
			$ctemplate2 = 'toolbox_create';
		}
	}
	else
	{
		error("You do not have permission to view this area");
		exit;
	}
}
elseif($location=='listreports')
{
	if($perms->check_perms("can_manage_reports"))
	{
		$query = $db->query("SELECT * FROM ".TABLE_PREFIX."reports");
		$count = $db->num($query);
		if($count!='0')
		{
			$result = $db->loop2array($query);
			$reports .= '<tr><td><img src="./images/report-alt.png" height="16" width="16">Reports</td><td><img src="./images/options.png">Report Controls</td></tr>';
			foreach($result as $row)
			{
				$query2 = $db->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE pid='{$row['pid']}'");
				$result2 = $db->fetch_array($query2);
				$count2 = $db->num($query2);
				// So reports for permanently deleted pages don't show up and screw things up.
				if($count2!='0')
				{
					// Hide reports for deleted pages if they can't view deleted pages.
					if($result2['status']!='5')
					{
						if($row['status']==1) // With 1 being read
						{
							$reports .= "<tr><td><a title=\"View the reported page\" target=\"_top\" href=\"view.php?pid={$row['pid']}\">{$result2['nicetitle']}</td>
							<td><a title=\"View the report itself\" href=\"toolbox.php?page=viewreport&amp;rid={$row['rid']}\">View</a> 
							<a title=\"Delete the report itself\" href=\"toolbox.php?page=deletereport&amp;rid={$row['rid']}\">Delete</a></td></tr>";
						}
						else // Unread reports
						{
							$reports .= "<tr><td><strong><a title=\"View the reported page\" target=\"_top\" href=\"view.php?pid={$row['pid']}\">{$result2['nicetitle']}</strong></td>
							<td><a title=\"View the report itself\" href=\"toolbox.php?page=viewreport&amp;rid={$row['rid']}\">View</a> 
							<a title=\"Delete the report itself\" href=\"toolbox.php?page=deletereport&amp;rid={$row['rid']}\">Delete</a></td></tr>";
						}
					}
				}
			}
		}
		else
		{
			$reports = '<tr><td>There currently aren\'t any reports to manage</td></tr>';
		}
		$smarty->assign('reports',$reports);
		$ctemplate = 'toolbox_report_list';
	}
	else
	{
		error("You do not have permission to view this area");
		exit;
	}
}
elseif($location=='viewreport')
{
	if($perms->check_perms("can_manage_reports"))
	{
		$rid = intval($_REQUEST['rid']);
		$query = $db->query("SELECT * FROM ".TABLE_PREFIX."reports WHERE rid='{$rid}'");
		$count = $db->num($query);
		if($count=='0')
		{
			$content = error("This report does not exist");
		}
		else
		{
			$report = $db->fetch_array($query);
			// Mark as read only if it's unread
			if($report['status']=='0')
			{
				// Marking the report as read since it's being viewed
				$db->query("UPDATE ".TABLE_PREFIX."reports SET status='1' WHERE rid='{$rid}'");
			}
			$query2 = $db->query("SELECT nicetitle FROM ".TABLE_PREFIX."pages WHERE pid='{$report['pid']}'");
			$page = $db->fetch_array($query2);
			$title = $page['nicetitle'];
			$name = getname($report['uid']);
			$content2 = nl2br($report['content']);
			$smarty->assign('title',$title);
			$smarty->assign('name',$name);
			$smarty->assign('content',$content2);
			$ctemplate = 'toolbox_report_view';
		}
	}
	else
	{
		error("You do not have permission to view this area");
		exit;
	}
}
elseif($location=='deletereport')
{
	if($perms->check_perms("can_manage_reports"))
	{
		$rid = intval($_REQUEST['rid']);
		$query = $db->query("SELECT * FROM ".TABLE_PREFIX."reports WHERE rid='{$rid}'");
		$count = $db->num($query);
		if($count=='0')
		{
			$content = error("This report does not exist");
			redirect("toolbox.php?page=reportlist&amp;delete=0");
		}
		else{
		$result = $db->fetch_array($query);
		if($result['status']=='2')
		{
			$content = error("This report has already been deleted");
			redirect("toolbox.php?page=reportlist&amp;delete=0");
		}
		$db->query("UPDATE ".TABLE_PREFIX."reports SET status='2' WHERE rid='{$rid}'");
		$content = "The selected report was successfully deleted";
		redirect("toolbox.php?page=reportlist&amp;delete=1");
		}
	}
	else
	{
		error("You do not have permission to view this area");
		exit;
	}
}
elseif($location=='undeletereport')
{
	if($perms->check_perms("can_manage_reports"))
	{
		$rid = intval($_REQUEST['rid']);
		$query = $db->query("SELECT * FROM ".TABLE_PREFIX."reports WHERE rid='{$rid}'");
		$count = $db->num($query);
		if($count=='0')
		{
			$content = error("This report does not exist");
			redirect("toolbox.php?page=reportlist&amp;undelete=0");
		}
		else
		{
			$result = $db->fetch_array($query);
			if($result['status']!='2')
			{
				$content = error("The selected report was not deleted in the first place");
				redirect("toolbox.php?page=reportlist&amp;undelete=0");
			}
			$db->query("UPDATE ".TABLE_PREFIX."reports SET status='1' WHERE rid='{$rid}'");
			$content = "The selected report was successfully undeleted";
			redirect("toolbox.php?page=reportlist&amp;undelete=1");
		}
	}
	else
	{
		error("You do not have permission to view this area");
		exit;
	}
}
elseif($location=='deletedreports')
{
	if($perms->check_perms("can_manage_reports") && $perms->check_perms("can_view_deleted_pages"))
	{
		$query = $db->query("SELECT * FROM ".TABLE_PREFIX."reports WHERE status='2'");
		$count = $db->num($query);
		if($count!='0')
		{
			$result = $db->loop2array($query);
			$reports .= '<tr><td>Page</td><td>Controls</td></tr>';
			foreach($result as $row)
			{
				$query2 = $db->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE pid='{$row['pid']}'");
				$result2 = $db->fetch_array($query2);
				$count2 = $db->num($query2);
				// So reports for permanently deleted pages don't show up and screw things up.
				if($count2!='0')
				{
					if($perms->check_perms("can_permanently_delete_reports"))
					{
						$delete = '<a onclick="javascript:return confirm(\'Are you sure you want to permanently delete this report? 
						You will not be able to get it back\')" title="Permanently Delete the Report" href="toolbox.php?page=deletereport&amp;rid='.$row['rid'].'">PermaDelete</a>';
					}
					$reports .= "<tr><td><strong><a title=\"View the reported page\" target=\"_top\" href=\"view.php?pid={$row['pid']}\">{$result2['nicetitle']}</strong></td>
					<td><a title=\"View the report itself\" href=\"toolbox.php?page=viewreport&amp;rid={$row['rid']}\">View</a> 
					<a title=\"Undelete the report itself\" href=\"toolbox.php?page=undeletereport&amp;rid={$row['rid']}\">Undelete</a>
					{$delete}</td></tr>";
				}
			}
		}
		else
		{
			$reports = '<tr><td>There currently aren\'t any deleted reports to manage</td></tr>';
		}
		$smarty->assign('reports',$reports);
		$ctemplate = 'toolbox_report_list';
	}
	else
	{
		error("You do not have permission to view this area");
		exit;
	}
}
elseif($location=='reportpage')
{
	if($perms->check_perms("can_report_pages"))
	{
		$pid = intval($_REQUEST['pid']);
		$smarty->assign('pid',$pid);
		$ctemplate = 'toolbox_report_page';
	}
	else
	{
		error("You do not have permission to view this area");
		exit;
	}
}
elseif($location=='changeavatar')
{
	$pid = intval($_REQUEST['pid']);
	$smarty->assign('pid',$pid);
	$ctemplate = 'toolbox_options_avatar';
}
else
{
	$ctemplate = 'toolbox_content_home';
}
$sneak = false;
if(empty($sample))
{
	$sneak = true;
}
$can_manage_reports = $perms->check_perms("can_manage_reports");
$smarty->assign('sample',$sample);
$smarty->assign('can_manage_reports',$can_manage_reports);
$smarty->assign('sneak',$sneak);
$smarty->assign('sidebar',$sidebar);
$smarty->assign('content',$ctemplate);
$smarty->assign('content2',$ctemplate2);
$smarty->display("db:page_toolbox");
?>