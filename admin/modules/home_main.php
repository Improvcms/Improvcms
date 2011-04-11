<?php
/*
	MillionCMS Project

	Name: AdminCP Home
	Version: Development
	Description: The homepage for the advanced design AdminCP
	Last Update: Never 

	Author: Damian, Kyuubi, Azareal.


	Copyright Damian, Kyuubi, Azareal + MillionCMS Group © 2010


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
if (!$is_admin)
{
	error("You do not have permission to view this page.");
	redirect("../index.php");
	exit;
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
		$detail['post'] = stripslashes($admin_notes);
		$detail['where'] = 'name';
		$details = serialize($detail);
		$time = time();
		$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','home_main.php','{$mcms->user['uid']}','{$_SERVER['REMOTE_ADDR']}','update','cache','{$details}') ");
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
<title>Admin Home | MillionCMS ACP</title>
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
        	<span id="logo" style="color:#0CF; font-size:42px; margin-top:10px;"><?php echo $mcms->settings['site_name'] ?><br /><span style=" color:#999; font-size:20px; float:right;">Administration Panel</span></span>
        <div id="user_details">

        <ul id="user_details_menu">
        	<br />
			<li>Welcome <strong><?php echo $mcms->user['username'] ?></strong></li>
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
        
        <div class="notification success">
        <a href="#" class="close"><img src="../images/cross_grey_small.png" title="Close this notification" alt="close" /></a>
            <div>
            	You are using Alpha 3 Development of MillionCMS. Please report any bugs or features you would like added on our forums.
            </div>
        </div>
                
            <div class="contentcontainer" style="margin-left:1%; margin-right:1%;">  
                <div class="headings">
                	<h2>Your Website - Information Bar</h2>
                </div>
					<?php
						$lastcutoff = time()-(60*15);
						$online_member_count = $db->count("SELECT uid FROM ".TABLE_PREFIX."users WHERE lastactive>={$lastcutoff}");
						if ($online_member_count == '1') $member_title = 'member';
						else $member_title = 'members';						
					?>           
                <div class="contentbox_info">
                	<div class="col_1">
                    	<span class="col_big_text"><a href="./users.php"><?php echo $db->count("SELECT uid FROM ".TABLE_PREFIX."users");?></a></span>&nbsp;&nbsp;&nbsp;<span class="col_nrm_text">total members</span>
                    </div>
                    <div class="col_2">
                    	<span class="col_big_text"><a href="./users.php?status=online"><?php echo $online_member_count ?></a></span>&nbsp;&nbsp;&nbsp;<span class="col_nrm_text">online <?php echo $member_title ?></span></div>
                    <div class="col_3">
                    	<span class="col_big_text"><a href="#"><?php echo $db->count("SELECT pid FROM ".TABLE_PREFIX."pages");?></a></span>&nbsp;&nbsp;&nbsp;<span class="col_nrm_text">total articles</span>
                    </div>
                    <div class="col_4">
                    	<span class="col_big_text"><a href="#"><?php echo get_server_load(); ?></a></span>&nbsp;&nbsp;&nbsp;<span class="col_nrm_text">server load</span>
                    </div>
                </div>
            </div>
    
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
                        <br />
                        Welcome infomation here...
                    </div>
                </div>
                        
                <div class="contentcontainer">
                    <div class="headings">
                        <h2>Quick Admin Search</h2>
                    </div>                
                    <div class="contentbox">
                    	<span style="font-size:14px">Chose one feild to search in, type your query and hit 'Search'.</span><br /><br />
                    	<form id name="quick_acp_search" style="text-align:center;">
                        	<input type="text" value="Member Search" /><br /><br />
                        	<input type="text" value="Setting Search" /><br /><br />
                        	<input type="text" value="IP Address Search" /><br /><br /><br /> 
                            <input type="submit" value="Search" />                                                     
                        </form>
                    </div>
                </div>
                
                <div class="contentcontainer">
                    <div class="headings">
                        <h2>MillionCMS News Feed</h2>
                    </div>                
                    <div class="contentbox">
                    	<script language="JavaScript" src="http://itde.vccs.edu/rss2js/feed2js.php?src=http%3A%2F%2Fforums.millioncms.com%2Fsyndication.php%3Ffid%3D2%26limit%3D2+&chan=n&num=2&desc=0&date=y&targ=y" type="text/javascript"></script>

<noscript>
<a href="http://itde.vccs.edu/rss2js/feed2js.php?src=http%3A%2F%2Fforums.millioncms.com%2Fsyndication.php%3Ffid%3D2%26limit%3D2+&chan=n&num=2&desc=0&date=y&targ=y&html=y">View RSS feed</a>
</noscript>

                    </div>
                </div>
                
                <div class="contentcontainer">               
                    <div class="contentbox_no_head">
                    		<?php
								$globend = microtime(true);
								$globtime = $globend - $globstart;
							?>
                    	<strong>MillionCMS</strong><br />
                        Copyright &copy; 2010-2011<br /><br />                        
                        Script executed in <?php echo $globtime ?>s<br />
                        <?php echo $db->queries ?> SQL queries used<br /><br />
                        Version: <?php echo $mcms->fversion; ?><br />
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
                	<h2>Admin Control Panel - Home</h2>
                </div>                
                <div class="contentbox">
               	  <div style="float:left; width:48%; margin-left:1%; margin-right:1%;">
                   	  <span class="form_sub_title">Admin Notes</span>
                      <?php
						// Success Message
						if ($_GET['action']=='notes_done') {echo '
							<div class="notification success">
        					<a href="#" class="close"><img src="../images/cross_grey_small.png" title="Close this notification" alt="close" /></a>
           					<div>
            					Your Admin Notes have been successfully saved! 
            				</div>
       						</div>
						';}
					  ?>
                    	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                   	    <textarea class="notes" name="admin_notes" id="textarea" style="width:100%; height:200px;"><?php echo get_cache('admin_notes'); ?></textarea>
               	      <br /><br />
               				<input class="input" name="insert_notes" type="submit" value="Save Notes"/><br /><br /><br /><br />
            			</form>
                        
                    	<span class="form_sub_title">Latest Admin Login</span>
                        	<?php $ccache = unserialize(get_cache('lastadminlogins')); echo "Was by {$ccache['name']} at ".date('G\:i A',$ccache['time'])." on the ".date('F j, Y',$ccache['time'])."."; ?>
                  </div>
                	<div style="float:right; width:48%; margin-left:1%; margin-right:1%;">
                    	<span class="form_sub_title">Website Infomation Center</span>
                        <table>
                        <tr>
                          <td>
                            <span class="form_sub_title_nb">
                              Member Infomation
                            </span>
                          </td>
                          <td>&nbsp;
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="text">Total Members:
                            </span>
                          </td>
                          <td>
                            <span class="text"><a href="./users.php"><?php echo $db->count("SELECT uid FROM ".TABLE_PREFIX."users");?></a>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="text">Online Members:
                            </span>
                          </td>
                          <td>
                            <span class="text"><a href="./users.php?status=online">
                            <?php
                            $lastcutoff = time()-(60*15);
                            echo $db->count("SELECT uid FROM ".TABLE_PREFIX."users WHERE lastactive>={$lastcutoff}");?></a>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="text">Awaiting Validation:</span>
                          </td>
                          <td>
                            <span class="text"><a href="./users.php?status=inactive"><?php echo $db->count("SELECT uid FROM ".TABLE_PREFIX."users WHERE activationkey!='0'");?></a>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="form_sub_title_nb">
                              Article Infomation
                            </span>
                          </td>
                          <td>&nbsp;
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="text">Total Articles:
                            </span>
                          </td>
                          <td>
                            <span class="text"><?php echo $db->count("SELECT pid FROM ".TABLE_PREFIX."pages");?>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="form_sub_title_nb">
                              Article Comment Infomation
                            </span>
                          </td>
                          <td>&nbsp;
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="text">Total Comments:
                            </span>
                          </td>
                          <td>
                            <span class="text"><?php echo $db->count("SELECT cid FROM ".TABLE_PREFIX."comments");?>
                            </span>
                          </td>
                        </tr>
                        <tr>
                            <td><span class="form_sub_title_nb">Technical Statistics</span></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><span class="text">Server Load:</span></td>
                            <td><span class="text"><?php echo get_server_load(); ?></span></td>
                        </tr>             
                	</table>
                    </div>
                    <br /><br />
                    
                </div>
            </div>
            
        	<div class="contentcontainer">
            	<div class="headings">
                	<h2>The MillionCMS Team</h2>
              </div>                
                <div class="contentbox">
                
                                    <table width="100%" cellpadding="10px" cellspacing="0"> 
           <tr> 
             <th width="25%" scope="col"><b>Management</b></th> 
             <th width="25%" scope="col"><b>Development Team</b></th> 
             <th width="25%" scope="col"><b>SQA Team</b></th> 
           </tr> 
           <tr> 
             <td>Kyuubi</td> 
             <td>Firestar</td> 
             <td>Austin</td> 
           </tr> 
           <tr class="alt"> 
             <td></td> 
             <td>Rob Chambers</td> 
             <td>Malietjie</td> 
           </tr>
            </table> 
         </table> 
                </div>
            </div>
                   
        </div>
        <!-- MAIN CONTENT STRIP AREA END -->
   	 </div>    
    </div>  
</body>
</html>