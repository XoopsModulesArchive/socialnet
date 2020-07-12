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
include "header.php";
$xoopsOption['template_main'] = 'socialnet_birthday.html';
include XOOPS_ROOT_PATH."/header.php";
include XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/include/socialnet_birthdayfunction.php";
// *******************************************************************************
// **** Main
// *******************************************************************************

function edit_birthday() {
	global $xoopsUser, $xoopsDB, $xoopsModule;
	$sql = "SELECT * FROM ".$xoopsDB->prefix("socialnet_birthday")." WHERE uid='".$xoopsUser->getVar('uid')."'";
  	$result = $xoopsDB->query($sql);
	$nb=$xoopsDB->getRowsNum($result);
	if ($nb=='0') {
		$day="1";
		$month="1";
		$year="1930";
	} else {
		while ($en = $xoopsDB->fetchArray($result)) {
			$day=$en['day'];
			$month=$en['month'];
			$year=$en['year'];
		}
	}
	
	echo "
	<h3 align='center'>"._MD_SOCIALNET_BIRTH_TITLE_2."</h3>
	<p>&nbsp;</p>

	<p>
		<img src='images/profile/username.gif' border='0' width='18' height='18' /> <a href='../../userinfo.php?uid=".$xoopsUser->getVar("uid")."'>"._MD_SOCIALNET_PROFILE."</a>&nbsp;
		<span style='font-weight:bold;'>&raquo;&raquo;</span>&nbsp;"._MD_SOCIALNET_BIRTH_EDIT."
	</p>
	<p>&nbsp;</p>
	<p> 
		<form action='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/birthdaybegin.php' method='post'>
			<table width='40%' align='center' class='outer'>
				<tr>
					<td colspan='2' class='odd'><strong>"._MD_SOCIALNET_BIRTH_ENTER." :</strong> <br /><img src='images/icons/owner.gif' border='0' width='18' height='18' /> "._MD_SOCIALNET_BIRTH_SEEWORKING." </td>
				</tr>
				<tr>
					<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
					<td width='30%' align='right' valign='middle'><strong>"._MD_SOCIALNET_BIRTH_YOUR_DATE." :</strong></td>
					<td width='70%' align='center' valign='middle'>"
						.listday("day",$day)."&nbsp;<strong>/</strong>&nbsp;"
						.listmonth("month",$month)."&nbsp;<strong>/</strong>&nbsp;"
						.listyear("year",(date("Y",time())-10),$year)."
					</td>
				</tr>
				<tr>
					<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
					<td colspan='2' align='center'>
						<input type='hidden' name='uid' value='".$xoopsUser->uid()."'>
						<input type='hidden' name='op' value='save_birthday'>
						<input type='submit' value='"._MD_SOCIALNET_BIRTH_SAVE."'>
					</td>
				</tr>
			</table>
		</form>
	</p>
<br>
<br>
<center>
<i>
Maintain By <a href='http://www.ipwgc.com/socialnet/'>IPWGC.com Project SocialNet 2010</a>
</i>
</center>
<br><br><br>
	<p>&nbsp;</p>";
}

function save_birthday() {
	global $xoopsUser, $xoopsDB, $xoopsModule;
	$myts =& MyTextSanitizer::getInstance();
	
	$day=$myts->htmlSpecialChars($_POST['day']);
	$month=$myts->htmlSpecialChars($_POST['month']);
	$year=$myts->htmlSpecialChars($_POST['year']);
	$uid=$myts->htmlSpecialChars($_POST['uid']);
	
	if ($xoopsUser) { 
		$sql = "SELECT * FROM ".$xoopsDB->prefix("socialnet_birthday")." WHERE uid='$uid'";
	  	$result = $xoopsDB->query($sql);
		$nb=$xoopsDB->getRowsNum($result);
		if ($nb==0) {
			$sql="INSERT ".$xoopsDB->prefix("socialnet_birthday")." (uid,day,month,year) VALUES ('$uid','$day','$month','$year')";
			$result = $xoopsDB->query($sql);
			if ($result)
				redirect_header(XOOPS_URL."/modules/socialnet/birthdaybegin.php",3,_MD_SOCIALNET_BIRTH_DBUPDATED);
			else
				redirect_header(XOOPS_URL."/modules/socialnet/birthdaybegin.php",3,_MD_SOCIALNET_BIRTH_NOBIRTHDAYSAVED);
		} else {
			$sql="UPDATE ".$xoopsDB->prefix("socialnet_birthday")." SET day='$day',month='$month',year='$year' WHERE uid='$uid'";
			$result = $xoopsDB->query($sql);
			if ($result)
				redirect_header(XOOPS_URL."/modules/socialnet/birthdaybegin.php",3,_MD_SOCIALNET_BIRTH_DBUPDATED);
			else
				redirect_header(XOOPS_URL."/modules/socialnet/birthdaybegin.php",3,_MD_SOCIALNET_BIRTH_NOBIRTHDAYSAVED);
		}
	} else {
		redirect_header(XOOPS_URL."/",3,_MD_SOCIALNET_BIRTH_NO_ACCES);
	}
}

if(!isset($HTTP_POST_VARS['op'])) {
	$op = isset($HTTP_GET_VARS['op']) ? $HTTP_GET_VARS['op'] : 'edit_birthday';
} else {
	$op = $HTTP_POST_VARS['op'];
}

switch($op) {
	case "edit_birthday":
		edit_birthday();
		break;
	case "save_birthday" :
		save_birthday();
		break;
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
?>