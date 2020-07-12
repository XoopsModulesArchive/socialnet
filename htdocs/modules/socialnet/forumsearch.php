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

include_once 'header.php';
include_once 'forumfunctions.php';
// *******************************************************************************
// **** Main
// *******************************************************************************

if ( !isset($_POST['submit']) ) {
	$xoopsOption['template_main']= 'socialnet_forumsearch.html';
	include XOOPS_ROOT_PATH.'/header.php';
	$xoopsTpl->assign('xoops_pagetitle', strip_tags($xoopsModule->name() . ' - ' .  _MD_SOCIALNET_FORUM_ADVSEARCH));
	$xoopsTpl->assign("lang_keywords", _MD_SOCIALNET_FORUM_KEYWORDS);
	$xoopsTpl->assign("lang_searchany", _MD_SOCIALNET_FORUM_SEARCHANY);
	$xoopsTpl->assign("lang_searchall", _MD_SOCIALNET_FORUM_SEARCHALL);
	$xoopsTpl->assign("lang_forumc", _MD_SOCIALNET_FORUM_FORUMC);
	$xoopsTpl->assign("lang_searchallforums", _MD_SOCIALNET_FORUM_SEARCHALLFORUMS);
	$xoopsTpl->assign("lang_sortby", _MD_SOCIALNET_FORUM_SORTBY);
	$xoopsTpl->assign("lang_date", _MD_SOCIALNET_FORUM_DATE);
	$xoopsTpl->assign("lang_topic", _MD_SOCIALNET_FORUM_TOPIC);
	$xoopsTpl->assign("lang_forum", _MD_SOCIALNET_FORUM_FORUM);
	$xoopsTpl->assign("lang_username", _MD_SOCIALNET_FORUM_USERNAME);
	$xoopsTpl->assign("lang_searchin", _MD_SOCIALNET_FORUM_SEARCHIN);
	$xoopsTpl->assign("lang_subject", _MD_SOCIALNET_FORUM_SUBJECT);
	$xoopsTpl->assign("lang_body", _MD_SOCIALNET_FORUM_BODY);

	$query = 'SELECT forum_name, forum_id, forum_type FROM '.$xoopsDB->prefix('socialnet_forums')." ORDER BY cat_id, forum_name";
	if ( !$result = $xoopsDB->query($query) ) {
		exit("<big>"._MD_SOCIALNET_FORUM_ERROROCCURED."</big><hr />"._MD_SOCIALNET_FORUM_COULDNOTQUERY);
	}
	$select = '<select name="forum">';
	while ( $row = $xoopsDB->fetchArray($result) ) {
		$listinclude=true;
		if(is_object($xoopsUser)) {
			$uid=$xoopsUser->getVar('uid');
			if($row['forum_type']==1 && (!$xoopsUser->isAdmin($xoopsModule->mid()) || ! is_moderator($row['forum_id'], $uid))) {	// If we are on a private forum and the current user is not the admin or a moderator
				// We are searching user's perms for this forum
				$queryrv="select count(forum_id) as cpt from ".$xoopsDB->prefix('socialnet_forumaccess')." WHERE user_id=$uid and forum_id=".$row['forum_id'];
				if ( !$resultrv = $xoopsDB->queryF($queryrv) ) {
					$listinclude=false;
				} else {
					$rowrv = $xoopsDB->fetchArray($resultrv);
					if($rowrv['cpt']==0)
					{
						$listinclude=false;
					}
				}
			}
		} else {	// Anonymous user
			if($row['forum_type']==1) { // Anonymous users can't access private forums
				$listinclude=false;
			}
		}

		if($listinclude) {
			$select .= '<option value="'.$row['forum_id'].'">'.$row['forum_name'].'</option>';
		}
	}
	$select .= '</select>';
	$xoopsTpl->assign("forum_selection_box", $select);

} else {
	$xoopsOption['template_main']= 'socialnet_forumsearchresults.html';
	include XOOPS_ROOT_PATH."/header.php";
	$xoopsTpl->assign('xoops_pagetitle', strip_tags($xoopsModule->name() . ' - ' .  _MD_SOCIALNET_FORUM_SEARCHRESULTS));
	$forum = (isset($_POST['forum']) && $_POST['forum'] != 'all') ? intval($_POST['forum']) : 'all';
	$xoopsTpl->assign("lang_keywords", _MD_SOCIALNET_FORUM_KEYWORDS);
	$xoopsTpl->assign("lang_searchany", _MD_SOCIALNET_FORUM_SEARCHANY);
	$xoopsTpl->assign("lang_searchall", _MD_SOCIALNET_FORUM_SEARCHALL);
	$addquery = '';
	$subquery = '';
	$query = 'SELECT u.uid,f.forum_id, p.topic_id, u.uname, p.post_time,t.topic_title,t.topic_views,t.topic_replies,f.forum_name FROM '.$xoopsDB->prefix('socialnet_forumposts').' p, '.$xoopsDB->prefix('socialnet_forumposts_text').' pt, '.$xoopsDB->prefix('users').' u, '.$xoopsDB->prefix('socialnet_forums').' f,'.$xoopsDB->prefix('socialnet_forumtopics').' t';
	$myts = MyTextSanitizer::getInstance();
	if ( isset($_POST['term']) && trim($_POST['term']) != '' ) {
		$terms = split(' ', $myts->addSlashes($_POST['term']));		// Get all the words into an array
		if ( strlen($terms[0]) < 4 ) {

		}
		$addquery .= "(pt.post_text LIKE '%$terms[0]%'";
		$subquery .= "(t.topic_title LIKE '%$terms[0]%'";
		if ( $_POST['addterms'] == "any" ) {					// AND/OR relates to the ANY or ALL on Search Page
			$andor = 'OR';
		} else {
			$andor = 'AND';
		}
		$size = count($terms);
		for ( $i = 1; $i < $size; $i++ ) {
			if ( strlen($terms[$i]) < 4 ) {

			}
			$addquery .= " $andor pt.post_text LIKE '%$terms[$i]%'";
			$subquery .= " $andor t.topic_title LIKE '%$terms[$i]%'";
		}
		$addquery .= ')';
		$subquery .= ')';
	} else {
		redirect_header('forumsearch.php',1,_MD_SOCIALNET_FORUM_ERROROCCURED);
	}
	if ($forum !='all' ) {
		$forum = intval($_POST['forum']);
		$uid = isset($xoopsUser) && is_object($xoopsUser) ? $xoopsUser->getVar('uid') : 0;
		if(check_priv_forum_auth($uid,$forum,1)) {
			if ( isset($addquery) ) {
				$addquery .= ' AND ';
				$subquery .= ' AND ';
			}
			$addquery .= ' p.forum_id='.$forum;
			$subquery .= ' p.forum_id='.$forum;
		}
	}
	if ( isset($_POST['search_username']) && trim($_POST['search_username']) != '' ) {
		$search_username = $myts->addSlashes(trim($_POST['search_username']));
		if ( !$result = $xoopsDB->query("SELECT uid FROM ".$xoopsDB->prefix("users")." WHERE uname='$search_username'") ) {
			redirect_header('forumsearch.php',1,_MD_SOCIALNET_FORUM_ERROROCCURED);
			exit();
		}
		$row = $xoopsDB->fetchArray($result);
		if ( !$row ) {
			redirect_header('forumsearch.php',1,_MD_SOCIALNET_FORUM_USERNOEXIST);
			exit();
		}
		if ( isset($addquery) ) {
			$addquery .= " AND p.uid=".$row['uid']." AND u.uname='$search_username'";
			$subquery .= " AND p.uid=".$row['uid']." AND u.uname='$search_username'";
		} else {
			$addquery .= " p.uid=".$row['uid']." AND u.uname='$search_username'";
			$subquery .= " p.uid=".$row['uid']." AND u.uname='$search_username'";
		}
	}
	if ( isset($addquery) ) {
		switch ( $_POST['searchboth'] ) {
		case 'both':
			$query .= " WHERE ( ($subquery) OR ($addquery) ) AND ";
		    break;
		case 'title':
			$query .= " WHERE ( $subquery ) AND ";
			break;
		case 'text':
		default:
			$query .= " WHERE ( $addquery ) AND ";
			break;
		}
	} else {
		$query .= ' WHERE ';
	}
	$query .= ' p.post_id = pt.post_id AND p.topic_id = t.topic_id AND p.forum_id = f.forum_id AND p.uid = u.uid';

	if (isset($xoopsUser) && is_object($xoopsUser)) {
		$where=private_forums_list_cant_access($xoopsUser->getVar('uid'),'f.');
		if(strlen(trim($where))>0) {
			$query .= " AND (".$where.') ';
		}
	} else {	// Don't give any access to private forums for anonymous users
		$query .=' AND f.forum_type=0 ';
	}

	$allowed = array("t.topic_title", "t.topic_views", "t.topic_replies", "f.forum_name", "u.uname");
	$sortby = (!in_array($_POST['sortby'], $allowed)) ? "u.uid" : $_POST['sortby'];
	$query .= ' ORDER BY '.$sortby;
	if ( !$result = $xoopsDB->query($query,100,0) ) {
		exit("<big>"._MD_SOCIALNET_FORUM_ERROROCCURED."</big><hr />"._MD_SOCIALNET_FORUM_COULDNOTQUERY);
	}
	if ( !$row = $xoopsDB->getRowsNum($result) ) {
		$xoopsTpl->assign("lang_nomatch", _MD_SOCIALNET_FORUM_NOMATCH);
	} else {
		while ( $row = $xoopsDB->fetchArray($result) ) {
			$user_name=$myts->htmlSpecialChars($row['uname']);
			if(get_show_name($row['forum_id'])) {
				$user_name=username($row['uid']);

			}
			$xoopsTpl->append('results', array('forum_name' => $myts->htmlSpecialChars($row['forum_name']), 'forum_id' => $row['forum_id'], 'topic_id' => $row['topic_id'], 'topic_title' => $myts->htmlSpecialChars($row['topic_title']), 'topic_replies' => $row['topic_replies'], 'topic_views' => $row['topic_views'], 'user_id' => $row['uid'], 'user_name' => $user_name, 'post_time' => formatTimestamp($row['post_time'], "m")));
		}
	}
}
$xoopsTpl->assign("lang_forumindex", sprintf(_MD_SOCIALNET_FORUM_FORUMINDEX,$xoopsConfig['sitename']));
$xoopsTpl->assign("lang_search", _MD_SOCIALNET_FORUM_SEARCH);
$xoopsTpl->assign("lang_forum", _MD_SOCIALNET_FORUM_FORUM);
$xoopsTpl->assign("lang_topic", _MD_SOCIALNET_FORUM_TOPIC);
$xoopsTpl->assign("lang_author", _MD_SOCIALNET_FORUM_AUTHOR);
$xoopsTpl->assign('lang_replies', _MD_SOCIALNET_FORUM_REPLIES);
$xoopsTpl->assign('lang_views', _MD_SOCIALNET_FORUM_VIEWS);
$xoopsTpl->assign("lang_possttime", _MD_SOCIALNET_FORUM_POSTTIME);
$xoopsTpl->assign("lang_searchresults", _MD_SOCIALNET_FORUM_SEARCHRESULTS);
$xoopsTpl->assign("img_folder", $bbImage['folder_topic']);


/**
* Adding to the module js and css of the lightbox and new ones
*/
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/socialnet.css');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/jquery.tabs.css');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/leftmenu.css');
// what browser they use if IE then add corrective script.
if(ereg('msie', strtolower($_SERVER['HTTP_USER_AGENT']))) {$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/jquery.tabs-ie.css');}

$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/jquery.lightbox-0.5.css');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jquery.js');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jquery.lightbox-0.5.js');
//$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/socialnet.js');

// SocialNetFaceStyle starts here
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/barfacestyle.css');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/barface.stylesheet.css');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/barface.readyfunction.js');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jquery-1.3.2.min.js');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jixedbar-0.0.3-dev.js');
// SocialNetFaceStyle End here

//navbar
$xoopsTpl->assign('module_name',$xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection',_MD_SOCIALNET_FORUM_FORUM);
$xoopsTpl->assign('section_name',_MD_SOCIALNET_FORUM_FORUM);
$xoopsTpl->assign('lang_home',_MD_SOCIALNET_HOME);
$xoopsTpl->assign('lang_photos',_MD_SOCIALNET_PHOTOS);
$xoopsTpl->assign('lang_friends',_MD_SOCIALNET_FRIENDS);
$xoopsTpl->assign('lang_audio',_MD_SOCIALNET_AUDIOS);
$xoopsTpl->assign('lang_videos',_MD_SOCIALNET_VIDEOS);
$xoopsTpl->assign('lang_scrapbook',_MD_SOCIALNET_SCRAPBOOK);
$xoopsTpl->assign('lang_profile',_MD_SOCIALNET_PROFILE);
$xoopsTpl->assign('lang_groups',_MD_SOCIALNET_GROUPS);
$xoopsTpl->assign('lang_configs',_MD_SOCIALNET_CONFIGSTITLE);
$xoopsTpl->assign('lang_search', _MD_SOCIALNET_SEARCH);
$xoopsTpl->assign('lang_membership', _MD_SOCIALNET_MEMBERSHIP);
$xoopsTpl->assign('lang_pagelist', _MD_SOCIALNET_PAGELIST);
$xoopsTpl->assign('lang_publish', _MD_SOCIALNET_PUBLISH);
$xoopsTpl->assign('lang_your_page', _MD_SOCIALNET_YOUR_PAGE);
$xoopsTpl->assign('lang_contactus', _MD_SOCIALNET_CONTACTUS);
$xoopsTpl->assign('lang_articles', _MD_SOCIAL_ARTICLES);
$xoopsTpl->assign('lang_popchatmenu', _MD_SOCIALNET_POPCHATMENU);
$xoopsTpl->assign('lang_forum', _MD_SOCIALNET_FORUM_FORUM);

include("../../footer.php");

?>
