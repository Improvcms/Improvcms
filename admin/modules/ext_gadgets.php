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
if(isset($_POST['perfaction']))
{
	$gadget = $db->sanitise($_POST['gadget']);
	if($gadgets->is_active($gadget) && ($_POST['position']=='left' || $_POST['position']=='right' || $_POST['position']=='top'))
	{
		$cache = get_cache('gadgets');
		$cache = unserialize($cache);
		$cache[$gadget]['position'] = $_POST['position'];
		$update = serialize($cache);
		$db->new_update('cache','content='.$update,'name=gadgets');
		$imp->cache['gadgets'] = $update;
	}
	// In this case, check if the gadget still.. exists
	if($gadgets->checkgadget($gadget) && ($_POST['position']=='left' || $_POST['position']=='right' || $_POST['position']=='top'))
	{
		$cache = get_cache('gadgets');
		$cache = unserialize($cache);
		$cache['count']++;
		$cache[$gadget]['position'] = $_POST['position'];
		$cache[$gadget]['place'] = 1;
		$cache['active'][$gadget] = 1;
		$update = serialize($cache);
		$db->new_update('cache','content='.$update,'name=gadgets');
		$imp->cache['gadgets'] = $update;
	}
	unset($gadget);
	unset($cache);
	unset($update);
}
elseif(isset($_POST['switch']))
{
	$gadget = $db->sanitise($_POST['gadget']);
	if($gadgets->is_active($gadget))
	{
		$cache = get_cache('gadgets');
		$cache = unserialize($cache);
		$cache['count']--;
		unset($cache[$gadget]);
		unset($cache['active'][$gadget]);
		$update = serialize($cache);
		$db->new_update('cache','content='.$update,'name=gadgets');
		$imp->cache['gadgets'] = $update;
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gadgets | MillionCMS ACP</title>
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
				<li><a href="ext_manage.php" class="selected"><span><span>Extentions</span></span></a></li>
				<li><a href="general_settings.php"><span><span>Settings</span></span></a></li>
                <li><a href="users.php"><span><span>Users &amp; Accounts</span></span></a></li>
				<li><a href="manager.php"><span><span>Million Manager</span></span></a></li>   
                <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>      
				<li class="last"><a href="http://forums.millioncms.com/"><span><span>Need Help?</span></span></a></li>
			</ul>
		</div>
        <div id="sec_menu">
			<ul>
				<li><a href="ext_manage.php" class="ext_manager">Extension Manager</a></li>
                <li><a href="ext_install.php" class="ext_install_uninstall">Install/Uninstall</a></li>
                <li><a href="ext_plugins.php" class="ext_plugin">Plugins</a></li>
                <li><a href="ext_gadgets.php" class="ext_gadget">Gadgets</a></li>
                <li><a href="ext_bridge.php" class="ext_bridge">Bridge Manager</a></li>
                <li><a href="ext_official.php" class="ext_official">MillionCMS Official</a></li>
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
                    	Help Here
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
                	<h2>Admin Control Panel - Gadgets Manager</h2>
                </div>                
                <div class="contentbox">
                
                	<span class="form_sub_title">Below is a list of gadgets that have been uploaded to the inc/gadgets folder. To activate a gadget, simply click Activate.</span>
                    
                        <table>
                        
                            <thead>
                              <tr>
                              	<th width="20%">Active Gadgets</th>
                                <th width="50%">&nbsp;</th>
                                <th width="30%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
								<?php
                                $loop = $gadgets->getgadgets();
                                if(!is_array($loop))
                                {
                                    echo "<tr><th><span class='title_text'>There are currently no active gadgets</span></th></tr>";
                                }
                                else
                                {
                                    foreach($loop as $row)
                                    {
                                        if($gadgets->is_active($row))
                                        {
                                            $info = $gadgets->get_info($row);
                                            echo "<tr><th><span class='title_text'>{$info['name']}</span></th>
                                            <th><span style='color:#999;'>{$info['description']}</span></th>
                                            <th style='text-align:right;'><form action='{$_SERVER['PHP_SELF']}' method='post'>
                                            <input type='hidden' name='gadget' value='{$row}' />
                                            <select name='position'>
                                            <option selected='selected' value='left'>Left</option>
                                            <option value='right'>Right</option>
                                            <option value='top'>Top</option></select>
                                            &nbsp;&nbsp;
                                            <input type='submit' name='perfaction' value='Update' />
                                            </form><br /><br />
                                            <form action='{$_SERVER['PHP_SELF']}' method='post' />
                                            <input type='hidden' name='gadget' value='{$row}' />
                                            <input type='submit' value='Deactivate' name='switch' />
                                            </form>
                                            </th></tr>";
                                        }
                                        else
                                        {
                                            $unactive[] = $row;
                                        }
                                    }
                                }
                                ?>            	
                            </tbody>
                            
                        </table>
                        <br /><br />
                        <table>
                        
                            <thead>
                              <tr>
                              	<th width="20%">Unactive Gadgets</th>
                                <th width="50%">&nbsp;</th>
                                <th width="30%">&nbsp;</th>
                              </tr>
                            </thead>
                        
                            <tbody>
								<?php
                                    if(!is_array($unactive))
                                    {
                                        echo "<tr><th><span class='title_text'>There are currently no unactive gadgets</span></th></tr>";
                                    }
                                    else
                                    {
                                        foreach($unactive as $row)
                                        {
                                            $info = $gadgets->get_info($row);
                                            echo "<tr><th><span class='title_text'>{$info['name']}</span></th>
                                            <th><span style='color:#999;'>{$info['description']}</span></th>
                                            <th style='text-align:right;'><form action='{$_SERVER['PHP_SELF']}' method='post'>
                                            <input type='hidden' name='gadget' value='{$row}' />
                                            <select name='position'>
                                            <option selected='selected' value='left'>Left</option>
                                            <option value='right'>Right</option>
                                            <option value='top'>Top</option></select>
                                            &nbsp;&nbsp;
                                            <input type='submit' name='perfaction' value='Activate' />
                                            </form>
                                            </th></tr>";
                                        }
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