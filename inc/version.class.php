<?php
/*
ImprovCMS Project
    
    Name: Version Class
    Description: This file contains version data.

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
if(!defined("IN_IMPROV"))
{
	die("Access Denied");
}

class version
{
	public $flatest;
	public $lc;
	public $fcurrent;
	public $cc;
	
	function data()
	{
		$latest = "Alpha 3 Development";
		$lc = "3";
		$current = "Alpa 3 Development";
		$cc = "3";
	}
}