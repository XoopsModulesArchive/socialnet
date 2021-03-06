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

$op = "form";
$op = isset($_POST['op']) ? trim(htmlspecialchars($_POST['op'])) : 'form';

if(isset($_POST['op']) && $_POST['op'] == 'submit' ) {$op = 'submit';}
include_once 'class/socialnet_controler.php';
$controler = new SocialnetControlerIndex($xoopsDB,$xoopsUser);

/**
* Fecthing numbers of groups friends videos pictures etc...
*/
$nbSections = $controler->getNumbersSections();

if($op == 'form')
{
	$xoopsOption['template_main'] = 'socialnet_searchform.html';
	include XOOPS_ROOT_PATH.'/header.php';
	$member_handler =& xoops_gethandler('member');
	$total = $member_handler->getUserCount(new Criteria('level', 0, '>'));
	include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
	$uname_text = new XoopsFormText('', 'user_uname', 30, 60);
	$uname_match = new XoopsFormSelectMatchOption('', 'user_uname_match');
	$uname_tray = new XoopsFormElementTray(_MD_SOCIALNET_UNAME, '&nbsp;');
	$uname_tray->addElement($uname_match);
	$uname_tray->addElement($uname_text);
	$name_text = new XoopsFormText('', 'user_name', 30, 60);
	$name_match = new XoopsFormSelectMatchOption('', 'user_name_match');
	$name_tray = new XoopsFormElementTray(_MD_SOCIALNET_REALNAME, '&nbsp;');
	$name_tray->addElement($name_match);
	$name_tray->addElement($name_text);
	$email_text = new XoopsFormText('', 'user_email', 30, 60);
	$email_match = new XoopsFormSelectMatchOption('', 'user_email_match');
	$email_tray = new XoopsFormElementTray(_MD_SOCIALNET_EMAIL, '&nbsp;');
	$email_tray->addElement($email_match);
	$email_tray->addElement($email_text);
	$url_text = new XoopsFormText(_MD_SOCIALNET_URLC, 'user_url', 30, 100);
	//$theme_select = new XoopsFormSelectTheme(_MD_SOCIALNET_THEME, "user_theme");
	//$timezone_select = new XoopsFormSelectTimezone(_MD_SOCIALNET_TIMEZONE, "user_timezone_offset");
	$icq_text = new XoopsFormText('', 'user_icq', 30, 100);
	$icq_match = new XoopsFormSelectMatchOption('', 'user_icq_match');
	$icq_tray = new XoopsFormElementTray(_MD_SOCIALNET_ICQ, '&nbsp;');
	$icq_tray->addElement($icq_match);
	$icq_tray->addElement($icq_text);
	$aim_text = new XoopsFormText('', 'user_aim', 30, 100);
	$aim_match = new XoopsFormSelectMatchOption('', 'user_aim_match');
	$aim_tray = new XoopsFormElementTray(_MD_SOCIALNET_AIM, '&nbsp;');
	$aim_tray->addElement($aim_match);
	$aim_tray->addElement($aim_text);
	$yim_text = new XoopsFormText('', 'user_yim', 30, 100);
	$yim_match = new XoopsFormSelectMatchOption('', 'user_yim_match');
	$yim_tray = new XoopsFormElementTray(_MD_SOCIALNET_YIM, '&nbsp;');
	$yim_tray->addElement($yim_match);
	$yim_tray->addElement($yim_text);
	$msnm_text = new XoopsFormText('', 'user_msnm', 30, 100);
	$msnm_match = new XoopsFormSelectMatchOption('', 'user_msnm_match');
	$msnm_tray = new XoopsFormElementTray(_MD_SOCIALNET_MSNM, '&nbsp;');
	$msnm_tray->addElement($msnm_match);
	$msnm_tray->addElement($msnm_text);
	$location_text = new XoopsFormText(_MD_SOCIALNET_LOCATION, 'user_from', 30, 100);
	$occupation_text = new XoopsFormText(_MD_SOCIALNET_OCCUPATION, 'user_occ', 30, 100);
	$interest_text = new XoopsFormText(_MD_SOCIALNET_INTEREST, 'user_intrest', 30, 100);

	//$bio_text = new XoopsFormText(_MD_SOCIALNET_EXTRAINFO, "user_bio", 30, 100);
	$lastlog_more = new XoopsFormText(_MD_SOCIALNET_LASTLOGMORE, 'user_lastlog_more', 10, 5);
	$lastlog_less = new XoopsFormText(_MD_SOCIALNET_LASTLOGLESS, 'user_lastlog_less', 10, 5);
	$reg_more = new XoopsFormText(_MD_SOCIALNET_REGMORE, 'user_reg_more', 10, 5);
	$reg_less = new XoopsFormText(_MD_SOCIALNET_REGLESS, 'user_reg_less', 10, 5);
	$posts_more = new XoopsFormText(_MD_SOCIALNET_POSTSMORE, 'user_posts_more', 10, 5);
	$posts_less = new XoopsFormText(_MD_SOCIALNET_POSTSLESS, 'user_posts_less', 10, 5);
	$sort_select = new XoopsFormSelect(_MD_SOCIALNET_SORT, 'user_sort');
	$sort_select->addOptionArray(array('uname'=>_MD_SOCIALNET_UNAME,'email'=>_MD_SOCIALNET_EMAIL,'last_login'=>_MD_SOCIALNET_LASTLOGIN,'user_regdate'=>_MD_SOCIALNET_REGDATE,'posts'=>_MD_SOCIALNET_POSTS));
	$order_select = new XoopsFormSelect(_MD_SOCIALNET_ORDER, 'user_order');
	$order_select->addOptionArray(array('ASC'=>_MD_SOCIALNET_ASC,'DESC'=>_MD_SOCIALNET_DESC));
	$limit_text = new XoopsFormText(_MD_SOCIALNET_LIMIT, 'limit', 6, 2);
	$op_hidden = new XoopsFormHidden('op', 'submit');
	$submit_button = new XoopsFormButton('', 'user_submit', _SUBMIT, 'submit');

	$form = new XoopsThemeForm('', 'searchform', 'searchmembers.php');
	$form->addElement($uname_tray);
	$form->addElement($name_tray);
	$form->addElement($email_tray);
	//$form->addElement($theme_select);
	//$form->addElement($timezone_select);
	$form->addElement($icq_tray);
	$form->addElement($aim_tray);
	$form->addElement($yim_tray);
	$form->addElement($msnm_tray);
	$form->addElement($url_text);
	$form->addElement($location_text);
	$form->addElement($occupation_text);
	$form->addElement($interest_text);
	//$form->addElement($bio_text);
	$form->addElement($lastlog_more);
	$form->addElement($lastlog_less);
	$form->addElement($reg_more);
	$form->addElement($reg_less);
	$form->addElement($posts_more);
	$form->addElement($posts_less);
	$form->addElement($sort_select);
	$form->addElement($order_select);
	$form->addElement($limit_text);
	$form->addElement($op_hidden);
	$form->addElement($submit_button);
	$form->assign($xoopsTpl);
	$xoopsTpl->assign('lang_search', _MD_SOCIALNET_SEARCH);
	$xoopsTpl->assign('lang_totalusers', sprintf(_MD_SOCIALNET_TOTALUSERS, '<span style="color:#ff0000;">'.$total.'</span>'));
}

if($op == 'submit')
{
	$xoopsOption['template_main'] = 'socialnet_searchresults.html';
	include XOOPS_ROOT_PATH.'/header.php';
	$iamadmin = $xoopsUserIsAdmin;
	$myts =& MyTextSanitizer::getInstance();
	$criteria = new CriteriaCompo();
	if(!empty($_POST['user_uname']))
	{
		$match = (!empty($_POST['user_uname_match'])) ? intval($_POST['user_uname_match']) : XOOPS_MATCH_START;
		switch($match)
		{
			case XOOPS_MATCH_START:
				$criteria->add(new Criteria('uname', $myts->addSlashes(trim($_POST['user_uname'])).'%', 'LIKE'));
			break;
			case XOOPS_MATCH_END:
				$criteria->add(new Criteria('uname', '%'.$myts->addSlashes(trim($_POST['user_uname'])), 'LIKE'));
			break;
			case XOOPS_MATCH_EQUAL:
				$criteria->add(new Criteria('uname', $myts->addSlashes(trim($_POST['user_uname']))));
			break;
			case XOOPS_MATCH_CONTAIN:
				$criteria->add(new Criteria('uname', '%'.$myts->addSlashes(trim($_POST['user_uname'])).'%', 'LIKE'));
			break;
		}
	}
	if(!empty($_POST['user_name']))
	{
		$match = (!empty($_POST['user_name_match'])) ? intval($_POST['user_name_match']) : XOOPS_MATCH_START;
		switch($match)
		{
			case XOOPS_MATCH_START:
				$criteria->add(new Criteria('name', $myts->addSlashes(trim($_POST['user_name'])).'%', 'LIKE'));
			break;
			case XOOPS_MATCH_END:
				$criteria->add(new Criteria('name', '%'.$myts->addSlashes(trim($_POST['user_name'])).'%', 'LIKE'));
			break;
			case XOOPS_MATCH_EQUAL:
				$criteria->add(new Criteria('name', $myts->addSlashes(trim($_POST['user_name']))));
			break;
			case XOOPS_MATCH_CONTAIN:
				$criteria->add(new Criteria('name', '%'.$myts->addSlashes(trim($_POST['user_name'])).'%', 'LIKE'));
			break;
		}
	}
	if(!empty($_POST['user_email']))
	{
		$match = (!empty($_POST['user_email_match'])) ? intval($_POST['user_email_match']) : XOOPS_MATCH_START;
		switch($match)
		{
			case XOOPS_MATCH_START:
				$criteria->add(new Criteria('email', $myts->addSlashes(trim($_POST['user_email'])).'%', 'LIKE'));
			break;
			case XOOPS_MATCH_END:
				$criteria->add(new Criteria('email', '%'.$myts->addSlashes(trim($_POST['user_email'])), 'LIKE'));
			break;
			case XOOPS_MATCH_EQUAL:
				$criteria->add(new Criteria('email', $myts->addSlashes(trim($_POST['user_email']))));
			break;
			case XOOPS_MATCH_CONTAIN:
				$criteria->add(new Criteria('email', '%'.$myts->addSlashes(trim($_POST['user_email'])).'%', 'LIKE'));
			break;
		}
		if(!$iamadmin) {$criteria->add(new Criteria('user_viewemail', 1));}
	}
	if(!empty($_POST['user_url']))
	{
		$url = formatURL(trim($_POST['user_url']));
		$criteria->add(new Criteria('url', $myts->addSlashes($url).'%', 'LIKE'));
	}
	if(!empty($_POST['user_icq']))
	{
		$match = (!empty($_POST['user_icq_match'])) ? intval($_POST['user_icq_match']) : XOOPS_MATCH_START;
		switch ($match) {
			case XOOPS_MATCH_START:
				$criteria->add(new Criteria('user_icq', $myts->addSlashes(trim($_POST['user_icq'])).'%', 'LIKE'));
			break;
			case XOOPS_MATCH_END:
				$criteria->add(new Criteria('user_icq', '%'.$myts->addSlashes(trim($_POST['user_icq'])), 'LIKE'));
			break;
			case XOOPS_MATCH_EQUAL:
				$criteria->add(new Criteria('user_icq', $myts->addSlashes(trim($_POST['user_icq']))));
			break;
			case XOOPS_MATCH_CONTAIN:
				$criteria->add(new Criteria('user_icq', '%'.$myts->addSlashes(trim($_POST['user_icq'])).'%', 'LIKE'));
			break;
		}
	}
	if(!empty($_POST['user_aim']))
	{
		$match = (!empty($_POST['user_aim_match'])) ? intval($_POST['user_aim_match']) : XOOPS_MATCH_START;
		switch($match)
		{
			case XOOPS_MATCH_START:
				$criteria->add(new Criteria('user_aim', $myts->addSlashes(trim($_POST['user_aim'])).'%', 'LIKE'));
			break;
			case XOOPS_MATCH_END:
				$criteria->add(new Criteria('user_aim', '%'.$myts->addSlashes(trim($_POST['user_aim'])), 'LIKE'));
			break;
			case XOOPS_MATCH_EQUAL:
				$criteria->add(new Criteria('user_aim', $myts->addSlashes(trim($_POST['user_aim']))));
			break;
			case XOOPS_MATCH_CONTAIN:
				$criteria->add(new Criteria('user_aim', '%'.$myts->addSlashes(trim($_POST['user_aim'])).'%', 'LIKE'));
			break;
		}
	}
	if(!empty($_POST['user_yim']))
	{
		$match = (!empty($_POST['user_yim_match'])) ? intval($_POST['user_yim_match']) : XOOPS_MATCH_START;
		switch($match)
		{
			case XOOPS_MATCH_START:
				$criteria->add(new Criteria('user_yim', $myts->addSlashes(trim($_POST['user_yim'])).'%', 'LIKE'));
			break;
			case XOOPS_MATCH_END:
				$criteria->add(new Criteria('user_yim', '%'.$myts->addSlashes(trim($_POST['user_yim'])), 'LIKE'));
			break;
			case XOOPS_MATCH_EQUAL:
				$criteria->add(new Criteria('user_yim', $myts->addSlashes(trim($_POST['user_yim']))));
			break;
			case XOOPS_MATCH_CONTAIN:
				$criteria->add(new Criteria('user_yim', '%'.$myts->addSlashes(trim($_POST['user_yim'])).'%', 'LIKE'));
			break;
		}
	}
	if(!empty($_POST['user_msnm']))
	{
		$match = (!empty($_POST['user_msnm_match'])) ? intval($_POST['user_msnm_match']) : XOOPS_MATCH_START;
		switch($match)
		{
			case XOOPS_MATCH_START:
				$criteria->add(new Criteria('user_msnm', $myts->addSlashes(trim($_POST['user_msnm'])).'%', 'LIKE'));
			break;
			case XOOPS_MATCH_END:
				$criteria->add(new Criteria('user_msnm', '%'.$myts->addSlashes(trim($_POST['user_msnm'])), 'LIKE'));
			break;
			case XOOPS_MATCH_EQUAL:
				$criteria->add(new Criteria('user_msnm', $myts->addSlashes(trim($_POST['user_msnm']))));
			break;
			case XOOPS_MATCH_CONTAIN:
				$criteria->add(new Criteria('user_msnm', '%'.$myts->addSlashes(trim($_POST['user_msnm'])).'%', 'LIKE'));
			break;
		}
	}
	if(!empty($_POST['user_from'])) {$criteria->add(new Criteria('user_from', '%'.$myts->addSlashes(trim($_POST['user_from'])).'%', 'LIKE'));}
	if(!empty($_POST['user_intrest'])) {$criteria->add(new Criteria('user_intrest', '%'.$myts->addSlashes(trim($_POST['user_intrest'])).'%', 'LIKE'));}
	if(!empty($_POST['user_occ'])) {$criteria->add(new Criteria('user_occ', '%'.$myts->addSlashes(trim($_POST['user_occ'])).'%', 'LIKE'));}
	if(!empty($_POST['user_lastlog_more']) && is_numeric($_POST['user_lastlog_more']))
	{
		$f_user_lastlog_more = intval(trim($_POST['user_lastlog_more']));
		$time = time() - (60 * 60 * 24 * $f_user_lastlog_more);
		if($time > 0) {$criteria->add(new Criteria('last_login', $time, '<'));}
	}
	if(!empty($_POST['user_lastlog_less']) && is_numeric($_POST['user_lastlog_less']))
	{
		$f_user_lastlog_less = intval(trim($_POST['user_lastlog_less']));
		$time = time() - (60 * 60 * 24 * $f_user_lastlog_less);
		if( $time > 0) {$criteria->add(new Criteria('last_login', $time, '>'));}
	}
	if(!empty($_POST['user_reg_more']) && is_numeric($_POST['user_reg_more']))
	{
		$f_user_reg_more = intval(trim($_POST['user_reg_more']));
		$time = time() - (60 * 60 * 24 * $f_user_reg_more);
		if($time > 0) {$criteria->add(new Criteria('user_regdate', $time, '<'));}
	}
	if(!empty($_POST['user_reg_less']) && is_numeric($_POST['user_reg_less']))
	{
		$f_user_reg_less = intval($_POST['user_reg_less']);
		$time = time() - (60 * 60 * 24 * $f_user_reg_less);
		if($time > 0) {$criteria->add(new Criteria('user_regdate', $time, '>'));}
	}
	if(isset($_POST['user_posts_more']) && is_numeric($_POST['user_posts_more']))
	{
		$criteria->add(new Criteria('posts', intval($_POST['user_posts_more']), '>'));
	}
	if(!empty($_POST['user_posts_less']) && is_numeric($_POST['user_posts_less']))
	{
		$criteria->add(new Criteria('posts', intval($_POST['user_posts_less']), '<'));
	}
	$criteria->add(new Criteria('level', 0, '>'));
	$validsort = array('uname', 'email', 'last_login', 'user_regdate', 'posts');
	$sort = (!in_array($_POST['user_sort'], $validsort)) ? 'uname' : htmlspecialchars($_POST['user_sort']);
	$order = 'ASC';
	if(isset($_POST['user_order']) && $_POST['user_order'] == 'DESC') {$order = 'DESC';}
	$limit = (!empty($_POST['limit'])) ? intval($_POST['limit']) : 20;
	if($limit == 0 || $limit > 50) {$limit = 50;}

	$start = (!empty($_POST['start'])) ? intval($_POST['start']) : 0;
	$member_handler =& xoops_gethandler('member');
	$total = $member_handler->getUserCount($criteria);
	$xoopsTpl->assign('lang_search', _MD_SOCIALNET_SEARCH);
	$xoopsTpl->assign('lang_results', _MD_SOCIALNET_RESULTS);
	$xoopsTpl->assign('total_found', $total);
	if($total == 0) {$xoopsTpl->assign('lang_nonefound', _MD_SOCIALNET_NOFOUND);}
	elseif($start < $total )
	{
		$xoopsTpl->assign('lang_username', _MD_SOCIALNET_UNAME);
		$xoopsTpl->assign('lang_realname', _MD_SOCIALNET_REALNAME);
		$xoopsTpl->assign('lang_avatar', _MD_SOCIALNET_AVATAR);
		$xoopsTpl->assign('lang_email', _MD_SOCIALNET_EMAIL);
		$xoopsTpl->assign('lang_privmsg', _MD_SOCIALNET_PM);
		$xoopsTpl->assign('lang_regdate', _MD_SOCIALNET_REGDATE);
		$xoopsTpl->assign('lang_lastlogin', _MD_SOCIALNET_LASTLOGIN);
		$xoopsTpl->assign('lang_posts', _MD_SOCIALNET_POSTS);
		$xoopsTpl->assign('lang_url', _MD_SOCIALNET_URL);
		$xoopsTpl->assign('lang_admin', _MD_SOCIALNET_ADMIN);
		if($iamadmin) {$xoopsTpl->assign('is_admin', true);}
		$criteria->setSort($sort);
		$criteria->setOrder($order);
		$criteria->setStart($start);
		$criteria->setLimit($limit);
		$foundusers =& $member_handler->getUsers($criteria, true);
		foreach (array_keys($foundusers) as $j)
		{
			$userdata['avatar'] = $foundusers[$j]->getVar('user_avatar') ? "<img src='".XOOPS_UPLOAD_URL."/".$foundusers[$j]->getVar('user_avatar')."' alt='' border='0' width='64' height='64' />" : '&nbsp;';
			$userdata['realname'] = $foundusers[$j]->getVar('name') ? $foundusers[$j]->getVar('name') : '&nbsp;';
			$userdata['name'] = $foundusers[$j]->getVar('uname');
			$userdata['id'] = $foundusers[$j]->getVar('uid');
			if($foundusers[$j]->getVar('user_viewemail') == 1 || $iamadmin)
			{
				$userdata['email'] = "<a href='mailto:".$foundusers[$j]->getVar('email')."'><img src='".XOOPS_URL."/images/icons/email.gif' border='0' alt='".sprintf(_SENDEMAILTO,$foundusers[$j]->getVar('uname', "E"))."' /></a>";
			}
			else {$userdata['email'] = '&nbsp;';}
			if($xoopsUser)
			{
				$userdata['pmlink'] = "<a href='javascript:openWithSelfMain(\"".XOOPS_URL."/pmlite.php?send2=1&amp;to_userid=".$foundusers[$j]->getVar('uid')."\",\"pmlite\",450,370);'><img src='".XOOPS_URL."/images/icons/pm.gif' border='0' alt='".sprintf(_SENDPMTO,$foundusers[$j]->getVar('uname', 'E'))."' /></a>";
			}
			else {$userdata['pmlink'] = '&nbsp;';}
			if($foundusers[$j]->getVar('url','E') != '')
			{
				$userdata['website'] = "<a href='".$foundusers[$j]->getVar('url','E')."' target='_blank'><img src='".XOOPS_URL."/images/icons/www.gif' border='0' alt='"._VISITWEBSITE."' /></a>";
			}
			else {$userdata['website'] = '&nbsp;';}
			$userdata['registerdate'] = formatTimeStamp($foundusers[$j]->getVar('user_regdate'),'s');
			if($foundusers[$j]->getVar('last_login') != 0) {$userdata['lastlogin'] = formatTimeStamp($foundusers[$j]->getVar('last_login'),'m');}
			else {$userdata['lastlogin'] = '&nbsp;';}
			$userdata['posts'] = $foundusers[$j]->getVar('posts');
			if($iamadmin)
			{
				$userdata['adminlink'] = "<a href='".XOOPS_URL."/modules/system/admin.php?fct=users&amp;uid=".intval($foundusers[$j]->getVar('uid'))."&amp;op=modifyUser'>"._EDIT."</a> | <a href='".XOOPS_URL."/modules/system/admin.php?fct=users&amp;op=delUser&amp;uid=".intval($foundusers[$j]->getVar('uid'))."'>"._DELETE."</a>";
			}
			$xoopsTpl->append('users', $userdata);
		}
		$totalpages = ceil($total / $limit);
		if($totalpages > 1)
		{
			$hiddenform = "<form name='findnext' action='searchmembers.php' method='post'>";
			foreach($_POST as $k => $v)
			{
				$hiddenform .= "<input type='hidden' name='".$myts->oopsHtmlSpecialChars($k)."' value='".$myts->makeTboxData4PreviewInForm($v)."' />\n";
			}
			if(!isset($_POST['limit'])) {$hiddenform .= "<input type='hidden' name='limit' value='".intval($limit)."' />\n";}
			if(!isset($_POST['start'])) {$hiddenform .= "<input type='hidden' name='start' value='".intval($start)."' />\n";}
			$prev = $start - $limit;
			if($start - $limit >= 0)
			{
				$hiddenform .= "<a href='#0' onclick='javascript:document.findnext.start.value=".$prev.";document.findnext.submit();'>"._MD_SOCIALNET_PREVIOUS."</a>&nbsp;\n";
			}
			$counter = 1;
			$currentpage = ($start+$limit) / $limit;
			while($counter <= $totalpages)
			{
				if($counter == $currentpage) {$hiddenform .= '<b>'.$counter.'</b> ';}
				elseif(($counter > $currentpage-4 && $counter < $currentpage+4) || $counter == 1 || $counter == $totalpages)
				{
					if($counter == $totalpages && $currentpage < $totalpages-4) {$hiddenform .= '... ';}
					$hiddenform .= "<a href='#".$counter."' onclick='javascript:document.findnext.start.value=".($counter-1)*$limit.";document.findnext.submit();'>".$counter."</a> ";
					if($counter == 1 && $currentpage > 5) {$hiddenform .= '... ';}
				}
				$counter++;
			}
			$next = $start+$limit;
			if($total > $next)
			{
				$hiddenform .= "&nbsp;<a href='#".$total."' onclick='javascript:document.findnext.start.value=".$next.";document.findnext.submit();'>"._MD_SOCIALNET_NEXT."</a>\n";
			}
			$hiddenform .= '</form>';
			$xoopsTpl->assign('pagenav', $hiddenform);
			$xoopsTpl->assign('lang_numfound', sprintf(_MD_SOCIALNET_USERSFOUND, $total));
		}
	}
}

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

//permissions
$xoopsTpl->assign('allow_scraps',$controler->checkPrivilegeBySection('scraps'));
$xoopsTpl->assign('allow_friends',$controler->checkPrivilegeBySection('friends'));
$xoopsTpl->assign('allow_groups',$controler->checkPrivilegeBySection('groups'));
$xoopsTpl->assign('allow_pictures',$controler->checkPrivilegeBySection('pictures'));
$xoopsTpl->assign('allow_videos',$controler->checkPrivilegeBySection('videos'));
$xoopsTpl->assign('allow_audios',$controler->checkPrivilegeBySection('audio'));

//Owner data
$xoopsTpl->assign('uid_owner',$controler->uidOwner);
$xoopsTpl->assign('owner_uname',$controler->nameOwner);
$xoopsTpl->assign('isOwner',$controler->isOwner);
$xoopsTpl->assign('isanonym',$controler->isAnonym);

//numbers
$xoopsTpl->assign('nb_groups',$nbSections['nbGroups']);
$xoopsTpl->assign('nb_photos',$nbSections['nbPhotos']);
$xoopsTpl->assign('nb_videos',$nbSections['nbVideos']);
$xoopsTpl->assign('nb_scraps',$nbSections['nbScraps']);
$xoopsTpl->assign('nb_friends',$nbSections['nbFriends']);
$xoopsTpl->assign('nb_audio',$nbSections['nbAudio']); 

//navbar
$xoopsTpl->assign('module_name',$xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection',_MD_SOCIALNET_SEARCH.' '.sprintf(_MD_SOCIALNET_TOTALUSERS, '<span style="color:#ff0000;">'.$total.'</span>'));
$xoopsTpl->assign('section_name',_MD_SOCIALNET_SEARCH);
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

include_once XOOPS_ROOT_PATH.'/footer.php';
?>