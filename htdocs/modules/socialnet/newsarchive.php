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

include '../../mainfile.php';
$xoopsOption['template_main'] = 'socialnet_archive.html';
include XOOPS_ROOT_PATH.'/header.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->getVar('dirname').'/class/class.newsstory.php';
include_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/calendar.php';
// *******************************************************************************
// **** Main
// *******************************************************************************

//error_reporting(E_ALL);
$lastyear = 0;
$lastmonth = 0;

$months_arr = array(1 => _CAL_JANUARY, 2 => _CAL_FEBRUARY, 3 => _CAL_MARCH, 4 => _CAL_APRIL, 5 => _CAL_MAY, 6 => _CAL_JUNE, 7 => _CAL_JULY, 8 => _CAL_AUGUST, 9 => _CAL_SEPTEMBER, 10 => _CAL_OCTOBER, 11 => _CAL_NOVEMBER, 12 => _CAL_DECEMBER);

$fromyear = (isset($_GET['year'])) ? intval ($_GET['year']): 0;
$frommonth = (isset($_GET['month'])) ? intval($_GET['month']) : 0;

$pgtitle='';
if($fromyear!=0 && $frommonth!=0) 
{
	$pgtitle=sprintf(" - %d - %d",$fromyear,$frommonth);
}
$myts =& MyTextSanitizer::getInstance();
$xoopsTpl->assign('xoops_pagetitle', $myts->htmlSpecialChars($xoopsModule->name()) . ' - ' . $myts->htmlSpecialChars(_MD_SOCIAL_NW_NEWSARCHIVES) . $pgtitle);

$useroffset = "";
if(is_object($xoopsUser)) {
	$timezone = $xoopsUser->timezone();
	if(isset($timezone)){
		$useroffset = $xoopsUser->timezone();
	}else{
		$useroffset = $xoopsConfig['default_TZ'];
	}
}
$result = $xoopsDB->query("SELECT published FROM ".$xoopsDB->prefix("socialnet_article")." WHERE published>0 AND published<=".time()." AND expired <= ".time()." ORDER BY published DESC");
if (!$result) {
	exit();

} else {
	$years = array();
	$months = array();
	$i = 0;
	while (list($time) = $xoopsDB->fetchRow($result)) {
		$time = formatTimestamp($time, "mysql", $useroffset);
			if (preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/", $time, $datetime)) {
				$this_year  = intval($datetime[1]);
				$this_month = intval($datetime[2]);
			if (empty($lastyear)) {
				$lastyear = $this_year;
			}
			if ($lastmonth == 0) {
				$lastmonth = $this_month;
				$months[$lastmonth]['string'] = $months_arr[$lastmonth];
				$months[$lastmonth]['number'] = $lastmonth;
			}
			if ($lastyear != $this_year) {
				$years[$i]['number'] = $lastyear;
				$years[$i]['months'] = $months;
				$months = array();
				$lastmonth = 0;
				$lastyear = $this_year;
				$i++;
			}
			if ($lastmonth != $this_month) {
				$lastmonth = $this_month;
				$months[$lastmonth]['string'] = $months_arr[$lastmonth];
				$months[$lastmonth]['number'] = $lastmonth;
			}
		}
	}
	$years[$i]['number'] = $this_year;
	$years[$i]['months'] = $months;	$xoopsTpl->assign('years', $years);
}

if ($fromyear != 0 && $frommonth != 0) {
	$xoopsTpl->assign('show_articles', true);
	$xoopsTpl->assign('lang_articles', _MD_SOCIAL_ARTICLES);
	$xoopsTpl->assign('currentmonth', $months_arr[$frommonth]);
	$xoopsTpl->assign('currentyear', $fromyear);
	$xoopsTpl->assign('lang_actions', _MD_SOCIAL_NW_ACTIONS);
	$xoopsTpl->assign('lang_date', _MD_SOCIAL_NW_DATE);
	$xoopsTpl->assign('lang_views', _MD_SOCIAL_NW_VIEWS);

	// must adjust the selected time to server timestamp
	$timeoffset = $useroffset - $xoopsConfig['server_TZ'];
	$monthstart = mktime(0 - $timeoffset, 0, 0, $frommonth, 1, $fromyear);
	$monthend = mktime(23 - $timeoffset, 59, 59, $frommonth + 1, 0, $fromyear);
	$monthend = ($monthend > time()) ? time() : $monthend;
	$sql = "SELECT * FROM ".$xoopsDB->prefix("socialnet_article")." WHERE published >= $monthstart and published <= $monthend ORDER by published DESC";
	$result = $xoopsDB->query($sql);
	$count = 0;
	while ($myrow = $xoopsDB->fetchArray($result)) {
	    $article = new SocialnetStory($myrow);
	    $story = array();
	    $story['title'] = "<a href='news.php?storytopic=".$article->topicid()."'>".$article->topic_title()."</a>: <a href='newsarticle.php?storyid=".$article->storyid()."'>".$article->title()."</a>";
	    $story['counter'] = $article->counter();
	    $story['date'] = formatTimestamp($article->published(),"m",$useroffset);
	    $story['print_link'] = 'newsprint.php?storyid='.$article->storyid();
	    $story['mail_link'] = 'mailto:?subject='.sprintf(_MD_SOCIAL_NW_INTARTICLE, $xoopsConfig['sitename']).'&amp;body='.sprintf(_MD_SOCIAL_NW_INTARTFOUND, $xoopsConfig['sitename']).':  '.XOOPS_URL.'/modules/socialnet/newsarticle.php?storyid='.$article->storyid();
	    $xoopsTpl->append('stories', $story);
	    $count++;
	}
	$xoopsTpl->assign('lang_printer', _MD_SOCIAL_NW_PRINTERFRIENDLY);
	$xoopsTpl->assign('lang_sendstory', _MD_SOCIAL_NW_SENDSTORY);
	$xoopsTpl->assign('lang_storytotal', sprintf(_MD_SOCIAL_NW_THEREAREINTOTAL, $count));
} else {
    $xoopsTpl->assign('show_articles', false);
}
$xoopsTpl->assign('lang_newsarchives', _MD_SOCIAL_NW_NEWSARCHIVES);

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

include XOOPS_ROOT_PATH."/footer.php";
?>