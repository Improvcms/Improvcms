<?php
/*
MillionCMS Project
    
    Name: Page Class
    Description: For all your page editting needs, 
	making creating and editting custom pages much easier.
	
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

class page
{
	public $page;
	public $cache;
	// I'll throw this in just to let the BBcode parser know this page is special.
	function __construct()
	{
		$page = '[page=custom]';
		$this->page = $page;
	}
	// To fetch a row to be used in sidebar or in tables.
	function get_row($content)
	{
		$row = "[row]{$content}[/row]";
		return $row;
	}
	// Same as before but, for the head.
	function get_head($content)
	{
		$head = "[head]{$content}[/head]";
		return $head;
	}
	// Put the head in with the rows
	function assemble_rows($head,$rows)
	{
		$table .= $head;
		// If it's an array then go through it.
		if(is_array($rows))
		{
			foreach($rows as $row)
			{
				$table .= $row;
			}
		}
		else
		{
			$table .= $rows;
		}
	}
	// Position is where the sidebar is on the page. 
	//Content is sidebar row content inbetween [row] tags.
	function new_sidebar($position,$content)
	{
		// For those who try to use an invalid $position.
		if($position!='left' || $position!='right' || $position!='bottom-left' || $position!='bottom-right')
		{
			// Default sidebar position.
			$position = 'left';
		}
		$sidebar .= "[sidebar={$position}]";
		// If $content is an array.
		if(is_array($content))
		{
			foreach($content as $con)
			{
				$sidebar .= $con;
			}
		}
		else
		{
			$sidebar .= $content;
		}
		$sidebar .= "[/sidebar]";
		$string = random_str(5);
		// If we're unlucky
		if(!empty($this->cache['sidebar'][$string]))
		{
			// Slightly longer to give much higher chance of uniqueness.
			$string = random_str(6);
		}
		// So sidebars can be deleted on the fly?
		$this->cache['sidebar'][$string] = $sidebar;
		// This is so this sidebar can be removed with del_sidebar() if needed.
		$this->cache['lastsidebar'] = $string;
		// Return the string so the script can remove this sidebar if needed.
		return $string;
	}
	// For removing sidebars.
	function del_sidebar($sidebar = $this->cache['lastsidebar'])
	{
		// If this sidebar can't be removed since it doesn't exist.
		if(empty($this->cache['sidebar'][$sidebar]))
		{
			return false;
		}
		// Deleting the sidebar.
		unset($this->cache['sidebar'][$sidebar]);
		return true;
	}
	// Function for putting the page together from all the arrays.
	function assemble_page()
	{
		$page .= $this->page;
		foreach($this->cache['sidebar'] as $sidebars)
		{
			$page .= $sidebars;
		}
		return $page;
	}
}
?>