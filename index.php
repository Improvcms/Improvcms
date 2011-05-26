<?php
/*
MillionCMS Project
    
    Name: The Index Page
    Description: The frontpage of the MillionCMS installation.
	
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

// This is where the magic begins with the pixies.
require_once("./global.php");
$loc = 'index.php';
if(isset($_GET['fetch']))
{
	if($_GET['fetch']=='comments')
	{
		require_once(ROOT."/inc/articles.class.php");
		if(!is_object($articles))
		{
			$articles = new articles;
			echo $articles->get_comment($_REQUEST['cid']);
		}
		else
		{
			error("A mysterious error has magically occurred in the pixie world");
		}
		exit;
	}
}

require(ROOT.'/inc/content.class.php');
$content = new content('index');
// Get these variables.
$pixientitle = $content->page['nicetitle'];
$pixiecontent = $content->content;
// Pixies grant special powers to the nice title.
eval("\$pixientitle = \"$pixientitle\";");
$rcontent = $content->variables['rcontent'];
// Pixies begin their checks.
if(empty($rcontent))
{
	// Pixies give a value to this variable.
	$rcontent = '<table border="1" width="100%" class="tborder" cellspacing="0">
	<tr class="tcat"><th>'.$pixientitle.'<div id="socialbuttons"style="float:right;">
<iframe src="http://www.facebook.com/plugins/like.php?href='.urlencode($imp->settings['siteurl'].'/index.php').'&amp;layout=button_count&amp;show_faces=false&amp;width=100&amp;action=recommend&amp;font=tahoma&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true">
			</iframe><a href="http://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a>
			<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div></th></tr>
	<tr class="trow"><td>'.$pixiecontent.'</td></tr></table>';
}
$smarty->assign('commenthead',$content->variables['commenthead']);
$smarty->assign('topbar',$content->variables['topbar']);
$smarty->assign('debug',$db->queries);
$smarty->assign('rcontent',$rcontent);
$smarty->assign('mcontent',$content->variables['mcontent']);
$smarty->assign('sidebar',$content->sidebar['left']);
$smarty->assign('sidebar_r',$content->sidebar['right']);
$smarty->display("db:index");
$pixie = $content->page;
// Do these tasks after the page has been sent to the end-user by the pixies.
$newview = $pixie['views']+1;
$db->query("UPDATE ".TABLE_PREFIX."pages SET views='{$newview}' WHERE pid='{$pixie['pid']}'");
?>