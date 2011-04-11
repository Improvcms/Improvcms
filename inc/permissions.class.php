<?php
/*
	MillionCMS Project
    
	Name: The Permissions Class
	Description: The class that handles permissions.
	Last Update: 13 October 2010
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

class permissions
{
	public $perms;
	function __construct($gid)
	{
		global $db;
		$groupfile = ROOT."/cache/groups/{$gid}.php";
		$expiry = get_cache('cacheexpiry');
		if(file_exists($groupfile)&&(time()-$expiry<filemtime($groupfile))) 
		{
			include($groupfile);
			$perms = $group['permissions'];
		}
		else
		{
			$groups = $db->query("SELECT * FROM ".TABLE_PREFIX."usergroups WHERE gid='{$gid}'");
			$permissions = $db->fetch_array($groups);
			$perms = $permissions['permissions'];
			$content .= "<?php\n";
			foreach($permissions as $key => $value)
			{
				$value = str_replace("'","/'",$value);
				$content .= "\$group['{$key}'] = '{$value}';\n";
			}
			$content .= '?>';
			// Open the file in write mode.
			$open = fopen($groupfile,'w');
			// Write to the file.
			fwrite($open,"$content\n");
			// Don't need it open anymore.
			fclose($open);
		}
		$this->perms = unserialize($perms);
	}
	function check_perms($needed)
	{
		global $mcms;
		if($this->perms[$needed]==1)
		{
			return true;
		}
		elseif($this->super_admin($mcms->user['uid']))
		{
			return true;
		}
		return false;
	}
	function override_perms($override)
	{
		$this->perms[$override] = 1;
		return true;
	}
	function set_permission($data,$name,$bool,$type = 'usergroup')
	{
		global $db;
		if($type=='usergroup')
		{
			$permissions = $this->fetch_perms('usergroup',$data);
			$permissions[$name] = $bool;
			$perms = serialize($permissions);
			$db->query("UPDATE ".TABLE_PREFIX."usergroups SET permissions='{$perms}' WHERE gid='{$data}'");
			return true;
		}
		return false;
	}
	function write_permissions($perms,$name,$type = 'usergroup')
	{
		global $db;
		if($type=='usergroup')
		{
			$perms = serialize($perms);
			$db->query("UPDATE ".TABLE_PREFIX."usergroups SET permissions='{$perms}' WHERE gid='{$name}'");
			return true;
		}
		return false;
	}
	function fetch_perms($type,$name)
	{
		global $db;
		if($type=='usergroup')
		{
			$name = intval($name);
			$query = $db->query("SELECT permissions FROM ".TABLE_PREFIX."usergroups WHERE gid='{$name}'");
			$perms = $db->fetch_array($query);
			$perms = $perms['permissions'];
			$perms = unserialize($perms);
			return $perms;
		}
		return false;
	}
	function page_check($access,$pid)
	{
		global $db, $mcms;
		$query = $db->query("SELECT author FROM ".TABLE_PREFIX."pages WHERE pid='{$pid}'");
		$page = $db->fetch_array($query);
		$author = $page['author'];
		if($access=='edit')
		{
			if($this->perms["can_edit_own_pages"]=='1' && $author==$mcms->user['uid'])
			{
				return true;
			}
			if($page['status']!='3')
			{
				if($this->perms['can_edit_all_pages']=='1')
				{
					return true;
				}
			}
			else
			{
				if($this->perms['can_edit_all_staff_pages']=='1')
				{
					return true;
				}
			}
			return false;
		}
		elseif($access=='delete')
		{
			if($this->perms["can_delete_own_pages"]=='1' && $author==$mcms->user['uid'])
			{
				return true;
			}
			if($page['status']!='3')
			{
				if($this->perms['can_delete_all_pages']=='1')
				{
					return true;
				}
			}
			else
			{
				if($this->perms['can_delete_all_staff_pages']=='1')
				{
					return true;
				}
			}
			return false;
		}
		return false;
	}
	// Similair to regular check except, it can be run at any time and for any user.
	function cross_check($permission,$uid)
	{
		global $db;
		if($this->super_admin($uid))
		{
			return true;
		}
		$userfile = ROOT."/cache/users/".$uid.".php";
		$expiry = get_cache('cacheexpiry');
		if(file_exists($userfile)&&(time()-$expiry<filemtime($userfile))) 
		{
			include($userfile);
			$muser['permissions'] = $user['permissions'];
			$groupfile = ROOT."/cache/groups/{$user['gid']}.php";
			if(file_exists($groupfile)&&(time()-$expiry<filemtime($groupfile))) 
			{
				include($groupfile);
				$mgroup = $group;
			}
		}
		else
		{
			$user = $db->query("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='{$uid}'");
			$muser = $db->fetch_array($user);
			$content .= "<?php\n";
			if(!is_array($muser))
			{
				$muser = array("username"=>"Pixie");
			}
			foreach($muser as $key => $value)
			{
				$muser[$key] = $value;
				$value = str_replace("'","/'",$value);
				$content .= "\$user['{$key}'] = '{$value}';\n";
			}
			$content .= '?>';
			// Open the file in write mode.
			$open = fopen($userfile,'w');
			// Write to the file.
			fwrite($open,"$content\n");
			// Don't need it open anymore.
			fclose($open);
			unset($content);
			unset($open);
			unset($user);
			$groupfile = ROOT."/cache/groups/{$muser['gid']}.php";
			$group = $db->query("SELECT * FROM ".TABLE_PREFIX."usergroups WHERE gid='{$muser['gid']}'");
			$mgroup = $db->fetch_array($group);
			$content .= "<?php\n";
			if(!is_array($mgroup))
			{
				$mgroup = array("name"=>"Unknown");
			}
			foreach($mgroup as $key => $value)
			{
				$mgroup[$key] = $value;
				$value = str_replace("'","/'",$value);
				$content .= "\$group['{$key}'] = '{$value}';\n";
			}
			$content .= '?>';
			// Open the file in write mode.
			$open = fopen($groupfile,'w');
			// Write to the file.
			fwrite($open,"$content\n");
			// Don't need it open anymore.
			fclose($open);
		}
		$perms = $this->process_perms(unserialize($muser['permissions']),unserialize($mgroup['permissions']));
		if($perms[$permission]==1)
		{
			return true;
		}
		return false;
	}
	// So many permissions to process..
	function process_perms($user,$usergroup)
	{
		global $db;
		if(!is_array($user))
		{
			$user = array();
		}
		if(!is_array($usergroup))
		{
			$usergroup = array();
		}
		foreach($usergroup as $key => $value)
		{
			if($value==1)
			{
				if($user[$key]==1 || $user[$key]==2 || !isset($user[$key]))
				{
					$perms[$key] = 1;
				}
				else
				{
					$perms[$key] = 0;
				}
			}
			else
			{
				if($user[$key]==1 || $user[$key]==0 || !isset($user[$key]))
				{
					$perms[$key] = 0;
				}
				else
				{
					$perms[$key] = 1;
				}
			}
		}
		// Bug fixer if a permission exists in user but, not in group.
		foreach($user as $key => $value)
		{
			if(!isset($usergroup[$key]))
			{
				if($usergroup[$key]==1)
				{
					if($user[$key]==1 || $user[$key]==2 || !isset($user[$key]))
					{
						$perms[$key] = 1;
					}
					else
					{
						$perms[$key] = 0;
					}
				}
				else
				{
					if($user[$key]==1 || $user[$key]==0 || !isset($user[$key]))
					{
						$perms[$key] = 0;
					}
					else
					{
						$perms[$key] = 1;
					}
				}
			}
		}
		return $perms;
	}
	// This is to check if a user is the super administrator.
	function super_admin($uid)
	{
		global $mcms, $db;
		if($uid==$mcms->config['super_admins'])
		{
			return true;
		}
		$query = $db->query("SELECT superadmin FROM ".TABLE_PREFIX."users WHERE uid='{$uid}'");
		$count = $db->num($query);
		if($count=='0')
		{
			return false;
		}
		$result = $db->fetch_array($query);
		if($result['superadmin']==1)
		{
			return true;
		}
		return false;
	}
	function founder($uid)
	{
		global $mcms;
		if($uid==$mcms->config['super_admins'])
		{
			return true;
		}
		return false;
	}
	function level_check($id,$targetid,$mode = 'uid')
	{
		global $db;
		$id = intval($id);
		$targetid = intval($targetid);
		if($mode=='uid')
		{
			if($this->super_admin($id))
			{
				if($this->founder($id))
				{
					return true; // Founder can do anything.
				}
				elseif($this->super_admin($targetid))
				{
					return false; // Can't touch other superadmins!
				}
			}
			elseif($this->super_admin($id))
			{
				return false; // Superadmins are top level.
			}
			if(!$this->cross_check('can_access_admincp',$targetid))
			{
				return true;
			}
			$group1 = getgroup($id);
			$group2 = getgroup($targetid);
		}
		elseif($mode=='gid')
		{
			$query = $db->query("SELECT adminlevel FROM ".TABLE_PREFIX."usergroups WHERE gid={$id}") or die("An error has occured: ".mysql_error());
			if(@$db->num($query)==0)
			{
				return false;
			}
			$group1 = $db->fetch_array($query);
			$query2 = $db->query("SELECT adminlevel FROM ".TABLE_PREFIX."usergroups WHERE gid={$targetid}");
			if(@$db->num($query2)==0)
			{
				return false;
			}
			$group2 = $db->fetch_array($query2);
		}
		else
		{
			return false;
		}
		$grouplevel = intval($group1['adminlevel']);
		$grouplevel2 = intval($group2['adminlevel']);
		if($grouplevel>$grouplevel2)
		{
			return true;
		}
		return false;
	}
}
?>