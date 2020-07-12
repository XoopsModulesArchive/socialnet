<?php
// $Id: myfavorites.php,v 0.1 2006/01/01 - MyLatinSoulmate                   //
//  ------------------------------------------------------------------------ //
//                    MyLatinSoulmate Friends Module                         //
//                  Copyright (c) 2006 MyLatinSoulmate                       //
//                   <http://www.mylatinsoulmate.com/>                       //
//  ------------------------------------------------------------------------ //
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


// Init
include '../../mainfile.php';
$xoopsOption['template_main'] = "socialnet_interestfriendslist.html";
include_once "../../header.php";

// *******************************************************************************
// **** Main
// *******************************************************************************

// Only Logged on members can have Favorites and Admirers
if (!$xoopsUser) {redirect_header('index.php',5,_MD_SOCIALNET_CONFIGSONLYEUSERS);exit();} else {

$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "normal";
$start = isset($_REQUEST['start']) ? intval($_REQUEST['start']) : 0;

$uid = $xoopsUser->getVar('uid');

if ($type == "admirers") {
	$sqlstr = "SELECT uid FROM ".$xoopsDB->prefix("socialnet_interestfriends")." WHERE fuid='".$uid."' ORDER BY ref DESC ";
	$title = _MD_SOCIALNET_INTEREST_ADMIRER_TITLE;
	$message = _MD_SOCIALNET_INTEREST_ADMIRER_NONE;
} else {
	$sqlstr = "SELECT fuid FROM ".$xoopsDB->prefix("socialnet_interestfriends")." WHERE uid='".$uid."' ORDER BY ref DESC ";
	$title = _MD_SOCIALNET_INTEREST_FAVORITE_TITLE;
	$message = _MD_SOCIALNET_INTEREST_FAVORITE_NONE;
}

$result = $xoopsDB->query($sqlstr) or die($xoopsDB->error() );
$z = 0;
while ( $item = $xoopsDB->fetchArray ( $result ) ) { // Fill array with results *this can be done more elegant
    $interests[$z] = $item;
	$z++;
}

$i=$start;  // So we can also see where we have been on the results page
$total_users=$z;
$limit = 5; // How many profiles to show per page
$max = $i+$limit > $z ? $z : $i+$limit; // Don't show more profiles then the limit set...or end of list

while ($i < $max) {
	if ($type == "admirers")
		$wuid = $interests[$i]['uid']; // You are the one beeing Admired
	else
		$wuid = $interests[$i]['fuid']; // You are the one Amiring
	$thisUser =& $member_handler->getUser($wuid);
	if (is_object($thisUser) && $thisUser->isActive()) { // Allowed users only
		$userarray["output"][] = "<a href='".XOOPS_URL."/userinfo.php?uid=".$thisUser->getVar('uid')."'>".$thisUser->getVar('uname')."</a>";
		if($thisUser->getVar('user_avatar') && "blank.gif" != $thisUser->getVar('user_avatar')){
			$userarray["output"][] = "<a href='".XOOPS_URL."/userinfo.php?uid=".$thisUser->getVar('uid')."'>
			<img src='".XOOPS_UPLOAD_URL."/".$thisUser->getVar('user_avatar')."' width='66' height='66' alt=' ".$thisUser->getVar('uname')." ' /></a>";
		} else {
			$userarray["output"][] = "<img src='".XOOPS_UPLOAD_URL."/blank.gif' width='66' height='66'  alt=' ".$thisUser->getVar('uname')." ' />";
		}
		$userarray["output"][] = $thisUser->getVar('user_from');
		if ($thisUser->isOnline()) {
			$active = "Online!";
		} else {
			$last_log = $thisUser->getVar('last_login');
			if (time() - $last_log < (24*60*60)) { // 24 Hours
				$active = _MD_SOCIALNET_INTEREST_24HOURS;
			} elseif (time() - $last_log < (2*24*60*60)) { // 48 Hours
				$active = _MD_SOCIALNET_INTEREST_48HOURS;
			} elseif (time() - $last_log < (7*24*60*60)) { // 1 Week
				$active =  _MD_SOCIALNET_INTEREST_1WEEK;
			} elseif (time() - $last_log < (13*7*24*60*60/3)) { // 1 Month
				$active =  _MD_SOCIALNET_INTEREST_1MONTH;
			} elseif (time() - $last_log < (13*7*24*60*60)) { // 3 Months
				$active =  _MD_SOCIALNET_INTEREST_3MONTHS;
			} else {
				$active =  _MD_SOCIALNET_INTEREST_LONGER;
			}
		}
		$userarray["output"][] = $active;
		$userarray["output"][] = $thisUser->getVar('bio');
		if ($type == "admirers") {
			$userarray["output"][] = "myfavoritesbegin.php?op=deladm&friendid=".$thisUser->getVar('uid');
		} else {
			$userarray["output"][] = "myfavoritesbegin.php?op=del&friendid=".$thisUser->getVar('uid');
		}
		$userarray["output"][] = "myfavoritesbegin.php?op=interest&friendid=".$thisUser->getVar('uid');
		$userarray["output"][] = "".XOOPS_URL."/userinfo.php?uid=".$thisUser->getVar('uid');
		$xoopsTpl->append('users', $userarray);
		unset($userarray);
	} else { $total_users--;}	
	$i++;
}

$xoopsTpl->assign('location', _MD_SOCIALNET_INTEREST_LOCATION);
$xoopsTpl->assign('active', _MD_SOCIALNET_INTEREST_ACTIVE);
$xoopsTpl->assign('page', _MD_SOCIALNET_INTEREST_PAGE);
if ($type == "admirers") {
	$xoopsTpl->assign('name', _MD_SOCIALNET_INTEREST_ADMIRER_NAME);
	$xoopsTpl->assign('button1', _MD_SOCIALNET_INTEREST_DEL_ADMIRER); 
} else {
	$xoopsTpl->assign('name', _MD_SOCIALNET_INTEREST_FAVORITE_NAME);
	$xoopsTpl->assign('button1', _MD_SOCIALNET_INTEREST_DEL_FAVORITE);
}
$xoopsTpl->assign('button2', _MD_SOCIALNET_INTEREST_INTEREST);
$xoopsTpl->assign('button3', _MD_SOCIALNET_INTEREST_VIEW_PROFILE);
$xoopsTpl->assign('title', $title);
$xoopsTpl->assign('message',$message);
	
if ($total_users > $limit) { // More pages
	$search_url[] = "view=".$view;
	$search_url[] = "type=".$type;
	if (isset($search_url)) {
            $args = implode("&amp;", $search_url);
    }
	if (isset($search_url)) {
            $args = implode("&amp;", $search_url);
    }
	if (isset($search_url)) {
            $args = implode("&amp;", $search_url);
    }
	include_once XOOPS_ROOT_PATH."/class/pagenav.php";
    $nav = new XoopsPageNav($total_users, $limit, $start, "start", $args);
    $xoopsTpl->assign('nav', $nav->renderNav(5));
}
   

/**
 * Adding to the module js and css of the lightbox and new ones
 */
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/socialnet.css');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/jquery.tabs.css');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/leftmenu.css');
// what browser they use if IE then add corrective script.
if(ereg("msie", strtolower($_SERVER['HTTP_USER_AGENT']))) {
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/jquery.tabs-ie.css');
}

$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/jquery.lightbox-0.5.css');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jquery.js');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jquery.lightbox-0.5.js');
//$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/socialnet.js');

// SocialNetFaceStyle starts here
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/barfacestyle.css');
//$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/foot_panelstyle.css');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/barface.stylesheet.css');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/barface.readyfunction.js');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jquery-1.3.2.min.js');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jixedbar-0.0.3-dev.js');
// SocialNetFaceStyle End here

//navbar
$xoopsTpl->assign('module_name',$xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection',_MD_SOCIALNET_MYPROFILE);
$xoopsTpl->assign('section_name',_MD_SOCIALNET_PROFILE);
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

include '../../footer.php';

}
?>