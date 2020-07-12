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

include_once '../../mainfile.php';
include_once '../../header.php';
include_once '../../class/criteria.php';
include_once 'class/socialnet_scraps.php';

// *******************************************************************************
// **** Main
// *******************************************************************************

/**
* Factories of groups  
*/
$scraps_factory = new Xoopssocialnet_scrapsHandler($xoopsDB);

$scrap_id = intval($_POST['scrap_id']);

if($_POST['confirm']!=1)
{
	xoops_confirm(array('scrap_id'=> $scrap_id,'confirm'=>1), 'delete_scrap.php', _MD_SOCIALNET_ASKCONFIRMSCRAPDELETION, _MD_SOCIALNET_CONFIRMSCRAPDELETION);
}
else
{
	/**
	* Creating the factory  and the criteria to delete the picture
	* The user must be the owner
	*/
	$criteria_scrap_id = new Criteria ('scrap_id',$scrap_id);
	$uid = intval($xoopsUser->getVar('uid'));
	$criteria_uid = new Criteria ('scrap_to',$uid);
	$criteria = new CriteriaCompo ($criteria_scrap_id);
	$criteria->add($criteria_uid);
	
	/**
	* Try to delete  
	*/
	if($scraps_factory->getCount($criteria)==1)
	{
		if($scraps_factory->deleteAll($criteria)) {redirect_header('scrapbook.php?uid='.$uid, 2, _MD_SOCIALNET_SCRAPDELETED);}
		else {redirect_header('scrapbook.php?uid='.$uid, 2, _MD_SOCIALNET_ANERROR);}
	}
}

include '../../footer.php';
?>

