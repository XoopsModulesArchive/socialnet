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
include_once 'class/socialnet_controler.php';
include_once XOOPS_ROOT_PATH . '/header.php';
include_once XOOPS_ROOT_PATH.'/modules/socialnet/class/class.newsstory.php';

// *******************************************************************************
// **** Main
// *******************************************************************************

if (isset($_GET['storytopic'])) {
    $xoopsOption['storytopic'] = intval($_GET['storytopic']);
} else {
    $xoopsOption['storytopic'] = 0;
}
if ( isset($_GET['storynum']) ) {
    $xoopsOption['storynum'] = intval($_GET['storynum']);
    if ($xoopsOption['storynum'] > $xoopsModuleConfig['max_items']) {
        $xoopsOption['storynum'] = $xoopsModuleConfig['max_items'];
    }
} elseif ($xoopsOption['storytopic'] > 0) {
    $xoopsOption['storynum'] = $xoopsModuleConfig['storyhome_topic'];
}
else {
    $xoopsOption['storynum'] = $xoopsModuleConfig['storyhome'];
}

if ( isset($_GET['start']) ) {
    $start = intval($_GET['start']);
} else {
    $start = 0;
}
if (empty($xoopsModuleConfig['newsdisplay']) || $xoopsModuleConfig['newsdisplay'] == 'Classic' || $xoopsOption['storytopic'] > 0) {
    $showclassic = 1;
}
else {
    $showclassic = 0;
}

$myts =& MyTextSanitizer::getInstance();
$pagetitle = $myts->htmlSpecialChars($xoopsModule->name());
$column_count = $xoopsModuleConfig['columnmode'];
if ($showclassic) {
    $xoopsOption['template_main'] = 'socialnet_news.html';
}
else {
     $xoopsOption['template_main'] = 'socialnet_by_topic.html';
}
include XOOPS_ROOT_PATH.'/header.php';
$xoopsTpl->assign('columnwidth', intval(1/$column_count*100));
if ($xoopsModuleConfig['displaynav'] == 1 ) {
    $xoopsTpl->assign('displaynav', true);
    $xt = new SocialnetTopic($xoopsDB->prefix('socialnet_topics'));
    $allTopics = $xt->getAllTopics(true);
    include_once(XOOPS_ROOT_PATH."/class/tree.php");
    include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
    $topic_tree = new XoopsObjectTree($allTopics, 'topic_id', 'topic_pid');
    $topic_select_code = $topic_tree->makeSelBox('storytopic', 'topic_title', '-', $xoopsOption['storytopic'], true);
    $topic_form = new XoopsThemeForm('', "topic_form", "news.php", "get");
    $topic_form->addElement(new XoopsFormLabel('', $topic_select_code));
    // Make number options
    $i = 1;
    while ($i <= $xoopsModuleConfig['max_items']) {
        $options[$i] = $i;
        if ($i == 1) {
            $i = 5;
        }
        else {
            $i = $i + 5;
        }
    }
    $storynum_select = new XoopsFormSelect('', 'storynum', $xoopsOption['storynum']);
    $storynum_select->addOptionArray($options);

    $submit_btn = new XoopsFormButton('', 'submit', _GO, 'submit');

    $topic_form->addElement($storynum_select);
    $topic_form->addElement($submit_btn);
    $topic_form->assign($xoopsTpl);
}
else {
    $xoopsTpl->assign('displaynav', false);
}
if ($showclassic) {
    $ihome = $xoopsOption['storytopic'] > 0 ? 1 : 0;

    $sarray = SocialnetStory::getAllPublished($xoopsOption['storynum'], $start, $xoopsModuleConfig['restrictindex'], $xoopsOption['storytopic'], $ihome);

    $scount = count($sarray);
    $xoopsTpl->assign('story_count', $scount);
    if ($scount > 0) {
        $uids = array();
        foreach ($sarray as $storyid => $thisstory) {
            $uids[$thisstory->uid()] = $thisstory->uid();
        }
        $member_handler =& xoops_gethandler('member');
        $user_arr = $member_handler->getUsers(new Criteria('uid', "(".implode(',', array_keys($uids)).")", 'IN') , true);
        foreach ($sarray as $storyid => $thisstory) {
            $stories[] = $thisstory->toArray(false, false, 0, $user_arr);
        }
        $xoopsTpl->assign('stories', $stories);
    }
    else {
        $xoopsTpl->assign('stories', array());
    }
    $xoopsTpl->assign('columns', $column_count);

    $totalcount = SocialnetStory::countPublishedByTopic($xoopsOption['storytopic'], $xoopsModuleConfig['restrictindex']);
    if ( $totalcount > $scount ) {
        include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
        $pagenav = new XoopsPageNav($totalcount, $xoopsOption['storynum'], $start, 'start', 'storytopic='.$xoopsOption['storytopic']);
        $xoopsTpl->assign('pagenav', $pagenav->renderNav());
    }
    else {
        $xoopsTpl->assign('pagenav', '');
    }

    if($xoopsOption['storytopic'] > 0)
    {
        if (!isset($xt)) {
            $xt = new SocialnetTopic($xoopsDB->prefix('socialnet_topics'));
        }
        $xt->getTopic($xoopsOption['storytopic']);
        $pagetitle .= ' - ' . $xt->topic_title();
        $xoopsTpl->assign('breadcrumb', $xt->getTopicPath());
    }
    else {
        $xoopsTpl->assign('breadcrumb', '');
    }
}
else {
    include_once(XOOPS_ROOT_PATH."/class/tree.php");
    $xt = new SocialnetTopic($xoopsDB -> prefix("socialnet_topics"));
    $allTopics = $xt->getAllTopics($xoopsModuleConfig['restrictindex']);
    $topic_obj_tree = new XoopsObjectTree($allTopics, 'topic_id', 'topic_pid');
    $alltopics = $topic_obj_tree->getFirstChild(0);
    
    $article_counts = SocialnetStory::countPublishedOrderedByTopic();
    
    $smarty_topics = array();
    foreach (array_keys($alltopics) as $i) {
        $allstories[$i] = SocialnetStory::getAllPublished($xoopsOption['storynum'], 0, false, $i, 0);
        if (count($allstories[$i]) > 0) {
            foreach ($allstories[$i] as $thisstory) {
                $uids[$thisstory->uid()] = $thisstory->uid();
            }
        }
        if (!isset($article_counts[$i])) {
            $article_counts[$i] = 0;
        }
    }
    if (count($uids) > 0) {
        $member_handler =& xoops_gethandler('member');
        $user_arr = $member_handler->getUsers(new Criteria('uid', "(".implode(',', array_keys($uids)).")", 'IN') , true);
        foreach ($alltopics as $topicid => $topic) {
            $topicstories = array();
            foreach ($allstories[$topicid] as $thisstory) {
                $topicstories[] = $thisstory->toArray(false, false, 0, $user_arr);
            }
            $subcount = 0;
            $subs = array();
            //$key = findKey($smarty_topics, $topicstories[0]['posttimestamp']);
            $subtopics = $topic_obj_tree->getFirstChild($topicid);
            $subcount = count($subtopics);
            foreach (array_keys($subtopics) as $i) {
                $subs[$i] = array('id' => $i, 'title' => $subtopics[$i]->topic_title(), 'imageurl' => $subtopics[$i]->topic_imgurl());
            }
            $smarty_topics[] = array('title' => $topic->topic_title(), 'stories' => $topicstories, 'id' => $topicid, 'subtopics' => $subs, 'articlecount' => $article_counts[$topicid], 'subtopiccount' => $subcount);
            unset($subs);
        }
    }
    //krsort($smarty_topics);
    $xoopsTpl->assign('topics', $smarty_topics);
    $xoopsTpl->assign('columns', $column_count);
    $xoopsTpl->assign('breadcrumb', '');
}
if (XOOPS_COMMENT_APPROVENONE != $xoopsModuleConfig['com_rule']) {
    $showcomments = 1;
}
else {
    $showcomments = 0;
}
$xoopsTpl->assign('showcomments', $showcomments);
$xoopsTpl->assign('xoops_pagetitle', $pagetitle);
$xoopsTpl->assign('lang_go', _GO);
$xoopsTpl->assign('lang_on', _ON);
$xoopsTpl->assign('lang_printerpage', _MD_SOCIAL_NW_PRINTERFRIENDLY);
$xoopsTpl->assign('lang_sendstory', _MD_SOCIAL_NW_SENDSTORY);
$xoopsTpl->assign('lang_postedby', _POSTEDBY);
$xoopsTpl->assign('lang_reads', _READS);
$xoopsTpl->assign('lang_morereleases', _MD_SOCIAL_NW_MORERELEASES);
if ($xoopsOption['storytopic'] > 0) {
    $topic = new SocialnetTopic($xoopsDB->prefix('socialnet_topics'), $xoopsOption['storytopic']);
    $xoopsTpl->assign('topicbanner', $myts->displayTarea($topic->getBanner(), 1));
}

function findKey($array, $suggested_key) {
    if (isset($array[$suggested_key])) {
        return findKey($array, $suggested_key +1 );
    }
    return $suggested_key;
}

/**
 * Adding to the module js and css of the lightbox and new ones
 */
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/socialnet.css');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/jquery.tabs.css');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/leftmenu.css');
// what browser they use if IE then add corrective script.
if(ereg("msie", strtolower($_SERVER['HTTP_USER_AGENT']))) {
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/jquery.tabs-ie.css');
}

$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/jquery.lightbox-0.5.css');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jquery.js');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jquery.lightbox-0.5.js');
//$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/socialnet.js');

// SocialNetFaceStyle starts here
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/barfacestyle.css');
//$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/foot_panelstyle.css');
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

include("../../footer.php");

?>
