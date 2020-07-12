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

function socialnet_mpublish_busca($queryarray, $andor, $limit, $offset, $userid){
	global $xoopsDB, $xoopsConfig, $xoopsUser;
	$module_handler =& xoops_gethandler('module');
	$groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
	$moduleperm_handler =& xoops_gethandler('groupperm');
	$socialnet_module =& $module_handler->getByDirname(_MI_SOCIALNET_DIR);
	$MyPages = $moduleperm_handler->getItemIds("socialnet_mpublish_acesso", $groups, $socialnet_module->getVar('mid'));
	$query_str = "";
	include_once XOOPS_ROOT_PATH."/modules/socialnet/class/socialnet_mpb_mpublish.class.php";
	$sql = "SELECT mpb_10_id, mpb_10_order FROM ".$xoopsDB->prefix(_MI_SOCIALNET_TABLEPUBLISH)." WHERE mpb_11_visible < 4 AND mpb_12_withoutlink = 0";
	if ( $userid != 0 ) {
		$sql .= " AND uid=".$userid." ";
	}
	if ( is_array($queryarray) && $count = count($queryarray) ) {
		$query_str .= "&busca[]=".$queryarray[0];
		$sql .= " AND ((mpb_35_content LIKE '%".$queryarray[0]."%' OR mpb_30_menu LIKE '%".$queryarray[0]."%' OR mpb_30_title LIKE '%".$queryarray[0]."%')";
		for($i=1;$i<$count;$i++){
			$sql .= " $andor ";
			$sql .= "(mpb_35_content LIKE '%".$queryarray[$i]."%' OR mpb_30_menu LIKE '%".$queryarray[$i]."%' OR mpb_30_title LIKE '%".$queryarray[$i]."%')";
			$query_str .= "&busca[]=".$queryarray[$i];
		}
		$sql .= ")";
	}

	$sql .= " ORDER BY mpb_10_order ASC";
	$result = $xoopsDB->query($sql,$limit,$offset);
	$ret = array();
	$contents = array();
	while($myrow = $xoopsDB->fetchArray($result)){
		if (!in_array($myrow['mpb_10_id'], $MyPages)) continue;
		$contents[$myrow['mpb_10_id']] = $myrow['mpb_10_order'];
	}
	$sql = "SELECT mpb_10_id, mpb_10_order, mpb_30_file FROM ".$xoopsDB->prefix(_MI_SOCIALNET_TABLEPUBLISH)." WHERE mpb_11_visible < 4 AND mpb_12_withoutlink = 0 AND mpb_30_file != '' AND SUBSTRING(mpb_30_file, 1, 4) != 'http'";
	if ( $userid != 0 ) {
		$sql .= " AND uid=".$userid." ";
	}
	$result = $xoopsDB->query($sql);
	while($myrow = $xoopsDB->fetchArray($result)){
		if (!in_array($myrow['mpb_10_id'], $MyPages)) continue;
		$pageContent = SOCIALNET_HTML_PATH."/".$myrow["mpb_30_file"];
		if(file_exists($pageContent)){
			ob_start();
			if(substr(strtolower($myrow["mpb_30_file"]), -3) == "php"){
				include($pageContent);
			}else{
				readfile($pageContent);
			}
			$content = ob_get_contents();
			ob_end_clean();
			$content = strip_tags($content);
			if ( is_array($queryarray) && $count = count($queryarray) ) {
				$ver_content = stristr($content, $queryarray[0]);
				if (!$ver_content && $andor == "AND") continue;
				for($i=1;$i<$count;$i++){
					if ($ver_content && $andor == "OR")	break;
					if (!$ver_content && $andor == "AND") break;
					$ver_content = stristr($content, $queryarray[$i]);
				}
			}
			if ($ver_content) {
				$contents[$myrow['mpb_10_id']] = $myrow['mpb_10_order'];
			}
		}
	}
	if (is_array($contents) && count($contents) > 0) {
		$i = 0;
		asort($contents);
		foreach ($contents as $k => $v) {
			$socialnet_classe = new socialnet_mpb_mpublish($k);
			$ret[$i]['image'] = "../images/icons/publish.gif' align='absmiddle";
			$ret[$i]['link'] = $socialnet_classe->pegaLink().$query_str;
			$ret[$i]['title'] = $socialnet_classe->getVar("mpb_30_menu");
			$ret[$i]['uid'] = "0";
			if ($i == ($limit-1)) {
				return $ret;
			}
			$i++;
		}
	}
	return $ret;
}
?>
