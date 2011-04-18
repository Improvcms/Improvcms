<?php
/*
ImprovCMS Project
    
    Name: Version Class
    Description: This file contains methods for determining latest and current version.

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

class version
{
	public $flatest;
	public $lc;
	public $fcurrent;
	public $cc;
	
	function flatest()
	{
		$latest = "Alpha 3 Development";
	}
	function lc()
	{
		$lc = "003";
	}
	function fcurrent()
	{
		$current = "Alpa 3 Development";
	}
	function cc()
	{
		$cc = "003";
	}
}