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
include_once 'class/socialnet_relgroupuser.php';
include_once 'class/socialnet_groups.php';

// *******************************************************************************
// **** Main
// *******************************************************************************

$group_id = intval($_POST['group_id']);
$rel_user_uid = intval($_POST['rel_user_uid']);

if($_POST['confirm']!=1)
{
	xoops_confirm(array('rel_user_uid' => $rel_user_uid, 'group_id' => $group_id ,'confirm' => 1 ) , 'kickfromgroup.php', _MD_SOCIALNET_ASKCONFIRMKICKFROMGROUP, _MD_SOCIALNET_CONFIRMKICK);
}
else
{
	/**
	* Creating the factory  and the criteria to delete the picture
	* The user must be the owner
	*/
	$relgroupuser_factory = new Xoopssocialnet_relgroupuserHandler($xoopsDB);
	$groups_factory = new Xoopssocialnet_groupsHandler($xoopsDB);
	$group = $groups_factory->get($group_id);
	//	echo "<pre>";
	//	print_r($group);
	if($xoopsUser->getVar('uid')==$group->getVar('owner_uid'))
	{
		$criteria_rel_user_uid = new Criteria('rel_user_uid',$rel_user_uid);
		$criteria_group_id 	   = new Criteria('rel_group_id',$group_id);
		$criteria = new CriteriaCompo($criteria_rel_user_uid);
		$criteria->add($criteria_group_id);
		/**
		* Try to delete  
		*/
		if($relgroupuser_factory->deleteAll($criteria)){redirect_header('groups.php', 2, _MD_SOCIALNET_GROUPKICKED);}
		else {redirect_header('groups.php', 2, _MD_SOCIALNET_ANERROR);}
	}
	else {redirect_header('groups.php', 2, _MD_SOCIALNET_ANERROR);}
}

include '../../footer.php';
?>
