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
elseif(!$perms->check_perms("admin:can_view_adminlogs"))
{
	die($error->perms(21));
}
// Include the Admin Control Panel Functions
include("./include/functions.php");
$userwhere = ' WHERE itable!=\'cache\' ORDER BY time DESC LIMIT 15';
if($_GET['do']=='undo')
{
	$lid = $_GET['logid'];
	reverse_action($lid);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrator Logs | ImprovCMS ACP</title>
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
        	<span id="logo" style="color:#0CF; font-size:42px; margin-top:10px;"><?php echo $imp->settings['site_name']; ?><br /><span style=" color:#999; font-size:20px; float:right;">Administration Panel</span></span>
        <div id="user_details">

        <ul id="user_details_menu">
        	<br />
			<li>Welcome <strong><?php echo $imp->user['username']; ?></strong></li>
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
                    	Here, the admin log's are great for super-admins to track what other admin's are doing in regards to settings and changes.
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
                	<h2>Admin Control Panel - Setting Change Log</h2>
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
                      
                	 <table>                        
                            <tbody>
                            <?php
								$query = $db->query("SELECT * FROM ".TABLE_PREFIX."admin_logs{$userwhere}");                    
								$result = $db->loop2array($query);
								if(!is_array($result))
								{
									$result = array();
								}
								$undo = 1;
								foreach($result as $row)
								{
									if($undo!='' && $row['action']=='update')
									{
										$undo = '(<a href="'.$_SERVER['PHP_SELF'].'?do=undo&logid='.$row['logid'].'">undo</a>)';
									}
									else
									{
										$undo = '';
									}
									echo '
									<tr><th><form name="admin_log_list_id_'.$row['logid'].'" id="log_list_'.$row['uid'].'" action="./core/settings_insert.php" method="post">
									#'.$row['uid'].'<small><strong>&nbsp;&nbsp;<span title="'.$row['ipaddress'].'">'.getname($row['uid']).'</span></strong>&nbsp;'.decipher_logs($row).'&nbsp;
									'.date("F j, Y, g:i a",$row['time']).'</small> <!--'.$undo.'-->
									</form></th></tr>';
									$undo = '';
								}
							?>                                                	
                            </tbody>
                     </table>
                </div>
            </div>            
        	                  
        </div>
        <!-- MAIN CONTENT STRIP AREA END -->
   	 </div>    
    </div>  
</body>
</html>