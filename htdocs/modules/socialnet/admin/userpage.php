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

require_once '../../../include/cp_header.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/include/common.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/admin/functions.php';
require_once XOOPS_ROOT_PATH.'/class/pagenav.php';

// ********************************************************************************************************************
// **** Main
// ********************************************************************************************************************

$op = 'default';
if(isset($_POST['op'])) {
 $op=$_POST['op'];
} elseif(isset($_GET['op'])) {
	$op=$_GET['op'];
}
$socialnet_handler =& xoops_getmodulehandler('socialnet', 'socialnet');

switch ($op) {
	/**
 	 * Default action, show statistics and a listing of all the pages
 	 */
	case 'stats':
	default:
        xoops_cp_header();
        adminmenu(4);

		if (file_exists(XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/admin.php')) {
			require_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/admin.php';
		} else {
			require_once XOOPS_ROOT_PATH.'/modules/socialnet/language/english/main.php';
		}

		if (file_exists(XOOPS_ROOT_PATH.'/modules/socialnet/language/'.$xoopsConfig['language'].'/main.php')) {
			require_once XOOPS_ROOT_PATH.'/modules/socialnet/language/'.$xoopsConfig['language'].'/main.php';
		} else {
			require_once XOOPS_ROOT_PATH.'/modules/socialnet/language/english/main.php';
		}
        $totalcount = $socialnet_handler->getCount();	// Pages count
		echo '<h4>'.sprintf(_AM_SOCIALNET_STATS,$totalcount).'</h4>';
		$limit = socialnet_utils::getModuleOption('linesperpage');
		$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
		$critere = new Criteria('1', '1','=');
		$critere->setLimit($limit);
		$critere->setStart($start);
		// tip, replace "up_created" with "up_uid" if you want to sort by user and not by date
		$critere->setSort('up_created');
		$critere->setOrder('DESC');
		$pagescount = $socialnet_handler->getCount();
		$pagenav = new XoopsPageNav($pagescount, $limit , $start, 'start', 'op=list');
		$pages = array();
		$pages = $socialnet_handler->getObjects($critere);
		echo "<div align='right'>".$pagenav->renderNav().'</div><br />';
		echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
		echo '<tr>';
		echo '<th align="center">'._MD_SOCIALNET_USER.'</th>';
		echo '<th align="center">'._MD_SOCIALNET_TITLE.'</th>';
		echo '<th align="center">'._MD_SOCIALNET_DATE.'</th>';
		echo '<th align="center">'._MD_SOCIALNET_HITS.'</th>';
		echo '<th align="center">'._AD_ACTION.'</th>';
		echo '</tr>';
		$class='';
		$allowhtml = socialnet_utils::getModuleOption('allowhtml');
		foreach($pages as $page) {
			$class = ($class == 'even') ? 'odd' : 'even';
			$page->setVar('dohtml',$allowhtml);
			echo "<tr class='".$class."'>";
			echo '<td>'.$page->uname().'</td>';
			echo "<td><a href=\"".XOOPS_URL."/modules/socialnet/pageuser.php?page_id=".$page->getVar('up_pageid')."\">".$page->getVar('up_title')."</a></td>";
			echo "<td align=\"center\">".formatTimestamp($page->getVar('up_created'), socialnet_utils::getModuleOption('dateformat'))."</td>";
			echo "<td align=\"center\">".$page->getVar('up_hits')."</td>";
			$del_action = "<a title='"._DELETE."' href='userpage.php?op=delete&id=".$page->getVar('up_pageid')."' ".socialnet_utils::javascriptLinkConfirm(_MD_SOCIALNET_ARE_YOU_SURE)." ><img src='../images/icons/dele.gif' alt='"._DELETE."' border='0' /></a>";
			$view_action = "<a target='_blank' title='"._MD_SOCIALNET_VIEW."' href='".$page->getURL()."'><img src='../images/icons/userpage.gif' alt='"._MD_SOCIALNET_VIEW."' border='0' /></a>";
			echo "<td align=\"center\">".$del_action.' '.$view_action.'</td>';
			echo "</tr>";
		}
		echo '</table>';
        echo "<div align='right'>".$pagenav->renderNav().'</div><br />';
		break;

	/**
	 * Remove a specific page
	 */
	case 'delete':
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		$res = false;
		if($id>0) {
			$page = $socialnet_handler->get($id);
			if(is_object($page)) {
				$res = $socialnet_handler->delete($page, true);
			}
		}
		if($res) {
		    socialnet_utils::updateCache();
			redirect_header('userpage.php', 2, _MD_SOCIALNET_DB_OK);
			exit();
		} else {
			redirect_header('userpage.php', 4, _ERRORS);
			exit();
		}
		break;
}

echo "<div align='center' style='margin-top:10px'><a href='http://www.ipwgc.com/socialnet/'><img src='../images/socialnetLogo.png'></a><br /><img src='../images/menu/mailuser.gif'><a style='color: #029116; font-size:11px' href='feedback.php'>"._AM_SOCIALNET_FEEDBACK."</a> - <img src='../images/icons/mainvideo.gif'><a style='color: #FF0000; font-size:11px' href='http://www.ipwgc.com/socialnet/modules/socialnet/index.php' target='_blank'>"._AM_SOCIALNET_CHKVERSION."</a></div>";
xoops_cp_footer();
?>