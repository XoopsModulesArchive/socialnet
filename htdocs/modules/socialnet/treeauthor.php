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
include_once "header.php";
include_once XOOPS_ROOT_PATH."/modules/socialnet/class/socialnet_cfi_contentfiles.class.php";
// *******************************************************************************
// **** Main
// *******************************************************************************

if (isset($_GET)) {
	foreach ($_GET as $k => $v) {
		$$k = $v;
	}
}

if (isset($_POST)) {
	foreach ($_POST as $k => $v) {
		$$k = $v;
	}
}
if ( file_exists( "language/" . $xoopsConfig['language'] . "/admin.php" ) ) {
	include_once "language/" . $xoopsConfig['language'] . "/admin.php";
}
elseif ( file_exists( "language/english/admin.php" ) ) {
	include_once "language/english/admin.php";
}
if (empty($op)) {
	$op = "list";
}elseif ($op == "editar" || $op == "limpacont" || $op == "limpacont_ok" || $op == "new"){
	$mpb_10_id = (!empty($mpb_10_id)) ? $mpb_10_id : 0;
	$socialnet_classe =& new socialnet_mpb_mpublish($mpb_10_id);
	if (empty($xoopsUser) || empty($mpb_10_id) || $socialnet_classe->getVar('mpb_10_id') == '' || $socialnet_classe->getVar('usr_10_uid') != $xoopsUser->getVar('uid')) {
		redirect_header(XOOPS_URL, 3, _AM_SOCIALNET_403);
	}
}
switch ($op){
	case "limpacont":
		xoops_confirm(array('op' => 'limpacont_ok', 'mpb_10_id' => $mpb_10_id), 'treeauthor.php', sprintf(_AM_SOCIALNET_CONFIRM_LIMPACONT, $mpb_10_id, $socialnet_classe->getVar("mpb_30_menu")));
		break;
	case "limpacont_ok":
		$socialnet_classe->setVar("mpb_10_counter", 0);
		$socialnet_classe->setVar("mpb_22_uptodate", time());
		if (!$socialnet_classe->store()) {
			redirect_header(XOOPS_URL, 3, _AM_SOCIALNET_ERRO1);
		}else{
			redirect_header($socialnet_classe->pegaLink(), 3, _AM_SOCIALNET_SUCESS1);
		}
		break;
	case "new":
		if (!$xoopsModuleConfig['socialnet_conf_cancreate']) {
			redirect_header(XOOPS_URL, 3, _AM_SOCIALNET_403);
		}
		$mpb_10_idpai = $mpb_10_id;
		$mpb_10_id = null;
		$socialnet_classe =& new socialnet_mpb_mpublish();
		$cfi_classe =& new socialnet_cfi_contentfiles();
		$form['title'] = _AM_SOCIALNET_ADD;
		$form['op'] = "save";
		include XOOPS_ROOT_PATH."/modules/socialnet/include/mpb.form.author.inc.php";
		$mpb_form->display();
		break;
	case "save":
		if (!empty($mpb_10_idpai) && empty($mpb_10_id)) {
			$socialnet_classe_pai = new socialnet_mpb_mpublish($mpb_10_idpai);
			if (empty($xoopsUser) || $socialnet_classe_pai->getVar("usr_10_uid") != $xoopsUser->getVar('uid') || !$xoopsModuleConfig['socialnet_conf_cancreate']) {
				redirect_header(XOOPS_URL, 3, _AM_SOCIALNET_403);
			}
		}
		$socialnet_classe = (isset($mpb_10_id) && $mpb_10_id>0) ? new socialnet_mpb_mpublish($mpb_10_id) : new socialnet_mpb_mpublish();
		if (($socialnet_classe->getVar("mpb_10_id") != "" && !$xoopsModuleConfig['socialnet_conf_canedit']) || ($socialnet_classe->getVar("mpb_10_id") == "" && !$xoopsModuleConfig['socialnet_conf_cancreate']) || ($socialnet_classe->getVar("mpb_10_id") != "" && $socialnet_classe->getVar("usr_10_uid") != $xoopsUser->getVar('uid'))) {
			redirect_header(XOOPS_URL, 3, _AM_SOCIALNET_403);
		}
		$socialnet_classe->setVar('mpb_10_idpai', $mpb_10_idpai);
		if(empty($mpb_10_id)) $socialnet_classe->setVar('usr_10_uid', $xoopsUser->getVar('uid'));
		$socialnet_classe->setVar('mpb_30_menu', $mpb_30_menu);
		$socialnet_classe->setVar('mpb_30_title', $mpb_30_title);
		$socialnet_classe->setVar('mpb_35_content', ((isset($mpb_12_withoutlink) || isset($mpb_frame) || isset($mpb_page) || empty($mpb_35_content)) ? '' : $mpb_35_content));
		$socialnet_classe->setVar('mpb_12_withoutlink', ((isset($mpb_12_withoutlink)) ? 1 : 0));
		$mpb_30_file = (!empty($_POST['mpb_30_file'])) ? $_POST['mpb_30_file'] : ((!empty($_POST['page'])) ? $_POST['page'] : "");
		$socialnet_classe->setVar('mpb_30_file', ((isset($mpb_12_withoutlink)) ? '' : ((isset($mpb_frame)) ? $mpb_30_file_frame : ((isset($mpb_external)) ? "ext:".$mpb_30_file_external : $mpb_30_file))));
		$socialnet_classe->setVar('mpb_11_visible', $mpb_11_visible);
		$socialnet_classe->setVar('mpb_11_open', $mpb_11_open);
		$socialnet_classe->setVar('mpb_12_comments', ((isset($mpb_12_comments)) ? 1 : 0));
		$socialnet_classe->setVar('mpb_12_exibesub', ((isset($mpb_12_exibesub)) ? 1 : 0));
		$socialnet_classe->setVar('mpb_12_recommend', ((isset($mpb_12_recommend)) ? 1 : 0));
		$socialnet_classe->setVar('mpb_12_print', ((isset($mpb_12_print)) ? 1 : 0));
		if (empty($mpb_10_id)) $socialnet_classe->setVar('mpb_22_create', time());
		$socialnet_classe->setVar('mpb_22_uptodate', time());
		$socialnet_classe->setVar('mpb_10_order', ((isset($mpb_10_order) && $mpb_10_order > 0) ? (int)$mpb_10_order : 0));
		$socialnet_classe->setVar('mpb_10_counter', (($socialnet_classe->getVar('mpb_10_counter') > 0) ? $socialnet_classe->getVar('mpb_10_counter')+1 : 0));
		if (!$socialnet_classe->store()) {
			redirect_header(XOOPS_URL, 3, _AM_SOCIALNET_ERRO1);
		}else{
			if((isset($mpb_10_id) && $mpb_10_id>0)) socialnet_apagaPermissoes($mpb_10_id);
			$grupos_ids = $xoopsUser->getGroups();
			if (!in_array(XOOPS_GROUP_ADMIN, $grupos_ids)) {
				array_push($grupos_ids, XOOPS_GROUP_ADMIN);
			}
			if (!in_array(XOOPS_GROUP_ANONYMOUS, $grupos_ids)) {
				array_push($grupos_ids, XOOPS_GROUP_ANONYMOUS);
			}
			if( !empty($grupos_ids) && count($grupos_ids) > 0 ){
				socialnet_inserePermissao($socialnet_classe->getVar("mpb_10_id"),$grupos_ids);
			}
			redirect_header($socialnet_classe->pegaLink(), 3, _AM_SOCIALNET_SUCESS1);
		}
	case "editar":
		if (!$xoopsModuleConfig['socialnet_conf_canedit']) {
			redirect_header(XOOPS_URL, 3, _AM_SOCIALNET_403);
		}
		$mpb_10_idpai = $socialnet_classe->getVar('mpb_10_idpai');
		$cfi_classe =& new socialnet_cfi_contentfiles();
		$form['title'] = _AM_SOCIALNET_EPAGE;
		$form['op'] = "save";
		include XOOPS_ROOT_PATH."/modules/socialnet/include/mpb.form.author.inc.php";
		$mpb_form->display();
		break;
	case "delete":
		$mpb_10_id = (!empty($mpb_10_id)) ? $mpb_10_id : 0;
		$socialnet_classe =& new socialnet_mpb_mpublish($mpb_10_id);
		if (empty($xoopsUser) || empty($mpb_10_id) || $socialnet_classe->getVar('mpb_10_id') == '' || $socialnet_classe->getVar('usr_10_uid') != $xoopsUser->getVar('uid') || !$xoopsModuleConfig['socialnet_conf_candelete']) {
			redirect_header(XOOPS_URL, 3, _AM_SOCIALNET_403);
		}
		if($socialnet_classe->tem_subcategorias()){
			xoops_confirm(array('op' => 'delete_ok', 'mpb_10_id' => $mpb_10_id), 'treeauthor.php', sprintf(_AM_SOCIALNET_CONFIRM_DEL_SUB, $mpb_10_id, $socialnet_classe->getVar("mpb_30_menu"), $socialnet_classe->contar(new Criteria("mpb_10_idpai", $mpb_10_id))));
		}else{
			xoops_confirm(array('op' => 'delete_ok', 'mpb_10_id' => $mpb_10_id), 'treeauthor.php', sprintf(_AM_SOCIALNET_CONFIRM_DEL, $mpb_10_id, $socialnet_classe->getVar("mpb_30_menu")));
		}
		break;
	case "delete_ok":
		$mpb_10_id = (!empty($mpb_10_id)) ? $mpb_10_id : 0;
		$socialnet_classe =& new socialnet_mpb_mpublish($mpb_10_id);
		if (empty($xoopsUser) || empty($mpb_10_id) || $socialnet_classe->getVar('mpb_10_id') == '' || $socialnet_classe->getVar('usr_10_uid') != $xoopsUser->getVar('uid') || !$xoopsModuleConfig['socialnet_conf_candelete']) {
			redirect_header(XOOPS_URL, 3, _AM_SOCIALNET_403);
		}
		$socialnet_total_deletados = 0;
		socialnet_apagaPermissoes($mpb_10_id);
		$socialnet_classe->delete();
		$socialnet_total_deletados += $socialnet_classe->afetadas;
		if($socialnet_classe->tem_subcategorias()){
			socialnet_apagaPermissoesPai($mpb_10_id);
			$socialnet_classe->deletaTodos(new Criteria("mpb_10_idpai", $mpb_10_id));
			$socialnet_total_deletados += $socialnet_classe->afetadas;
		}
		redirect_header($_SERVER['PHP_SELF']."?op=list", 3,sprintf(_AM_SOCIALNET_DEL_SUCESS, $socialnet_total_deletados));
		break;
	case "list":
	default:
		$socialnet_classe = new socialnet_mpb_mpublish();
		$criterio = null;
		// Options
		$c['op'] = 'list';
		$c['form'] = 0; // 0 to exhibit the registrations in mode visualization, 1 in mode edition
		$c['precrit']['field'][1] = "usr_10_uid";
		$c['precrit']['valor'][1] = $xoopsUser->getVar('uid');
		$c['name'][1] = 'mpb_10_id';
		$c['label'][1] = _AM_SOCIALNET_MPB_10_ID;
		$c['type'][1] = "text";
		$c['size'][1] = 5;
		$c['show'][1] = '"<a href=\'".$reg->pegaLink()."\' target=\'_blank\'>".$reg->getVar($reg->id)."</a>"';

		$c['name'][2] = 'mpb_10_idpai';
		$c['label'][2] = _AM_SOCIALNET_MPB_10_IDPAI;
		$c['type'][2] = "select";
		$c['options'][2] = $socialnet_classe->geraMenuSelect();

		$c['name'][3] = 'mpb_30_menu';
		$c['label'][3] = _AM_SOCIALNET_MPB_30_MENU;
		$c['type'][3] = "text";
		$c['size'][3] = 15;

		$c['name'][4] = 'mpb_30_title';
		$c['label'][4] = _AM_SOCIALNET_MPB_30_TITLE;
		$c['type'][4] = "text";

		$c['name'][5] = 'mpb_11_visible';
		$c['label'][5] = _AM_SOCIALNET_MPB_11_VISIBLE;
		$c['type'][5] = "select";
		$c['options'][5] = array(1=>_AM_SOCIALNET_MPB_11_VISIBLE_1, 3=>_AM_SOCIALNET_MPB_11_VISIBLE_3, 2=>_AM_SOCIALNET_MPB_11_VISIBLE_2, 4=>_AM_SOCIALNET_MPB_11_VISIBLE_4);

		$c['name'][6] = 'mpb_10_order';
		$c['label'][6] = _AM_SOCIALNET_MPB_10_ORDER;
		$c['type'][6] = "text";
		$c['size'][6] = 3;

		$c['name'][7] = 'mpb_10_counter';
		$c['label'][7] = _AM_SOCIALNET_MPB_10_CONTADOR;
		$c['type'][7] = "none";

		if ($xoopsModuleConfig['socialnet_conf_cancreate']) {
			$c['buttons'][1]['link'] = XOOPS_URL.'/modules/socialnet/treeauthor.php?op=new';
			$c['buttons'][1]['image'] = '../images/icons/new.gif';
			$c['buttons'][1]['text'] = _AM_SOCIALNET_ADD;
		}
		if ($xoopsModuleConfig['socialnet_conf_canedit']) {
			$c['buttons'][2]['link'] = XOOPS_URL.'/modules/socialnet/treeauthor.php?op=editar';
			$c['buttons'][2]['image'] = '../images/icons/edit.gif';
			$c['buttons'][2]['text'] = _EDIT;
		}

		if ($xoopsModuleConfig['socialnet_conf_candelete']) {
			$c['buttons'][3]['link'] = XOOPS_URL.'/modules/socialnet/treeauthor.php?op=delete';
			$c['buttons'][3]['image'] = '../images/icons/dele.gif';
			$c['buttons'][3]['text'] = _DELETE;
		}
		// Transtation
		$c['lang']['title'] = _AM_SOCIALNET_TITLETREE;
		$c['lang']['filters'] = _AM_SOCIALNET_FILTERS;
		$c['lang']['show'] = _AM_SOCIALNET_SHOW;
		$c['lang']['showing'] = _AM_SOCIALNET_SHOWING_PAGE;
		$c['lang']['perpage'] = _AM_SOCIALNET_PORPAGE;
		$c['lang']['action'] = _AM_SOCIALNET_ACTION;
		$c['lang']['semresult'] = _AM_SOCIALNET_SEMRESULT;
		echo $socialnet_classe->administration(XOOPS_URL."/modules/socialnet/treeauthor.php", $c);
}
echo "<div align='center'><a href='http://www.ipwgc.com/socialnet/'><img src='images/socialnetLogo.png'></a></div>";
include_once XOOPS_ROOT_PATH.'/footer.php';
exit;
?>