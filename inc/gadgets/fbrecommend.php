<?php
/*
MillionCMS Gadget
    
    Name: FB Recommendations
    Description: This gadget shows recommendations for pages 
	personalized for users by FB.

    Author: Azareal

    Copyright � 2010 Azareal
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

// What is it?
function fbrecommend_info()
{
	return array(
	"name" => "FBRecommend",
	"description" => "A gadget which shows personalized recommendations for pages, generated by FB"
	);
}
function fbrecommend_execute()
{
	global $mcms;
	$block = '<table width="180"><tr><td>
	<iframe src="http://www.facebook.com/plugins/recommendations.php?site='.urlencode($mcms->settings['siteurl']).'&amp;width=180&amp;height=300&amp;header=false&amp;colorscheme=light&amp;font=arial&amp;border_color=cyan" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:180px; height:300px;" allowTransparency="true">
	</iframe></td></tr></table>';
	return $block;
}
?>