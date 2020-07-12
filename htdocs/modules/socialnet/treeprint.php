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
$xoopsLogger->activated = false;
include_once "header.php";
// *******************************************************************************
// **** Main
// *******************************************************************************

$tac = (isset($_GET['tac'])) ? $_GET['tac'] : 0;
$tac = (is_int($tac)) ? $tac : str_replace("_"," ", $tac);
if(!$tac){
	redirect_header(XOOPS_URL, 2, _MD_SOCIALNET_404);
}else{
	$socialnet_classe = new socialnet_mpb_mpublish($tac);
	if (!$socialnet_classe->getVar("mpb_10_id")) {
		redirect_header(XOOPS_URL, 2, _MD_SOCIALNET_404);
	}else{
		$groups = (!empty($xoopsUser) && is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
		$gperm_handler =& xoops_gethandler('groupperm');
		if (!$gperm_handler->checkRight("socialnet_mpublish_acesso", $socialnet_classe->getVar("mpb_10_id"), $groups, $xoopsModule->getVar('mid'))) {
			redirect_header(XOOPS_URL, 3, _NOPERM);
			exit();
		}
		if ($xoopsModuleConfig['socialnet_conf_navigation']) {
			$navigation = $socialnet_classe->geraNavigation();
		}else{
			$navigation = "";
		}
		if($socialnet_classe->getVar("mpb_30_file") != "" && substr($socialnet_classe->getVar("mpb_30_file"), 0, 7) == "http://"){
			$content = '<iframe src ="'.$socialnet_classe->getVar("mpb_30_file").'" width="'.$xoopsModuleConfig['socialnet_conf_iframe_width'].'" height="'.$xoopsModuleConfig['socialnet_conf_iframe_height'].'" scrolling="auto" frameborder="0"></iframe>';
			$mpb_30_title = $socialnet_classe->getVar("mpb_30_title");
		}elseif ($socialnet_classe->getVar("mpb_30_file") != "" && $socialnet_classe->getVar("mpb_35_content") == ""){
			$pageContent = SOCIALNET_HTML_PATH."/".$socialnet_classe->getVar("mpb_30_file");
			if(file_exists($pageContent)){
				ob_start();
				if(substr(strtolower($socialnet_classe->getVar("mpb_30_file")), -3) == "php"){
					include($pageContent);
				}else{
					readfile($pageContent);
				}
				$content = ob_get_contents();
				ob_end_clean();
				if (substr(strtolower($socialnet_classe->getVar("mpb_30_file")), -3) == "txt") {
					$content = nl2br($content);
				}
				$content = prepareContent($content);
			}
		}else{
			$content = prepareContent($socialnet_classe->getVar("mpb_35_content", "n"));
		}
		$title = $socialnet_classe->getVar("mpb_30_title");
	}
	echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
	echo '<html><head>';
	echo '
	<style type="text/css">
	a{text-decoration: none; color:#000000 }
	</style>
	';
	echo '<meta http-equiv="Content-Type" content="text/html; charset='._CHARSET.'" />';
	echo '<title>'.$xoopsConfig['sitename'].' - '.$title.'</title>';
	echo '<meta name="AUTHOR" content="'.$xoopsConfig['sitename'].'" />';
	echo '<meta name="COPYRIGHT" content="Copyright (c) '.date("Y").' by '.$xoopsConfig['sitename'].'" />';
	echo '<meta name="DESCRIPTION" content="'.$xoopsConfig['slogan'].'" />';
	echo '<meta name="GENERATOR" content="SocialNet 2010 V '.round($xoopsModule->getVar('version') / 100, 2).'-'.XOOPS_VERSION.'" />';
	echo '<body bgcolor="#ffffff" text="#000000" onload="window.print()">
    	<table border="0"><tr><td align="center">
    	<table border="0" width="640" cellpadding="0" cellspacing="1" bgcolor="#000000"><tr><td>
    	<table border="0" width="640" cellpadding="20" cellspacing="1" bgcolor="#ffffff"><tr><td><span style="color:#000000; font-size:15px;">'.$navigation.'</span></td></tr>
    	<tr><td align="center">
    	<img src="'.XOOPS_URL.'/images/logo.gif" border="0" alt="" /><br /><br />
    	<h3>'.$title.'</h3></td></tr>';
	echo '<tr valign="top"><td>';
	echo $content;
	echo '</td></tr></table></td></tr></table>';
	echo '<br /><a href="'.XOOPS_URL.'/">'.$xoopsConfig['sitename'].'</a><br /><br />'.$socialnet_classe->pegaLink().'<br />
    	</td></tr></table>
    	</body>
    	</html>
    	';
}
?>
