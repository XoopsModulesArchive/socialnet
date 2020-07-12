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

function b_birthday_show() {
	global $xoopsUser, $xoopsDB, $xoopsModule;
	$block = array();

	$sql="SELECT * FROM ".$xoopsDB->prefix("socialnet_birthday")." as B, ".$xoopsDB->prefix("users")." as U WHERE B.day LIKE '".date("d",time())."' AND B.month LIKE '".date("m",time())."' AND U.uid=B.uid ORDER BY B.year ASC";
  	$result = $xoopsDB->query($sql);
	$nb=$xoopsDB->getRowsNum($result);
	$block['content'] = "";
	
	if ($nb!=0) {
		$block['content'] .= "<p>";
		//$block['content'] .= _MB_SOCIALNET_BLO_BIRTH_CONGRA."<p>";
		$block['content'] .= "<table style='text-align:left'><tr>";
		while ($en=mysql_fetch_array($result)) {
 			$block['content'] .= "<img src='".XOOPS_URL."/modules/socialnet/images/profile/birthday.gif' border='0'> ";
			$block['content'] .= _MB_SOCIALNET_BLO_BIRTH_CONGRA;
			$block['content'] .= "<td>";
			$block['content'] .= "<img src='".XOOPS_URL."/modules/socialnet/images/users/newemail.gif' border='0'><a href='".XOOPS_URL."/userinfo.php?uid=".$en['uid']."'>".$en['uname']."</a> ";
			$block['content'] .= "</td><td>";
			$block['content'] .= _MB_SOCIALNET_BLO_BIRTH_TODAY;
        	$block['content'] .= "<b>".(date("Y",time())-$en['year'])."</b>";
			$block['content'] .= _MB_SOCIALNET_BLO_BIRTH_YEARSOLD;
			$block['content'] .= "</td><td>";
			$block['content'] .= "</td><tr>";
			$block['content'] .= "<tr>";
			$block['content'] .= "<a href=\"javascript:openWithSelfMain('".XOOPS_URL."/pmlite.php?send2=1&to_userid=".$en['uid']."','pmlite',640,480);\"><img src='".XOOPS_URL."/images/icons/pm_small.gif' border='0' alt='"._MB_SOCIALNET_BLO_BIRTH_SEND.$en['uname']._MB_SOCIALNET_BLO_BIRTH_SEND2."' align='middle'><img src='".XOOPS_URL."/images/icons/pm.gif' border='0' alt='"._MB_SOCIALNET_BLO_BIRTH_SEND.$en['uname']._MB_SOCIALNET_BLO_BIRTH_SEND2."' align='middle' ></a>";
			$block['content'] .= "<tr>";
		}
			$block['content'] .= "</table>";

	} else {
		$block['content'] .= "<p>";
		$block['content'] .= _MB_SOCIALNET_BLO_BIRTH_NOBIRTHDAY;
		$block['content'] .= "</p>";
	}
	if ($xoopsUser) {
		$block['content'] .= "<p align='right'><font size=1><strong><a href=\"".XOOPS_URL."/modules/socialnet/birthdaybegin.php\">"._MB_SOCIALNET_BLO_BIRTH_EDIT."</a></strong></font></p>";
	}
	return $block;

}
?>
