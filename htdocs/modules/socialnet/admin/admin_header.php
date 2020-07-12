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
include_once(XOOPS_ROOT_PATH."/class/xoopsmodule.php");
include_once(XOOPS_ROOT_PATH."/include/cp_functions.php");

include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/include/cp_header.php';
include_once dirname(__FILE__) . '/functions.php';
include_once dirname(dirname(__FILE__)) . '/include/functions.php';


include '../../../include/cp_header.php';
if ( file_exists("../language/".$xoopsConfig['language']."/modinfo.php") ) {
	include_once("../language/".$xoopsConfig['language']."/modinfo.php");
} else {
	include_once("../language/english/modinfo.php");
}

/*
* Show Spot-Images
*/
include_once XOOPS_ROOT_PATH."/modules/socialnet/include/functionspot.inc.php";
$c['lang']['filters'] = _AM_SOCIALNET_FILTERS;
$c['lang']['show'] = _AM_SOCIALNET_SHOW;
$c['lang']['showing'] = _AM_SOCIALNET_SHOWING;
$c['lang']['perpage'] = _AM_SOCIALNET_PERPAGE;
$c['lang']['action'] = _AM_SOCIALNET_ACTION;
$c['lang']['semresult'] = _AM_SOCIALNET_SEMRESULT;
$c['lang']['showhidemenu'] = _AM_SOCIALNET_SHOWHIDEMENU;

$c['lang']['group_action'] = _AM_SOCIALNET_GRP_ACTION;
$c['lang']['group_error_sel'] = _AM_SOCIALNET_GRP_ERR_SEL;
$c['lang']['group_del'] = _AM_SOCIALNET_GRP_DEL;
$c['lang']['group_del_sure'] = _AM_SOCIALNET_GRP_DEL_SURE;


/*
* Show template
*/
if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
	include_once XOOPS_ROOT_PATH . '/class/template.php';
	$xoopsTpl = new XoopsTpl();
}

/*
* Show User
*/
if ( $xoopsUser ) {
	$xoopsModule = XoopsModule::getByDirname("socialnet");
	if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) { 
		redirect_header(XOOPS_URL."/",3,_NOPERM);
		exit();
	}
} else {
	redirect_header(XOOPS_URL."/",3,_NOPERM);
	exit();
}


/*
* Show Tree Menu
*/
include_once XOOPS_ROOT_PATH."/modules/socialnet/class/socialnet_mpb_mpublish.class.php";
include_once XOOPS_ROOT_PATH."/modules/socialnet/class/socialnet_med_media.class.php";
include_once XOOPS_ROOT_PATH."/modules/socialnet/class/socialnet_fil_files.class.php";
include_once XOOPS_ROOT_PATH."/modules/socialnet/class/socialnet_cfi_contentfiles.class.php";
include_once XOOPS_ROOT_PATH."/modules/socialnet/include/functionstree.inc.php";


/*
* Show PopChat
*/

if ( is_object($xoopsUser) ) {
	$xoopsModule = XoopsModule::getByDirname("socialnet");
	if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) {
		redirect_header($xoopsConfig['xoops_url']." / ",3,_NOPERM);
		exit();
	}
} else {
	redirect_header($xoopsConfig['xoops_url']." / ",3,_NOPERM);
	exit();
}
if ( file_exists("../language/".$xoopsConfig['language']."/admin.php") ) {
	include_once("../language/".$xoopsConfig['language']."/admin.php");
} else {
	include_once("../language/english/admin.php");
}
$ts =& MyTextSanitizer::getInstance();

?>