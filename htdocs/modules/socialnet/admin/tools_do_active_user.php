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

	xoops_cp_header();
	adminmenu(12);
	global $xoopsConfig, $xoopsTheme, $xoopsUser, $xoopsModule;

  if (HtmlSpecialchars($_GET['action']) == "status"){
 $uid = HtmlSpecialchars($_GET['uid']);
 $query =mysql_query("UPDATE  ".$xoopsDB->prefix("users")." SET level='1' WHERE uid='$uid' ")
  or die("users");

  if (!$query){

  echo"<center>" . _AM_SOCIALNET_ERROR . "</center><META HTTP-EQUIV=\"Refresh\" Content=2;URL=\"" . XOOPS_URL . "/modules/socialnet/admin/tools_activeall_user.php\">";
  }else{
  echo"<center>" . _AM_SOCIALNET_OK . "<br>" . _AM_SOCIALNET_REDIRECT . "</center><META HTTP-EQUIV=\"Refresh\" Content=2;URL=\"" . XOOPS_URL . "/modules/socialnet/admin/tools_activeall_user.php\">";
    }
   }
    if (HtmlSpecialchars($_GET['action']) == "statusr"){

 $query =mysql_query("UPDATE  ".$xoopsDB->prefix("users")." SET level='1' ")
  or die("users");

  if (!$query){

  echo"<center>" . _AM_SOCIALNET_ERROR . "</center><META HTTP-EQUIV=\"Refresh\" Content=2;URL=\"" . XOOPS_URL . "/modules/socialnet/admin/tools_activeall_user.php\">";
  }else{
  echo"<center>" . _AM_SOCIALNET_OK . "<br>" . _AM_SOCIALNET_REDIRECT . "</center><META HTTP-EQUIV=\"Refresh\" Content=2;URL=\"" . XOOPS_URL . "/modules/socialnet/admin/tools_activeall_user.php\">";
    }
   }
    if (HtmlSpecialchars($_GET['action']) == "statusd"){
 $uid = HtmlSpecialchars($_GET['uid']);

 $query = mysql_query("DELETE FROM ".$xoopsDB->prefix("users")." WHERE uid='$uid'")
  or die("cant users");

  if (!$query){

  echo"<center>" . _AM_SOCIALNET_ERROR . "</center><META HTTP-EQUIV=\"Refresh\" Content=2;URL=\"" . XOOPS_URL . "/modules/socialnet/admin/tools_activeall_user.php\">";
  }else{
  echo"<center>" . _AM_SOCIALNET_OK . "<br>" . _AM_SOCIALNET_REDIRECT . "</center><META HTTP-EQUIV=\"Refresh\" Content=2;URL=\"" . XOOPS_URL . "/modules/socialnet/admin/tools_activeall_user.php\">";
    }
   }
     xoops_cp_footer();
?>