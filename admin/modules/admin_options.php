<?php
/*
	ImprovCMS Project

	Name: AdminCP Home
	Version: Development
	Description: The homepage for the advanced design AdminCP
	Last Update: Never 

	Author: Damian, Kyuubi, Azareal.


	Copyright Damian, Kyuubi, Azareal + Improv Software Group © 2010


	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

// Define Important Constants
define("IN_MILLION", "1");
define("IN_ADMIN","1");

// Need to include certain files.
require("./include/functions.php");
require_once('../../global.php');

// Before the user can do anything here, check if the user is actually an administrator
if(!$is_admin) 
{
	die($error->perms(20));
}
// Admin Note's
if(!empty($_POST['admin_notes']))
{
	$admin_notes = $db->sanitise($_POST['admin_notes']);
	if(!empty($admin_notes))
	{
		$detail['prev'] = get_cache('admin_notes');
		$db->query("UPDATE ".TABLE_PREFIX."cache SET content='{$admin_notes}' WHERE name='admin_notes'");
		$detail['field'] = 'content';
		$detail['record'] = 'admin_notes';
		$detail['post'] = $admin_notes;
		$detail['where'] = 'name';
		$details = serialize($detail);
		$time = time();
		$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','home_main.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','cache','{$details}') ");
	}
	
	// Redirect to Save Message (Also to refresh the note's)
	header('Location: home_main.php?action=notes_done');
	exit;
}
$ccache = unserialize(get_cache('lastadminlogins'));
$ladminlogin = "Was by {$ccache['name']} at ".date('G\:i A',$ccache['time'])." on the ".date('F j, Y',$ccache['time']).".";
$commentcount = $db->count("SELECT cid FROM ".TABLE_PREFIX."comments");
$pagecount = $db->count("SELECT pid FROM ".TABLE_PREFIX."pages");
$awaitingactivation = $db->count("SELECT uid FROM ".TABLE_PREFIX."users WHERE activationkey!='0'");
$lastcutoff = time()-(60*15);
$onlineusers = $db->count("SELECT uid FROM ".TABLE_PREFIX."users WHERE lastactive>={$lastcutoff}");
$usercount = $db->count("SELECT uid FROM ".TABLE_PREFIX."users");
$anotes = get_cache('admin_notes');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Options | ImprovCMS ACP</title>
<link media="screen" rel="stylesheet" type="text/css" href="../css/admin.css" />
<script type="text/javascript" src="../js/behaviour.js"></script>
<script type="text/javascript" src="../js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="../js/current_date.js"></script>
<script type="text/javascript" src="../js/millioncms_admin_panel.jquery.js"></script>
</head>
<body onLoad="show_clock()">
<div id="wrapper">
	<div id="head">
    	<div id="logo_user_details">
        	<span id="logo" style="color:#0CF; font-size:42px; margin-top:10px;"><?php echo $imp->settings['site_name'] ?><br /><span style=" color:#999; font-size:20px; float:right;">Administration Panel</span></span>
        <div id="user_details">

        <ul id="user_details_menu">
        	<br />
			<li>Welcome <strong><?php echo $imp->user['username'] ?></strong></li>
				<li>
					<ul id="user_access">
						<li class="first"><a href="../../index.php">Return to Home</a></li>
						<li class="last"><a href="../logout.php" >Log Out?</a></li>
					</ul>
				</li>
			<li><a class="new_notifications" href="#">0 Unread Notifications</a></li>
		</ul>
        </div>
        <img id="mcms_logo" src="../images/logo.png" width="312" height="99" />
      </div>
    </div>
    
    <div id="million_menu_wrapper">
    	<div id="main_menu">
			<ul>
				<li><a href="home_main.php" class="selected"><span><span>Home</span></span></a></li>
				<li><a href="add_article.php"><span><span>Articles &amp; Categories</span></span></a></li>
				<li><a href="template_m_home.php"><span><span>Look &amp; Feel</span></span></a></li>
				<li><a href="ext_manage.php"><span><span>Extentions</span></span></a></li>
				<li><a href="general_settings.php"><span><span>Settings</span></span></a></li>
                <li><a href="users.php"><span><span>Users &amp; Accounts</span></span></a></li>
				<li><a href="manager.php"><span><span>Million Manager</span></span></a></li>    
                <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>      
				<li class="last"><a href="http://forums.millioncms.com/"><span><span>Need Help?</span></span></a></li>
			</ul>
		</div>
        <div id="sec_menu">
			<ul>
				<li><a href="home_main.php" class="admin_home">Admin Home</a></li>
				<li><a href="admin_options.php" class="admin_options">Admin Options</a></li>
				<li><a href="visual_preferences.php" class="visual_pref">Visual Preferences</a></li>
			</ul>
		</div>
    </div>
    
    <div id="content" style="padding-bottom:50px;"><img src="../images/content_top.png" width="100%" height="1px" />
        
        <!-- No Javascript Notification -->
		<noscript>
		<div class="notification error png_bg">
            <div>
                Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/">upgrade</a> your browser or <a href="http://activatejavascript.org/en/instructions/ie">enable</a> Javascript to navigate the MillionCMS Admin Control Panel interface properly.
            </div>
        </div>
        </noscript>                          
    
    	<!-- SIDEBAR -->
		<div id="sidebar">
        	<div class="contentcontainer">  
                <div class="contentcontainer">
                    <div class="headings">
                        <h2>Time & Day</h2>
                    </div>                
                    <div class="contentbox">
                    	<div id="clock_date" style="text-align:center;">		
                            <div id="clock"><script type="text/javascript" src="../js/time.js"></script></div>
                            <script>document.write(""+dayarray[day]+", "+montharray[month]+" "+daym+", "+year+"")</script>                      
                        </div>
                    </div>
                </div>                       
                
                <div class="contentcontainer">
                    <div class="headings">
                        <h2>Admin Help</h2>
                    </div>                
                    <div class="contentbox">
                    	This page (Admin Option's) allows you to set up general settings that effect either only you, or all admin user's. When editing these fields, please note that they are already set at recommended levels and by changing them, may cause security issues.
                    </div>
                </div>
                
                <div class="contentcontainer">               
                    <div class="contentbox_no_head">
                    		<?php
								$globend = microtime(true);
								$globtime = $globend - $globstart;
							?>
                    	<strong>ImprovCMS</strong><br />
                        Copyright &copy; 2010<br /><br />                        
                        Script executed in <?php echo $globtime; ?>s<br />
                        <?php echo $db->queries; ?> SQL queries used<br /><br />
                        Version: <?php echo $imp->fversion; ?><br />
                        <strong>Development Stage</strong>
                    </div>
                </div>              
            </div>
        </div>
        <!-- SIDEBAR END -->
        
        <!-- MAIN CONTENT STRIP AREA -->
        <div id="main_content">   
        
        	<div class="contentcontainer">
            	<div class="headings">
                	<h2>Admin Control Panel - Options</h2>
                </div>                
                <div class="contentbox">
                	<form>
               		<table>
                    
                        <thead>
                          <tr>                    
                            <th>General Settings</th>
                          </tr>
                        </thead>
                    
                    	<tbody>                        
                          <tr>
                            <td><label>Admin Session Time Out</label>Ten Minutes: <input type="radio" /> Fiften Minutes: <input type="radio" /> Twenty Minutes: <input type="radio" /></td>
                          </tr>
                        
                          <tr>
                            <td><label>Closable Notifications</label>Yes: <input type="radio" /> No: <input type="radio" /></td>
                          </tr>                    	
                        </tbody>
                    </table>
                   
               		<table>
                    
                        <thead>
                          <tr>                    
                            <th>Other Settings</th>
                          </tr>
                        </thead>
                    
                    	<tbody>                        
                          <tr>
                            <td><label>Send Crash Reports</label>Yes: <input type="radio" /> No: <input type="radio" /></td>
                          </tr>
                   </table>
                   </form>
                </div>
            </div>            
        	                  
        </div>
        <!-- MAIN CONTENT STRIP AREA END -->
   	 </div>    
    </div>  
</body>
</html>