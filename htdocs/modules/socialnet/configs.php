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
$xoopsOption['template_main'] = 'socialnet_configs.html';
include_once '../../header.php';
include_once 'class/socialnet_controler.php';

// *******************************************************************************
// **** Main
// *******************************************************************************

$controler = new SocialnetControlerConfigs($xoopsDB,$xoopsUser);
$nbSections = $controler->getNumbersSections();

include_once 'class/socialnet_configs.php';

if(!$xoopsUser) {redirect_header('index.php');}

/**
* Factories of groups  
*/
$configs_factory = new Xoopssocialnet_configsHandler($xoopsDB);

$uid = intval($xoopsUser->getVar('uid'));
 
$criteria = new Criteria('config_uid',$uid);
if($configs_factory->getCount($criteria)>0)
{
	$configs = $configs_factory->getObjects($criteria);
	$config = $configs[0];
	
	$pic = $config->getVar('pictures');
	$aud = $config->getVar('audio');
	$vid = $config->getVar('videos');
	$tri = $config->getVar('groups');
	$scr = $config->getVar('scraps');
	$fri = $config->getVar('friends');
	$pcon = $config->getVar('profile_contact');
	$pgen = $config->getVar('profile_general');
	$psta = $config->getVar('profile_stats');
	
	$xoopsTpl->assign('pic',$pic);
	$xoopsTpl->assign('aud',$aud);
	$xoopsTpl->assign('vid',$vid);
	$xoopsTpl->assign('tri',$tri);
	$xoopsTpl->assign('scr',$scr);
	$xoopsTpl->assign('fri',$fri);
	$xoopsTpl->assign('pcon',$pcon);
	$xoopsTpl->assign('pgen',$pgen);
	$xoopsTpl->assign('psta',$psta);
}

//linking style and js
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
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/foot_panelstyle.css');
//$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/barface.stylesheet.css');
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

//form
$xoopsTpl->assign('lang_whocan',_MD_SOCIALNET_WHOCAN);
$xoopsTpl->assign('lang_configtitle',_MD_SOCIALNET_CONFIGSTITLE);
$xoopsTpl->assign('lang_configprofilestats',_MD_SOCIALNET_CONFIGSPROFILESTATS);
$xoopsTpl->assign('lang_configprofilegeneral',_MD_SOCIALNET_CONFIGSPROFILEGENERAL);
$xoopsTpl->assign('lang_configprofilecontact',_MD_SOCIALNET_CONFIGSPROFILECONTACT);
$xoopsTpl->assign('lang_configfriends',_MD_SOCIALNET_CONFIGSFRIENDS);
$xoopsTpl->assign('lang_configscraps',_MD_SOCIALNET_CONFIGSSCRAPS);
$xoopsTpl->assign('lang_configsendscraps',_MD_SOCIALNET_CONFIGSSCRAPSSEND);
$xoopsTpl->assign('lang_configgroups',_MD_SOCIALNET_CONFIGSGROUPS);
$xoopsTpl->assign('lang_configaudio',_MD_SOCIALNET_CONFIGSAUDIOS); 
$xoopsTpl->assign('lang_configvideos',_MD_SOCIALNET_CONFIGSVIDEOS);
$xoopsTpl->assign('lang_configpictures',_MD_SOCIALNET_CONFIGSPICTURES);
$xoopsTpl->assign('lang_only_me',_MD_SOCIALNET_CONFIGSONLYME);
$xoopsTpl->assign('lang_only_friends',_MD_SOCIALNET_CONFIGSONLYEFRIENDS);
$xoopsTpl->assign('lang_only_users',_MD_SOCIALNET_CONFIGSONLYEUSERS);
$xoopsTpl->assign('lang_everyone',_MD_SOCIALNET_CONFIGSEVERYONE);
$xoopsTpl->assign('lang_cancel',_MD_SOCIALNET_CANCEL);

//xoopsToken
$xoopsTpl->assign('token',$GLOBALS['xoopsSecurity']->getTokenHTML());

//scraps
//$xoopsTpl->assign('scraps',$scraps);
$xoopsTpl->assign('lang_answerscrap',_MD_SOCIALNET_ANSWERSCRAP);

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
$xoopsTpl->assign('lang_mysection',_MD_SOCIALNET_CONFIGSTITLE);
$xoopsTpl->assign('section_name',_MD_SOCIALNET_CONFIGSTITLE);
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

include '../../footer.php';
?>
