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

// If you want to limit access to this page to registred users only, uncomment the following lines :
/*
if(!is_object($xoopsUser)) {	// Only for registred users
	redirect_header(XOOPS_URL.'/index.php', 2, _ERRORS);
	exit();
}
*/
$socialnet_handler =& xoops_getmodulehandler('socialnet', 'socialnet');
$uid = 0;
if(is_object($xoopsUser)) {
	$uid = $xoopsUser->getVar('uid');
}

$page_id = isset($_GET['page_id']) ? intval($_GET['page_id']) : 0;
if(empty($page_id)) {	// Search for current user's page
	$criteria = new Criteria('up_uid', $uid, '=');
} else {	// Search for a specific user page
	$criteria = new Criteria('up_pageid', $page_id, '=');
}

$cnt = $socialnet_handler->getCount($criteria);
if($cnt>0) {
	$pagetbl = $socialnet_handler->getObjects($criteria);
	$page = $pagetbl[0];
} else {	// Page not found
	redirect_header(XOOPS_URL.'/index.php', 2, _MD_SOCIALNET_PAGE_NOT_FOUND);
	exit();
}

$page->setVar('dohtml', socialnet_utils::getModuleOption('allowhtml'));
$myts =& MyTextSanitizer::getInstance();
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
echo '<html><head>';
echo '<meta http-equiv="Content-Type" content="text/html; charset='._CHARSET.'" />';
echo '<title>'. _MD_SOCIALNET_PAGE_OF.$page->uname().' - '.$myts->htmlSpecialChars(_MD_SOCIALNET_PRINTABLE).' - '.$xoopsConfig['sitename'].'</title>';
echo '<meta name="AUTHOR" content="'.$xoopsConfig['sitename'].'" />';
echo '<meta name="COPYRIGHT" content="Copyright (c) 2010 by '.$xoopsConfig['sitename'].'" />';
echo '<meta name="DESCRIPTION" content="'.$xoopsConfig['slogan'].'" />';
echo '<meta name="GENERATOR" content="SOCIALNET By IPWGC.com" />';
echo '<body bgcolor="#ffffff" text="#000000" onload="window.print()">
	<table border="0"><tr><td align="center">
	<table border="0" width="100%" cellpadding="0" cellspacing="1" bgcolor="#000000"><tr><td>
	<table border="0" width="100%" cellpadding="20" cellspacing="1" bgcolor="#ffffff"><tr><td align="center">
	<img src="'.XOOPS_URL.'/images/logo.gif" border="0" alt="" /><br /><br />
	<h3>'._MD_SOCIALNET_PAGE_OF.$page->uname().'</h3>';
echo '<tr valign="top" style="font:12px;"><td>';
echo "<table border='0' width='100%' align='center'>";
echo "<tr><td><b>".$page->getVar('up_title')."</b></td></tr>";
echo "<tr><td>".$page->getVar('up_text')."</td></tr>";
echo "</table>";
echo '</td></tr></table></td></tr></table><br /><br />';
printf(_MD_SOCIALNET_THISCOMESFROM,$xoopsConfig['sitename']);
echo '<br /><a href="'.XOOPS_URL.'/">'.XOOPS_URL.'</a><br /><br />'._MD_SOCIALNET_URLFORPAGE.' <br /><a href="'.$page->getURL().'">'.$page->getURL().'</a></td></tr></table></body></html>';
?>