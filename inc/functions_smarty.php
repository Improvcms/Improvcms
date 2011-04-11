<?php
/*
	MillionCMS Project
    
	Name: Smarty Functions
	Description: A file containing functions for smarty.
	Last Update: 03 December 2010

	Author: Azareal (some content from Smarty)


	Copyright Smarty, Azareal and the MillionCMS Group (C) 2010


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
// Function for getting the template
function db_get_template ($name,&$template,$smarty_obj)
{
	global $templates;
	// Calling the template.
	if(defined('IN_ADMIN'))
	{
		$template = $templates->fetch_admin($name);
	}
	else
	{
		$template = $templates->fetch($name);
	}
	// return true on success, false to generate failure notification
	return true;
}

function db_get_timestamp($name,&$timestamp,$smarty_obj)
{
	// Get the time.
	$timestamp = time(); // this example will always recompile!
	// Time generation has succeeded.
	return true;
}

function db_get_secure($name,$smarty_obj)
{
	// Templates are secure.
	return true;
}

function db_get_trusted($name,$smarty_obj)
{
	// Not used in this resource type.
}
?>