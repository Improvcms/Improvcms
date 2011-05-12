<?php
/*
ImprovCMS Project
    
    Name: Error Class
    Description: This file contains data for the Error Handler.

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
if(!defined("IN_MILLION"))
{
	die("Access Denied");
}

class error
{
	function internal($errcode)
	{
		switch($errcode)
		{
			case 40:
			$html = "
			<div align='center'>
				<table border='1'>
					<tr>
						<td>ImprovCMS Error</td>
					</tr>
					<tr>
						<td>Sorry, something went wrong when trying to perform the requested action.<br /><br />Error Code 40: This software has not been installed, browse to the /install/ directory to begin the installation</td>
				</tr>
				</table>
			</div>";
			echo $html;
			
			case 41:
			$html = "
			<div align='center'>
				<table border='1'>
					<tr>
						<td>ImprovCMS Error</td>
					</tr>
					<tr>
						<td>Sorry, something went wrong when trying to perform the requested action.<br /><br />Error Code 41: Your files are newer than the installed version, please run the upgrader.</td>
					</tr>
				</table>
			</div>";
			echo $html;
			
			case 42:
			$html = "
			<div align='center'>
				<table border='1'>
					<tr>
						<td>ImprovCMS Error</td>
					</tr>
					<tr>
						<td>Sorry, something went wrong when trying to perform the requested action.<br /><br />Error Code 42: There is no valid SQL extension installed or compiled with PHP. Contact your host to get MySQL enabled.</td>
					</tr>
				</table>
			</div>
			";
			echo $html;
			
			default:
			$html = "
			<div align='center'>
				<table border='1'>
					<tr>
						<td>ImprovCMS Error</td>
					</tr>
					<tr>
						<td>Sorry, something went wrong when trying to perform the requested action.<br /><br />An unknown error has occurred: please post in the Official Support forums for further assistance.</td>
					</tr>
				</table>
			</div>
			";
		}
	}
}
?>