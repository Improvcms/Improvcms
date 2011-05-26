<?php
/*
	MillionCMS Project
    
	Name: Gadgets Class
	Description: The class for handling the gadgets.
	Last Update: 02 November 2010
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

class gadgets
{
	// Retrieve all of the gadgets.
	function getgadgets()
	{
		$gadgets = array();
		$path = '../../inc/gadgets';
		if ($handle = opendir($path))
		{
			while (false!==($file=readdir($handle))) 
			{
				$fileinfo = pathinfo($path."/{$file}");
				if($fileinfo['extension']=='php')
				{
					$file = str_replace('.php','',$file);
					$gadgets[] = "{$file}";
				}
				unset($file);
				unset($fileinfo);
			}
			closedir($handle);
		}
		else
		{
			return false;
		}
		return $gadgets;
	}
	// Retrive the information
	function get_info($gadget)
	{
		require_once(ROOT."/inc/gadgets/{$gadget}.php");
		if(function_exists("{$gadget}_info"))
		{
			$information = call_user_func("{$gadget}_info");
		}
		if(empty($information))
		{
			$information['name'] = $gadget;
			$information['description'] = 'No description defined';
		}
		return $information;
	}
	// Checks if a gadget is actually active.
	function is_active($gadget)
	{
		$cache = get_cache('gadgets');
		$cache = unserialize($cache);
		if(!empty($cache['active'][$gadget]))
		{
			return true;
		}
		return false;
	}
	// Check if a gadget actually exists.
	function checkgadget($name)
	{
		if(is_readable("./inc/gadgets/{$name}.php"))
		{
			return true;
		}
		elseif(is_readable("./gadgets/{$name}.php"))
		{
			return true;
		}
		elseif(is_readable("../../inc/gadgets/{$name}.php"))
		{
			return true;
		}
		return false;
	}
	function retrieve_sidebar($position)
	{
		global $db;
		$result = get_cache('gadgets');
		$result = unserialize($result);
		// Only want to loop through things in the active cache to help save resources.
		$active = $result['active'];
		if(!is_array($active))
		{
			$active = array();
		}
		foreach($active as $key => $value)
		{
			if($value==1 && $result[$key]['position']==$position && !empty($result['active'][$key]))
			{
				if($this->checkgadget($key))
				{
					require_once(ROOT."/inc/gadgets/{$key}.php");
					if(function_exists("{$key}_execute"))
					{
						$check_function = "{$key}_check";
						if(function_exists("{$key}_check"))
						{
							if($check_function())
							{
								$sidebar .= call_user_func("{$key}_execute");
							}
						}
						else
						{
							$sidebar .= call_user_func("{$key}_execute");
						}
					}
				}
			}
			unset($check_function);
			unset($value);
			unset($key);
		}
		if(empty($sidebar))
		{
			$sidebar = "&nbsp;";
		}
		return $sidebar;
	}
}
?>