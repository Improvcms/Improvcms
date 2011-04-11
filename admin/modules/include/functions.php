<?php
/*
MillionCMS Project
    
	Name: Admin Functions
	Description: The file which supplies functions for the admincp.

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

function decipher_logs($logs)
{
	$details = unserialize($logs['detail']);
	if($logs['action']=='update')
	{
		switch ($logs['itable'])
		{
			case "users":
				if($details['where']=='uid')
				{
					if($details['field']=='superadmin')
					{
						if($details['post']==1)
						{
							$action = "Granted";
							$pro = "to";
						}
						else
						{
							$action = "Revoked";
							$pro = "from";
						}
						$field = " {$details['field']} status {$pro} ".getname($details['record']);
					}
					else
					{
						$action = "Changed the";
						$field = " {$details['field']}";
						$record = " on ".getname($details['record'])."'s account from";
						$diff = " {$details['prev']} to {$details['post']}";
					}
					break;
				}
			case "usergroups":
				if($details['field']=='permissions')
				{
					$group = getgroup($details['record']);
					$action = "Updated the permissions for the {$group['name']} usergroup";
					break;
				}
			case "cache":
				if($details['record']=='admin_notes')
				{
					$action = "Updated the admin notes"; 
					break;
				}
				elseif($details['record']=='lastadminlogins')
				{
					// Don't want this spamming up adminlogs.
					break;
				}
				else
				{
					$action = 'Updated a cache';
				}
			default:
				$action = 'Changed the';
				$field = " {$details['field']} field";
				if(isset($details['record']))
				{
					if(isset($details['where']))
					{
						$where = " (on {$details['where']} column)";
					}
					$record = " on the {$details['record']} record{$where}";
				}
				$diff = " from {$details['prev']} to {$details['post']}";
				$table = " on the {$logs['itable']} table";
			break;
		}
	}
	elseif($logs['action']=='reverse')
	{
		$action = 'Reversed the action made by '.getname($details['uid']);
	}
	$string = "{$action}{$field}{$record}{$diff}{$table}.";
	return $string;
}
// Reverse update queries made by administrators.
function reverse_action($logid)
{
	global $db, $loc, $mcms;
	$query = $db->query("SELECT * FROM ".TABLE_PREFIX."admin_logs WHERE logid='{$logid}'");
	$result = $db->fetch_array($query);
	$logs = unserialize($result['detail']);
	$logs['uid'] = $result['uid'];
	// Execute a query.
	$db->new_update($result['itable'],$logs['where'].'='.$logs['post'],$logs['field'].'='.$logs['prev'],false);
	$time = time();
	$logs = serialize($logs);
	// Log it!
	$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','{$loc}','{$mcms->user['uid']}','{$_SERVER['REMOTE_ADDR']}','reverse','{$result['itable']}','{$logs}') ");
	// Return true to tell the upstream script our work here is done.
}
function clearcompiled()
{
	$path = ROOT.'/cache/compile';
	if($handle = opendir($path))
	{
		while(false!==($file=readdir($handle))) 
		{
			$fileinfo = pathinfo($path."/{$file}");
			if($fileinfo['extension']=='php')
			{
				unlink($path."/{$file}");
			}
			unset($file);
			unset($fileinfo);
		}
		closedir($handle);
	}
}

// ACP Server Load function
function get_server_load($windows = 0)
{
	$os = strtolower(PHP_OS);
	if (strpos($os, "win") === false) 
	{
		if (file_exists("/proc/loadavg")) 
		{
		$load = file_get_contents("/proc/loadavg");
		$load = explode(' ', $load);
		return $load[0];
		}
		elseif (function_exists("shell_exec")) 
		{
			$load = explode(' ', `uptime`);
			return $load[count($load)-1];
		} 
		else {
			return "";
		}
	}
	elseif ($windows) 
	{
		if (class_exists("COM")) 
		{
		$wmi = new COM("WinMgmts:\\\\.");
		$cpus = $wmi->InstancesOf("Win32_Processor");

		$cpuload = 0;
		$i = 0;
		while ($cpu = $cpus->Next()) 
		{
			$cpuload += $cpu->LoadPercentage;
			$i++;
		}

		$cpuload = round($cpuload / $i, 2);
		return $cpuload;
	} 
		else {
			return "";
		}
	}
}
?>