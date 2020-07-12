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

include_once'../../mainfile.php';
$xoopsOption['template_main'] = 'socialnet_groups.html';
include_once'../../header.php';
include_once'class/socialnet_controler.php';

// *******************************************************************************
// **** Main
// *******************************************************************************

$controler = new SocialnetControlerGroups($xoopsDB,$xoopsUser);

/**
* Fecthing numbers of groups friends videos pictures etc...
*/
$nbSections = $controler->getNumbersSections();

$start_all = (isset($_GET['start_all']))? intval($_GET['start_all']) : 0;
$start_my = (isset($_GET['start_my']))? intval($_GET['start_my']) : 0;

/**
* All Groups 
*/
$criteria_groups = new criteria('group_id',0,'>');
$nb_groups = $controler->groups_factory->getCount($criteria_groups);
$criteria_groups->setLimit($xoopsModuleConfig['groupsperpage']);
$criteria_groups->setStart($start_all);
$groups = $controler->groups_factory->getGroups($criteria_groups);


/**
* My Groups 
*/
$mygroups = '';
$criteria_mygroups = new criteria('rel_user_uid', $controler->uidOwner);
$nb_mygroups = $controler->relgroupusers_factory->getCount($criteria_mygroups);
$criteria_mygroups->setLimit($xoopsModuleConfig['groupsperpage']);
$criteria_mygroups->setStart($start_my);
$mygroups = $controler->relgroupusers_factory->getGroups('', $criteria_mygroups,0);

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

/**
* Creating the navigation bar in case you has many friends
*/
$bar_navigation = new XoopsPageNav($nb_groups,$xoopsModuleConfig['groupsperpage'],$start_all,'start_all','uid='.intval($controler->uidOwner).'&amp;start_my='.$start_my);
$littlebar = $bar_navigation->renderImageNav(2);//allgroups

$bar_navigation_my = new XoopsPageNav($nb_mygroups,$xoopsModuleConfig['groupsperpage'],$start_my,'start_my','uid='.intval($controler->uidOwner).'&amp;start_all='.$start_all);
$littlebar_my = $bar_navigation_my->renderImageNav(2);

$maxfilebytes = $xoopsModuleConfig['maxfilesize'];

//permissions
$xoopsTpl->assign('allow_scraps',$controler->checkPrivilegeBySection('scraps'));
$xoopsTpl->assign('allow_friends',$controler->checkPrivilegeBySection('friends'));
$xoopsTpl->assign('allow_groups',$controler->checkPrivilegeBySection('groups'));
$xoopsTpl->assign('allow_pictures',$controler->checkPrivilegeBySection('pictures'));
$xoopsTpl->assign('allow_videos',$controler->checkPrivilegeBySection('videos'));
$xoopsTpl->assign('allow_audios',$controler->checkPrivilegeBySection('audio'));

//form
$xoopsTpl->assign('lang_youcanupload',sprintf(_MD_SOCIALNET_YOUCANUPLOAD,$maxfilebytes/1024));
$xoopsTpl->assign('lang_groupimage',_MD_SOCIALNET_GROUP_IMAGE);
$xoopsTpl->assign('maxfilesize',$maxfilebytes);
$xoopsTpl->assign('lang_title',_MD_SOCIALNET_GROUP_TITLE);
$xoopsTpl->assign('lang_description',_MD_SOCIALNET_GROUP_DESC);
$xoopsTpl->assign('lang_savegroup',_MD_SOCIALNET_UPLOADGROUP);

//Owner data
$xoopsTpl->assign('uid_owner',$controler->uidOwner);
$xoopsTpl->assign('owner_uname',$controler->nameOwner);
$xoopsTpl->assign('isOwner',$controler->isOwner);
$xoopsTpl->assign('isanonym',$controler->isAnonym);

//numbers
//$xoopsTpl->assign('nb_groups',$nbSections['nbGroups']);look at hte end for this nb
$xoopsTpl->assign('nb_photos',$nbSections['nbPhotos']);
$xoopsTpl->assign('nb_videos',$nbSections['nbVideos']);
$xoopsTpl->assign('nb_scraps',$nbSections['nbScraps']);
$xoopsTpl->assign('nb_friends',$nbSections['nbFriends']);
$xoopsTpl->assign('nb_audio',$nbSections['nbAudio']);
$xoopsTpl->assign('nb_groups',$nbSections['nbGroups']);

//navbar
$xoopsTpl->assign('module_name',$xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection',_MD_SOCIALNET_MYGROUPS);
$xoopsTpl->assign('section_name',_MD_SOCIALNET_GROUPS);
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
$xoopsTpl->assign('xoops_pagetitle', sprintf(_MD_SOCIALNET_PAGETITLE,$xoopsModule->getVar('name'), $controler->nameOwner));

//$xoopsTpl->assign('path_socialnet_uploads',$xoopsModuleConfig['link_path_upload']);
$xoopsTpl->assign('groups',$groups);
$xoopsTpl->assign('mygroups',$mygroups);
$xoopsTpl->assign('lang_mygroupstitle',_MD_SOCIALNET_MYGROUPS);
$xoopsTpl->assign('lang_groupstitle',_MD_SOCIALNET_ALLGROUPS.' ('.$nb_groups.')');
$xoopsTpl->assign('lang_nogroupsyet',_MD_SOCIALNET_NOGROUPSYET);

//page nav
$xoopsTpl->assign('bar_navigation',$littlebar);//allgroups
$xoopsTpl->assign('bar_navigation_my',$littlebar_my);
$xoopsTpl->assign('nb_groups',$nb_mygroups);// this is the one wich shows in the upper bar actually is about the mygroups
$xoopsTpl->assign('nb_groups_all',$nb_groups);//this is total number of groups

$xoopsTpl->assign('lang_creategroup',_MD_SOCIALNETCREATEYOURGROUP);
$xoopsTpl->assign('lang_owner',_MD_SOCIALNET_GROUPOWNER);
$xoopsTpl->assign('lang_abandongroup',_MD_SOCIALNET_GROUP_ABANDON);
$xoopsTpl->assign('lang_joingroup',_MD_SOCIALNET_GROUP_JOIN);
$xoopsTpl->assign('lang_searchgroup',_MD_SOCIALNET_GROUP_SEARCH);
$xoopsTpl->assign('lang_groupkeyword',_MD_SOCIALNET_GROUP_SEARCHKEYWORD);

include '../../footer.php';
?>
