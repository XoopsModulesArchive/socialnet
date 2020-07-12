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

switch ($op) {
	case "section_editar":
		adminmenu(13);
		$sec_10_id = (!empty($sec_10_id)) ? $sec_10_id : 0;
		$sec_classe =& spot_getClass(_MI_SOCIALNET_TABLESECSECTION, $sec_10_id);
		if (empty($sec_10_id) || $sec_classe->getVar('sec_10_id') == '') {
			redirect_header(XOOPS_URL."/modules/socialnet/admin/sec.php?op=list", 3, _AM_SOCIALNET_404);
		}
		$form['title'] = _AM_SOCIALNET_SEC_EDIT;
		$form['op'] = "salve";
		include XOOPS_ROOT_PATH."/modules/socialnet/include/sec.form.inc.php";
		$sec_form->display();
		break;
	case "section_delete":
		adminmenu();
		$sec_10_id = (!empty($sec_10_id)) ? $sec_10_id : 0;
		$sec_classe =& spot_getClass(_MI_SOCIALNET_TABLESECSECTION, $sec_10_id);
		if (empty($sec_10_id) || $sec_classe->getVar('sec_10_id') == '') {
			redirect_header(XOOPS_URL."/modules/socialnet/admin/sec.php?op=list", 3, _AM_SOCIALNET_404);
		}
		xoops_confirm(array('op' => 'section_delete_ok', 'sec_10_id' => $sec_10_id), 'sec.php', sprintf(_AM_SOCIALNET_SEC_CONFIRM_DEL, $sec_10_id, $sec_classe->getVar("sec_30_name")));
		break;
	case "section_delete_ok":
		$sec_10_id = (!empty($sec_10_id)) ? $sec_10_id : 0;
		$sec_classe =& spot_getClass(_MI_SOCIALNET_TABLESECSECTION, $sec_10_id);
		$go2_classe =& spot_getClass(_MI_SOCIALNET_TABLESPOTIMAGES);
		if (empty($sec_10_id) || $sec_classe->getVar('sec_10_id') == '') {
			redirect_header(XOOPS_URL."/modules/socialnet/admin/sec.php?list", 3, _AM_SOCIALNET_404);
		}
		$go2_classe->deletaTodos(new Criteria("sec_10_id", $sec_10_id));
		$sec_classe->delete();
		redirect_header(XOOPS_URL."/modules/socialnet/admin/sec.php?op=list", 3,_AM_SOCIALNET_SUCESS_DEL);
		break;
	case 'new':
		adminmenu();
		$sec_classe =& spot_getClass(_MI_SOCIALNET_TABLESECSECTION);
		$form['title'] = _AM_SOCIALNET_SEC_NEW;
		$form['op'] = "salve";
		include XOOPS_ROOT_PATH."/modules/socialnet/include/sec.form.inc.php";
		$sec_form->display();
		break;
	case 'salve':
		if (empty($sec_10_id)) {
			$sec_classe =& spot_getClass(_MI_SOCIALNET_TABLESECSECTION);
		}else{
			$sec_classe =& spot_getClass(_MI_SOCIALNET_TABLESECSECTION, $sec_10_id);
		}
		$sec_classe->setVar("sec_30_name", $sec_30_name);
		if ($sec_classe->getVar("sec_10_id") != "") {
			$msg = "UPD";
		}else{
			$msg = "ADD";
		}
		$error = '';
		if(!$sec_classe->store()) {
			ob_start();
			xoops_error(_AM_SOCIALNET_DB_ERROR);
			$error .= ob_get_clean();
		}else{
			redirect_header(XOOPS_URL."/modules/socialnet/admin/sec.php?op=list", 3,constant("_AM_SOCIALNET_SUCESS_".$msg));
		}
	case 'list':
	default:
		adminmenu(13);
		echo (!empty($error)) ? $error."<br />" : '';
		$sec_classe =& spot_getClass(_MI_SOCIALNET_TABLESECSECTION);
		$sec_10_id = (empty($sec_10_id)) ? null : $sec_10_id;
		// Options
		$c['op'] = 'list';
		$c['form'] = 0; // 0 for show the registrations in mode visualization, 1 in mode edition
		$c['checks'] = 0;
		$c['print'] = 0;

		$c['name'][1] = 'sec_10_id';
		$c['label'][1] = _AM_SOCIALNET_ID;
		$c['type'][1] = "text";
		$c['size'][1] = 5;
		$c['show'][1] = '$reg->getVar($reg->id)';

		$c['name'][2] = 'sec_30_name';
		$c['label'][2] = _AM_SOCIALNET_NAME;
		$c['type'][2] = "text";

		$c['name'][3] = 'destaques';
		$c['label'][3] = _AM_SOCIALNET_SPOT;
		$c['type'][3] = "none";
		$c['show'][3] = '($reg->contaDestaques() > 0) ? $reg->contaDestaques()." <a href=\''.XOOPS_URL.'/modules/socialnet/admin/spot.php?op=list_dstac&sec_10_id=".$reg->getVar($reg->id)."'.'\' title=\''._AM_SOCIALNET_SPOT.'\'><img src=\'../images/icons/view.gif\' align=\'absmiddle\' alt=\''._AM_SOCIALNET_SPOT.'\'></a>": 0;';
		$c['nosort'][3] = 1;

		$c['buttons'][1]['link'] = XOOPS_URL.'/modules/socialnet/admin/sec.php?op=section_editar';
		$c['buttons'][1]['image'] = '../images/icons/edit.gif';
		$c['buttons'][1]['text'] = _EDIT;

		$c['buttons'][2]['link'] = XOOPS_URL.'/modules/socialnet/admin/sec.php?op=section_delete';
		$c['buttons'][2]['image'] = '../images/icons/dele.gif';
		$c['buttons'][2]['text'] = _DELETE;

		// Translation
		$c['lang']['title'] = _AM_SOCIALNET_SEC_TITHE;

		echo $sec_classe->administration(XOOPS_URL."/modules/socialnet/admin/sec.php", $c);
		$sec_classe =& spot_getClass(_MI_SOCIALNET_TABLESECSECTION, $sec_10_id);
		$form['title'] = ((empty($sec_10_id)) ? _AM_SOCIALNET_SEC_NEW : _AM_SOCIALNET_SEC_EDIT);
		$form['op'] = "salve";
		include XOOPS_ROOT_PATH."/modules/socialnet/include/sec.form.inc.php";
		$sec_form->display();
		break;
}
echo "<div align='center' style='margin-top:10px'><a href='http://www.ipwgc.com/socialnet/'><img src='../images/socialnetLogo.png'></a><br /><img src='../images/menu/mailuser.gif'><a style='color: #029116; font-size:11px' href='feedback.php'>"._AM_SOCIALNET_FEEDBACK."</a> - <img src='../images/icons/mainvideo.gif'><a style='color: #FF0000; font-size:11px' href='http://www.ipwgc.com/socialnet/modules/socialnet/index.php' target='_blank'>"._AM_SOCIALNET_CHKVERSION."</a></div>";
xoops_cp_footer();
?>
