<?php
/*
ImprovCMS Project
    
    Name: Database Class
    Description: A class that deals with the day to day database queries.

    Author: Azareal

    Copyright © 2010 Azareal and Improv Software Group
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
// The class which manages the database
class mysql
{
	private $db;
	private $con;
	public $queries = 0;
	public $operators = array("=");
	// The constructor
	function __construct($config)
	{
		$this->db = $config['db'];
		$this->connect();
		$this->select();
	}
	// Connects to the MySQL Server
	function connect()
	{
		$this->con = mysql_connect($this->db['host'],$this->db['uname'],$this->db['pass']);
	}
	function select()
	{
		mysql_select_db($this->db['name'], $this->con);
	}
	// This function executes queries on the database
	function query($query)
	{
		global $error;
		$query1 = mysql_query($query, $this->con) or die($error->database(63));
		$this->queries = $this->queries+1;
		return $query1;
	}
	// A new update method to simplify the more complicated one.
	function new_update($table,$set,$where = null,$pre = null)
	{
		global $loc, $imp;
		$explode = explode('=',$set,2);
		if($where!=null)
		{
			$explode2 = explode('=',$where);
			if(defined('IN_ADMIN') && $pre!=false) // Pre is for adminlogging purposes.
			{
				if($pre!=null)
				{
					$detail['pre'] = $pre;
				}
				else
				{
					$fetch_pre = $this->query("SELECT {$explode2['0']} FROM ".TABLE_PREFIX."{$table} WHERE {$explode2['0']}=='{$explode2['1']}'");
					$fetch_array = $this->fetch_array($fetch_pre);
					unset($fetch_pre);
					$detail['pre'] = $fetch_array[$explode['0']];
					unset($fetch_array);
				}
				$detail['field'] = $explode['0'];
				$detail['post'] = $explode['1'];
				$detail['where'] = $explode2['0'];
				$detail['record'] = $explode2['1'];
				$details = serialize($detail);
				$time = time();
				$this->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','{$loc}','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','{$table}','{$details}') ");
				unset($detail);
			}
			$query = $this->query("UPDATE ".TABLE_PREFIX."{$table} SET {$explode['0']}='{$explode['1']}' WHERE {$explode2['0']}='{$explode2['1']}'");
		}
		else
		{
			$query = $this->query("UPDATE ".TABLE_PREFIX."{$table} SET {$explode['0']}='{$explode['1']}'");
		}
		return $query;
	}
	// Finally, we have the update method.
	function update()
	{
		return 'This method is deprecated, please use new_update';
	}
	
	function last_id()
	{
		$id = mysql_insert_id($this->con);
		return $id;
	}
	// Sanitises SQL data
	function sanitise($string)
	{
		if (ini_get('magic_quotes_gpc'))
		{
			$string = stripslashes($string);
		}
		$string = mysql_real_escape_string($string);
		return $string;
	}
	// Sanitise an entire array of SQL data
	function array_sanitise($string)
	{
		// For people who don't know what this method is actually for.
		if(!is_array($string))
		{
			$string = array();
		}
		foreach ($string as $key => $value)
		{
			if(ini_get('magic_quotes_gpc'))
			{
				$str = stripslashes($value);
			}
			$str = mysql_real_escape_string($str);
			$string2[$key] = $str;
			unset($str);
		}
		return $string2;
	}
	// Fetches data from the database
	function fetch($table, $column, $row, $which = '*')
	{
		$query = mysql_query("SELECT ".$which." FROM ".TABLE_PREFIX.$table." WHERE {$column}='{$row}'");
		$result = mysql_fetch_array($query);
		return $result;
	}
	function fetch_array($result)
	{
		$return = mysql_fetch_array($result);
		return $return;
	}
	// Method to be used as a potential fix to a bug
	function loop2array($result)
	{
		$loop = $result;
		while($row = mysql_fetch_array($loop))
		{
			$return[] = $row;
		}
		return $return;
	}
	function selectall($table, $which = '*')
	{
		$query = mysql_query("SELECT {$which} FROM ".TABLE_PREFIX.$table);
		$result = mysql_fetch_array($query);
		return $result;
	}
	function count($query)
	{
		$query = mysql_query("{$query}");
		$result = mysql_num_rows($query);
		return $result;
	}
	function num($query)
	{
		$result = mysql_num_rows($query);
		return $result;
	}
	// Closes the MySQL connection
	function close ()
	{
		mysql_close($this->con);
	}
}
?>