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

if (!$_POST) {
	$tac = (isset($_GET['tac'])) ? $_GET['tac'] : 0;
	$tac = (is_int($tac)) ? $tac : str_replace("_"," ", $tac);
	if(!$tac){
		redirect_header(XOOPS_URL, 2, _MD_SOCIALNET_404);
	}else{
		$socialnet_classe = new socialnet_mpb_mpublish($tac);
		if (!$socialnet_classe->getVar("mpb_10_id")) {
			redirect_header(XOOPS_URL, 2, _MD_SOCIALNET_404);
		}else{
			$groups = (!empty($xoopsUser) && is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
			$gperm_handler =& xoops_gethandler('groupperm');
			if (!$gperm_handler->checkRight("socialnet_mpublish_acesso", $socialnet_classe->getVar("mpb_10_id"), $groups, $xoopsModule->getVar('mid'))) {
				redirect_header(XOOPS_URL, 3, _NOPERM);
				exit();
			}
			include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
			echo "<h2>".sprintf(_MD_SOCIALNET_RECTOAFRIEND, $socialnet_classe->getVar("mpb_30_title"))."</h2>";
			$rec_form = new XoopsThemeForm("", 'rec_form', $_SERVER['PHP_SELF']);
			$rec_form->addElement(new XoopsFormText(_MD_SOCIALNET_YNAME, "yname", 20, 150), true);
			$rec_form->addElement(new XoopsFormText(_MD_SOCIALNET_YEMAIL, "yemail", 20, 150), true);
			$rec_form->addElement(new XoopsFormText(_MD_SOCIALNET_FNAME, "fname", 20, 150), true);
			$rec_form->addElement(new XoopsFormText(_MD_SOCIALNET_FEMAIL, "femail", 20, 150), true);
			$rec_form->addElement(new XoopsFormTextArea(_MD_SOCIALNET_MESSAGE, "message"), true);
			$rec_form->addElement(new XoopsFormHidden("tac", $socialnet_classe->getVar("mpb_10_id")), true);
			$rec_form->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
			$rec_form->display();
			include_once XOOPS_ROOT_PATH.'/footer.php';
		}
	}
}else{
	$tac = (isset($_POST['tac'])) ? $_POST['tac'] : 0;
	if(!$tac){
		redirect_header(XOOPS_URL, 2, _MD_SOCIALNET_404);
	}else{
		$socialnet_classe = new socialnet_mpb_mpublish($tac);
		if (!$socialnet_classe->getVar("mpb_10_id")) {
			redirect_header(XOOPS_URL, 2, _MD_SOCIALNET_404);
		}else{
			$yname = $_POST['yname'];
			$yemail = $_POST['yemail'];
			$fname = $_POST['fname'];
			$femail = $_POST['femail'];
			$link = $socialnet_classe->pegaLink();
			$title = $socialnet_classe->getVar("mpb_30_title");
			$msg = nl2br(strip_tags($_POST['message']));
			$body = sprintf(_MD_SOCIALNET_MAILBODY, $fname, $yname, $yemail, $link, $title, $link, $yname, $msg);
			$xoopsMailer =& getMailer();
			$xoopsMailer->useMail();
			$xoopsMailer->setToEmails($femail);
			$xoopsMailer->setFromEmail($yemail);
			$xoopsMailer->setFromName($yname);
			$xoopsMailer->setSubject(sprintf(_MD_SOCIALNET_MAILSUBJECT, $yname));
			$xoopsMailer->multimailer->IsHTML(true);
			$xoopsMailer->setBody($body);
			$xoopsMailer->send();
			echo'
			<div align="center" style="width: 80%; padding: 10px; padding-top:0px; padding-bottom: 5px; border: 2px solid #9C9C9C; background-color: #F2F2F2; margin-right:auto;margin-left:auto;">
			'.sprintf(_MD_SOCIALNET_MAILSUCCESS, $fname, $socialnet_classe->pegaLink()).'
			</div>
			';
			include_once XOOPS_ROOT_PATH.'/footer.php';
		}
	}
}
?>