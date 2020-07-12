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

require_once '../../../include/cp_header.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/include/common.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/admin/functions.php';
require_once XOOPS_ROOT_PATH.'/class/pagenav.php';

// *******************************************************************************
// **** Main
// *******************************************************************************

	xoops_cp_header();
	adminmenu(13);

$xoopsOption['pagetype'] = "user";
$email = isset($HTTP_GET_VARS['email']) ? trim($HTTP_GET_VARS['email']) : '';
$email = isset($HTTP_POST_VARS['email']) ? trim($HTTP_POST_VARS['email']) : $email;
//Get User Email   By Onasre
$uid = $_GET['uid'];
  $sql=mysql_query("SELECT * FROM ".$xoopsDB->prefix("users")." WHERE uid='$uid'")
  or die("can't get the sql");
  $row = mysql_fetch_array($sql);
//End Call User Email   by Onasre
$RE=  _AM_SOCIALNET_RE_ACTIVE0;
$RE1=_AM_SOCIALNET_RE_ACTIVE1;
$RE2=_AM_SOCIALNET_RE_ACTIVE2;
// If $email is empty, show form for link resend
if ($email == '') {
echo <<< TOPET05
<fieldset style="padding: 10px;">
  <legend style="font-weight: bold;">$RE</legend>
  <div><br />$RE1</div>
  <form action="$_SERVER[PHP_SELF]" method="post">
    $RE2<input type="text" name="email" size="26" maxlength="60" value="$row[email]" /></p> &nbsp; <input type="submit" value="Send" />
  </form>
</fieldset>
TOPET05;
// If $email is not empty, let's verify some things before sending the link
}else{
$myts =& MyTextSanitizer::getInstance();
$member_handler =& xoops_gethandler('member');
// The line below returns an array with all the users registered with the given e-mail, in our case it'll be only the $getuser[0]
$getuser =& $member_handler->getUsers(new Criteria('email', $myts->addSlashes($email)));
// If the e-mail doesn't exist in the database, $getuser returns empty...
if (empty($getuser)) {
echo "<h2>"._AM_SOCIALNET_RE_ACTIVE3."</h2>";
    exit();
}
//Verifying if the user is already active...
if($getuser[0]->isActive()){
echo "<h2>"._AM_SOCIALNET_RE_ACTIVE4."  ".$getuser[0]->getVar('uname').", "._AM_SOCIALNET_RE_ACTIVE2." ".$getuser[0]->getVar('email')."  "._AM_SOCIALNET_RE_ACTIVE5." </h2>";
    exit();
}
//Sending it
$xoopsMailer =& getMailer();
$xoopsMailer->useMail();
$xoopsMailer->setTemplate('register.tpl');
$xoopsMailer->assign('SITENAME', $xoopsConfig['sitename']);
$xoopsMailer->assign('ADMINMAIL', $xoopsConfig['adminmail']);
$xoopsMailer->assign('SITEURL', XOOPS_URL."/");
$xoopsMailer->setToUsers($getuser[0]);
$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
$xoopsMailer->setFromName($xoopsConfig['sitename']);
$xoopsMailer->setSubject(sprintf("- Resend - "._AM_SOCIALNET_USERKEYFOR,$getuser[0]->getVar("uname")));
    if ( !$xoopsMailer->send() ) {
    echo "<h2>"._AM_SOCIALNET_RE_ACTIVE6." ".$getuser[0]->getVar('uname').""._AM_SOCIALNET_RE_ACTIVE7."</h2>";
    exit();
    } else {
    echo "<h2>"._AM_SOCIALNET_RE_ACTIVE8."".$getuser[0]->getVar('uname')." "._AM_SOCIALNET_RE_ACTIVE9."</h2>";
    echo "<meta http-equiv=\"refresh\" content=\"3;URL=tools_activeall_user.php\">";
    }
}
  xoops_cp_footer();
?>