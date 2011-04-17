<?php
/*
MillionCMS Project
    
    Name: Functions
    Description: General Functions

    Author: Polarbear541

    Copyright © 2010 Polarbear541 and MillionCMS Group
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

// Generate a random string.
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

// Redirect to another page.
function redirect($url, $seconds=0) 
{
	echo "<br /><meta http-equiv='refresh' content='{$seconds}; url={$url}'>"; 
	return true;
}

// Output an error.
function error($message)
{
	global $error_class;
	if($error_class->seterrors==0)
	{
		$error_class->seterrors = 1;
		if(defined("IN_ADMIN"))
		{
			echo "<link rel='stylesheet' type='text/css' href='../../styles/default.css' />";
		}
		else
		{
			echo "<link rel='stylesheet' type='text/css' href='./styles/default.css' />";
		}
	}
	echo "<div id='error'><p><em>Error: {$message}</em></p></div><br />";
}
// Function for inline errors.
function inline_error($message)
{
	return "<div id='error'><p style='color:#FFF;'><em>Error: {$message}</em></p></div><br />";
}
// Check the user's session.
function check_session()
{
	global $db, $imp;
	$ruser['uid'] = 0;
	$ruser['gid'] = 1;
	$ruser['username'] = 'Guest';
	$impuid = $db->sanitise($_COOKIE['mcmsuid']);
	$user = $db->query("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='{$impuid}'");
	$millionsession = $db->sanitise($_COOKIE['millionsession']);
	$session = $db->query("SELECT * FROM ".TABLE_PREFIX."users WHERE session='{$millionsession}'");
	$count = $db->num($session);
	if($count==1)
	{
		$msession = $db->fetch_array($session);
		$muser = $db->fetch_array($user);
		if($msession['uid']==$muser['uid'])
		{
			$ruser = $muser;
		}
	}
	$imp->assign_user($ruser);
}

// Check the admin user's session.
function check_adminsession()
{
	global $db, $imp;
	$ruser['uid'] = 0;
	$ruser['gid'] = 1;
	$ruser['username'] = 'Guest';
	$impuid = $db->sanitise($_COOKIE['mcmsuid']);
	$user = $db->query("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='{$impuid}'");
	$millionsession = $db->sanitise($_COOKIE['madminsession']);
	$session = $db->query("SELECT * FROM ".TABLE_PREFIX."users WHERE adminsession='{$millionsession}'");
	$count = $db->num($session);
	if($count==1)
	{
		$msession = $db->fetch_array($session);
		$muser = $db->fetch_array($user);
		if($msession['uid']==$muser['uid'])
		{
			$ruser = $muser;
		}
	}
	$imp->assign_user($ruser);
}

// Get a username from the uid with proper formatting.

function getcname($uid)
{
	global $db, $perms;
	if($uid=='-1')
	{
		$user['username'] = 'Pixie Admin';
		return $user['username'];
	}
	// Want to save it as a PHP so random people can't view it.
	$userfile = ROOT."/cache/users/{$uid}.php";
	$expiry = get_cache('cacheexpiry');
	if(file_exists($userfile)&&(time()-$expiry<filemtime($userfile))) 
	{
		include($userfile);
	}
	else
	{
		$query = $db->query("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='{$uid}'");
		$count = $db->num($query);
		if($count=='0')
		{
			$user['username'] = 'Guest';
			return $user['username'];
		}
		$result = $db->fetch_array($query);
		$content .= "<?php\n";
		foreach($result as $key => $value)
		{
			if($key!='password' && $key!='salt')
			{
				$user[$key] = $value;
				$value = str_replace("'","/'",$value);
				$content .= "\$user['{$key}'] = '{$value}';\n";
				unset($row);
			}
		}
		$content .= '?>';
		// Open the file in write mode.
		$open = fopen($userfile,'w');
		// Write to the file.
		fwrite($open,"$content\n");
		// Don't need it open anymore.
		fclose($open);
	}
	if($perms->founder($uid))
	{
		$markup1 = '<span style="color:purple;">';
		$markup2 = '</span>';
	}
	elseif($user['superadmin']==1)
	{
		$markup1 = '<span style="color:purple;">';
		$markup2 = '</span>';
	}
	elseif($user['status']==1)
	{
		$markup1 = '<span style="color:green;">';
		$markup2 = '</span>';
	}
	elseif($user['status']==2)
	{
		$markup1 = '<span style="color:red;">';
		$markup2 = '</span>';
	}
	elseif($user['uid']==-1)
	{
		$markup1 = '<span style="color:black;"><i>';
		$markup2 = '</i></span>';
	}
	else
	{
		$markup1 = '';
		$markup2 = '';
	}
	$cusername = $markup1.$user['username'].$markup2;
	return $cusername;
}

// Get a username from the uid.
function getname($uid)
{
	global $db;
	if($uid=='-1')
	{
		$user['username'] = 'Pixie Admin';
		return $user['username'];
	}
	// Want to save it as a PHP so random people can't view it.
	$userfile = ROOT."/cache/users/{$uid}.php";
	$expiry = get_cache('cacheexpiry');
	if(file_exists($userfile)&&(time()-$expiry<filemtime($userfile))) 
	{
		include($userfile);
	}
	else
	{
		$query = $db->query("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='{$uid}'");
		$count = $db->num($query);
		if($count=='0')
		{
			$user['username'] = 'Guest';
			return $user['username'];
		}
		$result = $db->fetch_array($query);
		$content .= "<?php\n";
		foreach($result as $key => $value)
		{
			if($key!='password' && $key!='salt')
			{
				$user[$key] = $value;
				$value = str_replace("'","/'",$value);
				$content .= "\$user['{$key}'] = '{$value}';\n";
				unset($row);
			}
		}
		$content .= '?>';
		// Open the file in write mode.
		$open = fopen($userfile,'w');
		// Write to the file.
		fwrite($open,"$content\n");
		// Don't need it open anymore.
		fclose($open);
	}
	return $user['username'];
}

// Fetch an avatar from the uid.
function getavatar($uid)
{
	global $db;
	if($uid=='-1')
	{
		$avatar = "./images/uploads/avatars/pixie.png";
		return $avatar;
	}
	// Want to save it as a PHP so random people can't view it.
	$userfile = ROOT."/cache/users/{$uid}.php";
	$expiry = get_cache('cacheexpiry');
	if(file_exists($userfile)&&(time()-$expiry<filemtime($userfile))) 
	{
		include($userfile);
	}
	else
	{
		$query = $db->query("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='{$uid}'");
		$count = $db->num($query);
		if($count=='0')
		{
			return false;
		}
		$result = $db->fetch_array($query);
		$content .= "<?php\n";
		foreach($result as $key => $value)
		{
			if($key!='password' && $key!='salt')
			{
				$user[$key] = $value;
				$value = str_replace("'","/'",$value);
				$content .= "\$user['{$key}'] = '{$value}';\n";
				unset($row);
			}
		}
		$content .= '?>';
		// Open the file in write mode.
		$open = fopen($userfile,'w');
		// Write to the file.
		fwrite($open,"$content\n");
		// Don't need it open anymore.
		fclose($open);
	}
	if(defined("IN_ADMIN"))
	{
		$user['avatar'] = str_replace('./','../../',$user['avatar']);
	}
	return $user['avatar'];
}

// Function for resizing images.
function resize_image($height,$width,$maxheight,$maxwidth)
{
	if($height>$maxheight || $width>$maxwidth)
	{
		while($height>$maxheight)
		{
			$height = $height/2;
			$width = $width/2;
		}
		while($width>$maxwidth)
		{
			$height = $height/2;
			$width = $width/2;
		}
	}
	$array['height'] = $height;
	$array['width'] = $width;
	return $array;
}

// Get the usergroup from the uid supplied.
function getgroup($uid)
{
	global $db;
	if($uid=='-1')
	{
		$group['name'] = 'Pixie';
		$group['description'] = 'The leader of the mCMS Pixies';
		$group['adminlevel'] = 999;
		return $group;
	}
	// Want to save it as a PHP so random people can't view it.
	$userfile = ROOT."/cache/users/{$uid}.php";
	$expiry = get_cache('cacheexpiry');
	if(file_exists($userfile)&&(time()-$expiry<filemtime($userfile))) 
	{
		include($userfile);
		$groupfile = ROOT."/cache/groups/{$user['gid']}.php";
		if(file_exists($groupfile)&&(time()-$expiry<filemtime($groupfile))) 
		{
			include($groupfile);
		}
		else
		{
			$query2 = $db->query("SELECT * FROM ".TABLE_PREFIX."usergroups WHERE gid='{$user['gid']}'");
			$count2 = $db->num($query2);
			if($count2=='0')
			{
				$group['name'] = 'Unknown';
				$group['description'] = 'The group data could not be found';
				$group['adminlevel'] = 0;
				return $group;
			}
			$groupp = $db->fetch_array($query2);
			$content .= "<?php\n";
			foreach($groupp as $key => $value)
			{
				if($key!='password' && $key!='salt')
				{
					$group[$key] = $value;
					$value = str_replace("'","/'",$value);
					$content .= "\$group['{$key}'] = '{$value}';\n";
					unset($row);
				}
			}
			$content .= '?>';
			// Open the file in write mode.
			$open2 = fopen($groupfile,'w');
			// Write to the file.
			fwrite($open2,"$content\n");
			// Don't need it open anymore.
			fclose($open2);
		}
	}
	else
	{
		$query = $db->query("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='{$uid}'");
		$count = $db->num($query);
		if($count=='0')
		{
			$group['name'] = 'Unknown';
			$group['description'] = 'The group data could not be found';
			$group['adminlevel'] = 0;
			return $group;
		}
		$userr = $db->fetch_array($query);
		$content .= "<?php\n";
		foreach($userr as $key => $value)
		{
			if($key!='password' && $key!='salt')
			{
				$user[$key] = $value;
				$value = str_replace("'","/'",$value);
				$content .= "\$user['{$key}'] = '{$value}';\n";
				unset($row);
			}
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
		$groupfile = ROOT."/cache/groups/{$user['gid']}.php";
		$query2 = $db->query("SELECT * FROM ".TABLE_PREFIX."usergroups WHERE gid='{$user['gid']}'");
		$count2 = $db->num($query2);
		if($count2=='0')
		{
			$group['name'] = 'Unknown';
			$group['description'] = 'The group data could not be found';
			$group['adminlevel'] = 0;
			return $group;
		}
		$groupp = $db->fetch_array($query2);
		$content .= "<?php\n";
		foreach($groupp as $key => $value)
		{
			if($key!='password' && $key!='salt')
			{
				$group[$key] = $value;
				$value = str_replace("'","/'",$value);
				$content .= "\$group['{$key}'] = '{$value}';\n";
				unset($row);
			}
		}
		$content .= '?>';
		// Open the file in write mode.
		$open2 = fopen($groupfile,'w');
		// Write to the file.
		fwrite($open2,"$content\n");
		// Don't need it open anymore.
		fclose($open2);
	}
	return $group;
}

// Update the user's current location.
function update_location($string)
{
	global $imp;
	if(!empty($imp->user['uid']))
	{
		$db->query("UPDATE ".TABLE_PREFIX."users SET location='{$string}' WHERE uid='{$imp->user['uid']}'");
	}
}

// Confirm that the user in question actually exists.
function confirm_user($uid)
{
	global $db;
	$query = $db->query("SELECT uid FROM ".TABLE_PREFIX."users WHERE uid='{$uid}'");
	$count = $db->num($query);
	if($count=='0')
	{
		return false;
	}
	return true;
}

// Fetch cached data
function get_cache($cache)
{
	global $imp;
	$cache = $imp->cache[$cache];
	return $cache;
}
function getuid($username)
{
	global $db;
	$query = $db->query("SELECT uid FROM ".TABLE_PREFIX."users WHERE username='{$username}'");
	$count = $db->num($query);
	if($count=='0')
	{
		return false;
	}
	$result = $db->fetch_array($query);
	$uid = $result['uid'];
	return $uid;
}
function getutitle($uid)
{
	global $db;
	if($uid=='-1')
	{
		return 'Pixie Leader';
	}
	// Want to save it as a PHP so random people can't view it.
	$userfile = ROOT."/cache/users/{$uid}.php";
	$expiry = get_cache('cacheexpiry');
	if(file_exists($userfile)&&(time()-$expiry<filemtime($userfile))) 
	{
		include($userfile);
		$title = $user['title'];
		if(empty($title))
		{
			$group = getgroup($uid);
			$title = $group['name'];
		}
		return $title;
	}
	else
	{
		$query = $db->query("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='{$uid}'");
		$count = $db->num($query);
		if($count=='0')
		{
			return false;
		}
		$result = $db->fetch_array($query);
		$title = $result['title'];
		if(empty($title))
		{
			$group = getgroup($uid);
			$title = $group['name'];
		}
		$content .= "<?php\n";
		foreach($result as $key => $value)
		{
			if($key!='password' && $key!='salt')
			{
				$value = str_replace("'","/'",$value);
				$content .= "\$user['{$key}'] = '{$value}';\n";
				unset($row);
			}
		}
		$content .= '?>';
		// Open the file in write mode.
		$open = fopen($userfile,'w');
		// Write to the file.
		fwrite($open,"$content\n");
		// Don't need it open anymore.
		fclose($open);
	}
	return $title;
}
function getuser($uid)
{
	global $db;
	if($uid=='-1')
	{
		$user['title'] = 'Pixie Leader';
		$user['username'] = 'Pixie Admin';
		$user['avatar'] =  "./images/uploads/avatars/pixie.png";
		$user['superadmin'] = '1';
		$user['gid'] = '-1';
		$user['uid'] = $uid;
		return $user;
	}
	$query = $db->query("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='{$uid}'");
	$count = $db->num($query);
	if($count=='0')
	{
		return false;
	}
	$user = $db->fetch_array($query);
	$title = $user['title'];
	if(empty($title))
	{
		$group = getgroup($uid);
		$title = $group['name'];
	}
	$user['title'] = $title;
	return $user;
}
function regenerate_cache($cache,$id = null)
{
	global $db;
	if($cache=='users')
	{
		// Why not delete the file and have it rebuilt upon page load?
		if(file_exists(ROOT."/cache/users/{$id}.php"))
		{
			unlink(ROOT."/cache/users/{$id}.php");
		}
	}
	elseif($cache=='groups')
	{
		if(file_exists(ROOT."/cache/groups/{$id}.php"))
		{
			unlink(ROOT."/cache/groups/{$id}.php");
		}
	}
}
?>