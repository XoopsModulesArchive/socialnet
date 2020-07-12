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

include '../../mainfile.php';
include_once "header.php";
// *******************************************************************************
// **** Main
// *******************************************************************************

if (!defined('XOOPS_ROOT_PATH') || !is_object($xoopsModule)) {
	exit();
}
include_once XOOPS_ROOT_PATH.'/include/comment_constants.php';
if ('system' != $xoopsModule->getVar('dirname') && XOOPS_COMMENT_APPROVENONE == $xoopsModuleConfig['com_rule']) {
	exit();
}
include_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/comment.php';
include XOOPS_ROOT_PATH.'/header.php';
include_once XOOPS_ROOT_PATH."/modules/socialnet/class/socialnet_mpb_mpublish.class.php";
$com_itemid = isset($_GET['com_itemid']) ? intval($_GET['com_itemid']) : 0;
$socialnet_classe = new socialnet_mpb_mpublish($com_itemid);
$com_replytitle = $socialnet_classe->getVar("mpb_30_title");
if (isset($com_replytitle)) {
	if (isset($com_replytext)) {
		themecenterposts($com_replytitle, $com_replytext);
	}
	$myts =& MyTextSanitizer::getInstance();
	$com_title = $myts->htmlSpecialChars($com_replytitle);
	if (!preg_match("/^(Re|"._CM_RE."):/i", $com_title)) {
		$com_title = _CM_RE.": ".xoops_substr($com_title, 0, 56);
	}
} else {
	$com_title = '';
}
$com_mode = isset($_GET['com_mode']) ? htmlspecialchars(trim($_GET['com_mode']), ENT_QUOTES) : '';
if ($com_mode == '') {
	if (is_object($xoopsUser)) {
		$com_mode = $xoopsUser->getVar('umode');
	} else {
		$com_mode = $xoopsConfig['com_mode'];
	}
}

if (!isset($_GET['com_order'])) {
	if (is_object($xoopsUser)) {
		$com_order = $xoopsUser->getVar('uorder');
	} else {
		$com_order = $xoopsConfig['com_order'];
	}
} else {
	$com_order = intval($_GET['com_order']);
}
$com_id = 0;
$noname = 0;
$dosmiley = 1;
$dohtml = 0;
$dobr = 1;
$doxcode = 1;
$com_icon = '';
$com_pid = 0;
$com_rootid = 0;
$com_text = '';
/*
if ($xoopsModuleConfig['socialnet_conf_captcha']) {
	require('include/captcha/php-captcha.inc.php');
	if (isset($_SESSION[CAPTCHA_SESSION_ID])) {
		unset($_SESSION[CAPTCHA_SESSION_ID]);
	}
*/
}

include XOOPS_ROOT_PATH."/modules/socialnet/include/comment_form.php";
include XOOPS_ROOT_PATH.'/footer.php';

?>
