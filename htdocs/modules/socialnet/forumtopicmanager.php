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

include "header.php";
if ( isset($_POST['submit']) ) {
	foreach (array('forum', 'topic_id', 'newforum') as $getint) {
	    ${$getint} = isset($_POST[$getint]) ? intval($_POST[$getint]) : 0;
    }
} else {
	foreach (array('forum', 'topic_id') as $getint) {
		${$getint} = isset($_GET[$getint]) ? intval($_GET[$getint]) : 0;
	}
}
$accesserror = 0;
if ( is_object($xoopsUser)) {
	if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) {
		if ( !is_moderator($forum, $xoopsUser->uid()) ) {
			$accesserror = 1;
		}
	}
} else {
	$accesserror = 1;
}
if ( $accesserror == 1 ) {
	redirect_header("forumviewtopic.php?topic_id=$topic_id&amp;post_id=$post_id&amp;order=$order&amp;viewmode=$viewmode&amp;pid=$pid&amp;forum=$forum",3,_MD_SOCIALNET_FORUM_YANTMOTFTYCPTF);
	exit();
}

include XOOPS_ROOT_PATH.'/header.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/class/socialnet_forumsfiles.class.php';
OpenTable();
if ( ! empty($_POST['submit']) ) {
	switch ($_POST['mode']) {
	case 'del':
		// Update the users's post count, this might be slow on big topics but it makes other parts of the
	    // forum faster so we win out in the long run.
		$sql = "SELECT uid, post_id FROM ".$xoopsDB->prefix("socialnet_forumposts")." WHERE topic_id = $topic_id";
		if ( !$r = $xoopsDB->query($sql) ) {
			exit(_MD_SOCIALNET_FORUM_COULDNOTQUERY);
		}
		while ( $row = $xoopsDB->fetchArray($r) ) {
			if ( $row['uid'] != 0 ) {
				$sql = sprintf("UPDATE %s SET posts = posts - 1 WHERE uid = %u", $xoopsDB->prefix("users"), $row['uid']);
	    		$xoopsDB->query($sql);
	 		}
		}

		// Get the post ID's we have to remove.
		$sql = "SELECT post_id FROM ".$xoopsDB->prefix("socialnet_forumposts")." WHERE topic_id = $topic_id";
		if ( !$r = $xoopsDB->query($sql) ) {
			exit(_MD_SOCIALNET_FORUM_COULDNOTQUERY);
		}
		while ( $row = $xoopsDB->fetchArray($r) ) {
			$posts_to_remove[] = $row['post_id'];
		}

		$sql = sprintf("DELETE FROM %s WHERE topic_id = %u", $xoopsDB->prefix("socialnet_forumposts"), $topic_id);
		if ( !$result = $xoopsDB->query($sql) ) {
			exit(_MD_SOCIALNET_FORUM_COULDNOTREMOVE);
		}
		$sql= sprintf("DELETE FROM %s WHERE topic_id = %u", $xoopsDB->prefix("socialnet_forumtopics"), $topic_id);
		if ( !$result = $xoopsDB->query($sql) ) {
			exit(_MD_SOCIALNET_FORUM_COULDNOTQUERY);
		}

		$sql = "DELETE FROM ".$xoopsDB->prefix("socialnet_forumposts_text")." WHERE ";
		for ( $x = 0; $x < count($posts_to_remove); $x++ ) {
			if ( $set ) {
				$sql .= " OR ";
			}
			$sql .= "post_id = ".$posts_to_remove[$x];
			$set = true;
		}

		if ( !$xoopsDB->query($sql) ) {
			exit(_MD_SOCIALNET_FORUM_COULDNOTREMOVETXT);
		}
		// Delete attached files
		if(count($post_to_remove) > 0) {
			$file = new socialnet_sFiles();
			foreach($posts_to_remove as $postid) {
				$file->deletePost($postid);
			}
		}
		syncex($forum, 'forum');
		// RMV-NOTIFY
		xoops_notification_deletebyitem ($xoopsModule->getVar('mid'), 'thread', $topic_id);
		echo _MD_SOCIALNET_FORUM_TTHBRFTD."<p><a href='forumview.php?forum=$forum'>"._MD_SOCIALNET_FORUM_RETURNTOTHEFORUM."</a></p><p><a href='forumstart.php'>"._MD_SOCIALNET_FORUM_RTTFI."</a></p>";
		break;
	case 'move':
		if ($newforum > 0) {
			$sql = sprintf("UPDATE %s SET forum_id = %u WHERE topic_id = %u", $xoopsDB->prefix("socialnet_forumtopics"), $newforum, $topic_id);
	    	if ( !$r = $xoopsDB->query($sql) ) {
				exit(_MD_SOCIALNET_FORUM_EPGBATA);
			}
			$sql = sprintf("UPDATE %s SET forum_id = %u WHERE topic_id = %u", $xoopsDB->prefix("socialnet_forumposts"), $newforum, $topic_id);
			if ( !$r = $xoopsDB->query($sql) ) {
				exit(_MD_SOCIALNET_FORUM_EPGBATA);
			}
			syncex($newforum, 'forum');
			syncex($forum, 'forum');
		}
		echo _MD_SOCIALNET_FORUM_TTHBM."<p><a href='forumviewtopic.php?topic_id=$topic_id&amp;forum=$newforum'>"._MD_SOCIALNET_FORUM_VTUT."</a></p><p><a href='forumstart.php'>"._MD_SOCIALNET_FORUM_RTTFI."</a></p>";
		break;
	case 'lock':
		$sql = sprintf("UPDATE %s SET topic_status = 1 WHERE topic_id = %u", $xoopsDB->prefix("socialnet_forumtopics"), $topic_id);
	    if ( !$r = $xoopsDB->query($sql) ) {
			exit(_MD_SOCIALNET_FORUM_EPGBATA);
		}
		echo _MD_SOCIALNET_FORUM_TTHBL."<p><a href='forumviewtopic.php?topic_id=$topic_id&amp;forum=$forum'>"._MD_SOCIALNET_FORUM_VIEWTHETOPIC."</a></p><p><a href='forumstart.php'>"._MD_SOCIALNET_FORUM_RTTFI."</a></p>";
		break;
	case 'unlock':
		$sql = sprintf("UPDATE %s SET topic_status = 0 WHERE topic_id = %u", $xoopsDB->prefix("socialnet_forumtopics"), $topic_id);
	    if ( !$r = $xoopsDB->query($sql) ) {
			exit("Error - Could not unlock the selected topic. Please go back and try again.");
		}
		echo _MD_SOCIALNET_FORUM_TTHBU."<p><a href='forumviewtopic.php?topic_id=$topic_id&amp;forum=$forum'>"._MD_SOCIALNET_FORUM_VIEWTHETOPIC."</a></p><p><a href='forumstart.php'>"._MD_SOCIALNET_FORUM_RTTFI."</a></p>";
		break;
	case 'sticky':
		$sql = sprintf("UPDATE %s SET topic_sticky = 1 WHERE topic_id = %u", $xoopsDB->prefix("socialnet_forumtopics"), $topic_id);
	    if ( !$r = $xoopsDB->query($sql) ) {
			exit("Error - Could not sticky the selected topic. Please go back and try again.");
		}
		echo _MD_SOCIALNET_FORUM_TTHBS."<p><a href='forumviewtopic.php?topic_id=$topic_id&amp;forum=$forum'>"._MD_SOCIALNET_FORUM_VIEWTHETOPIC."</a></p><p><a href='forumstart.php'>"._MD_SOCIALNET_FORUM_RTTFI."</a></p>";
		break;
	case 'unsticky':
		$sql = sprintf("UPDATE %s SET topic_sticky = 0 WHERE topic_id = %u", $xoopsDB->prefix("socialnet_forumtopics"), $topic_id);
	    if ( !$r = $xoopsDB->query($sql) ) {
			exit("Error - Could not unsticky the selected topic. Please go back and try again.");
		}
		echo _MD_SOCIALNET_FORUM_TTHBUS."<p><a href='forumviewtopic.php?topic_id=$topic_id&amp;forum=$forum'>"._MD_SOCIALNET_FORUM_VIEWTHETOPIC."</a></p><p><a href='forumstart.php'>"._MD_SOCIALNET_FORUM_RTTFI."</a></p>";
		break;
	}
} else {  // No submit
	$mode = $_GET['mode'];
    echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>
	<table border='0' cellpadding='1' cellspacing='0' align='center' width='95%'><tr><td class='bg2'>
	<table border='0' cellpadding='1' cellspacing='1' width='100%'>
	<tr class='bg3' align='left'>";
	switch ( $mode ) {
	case 'del':
		echo '<td colspan="2">'. _MD_SOCIALNET_FORUM_OYPTDBATBOTFTTY .'</td>';
		break;
	case 'move':
		echo '<td colspan="2">'._MD_SOCIALNET_FORUM_OYPTMBATBOTFTTY.'</td>';
		break;
	case 'lock':
		echo '<td colspan="2">'._MD_SOCIALNET_FORUM_OYPTLBATBOTFTTY.'</td>';
		break;
	case 'unlock':
		echo '<td colspan="2">'._MD_SOCIALNET_FORUM_OYPTUBATBOTFTTY.'</td>';
		break;
	case 'sticky':
		echo '<td colspan="2">'._MD_SOCIALNET_FORUM_OYPTSBATBOTFTTY.'</td>';
		break;
	case 'unsticky':
		echo '<td colspan="2">'._MD_SOCIALNET_FORUM_OYPTTBATBOTFTTY.'</td>';
		break;
	}
	echo '</tr>';

	if ( $mode == 'move' ) {
		echo '<tr>
		<td class="bg3">'._MD_SOCIALNET_FORUM_MOVETOPICTO.'</td>
		<td class="bg1"><select name="newforum" size="0">';
		$sql = "SELECT forum_id, forum_name FROM ".$xoopsDB->prefix("socialnet_forums")." WHERE forum_id != $forum ORDER BY forum_id";
		if ( $result = $xoopsDB->query($sql) ) {
			if ( $myrow = $xoopsDB->fetchArray($result) ) {
				do {
					echo "<option value='".$myrow['forum_id']."'>".$myrow['forum_name']."</option>\n";
				} while ( $myrow = $xoopsDB->fetchArray($result) );
			} else {
				echo "<option value='-1'>"._MD_SOCIALNET_FORUM_NOFORUMINDB."</option>\n";
			}
		} else {
			echo "<option value='-1'>"._MD_SOCIALNET_FORUM_DATABASEERROR."</option>\n";
		}
		echo '</select></td></tr>';
	}
	echo '<tr class="bg3">
	<td colspan="2" align="center">';

	switch ( $mode ) {
	case 'del':
		echo '<input type="hidden" name="mode" value="del" />
		<input type="hidden" name="topic_id" value="'.$topic_id.'" />
		<input type="hidden" name="forum" value="'.$forum.'" />
		<input type="submit" name="submit" value="'._MD_SOCIALNET_FORUM_DELTOPIC.'" />';
		break;
	case 'move':
		echo '<input type="hidden" name="mode" value="move" />
		<input type="hidden" name="topic_id" value="'.$topic_id.'" />
		<input type="hidden" name="forum" value="'.$forum.'" />
		<input type="submit" name="submit" value="'._MD_SOCIALNET_FORUM_MOVETOPIC.'" />';
		break;
	case 'lock':
		echo '<input type="hidden" name="mode" value="lock" />
		<input type="hidden" name="topic_id" value="'.$topic_id.'" />
		<input type="hidden" name="forum" value="'.$forum.'" />
		<input type="submit" name="submit" value="'._MD_SOCIALNET_FORUM_LOCKTOPIC.'" />';
		break;
	case 'unlock':
		echo '<input type="hidden" name="mode" value="unlock" />
		<input type="hidden" name="topic_id" value="'.$topic_id.'" />
		<input type="hidden" name="forum" value="'.$forum.'" />
		<input type="submit" name="submit" value="'._MD_SOCIALNET_FORUM_UNLOCKTOPIC.'" />';
		break;
	case 'sticky':
		echo "<input type='hidden' name='mode' value='sticky' />
		<input type='hidden' name='topic_id' value='$topic_id' />
		<input type='hidden' name='forum' value='$forum' />
		<input type='submit' name='submit' value='"._MD_SOCIALNET_FORUM_STICKYTOPIC."' />";
		break;
	case 'unsticky':
		echo "<input type='hidden' name='mode' value='unsticky' />
		<input type='hidden' name='topic_id' value='$topic_id' />
		<input type='hidden' name='forum' value='$forum' />
		<input type='submit' name='submit' value='". _MD_SOCIALNET_FORUM_UNSTICKYTOPIC."' />";
		break;
	}
	echo '</td></tr>
	</form>
	</table></td></tr></table>';
}
CloseTable();
include XOOPS_ROOT_PATH.'/footer.php';
?>
