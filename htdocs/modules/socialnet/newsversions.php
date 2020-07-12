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

include("../../mainfile.php");
include_once XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->getVar('dirname').'/class/class.newsstory.php';

// *******************************************************************************
// **** Main
// *******************************************************************************

if (!isset($_POST['submit'])) {
    if (!isset($_GET['storyid'])) {
        redirect_header('index.php', 3, _MD_SOCIAL_NW_NOSTORY);
        exit();
    }
    $xoopsConfig['module_cache'][$xoopsModule->getVar('mid')] = 0; // disable caching
    $xoopsOption['template_main'] = "socialnet_newsversion.html";
    include_once XOOPS_ROOT_PATH."/header.php";
    $story = new SocialnetStory(intval($_GET['storyid']));
    $gperm_handler =& xoops_gethandler('groupperm');
    if (!$xoopsUser || !$gperm_handler->checkRight("socialnet_approve", $story->topicid(), $xoopsUser->getGroups(), $xoopsModule->mid())) {
        redirect_header('newsarticle.php?storyid='.$story->storyid, 3, _NOPERM);
        exit();
    }
    $xoopsTpl->assign('breadcrumb', $story->getPath(true)." > "._MD_SOCIAL_NW_VERSION);
    $xoopsTpl->assign('lang_go', _GO);
    $xoopsTpl->assign('lang_on', _ON);
    $xoopsTpl->assign('lang_printerpage', _MD_SOCIAL_NW_PRINTERFRIENDLY);
    $xoopsTpl->assign('lang_sendstory', _MD_SOCIAL_NW_SENDSTORY);
    $xoopsTpl->assign('lang_postedby', _POSTEDBY);
    $xoopsTpl->assign('lang_reads', _READS);
    $xoopsTpl->assign('lang_morereleases', _MD_SOCIAL_NW_MORERELEASES);
    $xoopsTpl->assign('versions', $story->getVersions());
    $xoopsTpl->assign('story', $story->toArray(true, false, 0));
}
else {
    switch($_POST['op']) {
        case "setversion":
            $story = new SocialnetStory(intval($_POST['storyid']));
            $gperm_handler =& xoops_gethandler('groupperm');
            if (!$xoopsUser || !$gperm_handler->checkRight("socialnet_approve", $story->topicid(), $xoopsUser->getGroups(), $xoopsModule->mid())) {
                redirect_header('newsarticle.php?storyid='.$story->storyid, 3, _NOPERM);
                exit();
            }
            $version_array = explode(".", $_POST['version']);
            if (!isset($version_array[2])) {
                $version_array[2] = 0;
            }
            if ($story->setCurrentVersion($version_array[0], $version_array[1], $version_array[2])) {
                $message = sprintf(_MD_SOCIAL_NW_VERSIONUPDATED, implode('.', $version_array));
                redirect_header('newsarticle.php?storyid='.$story->storyid, 3, $message);
            }
            else {
                redirect_header('index.php', 3, $story->renderErrors());
            }
            break;
            
        case "delversions":
            $story = new SocialnetStory(intval($_POST['storyid']));
            $gperm_handler =& xoops_gethandler('groupperm');
            if (!$xoopsUser || !$gperm_handler->checkRight("socialnet_approve", $story->topicid(), $xoopsUser->getGroups(), $xoopsModule->mid())) {
                redirect_header('newsarticle.php?storyid='.$story->storyid, 3, _NOPERM);
                exit();
            }
            if (!empty($_POST['ok'])) {
                include_once XOOPS_ROOT_PATH."/header.php";
                $story->delversions($_POST['version'], $_POST['revision'], $_POST['revisionminor']);
                redirect_header('newsarticle.php?storyid='.$story->storyid, 3, sprintf(_MD_SOCIAL_NW_VERSIONUPDATED, $_POST['version'].".".$_POST['revision'].".".$_POST['revisionminor']));
            }
            else {
                $version_array = explode(".", $_POST['version']);
                if (!isset($version_array[2])) {
                    $version_array[2] = 0;
                }
                include_once XOOPS_ROOT_PATH."/header.php";
                xoops_confirm(array('op' => 'delversions', 'submit' => 1, 'ok' => 1, 'storyid' => $_POST['storyid'], 'version' => $version_array[0], 'revision' => $version_array[1], 'revisionminor' => $version_array[2]) , 'versions.php', _MD_SOCIAL_NW_RUSUREDELVERSIONS);
            }            
            break;
            
        case "delallversions":
            $story = new SocialnetStory(intval($_POST['storyid']));
            $gperm_handler =& xoops_gethandler('groupperm');
            if (!$xoopsUser || !$gperm_handler->checkRight("socialnet_approve", $story->topicid(), $xoopsUser->getGroups(), $xoopsModule->mid())) {
                redirect_header('newsarticle.php?storyid='.$story->storyid, 3, _NOPERM);
                exit();
            }
            if (!empty($_POST['ok'])) {
                include_once XOOPS_ROOT_PATH."/header.php";
                $story->delallversions($_POST['version'], $_POST['revision'], $_POST['revisionminor']);
                redirect_header('newsarticle.php?storyid='.$story->storyid, 3, sprintf(_MD_SOCIAL_NW_VERSIONUPDATED, $_POST['version'].".".$_POST['revision'].".".$_POST['revisionminor']));
            }
            else {
                $version_array = explode(".", $_POST['version']);
                if (!isset($version_array[2])) {
                    $version_array[2] = 0;
                }
                include_once XOOPS_ROOT_PATH."/header.php";
                xoops_confirm(array('op' => 'delallversions', 'submit' => 1, 'ok' => 1, 'storyid' => $_POST['storyid'], 'version' => $version_array[0], 'revision' => $version_array[1], 'revisionminor' => $version_array[2]) , 'versions.php', _MD_SOCIAL_NW_RUSUREDELALLVERSIONS);
            }            
            break;
    }
}
include '../../footer.php';
?>