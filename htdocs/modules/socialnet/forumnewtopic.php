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

include 'header.php';
foreach (array('forum', 'order') as $getint) {
	${$getint} = isset($_GET[$getint]) ? intval($_GET[$getint]) : 0;
}
$viewmode = (isset($_GET['viewmode']) && $_GET['viewmode'] != 'flat') ? 'thread' : 'flat';
if ( empty($forum) ) {
	redirect_header("forumstart.php", 2, _MD_SOCIALNET_FORUM_ERRORFORUM);
	exit();
} else {
	$sql = "SELECT forum_type, forum_name, forum_access, allow_html, allow_sig, posts_per_page, hot_threshold, topics_per_page, allow_upload FROM ".$xoopsDB->prefix('socialnet_forums')." WHERE forum_id = $forum";
	if ( !$result = $xoopsDB->query($sql) ) {
		redirect_header('forumstart.php',4,_MD_SOCIALNET_FORUM_ERROROCCURED);
		exit();
	}
	$forumdata = $xoopsDB->fetchArray($result);
	if ( $forumdata['forum_type'] == 1 ) {
		// To get here, we have a logged-in user. So, check whether that user is allowed to post in this private forum.
		$accesserror = 0; //initialize
		if ( is_object($xoopsUser)) {
			//check if the user has forum admin right
			if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) {
				if ( !check_priv_forum_auth($xoopsUser->uid(), $forum, true) ) {
					$accesserror = 1;
				}
			}
		} else {
			$accesserror = 1;
		}
		if ( $accesserror == 1 ) {
			redirect_header("forumview.php?order=$order&viewmode=$viewmode&forum=$forum",2,_MD_SOCIALNET_FORUM_NORIGHTTOPOST);
			exit();
		}
		// Ok, looks like we're good.
	} else {
		$accesserror = 0;
		if ( $forumdata['forum_access'] == 3 ) {
			if ( is_object($xoopsUser)) {
				if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) {
					if ( !is_moderator($forum, $xoopsUser->uid()) ) {
						$accesserror = 1;
					}
				}
			} else {
				$accesserror = 1;
			}
		} elseif ( $forumdata['forum_access'] == 1 && !is_object($xoopsUser)) {
			$accesserror = 1;
		}
		if ( $accesserror == 1 ) {
			redirect_header("forumview.php?order=$order&viewmode=$viewmode&forum=$forum",2,_MD_SOCIALNET_FORUM_NORIGHTTOPOST);
			exit();
		}
    }
	include XOOPS_ROOT_PATH.'/header.php';
	$istopic = 1;
	$pid=0;
	$subject = '';
	$message = '';
	$myts =& MyTextSanitizer::getInstance();
	$hidden = '';
	unset($post_id);
	unset($topic_id);
	include 'include/socialnet_forumform.inc.php';



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


}
?>
