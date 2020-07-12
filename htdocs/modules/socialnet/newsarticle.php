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

include_once("../../mainfile.php");
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/class/class.newsstory.php";
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/class/class.sfiles.php";

// *******************************************************************************
// **** Main
// *******************************************************************************

/*foreach ($_POST as $k => $v) {
    ${$k} = $v;
}
*/
$storyid = (isset($_GET['storyid'])) ? $_GET['storyid'] : 0;
$storyid = intval($storyid);
if (empty($storyid)) {
    redirect_header("news.php",2,_MD_SOCIAL_NW_NOSTORY);
    exit();
}

$myts =& MyTextSanitizer::getInstance();
// set comment mode if not set


$article = new SocialnetStory($storyid);
if ( $article->published() == 0 || $article->published() > time() ) {
    //redirect_header('news.php', 2, _MD_SOCIAL_NW_NOSTORY);
    include_once XOOPS_ROOT_PATH.'/header.php';
    include XOOPS_ROOT_PATH.'/footer.php';
    exit();
}
$admin = false;
$gperm_handler =& xoops_gethandler('groupperm');
if (is_object($xoopsUser)) {
    $groups = $xoopsUser->getGroups();
} else {
	$groups = XOOPS_GROUP_ANONYMOUS;
}
if (!$gperm_handler->checkRight("socialnet_approve", $article->topicid(), $groups, $xoopsModule->getVar('mid'))) {
    if (!$gperm_handler->checkRight("socialnet_view", $article->topicid(), $groups, $xoopsModule->getVar('mid'))) {
        if (!$gperm_handler->checkRight("socialnet_submit", $article->topicid(), $groups, $xoopsModule->getVar('mid'))) {
            redirect_header('news.php', 3, _NOPERM);
            exit();
        }
    }
    if (!$gperm_handler->checkRight("socialnet_newsaudience", $article->audienceid, $groups, $xoopsModule->getVar('mid'))) {
        redirect_header('news.php', 3, sprintf(_MD_SOCIAL_NW_NOTALLOWEDAUDIENCE, $article->audience));
        exit();
    }
}
else {
    $admin = true;
}

$storypage = isset($_GET['page']) ? intval($_GET['page']) : 0;
// update counter only when viewing top page
if (empty($_GET['com_id']) && $storypage == 0) {
    $article->updateCounter();
}
if ($admin) {
    $xoopsConfig['module_cache'][$xoopsModule->getVar('mid')] = 0;
}
$xoopsOption['template_main'] = 'socialnet_article.html';
include_once XOOPS_ROOT_PATH.'/header.php';

$xoopsTpl->assign('story', $article->toArray($admin, true, $storypage));
$artbanner = $article->getBanner();
if ($artbanner == "") {
    $artbanner = " ";
}
$xoopsTpl->assign('articlebanner', $myts->displayTarea($artbanner, 1));
$showcomments = (XOOPS_COMMENT_APPROVENONE != $xoopsModuleConfig['com_rule']) ? 1 : 0;
$allow_rating = $xoopsUser || $xoopsModuleConfig['anonymous_vote'] ? 1 :0;
$xoopsTpl->assign('showcomments', $showcomments);
$xoopsTpl->assign('allow_rating', $allow_rating);
$xoopsTpl->assign('lang_printerpage', _MD_SOCIAL_NW_PRINTERFRIENDLY);
$xoopsTpl->assign('lang_sendstory', _MD_SOCIAL_NW_SENDSTORY);
$xoopsTpl->assign('lang_on', _MD_SOCIAL_NW_PUBLISHED_DATE);
$xoopsTpl->assign('lang_postedby', _MD_SOCIAL_NW_POSTEDBY);
$xoopsTpl->assign('lang_reads', _MD_SOCIAL_NW_READS);
$xoopsTpl->assign('mail_link', 'mailto:?subject='.sprintf(_MD_SOCIAL_NW_INTARTICLE,$xoopsConfig['sitename']).'&amp;body='.sprintf(_MD_SOCIAL_NW_INTARTFOUND, $xoopsConfig['sitename']).':  '.XOOPS_URL.'/modules/socialnet/newsarticle.php?storyid='.$article->storyid());
$xoopsTpl->assign('related', $article->getLinks());
$xoopsTpl->assign('page', $storypage);
$xoopsTpl->assign('admin', $admin);
$xoopsTpl->assign('hasversions', $article->hasVersions());

$xoopsTpl->assign('lang_attached_files',_MD_SOCIAL_NW_ATTACHEDFILES);
$sfiles = new sFiles();
$filesarr=Array();
$newsfiles=Array();
$filesarr=$sfiles->getAllbyStory($storyid);
$filescount=count($filesarr);
$xoopsTpl->assign('attached_files_count',$filescount);
if($filescount>0)
{
	foreach ($filesarr as $onefile) 
	{
		$newsfiles[]=Array('file_id'=>$onefile->getFileid(), 'visitlink' => XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/newsvisit.php?fileid='.$onefile->getFileid(),'file_realname'=>$onefile->getFileRealName(), 'file_attacheddate'=>formatTimestamp($onefile->getDate()), 'file_mimetype'=>$onefile->getMimetype(), 'file_downloadname'=>XOOPS_UPLOAD_URL.'/socialnet/news'.$onefile->getDownloadname());
	}
	$xoopsTpl->assign('attached_files',$newsfiles);
}
$xoopsTpl->assign('xoops_pagetitle', $myts->htmlSpecialChars($xoopsModule->name()) . ' - ' . $myts->htmlSpecialChars($article->topic_title()) . ' - ' . $myts->htmlSpecialChars($article->title()));

$xoopsTpl->assign('breadcrumb', $article->getPath());

include XOOPS_ROOT_PATH.'/include/comment_view.php';

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