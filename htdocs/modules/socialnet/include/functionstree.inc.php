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

// Administration

/*
	function adminmenu(){
	global $xoopsModule, $xoopsConfig, $xoopsModuleConfig;
	$adm_url = XOOPS_URL."/modules/socialnet/admin/";
	$links[] = array(0 => XOOPS_URL.'/modules/system/admin.php?fct=preferences&op=showmod&mod='.$xoopsModule->getVar('mid'), 1 => _PREFERENCES);
	xoops_cp_header();

	$dir = SOCIALNET_FILES_PATH;
	$dir2 = SOCIALNET_MEDIA_PATH;
	$dir3 = SOCIALNET_HTML_PATH;
	if(!is_writable($dir)) {
		xoops_error(_AM_SOCIALNET_FILEERROR);
	}
	if(!is_writable($dir2)) {
		xoops_error(_AM_SOCIALNET_MEDIAERROR);
	}
	if(!is_writable($dir3)) {
		xoops_error(_AM_SOCIALNET_HTMLERROR);
	}

	if($xoopsModuleConfig['socialnet_conf_wysiwyg'] && !is_writable(XOOPS_ROOT_PATH.$xoopsModuleConfig['socialnet_conf_wysiwyg_path'])) {
		xoops_error(sprintf(_AM_SOCIALNET_WYSIWYG_PATHERROR, XOOPS_ROOT_PATH.$xoopsModuleConfig['socialnet_conf_wysiwyg_path']));
	}

}

*/
function socialnet_apagaPermissoes($id){
	global $xoopsModule, $moduleperm_handler;
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('gperm_itemid', $id));
	$criteria->add(new Criteria('gperm_modid', $xoopsModule->getVar('mid')));
	$criteria->add(new Criteria('gperm_name', "socialnet_mpublish_acesso"));
	if( $old_perms =& $moduleperm_handler->getObjects($criteria) ){
		foreach( $old_perms as $p ){
			$moduleperm_handler->delete($p);
		}
	}
	xoops_comment_delete($xoopsModule->getVar('mid'), $id);
	return true;
}

function socialnet_apagaPermissoesPai($id){
	global $xoopsModule;
	include_once XOOPS_ROOT_PATH."/modules/socialnet/class/socialnet_mpb_mpublish.class.php";
	$socialnet_classe = new socialnet_mpb_mpublish();
	$todos = $socialnet_classe->PegaTudo(new Criteria("mpb_10_idpai", $id));
	if (!empty($todos)) {
		foreach ($todos as $v){
			socialnet_apagaPermissoes($v->getVar("mpb_10_id"));
			xoops_comment_delete($xoopsModule->getVar('mid'), $v->getVar("mpb_10_id"));
		}
		return true;
	}
	return false;
}

function socialnet_inserePermissao($id, $grupos_ids){
	global $xoopsModule, $moduleperm_handler;
	foreach( $grupos_ids as $gid ){
		$perm =& $moduleperm_handler->create();
		$perm->setVar('gperm_name', "socialnet_mpublish_acesso");
		$perm->setVar('gperm_itemid', $id);
		$perm->setVar('gperm_groupid', $gid);
		$perm->setVar('gperm_modid', $xoopsModule->getVar('mid'));
		$moduleperm_handler->insert($perm);
	}
	return true;
}

function prepareContent($content){
	global $xoopsUser, $xoopsConfig;
	if(is_object($xoopsUser)){
		if ($xoopsUser->cleanVars()) {
			foreach ($xoopsUser->cleanVars as $k => $v) {
				$content = str_replace("{".$k."}", $v, $content);
			};
		}
	}
	foreach ($xoopsConfig as $k => $v){
		if(!is_array($v)){
			$content = str_replace("{".$k."}", $v, $content);
		}
	}
	$content = str_replace("{banner}", xoops_getbanner(), $content);
	if (!empty($_GET['busca']) && is_array($_GET['busca'])) {
		$search_string = _MI_SOCIALNET_HIGHLIGHT_SEARCH;
		$found = 0;
		$bgs = array("#ffff66", "#a0ffff", "#99ff99", "#ff9999", "#880000", "#00aa00", "#886800", "#004699", "#990099");
		$colors = array("black", "black", "black", "black", "white", "white", "white", "white", "white");
		$ctrl = 0;
		$busca = array_unique($_GET['busca']);
		foreach ($busca as $v){
			if(stristr(strip_tags($content), $v)){
				$cfundo = $bgs[$ctrl];
				$ctexto = $colors[$ctrl];
				$busca[0] = "~".$v."(?![^<]*>)~";
				$busca[1] = "~".strtolower($v)."(?![^<]*>)~";
				$busca[2] = "~".strtoupper($v)."(?![^<]*>)~";
				$busca[3] = "~".ucfirst(strtolower($v))."(?![^<]*>)~";
				$troca[0] = '<span style="font-weight:bold; color: '.$ctexto.'; background-color: '.$cfundo.';">'.$v."</span>";
				$troca[1] = '<span style="font-weight:bold; color: '.$ctexto.'; background-color: '.$cfundo.';">'.strtolower($v)."</span>";
				$troca[2] = '<span style="font-weight:bold; color: '.$ctexto.'; background-color: '.$cfundo.';">'.strtoupper($v)."</span>";
				$troca[3] = '<span style="font-weight:bold; color: '.$ctexto.'; background-color: '.$cfundo.';">'.ucfirst(strtolower($v))."</span>";
				$content = preg_replace($busca, $troca, $content);
				$search_string .= '<span style="font-weight:bold; color: '.$ctexto.'; background-color: '.$cfundo.';">'.$v."</span>, ";
				$found = 1;
				if ($ctrl == 8) {
					$ctrl = 0;
				}else{
					$ctrl++;
				}
			}
		}
		if ($found) {
			$search_string = substr($search_string, 0, -2)."<br /><br />";
			$content = $search_string.$content;
		}
	}
	return $content;
}

// Módulo


?>