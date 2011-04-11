<?php
/*
MillionCMS Gadget
    
    Name: Author Information
    Description: This gadget is designed to display information about the 
	author of the page which is currently being viewed such as avatar.

    Author: Azareal

    Copyright © 2010 Azareal
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

// Information on the gadget.
function authorinfo_info()
{
	$info['name'] = 'AuthorInfo';
	$info['description'] = 'A gadget which shows the information for individual pages and their authors in a sidebar';
	return $info;
}
function authorinfo_execute()
{
	global $page, $pixie, $loc;
	if($loc!='index.php')
	{
		$authorid = $page['author'];
		$current = $page;
	}
	else
	{
		$authorid = $pixie['author'];
		$current = $pixie;
	}
	$avatar = getavatar($authorid);
	if(empty($avatar))
	{
		$avatar = "./images/groups/guests.png";
	}
	$username = getname($authorid);
	$cusername = getname($authorid);
	$limit = "height='180'";
	$avatarmarkup = "<img src='{$avatar}' {$limit} alt='{$username} Avatar' title='{$username} Avatar' />";
	// Check if the page was created today.
	$today = time()-(60*60*24);
	$yesterday = time()-(60*60*24*2);
	$thisweek = time()-(60*60*24*7);
	$thismonth = time()-(60*60*24*31);
	if($today<$current['datecreated'])
	{
		$date = 'Today '.date('h:i:s A',$current['datecreated']);
	}
	elseif($yesterday<$current['datecreated'])
	{
		$date = 'Yesterday '.date('h:i:s A',$current['datecreated']);
	}
	elseif($thisweek<$current['datecreated'])
	{
		$diff = $current['datecreated']-$thisweek;
		$x = 7-floor($diff/(24*60*60));
		$lastdate = "{$x} days ago ".date('h:i:s A',$current['datecreated']);
	}
	elseif($thismonth<$current['datecreated'])
	{
		$diff = $current['datecreated']-$thismonth;
		$x = 31-floor($diff/(7*24*60*60));
		$lastdate = "{$x} weeks ago ".date('h:i:s A',$current['datecreated']);
	}
	else
	{
		$date = date('l jS \of F Y h:i:s A',$current['datecreated']);
	}
	// Check if the page was editted today.
	if($today<$current['lastupdated'])
	{
		$lastdate = 'Today '.date('h:i:s A',$current['lastupdated']);
	}
	elseif($yesterday<$current['lastupdated'])
	{
		$lastdate = 'Yesterday '.date('h:i:s A',$current['lastupdated']);
	}
	elseif($thisweek<$current['lastupdated'])
	{
		$diff = $current['lastupdated']-$thisweek;
		$x = floor(7-$diff/(24*60*60));
		$lastdate = "{$x} days ago ".date('h:i:s A',$current['lastupdated']);
	}
	elseif($thismonth<$current['lastupdated'])
	{
		$diff = $current['lastupdated']-$thismonth;
		$x = floor(31-($diff/(7*24*60*60)));
		$lastdate = "{$x} weeks ago ".date('h:i:s A',$current['lastupdated']);
	}
	else
	{
		$lastdate = date('l jS \of F Y h:i:s A',$current['lastupdated']);
	}
	if($current['title']=='index' || $current['status']=='6' || $current['status']=='3')
	{
		$pageicon = './images/page-official.png';
		$pageicon = "<img src='{$pageicon}' width='20' height='20' alt='(Official Page)' title='Official Page' /> ";
	}
	else
	{
		$pageicon = './images/page.png';
		$pageicon = "<img src='{$pageicon}' width='20' height='20' alt='(Regular Page)' title='Regular Page' /> ";
	}
	$uusername = "<a href='./view.php?uid={$authorid}'>{$cusername}</a>";
	$utitle = getutitle($authorid);
	if(!$utitle)
	{
		$utitle = 'Mysterious User';
	}
	$utitle = "<span title='{$utitle}'>{$utitle}</span>";
	$table .= "<table border='1' class='tborder' cellspacing='0'>
	<tr class='trow'><td>{$pageicon}Page Info</td></tr>
	<tr class='trow'><td>
	<table border='0' cellspacing='0'>
	<tr><td width='180'>{$avatarmarkup}</td></tr>
	<tr><td><p align='center'><b>{$uusername}</b><br />
	{$utitle}</p></td></tr>
	<tr class='trow'><td><b>Views:</b> <span title='The number of views this page has'>{$current['views']}</span><br />
	<b>Date Created:</b> <span title='The date this page was created'>{$date}</span><br />
	<b>Last Updated:</b> <span title='When this page was last modified'>{$lastdate}</span></td></tr></table>
	</td></tr></table>";
	return $table;
}

function authorinfo_check()
{
	global $loc;
	if($loc=='view.php' || $loc=='index.php')
	{
		return true;
	}
	return false;
}
?>