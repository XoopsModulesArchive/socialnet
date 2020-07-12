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
$criterio = new CriteriaCompo(new Criteria("fil_12_show", 1));
$criterio->setSort("fil_30_name");
$fil_classe = new socialnet_fil_files();
$files = $fil_classe->PegaTudo($criterio);
if ($fil_classe->total > 0) {

	foreach ($files as $fil) {
		$ext = (substr($fil->getVar('fil_30_file'), -4,1) == ".") ? substr($fil->getVar('fil_30_file'), -4) : substr($fil->getVar('fil_30_file'), -5);
		$ret .= '["'.$fil->getVar('fil_30_name').'  ('.$ext.')", "'.SOCIALNET_FILES_URL.'/'.$fil->getVar('fil_30_file').'"],';
	}
	$ret = substr($ret, 0, -1);
}
?>
var tinyMCELinkList = new Array(
	<?=$ret;?>
);