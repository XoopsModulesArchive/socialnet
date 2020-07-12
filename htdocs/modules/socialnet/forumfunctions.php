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

/*
 * Gets the total number of topics in a form
 */
function get_total_topicsex($forum_id="")
{
	global $xoopsDB;
	if ( $forum_id ) {
		$sql = "SELECT COUNT(*) AS total FROM ".$xoopsDB->prefix("socialnet_forumtopics")." WHERE forum_id = $forum_id";
	} else {
		$sql = "SELECT COUNT(*) AS total FROM ".$xoopsDB->prefix("socialnet_forumtopics");
	}
	if ( !$result = $xoopsDB->query($sql) ) {
		return _MD_SOCIALNET_FORUM_ERROR;
	}

	if ( !$myrow = $xoopsDB->fetchArray($result) ) {
		return _MD_SOCIALNET_FORUM_ERROR;
	}

	return $myrow['total'];
}

/*
 * Returns the total number of posts in the whole system, a forum, or a topic
 * Also can return the number of users on the system.
 */
function get_total_postsex($id, $type)
{
	global $xoopsDB;
	switch ( $type ) {
	case 'users':
		$sql = "SELECT COUNT(*) AS total FROM ".$xoopsDB->prefix("users")." WHERE (uid > 0) AND ( level >0 )";
	    break;
	case 'all':
		$sql = "SELECT COUNT(*) AS total FROM ".$xoopsDB->prefix("socialnet_forumposts");
	    break;
	case 'forum':
		$sql = "SELECT COUNT(*) AS total FROM ".$xoopsDB->prefix("socialnet_forumposts")." WHERE forum_id = $id";
	    break;
	case 'topic':
		$sql = "SELECT COUNT(*) AS total FROM ".$xoopsDB->prefix("socialnet_forumposts")." WHERE topic_id = $id";
	    break;
	// Old, we should never get this.
	case 'user':
		exit("Should be using the users.user_posts column for this.");
	}
	if ( !$result = $xoopsDB->query($sql) ) {
		return "ERROR";
	}
	if ( !$myrow = $xoopsDB->fetchArray($result) ) {
		return 0;
	}
	return $myrow['total'];
}

/*
 * Returns the most recent post in a forum, or a topic
 */
function get_last_postex($id, $type)
{
	global $xoopsDB;
	switch ( $type ) {
	case 'time_fix':
		$sql = "SELECT post_time FROM ".$xoopsDB->prefix("socialnet_forumposts")." WHERE topic_id = $id ORDER BY post_time DESC";
		break;
	case 'forum':
		$sql = "SELECT p.post_time, p.uid, u.uname FROM ".$xoopsDB->prefix("socialnet_forumposts")." p, ".$xoopsDB->prefix("users")." u WHERE p.forum_id = $id AND p.uid = u.uid ORDER BY post_time DESC";
		break;
	case 'topic':
		$sql = "SELECT p.post_time, u.uname FROM ".$xoopsDB->prefix("socialnet_forumposts")." p, ".$xoopsDB->prefix("users")." u WHERE p.topic_id = $id AND p.uid = u.uid ORDER BY post_time DESC";
		break;
	case 'user':
		$sql = "SELECT post_time FROM ".$xoopsDB->prefix("socialnet_forumposts")." WHERE uid = $id";
	    break;
	}
	if ( !$result = $xoopsDB->query($sql,1,0) ) {
		return _MD_SOCIALNET_FORUM_ERROR;
	}
	if ( !$myrow = $xoopsDB->fetchArray($result) ) {
		return _MD_SOCIALNET_FORUM_NOPOSTS;
	}
	if ( ($type != 'user') && ($type != 'time_fix') ) {
		$val = sprintf("%s <br /> %s %s", $myrow['post_time'], _MD_SOCIALNET_FORUM_BY, $myrow['uname']);
	} else {
		$val = $myrow['post_time'];
	}
	return $val;
}

//
/*
 * Returns true if a forum must replace the user's login with its real name
 */
function get_show_name($forum_id)
{
	global $xoopsDB;
	static $tbloptions= Array();
	if(is_array($tbloptions) && array_key_exists($forum_id,$tbloptions)) {
		return $tbloptions[$forum_id];
	} else {
		$sql = "SELECT show_name, forum_id FROM ".$xoopsDB->prefix('socialnet_forums');
		$result = $xoopsDB->query($sql);
		while($myrow = $xoopsDB->fetchArray($result)) {
			$tbloptions[$myrow['forum_id']]=$myrow['show_name'];
		}
		return $tbloptions[$forum_id];
	}
}


//
/*
 * Returns informations about a forum, do we have to display the icons panel and do whe have to show the smilies panel
 */
function get_show_panels($forum_id)
{
	global $xoopsDB;
	static $tbloptions2= Array();
	if(is_array($tbloptions2) && array_key_exists($forum_id,$tbloptions2)) {
		return $tbloptions2[$forum_id];
	} else {
		$sql = "SELECT show_icons_panel, show_smilies_panel, forum_id FROM ".$xoopsDB->prefix("socialnet_forums")." f";
		$result = $xoopsDB->query($sql);
		while($myrow = $xoopsDB->fetchArray($result) )
		{
			$tbloptions2[$myrow['forum_id']] = $myrow['show_icons_panel'].$myrow['show_smilies_panel'];
		}
		return $tbloptions2[$forum_id];
	}
}



//
/*
 * Returns a user's name
 */
function username($uid)
{
	global $xoopsDB;
	static $TblUser;
	if (isset($TblUser) && array_key_exists($uid,$TblUser))	{
		$ret=$TblUser[$uid];
	} else {
		$sql = "SELECT name FROM ".$xoopsDB->prefix("users")." WHERE uid= $uid";
		$ret = '';
		if ( $result = $xoopsDB->query($sql) ) {
			if ( $myrow = $xoopsDB->fetchRow($result) ) {
					$ret = $myrow[0];
			}
		}
		$TblUser[$uid]=$ret;
	}
	return $ret;
}

//
/*
 * Returns the list of private forums the user can't access
 */
function private_forums_list_cant_access($uid, $prefix)
{
	global $xoopsDB, $xoopsUser, $xoopsModuleConfig;
 	static $Tbllist;
 	$ret='';

	if($xoopsModuleConfig['confidentiality']==1) {
		return '';
	}

	if (isset($Tbllist) && array_key_exists($uid,$Tbllist)) {
		$ret=$Tbllist[$uid];
	} else {
 		$cpt=0;
 		$flist='';
 		$query="SELECT forum_id FROM ".$xoopsDB->prefix('socialnet_forums')." WHERE forum_type=1";
    	if (!$result = $xoopsDB->queryF($query)) {
	        return false;
	    }
	    while ($arr = $xoopsDB->fetchArray($result)) {
			$query2=sprintf("SELECT count(user_id) as cpt FROM %s WHERE user_id=%u AND forum_id=%u",$xoopsDB->prefix('socialnet_forumaccess'),$uid,$arr['forum_id']);
			if (!$result2 = $xoopsDB->queryF($query2)) {
				return false;
			}
			$arr2 = $xoopsDB->fetchArray($result2);
			if($arr2['cpt']==0 && !is_moderator($arr['forum_id'],$uid)) {
				$cpt++;
				$and='';
				if($cpt>1) {
					$and=' AND ';
				}
				$flist = $flist . $and . $prefix.'forum_id<>'.$arr['forum_id'];
			}
		}
		$ret=$flist;
		$Tbllist[$uid]=$flist;
	}
	return $ret;
}

/*
 * Returns an array of all the moderators of a forum
 */
function get_moderators($forum_id)
{
	global $xoopsDB;
	$forum_id = intval($forum_id);
	if(get_show_name($forum_id))
	{
		$sql = "SELECT u.uid, u.name as uname FROM ".$xoopsDB->prefix("users")." u, ".$xoopsDB->prefix("socialnet_forummods")." f WHERE f.forum_id = $forum_id and f.user_id = u.uid";
	} else {
		$sql = "SELECT u.uid, u.uname FROM ".$xoopsDB->prefix("users")." u, ".$xoopsDB->prefix("socialnet_forummods")." f WHERE f.forum_id = $forum_id and f.user_id = u.uid";
	}

	if ( !$result = $xoopsDB->query($sql) ) {
		return array();
	}
	if ( !$myrow = $xoopsDB->fetchArray($result) ) {
		return array();
	}
	do {
		$array[] = array($myrow['uid'] => $myrow['uname']);
	} while ( $myrow = $xoopsDB->fetchArray($result) );
	return $array;
}

/*
 * Checks if a user (user_id) is a moderator of a perticular forum (forum_id)
 * Retruns 1 if TRUE, 0 if FALSE or Error
 */
function is_moderator($forum_id, $user_id)
{
	global $xoopsDB;
	$forum_id = intval($forum_id);
	$user_id = intval($user_id);
	$sql = "SELECT COUNT(*) FROM ".$xoopsDB->prefix("socialnet_forummods")." WHERE forum_id = $forum_id AND user_id = $user_id";
	$ret = false;
	if ( $result = $xoopsDB->query($sql) ) {
		if ( $myrow = $xoopsDB->fetchRow($result) ) {
			if ( $myrow[0] > 0 ) {
				$ret = true;
			}
		}
	}
	return $ret;
}

/*
 * Checks if a topic is locked
 */
function is_lockedex($topic)
{
	global $xoopsDB;
	$ret = false;
	$topic = intval($topic);
	$sql = "SELECT topic_status FROM ".$xoopsDB->prefix("socialnet_forumtopics")." WHERE topic_id = $topic";
	if ( $r = $xoopsDB->query($sql) ) {
		if ( $m = $xoopsDB->fetchArray($r) ) {
			if ( $m['topic_status'] == 1 ) {
				$ret = true;
			}
		}
	}
	return $ret;
}

/**
 * Checks if the given userid is allowed to log into the given (private) forumid.
 * If the "is_posting" flag is true, checks if the user is allowed to post to that forum.
 */
function check_priv_forum_auth($userid, $forumid, $is_posting)
{
	global $xoopsDB;
	$userid = intval($userid);
	$forumid = intval($forumid);
	$sql = "SELECT count(*) AS user_count FROM ".$xoopsDB->prefix("socialnet_forumaccess")." WHERE (user_id = $userid) AND (forum_id = $forumid) ";

	if ( $is_posting ) {
		$sql .= "AND (can_post = 1)";
	}

	if ( !$result = $xoopsDB->query($sql) ) {
		// no good..
		return false;
	}

	if ( !$row = $xoopsDB->fetchArray($result) ) {
		return false;
	}

  	if ( $row['user_count'] <= 0 ) {
  		return false;
  	}

  	return true;
}

function make_jumpboxex($selected=0)
{
	global $xoopsDB;
	$myts = MyTextSanitizer::getInstance();
	$box = '<form action="forumview.php" method="get">
	<select name="forum">
	';
	$sql = 'SELECT cat_id, cat_title FROM '.$xoopsDB->prefix('socialnet_forumcategories').' ORDER BY cat_order';
	if ( $result = $xoopsDB->query($sql) ) {
		$myrow = $xoopsDB->fetchArray($result);
		$myrow['cat_title'] = $myts->htmlSpecialChars($myrow['cat_title']);
		do {
			$box .= '<option value="-1">________________</option>';
			$box .= '<option value="-1">'.$myrow['cat_title'].'</option>';
			//$box .= "<option value=\"-1\">----------------</option>\n";
			$sub_sql = "SELECT forum_id, forum_name FROM ".$xoopsDB->prefix("socialnet_forums")." WHERE cat_id ='".$myrow['cat_id']."' ORDER BY forum_id";
			if ( $res = $xoopsDB->query($sub_sql) ) {
				if ( $row = $xoopsDB->fetchArray($res) ) {
					do {
						$name = $myts->htmlSpecialChars($row['forum_name']);
						$box .= "<option value='".$row['forum_id']."'";
						if ( !empty($selected) && $row['forum_id'] == $selected ) {
							$box .= ' selected="selected"';
						}
						$box .= ">&nbsp;&nbsp;- $name</option>\n";
					} while ( $row = $xoopsDB->fetchArray($res) );
				}
			} else {
				$box .= "<option value=\"0\">ERROR</option>\n";
			}
		} while ( $myrow = $xoopsDB->fetchArray($result) );
	} else {
		$box .= "<option value=\"-1\">ERROR</option>\n";
	}
	$box .= "</select>\n<input type=\"submit\" class=\"formButton\" value=\""._MD_SOCIALNET_FORUM_GO."\" />\n</form>";
	return $box;
}

function syncex($id, $type)
{
	global $xoopsDB;
	$id = intval($id);
	switch ( $type ) {
	case 'forum':
		$sql = "SELECT MAX(post_id) AS last_post FROM ".$xoopsDB->prefix("socialnet_forumposts")." WHERE forum_id = $id";
   		if ( !$result = $xoopsDB->query($sql) ) {
			exit("Could not get post ID");
		}
   		if ( $row = $xoopsDB->fetchArray($result) ) {
			$last_post = $row['last_post'];
   		}

   		$sql = "SELECT COUNT(post_id) AS total FROM ".$xoopsDB->prefix("socialnet_forumposts")." WHERE forum_id = $id";
   		if ( !$result = $xoopsDB->query($sql) ) {
			exit("Could not get post count");
   		}
   		if ( $row = $xoopsDB->fetchArray($result) ) {
			$total_posts = $row['total'];
   		}

   		$sql = "SELECT COUNT(topic_id) AS total FROM ".$xoopsDB->prefix("socialnet_forumtopics")." WHERE forum_id = $id";
   		if ( !$result = $xoopsDB->query($sql) ) {
			exit("Could not get topic count");
   		}
   		if ( $row = $xoopsDB->fetchArray($result) ) {
			$total_topics = $row['total'];
   		}

		$sql = sprintf("UPDATE %s SET forum_last_post_id = %u, forum_posts = %u, forum_topics = %u WHERE forum_id = %u", $xoopsDB->prefix("socialnet_forums"), $last_post, $total_posts, $total_topics, $id);
   		if ( !$result = $xoopsDB->queryF($sql) ) {
			exit("Could not update forum $id");
   		}
		break;
	case 'topic':
		$sql = "SELECT max(post_id) AS last_post FROM ".$xoopsDB->prefix("socialnet_forumposts")." WHERE topic_id = $id";
   		if ( !$result = $xoopsDB->query($sql) ) {
			exit("Could not get post ID");
		}
		if ( $row = $xoopsDB->fetchArray($result) ) {
			$last_post = $row['last_post'];
		}
   		if ( $last_post > 0 ) {
			$sql = "SELECT COUNT(post_id) AS total FROM ".$xoopsDB->prefix("socialnet_forumposts")." WHERE topic_id = $id";
   			if ( !$result = $xoopsDB->query($sql) ) {
				exit("Could not get post count");
   			}
   			if ( $row = $xoopsDB->fetchArray($result) ) {
				$total_posts = $row['total'];
   			}
   			$total_posts -= 1;
			$sql = sprintf("UPDATE %s SET topic_replies = %u, topic_last_post_id = %u WHERE topic_id = %u", $xoopsDB->prefix("socialnet_forumtopics"), $total_posts, $last_post, $id);
   			if ( !$result = $xoopsDB->queryF($sql) ) {
				exit("Could not update topic $id");
   			}
		}
		break;
	case 'all forums':
		$sql = "SELECT forum_id FROM ".$xoopsDB->prefix("socialnet_forums");
   		if ( !$result = $xoopsDB->query($sql) ) {
			exit("Could not get forum IDs");
   		}
   		while ( $row = $xoopsDB->fetchArray($result) ) {
			$id = $row['forum_id'];
			syncex($id, "forum");
		}
		break;
	case 'all topics':
		$sql = "SELECT topic_id FROM ".$xoopsDB->prefix("socialnet_forumtopics");
	    if ( !$result = $xoopsDB->query($sql) ) {
			exit("Could not get topic ID's");
		}
		while ( $row = $xoopsDB->fetchArray($result) ) {
			$id = $row['topic_id'];
   			syncex($id, "topic");
   		}
		break;
	}
	return true;
}

// Functions for unserialize() vulnerability in < 4.3.10,
// based on the code provided by GIJOE
// Servers with 4.3.10 or up can use the code with serialize/unserialize
// functions, as commented out below
function socialnet_get_topics_viewed()
{
	if (empty($_COOKIE['socialnet_topics_viewed'])) {
		return array();
	}
	$topics_tmp = explode(',', $_COOKIE['socialnet_topics_viewed']);
	$topics = array();
	foreach ($topics_tmp as $tmp) {
 		$idmin = explode('|', $tmp);
 		$id = empty($idmin[0]) ? 0 : intval($idmin[0]);
 		$min = empty($idmin[1]) ? 0 : intval($idmin[1]);
 		$topics[$id] = $min * 60 ;
 	}
	//$topics = !empty($_COOKIE['socialnet_topic_lastread']) ? unserialize($_COOKIE['socialnet_topic_lastread']) : array();
	return $topics;
}

function socialnet_add_topics_viewed($topicsViewed, $topicId, $timeViewed, $cookiePath, $cookieDomain, $cookieSecure)
{
	$topicsViewed[$topicId] = time();
	arsort($topicsViewed);
	$counter = 300 ;
	foreach (array_keys($topicsViewed) as $id) {
		$tmp[] = intval($id) . '|' . intval(ceil($topicsViewed[$id] / 60));
		if (--$counter < 0) {
			break;
		}
	}
	setcookie('socialnet_topics_viewed', implode(',', $tmp), time()+365*24*3600, $cookiePath, $cookieDomain, $cookieSecure);
	//$topicsViewed[$topicId] = time();
	//setcookie('socialnet_topic_lastread', serialize($topicsViewed), time()+365*24*3600, $cookiePath, $cookieDomain, $cookieSecure);
}

function socialnet_isX23()
{
	$x23 = false;
	$xv = str_replace('XOOPS ','',XOOPS_VERSION);
	if(substr($xv,2,1) == '3') {
		$x23 = true;
	}
	return $x23;
}

?>
