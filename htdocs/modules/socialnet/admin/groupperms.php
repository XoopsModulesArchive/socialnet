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

include '../../../include/cp_header.php';
include_once XOOPS_ROOT_PATH . "/modules/socialnet/class/class.newstopic.php";
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once XOOPS_ROOT_PATH.'/class/xoopsform/grouppermform.php';
include_once "functions.php";

// *******************************************************************************
// **** Main
// *******************************************************************************

xoops_cp_header();
adminmenu(7);

$module_id = $xoopsModule->getVar('mid');

//Approver Form
$approveform = new XoopsGroupPermForm(_AM_SOCIALNET_APPROVEFORM, $module_id, "socialnet_approve", _AM_SOCIALNET_APPROVEFORM_DESC);

//Submitter Form
$submitform = new XoopsGroupPermForm(_AM_SOCIALNET_SUBMITFORM, $module_id, "socialnet_submit", _AM_SOCIALNET_SUBMITFORM_DESC);

//Viewer Form
$viewform = new XoopsGroupPermForm(_AM_SOCIALNET_VIEWFORM, $module_id, "socialnet_view", _AM_SOCIALNET_VIEWFORM_DESC);

$alltopics = SocialnetTopic::getAllTopics();

foreach ($alltopics as $topic_id => $topic) {
    $approveform->addItem($topic_id, $topic->topic_title(), $topic->topic_pid());
    $submitform->addItem($topic_id, $topic->topic_title(), $topic->topic_pid());
    $viewform->addItem($topic_id, $topic->topic_title(), $topic->topic_pid());
}

echo $approveform->render();
unset ($approveform);

echo $submitform->render();
unset ($submitform);

echo $viewform->render();
unset ($viewform);

echo "<div align='center' style='margin-top:10px'><a href='http://www.ipwgc.com/socialnet/'><img src='../images/socialnetLogo.png'></a><br /><img src='../images/menu/mailuser.gif'><a style='color: #029116; font-size:11px' href='feedback.php'>"._AM_SOCIALNET_FEEDBACK."</a> - <img src='../images/icons/mainvideo.gif'><a style='color: #FF0000; font-size:11px' href='http://www.ipwgc.com/socialnet/modules/socialnet/index.php' target='_blank'>"._AM_SOCIALNET_CHKVERSION."</a></div>";
xoops_cp_footer();
?>
