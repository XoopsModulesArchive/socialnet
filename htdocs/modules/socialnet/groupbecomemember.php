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
include_once 'class/socialnet_friendpetition.php';
include_once 'class/socialnet_relgroupuser.php';
include_once 'class/socialnet_groups.php';

// *******************************************************************************
// **** Main
// *******************************************************************************

/**
* Factories of groups... testing for zend editor  
*/
$relgroupuser_factory = new Xoopssocialnet_relgroupuserHandler($xoopsDB);
$groups_factory = new Xoopssocialnet_groupsHandler($xoopsDB);

$group_id = intval($_POST['group_id']);
$uid = intval($xoopsUser->getVar('uid'));

$criteria_uid = new Criteria('rel_user_uid',$uid);
$criteria_group_id = new Criteria('rel_group_id',$group_id);
$criteria = new CriteriaCompo($criteria_uid);
$criteria->add($criteria_group_id);
if($relgroupuser_factory->getCount($criteria)<1)
{
	$relgroupuser = $relgroupuser_factory->create();
	$relgroupuser->setVar('rel_group_id',$group_id);
	$relgroupuser->setVar('rel_user_uid',$uid);
	if($relgroupuser_factory->insert($relgroupuser)) {redirect_header('groups.php',1,_MD_SOCIALNET_YOUAREMEMBERNOW);}
	else {redirect_header('groups.php',1,_MD_SOCIALNET_ANERROR);}
}
else {redirect_header('groups.php',1,_MD_SOCIALNET_YOUAREMEMBERALREADY);}

include '../../footer.php';
?>