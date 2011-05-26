<?php
/*
	MillionCMS Project
    
	Name: Parsing Functions
	Description: The functions which parse things like BBcode.
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
if(!defined("IN_IMPROV"))
{
	die("Access Denied");
}

// To parse messages and similair.
function parser($settings,$message)
{
	global $imp;
	// Check if HTML is allowed.
	if ($settings['allowhtml']!=1)
	{
		$message = htmlentities($message);
	}
	// So the linebreaks will operate properly.
	$message = nl2br($message);
	// Parsing BBcode comes here.
	if($settings['bbcode']==1)
	{
		/*
		Large block to handle the BBcode.
		*/
		// Bold
		$message = preg_replace ('#\[b\](.+)\[\/b\]#iUs',"<b>$1</b>",$message);
		// Italic
		$message = preg_replace ('#\[i\](.+)\[\/i\]#iUs',"<i>$1</i>",$message);
		// Underline
		$message = preg_replace ('#\[u\](.+)\[\/u\]#iUs',"<u>$1</u>",$message);
		// Colour
		$message = preg_replace ('#\[color=(.+)\](.+)\[\/color\]#iUs',"<span style='color:$1;'>$2</span>",$message);
		// Quote
		$message = preg_replace("#\[quote\](.*?)\[\/quote\]#si","<blockquote><cite>Quote</cite><br />$1</blockquote><br />",$message);
		// Images
		$message = preg_replace("#\[img\](.*?)\[\/img\]#si","<img src='$1' alt='Embedded Image' />",$message);
		// URLs now
		$message = preg_replace("#\[url\](.*?)\[\/url\]#si","<a href='$1'>$1</a>",$message);
		// URLs with titles
		$message = preg_replace("#\[url=(.*?)\](.*?)\[\/url\]#si","<a href='$1'>$2</a>",$message);
		// Blink
		$message = preg_replace("#\[blink\](.*?)\[\/blink\]#si","<span style='text-decoration: blink;'>$1</span>",$message);
		// Strikethrough
		$message = preg_replace("#\[s\](.*?)\[\/s\]#si","<s>$1</s>",$message);
		// Code
		$message = preg_replace("#\[code\](.*?)\[\/code\]#si","<code>$1</code>",$message);
		// Abbreviation with title
		$message = preg_replace("#\[abbr=(.*?)\](.*?)\[\/abbr\]#si","<abbr title='$1'>$2</abbr>",$message);
		// Abbreviation without title
		$message = preg_replace("#\[abbr\](.*?)\[\/abbr\]#si","<abbr>$1</abbr>",$message);
		// Citation
		$message = preg_replace("#\[cite\](.*?)\[\/cite\]#si","<cite>$1</cite>",$message);
		// Preformatted stuff
		$message = preg_replace("#\[pre\](.*?)\[\/pre\]#si","<pre>$1</pre>",$message);
		// The You Tag
		$message = str_replace("[you/]","{$imp->user['username']}",$message);
		// Bidrectional Override
		$message = preg_replace("#\[dir=(.*?)\](.*?)\[\/dir\]#si","<bdo dir='$1'>$2</bdo>",$message);
		// Possible Spoiler
		$message = preg_replace("#\[spoiler\](.*?)\[/spoiler\]#si",'
		<div style="margin:20px; margin-top:5px"><div class="quotetitle">
		<input class="button2 btnlite" type="button" value="View Spoiler" 
		style="text-align:center;width:115px;margin:0px;padding:0px;" 
		onclick="if (this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display != \'\') { 
		this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display = \'\';      
		this.innerText = \'\'; this.value = \'Hide Spoiler\'; } 
		else { this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display = \'none\'; 
		this.innerText = \'\'; this.value = \'View Spoiler\'; }" /></div><div class="quotecontent"><div style="display: none;">$1</div></div></div>',$message);
		// A special BBcode
		$message = preg_replace('#\(@(.*?)\)#iUs',"<a href='./view.php?user=$1'>$1</a>",$message);
		/*
		Block for stripping unclosed BBcode
		*/
		// Bold
		$message = str_replace("[b]","",$message);
		// Italic
		$message = str_replace("[i]","",$message);
		// Colour
		$message = preg_replace ('#\[color=(.+)\]#iUs',"",$message);
		// Quote
		$message = str_replace("[quote]","",$message);
		// Citation
		$message = str_replace("[cite]","",$message);
		// Spoiler
		$message = str_replace("[spoiler]","",$message);
		// You tag variant 1
		$message = str_replace("[you","",$message);
		// Bidirectional Override
		$message = preg_replace ('#\[dir=(.+)\]#iUs',"",$message);
	}
	if($settings['smilies']==1)
	{
		// Smiling
		$message = str_replace(':)',"<img title=':)' src='./images/smilies/smile.png' alt=':)' />",$message);
		// Big Smile
		$message = str_replace(':D',"<img title=':D' src='./images/smilies/biggrin.png' alt=':D' />",$message);
		// Sad Smilie
		$message = str_replace(':(',"<img title=':(' src='./images/smilies/frown.png' alt=':(' />",$message);
		// Tongue Smilie
		$message = str_replace(':P',"<img title=':P' src='./images/smilies/tongue.png' alt=':P' />",$message);
		// Wink
		$message = str_replace(';)',"<img title=';)' src='./images/smilies/wink.png' alt=';)' />",$message);
	}
	return $message;
}
// This is for parsing the custom page blocks.
function page_parser($pblock)
{
	// Remove the custom page BBcode.
	$pblock = preg_replace ("#\[page=custom\](.*)\[\/page\]#iUs","$1",$pblock);
	// Regex for checking if theres any sidebar BBcode.
	$check = preg_match("#\[sidebar=left\](.*)\[\/sidebar\]#iUs",$pblock,$custom);
	$check2 = preg_match("#\[sidebar=right\](.*)\[\/sidebar\]#iUs",$pblock,$custom2);
	// Set $page as an array.
	$page = array();
	// Actual conditional to determine whether theres any sidebar BBcode.
	if($check || $check2)
	{
		// Since theres atleast one sidebar.
		$page['sidebar'] = true;
		// Is it this sidebar which passed the conditional?
		if($check)
		{
			$data = $custom['0'];
			// Remove the sidebar BBcode.
			$data = preg_replace ("#\[sidebar=left\](.*)\[\/sidebar\]#iUs","$1",$data);
			// Check if there are any actual rows in this sidebar.
			$check = preg_match("#\[row\](.*)\[\/row\]#iUs",$data,$custom);
			// The actual conditional.
			if($check)
			{
				// Start building the sidebar table.
				$table .= "<div class='sidebar'>
				<table border='1' class='tborder' cellspacing='0'>";
				$check = preg_match("#\[head\](.*)\[\/head\]#iUs",$data,$custom);
				if(!$check)
				{
					$table .= "<tr><th>Sidebar</th></tr>";
				}
				// Parse this first for security reasons.
				$settings['bbcode'] = 1;
				$settings['smilies'] = 1;
				$settings['allowhtml'] = 0;
				$data = parser($settings,$data);
				// Replace the table heads too.
				$data = preg_replace("#\[head\](.*)\[\/head\]#iUs","<tr><th class='thead'>$1</th></tr>",$data);
				// Replace the row BBcode with proper table rows.
				$table .= preg_replace ("#\[row\](.*)\[\/row\]#iUs","<tr class='trow'><td>$1</td></tr>",$data);
				$table .= "</table>
				</div>";
				$page['sidebar_left'] = $table;
				// Fix to stop this table leaking into the next conditional.
				unset($table);
			}
			else
			{
				$page['sidebar_left'] = false;
			}
		}
		else
		{
			$page['sidebar_left'] = false;
		}
		// Or this one?
		if($check2)
		{
			$data2 = $custom2['0'];
			// Remove the sidebar BBcode.
			$data2 = preg_replace ("#\[sidebar=right\](.*)\[\/sidebar\]#iUs","$1",$data2);
			// Check if there are any actual rows in this sidebar.
			$check = preg_match("#\[row\](.*)\[\/row\]#iUs",$data2,$custom);
			// The actual conditional.
			if($check)
			{
				// Start building the sidebar table.
				$table .= "<div class='sidebar'>
				<table border='1' class='tborder' cellspacing='0'>";
				$check = preg_match("#\[head\](.*)\[\/head\]#iUs",$data2,$custom);
				if(!$check)
				{
					$table .= "<tr><th>Sidebar</th></tr>";
				}
				// Parse this first for security reasons.
				$settings['bbcode'] = 1;
				$settings['smilies'] = 1;
				$settings['allowhtml'] = 0;
				$data2 = parser($settings,$data2);
				// Replace the table heads too.
				$data2 = preg_replace("#\[head\](.*)\[\/head\]#iUs","<tr><th class='thead'>$1</th></tr>",$data2);
				// Replace the row BBcode with proper table rows.
				$table .= preg_replace("#\[row\](.*)\[\/row\]#iUs","<tr class='trow'><td>$1</td></tr>",$data2);
				$table .= "</table>
				</div>";
				$page['sidebar_right'] = $table;
			}
			else
			{
				$page['sidebar_right'] = false;
			}
		}
		else
		{
			$page['sidebar_right'] = false;
		}
		// Can be altered if the sidebars are mssing vital info.
		if(!$page['sidebar_left'] && !$page['sidebar_right'])
		{
			$page['sidebar'] = false;
		}
	}
	else
	{
		// There aren't any sidebar BBcode.
		$page['sidebar'] = false;
	}
	// Check for the big content tags.
	$check = preg_match("#\[content=(.*)\](.*)\[\/content\]#iUs",$pblock,$custom);
	if($check)
	{
		$page['comments'] = false; 
		$check = preg_match("#\[content=comments\](.*)\[\/content\]#iUs",$pblock,$custom);
		if($check)
		{
			$data = preg_replace("#\[content=comments\](.*)\[\/content\]#iUs","$1",$pblock);
			$page['comments'] = true;
		}
		$page['pagelist'] = false; 
		$check2 = preg_match("#\[content=pagelist\](.*)\[\/content\]#iUs",$pblock,$custom);
		if($check2)
		{
			$page['pagelist'] = true;
			$page['pagelist_cutoff_bool'] = false;
		}
		$check3 = preg_match("#\[content=pagelist cutoff=(.*)\](.*)\[\/content\]#iUs",$pblock,$fetch);
		if($check3)
		{
			$cus = $fetch['0'];
			$data = preg_replace("#\[content=pagelist cutoff=(.*)\](.*)\[\/content\]#iUs","$1",$cus);
			$page['pagelist'] = true;
			$page['pagelist_cutoff_bool'] = true;
			$page['pagelist_cutoff'] = $data;
		}
		$page['rmcontent'] = false; 
		$check4 = preg_match("#\[content=rmcontent\](.*)\[\/content\]#iUs",$pblock,$custom);
		if($check4)
		{
			$page['rmcontent'] = true;
		}
	}
	return $page;
}
?>