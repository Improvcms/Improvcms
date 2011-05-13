<?php
/*
ImprovCMS Project
    
    Name: AdminCP Settings
    Description: This file contains data for the Settings tab on the AdminCP.

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

// Define Important Constants
define("IN_MILLION", "1");
define("IN_ADMIN","1");

// Need to include the global.php
require_once('../../global.php');

// Before the user can do anything here, check if the user is actually an administrator
if (!$is_admin)
{
	die($error->perms(20));
}

// Now for the actual pages.
if($_GET['action']=='general')
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>General Settings | ImprovCMS ACP</title>
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
        	<span id="logo" style="color:#0CF; font-size:42px; margin-top:10px;">
			<?php echo $imp->settings['site_name'];	?>
			<br /><span style=" color:#999; font-size:20px; float:right;">Administration Panel</span></span>
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
				<li><a href="home_main.php"><span><span>Home</span></span></a></li>
				<li><a href="add_article.php"><span><span>Articles &amp; Categories</span></span></a></li>
				<li><a href="template_m_home.php"><span><span>Look &amp; Feel</span></span></a></li>
				<li><a href="ext_manage.php"><span><span>Extentions</span></span></a></li>
				<li><a href="general_settings.php" class="selected"><span><span>Settings</span></span></a></li>
                <li><a href="users.php"><span><span>Users &amp; Accounts</span></span></a></li>
				<li><a href="manager.php"><span><span>Million Manager</span></span></a></li>   
                <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>      
				<li class="last"><a href="http://improvcms.com/forums/"><span><span>Need Help?</span></span></a></li>
			</ul>
		</div>
        <div id="sec_menu">
			<ul>
				<li><a class="general_settings" style="font-weight: bold;">General Settings</a></li>
                <li><a href="settings.php?action=user" class="user_settings">User Settings</a></li>
                <li><a href="#" class="user_creation">User Creation</a></li>
                <li><a href="#" class="system">System</a></li>
                <li><a href="settings.php?action=server" class="server">Server</a></li>
                <li><a href="settings.php?action=backup" class="backup">Backup System</a></li>
                <li><a href="settings.php?action=adminlogs" class="admin_logs">Admin Logs</a></li>
                <li><a href="#" class="mass_mail">Send Mass Mail</a></li>
			</ul>
		</div>
    </div>
    
    <div id="content" style="padding-bottom:50px;"><img src="../images/content_top.png" width="100%" height="1px" />
        
        <!-- No Javascript Notification -->
		<noscript>
		<div class="notification error png_bg">
            <div>
                Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/">upgrade</a> your browser or <a href="http://activatejavascript.org/en/instructions/ie">enable</a> Javascript to navigate the ImprovCMS Admin Control Panel interface properly.
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
                    	On this page, you will find the General Settings for your website. The settings here go from turning your site on or off, to changing the favicon all over your website.
                        <br /><br />
                        All settings on this page are safe to edit, and will not cause safty issues if you change them. The email here is kept in the database, and can not be accessed outside of the ACP.
                    </div>
                </div>
                
                <div class="contentcontainer">               
                    <div class="contentbox_no_head">
                    		<?php
								$globend = microtime(true);
								$globtime = $globend - $globstart;
							?>
                    	<strong>ImprovCMS</strong><br />
                        Copyright &copy; 2011<br /><br />                        
                        Script executed in <?php echo $globtime ?>s<br />
                        <?php echo $db->queries ?> SQL queries used<br /><br />
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
                	<h2>Admin Control Panel - General Settings</h2>
              </div>                
                <div class="contentbox">
                
                      <?php
						// Success Message
						if ($_GET['action']=='done') {echo '
							<div class="notification success">
        					<a href="#" class="close"><img src="../images/cross_grey_small.png" title="Close this notification" alt="close" /></a>
           					<div>
            					Settings have been successfully updated and saved!
            				</div>
       						</div>
						';}
					  ?>
                
                	<form action="core/settings_insert.php" method="post" name="general_settings" enctype="multipart/form-data">
                    	<table>
                            <thead>
                              <tr>                    
                                <th width="25%">Operational Settings</th>
                                <th width="75%"></th>
                              </tr>
                            </thead>
                        
                            <tbody>                        
                              <tr>
                                <td><span class='title_text'>Site On/Off?</span></td>
                                <td>
                                <!-- On is 1 and Off is 0 -->                                                                                
              					<input type="radio" <?php if($imp->settings['site_switch'] == '1') { echo 'checked="checked"'; }; ?> name="site_switch_input" id="1" value="1" /> On
     		  					<input type="radio" <?php if($imp->settings['site_switch'] == '0') { echo 'checked="checked"'; }; ?> name="site_switch_input" id="0" value="0" /> Off
                                </td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Site Message:</span></td>
                                <td><input style="width:50%" type="text" id="site_message_input" name="site_message_input" value="<?php echo $imp->settings['site_message'] ?>" /></td>
                              </tr>                    	
                            </tbody>
                        </table>
                        
                        <br /><br />
                        
                    	<table>
                            <thead>
                              <tr>                    
                                <th width="25%">General Settings</th>
                                <th width="75%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
                            
                              <tr>
                                <td><span class='title_text'>Site URL:</span></td>
                                <td><input style="width:50%" type="text" name="site_url_input" id="site_url_input" value="<?php echo $imp->settings['siteurl'] ?>" /></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Home URL:</span></td>
                                <td><input style="width:50%" type="text" name="home_url_input" id="home_url_input" value="<?php echo $imp->settings['homeurl'] ?>" /></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Site Email:</span></td>
                                <td><input style="width:50%" type="text" name="master_email_input" id="master_email_input" value="<?php echo $imp->settings['site_email'] ?>" /></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Website Name:</span></td>
                                <td><input style="width:50%" type="text" name="site_name_input" id="site_name_input" value="<?php echo $imp->settings['site_name'] ?>" /></td>
                              </tr>
                                                 	
                            </tbody>
                        </table>
                        
                        <br /><br />
                        
                    	<table>
                            <thead>
                              <tr>                    
                                <th width="25%">Other Settings</th>
                                <th width="75%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
                            
                              <tr>
                                <td><span class='title_text'>Current Favicon:</span></td>
                                <td><?php if (!file_exists("../../../favicon.ico")){echo "You don't have a favicon!";}else echo '<img src="../../../favicon.ico">';?></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Change Favicon:</span></td>
                                <td><input name="favicon_upload" id="favicon_upload" type="file" /></td>
                              </tr>
                              
                            </tbody>
                        </table>
                        <div style="text-align:center;"><br /><input name="general_settings" id="general_settings" type="submit" value="Save Changes" /></div>
                    </form>
                </div>
            </div>            
        	                  
        </div>
        <!-- MAIN CONTENT STRIP AREA END -->
   	 </div>    
    </div>  
</body>
</html>
<?php
}
elseif($_GET['action']=='user')
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>User Settings | ImprovCMS ACP</title>
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
				<li><a href="home_main.php"><span><span>Home</span></span></a></li>
				<li><a href="add_article.php"><span><span>Articles &amp; Categories</span></span></a></li>
				<li><a href="template_m_home.php"><span><span>Look &amp; Feel</span></span></a></li>
				<li><a href="ext_manage.php"><span><span>Extentions</span></span></a></li>
				<li><a href="settings.php" class="selected"><span><span>Settings</span></span></a></li>
                <li><a href="users.php"><span><span>Users &amp; Accounts</span></span></a></li>
				<li><a href="manager.php"><span><span>Million Manager</span></span></a></li>   
                <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>      
				<li class="last"><a href="http://forums.millioncms.com/"><span><span>Need Help?</span></span></a></li>
			</ul>
		</div>
        <div id="sec_menu">
			<ul>
				<li><a href="settings.php?action=general" class="general_settings">General Settings</a></li>
                <li><a class="user_settings" style="font-weight: bold;">User Settings</a></li>
                <li><a href="#" class="user_creation">User Creation</a></li>
                <li><a href="#" class="system">System</a></li>
                <li><a href="server.php" class="server">Server</a></li>
                <li><a href="backup.php" class="backup">Backup System</a></li>
                <li><a href="adminlogs.php" class="admin_logs">Admin Logs</a></li>
                <li><a href="sql_inject.php" class="sql_inject">SQL Inject</a></li>
                <li><a href="#" class="mass_mail">Send Mass Mail</a></li>
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
                    	Help goes Here!
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
                        Script executed in <?php echo $globtime ?>s<br />
                        <?php echo $db->queries ?> SQL queries used<br /><br />
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
                	<h2>Admin Control Panel - User Settings</h2>
                </div>                
                <div class="contentbox">
                
                      <?php
						// Success Message
						if ($_GET['action']=='done') {echo '
							<div class="notification success">
        					<a href="#" class="close"><img src="../images/cross_grey_small.png" title="Close this notification" alt="close" /></a>
           					<div>
            					Settings have been successfully updated and saved!
            				</div>
       						</div>
						';}
					  ?>
                      
                	<form action="core/settings_insert.php" method="post" name="user_settings">
                    	<table>
                            <thead>
                              <tr>                    
                                <th width="25%">Avatar Dimentions (pixels)</th>
                                <th width="75%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
                            
                              <tr>
                                <td><span class='title_text'>Width:</span></td>
                                <td><input type="text" name="avatar_maxwidth" id="avatar_maxwidth" value="<?php echo $imp->settings['avatar_maxwidth'] ?>" /></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Height:</span></td>
                                <td><input type="text" name="avatar_maxheight" id="avatar_maxheight" value="<?php echo $imp->settings['avatar_maxheight'] ?>" /></td>
                              </tr>
                                                 	
                            </tbody>
                        </table>
                        <div style="text-align:center;"><br /><input name="user_settings" id="user_settings" type="submit" value="Save Changes" /></div>
                    </form>
                </div>
            </div>            
        	                  
        </div>
        <!-- MAIN CONTENT STRIP AREA END -->
   	 </div>    
    </div>  
</body>
</html>
<?php
}
else {
	die($error->internal(44));
}
?>