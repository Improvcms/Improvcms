<?php
//Require the Global Loader
define("IN_MILLION", "1");
define("IN_ADMIN","1");
require_once('../../global.php');
// Before the user can do anything here, check if the user is actually an administrator
if(!$is_admin) 
{
	die($error->perms(20));
}
elseif(!$perms->check_perms("admin:can_edit_usergroups"))
{
	die($error->perms(21));
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit a Group | MillionCMS ACP</title>
<link media="screen" rel="stylesheet" type="text/css" href="../css/admin.css" />
<script type="text/javascript" src="../js/behaviour.js"></script>
<script type="text/javascript" src="../js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="../js/current_date.js"></script>
<script type="text/javascript" src="../js/millioncms_admin_panel.jquery.js"></script>
</head>
<body onLoad="show_clock()">

<?php
// Get the UserID to grab his info from database...
$user_group_id = $db->sanitise(intval($_REQUEST['gid']));
// Run the query, expecting some sort of infomation...
$query = $db->query("SELECT * FROM ".TABLE_PREFIX."usergroups WHERE gid='{$user_group_id}'");
$row = $db->fetch_array($query);
// If we get that infomation, lets make the var's for the form below!
$user_group_name = $row['name'];
$user_group_description = $row['description'];
$user_group_adminlevel = $row['adminlevel'];
$user_group_permissions = unserialize($row['permissions']);
?>

<?php
$lowgroup = strtolower($user_group_name);
$ava = "<img src='../../images/groups/{$lowgroup}.png' style='max-height:40; vertical-align:middle;' width='45' />";
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
                	<h2><span style="float:left;">Admin Control Panel - Usergroup Editing - <?php echo $user_group_name; ?></span><span style="float:right; margin-right:15px;">GID #<?php echo $user_group_id; ?></span></h2>
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
                                <td><span class='title_text'>Group Name:</span></td>
                                <td><input style="width:50%" type="text" name="user_account_name_input" id="user_account_name_input" value="<?php echo $user_group_name ?>" /></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Group Description:</span></td>
                                <td><input style="width:50%" type="text" name="user_account_password_input" id="user_account_password_input" value="<?php echo $user_group_description ?>" /></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Group Icon (URL):</span></td>
                                <td><input readonly="readonly" id="group_icon" name="group_icon" style="width:50%" type="text" value="<?php echo $imp->settings['siteurl'].'images/groups/'.strtolower($user_group_name).'.png'; ?>" /></td>
                              </tr>
                              
                              <?php
								if(!$perms->check_perms("can_edit_adminlevels"))
								{
								$disablealevel = 'disabled="disabled"';
								}
							  ?>
                            
                              <tr>
                                <td><span class='title_text'>Group Admin 'Level':</span></td>
                                <td><input style="width:50%" <?php echo $disablealevel; ?> type="text" name="user_account_title_input" id="user_account_title_input" value="<?php echo $user_group_adminlevel ?>" /></td>
                              </tr>
                                                 	
                            </tbody>
                        </table>
                        <br /><br />                        
       	      <table>
                            <thead>
                              <tr>                    
                                <th width="25%">Permissions (Public)</th>
                                <th width="75%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
                            
                              	<?php include("../../cache/permlist.php"); ?>
                                <!-- Yes is 1 and No is 0 -->
                                <?php
                                //$confirm = $perms->fetch_perms('usergroup',$user_group_id);
                                $confirm = $user_group_permissions;
                                foreach($regpermissions as $row) 
                                {
                                    if($confirm[$row]==1)
                                    {
                                        $checked = 'checked="checked"';
                                    }
                                    else
                                    {
                                        $checked2 = 'checked="checked"';
                                    }
                                    echo '<tr><td><span class="title_text">'.$row.'</span>:</td>
                                    <td><input class="radio_input" type="radio" '.$checked.' name="'.$row.'" id="1" value="1" /> Yes
                                    <input class="radio_input" type="radio" '.$checked2.' name="'.$row.'" id="0" value="0" /> No</td></tr>';
                                    unset($checked);
                                    unset($checked2);
                                }
                                ?>
                                                 	
                            </tbody>
                        </table>
                        <br /><br />                        
                   	   <table>
                            <thead>
                              <tr>                    
                                <th width="25%">Permissions (Admin)</th>
                                <th width="75%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
                            
							<?php
                            if(!$perms->check_perms("can_edit_adminperms"))
                            {
                                $disabled = 'disabled="disabled"';
                            }
                            foreach($adminpermissions as $row) 
                            {
                                if($confirm[$row]==1)
                                {
                                    $checked = 'checked="checked"';
                                }
                                else
                                {
                                    $checked2 = 'checked="checked"';
                                }
                                $name = str_replace('admin:','',$row);
                                echo '<tr><td><span class="title_text">'.$name.'</span>:</td>
                                <td><input type="radio" '.$disabled.' '.$checked.' name="'.$row.'" id="1" value="1" /> Yes
                                <input type="radio" '.$disabled.' '.$checked2.' name="'.$row.'" id="0" value="0" /> No</td>';
                                unset($checked);
                                unset($checked2);
                            }
                            ?>
                                                 	
                            </tbody>
                        </table>
                        <br />
                        <div align="center">
                        <input <?php
						if(!$perms->level_check($imp->user['gid'],$user_group_id,'gid')===true && !$perms->super_admin($imp->user['uid']))
						{
							echo "disabled='disabled' ";
						}
						?>name="usergroup_edit" style="width:300px;" id="usergroup_edit" type="submit" value="Save <?php echo $user_group_name ?>'s Usergroup Data" />
                        </div>
                    </form>
                </div>
            </div>            
        	                  
        </div>
        <!-- MAIN CONTENT STRIP AREA END -->
   	 </div>    
    </div>  
</body>
</html>