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

require_once XOOPS_ROOT_PATH.'/modules/socialnet/include/common.php';

/**
 * Show last pages
 */
function b_socialnet_last_show($options)	// 10=Items count, 30=Title's length
{
	$block = array();
	$start = 0;
	$limit = intval($options[0]);

	$socialnet_handler =& xoops_getmodulehandler('socialnet', 'socialnet');
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('1', '1','='));
	$criteria->setLimit($limit);
	$criteria->setStart($start);
	$criteria->setSort('up_created');
	$criteria->setOrder('DESC');
	$pages = array();
	$pages = $socialnet_handler->getObjects($criteria);

	foreach($pages as $page) {
		$page->setVar('dohtml', socialnet_utils::getModuleOption('allowhtml'));
		$data = array();
		$data = $page->toArray();
		$data['up_title'] = xoops_substr(strip_tags($page->getVar('up_title')),0,intval($options[1]));
		$block['pages'][] = $data;
	}
	return $block;
}


/**
 * The edit function
 */
function b_socialnet_last_edit($options)		// 10=Items count, 30=Title's length
{
	$form= '';
    $form .= _MB_SOCIALNET_BLO_PAGE_ITEMS_COUNT."&nbsp;<input type='text' name='options[]' value='".$options[0]."' />&nbsp;<br />";
    $form .= _MB_SOCIALNET_BLO_PAGE_TITLES_LENGTH."&nbsp;<input type='text' name='options[]' value='".$options[1]."' />&nbsp;";
	return $form;
}


/**
* Block, "on the fly".
*/
function b_socialnet_last_onthefly($options)
{
	$options = explode('|',$options);
	$block = & b_socialnet_last_show($options);

	$tpl = new XoopsTpl();
	$tpl->assign('block', $block);
	$tpl->display('db:socialnet_block_last.html');
}
?>