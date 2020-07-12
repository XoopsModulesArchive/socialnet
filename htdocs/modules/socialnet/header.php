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

if(file_exists('../../mainfile.php')) {
	require '../../mainfile.php';
} elseif(file_exists('../../../mainfile.php')) {
	require '../../../mainfile.php';
}

include_once '../../header.php';
include_once '../../class/pagenav.php';
include_once 'class/socialnet_images.php';
include_once 'class/socialnet_visitors.php';
include_once 'class/socialnet_youtube.php';
include_once 'class/socialnet_friendpetition.php';
include_once 'class/socialnet_friendship.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/include/common.php';


if ( file_exists("language/".$xoopsConfig['language']."/modinfo.php") ) {
	include_once("language/".$xoopsConfig['language']."/modinfo.php");
} else {
	include_once("language/english/modinfo.php");
}
include_once XOOPS_ROOT_PATH."/modules/socialnet/include/functionspot.inc.php";
include_once XOOPS_ROOT_PATH."/modules/socialnet/class/socialnet_mpb_mpublish.class.php";
include_once XOOPS_ROOT_PATH."/modules/socialnet/include/functionstree.inc.php";

/**
* Belong to the socialnet forum
*/
include_once XOOPS_ROOT_PATH.'/modules/socialnet/forumfunctions.php';
include_once XOOPS_ROOT_PATH.'/modules/socialnet/forumconfig.php';


if(!@ include_once XOOPS_ROOT_PATH.'/language/'.$GLOBALS['xoopsConfig']['language'].'/user.php')
{
	include_once XOOPS_ROOT_PATH.'/language/english/user.php';
}

$album_factory	= new Xoopssocialnet_imagesHandler($xoopsDB);
$visitors_factory = new Xoopssocialnet_visitorsHandler($xoopsDB);
$videos_factory = new Xoopssocialnet_youtubeHandler($xoopsDB);
$friendpetition_factory = new Xoopssocialnet_friendpetitionHandler($xoopsDB);
$friendship_factory = new Xoopssocialnet_friendshipHandler($xoopsDB);

$isOwner=0;
$isanonym =1;
$isfriend =0;

/**
* If anonym and uid not set then redirect to admins profile
* Else redirects to own profile
*/
if(empty($xoopsUser))
{
	$isanonym =1;
	if(isset($_GET['uid'])) {$uid_owner = intval($_GET['uid']);}
	else
	{
		$uid_owner=1;
		$isOwner = 0;
	}
}
else
{
	$isanonym =0;
	if( isset($_GET['uid']))
	{
		$uid_owner = intval($_GET['uid']);
		$isOwner = ($xoopsUser->getVar('uid')==$uid_owner)?1:0;
	}
	else
	{
		$uid_owner = intval($xoopsUser->getVar('uid'));
		$isOwner = 1;
	}
	
}

?>