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
<title>Add a Member | MillionCMS ACP</title>
<?php
$smarty->display("db:header_includes");
?>
</head>
<body>
<?php
$smarty->display("db:header");
?>
<div id="content" style="padding-top:20px;">
	<div id="sidebar">
<?php
$smarty->display("db:sidebar");
?>          
    </div>
     <div id="main">
       <div class="title">Create a Member Account</div>
 	    <div class="section-title"><script>document.write(""+dayarray[day]+", "+montharray[month]+" "+daym+", "+year+"")</script></div>
        <form>
 		 <div class="section-subtitle">General</div>                    
   			 <div class="settings">
     		  <span class="setting"><div class="label">Username:</div><input type="text" /></span>
              <span class="setting"><div class="label">Password:</div><input type="password" /></span>
              <span class="setting"><div class="label">Email:</div><input type="text" /></span>
  		     </div>
         <div class="section-subtitle">Profile</div>
   			 <div class="settings">
     		  <span class="setting"><div class="label">About Me Info:</div><input type="text" /></span>
     		  <span class="setting"><div class="label">Status:</div><input type="text" /></span>
  		     </div>
         <div class="section-subtitle">User Group &amp; Permissions</div>
   			 <div class="settings">
     		  <span class="setting"><div class="label">Primary Usergroup:</div>
              		<select name="prime_usergroup_acp">
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
              </span>
     		  </span>
     		  <span class="setting"><div class="label">Admin Control Panel Access:</div><input type="text" /></span>
     		  <span class="setting"><div class="label">ACP Individual Permissions:</div>Click Here...</span>
  		     </div>
             
         <div align="center"><input name="submit" type="submit" value="Save Changes" /></div>
        </form>
     </div>
     
</div>

<div id="footer">
     <?php include("include/footer.php"); ?>
</div>

</body>
</html>