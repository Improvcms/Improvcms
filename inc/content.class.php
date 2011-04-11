<?php
/*
MillionCMS Project

	Name: Content Class
	Description: Where the content for pages is processed basically, the page engine.
	
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

class content
{
	public $content;
	public $sidebar = array();
	public $variables = array();
	public $page;
	// Get the needed page.
	function __construct($title)
	{
		global $db, $perms, $mcms, $gadgets, $loc;
		if($title=='index')
		{
			if($loc=='view.php')
			{
				header("Location: index.php");
				error("You may not directly navigate to this page, please visit index.php");
				exit;
			}
			// Perform the query to get the index.
			$query = $db->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE title='index'");
			// Count how many results come up.
			$count = $db->num($query);
			// If the index page does not exist then, something has gone terribly wrong for the pixies.
			if($count=='0')
			{
				error("Error! The index page does not exist in the database, contact the administrator.");
				exit;
			}
			// Pixies are feeling well.
			$pixie = $db->fetch_array($query);
		}
		else
		{
			if(!empty($title))
			{
				$query = $db->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE title='{$title}'");
			}
			else
			{
				global $pid;
				$query = $db->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE pid='{$pid}'");
			}
			$count = $db->num($query);
			if($count=='0')
			{
				error("This page does not exist");
				exit;
			}
			// Pixies are feeling well.
			$pixie = $db->fetch_array($query);
			if($pixie['status']=='5' && !$perms->check_perms("can_view_deleted_pages"))
			{
				error("This page does not exist");
				exit;
			}
		}
		// Register this in globals.
		$GLOBALS['pixie'] = $pixie;
		// Pixies want this too.
		$sidebar = $gadgets->retrieve_sidebar('left');
		$pntitle = $pixie['nicetitle'];
		$pcontent = $pixie['content'];
		// Set default value for the sidebar positioned on the right for the pixies.
		$sidebar_r = "&nbsp;";
		$topbar = "";
		$topbar = $gadgets->retrieve_sidebar('top');
		$sidebar_r = $gadgets->retrieve_sidebar('right');
		// Pixies want to invite their friends.
		require_once(ROOT."/inc/functions_parser.php");
		// Let's send the pixies to check if this is a magical page.
		$check = preg_match("#\[page=custom\](.*)\[\/page\]#iUs",$pixie['content'],$custom);
		if($check)
		{
			// Hide the page BBcode from our pixies.
			$pcontent = preg_replace("#\[page=custom\](.*)\[\/page\]#iUs","",$pcontent);
			// The friends of the pixies have arrived.
			$pixie_parser = page_parser($custom['0']);
			// If places for where the pixies sit are set.
			if($pixie_parser['sidebar'])
			{
				// Some pixies sit on the left of the page.
				if($pixie_parser['sidebar_left'])
				{
					$sidebar = $pixie_parser['sidebar_left'];
				}
				// Some on the right.
				if($pixie_parser['sidebar_right'])
				{
					$sidebar_r = $pixie_parser['sidebar_right'];
				}
			}
			// If we have a list of all the pixies.
			if($pixie_parser['pagelist'])
			{
				// The grand gates of the pixie kingdom open.
				require_once(ROOT."/inc/articles.class.php");
				// If the pixies don't have a home..
				if(!is_object($articles))
				{
					// Then, create somewhere for them to live.
					$articles = new articles;
				}
				// Pixies will check if a cutoff is defined.
				if($pixie_parser['pagelist_cutoff_bool'])
				{
					// Pixies will add this to their pile of content.
					$mcontent .= $articles->generate_pagelist(0,$pixie_parser['pagelist_cutoff']);
				}
				else
				{
					// Pixies are still keeping this.
					$mcontent .= $articles->generate_pagelist(0);
				}
			}
			// For pixies to communicate.
			if($pixie_parser['comments'])
			{
				// The grand gates of the pixie kingdom open.
				require_once(ROOT."/inc/articles.class.php");
				// Pixies put a roof on the comment shrine.
				$commenthead = "<script type='text/javascript' src='./js/editcomment.js'></script>";
				// If the pixies don't have a home..
				if(!is_object($articles))
				{
					// Then, create somewhere for them to live.
					$articles = new articles;
				}
				// Pixies decide to create a comment.
				if(isset($_POST['ccontent']))
				{
					$articles->add_comment($pixie['pid'],$_POST['ccontent']);
				}
				elseif(isset($_REQUEST['delcid'])) // Pixie admins decide to delete a comment.
				{
					$cdelete = $articles->delete_comment($_REQUEST['delcid']);
					// Pixies fail to delete comment.
					if(!$cdelete)
					{
						error("Something went wrong!");
					}
				}
				elseif(isset($_POST['uccontent'])) // Pixies change their minds.
				{
					$update = $articles->update_comment($_POST['cid'],$_POST['uccontent']);
					// They decide to change back.
					if(!$update)
					{
						error("Something went wrong!");
					}
				}
				// Pixies add the comments to their pile.
				$mcontent .= $articles->generate_comments($pixie['pid'],'title');
			}
			// Pixies throw everything away.
			if($pixie_parser['rmcontent'])
			{
				$rcontent = '&nbsp;';
			}
		}
		// Pixies grant the power to use smilies and BBcode.
		$pixiesettings['bbcode'] = 1;
		$pixiesettings['smilies'] = 1;
		// Pixies check if your allowed to use the mystical magic of HTML.
		if($perms->cross_check("can_use_html",$pixie['author']))
		{
			$pixiesettings['allowhtml'] = 1;
		}
		else
		{
			$pixiesettings['allowhtml'] = 0;
		}
		// Pixies begin to parse the page.
		$pcontent = parser($pixiesettings,$pcontent);
		$this->variables['commenthead'] = $commenthead;
		$this->variables['topbar'] = $topbar;
		$this->variables['rcontent'] = $rcontent;
		$this->variables['mcontent'] = $mcontent;
		$this->page = $pixie;
		$this->sidebar['left'] = $sidebar;
		$this->sidebar['right'] = $sidebar_r;
		$this->content = $pcontent;
	}
}
?>