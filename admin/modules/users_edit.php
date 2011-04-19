<?php
//Require the Global Loader
define("IN_MILLION", "1");
define("IN_ADMIN","1");
require_once('../../global.php');
// Before the user can do anything here, check if the user is actually an administrator
if (!$is_admin) {
	error("You do not have permission to view this page.");
	redirect("../index.php");
	exit;
}
elseif(!$perms->check_perms("admin:can_edit_users"))
{
	error("You do not have the required admin permission to view this page, 
	If you believe this message is in error then, contact a super administrator");
	exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit a User | MillionCMS ACP</title>
<link media="screen" rel="stylesheet" type="text/css" href="../css/admin.css" />
<script type="text/javascript" src="../js/behaviour.js"></script>
<script type="text/javascript" src="../js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="../js/current_date.js"></script>
<script type="text/javascript" src="../js/millioncms_admin_panel.jquery.js"></script>
</head>
<body onLoad="show_clock()">

<?php
// Get the UserID to grab his info from database...
$user_id_useredit = $db->sanitise(intval($_REQUEST['uid']));
// Run the query, expecting some sort of infomation...
$query = $db->query("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='{$user_id_useredit}'");
$row = $db->fetch_array($query);
// If we get that infomation, lets make the var's for the form below!
$user_account_id = $user_id_useredit;
$user_account_name = $row['username'];
$user_account_password = $row['password'];
$user_account_email = $row['email'];
$user_account_title = $row['title'];
$user_account_groupid = $row['gid'];
$user_account_avatar = $row['avatar'];
$user_account_regip = $row['ipaddress'];
$user_account_lastactive = $row['lastactive'];
$user_account_adminstyle = $row['adminstyle'];
?>

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
						<li class="first"><a href="../../../index.php">Return to Home</a></li>
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
				<li><a href="general_settings.php"><span><span>Settings</span></span></a></li>
                <li><a href="users.php" class="selected"><span><span>Users &amp; Accounts</span></span></a></li>
				<li><a href="manager.php"><span><span>Million Manager</span></span></a></li>   
                <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>      
				<li class="last"><a href="http://forums.millioncms.com/"><span><span>Need Help?</span></span></a></li>
			</ul>
		</div>
        <div id="sec_menu">
			<ul>
				<li><a href="users.php" class="account_manager">Account Manager</a></li>
				<li><a href="usergroups.php" class="usergroups">Usergroup Manager</a></li>
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
                	<h2><span style="float:left;">Admin Control Panel - User Account Editing - <?php echo"&lsquo;{$user_account_name}&rsquo;"; ?></span><span style="float:right; margin-right:15px;">ID #<?php echo $user_account_id; ?></span></h2>
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
                      
                	 <form name="user_edit" id="user_edit" method="post" action="core/settings_insert.php">
     				 <input type="hidden" id="user_list_id" name="user_list_id" value="<?php echo $row['uid']; ?>">
                    	<table>
                            <thead>
                              <tr>                    
                                <th width="25%">General</th>
                                <th width="75%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
                            
                              <tr>
                                <td><span class='title_text'>Username:</span></td>
                                <td><input style="width:50%" type="text" name="user_account_name_input" id="user_account_name_input" value="<?php echo $user_account_name ?>" /></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Password:</span></td>
                                <td><input style="width:50%" type="password" name="user_account_password_input" id="user_account_password_input" value="*****" /></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Email:</span></td>
                                <td><input style="width:50%" type="text" name="user_account_email_input" id="user_account_email_input" value="<?php echo $user_account_email ?>" /></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Usertitle:</span></td>
                                <td><input style="width:50%" type="text" name="user_account_title_input" id="user_account_title_input" value="<?php echo $user_account_title ?>" /></td>
                              </tr>
                                                 	
                            </tbody>
                        </table>
                        <br /><br />                        
                    	<table>
                            <thead>
                              <tr>                    
                                <th width="25%">Advanced</th>
                                <th width="75%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
                            
                              <tr>
                                <td><span class='title_text'>Registration IP:</span></td>
                                <td><input style="width:50%" type="text" name="user_account_regip_input" id="user_account_regip_input" value="<?php echo $user_account_regip ?>" /></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Avatar URL:</span></td>
                                <td><input style="width:50%" type="text" name="user_account_avatar_input" id="user_account_avatar_input" value="<?php echo $user_account_avatar ?>" /></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Protect User?</span></td>
                                <td>
                                <!-- Yes is 1 and No is 0 -->
								<input class="radio_input" type="radio" <?php if($row['protect']=='1') { echo 'checked="checked"'; }; ?> name="user_account_protect_input" id="1" value="1" /> Yes
								<input class="radio_input" type="radio" <?php if($row['protect']=='0') { echo 'checked="checked"'; }; ?> name="user_account_protect_input" id="0" value="0" /> No
                                </td>
                              </tr>
                                                 	
                            </tbody>
                        </table>
                        <br /><br />                        
                    	<table>
                            <thead>
                              <tr>                    
                                <th width="25%">Profile</th>
                                <th width="75%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
                            
                              <tr>
                                <td><span class='title_text'>About Me:</span></td>
                                <td><input disabled="disabled" style="width:50%" type="text" name="user_account_aboutme_input" id="user_account_aboutme_input" value="Row not yet created..." /></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'Status:></span></td>
                                <td><input disabled="disabled" style="width:50%" type="text" name="user_account_status_input" id="user_account_status_input" value="Row not yet created..." /></td>
                              </tr>
                                                 	
                            </tbody>
                        </table>
                        <br /><br />                        
                    	<table>
                            <thead>
                              <tr>                    
                                <th width="25%">User Group & Permissions</th>
                                <th width="75%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
                            
                              <tr>
                                <td><span class='title_text'>Usergroup:</span></td>
                                <td>
                                <select style="width:50%" name="user_account_groupid_input" id="user_account_groupid_input">
									<?php
                                    // Display the list of current usergroups one could join...
                                    // Last updated: 27th of November for Alpha Two               
                                    $query = $db->query("SELECT * FROM ".TABLE_PREFIX."usergroups");
                                    $result = $db->loop2array($query) ;
                                    foreach($result as $row) 
                                    {
                                        echo '<option ';
                                        if($row['gid'] == $user_account_groupid) 
                                        { 
                                            echo 'selected="selected"'; 
                                        }
                                        echo ' id="'.$row['gid'].'" value="'.$row['gid'].'">';
                                        echo $row['name'].'</option>';
                                    }
                                    ?>
                                </select>
                                </td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Is a Staff Member?</span></td>
                                <td>
                                <input class="radio_input" type="radio" <?php if($row['status']=='1') { echo 'checked="checked"'; }; ?> name="user_account_staff_input" value="1" /> Yes
								<input class="radio_input" type="radio" <?php if($row['status']!='1') { echo 'checked="checked"'; }; ?> name="user_account_staff_input" value="0" /> No
                                </td>
                              </tr>
                              
                              <?php
								if(!$perms->founder($imp->user['uid']))
								{
									$disabled = 'disabled="disabled"';
								}
								if($perms->super_admin($user_id_useredit))
								{
									$checked = ' checked="checked"';
								}
								else
								{
									$checked2 = ' checked="checked"';
								}
							  ?>
                            
                              <tr>
                                <td><span class='title_text'>Super Administrator Status</span></td>
                                <td>
                                <?php echo '
								<input class="radio_input" type="radio" '.$disabled.$checked.' name="user_account_superadmin_input" value="1" /> Yes
								<input class="radio_input" type="radio" '.$disabled.$checked2.' name="user_account_superadmin_input" value="0" /> No</span>';
								?>
                                </td>
                              </tr>
                                                 	
                            </tbody>
                        </table>
                        <br />
                        <div align="center"><input <?php
						if(!$perms->level_check($imp->user['uid'],$user_id_useredit) && $imp->user['uid']!=$user_id_useredit)
						{
							echo "disabled='disabled' ";
						}
						?>name="user_edit" style="width:300px;" id="user_edit" type="submit" value="Save <?php echo $user_account_name ?>'s User Account Data" /></div>
                    </form>
                </div>
            </div>            
        	                  
        </div>
        <!-- MAIN CONTENT STRIP AREA END -->
   	 </div>    
    </div>  
</body>
</html>