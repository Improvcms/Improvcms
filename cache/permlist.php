<?php
/*
MillionCMS Project
    
	Name: Permissions Library Cache
	Description: A file which contains all of the permissions used by MillionCMS.

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

// First, the regular permissions.
$regpermissions = array();
$regpermissions[] = "can_view_pages";
$regpermissions[] = "can_view_toolbox";
$regpermissions[] = "can_view_page_list";
$regpermissions[] = "can_create_pages";
$regpermissions[] = "can_create_staff_pages";
$regpermissions[] = "can_edit_own_pages";
$regpermissions[] = "can_edit_pages";
$regpermissions[] = "can_delete_own_pages";
$regpermissions[] = "can_report_pages";
$regpermissions[] = "can_view_deleted_pages";
$regpermissions[] = 'can_edit_all_pages';
$regpermissions[] = 'can_delete_pages';
$regpermissions[] = 'can_delete_all_pages';
$regpermissions[] = 'can_manage_reports';
$regpermissions[] = 'can_undelete_pages';
$regpermissions[] = 'can_warn_users';
$regpermissions[] = 'can_access_admincp';
$regpermissions[] = 'can_permanently_delete_reports';
$regpermissions[] = 'can_permanently_delete_pages';
$regpermissions[] = "can_edit_all_staff_pages";
$regpermissions[] = "can_change_page_status";
$regpermissions[] = "can_use_page_block_bbcode";
$regpermissions[] = "can_delete_all_staff_pages";
$regpermissions[] = "can_ban_users";
$regpermissions[] = "can_edit_users";
$regpermissions[] = "can_view_offline";
$regpermissions[] = "can_create_comments";
$regpermissions[] = "can_edit_comments";
$regpermissions[] = 'can_delete_comments';

// Then, the administrator permissions.
$adminpermissions[] = 'admin:can_manage_pages';
$adminpermissions[] = 'admin:can_edit_users';
$adminpermissions[] = 'admin:can_view_adminlogs';
$adminpermissions[] = 'admin:can_edit_adminperms';
$adminpermissions[] = 'admin:can_edit_adminlevels';
$adminpermissions[] = 'admin:can_edit_usergroups';
?>