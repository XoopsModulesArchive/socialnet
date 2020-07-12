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
include("admin_header.php");

// *******************************************************************************
// **** Main
// *******************************************************************************

  xoops_cp_header();
adminmenu(11);
global $xoopsConfig, $xoopsTheme, $xoopsUser, $xoopsModule;
$xid = $_GET['xid'];
if (!$xid){
echo""._AM_SOCIALNET_MSGNONEEDIT."";
}else{
 $sql=mysql_query("SELECT * FROM ".$xoopsDB->prefix("socialnet_note")." WHERE xid='$xid'")
  or die("can't get the note");
  $row = mysql_fetch_array($sql);
?>
<BR><div align='left'>

<table width=95% >
<form method='POST' action='tools_do_edit.php'>

<input type ='hidden' name='xid' value="<?php echo $row["xid"] ?>">
<tr>
<td><? echo _AM_SOCIALNET_MSGNAME; ?></td>
<td> <input type ='text' name='name' size='50' value="<?php echo $row["name"] ?>" ></td>
</tr>
<tr>
<tr>
<td><? echo _AM_SOCIALNET_MSGTHENOTE; ?></td>
<td><textarea rows="8" name="comment" cols="50"><?php echo $row["comment"] ?></textarea></td>

</tr>
</table><p><input type=submit value='  <? echo _AM_SOCIALNET_MSGSAVE; ?>  '    name=send></p>
</form>
  <?
  }
  xoops_cp_footer();
?>