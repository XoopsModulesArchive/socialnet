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

include_once("admin_header.php");
require_once '../../../include/cp_header.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/include/common.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/admin/functions.php';
require_once XOOPS_ROOT_PATH.'/class/pagenav.php';

// *******************************************************************************
// **** Main
// *******************************************************************************

xoops_cp_header();

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
$sec_classe =& spot_getClass(_MI_SOCIALNET_TABLESECSECTION);
$sec_todos = $sec_classe->pegaTudo();
$sec_select = array();
if ($sec_todos) {
    foreach ($sec_todos as $v) {
        $sec_select[$v->getVar($v->id)] = $v->getVar("sec_30_name");
    }
}
if (!empty($_POST['group_action'])) {
    switch ($_POST['group_action']){
        case "group_del":
            if (is_array($_POST['checks'])) {
                foreach ($_POST['checks'] as $k => $v) {
                    $go2_classe =& spot_getClass(_MI_SOCIALNET_TABLESPOTIMAGES, $k);
                    $go2_classe->delete();
                }
            }
            redirect_header(XOOPS_URL."/modules/socialnet/admin/spot.php?op=list", 3,_AM_SOCIALNET_SUCESS_UPD);
            break;

        case "zera_count":
            if (is_array($_POST['checks'])) {
                foreach ($_POST['checks'] as $k => $v) {
                    $go2_classe =& spot_getClass(_MI_SOCIALNET_TABLESPOTIMAGES, $k);
                    $go2_classe->setVar("spot_10_access", 0);
                    $go2_classe->store();
                }
            }
            redirect_header(XOOPS_URL."/modules/socialnet/admin/spot.php?op=list", 3,_AM_SOCIALNET_SUCESS_UPD);
            break;

        case "deactivate":
            if (is_array($_POST['checks'])) {
                foreach ($_POST['checks'] as $k => $v) {
                    $go2_classe =& spot_getClass(_MI_SOCIALNET_TABLESPOTIMAGES, $k);
                    $go2_classe->desativar();
                }
            }
            redirect_header(XOOPS_URL."/modules/socialnet/admin/spot.php?op=list", 3,_AM_SOCIALNET_SUCESS_UPD);
            break;
        case "ativa":
        default:
            if (is_array($_POST['checks'])) {
                foreach ($_POST['checks'] as $k => $v) {
                    $go2_classe =& spot_getClass(_MI_SOCIALNET_TABLESPOTIMAGES, $k);
                    $go2_classe->ativar();
                }
            }
            redirect_header(XOOPS_URL."/modules/socialnet/admin/spot.php?op=list", 3,_AM_SOCIALNET_SUCESS_UPD);
            break;
    }
}
switch ($op) {
    case "ativar":
        $spot_10_id = (!empty($spot_10_id)) ? $spot_10_id : 0;
        $go2_classe =& spot_getClass(_MI_SOCIALNET_TABLESPOTIMAGES, $spot_10_id);
        if (empty($spot_10_id) || $go2_classe->getVar('spot_10_id') == '') {
            redirect_header(XOOPS_URL."/modules/socialnet/admin/spot.php?list", 3, _AM_SOCIALNET_404);
        }
        $go2_classe->ativar();
        redirect_header(XOOPS_URL."/modules/socialnet/admin/spot.php?op=list", 3,_AM_SOCIALNET_SUCESS_UPD);
        break;
    case "desativar":
        $spot_10_id = (!empty($spot_10_id)) ? $spot_10_id : 0;
        $go2_classe =& spot_getClass(_MI_SOCIALNET_TABLESPOTIMAGES, $spot_10_id);
        if (empty($spot_10_id) || $go2_classe->getVar('spot_10_id') == '') {
            redirect_header(XOOPS_URL."/modules/socialnet/admin/spot.php?list", 1, _AM_SOCIALNET_404);
        }
        $go2_classe->desativar();
        redirect_header(XOOPS_URL."/modules/socialnet/admin/spot.php?op=list", 1,_AM_SOCIALNET_SUCESS_UPD);
        break;
    case "dstac_editar":
        adminmenu(14);
        $spot_10_id = (!empty($spot_10_id)) ? $spot_10_id : 0;
        $go2_classe =& spot_getClass(_MI_SOCIALNET_TABLESPOTIMAGES, $spot_10_id);
        if (empty($spot_10_id) || $go2_classe->getVar('spot_10_id') == '') {
            redirect_header(XOOPS_URL."/modules/socialnet/admin/spot.php?op=list", 3, _AM_SOCIALNET_404);
        }
        $form['title'] = _AM_SOCIALNET_SPOT_EDIT;
        $form['op'] = "salve";
        include XOOPS_ROOT_PATH."/modules/socialnet/include/spotimage.form.inc.php";
        $go2_form->display();
        break;
    case "dstac_delete":
        adminmenu(14);
        $spot_10_id = (!empty($spot_10_id)) ? $spot_10_id : 0;
        $go2_classe =& spot_getClass(_MI_SOCIALNET_TABLESPOTIMAGES, $spot_10_id);
        if (empty($spot_10_id) || $go2_classe->getVar('spot_10_id') == '') {
            redirect_header(XOOPS_URL."/modules/socialnet/admin/spot.php?op=list", 3, _AM_SOCIALNET_404);
        }
        xoops_confirm(array('op' => 'dstac_delete_ok', 'spot_10_id' => $spot_10_id), 'spot.php', sprintf(_AM_SOCIALNET_SPOT_CONFIRM_DEL, $spot_10_id, $go2_classe->getVar("spot_30_name")));
        break;
    case "dstac_delete_ok":
        $spot_10_id = (!empty($spot_10_id)) ? $spot_10_id : 0;
        $go2_classe =& spot_getClass(_MI_SOCIALNET_TABLESPOTIMAGES, $spot_10_id);
        if (empty($spot_10_id) || $go2_classe->getVar('spot_10_id') == '') {
            redirect_header(XOOPS_URL."/modules/socialnet/admin/spot.php?list", 3, _AM_SOCIALNET_404);
        }
        $go2_classe->delete();
        redirect_header(XOOPS_URL."/modules/socialnet/admin/spot.php?op=list", 3,_AM_SOCIALNET_SUCESS_DEL);
        break;
    case 'new':
        adminmenu(14);
        $go2_classe =& spot_getClass(_MI_SOCIALNET_TABLESPOTIMAGES);
        $form['title'] = _AM_SOCIALNET_SPOT_NEW;
        $form['op'] = "salve";
        include XOOPS_ROOT_PATH."/modules/socialnet/include/spotimage.form.inc.php";
        $go2_form->display();
        break;
    case 'salve':
        if (empty($spot_10_id)) {
            $go2_classe =& spot_getClass(_MI_SOCIALNET_TABLESPOTIMAGES);
        }else{
            $go2_classe =& spot_getClass(_MI_SOCIALNET_TABLESPOTIMAGES, $spot_10_id);
        }
        $go2_classe->setVar("sec_10_id", $sec_10_id);
        $go2_classe->setVar("spot_30_name", $spot_30_name);
        $go2_classe->setVar("spot_30_link", $spot_30_link);
        $go2_classe->setVar("spot_11_target", $spot_11_target);
        $go2_classe->setVar("spot_30_image", $spot_30_image);
        if ($go2_classe->getVar("spot_10_id") != "") {
            $msg = "UPD";
        }else{
            $msg = "ADD";
        }
        $go2_classe->setVar("spot_12_ative", $spot_12_ative);
        $error = '';
        if(!$go2_classe->store()) {
            ob_start();
            xoops_error(_AM_SOCIALNET_DB_ERROR);
            $error .= ob_get_clean();
        }else{
            redirect_header(XOOPS_URL."/modules/socialnet/admin/spot.php?op=list", 3,constant("_AM_SOCIALNET_SUCESS_".$msg));
        }
    case 'list_dstac':
        adminmenu(14);
        echo (!empty($error)) ? $error."<br />" : '';
        $go2_classe =& spot_getClass(_MI_SOCIALNET_TABLESPOTIMAGES);
        $spot_10_id = (empty($spot_10_id)) ? null : $spot_10_id;
        if (!empty($_REQUEST['sec_10_id'])) {
            $sec_10_id = $_REQUEST['sec_10_id'];
            $_SESSION['list_sec_sec_10_id'] = $_REQUEST['sec_10_id'];
            $sec_classe =& spot_getClass(_MI_SOCIALNET_TABLESECSECTION, $sec_10_id);
        }elseif (!empty($_SESSION['list_sec_sec_10_id'])){
            $sec_10_id = $_SESSION['list_sec_sec_10_id'];
            $sec_classe =& spot_getClass(_MI_SOCIALNET_TABLESECSECTION, $sec_10_id);
        }else{
            redirect_header(XOOPS_URL."/modules/socialnet/admin/spot.php?op=list", 3, _AM_SOCIALNET_404);
        }
        if ($sec_classe->getVar('sec_10_id') == '') {
            redirect_header(XOOPS_URL."/modules/socialnet/admin/spot.php?op=list", 3, _AM_SOCIALNET_404);
        }
        // Options
        $c['op'] = 'list_dstac';
        $c['form'] = 0; // 0 for show the registrations in mode visualization, 1 in mode edition
        $c['checks'] = 1;
        $c['print'] = 0;
        $c['group_del'] = 1;

        $c['precrit']['field'][1] = "sec_10_id";
        $c['precrit']['valor'][1] = $sec_10_id;

        $c['name'][1] = 'spot_10_id';
        $c['label'][1] = _AM_SOCIALNET_ID;
        $c['type'][1] = "text";
        $c['size'][1] = 5;
        $c['show'][1] = '$reg->getVar($reg->id)';

        $c['name'][2] = 'spot_30_image';
        $c['label'][2] = _AM_SOCIALNET_IMAGE;
        $c['type'][2] = "none";
        $c['nosort'][2] = 1;
        $c['show'][2] = '"<img src=\'".$reg->pegaImagem()."\' style=\'max-width:200px\'>"';

        $c['name'][3] = 'spot_30_name';
        $c['label'][3] = _AM_SOCIALNET_SPOT_30_NAME;
        $c['type'][3] = "text";

        $c['name'][4] = 'spot_30_link';
        $c['label'][4] = _AM_SOCIALNET_SPOT_30_LINK;
        $c['type'][4] = "text";
        $c['show'][4] = '$reg->pegaLink()';

        $c['name'][5] = 'spot_10_access';
        $c['label'][5] = _AM_SOCIALNET_SPOT_10_ACCESS;
        $c['type'][5] = "none";

        $c['name'][6] = 'spot_12_ative';
        $c['label'][6] = _AM_SOCIALNET_SPOT_ACTIVE;
        $c['type'][6] = "simnao";
        $c['show'][6] = '($reg->getVar("spot_12_ative") == 0) ? "<a href=\'spot.php?op=ativar&spot_10_id=".$reg->getVar($reg->id)."\'><img src=\'../images/icons/green_off.gif\' align=\'absmiddle\'></a> <img src=\'../images/icons/red.gif\' align=\'absmiddle\'>" : "<img src=\'../images/icons/green.gif\' align=\'absmiddle\'> <a href=\'spot.php?op=desativar&spot_10_id=".$reg->getVar($reg->id)."\'><img src=\'../images/icons/red_off.gif\' align=\'absmiddle\'></a>"';

        $c['buttons'][1]['link'] = XOOPS_URL.'/modules/socialnet/admin/spot.php?op=dstac_editar';
        $c['buttons'][1]['image'] = '../images/icons/edit.gif';
        $c['buttons'][1]['text'] = _EDIT;

        $c['buttons'][2]['link'] = XOOPS_URL.'/modules/socialnet/admin/spot.php?op=dstac_delete';
        $c['buttons'][2]['image'] = '../images/icons/dele.gif';
        $c['buttons'][2]['text'] = _DELETE;

        $c['group_action'][1]['text'] = _AM_SOCIALNET_SPOT_ACTIVATE_SEL;
        $c['group_action'][1]['valor'] = "ativa";
        $c['group_action'][2]['text'] = _AM_SOCIALNET_SPOT_DEACTIVATE_SEL;
        $c['group_action'][2]['valor'] = "deactivate";
        $c['group_action'][3]['text'] = _AM_SOCIALNET_SPOT_ZERA_COUNT;
        $c['group_action'][3]['valor'] = "zera_count";

        // Translation
        $c['lang']['title'] = _AM_SOCIALNET_SPOT_TITHE." -> <span style='color:red'>".$sec_classe->getVar("sec_30_name")."</span>";

        echo $go2_classe->administration(XOOPS_URL."/modules/socialnet/admin/spot.php", $c);
        $go2_classe =& spot_getClass(_MI_SOCIALNET_TABLESPOTIMAGES, $spot_10_id);
        $form['title'] = ((empty($spot_10_id)) ? _AM_SOCIALNET_SPOT_NEW : _AM_SOCIALNET_SPOT_EDIT);
        $form['op'] = "salve";
        $sec_classe->setVar("sec_10_id", 0);
        include XOOPS_ROOT_PATH."/modules/socialnet/include/spotimage.form.inc.php";
        $go2_form->display();
        break;

    case 'list':
    default:
        adminmenu(14);
        echo (!empty($error)) ? $error."<br />" : '';
        $go2_classe =& spot_getClass(_MI_SOCIALNET_TABLESPOTIMAGES);
        $spot_10_id = (empty($spot_10_id)) ? null : $spot_10_id;
        // Options
        $c['op'] = 'list';
        $c['form'] = 0; // 0 for show the registrations in mode visualization, 1 in mode edition
        $c['checks'] = 1;
        $c['print'] = 0;
        $c['group_del'] = 1;

        $c['name'][1] = 'spot_10_id';
        $c['label'][1] = _AM_SOCIALNET_ID;
        $c['type'][1] = "text";
        $c['size'][1] = 5;
        $c['show'][1] = '$reg->getVar($reg->id)';

        $c['name'][2] = 'spot_30_image';
        $c['label'][2] = _AM_SOCIALNET_IMAGE;
        $c['type'][2] = "none";
        $c['nosort'][2] = 1;
        $c['show'][2] = '"<img src=\'".$reg->pegaImagem()."\' style=\'max-width:200px\'>"';

        $c['name'][3] = 'sec_10_id';
        $c['label'][3] = _AM_SOCIALNET_SECTION;
        $c['type'][3] = "select";
        $c['options'][3] = $sec_select;

        $c['name'][4] = 'spot_30_name';
        $c['label'][4] = _AM_SOCIALNET_SPOT_30_NAME;
        $c['type'][4] = "text";

        $c['name'][5] = 'spot_30_link';
        $c['label'][5] = _AM_SOCIALNET_SPOT_30_LINK;
        $c['type'][5] = "text";
        $c['show'][5] = '$reg->pegaLink()';

        $c['name'][6] = 'spot_10_access';
        $c['label'][6] = _AM_SOCIALNET_SPOT_10_ACCESS;
        $c['type'][6] = "none";

        $c['name'][7] = 'spot_12_ative';
        $c['label'][7] = _AM_SOCIALNET_SPOT_ACTIVE;
        $c['type'][7] = "simnao";
        $c['show'][7] = '($reg->getVar("spot_12_ative") == 0) ? "<a href=\'spot.php?op=ativar&spot_10_id=".$reg->getVar($reg->id)."\'><img src=\'../images/icons/green_off.gif\' align=\'absmiddle\'></a> <img src=\'../images/icons/red.gif\' align=\'absmiddle\'>" : "<img src=\'../images/icons/green.gif\' align=\'absmiddle\'> <a href=\'spot.php?op=desativar&spot_10_id=".$reg->getVar($reg->id)."\'><img src=\'../images/icons/red_off.gif\' align=\'absmiddle\'></a>"';

        $c['buttons'][1]['link'] = XOOPS_URL.'/modules/socialnet/admin/spot.php?op=dstac_editar';
        $c['buttons'][1]['image'] = '../images/icons/edit.gif';
        $c['buttons'][1]['text'] = _EDIT;

        $c['buttons'][2]['link'] = XOOPS_URL.'/modules/socialnet/admin/spot.php?op=dstac_delete';
        $c['buttons'][2]['image'] = '../images/icons/dele.gif';
        $c['buttons'][2]['text'] = _DELETE;

        $c['group_action'][1]['text'] = _AM_SOCIALNET_SPOT_ACTIVATE_SEL;
        $c['group_action'][1]['valor'] = "ativa";
        $c['group_action'][2]['text'] = _AM_SOCIALNET_SPOT_DEACTIVATE_SEL;
        $c['group_action'][2]['valor'] = "deactivate";
        $c['group_action'][3]['text'] = _AM_SOCIALNET_SPOT_ZERA_COUNT;
        $c['group_action'][3]['valor'] = "zera_count";


        // Translation
        $c['lang']['title'] = _AM_SOCIALNET_SPOT_TITHE;

        echo $go2_classe->administration(XOOPS_URL."/modules/socialnet/admin/spot.php", $c);
        $go2_classe =& spot_getClass(_MI_SOCIALNET_TABLESPOTIMAGES, $spot_10_id);
        $form['title'] = ((empty($spot_10_id)) ? _AM_SOCIALNET_SPOT_NEW : _AM_SOCIALNET_SPOT_EDIT);
        $form['op'] = "salve";
        include XOOPS_ROOT_PATH."/modules/socialnet/include/spotimage.form.inc.php";
        $go2_form->display();
        break;
}
echo "<div align='center' style='margin-top:10px'><a href='http://www.ipwgc.com/socialnet/'><img src='../images/socialnetLogo.png'></a><br /><img src='../images/menu/mailuser.gif'><a style='color: #029116; font-size:11px' href='feedback.php'>"._AM_SOCIALNET_FEEDBACK."</a> - <img src='../images/icons/mainvideo.gif'><a style='color: #FF0000; font-size:11px' href='http://www.ipwgc.com/socialnet/modules/socialnet/index.php' target='_blank'>"._AM_SOCIALNET_CHKVERSION."</a></div>";
xoops_cp_footer();
?>