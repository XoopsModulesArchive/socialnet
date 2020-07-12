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

include_once 'admin_header.php';
require_once '../../../include/cp_header.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/include/common.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/admin/functions.php';
require_once XOOPS_ROOT_PATH.'/class/pagenav.php';
xoops_cp_header();

// *******************************************************************************
// **** Main
// *******************************************************************************

$op = (isset($_GET['op'])) ? $_GET['op'] : 'list';
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
switch ($op){
    case "limpacont":
        $mpb_10_id = (!empty($mpb_10_id)) ? $mpb_10_id : 0;
        $socialnet_classe =& new socialnet_mpb_mpublish($mpb_10_id);
        if (empty($mpb_10_id) || $socialnet_classe->getVar('mpb_10_id') == '') {
            redirect_header(XOOPS_URL."/modules/socialnet/admin/treemenu.php", 3, _AM_SOCIALNET_ERRO2);
        }
        adminmenu();
        xoops_confirm(array('op' => 'limpacont_ok', 'mpb_10_id' => $mpb_10_id), 'treemenu.php', sprintf(_AM_SOCIALNET_CONFIRM_LIMPACONT, $mpb_10_id, $socialnet_classe->getVar("mpb_30_menu")));
        break;

    case "limpacont_ok":
        $mpb_10_id = (!empty($mpb_10_id)) ? $mpb_10_id : 0;
        $socialnet_classe =& new socialnet_mpb_mpublish($mpb_10_id);
        if (empty($mpb_10_id) || $socialnet_classe->getVar('mpb_10_id') == '') {
            redirect_header(XOOPS_URL."/modules/socialnet/admin/treemenu.php", 3, _AM_SOCIALNET_ERRO2);
        }
        $socialnet_classe->setVar("mpb_10_counter", 0);
        $socialnet_classe->setVar("mpb_22_uptodate", time());
        if (!$socialnet_classe->store()) {
            redirect_header(XOOPS_URL."/modules/socialnet/admin/treemenu.php", 3, _AM_SOCIALNET_ERRO1);
        }else{
            redirect_header(XOOPS_URL."/modules/socialnet/admin/treemenu.php?op=list_editar&mpb_10_id=".$mpb_10_id, 3, _AM_SOCIALNET_SUCESS1);
        }
        break;
    case "new":
        adminmenu(16);
        $mpb_10_id = null;
        $socialnet_classe =& new socialnet_mpb_mpublish($mpb_10_id);
        $cfi_classe =& new socialnet_cfi_contentfiles();
        $form['title'] = _AM_SOCIALNET_ADD;
        $form['op'] = "save";
        include XOOPS_ROOT_PATH."/modules/socialnet/include/mpb.form.inc.php";
        $mpb_form->display();
        break;
    case "save":
        $socialnet_classe = (isset($mpb_10_id) && $mpb_10_id>0) ? new socialnet_mpb_mpublish($mpb_10_id) : new socialnet_mpb_mpublish();
        $socialnet_classe->setVar('mpb_10_idpai', $mpb_10_idpai);
        $socialnet_classe->setVar('usr_10_uid', (empty($usr_10_uid) ? $xoopsUser->getVar('uid') : $usr_10_uid));
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
            redirect_header(XOOPS_URL."/modules/socialnet/admin/treemenu.php", 3, _AM_SOCIALNET_ERRO1);
        }else{
            if((isset($mpb_10_id) && $mpb_10_id>0)) socialnet_apagaPermissoes($mpb_10_id);
            if( !empty($grupos_perm) && count($grupos_perm) > 0 ){
                socialnet_inserePermissao($socialnet_classe->getVar("mpb_10_id"),$grupos_perm);
            }
            redirect_header(XOOPS_URL."/modules/socialnet/admin/treemenu.php", 3, _AM_SOCIALNET_SUCESS1);
        }
        break;
    case "list_clone":
        $mpb_10_id = (!empty($mpb_10_id)) ? $mpb_10_id : 0;
        $socialnet_classe =& new socialnet_mpb_mpublish($mpb_10_id);
        if (empty($mpb_10_id) || $socialnet_classe->getVar('mpb_10_id') == '') {
            redirect_header(XOOPS_URL."/modules/socialnet/admin/treemenu.php", 3, _AM_SOCIALNET_ERRO2);
        }
        adminmenu();
        xoops_confirm(array('op' => 'list_clone_ok', 'mpb_10_id' => $mpb_10_id), 'treemenu.php', sprintf(_AM_SOCIALNET_CONFIRM_CLONE, $mpb_10_id, $socialnet_classe->getVar("mpb_30_menu")));
        break;
    case "list_clone_ok":
        $socialnet_classe = (isset($mpb_10_id) && $mpb_10_id>0) ? new socialnet_mpb_mpublish($mpb_10_id) : new socialnet_mpb_mpublish();
        $grupos_ids = $moduleperm_handler->getGroupIds("socialnet_mpublish_acesso", $mpb_10_id, $xoopsModule->getVar('mid'));
        if ($socialnet_classe->getVar("mpb_10_id") > 0) {
            $socialnet_classe->setVar('mpb_10_id', 0);
            $socialnet_classe->setVar('mpb_30_menu', _AM_SOCIALNET_CLONE.$socialnet_classe->getVar("mpb_30_menu"));
            if (!$socialnet_classe->store()) {
                redirect_header(XOOPS_URL."/modules/socialnet/admin/treemenu.php", 3, _AM_SOCIALNET_ERRO1);
            }else{
                socialnet_inserePermissao($socialnet_classe->getVar("mpb_10_id"),$grupos_ids);
                redirect_header(XOOPS_URL."/modules/socialnet/admin/treemenu.php", 3, _AM_SOCIALNET_SUCESS1);
            }
        }else{
            redirect_header(XOOPS_URL."/modules/socialnet/admin/treemenu.php", 3, _AM_SOCIALNET_ERRO2);
        }
        break;
    case "list_editar":
        adminmenu(16);
        $mpb_10_id = (!empty($mpb_10_id)) ? $mpb_10_id : 0;
        $socialnet_classe =& new socialnet_mpb_mpublish($mpb_10_id);
        $cfi_classe =& new socialnet_cfi_contentfiles();
        if (empty($mpb_10_id) || $socialnet_classe->getVar('mpb_10_id') == '') {
            redirect_header(XOOPS_URL."/modules/socialnet/admin/treemenu.php", 3, _AM_SOCIALNET_ERRO2);
        }
        $form['title'] = _AM_SOCIALNET_EPAGE;
        $form['op'] = "save";
        include XOOPS_ROOT_PATH."/modules/socialnet/include/mpb.form.inc.php";
        $mpb_form->display();
        break;
    case "list_delete":
        $mpb_10_id = (!empty($mpb_10_id)) ? $mpb_10_id : 0;
        $socialnet_classe =& new socialnet_mpb_mpublish($mpb_10_id);
        if (empty($mpb_10_id) || $socialnet_classe->getVar('mpb_10_id') == '') {
            redirect_header(XOOPS_URL."/modules/socialnet/admin/treemenu.php", 3, _AM_SOCIALNET_ERRO2);
        }
        if($socialnet_classe->tem_subcategorias()){
            adminmenu();
            xoops_confirm(array('op' => 'list_delete_ok', 'mpb_10_id' => $mpb_10_id), 'treemenu.php', sprintf(_AM_SOCIALNET_CONFIRM_DEL_SUB, $mpb_10_id, $socialnet_classe->getVar("mpb_30_menu"), $socialnet_classe->contar(new Criteria("mpb_10_idpai", $mpb_10_id))));
        }else{
            adminmenu();
            xoops_confirm(array('op' => 'list_delete_ok', 'mpb_10_id' => $mpb_10_id), 'treemenu.php', sprintf(_AM_SOCIALNET_CONFIRM_DEL, $mpb_10_id, $socialnet_classe->getVar("mpb_30_menu")));
        }
        break;
    case "list_delete_ok":
        $mpb_10_id = (!empty($mpb_10_id)) ? $mpb_10_id : 0;
        $socialnet_classe =& new socialnet_mpb_mpublish($mpb_10_id);
        if (empty($mpb_10_id) || $socialnet_classe->getVar('mpb_10_id') == '') {
            redirect_header(XOOPS_URL."/modules/socialnet/admin/treemenu.php", 3, _AM_SOCIALNET_ERRO2);
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
        redirect_header(XOOPS_URL."/modules/socialnet/admin/treemenu.php", 3,sprintf(_AM_SOCIALNET_DEL_SUCESS, $socialnet_total_deletados));
        break;
    case "list_all":
        if(empty($_POST['fields'])){
            adminmenu(17);
            $socialnet_classe = new socialnet_mpb_mpublish();
            $criterio = null;
            // Options
            $c['op'] = 'list_all';
            $c['form'] = 1; // 0 to exhibit the registrations in mode visualization, 1 in mode edition
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

            $c['buttons'][1]['link'] = XOOPS_URL.'/modules/socialnet/admin/treemenu.php?op=list_editar';
            $c['buttons'][1]['image'] = '../images/icons/edit.gif';
            $c['buttons'][1]['text'] = _EDIT;

            $c['buttons'][2]['link'] = XOOPS_URL.'/modules/socialnet/admin/treemenu.php?op=list_delete';
            $c['buttons'][2]['image'] = '../images/icons/dele.gif';
            $c['buttons'][2]['text'] = _DELETE;

            // Translation
            $c['lang']['title'] = _AM_SOCIALNET_TITLE;
            $c['lang']['filters'] = _AM_SOCIALNET_FILTERS;
            $c['lang']['show'] = _AM_SOCIALNET_SHOW;
            $c['lang']['showing'] = _AM_SOCIALNET_SHOWING_PAGE;
            $c['lang']['perpage'] = _AM_SOCIALNET_PORPAGE;
            $c['lang']['action'] = _AM_SOCIALNET_ACTION;
            $c['lang']['semresult'] = _AM_SOCIALNET_SEMRESULT;
            echo $socialnet_classe->administration(XOOPS_URL."/modules/socialnet/admin/treemenu.php", $c);
            echo "<img src='../images/icons/closed.gif'><a href='".XOOPS_URL."/modules/socialnet/admin/treemenu.php?op=list' style='padding:3px; border:5px double #FFFFFF; background-color: #00950F; color: #FFFFFF'>"._AM_SOCIALNET_SHOW_NESTED_MODE."</a>";
			echo "&nbsp;&nbsp;";
			echo "<img src='../images/icons/open.gif'><a  href='".XOOPS_URL."/modules/socialnet/admin/treemenu.php?op=new' style='padding:3px; border:5px double #FFFFFF; background-color: #00950F; color: #FFFFFF'>"._AM_SOCIALNET_ADD."</a>";

        }else{
            foreach ($_POST['fields'] as $k=>$v) {
                $socialnet_classe = new socialnet_mpb_mpublish($k);
                $socialnet_classe->assignVars($v);
                $socialnet_classe->store();
            }
            redirect_header(XOOPS_URL."/modules/socialnet/admin/treemenu.php?op=list_all", 3, _AM_SOCIALNET_SUCESS2);
        }
        break;
    case "list":
    default:
        if(empty($_POST['fields'])){
            adminmenu(17);
            $criterio = null;
            if (isset($_REQUEST['mpb_10_id'])) {
                $mpb_10_id = $_REQUEST['mpb_10_id'];
                $_SESSION['list_socialnet_mpb_10_id'] = $_REQUEST['mpb_10_id'];
                $socialnet_classe = new socialnet_mpb_mpublish($mpb_10_id);
            }elseif (!empty($_SESSION['list_socialnet_mpb_10_id'])){
                $mpb_10_id = $_SESSION['list_socialnet_mpb_10_id'];
                $socialnet_classe = new socialnet_mpb_mpublish($mpb_10_id);
            }else{
                $mpb_10_id = 0;
                $socialnet_classe = new socialnet_mpb_mpublish();
            }
            // Opções
            $c['op'] = 'list';
            $c['form'] = 1; // 0 to exhibit the registrations in mode visualization, 1 in mode edition
            $c['precrit']['field'][1] = "mpb_10_idpai";
            $c['precrit']['valor'][1] = $mpb_10_id;
            if ($mpb_10_id == 0) {
                $c['precrit']['operador'][1] = "<=";
            }

            $c['name'][1] = 'mpb_10_id';
            $c['label'][1] = _AM_SOCIALNET_MPB_10_ID;
            $c['type'][1] = "text";
            $c['size'][1] = 5;
            $c['show'][1] = '"<a href=\'".$reg->pegaLink()."\' target=\'_blank\'>".$reg->getVar($reg->id)."</a>"';

            $c['name'][2] = 'mpb_30_menu';
            $c['label'][2] = _AM_SOCIALNET_MPB_30_MENU;
            $c['type'][2] = "text";
            $c['size'][2] = 15;

            $c['name'][3] = 'mpb_30_title';
            $c['label'][3] = _AM_SOCIALNET_MPB_30_TITLE;
            $c['type'][3] = "text";

            $c['name'][4] = 'mpb_11_visible';
            $c['label'][4] = _AM_SOCIALNET_MPB_11_VISIBLE;
            $c['type'][4] = "select";
            $c['options'][4] = array(1=>_AM_SOCIALNET_MPB_11_VISIBLE_1, 3=>_AM_SOCIALNET_MPB_11_VISIBLE_3, 2=>_AM_SOCIALNET_MPB_11_VISIBLE_2, 4=>_AM_SOCIALNET_MPB_11_VISIBLE_4);

            $c['name'][5] = 'mpb_10_order';
            $c['label'][5] = _AM_SOCIALNET_MPB_10_ORDER;
            $c['type'][5] = "text";
            $c['size'][5] = 3;

            $c['name'][6] = 'subpages';
            $c['label'][6] = _AM_SOCIALNET_SUBS;
            $c['type'][6] = "none";
            $c['show'][6] = '($mySubs = $reg->countSubs()) ? $mySubs." <a href=\''.XOOPS_URL.'/modules/socialnet/admin/treemenu.php?op=list&mpb_10_id=".$reg->getVar($reg->id)."'.'\' title=\''._AM_SOCIALNET_SHOWSUBS.'\'><img src=\'../images/icons/view.gif\' align=\'absmiddle\' alt=\''._AM_SOCIALNET_SHOWSUBS.'\'></a>": 0;';
            $c['nosort'][6] = 1;

            $c['name'][7] = 'mpb_10_counter';
            $c['label'][7] = _AM_SOCIALNET_MPB_10_CONTADOR;
            $c['type'][7] = "none";

            $c['buttons'][1]['link'] = XOOPS_URL.'/modules/socialnet/admin/treemenu.php?op=list_editar';
            $c['buttons'][1]['image'] = '../images/icons/edit.gif';
            $c['buttons'][1]['text'] = _EDIT;

            $c['buttons'][2]['link'] = XOOPS_URL.'/modules/socialnet/admin/treemenu.php?op=list_clone';
            $c['buttons'][2]['image'] = '../images/icons/clone.gif';
            $c['buttons'][2]['text'] = _CLONE;

            $c['buttons'][3]['link'] = XOOPS_URL.'/modules/socialnet/admin/treemenu.php?op=list_delete';
            $c['buttons'][3]['image'] = '../images/icons/dele.gif';
            $c['buttons'][3]['text'] = _DELETE;

            // Translation
            $c['lang']['title'] = _AM_SOCIALNET_TITLE."<br /><div style='font-weight:normal; font-size:11px'>".$socialnet_classe->geraNavigationAdmin($mpb_10_id)."</div>";
            $c['lang']['filters'] = _AM_SOCIALNET_FILTERS;
            $c['lang']['show'] = _AM_SOCIALNET_SHOW;
            $c['lang']['showing'] = _AM_SOCIALNET_SHOWING_PAGE;
            $c['lang']['perpage'] = _AM_SOCIALNET_PORPAGE;
            $c['lang']['action'] = _AM_SOCIALNET_ACTION;
            $c['lang']['semresult'] = _AM_SOCIALNET_SEMRESULT;
            echo $socialnet_classe->administration(XOOPS_URL."/modules/socialnet/admin/treemenu.php", $c);
            echo "<img src='../images/icons/closed.gif'><a href='".XOOPS_URL."/modules/socialnet/admin/treemenu.php?op=list_all' style='padding:3px; border:5px double #FFFFFF; background-color: #00950F; color: #FFFFFF'>"._AM_SOCIALNET_SHOW_INLINE_MODE."</a>";
			echo "&nbsp;&nbsp;";
			echo "<img src='../images/icons/open.gif'><a  href='".XOOPS_URL."/modules/socialnet/admin/treemenu.php?op=new' style='padding:3px; border:5px double #FFFFFF; background-color: #00950F; color: #FFFFFF' >"._AM_SOCIALNET_ADD."</a>";

        }else{
            foreach ($_POST['fields'] as $k=>$v) {
                $socialnet_classe = new socialnet_mpb_mpublish($k);
                $socialnet_classe->assignVars($v);
                $socialnet_classe->store();
            }
            redirect_header(XOOPS_URL."/modules/socialnet/admin/treemenu.php?op=list", 3, _AM_SOCIALNET_SUCESS2);
        }

}
echo "<br>";
echo "<br>";
echo "<div align='center' style='margin-top:10px'><a href='http://www.ipwgc.com/socialnet/'><img src='../images/socialnetLogo.png'></a><br /><img src='../images/menu/mailuser.gif'><a style='color: #029116; font-size:11px' href='feedback.php'>"._AM_SOCIALNET_FEEDBACK."</a> - <img src='../images/icons/mainvideo.gif'><a style='color: #FF0000; font-size:11px' href='http://www.ipwgc.com/socialnet/modules/socialnet/index.php' target='_blank'>"._AM_SOCIALNET_CHKVERSION."</a></div>";
xoops_cp_footer();
?>
