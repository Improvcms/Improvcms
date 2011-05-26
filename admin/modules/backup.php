<?php
//Require the Global Loader
define("IN_IMPROV", "1");
define("IN_ADMIN","1");
require_once('../../global.php');
// Before the user can do anything here, check if the user is actually an administrator
if(!$is_admin) 
{
	die($error->perms(20));
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Backup System | ImprovCMS ACP</title>
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
				<li><a href="general_settings.php" class="selected"><span><span>Settings</span></span></a></li>
                <li><a href="users.php"><span><span>Users &amp; Accounts</span></span></a></li>
				<li><a href="manager.php"><span><span>Million Manager</span></span></a></li>   
                <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>      
				<li class="last"><a href="http://forums.millioncms.com/"><span><span>Need Help?</span></span></a></li>
			</ul>
		</div>
        <div id="sec_menu">
			<ul>
				<li><a href="general_settings.php" class="general_settings">General Settings</a></li>
                <li><a href="user_settings.php" class="user_settings">User Settings</a></li>
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
                    	<strong>MillionCMS</strong><br />
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
                	<h2>Admin Control Panel - Backup</h2>
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
                      
                	<form action="#" method="post" name="backup">
                    	<table>
                            <thead>
                              <tr>                    
                                <th width="25%">Automatic Backup Setting's</th>
                                <th width="75%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
                            
                              <tr>
                                <td><span class='title_text'>Enable Auto Backup?</span></td>
                                <td>Yes: <input type="radio" /> No: <input type="radio" /></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Backup Time:</span></td>
                                <td>
                                <select name="auto_backup_time">
                                    <option value="12am">12am Server Time</option>
                                    <option value="1am">1am Server Time</option>
                                    <option value="2am">2am Server Time</option>
                                    <option value="3am">3am Server Time</option>
                                    <option value="4am">4am Server Time</option>
                                    <option value="5am">5am Server Time</option>
                                    <option value="6am">6am Server Time</option>
                                    <option value="7am">7am Server Time</option>
                                    <option value="8am">8am Server Time</option>
                                    <option value="9am">9am Server Time</option>
                                    <option value="10am">10am Server Time</option>
                                    <option value="11am">11am Server Time</option>
                                    <option value="12pm">12pm Server Time</option>
                                    <option value="1pm">1pm Server Time</option>
                                    <option value="2pm">2pm Server Time</option>
                                    <option value="3pm">3pm Server Time</option>
                                    <option value="4pm">4pm Server Time</option>
                                    <option value="5pm">5pm Server Time</option>
                                    <option value="6pm">6pm Server Time</option>
                                    <option value="7pm">7pm Server Time</option>
                                    <option value="8pm">8pm Server Time</option>
                                    <option value="9pm">9pm Server Time</option>
                                    <option value="10pm">10pm Server Time</option>
                                    <option value="11pm" selected="selected">11pm Server Time</option>
                                </select>
                                </td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Backup Day:</span></td>
                                <td>
                                <select name="auto_backup_day">
                                    <option value="mon">Monday Server Time</option>
                                    <option value="tue">Tuesday Server Time</option>
                                    <option value="wed">Wednesday Server Time</option>
                                    <option value="thu">Thusday Server Time</option>
                                    <option value="fri">Friday Server Time</option>
                                    <option value="sat" selected="selected">Saturday Server Time</option>
                                    <option value="sun">Sunday Server Time</option>
                                </select>
                                </td>
                              </tr>
                                                 	
                            </tbody>
                        </table>
                        <br /><br />
                        <table>
                            <thead>
                              <tr>                    
                                <th width="25%">Manual Backup Setting's</th>
                                <th width="75%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
                            
                              <tr>
                                <td><span class='title_text'>Start a Backup now?</span></td>
                                <td><a href="manual_backup.php"><input name="backup_manual_start" id="backup_manual_start" type="submit" value="Start Manual Backup" /></a></td>
                              </tr>
                                                 	
                            </tbody>
                        </table>
                        <br /><br />
                        <table>
                            <thead>
                              <tr>                    
                                <th width="25%">General Backup Setting's</th>
                                <th width="75%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
                            
                              <tr>
                                <td><span class='title_text'>Backup Save Directory</span></td>
                                <td><a href="manual_backup.php"><input style="width:50%" type="text" /></a></td>
                              </tr>
                                                 	
                            </tbody>
                        </table>
                        <div style="text-align:center;"><br /><input name="backup" id="backup" type="submit" value="Save Changes" /></div>
                    </form>
                </div>
            </div>            
        	                  
        </div>
        <!-- MAIN CONTENT STRIP AREA END -->
   	 </div>    
    </div>  
</body>
</html>