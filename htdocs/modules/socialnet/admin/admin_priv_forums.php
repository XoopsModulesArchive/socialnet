<?php
//  ------------------------------------------------------------------------ //
//                      SOCIALNET - MODULE FOR XOOPS 2                       //
//                  Copyright (c) 2009-2010  David Yanez Osses               //
//                     <http://www.ipwgc.com/>                      		 //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

include_once 'admin_header.php';
include_once '../../../include/cp_header.php';
include_once '../forumfunctions.php';
include_once '../forumconfig.php';
$myts =& MyTextSanitizer::getInstance();
require_once XOOPS_ROOT_PATH.'/modules/socialnet/include/common.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/admin/functions.php';
require_once XOOPS_ROOT_PATH.'/class/pagenav.php';
xoops_cp_header();
adminmenu(25);
// *******************************************************************************
// **** Main
// *******************************************************************************

echo"<table width='100%' border='0' cellspacing='1' class='outer'>"
."<tr><td class=\"odd\">";
echo "<a href='./admin_forumbegin.php'><h4>"._AM_SOCIALNET_FORUMCONF."</h4></a>";
extract($_GET);
if (isset($_POST)) {
	foreach ($_POST as $key => $value) {
		${$key} = $value;
	}
}

	if (!$op)
	{
		// No opcode passed. Show list of private forums.
?>

	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		<table border="0" cellpadding="1" cellspacing="0" align="center" width="95%">
			<tr>
				<td class='bg2'>
					<table border="0" cellpadding="1" cellspacing="1" width="100%">
						<tr class='bg3' align='left'>
							<td align="center" colspan="2">
								<span class='fg2'>
									<b><?php _AM_SOCIALNET_SAFTE;?></b>
								</span>
							</td>
						</tr>
						<tr class='bg1' align='left'>
							<td align="center" colspan="2">
								<select name="forum" size="0">
	<?php

		$sql = "SELECT forum_name, forum_id FROM ".$xoopsDB->prefix("socialnet_forums")." WHERE forum_type = 1 ORDER BY forum_id";
		if(!$result = $xoopsDB->query($sql))
		{
			echo"</td></tr></table>";
			xoops_cp_footer();
			exit();
		}

		if($myrow = $xoopsDB->fetchArray($result))
		{
			do
			{
				$name = $myts->htmlSpecialChars($myrow['forum_name']);
				echo "<option value=\"".$myrow['forum_id']."\">$name</option>\n";
			}
			while($myrow = $xoopsDB->fetchArray($result));
		}
		else
		{
			echo "<option value=\"-1\">"._AM_SOCIALNET_NFID."</option>\n";
		}

?>
								</select>
							</td>
						</tr>
						<tr class='bg3' Align="left">
							<td align="center" colspan="2">
								<input type="hidden" name="op" value="showform" />
								<input type="submit" name="submit" value="<?php echo _AM_SOCIALNET_EDIT;?>" />&nbsp;&nbsp;
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>


<?php

	}
	else
	{
		// Opcode exists. See what it is, do stuff.


		if ($op == "adduser")
		{
			// Add user(s) to the list for this forum.
			if ($userids)
			{
				while(list($null, $curr_userid) = each($_POST["userids"]))
				{
					$forum = intval($forum);
					$curr_userid = intval($curr_userid);
					$sql = "INSERT INTO ".$xoopsDB->prefix("socialnet_forumaccess")." (forum_id, user_id, can_post) VALUES ($forum, $curr_userid, 0)";
					if (!$result = $xoopsDB->query($sql))
					{
						echo"</td></tr></table>";
						xoops_cp_footer();
						exit();
					}
				}
			}
			$op = "showform";

		}
		else if ($op == "deluser")
		{
			// Remove a user from the list for this forum.
			$sql = sprintf("DELETE FROM %s WHERE forum_id = %u AND user_id = %u", $xoopsDB->prefix("socialnet_forumaccess"), $forum, $op_userid);
			if (!$result = $xoopsDB->query($sql))
			{
				echo"</td></tr></table>";
				xoops_cp_footer();
				exit();
			}

			$op = "showform";

		}
		else if ($op == "clearusers")
		{
			// Remove all users from the list for this forum.
			$sql = sprintf("DELETE FROM %s WHERE forum_id = %u", $xoopsDB->prefix("socialnet_forumaccess"), $forum);
			if (!$result = $xoopsDB->query($sql))
			{
				echo"</td></tr></table>";
				xoops_cp_footer();
				exit();
			}

			$op = "showform";
		}
		else if ($op == "grantuserpost")
		{
			// Add posting rights for this user in this forum.
			$sql = sprintf("UPDATE %s SET can_post=1 WHERE forum_id = %u AND user_id = %u", $xoopsDB->prefix("socialnet_forumaccess"), $forum, $op_userid);
			if (!$result = $xoopsDB->query($sql))
			{
				echo"</td></tr></table>";
				xoops_cp_footer();
				exit();
			}

			$op = "showform";

		}
		else if ($op == "revokeuserpost")
		{
			// Revoke posting rights for this user in this forum.
			$sql = "UPDATE ".$xoopsDB->prefix("socialnet_forumaccess")." SET can_post=0 WHERE forum_id = $forum AND user_id = $op_userid";
			if (!$result = $xoopsDB->query($sql))
			{
				echo"</td></tr></table>";
				xoops_cp_footer();
				exit();
			}

			$op = "showform";

		}

		// We want this one to be available even after one of the above blocks has executed.
		// The above blocks will set $op to "showform" on success, so it goes right back to the form.
		// Neato. This is really slick.
		if ($op == "showform")
		{
			// Show the form for the given forum.

			$sql = "SELECT forum_name FROM ".$xoopsDB->prefix("socialnet_forums")." WHERE forum_id = $forum";
			if ((!$result = $xoopsDB->query($sql)) || ($forum == -1))
			{
				echo"</td></tr></table>";
				xoops_cp_footer();
				exit();
			}
			$forum_name = "";
			if ($row = $xoopsDB->fetchArray($result))
			{
				$forum_name = $myts->htmlSpecialChars($row['forum_name']);
			}
?>
     <br />&nbsp;
	 <table border="0" cellpadding="1" cellspacing="1" align="center" width="95%">
		<tr>
			<td class='bg2'>
				<table border="0" cellpadding="3" cellspacing="0" width="100%">
					<tr class='bg3' align="left">
		     <td colspan="3" align="center"><?php printf(_AM_SOCIALNET_EFPF,$forum_name);?></td>
		     </tr>
		     <tr>
		     <td class='bg3' align='center' width='40%'>
			<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		         <b><?php echo _AM_SOCIALNET_UWOA;?></b>
		     </td>
		     <td class='bg3' align='center' width='20%'>
		        &nbsp;
		     </td>
		     <td class='bg3' align='center'>
		        <b><?php echo _AM_SOCIALNET_UWA;?></b>
		     </td>
		     </tr>

		     <tr>
		      <td valign="top" class='bg1' align='center' width='40%'>
		     <select name="userids[]" size="10" multiple='multiple' style="width: 100px;">
<?php
			$sql = "SELECT u.uid FROM ".$xoopsDB->prefix("users")." u, ".$xoopsDB->prefix("socialnet_forumaccess")." f WHERE u.uid = f.user_id AND f.forum_id = $forum";
			if (!$result = $xoopsDB->query($sql))
			{
				echo"</td></tr></table>";
				xoops_cp_footer();
				exit();
			}

			$current_users = Array();

			while ($row = $xoopsDB->fetchArray($result))
			{
				$current_users[] = $row[uid];
			}

			$sql = "SELECT uid, uname FROM ".$xoopsDB->prefix("users")." WHERE (uid > 0 AND level > 0)";
			while(list($null, $curr_userid) = each($current_users))
			{
	 			$sql .= "AND (uid != $curr_userid) ";
      	}
      	$sql .= "ORDER BY uname ASC";

      	if (!$result = $xoopsDB->query($sql))
      	{
		echo"</td></tr></table>";
		xoops_cp_footer();
		exit();
      	}
      	while ($row = $xoopsDB->fetchArray($result))
      	{
?>
	     <option value="<?php echo $row['uid'] ?>"> <?php echo $row['uname'] ?> </option>
<?php
      	}
?>
							</select>
						</td>
						<td class='bg1' align='center' valign="top">

							<input type="hidden" name="op" value="adduser" />
							<input type="hidden" name="forum" value="<?php echo $forum ?>" />
							<input type="submit" name="submit" value="<?php echo _AM_SOCIALNET_ADDUSERS;?>" />
							</form><br />
<?php
							$link = $_SERVER['PHP_SELF']."?forum=".$forum."&amp;op=clearusers";
							echo myTextForm($link, _AM_SOCIALNET_CLEARALLUSERS);
?>
						</td>
						<td valign="top" class='bg1' align='center'>
<?php
			$sql = "SELECT u.uname, u.uid, f.can_post FROM ".$xoopsDB->prefix("users")." u, ".$xoopsDB->prefix("socialnet_forumaccess")." f WHERE u.uid = f.user_id AND f.forum_id = $forum ORDER BY u.uid ASC";
			if (!$result = $xoopsDB->query($sql))
			{
				echo"</td></tr></table>";
				xoops_cp_footer();
				exit();
			}
?>
							<table border="0" cellpadding="10" cellspacing="0">

<?php
			while ($row = $xoopsDB->fetchArray($result))
			{
				$post_text = ($row['can_post']) ? _AM_SOCIALNET_CANPOST : _AM_SOCIALNET_CANTPOST;
				//$post_toggle_link = "<a href=\"".$_SERVER['PHP_SELF']."?forum=$forum&op_userid=".$row['uid']."&op=";
				$post_toggle_link = XOOPS_URL."/modules/socialnet/admin/admin_priv_forums.php?forum=$forum&op_userid=".$row['uid']."&op=";
				if ($row['can_post'])
				{
					$post_toggle_link .= "revokeuserpost";
					$post_toggle_link = myTextForm($post_toggle_link,_AM_SOCIALNET_REVOKEPOSTING);
				}
				else
				{
					$post_toggle_link .= "grantuserpost";
					$post_toggle_link = myTextForm($post_toggle_link,_AM_SOCIALNET_GRANTPOSTING);
				}
				$remove_link = myTextForm(XOOPS_URL."/modules/socialnet/admin/admin_priv_forums.php?forum=$forum&amp;op=deluser&amp;op_userid=".$row['uid'], _AM_SOCIALNET_REMOVE);
?>
								<tr>
								<td><b><?php echo $row['uname']?></b>
                                (<?php echo $post_text ?>)
                                <?php echo $post_toggle_link ?>
								<?php echo $remove_link ?></td>
								</tr>
<?php
			}
?>
							</table>
						</td>
					</tr>
				</table>
			</form>
			</td></tr></table>
<?php
		} // end of big opcode if/else block.


	}

//}

echo"</td></tr></table>";
xoops_cp_footer();
?>
