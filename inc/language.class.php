<?php
/*
ImprovCMS Project
    
    Name: Language Class
    Description: This file contains data for the Lanauge Ssystem.

    Author: Kyuubi

    Copyright (c) 2010 Kyuubi and Improv Software Group
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

// Stops unauthorised users accessing this...
if(!defined("IN_IMPROV"))
{
	die("Access Denied");
}

class language
{
	function read($string)
	{
		$html = "
		<div align='center'>
				<table border='1'>
					<tr>
						<td>Error</td>
					</tr>
					<tr>
						<td>{$string}</td>
				</tr>
				</table>
			</div>
		";
		echo $html;
	}
	
	function edit()
	{
	
	}
	
	function delete()
	{
	
	}
}
?>