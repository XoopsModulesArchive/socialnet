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

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

function socialnet_searchpage($queryarray, $andor, $limit, $offset, $userid) {
	require_once XOOPS_ROOT_PATH.'/modules/socialnet/include/common.php';
	$socialnet_handler =& xoops_getmodulehandler('socialnet', 'socialnet');
	$ret = array();

	$criteria = new CriteriaCompo();
	if ($userid != 0) {
		$criteria->add(new Criteria('up_uid', $userid,'='));
	}

	if (is_array($queryarray) && $count = count($queryarray)) {
		$tmpcrit = new CriteriaCompo(new Criteria('up_title', "%".$queryarray[0]."%",'like'));
		$tmpcrit->add(new Criteria('up_text', "%".$queryarray[0]."%",'like'),'OR');
		$criteria->add($tmpcrit);
		unset($tmpcrit);
		for($i=1;$i < $count;$i++) {
			$tmpcrit = new CriteriaCompo(new Criteria('up_title', "%".$queryarray[$i]."%",'like'));
			$tmpcrit->add(new Criteria('up_text', "%".$queryarray[$i]."%",'like'),'OR');
			$criteria->add($tmpcrit,$andor);
			unset($tmpcrit);
		}
	}

	$criteria->setOrder('DESC');
	$criteria->setSort('up_created');
	$tblpages = array();
	$tblpages = $socialnet_handler->getObjects($criteria);
	$i = 0;
	foreach($tblpages as $page) {
		$ret[$i]['image'] = "images/icons/username.gif";
		$ret[$i]['link'] = $page->getURL(true);
		$ret[$i]['title'] = $page->getVar('up_title');
		$ret[$i]['time'] = $page->getVar('up_created');
		$ret[$i]['uid'] = $page->getVar('up_uid');
		$i++;
	}
	return $ret;
}
?>