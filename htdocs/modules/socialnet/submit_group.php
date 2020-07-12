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



/**
 * Xoops header ...
 */
include_once("../../mainfile.php");
include_once("../../header.php");

/**
 * Modules class includes  
 */
include_once("class/socialnet_friendpetition.php");
include_once("class/socialnet_relgroupuser.php");
include_once("class/socialnet_groups.php");


/**
 * Factories of groups  
 */
$relgroupuser_factory      = new Xoopssocialnet_relgroupuserHandler($xoopsDB);
$groups_factory = new Xoopssocialnet_groupsHandler($xoopsDB);


$marker = (isset($_POST['marker']))?$_POST['marker']:0;

if ($marker==1) {
  /**
   * Verify Token
   */
  if (!($GLOBALS['xoopsSecurity']->check())){
	redirect_header($_SERVER['HTTP_REFERER'], 3, _MD_SOCIALNET_TOKENEXPIRED);
  }
  /**
   * 
   */
  $myts =& MyTextSanitizer::getInstance();
  $group_title = $myts->displayTarea($_POST['group_title'],0,1,1,1,1);
  $group_desc  = $myts->displayTarea($_POST['group_desc'],0,1,1,1,1);
  $group_img   = (!empty($_POST['group_img'])) ? $_POST['group_img'] : "";
  $path_upload    = XOOPS_ROOT_PATH."/uploads/socialnet/groups";
  $pictwidth      = $xoopsModuleConfig['resized_width'];
  $pictheight     = $xoopsModuleConfig['resized_height'];
  $thumbwidth     = $xoopsModuleConfig['thumb_width'];
  $thumbheight    = $xoopsModuleConfig['thumb_height'];
  $maxfilebytes   = $xoopsModuleConfig['maxfilesize'];
  $maxfileheight  = $xoopsModuleConfig['max_original_height'];
  $maxfilewidth   = $xoopsModuleConfig['max_original_width'];
  if ($groups_factory->receiveGroup($group_title,$group_desc,'',$path_upload,$maxfilebytes,$maxfilewidth,$maxfileheight))
  {
    $relgroupuser = $relgroupuser_factory->create();
    $relgroupuser->setVar('rel_group_id',$xoopsDB->getInsertId());
    $relgroupuser->setVar('rel_user_uid',$xoopsUser->getVar('uid'));
    $relgroupuser_factory->insert($relgroupuser);
    redirect_header("groups.php",500,_MD_SOCIALNET_GROUP_CREATED);
  }else{
    $groups_factory->renderFormSubmit(120000,$xoopsTpl);
  }
}else{
  $groups_factory->renderFormSubmit(120000,$xoopsTpl);
}

       

/**
 * Close page  
 */
include("../../footer.php");
?>