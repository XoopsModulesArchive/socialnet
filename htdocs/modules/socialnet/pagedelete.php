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

require 'header.php';
include_once '../../mainfile.php';
include_once '../../header.php';
include_once 'class/socialnet_controler.php';
// *******************************************************************************
// **** Main
// *******************************************************************************

$socialnet_handler =& xoops_getmodulehandler('socialnet', 'socialnet');
$uid = $id = 0;
$res = false;

if(is_object($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->getVar('mid'))) {
	$uid = $xoopsUser->getVar('uid');
} else {
	header('Location: pagelist.php');
	exit;
}

if(isset($_GET['id'])) {
	$id = intval($_GET['id']);
	$page = $socialnet_handler->get($id);
	if(is_object($page)) {
		$res = $socialnet_handler->delete($page, true);
	}
}
if($res) {
	redirect_header('pageuser.php', 2, _MD_SOCIALNET_DB_OK);
	exit();
} else {
	redirect_header('pageuser.php', 4, _ERRORS);
	exit();
}
include '../../footer.php';
?>
