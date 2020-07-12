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
$xoopsOption['template_main'] = 'socialnet_group.html';
include_once '../../header.php';
include_once 'class/socialnet_controler.php';

// *******************************************************************************
// **** Main
// *******************************************************************************

$controler = new SocialnetControlerGroups($xoopsDB,$xoopsUser);

/**
* Fecthing numbers of groups friends videos pictures etc...
*/
$nbSections = $controler->getNumbersSections();

$group_id = intval($_GET['group_id']);
$criteria= new criteria('group_id',$group_id);
$groups = $controler->groups_factory->getObjects($criteria);
$group = $groups[0];

/**
* Render a form with the info of the user  
*/
$group_members = $controler->relgroupusers_factory->getUsersFromGroup($group_id,0,50);
foreach($group_members as $group_member) {$uids[]=intval($group_member['uid']);}

$uid = intval($xoopsUser->getVar('uid'));
if($xoopsUser)
{
	if(in_array($uid,$uids)) $xoopsTpl->assign('memberOfGroup', 1);
	$xoopsTpl->assign('useruid', $uid);
}
$xoopsTpl->assign('group_members', $group_members );
$maxfilebytes = $xoopsModuleConfig['maxfilesize'];
$xoopsTpl->assign('lang_savegroup',_MD_SOCIALNET_UPLOADGROUP);
$xoopsTpl->assign('maxfilesize',$maxfilebytes);
$xoopsTpl->assign('group_title', $group->getVar('group_title'));
$xoopsTpl->assign('group_desc', $group->getVar('group_desc'));
$xoopsTpl->assign('group_img', $group->getVar('group_img'));
$xoopsTpl->assign('group_id', $group->getVar('group_id'));
$xoopsTpl->assign('group_owneruid', $group->getVar('owner_uid'));

$xoopsTpl->assign('lang_membersofgroup', _MD_SOCIALNET_MEMBERSDOFGROUP);
$xoopsTpl->assign('lang_editgroup', _MD_SOCIALNET_EDIT_GROUP);
$xoopsTpl->assign('lang_groupimage', _MD_SOCIALNET_GROUP_IMAGE);
$xoopsTpl->assign('lang_keepimage', _MD_SOCIALNET_MAINTAINOLDIMAGE);
$xoopsTpl->assign('lang_youcanupload',sprintf(_MD_SOCIALNET_YOUCANUPLOAD,$maxfilebytes/1024));
$xoopsTpl->assign('lang_titlegroup', _MD_SOCIALNET_GROUP_TITLE);
$xoopsTpl->assign('lang_descgroup', _MD_SOCIALNET_GROUP_DESC);

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
$xoopsTpl->assign('lang_mysection',_MD_SOCIALNET_GROUPS.' :: '.$group->getVar('group_title'));
$xoopsTpl->assign('section_name',_MD_SOCIALNET_GROUPS.' > '.$group->getVar('group_title'));
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
$xoopsTpl->assign('lang_owner',_MD_SOCIALNET_GROUPOWNER);

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

include_once XOOPS_ROOT_PATH.'/include/comment_view.php';

include '../../footer.php';

?>
