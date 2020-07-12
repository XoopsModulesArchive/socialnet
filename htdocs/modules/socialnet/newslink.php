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

$xoopsOption['pagetype'] = "search";
include "../../mainfile.php";

// *******************************************************************************
// **** Main
// *******************************************************************************

if (!$xoopsUser) {
    redirect_header('news.php', 3, _NOPERM);
}
include_once XOOPS_ROOT_PATH.'/modules/socialnet/class/class.newsstory.php';
$storyid = (isset($_POST['storyid'])) ? intval($_POST['storyid']) : (isset($_GET['storyid']) ? intval($_GET['storyid']) : 0);
if (!$storyid) {
    redirect_header("news.php",2,_MD_SOCIAL_NW_NOSTORY);
    exit();
}
$article = new SocialnetStory($storyid);
if ($xoopsUser->getVar('uid') != $article->uid()) {
    $gperm_handler =& xoops_gethandler('groupperm');
    $groups = $xoopsUser->getGroups();
    if (!$gperm_handler->checkRight("socialnet_approve", $article->topicid(), $groups, $xoopsModule->getVar('mid'))) {
        redirect_header('news.php', 3, _NOPERM);
        exit();
    }
}

$op = (isset($_POST['op'])) ? $_POST['op'] : "default";
$myts =& MyTextSanitizer::getInstance();

$xoopsConfigSearch =& $config_handler->getConfigsByCat(XOOPS_CONF_SEARCH);
$xoopsConfig['module_cache'][$xoopsModule->getVar('mid')] = 0; // disable caching
$xoopsOption['template_main'] = 'socialnet_newssearchform.html';
include_once XOOPS_ROOT_PATH.'/header.php';

$username = (isset($_POST['username']) && $_POST['username'] != "") ? $_POST['username'] : '';
$username = $myts->addSlashes($username);
$queries = array();
$andor = isset($_POST['andor']) ? $_POST['andor'] : "AND";

switch($op) {
    case 'default':
    default:
    break;
    
    case 'results':
    $results = array();
    if ( $andor != "exact" ) {
        $ignored_queries = array(); // holds kewords that are shorter than allowed minmum length
        $temp_queries = preg_split('/[\s,]+/', $_POST['query']);
        foreach ($temp_queries as $q) {
            $q = trim($q);
            if (strlen($q) >= $xoopsConfigSearch['keyword_min']) {
                $queries[] = $myts->addSlashes($q);
            } else {
                $ignored_queries[] = $myts->addSlashes($q);
            }
        }
    }
    else {
        $query = trim($_POST['query']);
        if (strlen($query) < $xoopsConfigSearch['keyword_min']) {
            //query string too short
        }
        $queries = array($myts->addSlashes($query));
    }
    $module_handler =& xoops_gethandler('module');
    if ($username != "") {
        $member_handler =& xoops_gethandler('member');
        $criteria = new Criteria('uname', '%'.$username.'%', 'LIKE');
        $users = $member_handler->getUserList($criteria);
    }
    else {
        $users = 0;
    }
    foreach ($_POST['mids'] as $mid) {
        $thismodule =& $module_handler->get($mid);
        if ($users == 0) {
            $thisresult = $thismodule->search($queries, $andor, 10, 0, 0, $article->storyid());
            if (count($thisresult) > 0) {
                foreach ($thisresult as $key => $searchresult) {
                    if ($mid == $xoopsModule->getVar('mid')) {
                        if (isset($searchresult['id']) && ($searchresult['id'] == $storyid)) {
                            unset($thisresult[$key]);
                            continue;
                        }
                    }
                    $thisresult[$key]['title'] = $myts->htmlSpecialChars($searchresult['title']);
                }
                $results[$mid]['results'][0] = $thisresult;
            }
        }
        else {
            foreach ($users as $userid => $username) {
                $thisresult = $thismodule->search($queries, $andor, 10, 0, $userid, $article->storyid());
                if (count($thisresult) > 0) {
                    foreach ($thisresult as $key => $searchresult) {
                        if ($mid == $xoopsModule->getVar('mid')) {                        
                            if (isset($searchresult['id']) && ($searchresult['id'] == $storyid)) {
                                unset($thisresult[$key]);
                                continue;
                            }
                        }
                        $thisresult[$key]['title'] = $myts->htmlSpecialChars($searchresult['title']);
                    }
                    $results[$mid]['results'][$userid] = $thisresult;
                }
            }
        }
        if (isset($results[$mid]) && !isset($results[$mid]['modulename'])) {
            $results[$mid]['modulename'] = $thismodule->name();
            $results[$mid]['dirname'] = $thismodule->dirname();
            $results[$mid]['moduleid'] = $thismodule->mid();
        }
    }
    if (count($results) > 0) {
        $xoopsTpl->assign('results', $results);
    }
    else {
        $xoopsTpl->assign('message', _SR_NOMATCH);
    }
    break;
    
    case 'addexternallink':
        if ((isset($_POST['url']) && $_POST['url'] != "") && (isset($_POST['title']) && $_POST['title'] != "")) {
            if (!$article->addLink(-1, $_POST['url'], $myts->addSlashes($_POST['title']), $_POST['position'])) {
                $xoopsTpl->assign('message', $article->renderErrors());
            }
        }
    break;
    
    case 'addlink':
    if (isset($_POST['linkids'])) {
        $linkids = $_POST['linkids'];
        $modules = $_POST['modules'];
        $links = $_POST['links'];
        $titles = $_POST['titles'];
    }
    else {
        $linkids = array();
        $xoopsTpl->assign('message', 'No Link Selected');
    }
    if (count($linkids) > 0) {
        $errors = 0;
        foreach ($linkids as $key => $link) {
            if (!$article->addLink($modules[$key], $links[$key], $titles[$key], $_POST['position'])) {
                $errors = 1;
            }
        }
        if ($errors == 1) {
            $xoopsTpl->assign('message', $article->renderErrors());
        }
    }
    break;
    
    case 'dellink':
    if (isset($_POST['linkids'])) {
        $errors = 0;
        foreach ($_POST['linkids'] as $linkid) {
            if (!$article->deleteLink($linkid)) {
                $errors = 1;
            }
        }
        if ($errors == 1) {
            $xoopsTpl->assign('message', $article->renderErrors());
        }
    }
    else {
        $xoopsTpl->assign('message', "No link selected");
    }
    break;
}
$existing_links = $article->getLinks();
include 'include/searchform.php';
$search_form->assign($xoopsTpl);
if (count($existing_links)>0) {
    $xoopsTpl->assign('related', $existing_links);
}
$xoopsTpl->assign('breadcrumb', $article->getPath(true)." > "._MD_SOCIAL_NW_MANAGELINK);
$xoopsTpl->assign('story', $article->toArray());
$xoopsTpl->assign('lang_on', _ON);
$xoopsTpl->assign('lang_postedby', _POSTEDBY);
$xoopsTpl->assign('lang_reads', _READS);
$xoopsTpl->assign('xoops_pagetitle', $myts->htmlSpecialChars($xoopsModule->name()) . ' - ' . $myts->htmlSpecialChars($article->title()));

/**
* Adding to the module js and css of the lightbox and new ones
*/
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/socialnet.css');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/jquery.tabs.css');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/leftmenu.css');
// what browser they use if IE then add corrective script.
if(ereg('msie', strtolower($_SERVER['HTTP_USER_AGENT']))) {$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/jquery.tabs-ie.css');}

$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/jquery.lightbox-0.5.css');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jquery.js');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jquery.lightbox-0.5.js');
//$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/socialnet.js');

// SocialNetFaceStyle starts here
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/barfacestyle.css');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/barface.stylesheet.css');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/barface.readyfunction.js');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jquery-1.3.2.min.js');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jixedbar-0.0.3-dev.js');
// SocialNetFaceStyle End here

//navbar
$xoopsTpl->assign('module_name',$xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection',_MD_SOCIAL_ARTICLES);
$xoopsTpl->assign('section_name',_MD_SOCIAL_ARTICLES);
$xoopsTpl->assign('lang_home',_MD_SOCIALNET_HOME);
$xoopsTpl->assign('lang_photos',_MD_SOCIALNET_PHOTOS);
$xoopsTpl->assign('lang_friends',_MD_SOCIALNET_FRIENDS);
$xoopsTpl->assign('lang_audio',_MD_SOCIALNET_AUDIOS);
$xoopsTpl->assign('lang_videos',_MD_SOCIALNET_VIDEOS);
$xoopsTpl->assign('lang_scrapbook',_MD_SOCIALNET_SCRAPBOOK);
$xoopsTpl->assign('lang_profile',_MD_SOCIALNET_PROFILE);
$xoopsTpl->assign('lang_groups',_MD_SOCIALNET_GROUPS);
$xoopsTpl->assign('lang_configs',_MD_SOCIALNET_CONFIGSTITLE);
$xoopsTpl->assign('lang_search', _MD_SOCIALNET_SEARCH);
$xoopsTpl->assign('lang_membership', _MD_SOCIALNET_MEMBERSHIP);
$xoopsTpl->assign('lang_pagelist', _MD_SOCIALNET_PAGELIST);
$xoopsTpl->assign('lang_publish', _MD_SOCIALNET_PUBLISH);
$xoopsTpl->assign('lang_your_page', _MD_SOCIALNET_YOUR_PAGE);
$xoopsTpl->assign('lang_contactus', _MD_SOCIALNET_CONTACTUS);
$xoopsTpl->assign('lang_articles', _MD_SOCIAL_ARTICLES);
$xoopsTpl->assign('lang_popchatmenu', _MD_SOCIALNET_POPCHATMENU);
$xoopsTpl->assign('lang_forum', _MD_SOCIALNET_FORUM_FORUM);

include XOOPS_ROOT_PATH.'/footer.php';
?>