<?php
/*
MillionCMS Project
    
    Name: Core Class
    Description: Where quite afew core functions are performed.
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

// Stops unauthorised users accessing this...
if(!defined("IN_MILLION"))
{
	die("Access Denied");
}

class core
{
	public $settings;
	public $cache = array();
	public $user;
	public $usergroup;
	// Store the configuration data here.
	public $config;
	public $version = "003";
	public $fversion = "Alpha 3 Dev";
	// Constructor which starts core up.
	function __construct()
	{
		global $db, $config;
		$this->config = $config;
		$query1 = $db->query("SELECT * FROM ".TABLE_PREFIX."cache");
		$loop1 = $db->loop2array($query1);
		foreach($loop1 as $row)
		{
			$cache[$row['name']] = $row['content'];
		}
		if(!isset($cache['cacheexpiry']))
		{
			$cache['cacheexpiry'] = 5*60;
		}
		$settingcache = ROOT."/cache/settings.php";
		if(file_exists($settingcache)&&(time()-$cache['cacheexpiry']<filemtime($settingcache))) 
		{
			include_once(ROOT."/cache/settings.php");
		}
		else
		{
			$settings = $this->cache_settings();
		}
		$this->settings = $settings;
		$this->cache = $cache;
	}
	function cache_settings()
	{
		global $db;
		$query = $db->query("SELECT * FROM ".TABLE_PREFIX."settings");
		$loop = $db->loop2array($query);
		$content .= "<?php
/*
MillionCMS Project
		
	Name: Settings Cache
	Description: This is a cache of all of the current settings.
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
*/\n";
		foreach($loop as $row)
		{
			$settings[$row['name']] = $row['content'];
			$content .= "\$settings['{$row['name']}'] = '{$row['content']}';\n";
			unset($row);
		}
		$content .= "?>";
		// Want to save it as a PHP so random people can't view it.
		$settingsfile = ROOT."/cache/settings.php";
		// Open the file in write mode.
		$open = fopen($settingsfile,'w');
		// Write to the file.
		fwrite($open,"$content\n");
		// Don't need it open anymore.
		fclose($open);
		return $settings;
	}
	// Assigns the user variable with the needed user data 
	// aswell, as loading up related items.
	function assign_user($user)
	{
		global $db;
		$this->user = $user;
		unset($user);
		$ugroup = $db->query("SELECT * FROM ".TABLE_PREFIX."usergroups WHERE gid='{$this->user['gid']}'");
		// For security reasons, password will be unset
		unset($this->user['password']);
		$usergroup = $db->fetch_array($ugroup);
		$this->usergroup = $usergroup;
	}
}
?>
