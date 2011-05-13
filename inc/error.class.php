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
			break;
			
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
			break;
			
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
			break;
			
			case 43:
			$html = "
			<div align='center'>
				<table border='1'>
					<tr>
						<td>ImprovCMS Error</td>
					</tr>
					<tr>
						<td>Sorry, something went wrong when trying to perform the requested action.<br /><br />Error Code 43: The file config.php does not have the required write permissions. Please CHMOD this file to 666.</td>
					</tr>
				</table>
			</div>
			";
			echo $html;
			break;
			
			case 44:
			$html = "
			<div align='center'>
				<table border='1'>
					<tr>
						<td>ImprovCMS Error</td>
					</tr>
					<tr>
						<td>Sorry, something went wrong when trying to perform the requested action.<br /><br />Error Code 44: You are not accessing this file in the proper manner. Please go back and try to access this page properly.</td>
					</tr>
				</table>
			</div>
			";
			echo $html;
			break;
			
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
			break;
		}
	}
	
	function perms($errcode)
	{
		switch($errcode)
		{
			case 20:
			$html = "
			<div align='center'>
				<table border='1'>
					<tr>
						<td>Permissions Error</td>
					</tr>
					<tr>
						<td>Sorry, you are not an administrator and therefore cannot access the Administrator Control Panel.</td>
					</tr>
				</table>
			</div>
			";
			break;
		}
	}
	
	function database($errcode)
	{
		switch($errcode)
		{
			case 60:
			$html = "
			<div align='center'>
				<table border='1'>
					<tr>
						<td>Database Error</td>
					</tr>
					<tr>
						<td>A database error has occured and the software has stopped.<br /><br />Error Code 60: The MySQL server is down or not responding. Please contact your host.</td>
					</tr>
				</table>
			</div>
			";
			break;
			
			case 61:
			$html = "
			<div align='center'>
				<table border='1'>
					<tr>
						<td>Database Error</td>
					</tr>
					<tr>
						<td>A database error has occured and the software has stopped.<br /><br />Error Code 61: ImprovCMS cannot connect to your database, either due to a problem in ./inc/config.php or incorrect permissions on the database. Please correct these, and try again.</td>
					</tr>
				</table>
			</div>
			";
			break;
			
			case 63:
			$my_err = mysql_error();
			$html = "
			<div align='center'>
				<table border='1'>
					<tr>
						<td>Database Error</td>
					</tr>
					<tr>
						<td>A database error has occured and the software has stopped.<br /><br />Error Code 63: {$my_err}</td>
					</tr>
				</table>
			</div>
			";
			break;
			
			default:
			$html = "
			<div align='center'>
				<table border='1'>
					<tr>
						<td>Database Error</td>
					</tr>
					<tr>
						<td>An unknown error has occurred in your database. This could be a result of database corruption,<br />or an unexpected condition was met. Please post a thread in our official support forums for further assistance.</td>
					</tr>
				</table>
			</div>
			";
			break;
		}
	}
}
?>