<?php
/*
MillionCMS Project
    
    Name: Installer Functions
    Description: General Functions for the Installer

    Author: Polarbear541

    Copyright © 2010 Polarbear541 and InfinityCMS Group
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

function error($message)
{
	echo "<div id='error'><p><em>Error: {$message}</em></p></div><br />";
}

function random_str($length)
{
	$chars="aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ1234567890";
	$len=strlen($chars);
	$i=1;
	
	while ($i <= $length)
	{
		$rand=rand(1,$len);
		$str.=$chars[$rand-1];
		$i++;
	}
	
	return $str; 
}
function sql_connect()
{
	require('../inc/config.php');
	$database = $config['db'];
	mysql_connect($database['host'],$database['uname'],$database['pass'])or error("Cannot connect to host".mysql_error());
	mysql_select_db($database['name'])or error("Cannot connect to DB");
	define("TABLE_PREFIX",$config['table_prefix']);
}
function redirect($url, $seconds=0) 
{
	echo "<br /><meta http-equiv='refresh' content='{$seconds}; url={$url}'>"; 
	return true;
}
?>