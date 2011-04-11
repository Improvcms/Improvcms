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
<?php $smarty->display("db:header_includes"); ?>
</head>
<body>
<!-- Message's for User -->
  <div id="msg_saved" style="display:none;"> The user infomation has been saved!</div>
  <div id="msg_groupleverror" style="display:none;"> You may not move users to groups higher than your own!</div>
<!-- End Message's for User -->
<?php
// Success Message or error message
if ($_GET['action']=='done' && $_GET['error']=='grouplev')
{
	echo '<script type="text/javascript">$(document).ready(function () {$("#msg_groupleverror").twitter_alert({fadeout_time: 3500}); }); </script>';
}
elseif ($_GET['action']=='done')
{
	echo '<script type="text/javascript">$(document).ready(function () {$("#msg_saved").twitter_alert({fadeout_time: 3500}); }); </script>';
}
if ($_GET['action']=='delete_user')
{
	if(!empty($_GET['uid']))
	{
		$uid = $db->sanitise($_GET['uid']);
		if(confirm_user($uid) && !$perms->super_admin($uid) && !$perms->cross_check("can_access_admincp",$uid) && $perms->level_check($mcms->user['uid'],$uid))
		{
			$query = $db->query("SELECT * FROM ".TABLE_PREFIX."users WHERE uid='{$uid}'");
			$backup = $db->fetch_array($query);
			$db->query("DELETE FROM ".TABLE_PREFIX."users WHERE uid='{$uid}'");
			$detail['prev'] = $backup;
			$detail['record'] = $uid;
			$detail['post'] = null;
			$details = serialize($detail);
			$time = time();
			$db->query("INSERT INTO ".TABLE_PREFIX."admin_logs (time,script,uid,ipaddress,action,itable,detail) VALUES ('{$time}','users.php','{$mcms->user['uid']}','{$_SERVER['REMOTE_ADDR']}','delete','users','{$details}') ");
			redirect('./users.php?action=done');
		}
	}
}
$smarty->display("db:header");
?>
<div id="content" style="padding-top:20px;">
	<div id="sidebar">
<?php 
$smarty->display("db:sidebar");
?>
    </div>
     <div id="main">
       <div class="title">User Account List</div>
 	    <div class="section-title"><script>document.write(""+dayarray[day]+", "+montharray[month]+" "+daym+", "+year+"")</script></div>
         <div class="section-subtitle">Current Accounts</div>                    
	   <div class="settings">
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
					// Let's fetch the user's infomation...
					$avatar_image = getavatar($row['uid']);
					$user_list_uid = $row['uid'];
					$user_list_gid = $row['gid'];
					$user_list_username = $row['username'];
					$user_list_email = $row['email'];
					$mFounder = 0;
					
					// Now place a user in one bar, and repeat...
                    echo '<form name="user_list_id_'.$user_list_uid.'" id="user_list_'.$user_list_uid.'" action="users_edit.php" method="post">';
					// Usergroup shading for staff and banned users...
					echo '<span class="setting';
					if($perms->founder($row['uid']))
					{
						$mFounder = 1;
					}
					if($row['superadmin']==1 || $mFounder==1)
					{
						// Do nothing.
					}
					elseif($row['status']=='1') 
					{
						echo '_staff';
					}
					elseif($row['status']=='2') 
					{
						echo '_red';
					}
					echo '">';
					echo '<div class="label">#'.$user_list_uid.'<strong>&nbsp;&nbsp;';
					if($row['superadmin']==1 || $mFounder==1)
					{
						echo '<span style="color:purple;">';
					}
					echo $user_list_username;
					if($row['superadmin']==1 || $mFounder==1)
					{
						echo '</span>';
					}
					echo '</strong></div>';
						// This checks if the user has a avatar, and then displays said avatar, or the no-avatar avatar!
						if (file_exists($avatar_image)) {
							echo "<div class='avatar_block' align='center'><img src='".$avatar_image."' style='max-height:40; vertical-align:middle;' width='45' /></div>";
						} else {
							echo "<div class='avatar_block' align='center'>&ndash;</div>";
						}
					echo ''.$user_list_email.'&nbsp;
                    <span style="float:right">
                    <input type="hidden" id="user_list_id" name="user_list_id" value="'.$user_list_uid.'">
                    <input id="image_button" type="image" src="../icons/pencil_go.png" width="16" height="16">&nbsp;
                    <a onClick=\'javascript:return confirm("Are you sure you want to permanently delete this user?
					Warning: Once this user is removed, IT CANNOT BE RESTORED. Take care in deleting users.")\' href="?action=delete_user&amp;uid='.$user_list_uid.'"><img class="delete_button" src="../icons/delete.png" width="16" height="16" /></a>
                    </span>
                    </span>
                    </form>';
                }
                ?>			
       </div>
         <div align="right" style="margin-right:10px;"><span style="font-size:12px; text-align:right; color:red">&shy;&nbsp;A red user is a banned member<br />
		 &shy;&nbsp;<span style="color:green;">A green user is a staff member<br />
		 &shy;&nbsp;<span style="color:purple;">A purple user is a super administrator</span></div>
         
          <form name="create_user" id="create_user">
  		  <div class="section-subtitle">Create a User</div>                   
   			 <div class="settings">
     		  <span class="setting"><div class="label">User Name:</div><input type="text" /></span>
              <span class="setting">
              <div class="label">Password:</div><input type="text" /></span>
              <input name="create_user" id="create_user" type="button" disabled value="Create User and Edit Profile" />
  		     </div>
         </form>
             
         <br />
        
     </div>
</div>
<div id="footer">
     <?php include("include/footer.php"); ?>
</div>
</body>
</html>