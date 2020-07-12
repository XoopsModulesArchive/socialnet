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
include_once("../admin/admin_header.php");
$xoopsLogger->activated = false;
$ret = "";
if (!is_object($xoopsUser) || !$xoopsUserIsAdmin) {
	die("Oops!");
}
$criterio = new CriteriaCompo(new Criteria("med_12_show", 1));
$criterio->setSort("med_30_name");
$med_classe = new socialnet_med_media();
$medias = $med_classe->PegaTudo($criterio);
$tipos = array(1=>_AM_SOCIALNET_MED_10_TYPE_1, 2=>_AM_SOCIALNET_MED_10_TYPE_2, 3=>_AM_SOCIALNET_MED_10_TYPE_3,4=>_AM_SOCIALNET_MED_10_TYPE_4,5=>_AM_SOCIALNET_MED_10_TYPE_5);
if ($med_classe->total > 0) {

	foreach ($medias as $med) {
		$ret .= '["'.$med->getVar('med_30_name').'  ['.$tipos[$med->getVar('med_10_type')].']", "'.SOCIALNET_MEDIA_URL.'/'.$med->getVar('med_30_file').'"],';
	}
	$ret = substr($ret, 0, -1);
}
?>
var tinyMCEMediaList = new Array(
	<?=$ret;?>
);