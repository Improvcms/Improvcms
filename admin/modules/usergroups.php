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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Usergroup List | ImprovCMS ACP</title>
<link media="screen" rel="stylesheet" type="text/css" href="../css/admin.css" />
<script type="text/javascript" src="../js/behaviour.js"></script>
<script type="text/javascript" src="../js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="../js/current_date.js"></script>
<script type="text/javascript" src="../js/millioncms_admin_panel.jquery.js"></script>
</head>
<body onLoad="show_clock()">

<?php
$newugroup = false;
if(isset($_POST['create_usergroup']))
{
	if(!empty($_POST['ugroup-name']) && !empty($_POST['ugroup-desc']))
	{
		$name = $db->sanitise($_POST['ugroup-name']);
		$desc = $db->sanitise($_POST['ugroup-desc']);
		$new = array('name' => $name,'description' => $desc);
		$db->query("INSERT INTO ".TABLE_PREFIX."usergroups (name,description) VALUES ('{$name}','{$desc}') ");
		$detail['prev'] = null;
		$detail['post'] = $new;
		$detail['fields'] = array();
		$detail['fields'][] = 'name';
		$detail['fields'][] = 'description';
		$details = serialize($detail);
		$time = time();
		$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','usergroups.php','{$imp->user['uid']}','{$_SERVER['REMOTE_ADDR']}','insert','usergroups','{$details}') ");
		$newugroup = true;
	}
}
if($newugroup)
{
	echo '<div class="notification success">
          <a href="#" class="close"><img src="../images/cross_grey_small.png" title="Close this notification" alt="close" /></a>
          <div>
          	The usergroup has successfully been created!
          </div>
       	  </div>';
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
                	<h2>Admin Control Panel - Group List</h2>
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
                            <th width="5%">GID #</th>                    
                            <th width="20%">Group Name</th>                    
                            <th width="50%">Description</th>                    
                            <th width="10%">Image</th>                    
                            <th width="15%">Actions</th>
                          </tr>
                       </thead>
                    
                       <tbody>                       
                        
						<?php
                        $query = $db->query("SELECT * FROM ".TABLE_PREFIX."usergroups");
                        $result = $db->loop2array($query);
                        foreach($result as $row) 
                        {
                            $lowgroup = strtolower($row['name']);
                            
                            $ava = "../../images/groups/{$lowgroup}.png";
                            if (file_exists($ava)) {
                                $ava = "<img src='../../images/groups/{$lowgroup}.png' style='max-height:40; vertical-align:middle;' width='45' />";
                            } else {
                                $ava = "No Group Image";
                            }
                            
                            echo '
                            <form name="usergroup_list_id_'.$row['gid'].'" id="usergroup_list_'.$row['gid'].'" action="usergroups_edit.php" method="post">
                            <tr><td>'.$row['gid'].'</td>
                            <td><strong>'.$row['name'].'</strong></td>
                            <td>'.$row['description'].'</td>
                            <td>'.$ava.'</td>
                            <td>
                            <a href="usergroups_edit.php?gid='.$row['gid'].'" class="edit">Edit</a>
                            <a href="#" class="delete">Delete</a>
                            </td>
                            </tr>
                            </form>';
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