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

include_once '../../mainfile.php';
$xoopsOption['template_main'] = 'socialnet_youtube.html';
include_once '../../header.php';
include_once 'class/socialnet_controler.php';
// *******************************************************************************
// **** Main
// *******************************************************************************

$controler = new SocialnetVideoControler($xoopsDB,$xoopsUser);

/**
* Fecthing numbers of groups friends videos pictures etc...
*/
$nbSections = $controler->getNumbersSections();

$start = (isset($_GET['start']))? intval($_GET['start']) : 0;

/**
* Criteria for Videos
*/
$criteriaUidVideo  = new criteria('uid_owner',$controler->uidOwner);
$criteriaUidVideo->setStart($start);
$criteriaUidVideo->setLimit($xoopsModuleConfig['videosperpage']);

/**
* Get all videos of this user and assign them to template
*/

$videos = $controler->getVideos($criteriaUidVideo);
$videos_array = $controler->assignVideoContent($nbSections['nbVideos'],$videos);

if(is_array($videos_array)) {$xoopsTpl->assign('videos', $videos_array);}
else {$xoopsTpl->assign('lang_novideoyet',_MD_SOCIALNET_NOVIDEOSYET);}

$pageNav = $controler->VideosNavBar($nbSections['nbVideos'], $xoopsModuleConfig['videosperpage'],$start,2);

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

//permissions
$xoopsTpl->assign('allow_scraps',$controler->checkPrivilegeBySection('scraps'));
$xoopsTpl->assign('allow_friends',$controler->checkPrivilegeBySection('friends'));
$xoopsTpl->assign('allow_groups',$controler->checkPrivilegeBySection('groups'));
$xoopsTpl->assign('allow_pictures',$controler->checkPrivilegeBySection('pictures'));
$xoopsTpl->assign('allow_videos',$controler->checkPrivilegeBySection('videos'));
$xoopsTpl->assign('allow_audios',$controler->checkPrivilegeBySection('audio'));

//Owner data
$xoopsTpl->assign('uid_owner',$controler->uidOwner);
$xoopsTpl->assign('owner_uname',$controler->nameOwner);
$xoopsTpl->assign('isOwner',$controler->isOwner);
$xoopsTpl->assign('isanonym',$controler->isAnonym);

//numbers
$xoopsTpl->assign('nb_groups',$nbSections['nbGroups']);
$xoopsTpl->assign('nb_photos',$nbSections['nbPhotos']);
$xoopsTpl->assign('nb_videos',$nbSections['nbVideos']);
$xoopsTpl->assign('nb_scraps',$nbSections['nbScraps']);
$xoopsTpl->assign('nb_friends',$nbSections['nbFriends']);
$xoopsTpl->assign('nb_audio',$nbSections['nbAudio']);

//navbar
$xoopsTpl->assign('module_name',$xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection',_MD_SOCIALNET_MYVIDEOS);
$xoopsTpl->assign('section_name',_MD_SOCIALNET_VIDEOS);
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

//xoopsToken
$xoopsTpl->assign('token',$GLOBALS['xoopsSecurity']->getTokenHTML());

//page atributes
$xoopsTpl->assign('xoops_pagetitle',  sprintf(_MD_SOCIALNET_PAGETITLE,$xoopsModule->getVar('name'), $controler->nameOwner));

//form actions
$xoopsTpl->assign('lang_delete',_MD_SOCIALNET_DELETE );
$xoopsTpl->assign('lang_editdesc',_MD_SOCIALNET_EDITDESC );
$xoopsTpl->assign('lang_makemain',_MD_SOCIALNET_MAKEMAIN);

//FORM SUBMIT
$xoopsTpl->assign('lang_addvideos',_MD_SOCIALNET_ADDFAVORITEVIDEOS);
$xoopsTpl->assign('lang_youtubecodeLabel',_MD_SOCIALNET_YOUTUBECODE);
$xoopsTpl->assign('lang_captionLabel',_MD_SOCIALNET_CAPTION);
$xoopsTpl->assign('lang_submitValue',_MD_SOCIALNET_ADDVIDEO);


$xoopsTpl->assign('width',$xoopsModuleConfig['width_tube']);
$xoopsTpl->assign('height',$xoopsModuleConfig['height_tube']);
$xoopsTpl->assign('lang_videohelp',_MD_SOCIALNET_ADDVIDEOSHELP);

//Videos NAvBAr
$xoopsTpl->assign('pageNav',$pageNav);

include '../../footer.php';
?>
