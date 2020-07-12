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

/**
* Factories of groups  
*/
$relgroupuser_factory = new Xoopssocialnet_relgroupuserHandler($xoopsDB);
$groups_factory = new Xoopssocialnet_groupsHandler($xoopsDB);

$group_id = intval($_POST['group_id']);

if(!isset($_POST['confirm']) || $_POST['confirm']!=1)
{
	xoops_confirm(array('group_id'=> $group_id,'confirm'=>1), 'delete_group.php', _MD_SOCIALNET_ASKCONFIRMGROUPDELETION, _MD_SOCIALNET_CONFIRMGROUPDELETION);
}
else
{
	/**
	* Creating the factory  and the criteria to delete the picture
	* The user must be the owner
	*/
	$criteria_group_id = new Criteria ('group_id',$group_id);
	$uid = intval($xoopsUser->getVar('uid'));
	$criteria_uid = new Criteria ('owner_uid',$uid);
	$criteria = new CriteriaCompo ($criteria_group_id);
	$criteria->add($criteria_uid);
	
	/**
	* Try to delete  
	*/
	if($groups_factory->getCount($criteria)==1)
	{
		if($groups_factory->deleteAll($criteria))
		{
			$criteria_rel_group_id = new Criteria('rel_group_id',$group_id);
			$relgroupuser_factory->deleteAll($criteria_rel_group_id);
			redirect_header('groups.php?uid='.$uid, 3, _MD_SOCIALNET_GROUPDELETED);
		}
		else {redirect_header('groups.php?uid='.$uid, 3, _MD_SOCIALNET_ANERROR);}
	}
}

include '../../footer.php';
?>
