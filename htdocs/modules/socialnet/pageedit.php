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
require_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
$xoopsOption['template_main'] = 'socialnet_pageedit.html';
require_once XOOPS_ROOT_PATH.'/header.php';
// *******************************************************************************
// **** Main
// *******************************************************************************

$socialnet_handler =& xoops_getmodulehandler('socialnet', 'socialnet');
$myts =& MyTextSanitizer::getInstance();

$op = 'edit';
if(isset($_GET['op'])) {
	$op = $_GET['op'];
} elseif(isset($_POST['op'])) {
	$op = $_POST['op'];
}


$uid = 0;
if(is_object($xoopsUser)) {
	$uid = $xoopsUser->getVar('uid');
} else {
	redirect_header(XOOPS_URL.'/index.php', 2, _MD_SOCIALNET_PAGE_NOT_FOUND);
	exit();
}

switch($op) {
	case 'edit':		// Edit the page
		$xoopsTpl->assign('op', $op);
		$criteria = new Criteria('up_uid', $uid, '=');
		$cnt = $socialnet_handler->getCount($criteria);
		if($cnt > 0) {
			$page = $socialnet_handler->getObjects($criteria);
			$pagetbl = $socialnet_handler->getObjects($criteria);
			$page = $pagetbl[0];
		} else {
			$page = $socialnet_handler->create(true);
		}
		$xoopsTpl->assign('up_pageid',$page->getVar('up_pageid','e'));
		$xoopsTpl->assign('up_title',$page->getVar('up_title','e'));
		$xoopsTpl->assign('up_text',$page->getVar('up_text','e'));
		$xoopsTpl->assign('up_created',$page->getVar('up_created','e'));
		$xoopsTpl->assign('up_hits',$page->getVar('up_hits','e'));
		// Page's title
		$xoopsTpl->assign('xoops_pagetitle', strip_tags(_MD_SOCIALNET_EDIT).' - '.$myts->htmlSpecialChars($xoopsModule->name()));
		$editor = socialnet_utils::getWysiwygForm('Editor', 'up_text', $page->getVar('up_text','e'), 15, 60, 'socialnet_hidden');
		$xoopsTpl->assign('editor',$editor->render());
		break;


	case 'save':		// Save the page after it was edited
		$criteria = new Criteria('up_uid', $uid, '=');
		$cnt = $socialnet_handler->getCount($criteria);
		if($cnt > 0) {
			$creation = false;
			$pagetbl = $socialnet_handler->getObjects($criteria);
			$page = $pagetbl[0];
			$page->unsetNew();
		} else {
			$creation = true;
			$page = $socialnet_handler->create(true);
			$page->setNew();
		}
		if($creation) {
			$page->setVar('up_uid',$uid);
			$page->setVar('up_created',time());
			$page->setVar('up_hits',0);
		}
		$up_title = isset($_POST['up_title']) ? $_POST['up_title'] : '';
		$up_text = isset($_POST['up_text']) ? $_POST['up_text'] : '';
		$page->setVar('up_title',$up_title);
		$page->setVar('up_text',$up_text);
		if($socialnet_handler->insert($page,true)) {
			socialnet_utils::updateCache();		// Remove module's cache
			redirect_header('pageuser.php',1,_MD_SOCIALNET_DB_OK);
		} else {
			redirect_header('pageuser.php',2,_MD_SOCIALNET_DB_PB);
		}
		break;
}

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
$xoopsTpl->assign('lang_mysection',_MD_SOCIALNET_PUBLISH);
$xoopsTpl->assign('section_name',_MD_SOCIALNET_PUBLISH);
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
$xoopsTpl->assign('lang_pagelist', _MD_SOCIALNET_PAGELIST);
$xoopsTpl->assign('lang_publish', _MD_SOCIALNET_PUBLISH);
$xoopsTpl->assign('lang_contactus', _MD_SOCIALNET_CONTACTUS);
$xoopsTpl->assign('lang_articles', _MD_SOCIAL_ARTICLES);
$xoopsTpl->assign('lang_popchatmenu', _MD_SOCIALNET_POPCHATMENU);
$xoopsTpl->assign('lang_forum', _MD_SOCIALNET_FORUM_FORUM);

include '../../footer.php';
?>
