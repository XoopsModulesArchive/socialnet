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

include_once("admin_header.php");
require_once '../../../include/cp_header.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/include/common.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/admin/functions.php';
require_once XOOPS_ROOT_PATH.'/class/pagenav.php';

// *******************************************************************************
// **** Main
// *******************************************************************************

xoops_cp_header();
adminmenu(1);

$op = (isset($_GET['op'])) ? $_GET['op'] : 'feature';
if (isset($_GET)) {
	foreach ($_GET as $k => $v) {
		$$k = $v;
	}
}

if (isset($_POST)) {
	foreach ($_POST as $k => $v) {
		$$k = $v;
	}
}
switch ($op) {
	case 'save':
		$yname = $_POST['yname'];
		$yemail = $_POST['yemail'];
		$ydomain = $_POST['ydomain'];
		$feedback_type = $_POST['feedback_type'];
		$feedback_other = $_POST['feedback_other'];
		$title = "Social Net2010 - FeedBack from ".$ydomain;
		$body = "<b>".$yname." (".$yemail.") - ".$ydomain."</b><br />";
		$body .= "Type: ".$feedback_type.((!empty($feedback_other)) ? " - ".$feedback_other : "")."<br />";
		$body .= $_POST['feedback_content'];
		$xoopsMailer =& xoops_getMailer();
		$xoopsMailer->useMail();
		$xoopsMailer->setToEmails('support@ipwgc.com');
		$xoopsMailer->setFromEmail($yemail);
		$xoopsMailer->setFromName($yname);
		$xoopsMailer->setSubject($title);
		$xoopsMailer->multimailer->IsHTML(true);
		$xoopsMailer->setBody($body);
		$xoopsMailer->send();
		$msg = '
			<div align="center" style="width: 80%; padding: 10px; padding-top:0px; padding-bottom: 5px; border: 2px solid #9C9C9C; background-color: #F2F2F2; margin-right:auto;margin-left:auto;">
			<h3>'._AM_SOCIALNET_FEEDSUCCESS.'</h3>
			</div>
			';
	case 'feature':
	default:
		echo (!empty($msg)) ? $msg."<br />" : '';
		$form['title'] = _AM_SOCIALNET_FEEDBACKN;
		$form['op'] = "save";
		include XOOPS_ROOT_PATH."/modules/socialnet/include/feedback.form.inc.php";
		$feedbackform->display();
		break;
}
echo "<div align='center' style='margin-top:10px'><a href='http://www.ipwgc.com/socialnet/'><img src='../images/socialnetLogo.png'></a><br /><img src='../images/menu/mailuser.gif'><a style='color: #029116; font-size:11px' href='feedback.php'>"._AM_SOCIALNET_FEEDBACK."</a> - <img src='../images/icons/mainvideo.gif'><a style='color: #FF0000; font-size:11px' href='http://www.ipwgc.com/socialnet/modules/socialnet/index.php' target='_blank'>"._AM_SOCIALNET_CHKVERSION."</a></div>";
xoops_cp_footer();