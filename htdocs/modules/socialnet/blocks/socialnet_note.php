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

include_once XOOPS_ROOT_PATH."/modules/socialnet/admin/note.textsanitizer.php";
include_once XOOPS_ROOT_PATH."/include/xoopscodes.php";

function b_note_blocks_show($options) {
	global $xoopsUser, $xoopsConfig, $xoopsDB;
	$block = array();
	$myts =& noteTextSanitizer::getInstance();

$sql=$xoopsDB->query("select count(xid) from ".$xoopsDB->prefix("socialnet_note"));
list($numrows) = $xoopsDB->fetchRow($sql);

$result = $xoopsDB->query("SELECT name, comment FROM ".$xoopsDB->prefix("socialnet_note")." order by xid desc limit ".$options[1]."");
	while($myrow = $xoopsDB->fetchArray($result)){
        $note= array();
        $note['name'] = $myts->htmlSpecialChars($myrow['name']);
     		$note['comment'] = $myts->makeTareaData4Show($myrow['comment'],0);
        $block['note'][] = $note;
	}

	return $block;
}

function b_note_blocks_edit($options) {
	$form = ""._MB_SOCIALNET_BLO_AMSGN_DISP."&nbsp;";
	$form .= "<input type='hidden' name='options[]' value='";
	$form .= "date'";
	$form .= " />";
	$form .= "<input type='text' name='options[]' value='".$options[1]."' />&nbsp;"._MB_SOCIALNET_BLO_AMSG_NUM."";
	return $form;
}
?>