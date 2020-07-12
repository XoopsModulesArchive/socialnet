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
require_once XOOPS_ROOT_PATH.'/class/template.php';

// *******************************************************************************
// **** Main
// *******************************************************************************

if(!socialnet_utils::getModuleOption('allowrss')) {
	exit();
}

if (function_exists('mb_http_output')) {
	mb_http_output('pass');
}
$charset = 'utf-8';
header ('Content-Type:text/xml; charset='.$charset);
$tpl = new XoopsTpl();
$tpl->xoops_setCaching(2);
$tpl->xoops_setCacheTime(3600);
if (!$tpl->is_cached('db:socialnet_rss.html')) {
	$sitename = htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES);
	$email = $xoopsConfig['adminmail'];
	$slogan = htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES);
	$category = 'SocialNet';
	$module = 'SocialNet';
	$tpl->assign('charset',$charset);
	$tpl->assign('channel_title', xoops_utf8_encode($sitename));
	$tpl->assign('channel_link', XOOPS_URL.'/');
	$tpl->assign('channel_desc', xoops_utf8_encode($slogan));
	$tpl->assign('channel_lastbuild', formatTimestamp(time(), 'rss'));
	$tpl->assign('channel_webmaster', xoops_utf8_encode($email));
	$tpl->assign('channel_editor', xoops_utf8_encode($email));
	$tpl->assign('channel_category', xoops_utf8_encode($category));
	$tpl->assign('channel_generator', xoops_utf8_encode($module));
	$tpl->assign('channel_language', _LANGCODE);
	$tpl->assign('image_url', XOOPS_URL.'/images/logo.gif');
	$dimention = getimagesize(XOOPS_ROOT_PATH.'/images/logo.gif');
	if (empty($dimention[0])) {
		$width = 88;
	} else {
		$width = ($dimention[0] > 144) ? 144 : $dimention[0];
	}
	if (empty($dimention[1])) {
		$height = 31;
	} else {
		$height = ($dimention[1] > 400) ? 400 : $dimention[1];
	}
	$tpl->assign('image_width', $width);
	$tpl->assign('image_height', $height);

	$socialnet_handler =& xoops_getmodulehandler('socialnet', 'socialnet');
	$critere = new Criteria('1', '1','=');
	$critere->setLimit(10);
	$critere->setStart(0);
	$critere->setOrder('DESC');
	$critere->setSort('up_created');
	$pages = $socialnet_handler->getObjects($critere);
	foreach($pages as $page) {
		$titre  = htmlspecialchars($page->getVar('up_title'), ENT_QUOTES);
		$description = xoops_substr(htmlspecialchars(strip_tags($page->getVar('up_text')), ENT_QUOTES), 0, socialnet_utils::getModuleOption('rsslength'));
		$tpl->append('items', array('title' => xoops_utf8_encode($titre),
			'link' => $page->getURL(),
			'guid' => $page->getURL(),
			'pubdate' => formatTimestamp($page->getVar('up_created'), 'rss'),
			'description' => xoops_utf8_encode($description)));
	}
}
$tpl->display('db:socialnet_rss.html');
?>