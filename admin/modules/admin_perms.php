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
<title>Edit a Group | ImprovCMS ACP</title>
<?php $smarty->display("db:header_includes"); ?>
</head>
<body>
<?php $smarty->display("db:header"); ?>
<div id="content" style="padding-top:20px;">
	<div id="sidebar">
<?php $smarty->display("db:sidebar"); ?>            
    </div>
     <div id="main">
       <div class="title">User-Group Editing - *Group Name*</div>
 	    <div class="section-title"><script>document.write(""+dayarray[day]+", "+montharray[month]+" "+daym+", "+year+"")</script>
           <span style="float:right; text-align:right;">
            User-Group ID: #
           </span>
        </div>
 		 <div class="section-subtitle">General</div>                    
   			 <div class="settings">
     		  <span class="setting"><div class="label">Username:</div><input size="50" type="text" /></span>
              <span class="setting"><div class="label">Username:</div><input size="50" type="text" /></span>
              <span class="setting"><div class="label">Username:</div><input size="50" type="text" /></span>
              <span class="setting"><div class="label">Username:</div><input size="50" type="text" /></span>
              <span class="setting"><div class="label">Username:</div><input size="50" type="text" /></span>
  		     </div><br />
     </div>
</div>
<div id="footer">
     <?php include("include/footer.php"); ?>
</div>
</body>
</html>