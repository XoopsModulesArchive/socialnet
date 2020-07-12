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
include_once 'class/socialnet_friendship.php';

// *******************************************************************************
// **** Main
// *******************************************************************************

/**
* Factory of petitions created  
*/
$friendpetition_factory = new Xoopssocialnet_friendpetitionHandler($xoopsDB);
$friendship_factory = new Xoopssocialnet_friendshipHandler($xoopsDB);

/**
* Getting the uid of the user which user want to ask to be friend
*/
$friend1_uid = intval($_POST['friend_uid']);
$friend2_uid = intval($xoopsUser->getVar('uid'));

$criteria_friend1 = new Criteria('friend1_uid',$friend1_uid);
$criteria_friend2 = new Criteria('friend2_uid',$friend2_uid);
	
$criteria_delete1 = new CriteriaCompo($criteria_friend1);
$criteria_delete1->add($criteria_friend2);

$friendship_factory->deleteAll($criteria_delete1);

$criteria_friend1 = new Criteria('friend1_uid',$friend2_uid);
$criteria_friend2 = new Criteria('friend2_uid',$friend1_uid);

$criteria_delete1 = new CriteriaCompo($criteria_friend1);
$criteria_delete1->add($criteria_friend2);

$friendship_factory->deleteAll($criteria_delete1);

redirect_header('friends.php',3,_MD_SOCIALNET_FRIENDSHIPTERMINATED);	

include '../../footer.php';
?>