<span style="float:left; margin-left:15px; display:inline-block;">
	<?php echo "Copyright &copy; 2010 MillionCMS Version "; echo $imp->fversion; ?>
</span>

<span style="float:right; margin-right:15px; display:inline-block;">
<form id="admin_style_selector" name="admin_style_selector" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<label for="admin_style_selector_drop">Style Selection:&nbsp;</label>
	<select name="admin_style_selector_drop" id="admin_style_selector_drop" onchange="this.form.submit()">
		<?php
        if(isset($_POST['admin_style_selector_drop']))
        {
            $admin_style = $db->sanitise(intval($_POST['admin_style_selector_drop']));
            echo $admin_style;
            if(isset($admin_style))
            {
                $db->query("UPDATE ".TABLE_PREFIX."users SET admin_style='{$admin_style}' WHERE uid='{$imp->user['uid']}'");
                $imp->user['admin_style'] = $admin_style;
            }
        }
            echo '<option id="default" ';
            if($imp->user['admin_style']==0)
            {
                echo 'selected="selected" ';
            }
            echo 'value="0">Default</option>';
        $query = $db->query("SELECT * FROM ".TABLE_PREFIX."admin_styles");
        $result = $db->loop2array($query);
        foreach($result as $row) 
        {
            echo '<option ';
            if($row['setid']==$imp->user['admin_style']) 
            { 
                echo 'selected="selected"'; 
            }
            echo ' id="'.$row['setid'].'" value="'.$row['setid'].'">'.$row['fname'].'</option>';
        }
        ?>
	</select>
	<noscript><input type="submit" value="Change Style" name="chgadminstyle" /></noscript>
</form>
</span>

	<?php
		$globend = microtime(true);
		$globtime = $globend - $globstart;
		echo 'Total Database Queries:&nbsp;'.$db->queries.'&nbsp;&nbsp;Generated in: '.$globtime.' seconds';
	?>