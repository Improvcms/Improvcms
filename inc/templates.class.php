<?php
/*
MillionCMS Project

	Name: Templates Class
	Description: This class deals with fetching templates.
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
if(!defined("IN_MILLION"))
{
	die("Access Denied");
}
class templates
{
	public $templates;
	private $admintemplates;
	function __construct()
	{
		global $db;
		if(!is_object($db))
		{
			global $config;
			$db = new database($config);
		}
		$templates = $db->query("SELECT * FROM ".TABLE_PREFIX."templates");
		// Added to make array loopable due to major error.
		$result = $db->loop2array($templates);
		unset($templates);
		foreach($result as $row)
		{
			$template[$row['name']] = $row['content'];
		}
		$this->templates = $template;
		// Only run this in AdminCP.
		if(defined("IN_ADMIN"))
		{
			global $mcms;
			if(empty($mcms->user['admin_style']))
			{
				$is_default = $db->query("SELECT setid FROM ".TABLE_PREFIX."admin_styles WHERE is_default='1' LIMIT 1");
				$isdresult = $db->fetch_array($is_default);
				$defaulttemp = $isdresult['setid'];
				$atemplates = $db->query("SELECT * FROM ".TABLE_PREFIX."admin_templates WHERE templateset='{$defaulttemp}'");
			}
			else
			{
				$is_default = $db->query("SELECT setid FROM ".TABLE_PREFIX."admin_styles WHERE is_default='1' LIMIT 1");
				$isdresult = $db->fetch_array($is_default);
				$defaulttemp = $isdresult['setid'];
				$atemplates2 = $db->query("SELECT * FROM ".TABLE_PREFIX."admin_templates WHERE templateset='{$defaulttemp}'");
				$atemplates = $db->query("SELECT * FROM ".TABLE_PREFIX."admin_templates WHERE templateset='{$mcms->user['admin_style']}'");
			}
			// Change the array into something that is loopable.
			$aresult = $db->loop2array($atemplates);
			unset($atemplates);
			if(!empty($atemplates2))
			{
				$aresult2 = $db->loop2array($atemplates2);
				unset($atemplates2);
				foreach($aresult2 as $arow)
				{
					$atemplate[$arow['name']] = $arow['content'];
				}
			}
			foreach($aresult as $arow)
			{
				unset($atemplate[$arow['name']]);
				$atemplate[$arow['name']] = $arow['content'];
			}
			$this->admintemplates = $atemplate;
		}
	}
	function fetch($template = null)
	{
		if ($template==null)
		{
			trigger_error("You have not specified which template to fetch",E_USER_WARNING);
			return false;
		}
		if(isset($this->templates[$template]))
		{
			return $this->templates[$template];
		}
		else
		{
			trigger_error("Invalid Template!",E_USER_WARNING);
			return false;
		}
	}
	function fetch_admin($template = null)
	{
		if ($template==null)
		{
			trigger_error("You have not specified which template to fetch",E_USER_WARNING);
			return false;
		}
		if(isset($this->admintemplates[$template]))
		{
			return $this->admintemplates[$template];
		}
		else
		{
			trigger_error("Invalid Template!",E_USER_WARNING);
			return false;
		}
	}
	function eval2($template)
	{
		global $mcms;
		$template = addslashes($template);
		eval("\$template = \"$template\";");
		return $template;
	}
	// Creating a new template
	function add($name,$content)
	{
		global $db;
		$test = $db->query("SELECT * FROM ".TABLE_PREFIX."templates WHERE name='{$name}'");
		$count = $db->num($test);
		if($count!=0)
		{
			trigger_error("That template already exists",E_USER_WARNING);
			return false;
		}
		$db->query("INSERT INTO ".TABLE_PREFIX."templates (name,content) VALUES ('{$name}','{$content}') ");
		$this->templates[$name] = $content;
		return true;
	}
	// Removing/deleting an existing template
	function remove($name,$templateset = null)
	{
		global $db;
		$test = $db->query("SELECT * FROM templates WHERE name='{$name}'");
		$count = $db->num($test);
		if(empty($count))
		{
			trigger_error("This template does not exist",E_USER_WARNING);
			return false;
		}
		$db->query("DELETE FROM ".TABLE_PREFIX."templates WHERE name='{$name}'");
		unset($this->templates[$name]);
		return true;
	}
	// Updating the contents of an existing template
	function update($name,$content)
	{
		global $db;
		$test = $db->query("SELECT * FROM templates WHERE name='{$name}'");
		$count = $db->num($test);
		if(empty($count))
		{
			trigger_error("This template does not exist",E_USER_WARNING);
			return false;
		}
		$db->query("UPDATE ".TABLE_PREFIX."templates SET content='{$content}' WHERE name='{$name}'");
		$this->templates[$name] = $content;
		return true;
	}
}
?>