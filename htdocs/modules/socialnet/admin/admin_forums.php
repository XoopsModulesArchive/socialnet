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
require_once XOOPS_ROOT_PATH.'/modules/socialnet/include/common.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/admin/functions.php';
require_once XOOPS_ROOT_PATH.'/class/pagenav.php';
//xoops_cp_header();
//adminmenu(22);

// *******************************************************************************
// **** Main
// *******************************************************************************

if (isset ($_GET['mode'])) {
	$mode = $_GET['mode'];
}

foreach ($_POST as $k => $v) {
	${ $k } = $v;
}

switch (trim($mode)) {
	case 'editforum' :

		$myts = & MyTextSanitizer :: getInstance();
		if (isset ($_POST['save']) && $_POST['save'] != '') {
			if (!$_POST['delete']) {
				$name = $myts->addSlashes($_POST['name']);
				$desc = $myts->addSlashes($_POST['desc']);

				$sql = sprintf("UPDATE %s SET forum_name = '%s', forum_desc = '%s', forum_type = '%s', cat_id = %u, forum_access = %u, allow_html = '%s', allow_sig = '%s', posts_per_page = %u, hot_threshold = %u, topics_per_page = %u, show_name='%s', show_icons_panel='%s', show_smilies_panel='%s', allow_upload='%d' WHERE forum_id = %u", $xoopsDB->prefix('socialnet_forums'), $name, $desc, $type, $cat, $forum_access, $html, $sig, $ppp, $hot, $tpp, $show_name, $show_icons_panel, $show_smilies_panel, $allow_upload, $forum);

				if (!$r = $xoopsDB->query($sql)) {
					redirect_header("./admin_forumbegin.php", 1);
					exit ();
				}
				$count = 0;
				if (isset ($_POST["mods"])) {
					while (list ($null, $mod) = each($_POST["mods"])) {
						$mod_data = new XoopsUser($mod);
						if ($mod_data->isActive()) {
							$sql = sprintf("INSERT INTO %s (forum_id, user_id) VALUES (%u, %u)", $xoopsDB->prefix("socialnet_forummods"), $forum, $mod);
							if (!$xoopsDB->query($sql)) {
								redirect_header("./admin_forumbegin.php", 1);
								exit ();
							}
						}
					}
				}

				if (!isset ($mods)) {
					$current_mods = "SELECT count(*) AS total FROM " . $xoopsDB->prefix("socialnet_forummods") . " WHERE forum_id = $forum";
					$r = $xoopsDB->query($current_mods);
					list ($total) = $xoopsDB->fetchRow($r);
				} else {
					$total = count($mods) + 1;
				}

				if (isset ($rem_mods) && $total > 1) {
					while (list ($null, $mod) = each($_POST["rem_mods"])) {
						$sql = sprintf("DELETE FROM %s WHERE forum_id = %u AND user_id = %u", $xoopsDB->prefix("socialnet_forummods"), $forum, $mod);
						if (!$xoopsDB->query($sql)) {
							redirect_header("./admin_forumbegin.php", 1);
							exit ();
						}
					}
				} else {
					if (isset ($rem_mods)) {
						$mod_not_removed = 1;
					}
				}
				if ($mod_not_removed) {
					redirect_header("./admin_forumbegin.php", 1, _AM_SOCIALNET_FORUMUPDATED . "<br />" . _AM_SOCIALNET_HTSMHNBRBITHBTWNLBAMOTF);
				} else {
					redirect_header("./admin_forumbegin.php", 1, _AM_SOCIALNET_FORUMUPDATED);
				}
			} else {
				$sql = "SELECT post_id FROM " . $xoopsDB->prefix("socialnet_forumposts") . " WHERE forum_id = $forum";
				if (!$r = $xoopsDB->query($sql)) {
					redirect_header("./admin_forumbegin.php", 1);
					exit ();
				}
				if ($xoopsDB->getRowsNum($r) > 0) {
					$sql = "DELETE FROM " . $xoopsDB->prefix("socialnet_forumposts_text") . " WHERE ";
					$looped = false;
					while ($ids = $xoopsDB->fetchArray($r)) {
						if ($looped == true) {
							$sql .= " OR ";
						}
						$sql .= "post_id = " . $ids["post_id"] . " ";
						$looped = true;
					}
					if (!$r = $xoopsDB->query($sql)) {
						redirect_header("./admin_forumbegin.php", 1);
						exit ();
					}
					$sql = sprintf("DELETE FROM %s WHERE forum_id = %u", $xoopsDB->prefix("socialnet_forumposts"), $forum);
					if (!$r = $xoopsDB->query($sql)) {
						redirect_header("./admin_forumbegin.php", 1);
						exit ();
					}
				}
				// RMV-NOTIFY
				xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'forum', $forum);
				// Get list of all topics in forum, to delete them too
				$sql = sprintf("SELECT topic_id FROM %s WHERE forum_id = %u", $xoopsDB->prefix("socialnet_forumtopics"), $forum);
				if ($r = $xoopsDB->query($sql)) {
					while ($row = $xoopsDB->fetchArray($r)) {
						xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'thread', $row['topic_id']);
					}
				}

				$sql = sprintf("DELETE FROM %s WHERE forum_id = %u", $xoopsDB->prefix("socialnet_forumtopics"), $forum);
				if (!$r = $xoopsDB->query($sql)) {
					redirect_header("./admin_forumbegin.php", 1);
					exit ();
				}
				$sql = sprintf("DELETE FROM %s WHERE forum_id = %u", $xoopsDB->prefix("socialnet_forums"), $forum);
				if (!$r = $xoopsDB->query($sql)) {
					redirect_header("./admin_forumbegin.php", 1);
					exit ();
				}

				$sql = sprintf("DELETE FROM %s WHERE forum_id = %u", $xoopsDB->prefix("socialnet_forummods"), $forum);
				if (!$r = $xoopsDB->query($sql)) {
					redirect_header("./admin_forumbegin.php", 1);
					exit ();
				}
				redirect_header("./admin_forumbegin.php", 1, _AM_SOCIALNET_FORUMREMOVED);
			}
		}
		if (isset ($_POST['submit']) && !isset ($_POST['save'])) {
			$sql = "SELECT * FROM " . $xoopsDB->prefix("socialnet_forums") . " WHERE forum_id = $forum";
			if (!$result = $xoopsDB->query($sql)) {
				redirect_header("./admin_forumbegin.php", 1);
				exit ();
			}
			if (!$myrow = $xoopsDB->fetchArray($result)) {
				redirect_header("./admin_forumbegin.php", 1, _AM_SOCIALNET_NOSUCHFORUM);
			}
			$name = $myts->htmlSpecialChars($myrow['forum_name']);
			$desc = $myts->htmlSpecialChars($myrow['forum_desc']);
			xoops_cp_header();
			//adminmenu(23);
			echo "<table width='100%' border='0' cellspacing='1' class='outer'>" .
			"<tr><td class=\"odd\">";
			echo "<a href='./admin_forumbegin.php'><h4>" . _AM_SOCIALNET_FORUMCONF . "</h4></a>";
?>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method='post'>
		<table border="0" cellpadding="1" cellspacing="0" align='center' Valign="TOP" width="95%"><tr><td class='bg2'>
		<table border="0" cellpadding="1" cellspacing="1" width="100%">
		<tr class='bg3' align='left'>
        	<td align='center' colspan="2"><span class='fg2'><b><?php echo _AM_SOCIALNET_EDITTHISFORUM;?></b></span></td>
		</tr>
		<tr class='bg1' align='left'>
        	<td colspan=2><input type="CHECKBOX" name='delete' value="1"><span class='fg2'> <?php echo _AM_SOCIALNET_DTFTWARAPITF;?></span></td>
		</tr>
		<tr class='bg1' align='left'>
        	<td><span class='fg2'><?php echo _AM_SOCIALNET_FORUMNAME;?></span></td>
        	<td><input type='text' name='name' SIZE="40" MAXLENGTH="150" value="<?php echo $name?>"></td>
		</tr>
		<tr class='bg1' align='left'>
        	<td><span class='fg2'><?php echo _AM_SOCIALNET_FORUMDESCRIPTION;?></span></td>
        	<td><TEXTAREA name='desc' ROWS="15" COLS="45" WRAP="VIRTUAL"><?php echo $desc?></TEXTAREA></td>
		</tr>
		<tr class='bg1' align='left'>
        	<td valign="top"><span class='fg2'><?php echo _AM_SOCIALNET_MODERATOR;?></span></td>
        	<td><b><?php echo _AM_SOCIALNET_CURRENT; ?>:</b><br />
		<?php

			$sql = "SELECT u.uname, u.uid FROM " . $xoopsDB->prefix("users") . " u, " . $xoopsDB->prefix("socialnet_forummods") . " f WHERE f.forum_id = $forum AND u.uid = f.user_id";
			if (!$r = $xoopsDB->query($sql)) {
				echo "</td></tr></table>";
				xoops_cp_footer();
				exit ();
			}
			if ($row = $xoopsDB->fetchArray($r)) {
				do {
					echo $row['uname'] . " (<input type=\"checkbox\" name=\"rem_mods[]\" value=\"" . $row['uid'] . "\"> " . _AM_SOCIALNET_REMOVE . ")<br />";
					$current_mods[] = $row['uid'];
				} while ($row = $xoopsDB->fetchArray($r));
				echo "<br />";
			} else {
				echo _AM_SOCIALNET_NOMODERATORASSIGNED . "<br /><br />\n";
			}
?>
		<b><?php echo _AM_SOCIALNET_ADD; ?></b><br />
		<select name='mods[]' size="5" multiple>
		<?php

			$sql = "SELECT uid, uname FROM " . $xoopsDB->prefix("users") . " WHERE uid > 0 AND level > 0 ";
			while (list ($null, $currMod) = each($current_mods)) {
				$sql .= "AND uid != $currMod ";
			}
			$sql .= "ORDER BY uname";
			if (!$r = $xoopsDB->query($sql)) {
				echo "</td></tr></table>";
				xoops_cp_footer();
				exit ();
			}
			if ($row = $xoopsDB->fetchArray($r)) {
				do {
					$s = "";
					if ($row['uid'] == $myrow['forum_moderator']) {
						$s = "SELECTED";
					}
					echo "<option value=\"" . $row['uid'] . "\" $s>" . $row['uname'] . "</option>\n";
				} while ($row = $xoopsDB->fetchArray($r));
			} else {
				echo "<option value=\"0\">" . _AM_SOCIALNET_NONE . "</option>\n";
			}
?>
        	</select></td>
		</tr>
		<tr class='bg1' align='left'>
        	<td><span class='fg2'><?php echo _AM_SOCIALNET_CATEGORY;?></span></td>
        	<td><select name='cat'>
		<?php

			$sql = "SELECT * FROM " . $xoopsDB->prefix("socialnet_forumcategories") . "";
			if (!$r = $xoopsDB->query($sql)) {
				echo "</td></tr></table>";
				xoops_cp_footer();
				exit ();
			}
			if ($row = $xoopsDB->fetchArray($r)) {
				do {
					$s = "";
					if ($row['cat_id'] == $myrow['cat_id']) {
						$s = "SELECTED";
					}
					echo "<option value=\"" . $row['cat_id'] . "\" $s>" . $row['cat_title'] . "</option>\n";
				} while ($row = $xoopsDB->fetchArray($r));
			} else {
				echo "<option value=\"0\">" . _AM_SOCIALNET_NONE . "</option>\n";
			}
?>
        	</select></td>
		<?php

			if ($myrow['forum_access'] == 1) {
				$access1 = "SELECTED";
			}
			if ($myrow['forum_access'] == 2) {
				$access2 = "SELECTED";
			}
			if ($myrow['forum_access'] == 3) {
				$access3 = "SELECTED";
			}
?>
		</tr>
		<tr class='bg1' align='left'>
		<td><span class='fg2'><?php echo _AM_SOCIALNET_ACCESSLEVEL ?></span></td>
		<td><select name='forum_access'>
	    	<option value="2" <?php echo $access2?>><?php echo _AM_SOCIALNET_ANONYMOUSPOST;?></option>
	    	<option value="1" <?php echo $access1?>><?php echo _AM_SOCIALNET_REGISTERUSERONLY;?></option>
	    	<option value="3" <?php echo $access3?>><?php echo _AM_SOCIALNET_MODERATORANDADMINONLY;?></option>
	    	</select>
        	</td>
		</tr>
		<tr class='bg1' align='left'>
		<td><span class='fg2'><?php echo _AM_SOCIALNET_TYPE;?></span></td>
		<td><select name='type'>
		<?php

			if ($myrow['forum_type'] == 1) {
				$priv = "SELECTED";
			} else {
				$pub = "SELECTED";
			}
?>
		<option value="0" <?php echo $pub?>><?php echo _AM_SOCIALNET_PUBLIC;?></option>
		<option value="1" <?php echo $priv?>><?php echo _AM_SOCIALNET_PRIVATE;?></option>
		</select>
		</td>
		</tr>
		<?php

			//
			$html_yes = $html_no = $show_icons_panel_yes = $show_icons_panel_no = $show_smilies_panel_yes = $show_smilies_panel_no = $sig_yes = $show_name_yes = $show_name_no = $sig_no = "";
			$allow_upload_yes = $allow_upload_no = "";

			if ($myrow['allow_upload'] == 1) {
				$allow_upload_yes = "checked='checked'";
			} else {
				$allow_upload_no = "checked='checked'";
			}

			if ($myrow['allow_html'] == 1) {
				$html_yes = "checked='checked'";
			} else {
				$html_no = "checked='checked'";
			}
			if ($myrow['allow_sig'] == 1) {
				$sig_yes = "checked='checked'";
			} else {
				$sig_no = "checked='checked'";
			}
			//
			if ($myrow['show_name'] == 1) {
				$show_name_yes = "checked='checked'";
			} else {
				$show_name_no = "checked='checked'";
			}
			if ($myrow['show_icons_panel'] == 1) {
				$show_icons_panel_yes = "checked='checked'";
			} else {
				$show_icons_panel_no = "checked='checked'";
			}
			if ($myrow['show_smilies_panel'] == 1) {
				$show_smilies_panel_yes = "checked='checked'";
			} else {
				$show_smilies_panel_no = "checked='checked'";
			}

			echo "<tr class='bg1' align='left'><td><span class='fg2'>" . _AM_SOCIALNET_ALLOW_UPLOAD . "</span></td>			<td><input type='radio' name='allow_upload' value='1'" . $allow_upload_yes . " />" . _AM_SOCIALNET_YES . "<input type='radio' name='allow_upload' value='0'" . $allow_upload_no . " />" . _AM_SOCIALNET_NO . "</td></tr>";
			echo "<tr class='bg1' align='left'><td><span class='fg2'>" . _AM_SOCIALNET_ALLOWHTML . "</span></td>			<td><input type='radio' name='html' value='1'" . $html_yes . " />" . _AM_SOCIALNET_YES . "<input type='radio' name='html' value='0'" . $html_no . " />" . _AM_SOCIALNET_NO . "</td></tr>
					<tr class='bg1' align='left'><td><span class='fg2'>" . _AM_SOCIALNET_ALLOWSIGNATURES . "</span></td>
					<td><input type='radio' name='sig' value='1'$sig_yes />" . _AM_SOCIALNET_YES . "<input type='radio' name='sig' value='0'$sig_no />" . _AM_SOCIALNET_NO . "</td></tr>
					<tr class='bg1' align='left'><td><span class='fg2'>" . _AM_SOCIALNET_HOTTOPICTHRESHOLD . "</span></td><td><input type='text' name='hot' size='3' maxlength='3' value='" . $myrow['hot_threshold'] . "' /></td></tr>
					<tr class='bg1' align='left'><td><span class='fg2'>" . _AM_SOCIALNET_POSTPERPAGE . "</span><br /><span class='fg2'><i>" . _AM_SOCIALNET_TITNOPPTTWBDPPOT . "</i></span></td>
					<td><input type='text' name='ppp' size='3' maxlength='3' value='" . $myrow['posts_per_page'] . "' /></td></tr>
					<tr class='bg1' align='left'><td><span class='fg2'>" . _AM_SOCIALNET_TOPICPERFORUM . "</span><br /><span class='fg2'><i>" . _AM_SOCIALNET_TITNOTPFTWBDPPOAF . "</i></span></td><td><input type='text' name='tpp' size='3' maxlength='3' value='" . $myrow['topics_per_page'] . "' /></td></tr>";

			echo "<tr class='bg1' align='left'><td><span class='fg2'>" . _AM_SOCIALNET_SHOWNAME . "</span></td>			<td><input type='radio' name='show_name' value='1'" . $show_name_yes . " />" . _AM_SOCIALNET_YES . "<input type='radio' name='show_name' value='0'" . $show_name_no . " />" . _AM_SOCIALNET_NO . "</td></tr>";
			echo "<tr class='bg1' align='left'><td><span class='fg2'>" . _AM_SOCIALNET_SHOWICONSPANEL . "</span></td>			<td><input type='radio' name='show_icons_panel' value='1'" . $show_icons_panel_yes . " />" . _AM_SOCIALNET_YES . "<input type='radio' name='show_icons_panel' value='0'" . $show_icons_panel_no . " />" . _AM_SOCIALNET_NO . "</td></tr>";
			echo "<tr class='bg1' align='left'><td><span class='fg2'>" . _AM_SOCIALNET_SHOWSMILIESPANEL . "</span></td>			<td><input type='radio' name='show_smilies_panel' value='1'" . $show_smilies_panel_yes . " />" . _AM_SOCIALNET_YES . "<input type='radio' name='show_smilies_panel' value='0'" . $show_smilies_panel_no . " />" . _AM_SOCIALNET_NO . "</td></tr>";
			echo "</tr></table></td></tr></table>";
			echo "<tr class='bg3' align='left'><td align='center' colspan='2'><input type='hidden' name='mode' value='editforum' /><input type='hidden' name='forum' value='$forum' /><input type='submit' name='save' value='" . _AM_SOCIALNET_SAVECHANGES . "' />&nbsp;&nbsp;<input type='reset' value='" . _AM_SOCIALNET_CLEAR . "' /></td></tr>";
		}
		if (!isset ($_POST['submit']) && !isset ($_POST['save'])) {
			xoops_cp_header();
// ok Correct Edit correst Menu
adminmenu(24);
			echo "<table width='100%' border='0' cellspacing='1' class='outer'>" .
			"<tr><td class=\"odd\">";
			echo "<a href='./admin_forumbegin.php'><h4>" . _AM_SOCIALNET_FORUMCONF . "</h4></a>";
?>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method='post'>
		<table border="0" cellpadding="1" cellspacing="0" align='center' Valign="TOP" width="95%"><tr><td class='bg2'>
		<table border="0" cellpadding="1" cellspacing="1" width="100%">
		<tr class='bg3' align='left'>
		<td align='center' colspan="2"><span class='fg2'><b><?php echo _AM_SOCIALNET_SELECTFORUMEDIT;?></b><span class='fg2'></td>
		</tr>
		<tr class='bg1' align='left'>
		<td align='center' colspan="2"><select name='forum' SIZE="0">
		<?php

			$sql = "SELECT forum_name, forum_id FROM " . $xoopsDB->prefix("socialnet_forums") . " ORDER BY forum_id";
			if ($result = $xoopsDB->query($sql)) {
				if ($myrow = $xoopsDB->fetchArray($result)) {
					do {
						$name = $myts->htmlSpecialChars($myrow['forum_name']);
						echo "<option value=\"" . $myrow['forum_id'] . "\">$name</option>\n";
					} while ($myrow = $xoopsDB->fetchArray($result));
				} else {
					echo "<option value=\"-1\">" . _AM_SOCIALNET_NOFORUMINDATABASE . "</option>\n";
				}
			} else {
				echo "<option value=\"-1\">" . _AM_SOCIALNET_DATABASEERROR . "</option>\n";
			}
?>
		</select></td>
		</tr>
		<tr class='bg3' align='left'>
		<td align='center' colspan="2">
		<input type="hidden" name='mode' value="editforum">
		<input type='submit' name='submit' value="<?php echo _AM_SOCIALNET_EDIT;?>">&nbsp;&nbsp;
		</td>
		</tr>
		</tr>
		</table></td></tr></table>
		<?php

		}
		break;
	case 'editcat' :
		$myts = & MyTextSanitizer :: getInstance();
		if (isset ($_POST['submit']) && isset ($_POST['save'])) {
			$new_title = $myts->addSlashes($_POST['new_title']);
			$sql = "UPDATE " . $xoopsDB->prefix("socialnet_forumcategories") . " SET cat_title = '$new_title' WHERE cat_id = $cat_id";
			if (!$result = $xoopsDB->query($sql)) {
				redirect_header("./admin_forumbegin.php", 1);
				exit ();
			} else {
				redirect_header("./admin_forumbegin.php", 1, _AM_SOCIALNET_CATEGORYUPDATED);
			}
		} else
			if (isset ($_POST['submit']) && $_POST['submit'] != "") {
				$sql = "SELECT cat_title FROM " . $xoopsDB->prefix("socialnet_forumcategories") . " WHERE cat_id = '$cat'";
				if (!$result = $xoopsDB->query($sql)) {
					redirect_header("./admin_forumbegin.php", 1);
					exit ();
				}
				xoops_cp_header();
				//adminmenu(28);
				echo "<table width='100%' border='0' cellspacing='1' class='outer'>" .
				"<tr><td class=\"odd\">";
				echo "<a href='./admin_forumbegin.php'><h4>" . _AM_SOCIALNET_FORUMCONF . "</h4></a>";
				$cat_data = $xoopsDB->fetchArray($result);
				$cat_title = $myts->htmlSpecialChars($cat_data["cat_title"]);
?>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method='post'>
		<table border="0" cellpadding="1" cellspacing="0" align='center' Valign="TOP" width="95%"><tr><td class='bg2'>
		<table border="0" cellpadding="1" cellspacing="1" width="100%">
		<tr class='bg3' align='left'>
		<td align='center' colspan="2"><span class='fg2'><b><?php echo _AM_SOCIALNET_EDITCATEGORY;?> <?php echo $cat_title ?></b><span class='fg2'></td>
		</tr>
		<tr class='bg1' align='left'>
		<td><?php echo _AM_SOCIALNET_CATEGORYTITLE;?></td>
		<td><input type="text" name="new_title" value="<?php echo $cat_title ?>" size="45" maxlength="100"></td>
		</tr>
		<tr class='bg3' align='left'>
		<td align='center' colspan="2">
		<input type="hidden" name='mode' value="editcat" />
		<input type="hidden" name="save" value="TRUE" />
		<input type="hidden" name="cat_id" value="<?php echo $cat?>" />
		<input type='submit' name='submit' value="<?php echo _AM_SOCIALNET_SAVECHANGES;?>" />
		</td>
		</tr>
		</tr>
		</table></td></tr></table>
		<?php

			} else {
				$sql = "SELECT cat_id, cat_title FROM " . $xoopsDB->prefix("socialnet_forumcategories") . " ORDER BY cat_order";
				if (!$result = $xoopsDB->query($sql)) {
					redirect_header("./admin_forumbegin.php", 1);
					exit ();
				}
				xoops_cp_header();
// OK Edit correst Category Menu
adminmenu(28);
				echo "<table width='100%' border='0' cellspacing='1' class='outer'>" .
				"<tr><td class=\"odd\">";
				echo "<a href='./admin_forumbegin.php'><h4>" . _AM_SOCIALNET_FORUMCONF . "</h4></a>";
?>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method='post'>
		<table border="0" cellpadding="1" cellspacing="0" align='center' Valign="TOP" width="95%"><tr><td class='bg2'>
		<table border="0" cellpadding="1" cellspacing="1" width="100%">
		<tr class='bg3' align='left'>
		<td align='center' colspan="2"><span class='fg2'><b><?php echo _AM_SOCIALNET_SELECTACATEGORYEDIT;?></b><span class='fg2'></td>
		</tr>
		<tr class='bg1' align='left'>
		<td align='center' colspan="2"><select name='cat' SIZE="0">
		<?php

				while ($cat_data = $xoopsDB->fetchArray($result)) {
					echo "<option value=\"" . $cat_data["cat_id"] . "\">" . $myts->htmlSpecialChars($cat_data["cat_title"]) . "</option>\n";
				}
?>
		</select></td>
		<tr class='bg3' align='left'>
		<td align='center' colspan="2">
		<input type="hidden" name='mode' value="editcat">
		<input type='submit' name='submit' value="<?php echo _AM_SOCIALNET_EDIT;?>">&nbsp;&nbsp;
		</td>
		</tr>
		</tr>
		</table></td></tr></table>
		<?php

			}
		break;
	case 'remcat' :
		$myts = & MyTextSanitizer :: getInstance();
		if (isset ($_POST['submit']) && $_POST['submit'] != "") {
			$sql = sprintf("DELETE FROM %s WHERE cat_id = %u", $xoopsDB->prefix("socialnet_forumcategories"), $cat);
			if (!$r = $xoopsDB->query($sql)) {
				redirect_header("./admin_forumbegin.php", 1);
				exit ();
			}
			redirect_header("./admin_forumbegin.php", 1, _AM_SOCIALNET_CATEGORYDELETED);
		} else {
			xoops_cp_header();
// OK Correct Remove order category
adminmenu(29);
			echo "<table width='100%' border='0' cellspacing='1' class='outer'>" .
			"<tr><td class=\"odd\">";
			echo "<a href='./admin_forumbegin.php'><h4>" . _AM_SOCIALNET_FORUMCONF . "</h4></a>";
?>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method='post'>
		<table border="0" cellpadding="1" cellspacing="0" align='center' width="95%"><tr><td class='bg2'>
		<table border="0" cellpadding="1" cellspacing="1" width="100%">
		<tr class='bg3' align='left'>
		<td align='center' colspan="2"><span class='fg2'><b><?php echo _AM_SOCIALNET_RMVACAT;?></b></span></td>
		</tr>
		<tr class='bg3' align='left'>
		<td align='center' colspan="2"><span class='fg2'><i><?php echo _AM_SOCIALNET_NTWNRTFUTCYMDTVTEFS;?></i></span></td>
		</tr>
		<tr class='bg1'>
		<td align='center' colspan="2"><span class='fg2'>
		<select name='cat'>
		<?php

			$sql = "SELECT * FROM " . $xoopsDB->prefix("socialnet_forumcategories") . " ORDER BY cat_title";
			if (!$r = $xoopsDB->query($sql)) {
				echo "</td></tr></table>";
				xoops_cp_footer();
				exit ();
			}
			while ($m = $xoopsDB->fetchArray($r)) {
				echo "<option value=\"" . $m['cat_id'] . "\">" . $myts->htmlSpecialChars($m['cat_title']) . "</option>\n";
			}
?>
		</select>
		<input type='hidden' name='mode' value='<?php echo $mode ?>' /></td>
		</tr>
		<tr class='bg3'>
		<td align='center' colspan="2"><span class='fg2'>
		<input type="submit" name="submit" value="<?php echo _AM_SOCIALNET_REMOVECATEGORY;?>" /></td></tr>
		</table></table></form>
		<?php

		}
		break;
	case 'addcat' :
		$myts = & MyTextSanitizer :: getInstance();
		if (isset ($_POST['submit']) && $_POST['submit'] != "") {
			$nextid = $xoopsDB->genId($xoopsDB->prefix("socialnet_forumcategories") . "_cat_id_seq");
			$sql = "SELECT max(cat_order) AS highest FROM " . $xoopsDB->prefix("socialnet_forumcategories") . "";
			if (!$r = $xoopsDB->query($sql)) {
				redirect_header("./admin_forumbegin.php", 1);
				exit ();
			}
			list ($highest) = $xoopsDB->fetchRow($r);
			$highest++;
			$title = $myts->addSlashes($title);
			$sql = "INSERT INTO " . $xoopsDB->prefix("socialnet_forumcategories") . " (cat_id, cat_title, cat_order) VALUES ($nextid, '$title', '$highest')";
			if (!$result = $xoopsDB->query($sql)) {
				redirect_header("./admin_forumbegin.php", 1);
				exit ();
			}
			redirect_header("./admin_forumbegin.php", 1, _AM_SOCIALNET_CATEGORYCREATED);
		} else {
			xoops_cp_header();
// OK Correct Create new category
adminmenu(27);
			echo "<table width='100%' border='0' cellspacing='1' class='outer'>" .
			"<tr><td class=\"odd\">";
			echo "<a href='./admin_forumbegin.php'><h4>" . _AM_SOCIALNET_FORUMCONF . "</h4></a>";
?>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method='post'>
		<table border="0" cellpadding="1" cellspacing="0" align='center' Valign="TOP" width="95%"><tr><td class='bg2'>
		<table border="0" cellpadding="1" cellspacing="1" width="100%">
		<tr class='bg3' align='left'>
		<td align='center' colspan="2"><span class='fg2'><b><?php echo _AM_SOCIALNET_CREATENEWCATEGORY;?></b></span></td>
		</tr>
		<tr class='bg1' align='left'>
		<td><span class='fg2'><?php echo _AM_SOCIALNET_CATEGORYTITLE;?></span></td>
		<td><input type="text" name="title" size="40" maxlength="100"></td>
		</tr>
		<tr class='bg3' align="left">
		<td align='center' colspan="2">
		<input type="hidden" name="mode" value="addcat" />
		<input type="submit" name="submit" value="<?php echo _AM_SOCIALNET_CREATENEWCATEGORY;?>" />&nbsp;&nbsp;
		<input type="reset" value="<?php echo _AM_SOCIALNET_CLEAR;?>" />
		</td>
		</tr>
		</tr>
		</table></td></tr></table>
		<?php

		}
		break;
	case 'addforum' :
	
		$myts = & MyTextSanitizer :: getInstance();
		if (isset ($_POST['submit']) && $_POST['submit'] != "") {
			if ($name == '' || $desc == '' || !is_array($mods)) {
				xoops_cp_header();

				echo "<table width='100%' border='0' cellspacing='1' class='outer'>" .
				"<tr><td class=\"odd\">";
				echo "<a href='./admin_forumbegin.php'><h4>" . _AM_SOCIALNET_FORUMCONF . "</h4></a>";
				echo _AM_SOCIALNET_YDNFOATPOTFDYAA;
				echo "</td></tr></table>";
				xoops_cp_footer();
				exit ();
			}
			$desc = $myts->addSlashes($_POST['desc']);
			$name = $myts->addSlashes($_POST['name']);
			$html = intval($_POST['html']);

			$allow_upload = intval($_POST['allow_upload']);
			$show_name = intval($_POST['show_name']);
			$show_icons_panel = intval($_POST['show_icons_panel']);
			$show_smilies_panel = intval($_POST['show_smilies_panel']);
			$sig = intval($_POST['sig']);
			$ppp = intval($_POST['ppp']);
			$hot = intval($_POST['hot']);
			$tpp = intval($_POST['tpp']);
			$nextid = $xoopsDB->genId($xoopsDB->prefix('socialnet_forums') . "_forum_id_seq");

			$sql = "INSERT INTO " . $xoopsDB->prefix('socialnet_forums') . " (forum_id, forum_name, forum_desc, forum_access, cat_id, forum_type, allow_html, allow_sig,posts_per_page,hot_threshold,topics_per_page,show_name,show_icons_panel,show_smilies_panel, allow_upload) VALUES ($nextid, '$name', '$desc', $forum_access, $cat, $type, '$html', '$sig', $ppp, $hot, $tpp, '$show_name', '$show_icons_panel', '$show_smilies_panel', '$allow_upload')";
			if (!$result = $xoopsDB->query($sql)) {
				redirect_header("./admin_forumbegin.php", 1);
				exit ();
			}
			if ($nextid == 0) {
				$nextid = $xoopsDB->getInsertId();
			}
			// RMV-NOTIFY
			$tags = array ();
			$tags['FORUM_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/forumview.php?forum=' . $nextid;
			$tags['FORUM_NAME'] = $name;
			$tags['FORUM_DESCRIPTION'] = $desc;
			$notification_handler = & xoops_gethandler('notification');
			$notification_handler->triggerEvents('global', 0, 'new_forum', $tags);

			$count = 0;
			while (list ($mod_number, $mod) = each($_POST["mods"])) {
				$mod_data = new XoopsUser($mod);
				if ($mod_data->isActive() && $mod_data->level() < 2) {
					if (!isset ($user_query)) {
						$user_query = "UPDATE " . $xoopsDB->prefix("users") . " SET level = 2 WHERE ";
					}
					if ($count > 0) {
						$user_query .= "OR ";
					}
					$user_query .= "uid = $mod ";
					$count++;
				}
				$mod_query = "INSERT INTO " . $xoopsDB->prefix("socialnet_forummods") . " (forum_id, user_id) VALUES ($nextid, $mod)";
				if (!$xoopsDB->query($mod_query)) {
					redirect_header("./admin_forumbegin.php", 1);
					exit ();
				}
			}

			if (isset ($user_query)) {
				if (!$xoopsDB->query($user_query)) {
					redirect_header("./admin_forumbegin.php", 1);
					exit ();
				}
			}
			redirect_header("./admin_forumbegin.php", 1, _AM_SOCIALNET_FORUMCREATED);
		} else {	// Mode Edition
			$sql = "SELECT count(*) AS total FROM " . $xoopsDB->prefix("socialnet_forumcategories") . "";
			if (!$r = $xoopsDB->query($sql)) {
				redirect_header("./admin_forumbegin.php", 1);
				exit ();
			}
			xoops_cp_header();
// OK Correct Add Forum category
adminmenu(23);
			echo "<table width='100%' border='0' cellspacing='1' class='outer'>" .
			"<tr><td class=\"odd\">";
			echo "<a href='./admin_forumbegin.php'><h4>" . _AM_SOCIALNET_FORUMCONF . "</h4></a>";
			list ($total) = $xoopsDB->fetchRow($r);
			if ($total < 1 || !isset ($total)) {
				echo _AM_SOCIALNET_EYMAACBYAF;
				echo "</td></tr></table>";
				xoops_cp_footer();
				exit ();
			}
?>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method='post'>
		<table border="0" cellpadding="1" cellspacing="0" align='center' Valign="TOP" width="95%"><tr><td class='bg2'>
		<table border="0" cellpadding="1" cellspacing="1" width="100%">
		<tr class='bg3' align='left'>
		<td align='center' colspan="2"><span class='fg2'><b><?php echo _AM_SOCIALNET_CREATENEWFORUM;?></b></span></td>
		</tr>
		<tr class='bg1' align='left'>
		<td><span class='fg2'><?php echo _AM_SOCIALNET_FORUMNAME;?></span></td>
		<td><input type='text' name='name' SIZE="40" MAXLENGTH="150"></td>
		</tr>
		<tr class='bg1' align='left'>
		<td><span class='fg2'><?php echo _AM_SOCIALNET_FORUMDESCRIPTION;?></span></td>
		<td><TEXTAREA name='desc' ROWS="15" COLS="45" WRAP="VIRTUAL"></TEXTAREA></td>
		</tr>
		<tr class='bg1' align='left'>
		<td><span class='fg2'><?php echo _AM_SOCIALNET_MODERATOR;?></span></td>
		<td><select name='mods[]' size='5' multiple='multiple'>
		<?php

			$sql = "SELECT uid, uname FROM " . $xoopsDB->prefix('users') . " WHERE uid > 0 AND level > 0 ORDER BY uname";
			if (!$result = $xoopsDB->query($sql)) {
				echo "</td></tr></table>";
				xoops_cp_footer();
				exit ();
			}
			if ($myrow = $xoopsDB->fetchArray($result)) {
				do {
					echo "<option value=\"" . $myrow['uid'] . "\">" . $myrow['uname'] . "</option>\n";
				} while ($myrow = $xoopsDB->fetchArray($result));
			} else {
				echo "<option value=\"0\">" . _AM_SOCIALNET_NONE . "</option>\n";
			}
?>
		</select></td>
		</tr>
		<tr class='bg1' align='left'>
		<td><span class='fg2'><?php echo _AM_SOCIALNET_CATEGORY;?></span></td>
		<td><select name="cat">
		<?php

			$sql = "SELECT * FROM " . $xoopsDB->prefix('socialnet_forumcategories') . "";
			if (!$result = $xoopsDB->query($sql)) {
				echo "</td></tr></table>";
				xoops_cp_footer();
				exit ();
			}
			if ($myrow = $xoopsDB->fetchArray($result)) {

				$defaultcateg = '';
				if (isset ($_GET['Category'])) {
					$defaultcateg = $_GET['Category'];
				}
				do {
					$selected = '';
					if ($myrow['cat_id'] == $defaultcateg) {
						$selected = ' selected';
					}
					echo "<option value=\"" . $myrow['cat_id'] . '"' . $selected . ">" . $myrow['cat_title'] . "</option>\n";
				} while ($myrow = $xoopsDB->fetchArray($result));
			} else {
				echo "<option value=\"0\">" . _AM_SOCIALNET_NONE . "</option>\n";
			}
?>
		</select></td>
		</tr>
		<tr class='bg1' align='left'>
		<td><span class='fg2'><?php echo _AM_SOCIALNET_ACCESSLEVEL;?></span></td>
		<td><select name="forum_access">
		<option value="2"><?php echo _AM_SOCIALNET_ANONYMOUSPOST;?></option>
		<option value="1"><?php echo _AM_SOCIALNET_REGISTERUSERONLY;?></option>
		<option value="3"><?php echo _AM_SOCIALNET_MODERATORANDADMINONLY;?></option>
		</select>
		</td>
		</tr>
		<tr class='bg1' align='left'>
		<td><span class='fg2'><?php echo _AM_SOCIALNET_TYPE;?></span></td>
        	<td><select name="type">
        	<option value="0"><?php echo _AM_SOCIALNET_PUBLIC;?></option>
        	<option value="1"><?php echo _AM_SOCIALNET_PRIVATE;?></option>
        	</select>
        	</td>
		</tr>
		<?php
			echo "<tr class='bg1' align='left'><td><span class='fg2'>" . _AM_SOCIALNET_ALLOW_UPLOAD . "</span></td>			<td><input type='radio' name='allow_upload' value='1' />" . _AM_SOCIALNET_YES . "<input type='radio' name='allow_upload' value='0' checked='checked'  />" . _AM_SOCIALNET_NO . "</td></tr>";
			echo "<tr class='bg1' align='left'><td><span class='fg2'>" . _AM_SOCIALNET_ALLOWHTML . "</span></td>			<td><input type='radio' name='html' value='1' />" . _AM_SOCIALNET_YES . "<input type='radio' name='html' value='0' checked='checked'  />" . _AM_SOCIALNET_NO . "</td></tr>
					<tr class='bg1' align='left'><td><span class='fg2'>" . _AM_SOCIALNET_ALLOWSIGNATURES . "</span></td>
					<td><input type='radio' name='sig' value='1' checked='checked' />" . _AM_SOCIALNET_YES . "<input type='radio' name='sig' value='0' />" . _AM_SOCIALNET_NO . "</td></tr>";

			echo "<tr class='bg1' align='left'><td><span class='fg2'>" . _AM_SOCIALNET_SHOWNAME . "</span></td>			<td><input type='radio' name='show_name' value='1' />" . _AM_SOCIALNET_YES . "<input type='radio' name='show_name' value='0' checked='checked' />" . _AM_SOCIALNET_NO . "</td></tr>";
			echo "<tr class='bg1' align='left'><td><span class='fg2'>" . _AM_SOCIALNET_SHOWICONSPANEL . "</span></td>			<td><input type='radio' name='show_icons_panel' value='1' checked='checked' />" . _AM_SOCIALNET_YES . "<input type='radio' name='show_icons_panel' value='0' />" . _AM_SOCIALNET_NO . "</td></tr>";
			echo "<tr class='bg1' align='left'><td><span class='fg2'>" . _AM_SOCIALNET_SHOWSMILIESPANEL . "</span></td>			<td><input type='radio' name='show_smilies_panel' value='1' checked='checked' />" . _AM_SOCIALNET_YES . "<input type='radio' name='show_smilies_panel' value='0' />" . _AM_SOCIALNET_NO . "</td></tr>";

			echo "<tr class='bg1' align='left'><td><span class='fg2'>" . _AM_SOCIALNET_HOTTOPICTHRESHOLD . "</span></td><td><input type='text' name='hot' size='3' maxlength='3' value='10' /></td></tr>
					<tr class='bg1' align='left'><td><span class='fg2'>" . _AM_SOCIALNET_POSTPERPAGE . "</span><br /><span class='fg2'><i>" . _AM_SOCIALNET_TITNOPPTTWBDPPOT . "</i></span></td>
					<td><input type='text' name='ppp' size='3' maxlength='3' value='10' /></td></tr>
					<tr class='bg1' align='left'><td><span class='fg2'>" . _AM_SOCIALNET_TOPICPERFORUM . "</span><br /><span class='fg2'><i>" . _AM_SOCIALNET_TITNOTPFTWBDPPOAF . "</i></span></td><td><input type='text' name='tpp' size='3' maxlength='3' value='20' /></td></tr>";
?>
		<tr class='bg3' align='left'>
		<td align='center' colspan="2">
		<input type="hidden" name="mode" value="addforum" />
		<input type="submit" name="submit" value="<?php echo _AM_SOCIALNET_CREATENEWFORUM;?>" />&nbsp;&nbsp;
		<input type="reset" value="<?php echo _AM_SOCIALNET_CLEAR;?>" />
		</td>
		</tr>
		</tr>
		</table></td></tr></table>
		<?php

		}
		break;

	case 'catorder' :

		$myts = & MyTextSanitizer :: getInstance();
		xoops_cp_header();
adminmenu(30);
		echo "<table width='100%' border='0' cellspacing='1' class='outer'>" .
		"<tr><td class=\"odd\">";
		echo "<a href='./admin_forumbegin.php'><h4>" . _AM_SOCIALNET_FORUMCONF . "</h4></a>";
		//    update catagories set cat_order = cat_order + 1 WHERE cat_order >= 2; update catagories set cat_order = cat_order - 2 where cat_id = 3;
		if (isset ($up) && $up != "") {
			if ($current_order > 1) {
				$order = $current_order -1;
				$sql1 = "UPDATE " . $xoopsDB->prefix("socialnet_forumcategories") . " SET cat_order = $order WHERE cat_id = $cat_id";
				if (!$r = $xoopsDB->query($sql1)) {
					echo "</td></tr></table>";
					xoops_cp_footer();
					exit ();
				}
				$sql2 = "UPDATE " . $xoopsDB->prefix("socialnet_forumcategories") . " SET cat_order = $current_order WHERE cat_id = $last_id";
				if (!$r = $xoopsDB->query($sql2)) {
					echo "</td></tr></table>";
					xoops_cp_footer();
					exit ();
				}
				echo "<div>" . _AM_SOCIALNET_CATEGORYMOVEUP . "</div><br />";
			} else {
				echo "<div>" . _AM_SOCIALNET_TCIATHU . "</div><br />";
			}
		} else
			if (isset ($down) && $down != "") {
				$sql = "SELECT cat_order FROM " . $xoopsDB->prefix("socialnet_forumcategories") . " ORDER BY cat_order DESC";
				if (!$r = $xoopsDB->query($sql, 1, 0)) {
					echo "</td></tr></table>";
					xoops_cp_footer();
					exit ();
				}
				list ($last_number) = $xoopsDB->fetchRow($r);
				if ($last_number != $current_order) {
					$order = $current_order +1;
					$sql = "UPDATE " . $xoopsDB->prefix("socialnet_forumcategories") . " SET cat_order = $current_order WHERE cat_order = $order";
					if (!$r = $xoopsDB->query($sql)) {
						echo "</td></tr></table>";
						xoops_cp_footer();
						exit ();
					}
					$sql = "UPDATE " . $xoopsDB->prefix("socialnet_forumcategories") . " SET cat_order = $order where cat_id = $cat_id";
					if (!$r = $xoopsDB->query($sql)) {
						echo "</td></tr></table>";
						xoops_cp_footer();
						exit ();
					}
					echo "<div>" . _AM_SOCIALNET_CATEGORYMOVEDOWN . "</div><br />";
				} else {
					echo "<div>" . _AM_SOCIALNET_TCIATLD . "</div><br />";
				}
			}
?>
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method='post'>
    <table border="0" cellpadding="1" cellspacing="0" align='center' Valign="TOP" width="95%"><tr><td class='bg2'>
	<table border="0" cellpadding="1" cellspacing="1" width="100%">
	<tr class='bg3' align='left'>
    <td align='center' colspan="3"><span class='fg2'><b><?php echo _AM_SOCIALNET_SETCATEGORYORDER;?></b></span><br />
    <?php echo _AM_SOCIALNET_TODHITOTCWDOTIP;?><br />
    <?php echo _AM_SOCIALNET_ECWMTCPUODITO;?></td>
    </tr>
    <tr class='bg3' align='center'>
    <td><?php echo _AM_SOCIALNET_CATEGORY1;?></td><td><?php echo _AM_SOCIALNET_MOVEUP;?></td><td><?php echo _AM_SOCIALNET_MOVEDOWN;?></td>
    </tr>
	<?php

		$sql = "SELECT * FROM " . $xoopsDB->prefix("socialnet_forumcategories") . " ORDER BY cat_order";
		if (!$r = $xoopsDB->query($sql)) {
			exit ();
		}
		while ($m = $xoopsDB->fetchArray($r)) {
			echo "<!-- New Row -->\n";
			echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" METHOD=\"POST\">\n";
			echo "<tr class='bg1' align='center'>\n";
			echo "<td>" . $myts->htmlSpecialChars($m['cat_title']) . "</td>\n";
			echo "<td><input type=\"hidden\" name=\"mode\" value=\"$mode\">\n";
			echo "<input type=\"hidden\" name=\"cat_id\" value=\"" . $m['cat_id'] . "\">\n";
			echo "<input type=\"hidden\" name=\"last_id\" value=\"";
			if (isset ($last_id)) {
				echo $last_id;
			}
			echo "\">\n";
			echo "<input type=\"hidden\" name=\"current_order\" value=\"" . $m['cat_order'] . "\"><input type=\"submit\" name=\"up\" value=\"" . _AM_SOCIALNET_MOVEUP . "\"></td>\n";
			echo "<td><input type=\"submit\" name=\"down\" value=\"" . _AM_SOCIALNET_MOVEDOWN . "\"></td></tr></form>\n<!-- End of Row -->\n";
			$last_id = $m['cat_id'];
		}
?>
    </TABLE></TABLE>
	<?php

		break;
	case 'sync' :
		if ($submit) {
			flush();
			syncex(null, "all forums");
			flush();
			syncex(null, "all topics");
			redirect_header("./admin_forumbegin.php", 1, _AM_SOCIALNET_SYNCHING);
		} else {
			xoops_cp_header();
			echo "<table width='100%' border='0' cellspacing='1' class='outer'>" .
			"<tr><td class=\"odd\">";
			echo "<a href='./admin_forumbegin.php'><h4>" . _AM_SOCIALNET_FORUMCONF . "</h4></a>";
?>
		<table border="0" cellpadding="1" cellspacing="0" align="center" width="95%"><tr><td class='bg2'>
		<table border="0" cellpadding="1" cellspacing="1" width="100%">
		<tr class='bg3' align='left'>
		<td><?php echo _AM_SOCIALNET_CLICKBELOWSYNC;?></td>
		</tr>
		<tr class='bg1' align='center'>
		<td><form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		<input type="hidden" name="mode" value="<?php echo $mode?>"><input type="submit" name="submit" value="<?php echo _AM_SOCIALNET_SYNCFORUM;?>"></form></td>
		</td>
		</tr>
		</table>
		</td></tr></table>
		<?php

		}
		break;
}

echo "</td></tr></table>";
xoops_cp_footer();
?>
