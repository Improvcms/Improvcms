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
$userwhere = '';
if($_GET['status']=='inactive')
{
	$userwhere = " WHERE activationkey!='0'";
}
elseif($_GET['status']=='online')
{
	$lastcutoff = time()-(60*15);
	$userwhere = " WHERE lastactive>={$lastcutoff}";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Account List | MillionCMS ACP</title>
<link media="screen" rel="stylesheet" type="text/css" href="../css/admin.css" />
<script type="text/javascript" src="../js/behaviour.js"></script>
<script type="text/javascript" src="../js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="../js/current_date.js"></script>
<script type="text/javascript" src="../js/millioncms_admin_panel.jquery.js"></script>
</head>
<body onLoad="show_clock()">

<?php
if ($_GET['action']=='delete_user')
{
	if(!empty($_GET['uid']))
	{
		$uid = $db->sanitise($_GET['uid']);
		if(confirm_user($uid) && !$perms->super_admin($uid) && !$perms->cross_check("can_access_admincp",$uid) && $perms->level_check($imp->user['uid'],$uid))
		{
			$query = $db->query("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='{$uid}'");
			$backup = $db->fetch_array($query);
			$db->query("DELETE FROM ".TABLE_PREFIX."users WHERE uid='{$uid}'");
			$detail['prev'] = $backup;
			$detail['record'] = $uid;
			$detail['post'] = null;
			$details = serialize($detail);
			$time = time();
			$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','users.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','delete','users','{$details}') ");
			redirect('./users.php?action=done');
		}
	}
}
$newuser = false;
if(isset($_POST['create_user']))
{
	if(!empty($_POST['username']) && !empty($_POST['password']))
	{
		$username = $db->sanitise($_POST['username']);
		$password = $db->sanitise($_POST['password']);
		$salt = random_str(10);
		$finpassword = md5($salt.md5($password.$salt));
		$finpassword = md5($finpassword);
		$time = time();
		$new = array('username' => $username,'password' => $finpassword,'salt' => $salt,'lastactive' => $time,'ipaddress' => $_SERVER['REMOTE_ADDR'],'gid' => 2);
		$db->query("INSERT INTO ".TABLE_PREFIX."users (username,password,salt,ipaddress,lastactive,gid) VALUES ('{$username}','{$finpassword}','{$salt}','{$_SERVER['REMOTE_ADDR']}','{$time}','2') ");
		$newid = mysql_insert_id();
		$detail['prev'] = null;
		$detail['post'] = $new;
		$detail['fields'] = array();
		$detail['fields'][] = 'username';
		$detail['fields'][] = 'password';
		$detail['fields'][] = 'salt';
		$detail['fields'][] = 'ipaddress';
		$detail['fields'][] = 'lastactive';
		$detail['fields'][] = 'gid';
		$details = serialize($detail);
		$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','users.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','insert','users','{$details}') ");
		$newuser = true;
	}
}
if($newuser)
{
redirect('users_edit.php?uid='.$newid,0);
}
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
                	<h2>Admin Control Panel - User &amp; Account List</h2>
                </div>                
                <div class="contentbox">
                
                <?php
				// Success Message or error message
				if ($_GET['action']=='done' && $_GET['error']=='grouplev')
				{
					echo '<div class="notification attention">
						  <a href="#" class="close"><img src="../images/cross_grey_small.png" title="Close this notification" alt="close" /></a>
						  <div>
							You may not move users to groups higher than your own!
						  </div>
						  </div>';
				}
				elseif ($_GET['action']=='done')
				{
					echo '<div class="notification success">
						  <a href="#" class="close"><img src="../images/cross_grey_small.png" title="Close this notification" alt="close" /></a>
						  <div>
							Settings have been successfully updated and saved!
						  </div>
						  </div>';
				}
				?>
                      
                    <table>
                       <thead>
                          <tr>                    
                            <th width="5%">ID #</th>                    
                            <th width="35%">Account Name</th>                    
                            <th width="35%">Account Email</th>                    
                            <th width="10%">Avatar</th>                    
                            <th width="15%">Actions</th>
                          </tr>
                       </thead>
                    
                       <tbody>                       
                        
                       <form action="users_edit.php" method="post" />
                                <?php
                                // Userlist
                                $query = $db->query("SELECT * FROM ".TABLE_PREFIX."users{$userwhere}");                    
                                $result = $db->loop2array($query);
                                if(!is_array($result))
                                {
                                    $result = array();
                                }
                                foreach($result as $row)
                                {
                                    $avatar_image = getavatar($row['uid']);
                                    $user_list_uid = $row['uid'];
                                    $user_list_gid = $row['gid'];
                                    $user_list_username = $row['username'];
                                    $user_list_email = $row['email'];
                                    // Set initial value for founder check.
                                    $mFounder = 0;
                                    // Let's get started!
                                    echo '<tr><td>'.$user_list_uid.'</td>';
                                    // Usergroup shading for staff and banned users...
                                    echo '<td><strong>';
                                    if($perms->founder($row['uid']))
                                    {
                                        $mFounder = 1;
                                    }
                                    elseif($row['status']=='0') 
                                    {
                                        // Part of the member group.
                                        echo '<span style="color:black;">';
                                    }
                                    elseif($row['status']=='1') 
                                    {
                                        // Part of the staff.
                                        echo '<span style="color:green;">';
                                    }
                                    elseif($row['status']=='2') 
                                    {
                                        // Banned user who has been bad.
                                        echo '<span style="color:red;">';
                                    }
                                    if($row['superadmin']==1 || $mFounder==1)
                                    {
                                        // Founder colour.
                                        echo '<span style="color:purple;">';
                                    }
                                    echo $user_list_username;
                                    echo '</span></strong></td>';
                                    echo '<td>'.$user_list_email.'&nbsp;</td>';
                                    // This checks if the user has a avatar, and then displays said avatar, or the no-avatar avatar!
                                    if (file_exists($avatar_image)) {
                                        echo "<td><img src='".$avatar_image."' style='max-height:40; vertical-align:middle;' width='45' /></td>";
                                    } else {
                                        echo "<td>No Avatar</td>";
                                    }
                                    echo '<td><a href="users_edit.php?uid='.$user_list_uid.'" class="edit">Edit</a>&nbsp;';
                                    if($row['superadmin']!=1 && $mFounder!=1 && $row['status']!=1)
                                    {
                                        echo '<a onClick=\'javascript:return confirm("Are you sure you want to permanently delete this user?
                                        Warning: Once this user is removed, IT CANNOT BE RESTORED. Take care in deleting users.")\' href="?action=delete_user&amp;uid='.$user_list_uid.'" class="delete">Delete</a>';
										echo '<a href="#" class="reset">Ban User</a></td></tr>';
                                    }
                                    echo '<!--<input type="checkbox" value="'.$user_list_uid.'" name="actionuids[]" />--></span>';
                                }
                                ?>
                        </form>  
                    
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