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

function socialnet_createmeta_keywords($content)
{
	$tmp=array();
	// Search for the "Minimum keyword length"
	if(isset($_SESSION['socialnet_keywords_limit'])) {
		$limit = $_SESSION['socialnet_keywords_limit'];
	} else {
		$config_handler =& xoops_gethandler('config');
		$xoopsConfigSearch =& $config_handler->getConfigsByCat(XOOPS_CONF_SEARCH);
		$limit=$xoopsConfigSearch['keyword_min'];
		$_SESSION['socialnet_keywords_limit']=$limit;
	}
	$myts =& MyTextSanitizer::getInstance();
	$content = str_replace ('<br />', ' ', $content);
	$content= $myts->undoHtmlSpecialChars($content);
	$content= strip_tags($content);
	$content=strtolower($content);
	$search_pattern=array("&nbsp;","\t","\r\n","\r","\n",",",".","'",";",":",")","(",'"','?','!','{','}','[',']','<','>','/','+','-','_','\\','*');
	$replace_pattern=array(' ',' ',' ',' ',' ',' ',' ',' ','','','','','','','','','','','','','','','','','','','');
	$content = str_replace($search_pattern, $replace_pattern, $content);
	$keywords=explode(' ',$content);
	$keywords=array_unique($keywords);
	foreach($keywords as $keyword) {
		if(strlen($keyword)>=$limit && !is_numeric($keyword)) {
			$tmp[]=$keyword;
		}
	}
	$tmp=array_slice($tmp,0,30);	// If you want to change the limit of keywords, change this number from 30 to what you want
	if(count($tmp)>0) {
		return implode(',',$tmp);
	} else {
		if(!isset($config_handler) || !is_object($config_handler)) {
			$config_handler =& xoops_gethandler('config');
		}
		$xoopsConfigMetaFooter =& $config_handler->getConfigsByCat(XOOPS_CONF_METAFOOTER);
		return $xoopsConfigMetaFooter['meta_keywords'];
	}
}
?>