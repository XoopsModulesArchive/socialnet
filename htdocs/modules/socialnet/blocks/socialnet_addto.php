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

if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

function socialnet_addto_show($options)
{
	include_once(XOOPS_ROOT_PATH . '/modules/socialnet/include/common.php');
	include_once(XOOPS_ROOT_PATH . '/modules/socialnet/class/socialnet_addto.php');
	$socialnetaddto = new SocialnetAddTo($options[0]);
	$block = $socialnetaddto->renderForBlock();
	return $block;
}

function socialnet_addto_edit($options)
{
	include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

	$form = '';

	$layout_select = new XoopsFormSelect(_MB_SOCIALNET_BLO_ADDTO_LAYOUT, 'options[]', $options[0]);
	$layout_select->addOption(0, _MB_SOCIALNET_BLO_ADDTO_LAYOUT_OPTION0);
	$layout_select->addOption(1, _MB_SOCIALNET_BLO_ADDTO_LAYOUT_OPTION1);
	$layout_select->addOption(2, _MB_SOCIALNET_BLO_ADDTO_LAYOUT_OPTION2);
	$layout_select->addOption(3, _MB_SOCIALNET_BLO_ADDTO_LAYOUT_OPTION3);
	$form .= $layout_select->getCaption() . ' ' . $layout_select->render() . '<br />';

	return $form;
}

?>