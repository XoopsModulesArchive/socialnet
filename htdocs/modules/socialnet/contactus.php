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
include_once 'class/socialnet_controler.php';
include XOOPS_ROOT_PATH.'/header.php';


if (empty($_POST['submit']) | !$GLOBALS['xoopsSecurity']->check()) {
    $xoopsOption['template_main'] = 'socialnet_contactusform.html';
        $xoopsConfig["module_cache"][$xoopsModule->getVar("mid")] = 0;
    include XOOPS_ROOT_PATH."/header.php";
    include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
    $company_v = "";
    $name_v = !empty($xoopsUser) ? $xoopsUser->getVar("uname", "E") : "";
    $email_v = !empty($xoopsUser) ? $xoopsUser->getVar("email", "E") : "";
    $url_v = !empty($xoopsUser) ? $xoopsUser->getVar("url", "E") : "";
    $icq_v = !empty($xoopsUser) ? $xoopsUser->getVar("user_icq", "E") : "";
    $location_v = !empty($xoopsUser) ? $xoopsUser->getVar("user_from", "E") : "";
    $comment_v = "";
    include "contactform.php";
    $contact_form->assign($xoopsTpl);
    include XOOPS_ROOT_PATH."/footer.php";
} else {
    $myts =& MyTextSanitizer::getInstance();
    xoops_load("captcha");
    $xoopsCaptcha = XoopsCaptcha::getInstance();
    if (! $xoopsCaptcha->verify() ) {
                redirect_header( XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/index.php", 2, $xoopsCaptcha->getMessage() );
                exit();
    }
    if ( ! ( $usersEmail = checkEmail( $myts->stripSlashesGPC($_POST['usersEmail']) ) ) ) {
                redirect_header( XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/index.php", 2, _MD_SOCIALNET_INVALIDMAIL );
                exit();
    }
    $usersCompanyName = $myts->stripSlashesGPC($_POST['usersCompanyName']);
    $usersCompanyLocation = $myts->stripSlashesGPC($_POST['usersCompanyLocation']);
    $usersComments = $myts->stripSlashesGPC($_POST['usersComments']);
    $usersName = $myts->stripSlashesGPC($_POST['usersName']);
    $usersSite = @$myts->stripSlashesGPC($_POST['usersSite']);
    $usersICQ = @$myts->stripSlashesGPC($_POST['usersICQ']);

    $adminMessage = sprintf(_MD_SOCIALNET_SUBMITTED,$usersName);
    $adminMessage .= "\n";
    $adminMessage .= ""._MD_SOCIALNET_EMAIL." $usersEmail\n";
    if ( !empty($usersSite) ) {
        $adminMessage .= ""._MD_SOCIALNET_URL." $usersSite\n";
    }
    if ( !empty($usersICQ) ) {
        $adminMessage .= ""._MD_SOCIALNET_ICQ." $usersICQ\n";
    }
    if ( !empty($usersCompanyName) ) {
        $adminMessage .= _MD_SOCIALNET_COMPANY. " $usersCompanyName\n";
    }
    if ( !empty($usersCompanyLocation) ) {
        $adminMessage .= _MD_SOCIALNET_LOCATION." $usersCompanyLocation\n";
    }
    $adminMessage .= _MD_SOCIALNET_COMMENTS."\n";
    $adminMessage .= "\n$usersComments\n";
    $adminMessage .= "\n".$_SERVER['HTTP_USER_AGENT']."\n";
    $subject = $xoopsConfig['sitename']." - "._MD_SOCIALNET_CONTACTFORM;
    $xoopsMailer =& getMailer();
    $xoopsMailer->useMail();
    $xoopsMailer->setToEmails($xoopsConfig['adminmail']);
    $xoopsMailer->setFromEmail($usersEmail);
    $xoopsMailer->setFromName($xoopsConfig['sitename']);
    $xoopsMailer->setSubject($subject);
    $xoopsMailer->setBody($adminMessage);
    $xoopsMailer->send();
    $messagesent = sprintf(_MD_SOCIALNET_MESSAGESENT,$xoopsConfig['sitename'])."<br />"._MD_SOCIALNET_THANKYOU."";

        // uncomment the following lines if you want to send confirmation mail to the user
        $conf_subject = _MD_SOCIALNET_THANKYOU;
        $userMessage = sprintf(_MD_SOCIALNET_HELLO,$usersName);
        $userMessage .= "\n\n";
        $userMessage .= sprintf(_MD_SOCIALNET_THANKYOUCOMMENTS,$xoopsConfig['sitename']);
        $userMessage .= "\n";
        $userMessage .= sprintf(_MD_SOCIALNET_SENTTOWEBMASTER,$xoopsConfig['sitename']);
        $userMessage .= "\n";
        $userMessage .= _MD_SOCIALNET_YOURMESSAGE."\n";
        $userMessage .= "\n$usersComments\n\n";
        $userMessage .= "--------------\n";
        $userMessage .= "".$xoopsConfig['sitename']." "._MD_SOCIALNET_WEBMASTER."\n";
        $userMessage .= "".$xoopsConfig['adminmail']."";
        $xoopsMailer =& getMailer();
        $xoopsMailer->useMail();
        $xoopsMailer->setToEmails($usersEmail);
        $xoopsMailer->setFromEmail($usersEmail);
        $xoopsMailer->setFromName($xoopsConfig['sitename']);
        $xoopsMailer->setSubject($conf_subject);
        $xoopsMailer->setBody($userMessage);
        $xoopsMailer->send();
        $messagesent .= sprintf(_MD_SOCIALNET_SENTASCONFIRM, $usersEmail);

        // uncomment the following lines if you want a message to webmaster besides mail
        $pm_handler =& xoops_gethandler('privmessage');
        $pm =& $pm_handler->create();
        $pm->setVar("subject", $subject);
        $pm->setVar("msg_text", $adminMessage);
        $pm->setVar("to_userid", 1);
        $pm->setVar("from_userid", is_object($xoopsUser)?$xoopsUser->getVar("uid"):0);
        if (!$pm_handler->insert($pm)) {
                $messagesent .='';
        } else {
                $messagesent .='';
        }

    redirect_header(XOOPS_URL."/modules/socialnet/index.php",2,$messagesent);
}

include '../../footer.php';

?>