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
$xoopsOption['template_main'] = 'socialnet_album.html';
include_once '../../header.php';
include_once 'class/socialnet_controler.php';
// *******************************************************************************
// **** Main
// *******************************************************************************



$controler = new SocialnetControlerPhotos($xoopsDB,$xoopsUser);

/**
* Fecthing numbers of groups friends videos pictures etc...
*/
$nbSections = $controler->getNumbersSections();

/**
* This variable define the beggining of the navigation must b
* setted here so all calls to database will take this into account
*/
$start = (isset($_GET['start']))? intval($_GET['start']) : 0;

/**
* Filter for search pictures in database
*/
if($controler->isOwner==1) {$criteria_uid = new criteria('uid_owner', $controler->uidOwner);}
else
{
	$criteria_private = new criteria('private',0);
	$criteria_uid2 = new criteria('uid_owner', intval($controler->uidOwner));
	$criteria_uid = new criteriaCompo($criteria_uid2);
	$criteria_uid->add($criteria_private);
}
$criteria_uid->setLimit($xoopsModuleConfig['picturesperpage']);
$criteria_uid->setStart($start);
if($xoopsModuleConfig['images_order']==1)
{
	$criteria_uid->setOrder('DESC');
	$criteria_uid->setSort('cod_img');
}
/**
* Fetch pictures from factory
*/
$pictures_object_array = $controler->album_factory->getObjects($criteria_uid);
$criteria_uid->setLimit('');
$criteria_uid->setStart(0);

/**
* If there is no pictures in the album show in template lang_nopicyet
*/
if($nbSections['nbPhotos']==0)
{
	$nopicturesyet = _MD_SOCIALNET_NOTHINGYET;
	$xoopsTpl->assign('lang_nopicyet',$nopicturesyet);
}
else
{
	/**
	* Lets populate an array with the dati from the pictures
	*/
	$i = 0;
	foreach($pictures_object_array as $picture)
	{
		$pictures_array[$i]['url'] = $picture->getVar('url','s');
		$pictures_array[$i]['desc'] = $picture->getVar('title','s');
		$pictures_array[$i]['cod_img'] = $picture->getVar('cod_img','s');
		$pictures_array[$i]['private'] = $picture->getVar('private','s');
		$xoopsTpl->assign('pics_array', $pictures_array);
		$i++;
	}
}

/**
* Show the form if it is the owner and he can still upload pictures
*/
if(!empty($xoopsUser))
{
	if(($controler->isOwner==1) && $xoopsModuleConfig['nb_pict']>$nbSections['nbPhotos'])
	{
		$maxfilebytes = $xoopsModuleConfig['maxfilesize'];
		$xoopsTpl->assign('maxfilebytes',$maxfilebytes);
		$xoopsTpl->assign('showForm','1');
	}
}

/**
* Let's get the user name of the owner of the album
*/
$owner = new XoopsUser($controler->uidOwner);
$identifier = $owner->getVar('uname');
$avatar = $owner->getVar('user_avatar');

/**
* Adding to the module js and css of the lightbox and new ones
*/
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/socialnet.css');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/jquery.tabs.css');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/leftmenu.css');
// what browser they use if IE then add corrective script.
if(ereg("msie", strtolower($_SERVER['HTTP_USER_AGENT']))) {$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/jquery.tabs-ie.css');}

$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/jquery.lightbox-0.5.css');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jquery.js');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jquery.lightbox-0.5.js');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/socialnet.js');


/*
// CHECK THE CONFLIC WHIT THE FACESTYLE AND LIGHTBOX THE IMAGE IS NOT POPWINDOWS
// SocialNetFaceStyle starts here
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/barfacestyle.css');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/barface.stylesheet.css');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/barface.readyfunction.js');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jquery-1.3.2.min.js');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jixedbar-0.0.3-dev.js');
// SocialNetFaceStyle End here
*/

/**
* Creating the navigation bar in case you has many friends
*/
$bar_navigation = new XoopsPageNav($nbSections['nbPhotos'],$xoopsModuleConfig['picturesperpage'],$start,'start','uid='.intval($controler->uidOwner));
$navigation = $bar_navigation->renderImageNav(2);

/**
* Assigning smarty variables
*/
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

//numbers
$xoopsTpl->assign('nb_groups',$nbSections['nbGroups']);
$xoopsTpl->assign('nb_photos',$nbSections['nbPhotos']);
$xoopsTpl->assign('nb_videos',$nbSections['nbVideos']);
$xoopsTpl->assign('nb_scraps',$nbSections['nbScraps']);
$xoopsTpl->assign('nb_friends',$nbSections['nbFriends']);
$xoopsTpl->assign('nb_audio',$nbSections['nbAudio']);

//navbar
$xoopsTpl->assign('module_name',$xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection',_MD_SOCIALNET_MYPHOTOS);
$xoopsTpl->assign('section_name',_MD_SOCIALNET_PHOTOS);
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

//page atributes
$xoopsTpl->assign('xoops_pagetitle', sprintf(_MD_SOCIALNET_PAGETITLE,$xoopsModule->getVar('name'), $controler->nameOwner));
$xoopsTpl->assign('isanonym',$controler->isAnonym);

//form
$xoopsTpl->assign('lang_formtitle',_MD_SOCIALNET_SUBMIT_PIC_TITLE);
$xoopsTpl->assign('lang_selectphoto',_MD_SOCIALNET_SELECT_PHOTO);
$xoopsTpl->assign('lang_caption',_MD_SOCIALNET_CAPTION);
$xoopsTpl->assign('lang_uploadpicture',_MD_SOCIALNET_UPLOADPICTURE);
$xoopsTpl->assign('lang_youcanupload',sprintf(_MD_SOCIALNET_YOUCANUPLOAD,$maxfilebytes/1024));

//$xoopsTpl->assign('path_socialnet_uploads',$xoopsModuleConfig['link_path_upload']);
$xoopsTpl->assign('lang_max_nb_pict', sprintf(_MD_SOCIALNET_YOUCANHAVE,$xoopsModuleConfig['nb_pict']));
$xoopsTpl->assign('lang_delete',_MD_SOCIALNET_DELETE );
$xoopsTpl->assign('lang_editdesc',_MD_SOCIALNET_EDITDESC );
$xoopsTpl->assign('lang_nb_pict', sprintf(_MD_SOCIALNET_YOUHAVE,$nbSections['nbPhotos']));

$xoopsTpl->assign('token',$GLOBALS['xoopsSecurity']->getTokenHTML());
$xoopsTpl->assign('navigation',$navigation);
$xoopsTpl->assign('lang_avatarchange',_MD_SOCIALNET_AVATARCHANGE);
$xoopsTpl->assign('avatar_url',$avatar);

$xoopsTpl->assign('lang_setprivate',_MD_SOCIALNET_PRIVATIZE);
$xoopsTpl->assign('lang_unsetprivate',_MD_SOCIALNET_UNPRIVATIZE);

include XOOPS_ROOT_PATH.'/include/comment_view.php';

include '../../footer.php';
?>
