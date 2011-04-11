<?php
/*
MillionCMS Gadget
    
    Name: FB Comments
    Description: A comments system powered by FB.

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

// What is it?
function fbcomments_info()
{
	return array(
	"name" => "FBComments",
	"description" => "Comment system powered by FB where you make comments with your FB account"
	);
}
function fbcomments_execute()
{
	global $mcms, $loc;
	if($loc=='view.php')
	{
		global $page;
		$ext= "?title={$page['title']}";
	}
	$block = '<table width="180"><tr><td>
	<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#appId=APP_ID&amp;xfbml=1"></script>
	<fb:comments xid="'.urlencode($mcms->settings['siteurl'].'/'.$loc.$ext).'" numposts="10" width="425" publish_feed="true"></fb:comments></td></tr></table>';
	return $block;
}
?>