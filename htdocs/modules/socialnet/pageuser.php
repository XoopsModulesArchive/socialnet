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

require 'header.php';
$xoopsOption['template_main'] = 'socialnet_userpage.html';
require_once XOOPS_ROOT_PATH.'/header.php';
// *******************************************************************************
// **** Main
// *******************************************************************************


$socialnet_handler = & xoops_getmodulehandler('socialnet', 'socialnet');
$allowhtml = socialnet_utils::getModuleOption('allowhtml');
$myts = & MyTextSanitizer::getInstance();

$is_admin = false;
$uid = 0;
if(is_object($xoopsUser)) {
	$uid = $xoopsUser->getVar('uid');
	if($xoopsUser->isAdmin($xoopsModule->getVar('mid'))) {
		$is_admin = true;
	}
	$xoopsTpl->assign('confirm_delete', socialnet_utils::javascriptLinkConfirm(_MD_SOCIALNET_ARE_YOU_SURE));
} else {
	if(!isset($_GET['page_id'])) {
		header('Location: pagelist.php');
	}
}

$xoopsTpl->assign('is_admin', $is_admin);
$page_id = 0;
if(isset($_GET['page_id'])) {
	$page_id = intval($_GET['page_id']);
}

$xoopsTpl->assign('allowrss', socialnet_utils::getModuleOption('allowrss'));
if(empty($page_id)) {	// Show current user's page
	$xoopsTpl->assign('currentuser', true);
	$criteria = new Criteria('up_uid', $uid, '=');
	$cnt = $socialnet_handler->getCount($criteria);
	if($cnt>0) {
		$pagetbl = $socialnet_handler->getObjects($criteria);
		$page = $pagetbl[0];
	} else {
		$page = $socialnet_handler->create(true);
	}
} else {	// Shows a user's page
	// Is this the current user's page ?
	$xoopsTpl->assign('currentuser', false);
	$criteria = new Criteria('up_pageid', $page_id, '=');
	$cnt = $socialnet_handler->getCount($criteria);
	if($cnt > 0) {
		$pagetbl = $socialnet_handler->getObjects($criteria);
		$page = $pagetbl[0];
		if($page->getVar('up_uid') == $uid) {
			$xoopsTpl->assign('currentuser', true);
		}
	} else {	// Page not found
	    redirect_header(XOOPS_URL.'/index.php',2,_MD_SOCIALNET_PAGE_NOT_FOUND);
		exit();
	}
}
$page->setVar('dohtml',$allowhtml);		// Set html

if($page->getVar('up_pageid') !=0 ) {
	$xoopsTpl->assign('mail_cmd', 'mailto:?subject='.sprintf(_MD_SOCIALNET_INTARTICLE,$xoopsConfig['sitename']).'&amp;body='.sprintf(_MD_SOCIALNET_INTARTFOUND, $xoopsConfig['sitename']).':  '.XOOPS_URL.'/modules/socialnet/pageuser.php?page_id='.$page->getVar('up_pageid'));
	// Update counter (only if the user is not the owner and if the page exists)
	if($uid != $page->getVar('up_uid')) {
		$socialnet_handler->UpdateCounter($page->getVar('up_pageid'));
	}
} else {
	$xoopsTpl->assign('mail_cmd', '');
}
$xoopsTpl->assign('up_pageid',$page->getVar('up_pageid'));
$xoopsTpl->assign('up_title',$page->getVar('up_title'));
$xoopsTpl->assign('up_text',$page->getVar('up_text'));
$xoopsTpl->assign('up_created',$page->getVar('up_created'));
$xoopsTpl->assign('up_uid', $page->getVar('up_uid'));

$userName = '';
$page_user = null;
$page_user = new XoopsUser($page->getVar('up_uid'));
if(is_object($page_user)) {
	$userName = $page_user->getVar('uname');
	$xoopsTpl->assign('user_avatar', XOOPS_UPLOAD_URL.'/'.$page_user->getVar('user_avatar'));
	$xoopsTpl->assign('user_name', $userName);
	$xoopsTpl->assign('user_uname', $page_user->getVar('uname'));
	$xoopsTpl->assign('user_email', $page_user->getVar('email'));
	$xoopsTpl->assign('user_url', $page_user->getVar('url'));
	$xoopsTpl->assign('user_from', $page_user->getVar('user_from'));
	$xoopsTpl->assign('user_sig', $page_user->getVar('user_sig'));
}
$xoopsTpl->assign('up_uid', $page->getVar('up_uid'));


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
//$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/foot_panelstyle.css');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/barface.readyfunction.js');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jquery-1.3.2.min.js');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jixedbar-0.0.3-dev.js');
// SocialNetFaceStyle End here

//navbar
$xoopsTpl->assign('module_name',$xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection',_MD_SOCIALNET_YOUR_PAGE);
$xoopsTpl->assign('section_name',_MD_SOCIALNET_YOUR_PAGE);
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


if($page->getVar('up_created')!=0) {
	$xoopsTpl->assign('up_dateformated',formatTimestamp($page->getVar('up_created'), socialnet_utils::getModuleOption('dateformat')));
} else {
	$xoopsTpl->assign('up_dateformated','');
}
$xoopsTpl->assign('up_hits',$page->getVar('up_hits'));

$pagetitle = strip_tags($page->getVar('up_title')).' - '.$userName.' - '.$myts->htmlSpecialChars($xoopsModule->name());
$meta_keywords = socialnet_utils::createMetaKeywords(strip_tags($page->getVar('up_title')).' '.strip_tags($page->getVar('up_text')));
$meta_description = strip_tags($page->getVar('up_title'));

socialnet_utils::setMetas($pagetitle, $meta_description, $meta_keywords);

if(!empty($page_id)) {
	require_once XOOPS_ROOT_PATH.'/include/comment_view.php';
}

include("../../footer.php");
?>