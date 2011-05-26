<?php
/*
	ImprovCMS Project
    
	Name: Improv Manager
	Version: Development
	Description: One file that contains all the data for each Improv 
	Manager page.
	Last Update: Never

	Author: Kyuubi (modified by Azareal)


	Copyright Kyuubi, Azareal and the Improv Software Group (C) 2010


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

// Require Global
define("IN_MILLION", "1");
define("IN_ADMIN","1");
require_once('../../global.php');
require_once('./include/functions.php');
// Before the user can do anything here, check if the user is actually an administrator
if(!$is_admin) 
{
	die($error->perms(20));
}
if(isset($_POST['cleartcache']))
{
	$smarty->clearAllCache();
}
elseif(isset($_POST['clearccache']))
{
	clearcompiled();
}
elseif(isset($_POST['clearucache']))
{
	$path = ROOT.'/cache/users';
	if($handle = opendir($path))
	{
		while(false!==($file=readdir($handle))) 
		{
			$fileinfo = pathinfo($path."/{$file}");
			if($fileinfo['extension']=='php')
			{
				unlink($path."/{$file}");
			}
			unset($file);
			unset($fileinfo);
		}
		closedir($handle);
	}
	unset($path);
	unset($handle);
}
elseif(isset($_POST['cleargcache']))
{
	$path = ROOT.'/cache/groups';
	if($handle = opendir($path))
	{
		while(false!==($file=readdir($handle))) 
		{
			$fileinfo = pathinfo($path."/{$file}");
			if($fileinfo['extension']=='php')
			{
				unlink($path."/{$file}");
			}
			unset($file);
			unset($fileinfo);
		}
		closedir($handle);
	}
	unset($path);
	unset($handle);
}
elseif(isset($_POST['regeneratesettings']))
{
	$imp->cache_settings();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Million Manager | MillionCMS ACP</title>
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
				<li><a href="general_settings.php"><span><span>Settings</span></span></a></li>
                <li><a href="users.php"><span><span>Users &amp; Accounts</span></span></a></li>
				<li><a href="manager.php" class="selected"><span><span>Million Manager</span></span></a></li>   
                <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>      
				<li class="last"><a href="http://forums.millioncms.com/"><span><span>Need Help?</span></span></a></li>
			</ul>
		</div>
        <div id="sec_menu">
			<ul>
				<li><a href="manager.php?action=menu" class="menu_m">Menu Manager</a></li>
                <li><a href="manager.php?action=files" class="files_m">Files Manager</a></li>
                <li><a href="manager.php?action=language" class="language_m">Language Manager</a></li>
                <li><a href="manager.php?action=backup" class="backup_m">Backup Manager</a></li>
                <li><a href="manager.php?action=cache" class="cache_m">Cache Manager</a></li>
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
                	<h2>Admin Control Panel - Million Manager</h2>
                </div>                
                <div class="contentbox">
                
                <?php
				// Start File
				if($_GET['action']=='menu')
				{
				?>
                
                    	<table>
                            <thead>
                              <tr>                    
                                <th width="25%">Menu Manager</th>
                                <th width="75%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                                                 	
                            </tbody>
                        </table>
                        
                 	<?php
					}
					elseif($_GET['action']=='files')
					{
					?>
                
                    	<table>
                            <thead>
                              <tr>                    
                                <th width="25%">File's Manager</th>
                                <th width="75%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                                                 	
                            </tbody>
                        </table>
                        
                 	<?php
					}
					elseif($_GET['action']=='language')
					{
					?>
                
                    	<table>
                            <thead>
                              <tr>                    
                                <th width="25%">Language Manager</th>
                                <th width="75%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                                                 	
                            </tbody>
                        </table>
                        
                 	<?php
					}
					elseif($_GET['action']=='backup')
					{
					?>
                
                    	<table>
                            <thead>
                              <tr>                    
                                <th width="25%">Backup Manager</th>
                                <th width="75%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Text</span></td>
                                <td>Text</td>
                              </tr>
                                                 	
                            </tbody>
                        </table>
                        
                 	<?php
					}
					elseif($_GET['action']=='cache')
					{
					?>
                		<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=cache" method="post" />
                    	<table>
                            <thead>
                              <tr>                    
                                <th width="25%">Cache Manager</th>
                                <th width="75%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
                            
                              <tr>
                                <td><span class='title_text'>Clear Template Cache:</span></td>
                                <td><input size="50" type="submit" name="cleartcache" value="Execute" /></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Delete Compiled Templates:</span></td>
                                <td><input size="50" type="submit" name="clearccache" value="Execute" /></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Clear User Cache:</span></td>
                                <td><input size="50" type="submit" name="clearucache" value="Execute" /></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Clear Groups Cache:</span></td>
                                <td><input size="50" type="submit" name="cleargcache" value="Execute" /></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Regenerate Settings Cache:</span></td>
                                <td><input size="50" type="submit" name="regeneratesettings" value="Execute" /></td>
                              </tr>
                                                 	
                            </tbody>
                        </table>
                        </form>
                    <?php
					}
					else {
					?>
                
                    	<table>
                            <thead>
                              <tr>                    
                                <th width="25%">Million Manager</th>
                                <th width="75%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
                            
                              <tr>
                                <td><span class='title_text'>Menu Manager</span></td>
                                <td><a href="manager.php?action=menu"><input type="button" value="Go There..." /></a></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Files Manager</span></td>
                                <td><a href="manager.php?action=files"><input type="button" value="Go There..." /></a></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Language Manager</span></td>
                                <td><a href="manager.php?action=language"><input type="button" value="Go There..." /></a></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Backup Manager</span></td>
                                <td><a href="manager.php?action=backup"><input type="button" value="Go There..." /></a></td>
                              </tr>
                            
                              <tr>
                                <td><span class='title_text'>Cache Manager</span></td>
                                <td><a href="manager.php?action=cache"><input type="button" value="Go There..." /></a></td>
                              </tr>
                                                 	
                            </tbody>
                        </table>
                        
                    <?php			
					}
					?>
                        
                </div>
            </div>            
        	                  
        </div>
        <!-- MAIN CONTENT STRIP AREA END -->
   	 </div>    
    </div>  
</body>
</html>