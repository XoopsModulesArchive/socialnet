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
$xoopsOption['template_main']= 'socialnet_forumbegin.html';
include_once XOOPS_ROOT_PATH.'/header.php';
include_once XOOPS_ROOT_PATH.'/modules/socialnet/forumfunctions.php';
// *******************************************************************************
// **** Main
// *******************************************************************************

$myts =& MyTextSanitizer::getInstance();

$sql = 'SELECT c.* FROM '.$xoopsDB->prefix('socialnet_forumcategories').' c, '.$xoopsDB->prefix("socialnet_forums").' f WHERE f.cat_id=c.cat_id GROUP BY c.cat_id, c.cat_title, c.cat_order ORDER BY c.cat_order';
if ( !$result = $xoopsDB->query($sql) ) {
	redirect_header(XOOPS_URL.'/',1,_MD_SOCIALNET_FORUM_ERROROCCURED);
	exit();
}

$xoopsTpl->assign(array("lang_welcomemsg" => sprintf(_MD_SOCIALNET_FORUM_WELCOME,$xoopsConfig['sitename']), "lang_tostart" => _MD_SOCIALNET_FORUM_TOSTART, "lang_totaltopics" => _MD_SOCIALNET_FORUM_TOTALTOPICSC, "lang_totalposts" => _MD_SOCIALNET_FORUM_TOTALPOSTSC, "total_topics" => get_total_topicsex(), "total_posts" => get_total_postsex(0, 'all'), "lang_lastvisit" => sprintf(_MD_SOCIALNET_FORUM_LASTVISIT,formatTimestamp($last_visit)), "lang_currenttime" => sprintf(_MD_SOCIALNET_FORUM_TIMENOW,formatTimestamp(time(),"m")), "lang_forum" => _MD_SOCIALNET_FORUM_FORUM, "lang_topics" => _MD_SOCIALNET_FORUM_TOPICS, "lang_posts" => _MD_SOCIALNET_FORUM_POSTS, "lang_lastpost" => _MD_SOCIALNET_FORUM_LASTPOST, "lang_moderators" => _MD_SOCIALNET_FORUM_MODERATOR));

$viewcat = (!empty($_GET['cat'])) ? intval($_GET['cat']) : 0;
$categories = array();
while ( $cat_row = $xoopsDB->fetchArray($result) ) {
	$categories[] = $cat_row;
}

// Hack for viewing only authorized forums
if (isset($xoopsUser) && is_object($xoopsUser)) {
	$where=private_forums_list_cant_access($xoopsUser->getVar('uid'),'f.');
	if(strlen(trim($where))>0) {
		$where = "  (".$where.') ';
	} else {
		$where = " 1=1 ";
	}
} else {	// Don't give any access to private forums for anonymous users
	$where='f.forum_type=0 ';
}

//
$sql = 'SELECT f.*, u.uname, u.name, u.uid, p.topic_id, p.post_time, p.subject, p.icon FROM '.$xoopsDB->prefix('socialnet_forums').' f LEFT JOIN '.$xoopsDB->prefix('socialnet_forumposts').' p ON p.post_id = f.forum_last_post_id LEFT JOIN '.$xoopsDB->prefix('users').' u ON u.uid = p.uid';
if ( $viewcat != 0 ) {
	$sql .= ' WHERE f.cat_id = '.$viewcat. ' AND '.$where;
	$xoopsTpl->assign('forum_index_title', sprintf(_MD_SOCIALNET_FORUM_FORUMINDEX,$xoopsConfig['sitename']));
} else {
	$sql .= ' WHERE '.$where;
	$xoopsTpl->assign('forum_index_title', '');
}
$sql .= ' ORDER BY f.cat_id, f.forum_id';
if ( !$result = $xoopsDB->query($sql) ) {
	exit("Error");
}
$forums = array(); // RMV-FIX
while ( $forum_data = $xoopsDB->fetchArray($result) ) {
	$forums[] = $forum_data;
}
$cat_count = count($categories);
if ($cat_count > 0) {
	for ( $i = 0; $i < $cat_count; $i++ ) {
		$categories[$i]['cat_title'] = $myts->htmlSpecialChars($categories[$i]['cat_title']);
		if ( $viewcat != 0 && $categories[$i]['cat_id'] != $viewcat ) {
			$xoopsTpl->append("categories", $categories[$i]);
			continue;
		}
		$topic_lastread = socialnet_get_topics_viewed();
		foreach ( $forums as $forum_row ) {
			unset($last_post);
			if ( $forum_row['cat_id'] == $categories[$i]['cat_id'] ) {
				if ($forum_row['post_time']) {
					//$forum_row['subject'] = $myts->htmlSpecialChars($forum_row['subject']);
					$categories[$i]['forums']['forum_lastpost_time'][] = formatTimestamp($forum_row['post_time']);
					$last_post_icon = '<a href="'.XOOPS_URL.'/modules/socialnet/forumviewtopic.php?post_id='.$forum_row['forum_last_post_id'].'&amp;topic_id='.$forum_row['topic_id'].'&amp;forum='.$forum_row['forum_id'].'#forumpost'.$forum_row['forum_last_post_id'].'">';
					if ( $forum_row['icon'] ) {
						$last_post_icon .= '<img src="'.XOOPS_URL.'/images/subject/'.$forum_row['icon'].'" border="0" alt="" />';
					} else {
						$last_post_icon .= '<img src="'.XOOPS_URL.'/images/subject/icon1.gif" width="15" height="15" border="0" alt="" />';
					}
					$last_post_icon .= '</a>';

					//
					$panels_params=get_show_panels($forum_row['forum_id']);
					if(substr($panels_params,0,1)=='1') {
						$categories[$i]['forums']['forum_lastpost_icon'][] = $last_post_icon;
					} else {
						$categories[$i]['forums']['forum_lastpost_icon'][] = '';
					}

					if ( $forum_row['uid'] != 0 && $forum_row['uname'] ) {
						//
						$username=$forum_row['uname'];
						if(get_show_name($forum_row['forum_id'])) {
							if(trim($forum_row['name'])!='') {
								$username=$forum_row['name'];
							}
						}
						$categories[$i]['forums']['forum_lastpost_user'][] = '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$forum_row['uid'].'">' . $myts->htmlSpecialChars($username).'</a>';
					} else {
						$categories[$i]['forums']['forum_lastpost_user'][] = $xoopsConfig['anonymous'];
					}
					$forum_lastread = !empty($topic_lastread[$forum_row['topic_id']]) ? $topic_lastread[$forum_row['topic_id']] : false;
					if ( $forum_row['forum_type'] == 1 ) {
						$categories[$i]['forums']['forum_folder'][] = $bbImage['locked_forum'];
					} elseif ( $forum_row['post_time'] > $forum_lastread && !empty($forum_row['topic_id'])) {
						$categories[$i]['forums']['forum_folder'][] = $bbImage['newposts_forum'];
					} else {
						$categories[$i]['forums']['forum_folder'][] = $bbImage['folder_forum'];
					}
				} else {
					// no forums, so put empty values
					$categories[$i]['forums']['forum_lastpost_time'][] = "";
					$categories[$i]['forums']['forum_lastpost_icon'][] = "";
					$categories[$i]['forums']['forum_lastpost_user'][] = "";
					if ( $forum_row['forum_type'] == 1 ) {
						$categories[$i]['forums']['forum_folder'][] = $bbImage['locked_forum'];
					} else {
						$categories[$i]['forums']['forum_folder'][] = $bbImage['folder_forum'];
					}
				}
				$categories[$i]['forums']['forum_id'][] = $forum_row['forum_id'];
				$categories[$i]['forums']['forum_name'][] = $myts->htmlSpecialChars($forum_row['forum_name']);
				$categories[$i]['forums']['forum_desc'][] = $myts->displayTarea($forum_row['forum_desc']);
				$categories[$i]['forums']['forum_topics'][] = $forum_row['forum_topics'];
				$categories[$i]['forums']['forum_posts'][] = $forum_row['forum_posts'];
	 			$all_moderators = get_moderators($forum_row['forum_id']);
	 			$count = 0;
				$forum_moderators = '';
				foreach ( $all_moderators as $mods) {
					foreach ( $mods as $mod_id => $mod_name) {
						if ( $count > 0 ) {
							$forum_moderators .= ', ';
						}
						$forum_moderators .= '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$mod_id.'">'.$myts->htmlSpecialChars($mod_name).'</a>';
						$count = 1;
					}
				}
				$categories[$i]['forums']['forum_moderators'][] = $forum_moderators;
			}
		}
		$xoopsTpl->append("categories", $categories[$i]);
	}
} else {
	$xoopsTpl->append("categories", array());
}
$xoopsTpl->assign(array("img_hotfolder" => $bbImage['newposts_forum'], "img_folder" => $bbImage['folder_forum'], "img_locked" => $bbImage['locked_forum'], "lang_newposts" => _MD_SOCIALNET_FORUM_NEWPOSTS, "lang_private" => _MD_SOCIALNET_FORUM_PRIVATEFORUM, "lang_nonewposts" => _MD_SOCIALNET_FORUM_NONEWPOSTS, "lang_search" => _MD_SOCIALNET_FORUM_SEARCH, "lang_advsearch" => _MD_SOCIALNET_FORUM_ADVSEARCH));

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
