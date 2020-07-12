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
include("header.php");
include XOOPS_ROOT_PATH."/modules/socialnet/include/functionsbuddy.php";
// *******************************************************************************
// **** Main
// *******************************************************************************

$ModName = "Messenger";
global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsTheme, $xoopsLogger, $xoopsMF;
$uid=$xoopsUser->uid();
$currenttheme = getTheme();

echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
If($xoopsUser) {                 
echo "<html>\n<head>";
echo "<LINK REL=\"StyleSheet\" HREF=\"".XOOPS_URL."/themes/$currenttheme/style.css\" TYPE=\"text/css\">\n";
} else {
echo "<html>\n<head>\n";
echo "<LINK REL=\"StyleSheet\" HREF=\"".XOOPS_URL."/themes/$currenttheme/style.css\" TYPE=\"text/css\">\n";
move();
echo "<body LEFTMARGIN=3 MARGINWIDTH=3 TOPMARGIN=3 MARGINHEIGHT=3>\n";
echo "<table height=100% width=100%><tr><td>";
OpenTable();
echo "<p align=center class=pn-title>"._MD_SOCIALNET_BUDDY_PLEASE." $ModName<BR><a href='javascript:window.opener.location=\"".XOOPS_URL."/register.php\";window.close();'>"._MD_SOCIALNET_BUDDY_REGIN."</a><BR><BR>"._IFMEMBER." ".$xoopsConfig['sitename']."<BR><a href='javascript:window.opener.location=\"".XOOPS_URL."/user.php\";window.close();'>"._MD_SOCIALNET_BUDDY_ORLOGIN."</a></p>\n";
CloseTable();
echo "</td></tr></table></body></html>\n";
        exit;
}
$task = isset($HTTP_GET_VARS['task']) ? trim($HTTP_GET_VARS['task']) : '';
$task = isset($HTTP_POST_VARS['task']) ? trim($HTTP_POST_VARS['task']) : $task;
$type = isset($HTTP_GET_VARS['type']) ? trim($HTTP_GET_VARS['type']) : '';
$type = isset($HTTP_POST_VARS['type']) ? trim($HTTP_POST_VARS['type']) : $type;
$msg_id = isset($HTTP_GET_VARS['msg_id']) ? trim($HTTP_GET_VARS['msg_id']) : '';
$msg_id = isset($HTTP_POST_VARS['msg_id']) ? trim($HTTP_POST_VARS['msg_id']) : $msg_id;

switch($task)  {
        case "buddel":
        buddel($prev_msg);
        break;
        case "buddyread":
        buddyread($msg_id, $msg_time);
        break;
        case "buddycompose":
        buddycompose($to, $subject, $prev_msg);
        break;
        case "buddyfriend":
        displayFriendsList($beg);
        break;
	    case "mod":
        displayUsersList($beg, $letter);
        break;
	    case "add":
        addFriend($_GET['uid']);
        break;
	    case "remove":
        deleteFriend($uid);
        break;
        default:
        buddylist();
        break;
}

?>
