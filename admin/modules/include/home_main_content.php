<br />
<br />
<table width="100%" border="0">
  <tr>
    <td width="25%">
      <img src="../icons/cog_edit.png" width="16" height="16"/> 
      <a href="general_settings.php">Edit System Settings
      </a>
    </td>
    <td width="25%">
      <img src="../icons/comments.png" width="16" height="16"/> 
      <a href="add_article.php">Add Article
      </a>
    </td>
    <td width="25%">
      <img src="../icons/key.png" width="16" height="16"/> 
      <a href="adminlogs.php">View Admin Logs
      </a>
    </td>
    <td width="25%">
      <img src="../icons/palette.png" width="16" height="16"/> 
      <a href="template_m_home.php">Theme Manager
      </a>
    </td>
  </tr>
  <tr>
    <td width="25%">
      <img src="../icons/group.png" width="16" height="16"/> 
      <a href="usergroups.php">Manage User Groups
      </a>
    </td>
    <td width="25%">
      <img src="../icons/user_add.png" width="16" height="16"/> 
      <a href="users.php">Manage Users
      </a>
    </td>
    <td width="25%">
      <img src="../icons/database_refresh.png" width="16" height="16"/> 
      <a href="sql_inject.php">Run Direct SQL Code
      </a>
    </td>
    <td width="25%">
      <img src="../icons/emoticon_grin.png" width="16" height="16"/> 
      <a href="manager.php?action=cache">Cache Manager
      </a>
    </td>
  </tr>
</table>
<br/>
<table width="100%" border="0">
  <tr>
    <td width="50%">
      <table width="100%" border="0">
        <tr>
          <td width="47.5%">
            <span class="section-title">Quick Admin Search
            </span>
            <br/>
            <table width="100%" border="0">
              <tr>
                <td width="50%">
                  <span class="bold">Member Search
                  </span>
                </td>
                <td width="50%">
                  <form id="search_tools" method="post" action="">
                    <label for="member_search">
                    </label>
                    <input class="input" type="text" name="textfield" id="textfield"/>
                  </form>
                </td>
              </tr>
              <tr>
                <td width="50%">
                  <span class="bold">Setting Search
                  </span>
                </td>
                <td width="50%">
                  <label for="setting_search">
                  </label>
                  <input class="input" type="text" name="textfield2" id="textfield2"/> 
                </form>
                </td>
              </tr>
              <tr>
                <td width="50%">
                  <span class="bold">IP Addresses Search
                  </span>
                </td>
                <td width="50%">
                  <label for="ip_search">
                  </label>
                  <input class="input" type="text" name="textfield3" id="textfield3"/> 
                </form>
                </td>
              </tr>
            </table>
            <p align="center">
              <input class="input" name="" type="submit" value="Start Search"/>
            </p>
          </form>
          </td>
        </tr>
        <tr>
          <td>
            <span class="section-title">Admin Notes
            </span>
            <br/>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
              <textarea class="notes" name="admin_notes" id="textarea" rows='12' cols='50'><?php echo get_cache('admin_notes'); ?></textarea>
                <br/>
                <input class="input" name="insert_notes" type="submit" value="Save Notes"/>
              </form>
          </td>
        </tr>
      </table>
    </td>
    <td width="50%">
      <span class="section-title">Website Infomation Center
      </span>
      <br/>
      <table width="100%" border="0">
        <tr>
          <td width="50%">
            <span class="bold">
              <u>Member Infomation
              </u>
            </span>
          </td>
          <td width="50%">&nbsp;
          </td>
        </tr>
        <tr>
          <td width="50%">
            <span class="text">Total Members:
            </span>
          </td>
          <td width="50%">
            <span class="text"><a href="./users.php"><?php echo $db->count("SELECT uid FROM ".TABLE_PREFIX."users");?></a>
            </span>
          </td>
        </tr>
        <tr>
          <td width="50%">
            <span class="text">Online Members:
            </span>
          </td>
          <td width="50%">
            <span class="text"><a href="./users.php?status=online">
			<?php
			$lastcutoff = time()-(60*15);
			echo $db->count("SELECT uid FROM ".TABLE_PREFIX."users WHERE lastactive>={$lastcutoff}");?></a>
            </span>
          </td>
        </tr>
        <tr>
          <td width="50%">
            <span class="text">Awaiting Validation:
            </span>
          </td>
          <td width="50%">
            <span class="text"><a href="./users.php?status=inactive"><?php echo $db->count("SELECT uid FROM ".TABLE_PREFIX."users WHERE activationkey!='0'");?></a>
            </span>
          </td>
        </tr>
        <tr>
          <td width="50%">&nbsp;
          </td>
          <td width="50%">&nbsp;
          </td>
        </tr>
        <tr>
          <td width="50%">
            <span class="bold">
              <u>Article Infomation
              </u>
            </span>
          </td>
          <td width="50%">&nbsp;
          </td>
        </tr>
        <tr>
          <td width="50%">
            <span class="text">Total Articles:
            </span>
          </td>
          <td width="50%">
            <span class="text"><?php echo $db->count("SELECT pid FROM ".TABLE_PREFIX."pages");?>
            </span>
          </td>
        </tr>
        <tr>
          <td width="50%">&nbsp;
          </td>
          <td width="50%">&nbsp;
          </td>
        </tr>
        <tr>
          <td width="50%">
            <span class="bold">
              <u>Article Comment Infomation
              </u>
            </span>
          </td>
          <td width="50%">&nbsp;
          </td>
        </tr>
        <tr>
          <td width="50%">
            <span class="text">Total Comments:
            </span>
          </td>
          <td width="50%">
            <span class="text"><?php echo $db->count("SELECT cid FROM ".TABLE_PREFIX."comments");?>
            </span>
          </td>
        </tr>
		<tr>
          <td width="50%">&nbsp;
          </td>
          <td width="50%">&nbsp;
          </td>
        </tr>
		<tr>
			<td width="50%"><span class="bold"><u>Technical Statistics :</u></span>		</td>
			<td width="50%">&nbsp;</td>
		</tr>
		<tr>
			<td width="50%"><span class="text">Server Load:</span></td>
			<td width="50%"><span class="text"><?php echo get_server_load(); ?></span>
		</td>
	</tr>             
      </table>
      <p>
        <span class="section-title">
        Latest Admin Login
        </span>
        <br/>
        <?php $ccache = unserialize(get_cache('lastadminlogins')); echo "Was by {$ccache['name']} at ".date('G\:i A',$ccache['time'])." on the ".date('F j, Y',$ccache['time'])."."; ?>
        <br />
        </p>
</table>
</td>
</tr>
</table>
<br/>
<br/>
<span class="section-title">Who made ImprovCMS?
</span>
<span class="bold">
  <br/>
  <table width="100%" border="0">
    <tr>
      <td width="33%">
        <strong>Management Members
        </strong>
      </td>
      <td width="33%">
        <strong>Developer Team Members
        </strong>
      </td>
      <td width="33%">
        <strong>SQA  Team Members</strong>
      </td>
    </tr>
    <tr>
      <td width="33%"><i>Gordon Hughes</i></td>
      <td width="33%">Rob Chambers</td>
      <td width="33%">Austin</td>
      </tr>
    <tr>
      <td width="33%"><i>Azareal</i></td>
      <td width="33%"><i>Malietjie</span></td>
      <td width="33%">&nbsp;</td>
    </tr>
    <tr>
	 <td width="33%">&nbsp;</td>
     <td width="33%">Firestar</td>
     <td width="33%">&nbsp;</td>
    </tr>
  </table>
</span>
</div>