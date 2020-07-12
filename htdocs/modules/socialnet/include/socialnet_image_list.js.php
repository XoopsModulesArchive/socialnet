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

include_once("../../../mainfile.php");
$xoopsLogger->activated = false;
$ret = "";
if (!is_object($xoopsUser)) {
	$group = array(XOOPS_GROUP_ANONYMOUS);
} else {
	$group =& $xoopsUser->getGroups();
}
$imgcat_handler =& xoops_gethandler('imagecategory');
$catlist =& $imgcat_handler->getList($group, 'imgcat_read', 1);
$catcount = count($catlist);
if ($catcount > 0) {
	foreach ($catlist as $c_id => $c_name) {
		$ret .= '["--- '.$c_name.' ---", ""],';
		$image_handler = xoops_gethandler('image');
		$criteria = new CriteriaCompo(new Criteria('imgcat_id', $c_id));
		$criteria->add(new Criteria('image_display', 1));
		$total = $image_handler->getCount($criteria);
		if ($total > 0) {
			$imgcat =& $imgcat_handler->get($c_id);
			$storetype = $imgcat->getVar('imgcat_storetype');
			if ($storetype == 'db') {
				$images =& $image_handler->getObjects($criteria, false, true);
			} else {
				$images =& $image_handler->getObjects($criteria, false, false);
			}
			$imgcount = count($images);
			for ($i = 0; $i < $imgcount; $i++) {
				if ($storetype == 'db') {
					$ret .= '["'.$images[$i]->getVar('image_nicename').'", "'.XOOPS_URL."/image.php?id=".$images[$i]->getVar('image_id').'"],';
				} else {
					$ret .= '["'.$images[$i]->getVar('image_nicename').'", "'.XOOPS_UPLOAD_URL.'/'.$images[$i]->getVar('image_name').'"],';
				}
			}
		}
	}
	$ret = substr($ret, 0, -1);
}
?>
var tinyMCEImageList = new Array(
	<?=$ret;?>
);