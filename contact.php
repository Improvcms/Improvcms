<?php
/*
MillionCMS Project
    
    Name: Contact Form
    Description: Contains the code for the contact us form.
	
    Author: Kyuubi

    Copyright © 2010 Kyuubi and MillionCMS Group
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

define("THIS_SCRIPT","contact.php");
define("IN_IMPROV","1");
require("global.php");
$loc = 'contact.php';

// Only display the code below if the user is viewing the page ?action=success.
if($_GET['action'] == 'success')
{
	$emailsent = $_POST['email'];
	$email_subj = $_POST['email_subj'];
	$mess = $_POST['mess'];
	$success = "Thank you, the details were submitted to the administrator.<br /><br />
	You submitted the following:<br />
	Email: {$emailsent}
	Message: {$mess}";
	$to = $imp->settings['email'];
	$message = "
	Hello.
	
	The following email was sent to you by {$email} via the Contact Us form.

	Here is a copy of the message sent by the user
	{$mess}

	All the best,
	{$imp->settings['site_name']} Mailer";
	$subject = "Contact Us Form - {$imp->settings['site_name']}";
	$header_from .= "From: {$imp->settings['site_name']} Mailer System <no-reply@{$imp->settings['homeurl']}>"."\r\n";
	mail($to, $subject, $message, $header_from);
}
$smarty->assign('success',$success);
$smarty->display("db:page_contact");
?>