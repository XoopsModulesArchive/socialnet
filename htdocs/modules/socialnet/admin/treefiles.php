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


$op = (isset($_GET['op'])) ? $_GET['op'] : 'files';
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
	case "files_editar":
		adminmenu(19);
		$fil_10_id = (!empty($fil_10_id)) ? $fil_10_id : 0;
		$fil_classe =& new socialnet_fil_files($fil_10_id);
		if (empty($fil_10_id) || $fil_classe->getVar('fil_10_id') == '') {
			redirect_header(XOOPS_URL."/modules/socialnet/admin/treefiles.php", 3, _AM_SOCIALNET_ERRO_FIL404);
		}
		$form['title'] = _AM_SOCIALNET_EFILE;
		$form['op'] = "save";
		include XOOPS_ROOT_PATH."/modules/socialnet/include/fil.form.inc.php";
		$fil_form->display();
		break;
	case "files_delete":
		adminmenu(19);
		$fil_10_id = (!empty($fil_10_id)) ? $fil_10_id : 0;
		$fil_classe =& new socialnet_fil_files($fil_10_id);
		if (empty($fil_10_id) || $fil_classe->getVar('fil_10_id') == '') {
			redirect_header(XOOPS_URL."/modules/socialnet/admin/treefiles.php", 3, _AM_SOCIALNET_ERRO_FIL404);
		}
		xoops_confirm(array('op' => 'files_delete_ok', 'fil_10_id' => $fil_10_id), 'treefiles.php', sprintf(_AM_SOCIALNET_CONFIRM_DELFIL, $fil_10_id, $fil_classe->getVar("fil_30_name")));
		break;
	case "files_delete_ok":
		$fil_10_id = (!empty($fil_10_id)) ? $fil_10_id : 0;
		$fil_classe =& new socialnet_fil_files($fil_10_id);
		if (empty($fil_10_id) || $fil_classe->getVar('fil_10_id') == '') {
			redirect_header(XOOPS_URL."/modules/socialnet/admin/treefiles.php", 3, _AM_SOCIALNET_ERRO_FIL404);
		}
		$fil_classe->delete();
		$fil_classe->deletaArquivo();
		redirect_header(XOOPS_URL."/modules/socialnet/admin/treefiles.php", 3,_AM_SOCIALNET_DELFIL_SUCESS);
		break;

	case 'files_adicionar':
		adminmenu(19);
		$fil_classe =& new socialnet_fil_files();
		$form['title'] = _AM_SOCIALNET_NFILE;
		$form['op'] = "save";
		include XOOPS_ROOT_PATH."/modules/socialnet/include/fil.form.inc.php";
		$fil_form->display();
		break;
	case 'save':
		if (empty($fil_10_id)) {
			$files = new socialnet_fil_files();
		}else{
			$files = new socialnet_fil_files($fil_10_id);
		}
		$erro = '';
		$file_name = $_FILES[$_POST['xoops_upload_file'][0]];
		$file_name = (get_magic_quotes_gpc()) ? stripslashes($file_name['name']) : $file_name['name'];
		if(xoops_trim($file_name!='')) {
			include_once(XOOPS_ROOT_PATH."/class/uploader.php");
			$uploader = new XoopsMediaUploader( SOCIALNET_FILES_PATH, $xoopsModuleConfig['socialnet_conf_mimetypes'], $xoopsModuleConfig['socialnet_max_filesize']*1024);
			$uploader->setPrefix("files_");
			if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
				if ($uploader->upload()) {
					if (!empty($fil_10_id)) {
						$files->deletaArquivo();
					}
					$files->setVar("fil_30_name", $_POST['fil_30_name']);
					$files->setVar("fil_30_file", $uploader->getSavedFileName());
					$files->setVar("fil_30_mime", $uploader->getMediaType());
					$files->setVar("fil_10_size", $uploader->getMediaSize());
					$files->setVar("fil_12_show", $_POST['fil_12_show']);
					$files->setVar("fil_22_data", time());
					if(!$files->store()) {
						ob_start();
						xoops_error(_AM_SOCIALNET_PAGEERRORDB);
						$erro .= ob_get_clean();
					}else{
						redirect_header(XOOPS_URL."/modules/socialnet/admin/treefiles.php", 3,((empty($fil_10_id)) ? _AM_SOCIALNET_SENFIL_SUCESS : _AM_SOCIALNET_SUCESS2));
					}
				} else {
					ob_start();
					xoops_error($uploader->getErrors(), _AM_SOCIALNET_SENDERROR);
					$erro .= ob_get_clean();
				}
			} else {
				ob_start();
				xoops_error($uploader->getErrors());
				$erro .= ob_get_clean();
			}
		}elseif ($file_name == "" && !empty($fil_10_id)){
			$files->setVar("fil_30_name", $_POST['fil_30_name']);
			$files->setVar("fil_12_show", $_POST['fil_12_show']);
			if(!$files->store()) {
				ob_start();
				xoops_error(_AM_SOCIALNET_PAGEERRORDB);
				$erro .= ob_get_clean();
			}else{
				redirect_header(XOOPS_URL."/modules/socialnet/admin/treefiles.php", 3,_AM_SOCIALNET_SUCESS2);
			}
		}else{
			redirect_header(XOOPS_URL."/modules/socialnet/admin/treefiles.php", 3,_AM_SOCIALNET_ERR_SELECT_FILE);
		}
	case 'files':
	default:
		adminmenu(19);
		echo (!empty($erro)) ? $erro."<br />" : '';
		$socialnet_fil_files = new socialnet_fil_files();
		$fil_10_id = (empty($fil_10_id)) ? null : $fil_10_id;
		// Opções
		$c['op'] = 'files';
		$c['form'] = 0; // 0 to exhibit the registrations in mode visualization, 1 in mode edition
		$c['checks'] = 1;
		$c['print'] = 0;

		$c['name'][1] = 'fil_10_id';
		$c['label'][1] = _AM_SOCIALNET_FIL_10_ID;
		$c['type'][1] = "text";
		$c['size'][1] = 5;
		$c['show'][1] = '$reg->getVar($reg->id)';

		$c['name'][2] = 'fil_30_name';
		$c['label'][2] = _AM_SOCIALNET_FIL_30_NAME;
		$c['type'][2] = "text";
		$c['size'][2] = 15;
		//$c['nosort'][2] = 1;

		$c['name'][3] = 'fil_30_file';
		$c['label'][3] = _AM_SOCIALNET_FIL_30_FILE;
		$c['type'][3] = "text";
		$c['show'][3] = '"<a href=\'".SOCIALNET_FILES_URL."/".$reg->getVar("fil_30_file")."\' target=\'_blank\'>".$reg->getVar("fil_30_file")."</a>"';
		$c['nosort'][3] = 1;

		$c['name'][4] = 'fil_10_size';
		$c['label'][4] = _AM_SOCIALNET_FIL_10_SIZE;
		$c['type'][4] = "none";
		$c['show'][4] = 'number_format($reg->getVar("fil_10_size")/1024, 2, ".", "")." Kb"';

		$c['name'][5] = 'fil_30_mime';
		$c['label'][5] = _AM_SOCIALNET_FIL_30_MIME;
		$c['type'][5] = "select";
		$c['options'][5] = $socialnet_fil_files->pegaMimes();

		$c['name'][6] = 'fil_12_show';
		$c['label'][6] = trim(_AM_SOCIALNET_SHOW);
		$c['type'][6] = "simnao";

		$c['name'][7] = 'fil_22_data';
		$c['label'][7] = _AM_SOCIALNET_FIL_22_DATA;
		$c['type'][7] = "none";
		$c['show'][7] = 'date("d/m/Y", $reg->getVar("fil_22_data"))';

		$c['group_del'] = 1;
		$c['group_del_function'][1] = 'deletaArquivo';

		$c['buttons'][1]['link'] = XOOPS_URL.'/modules/socialnet/admin/treefiles.php?op=files_editar';
		$c['buttons'][1]['image'] = '../images/icons/edit.gif';
		$c['buttons'][1]['text'] = _EDIT;

		$c['buttons'][2]['link'] = XOOPS_URL.'/modules/socialnet/admin/treefiles.php?op=files_delete';
		$c['buttons'][2]['image'] = '../images/icons/dele.gif';
		$c['buttons'][2]['text'] = _DELETE;

		// Transtation
		$c['lang']['title'] = _AM_SOCIALNET_FILETITLE;
		$c['lang']['filters'] = _AM_SOCIALNET_FILTERS;
		$c['lang']['show'] = _AM_SOCIALNET_SHOW;
		$c['lang']['showing'] = _AM_SOCIALNET_SHOWING_FILES;
		$c['lang']['perpage'] = _AM_SOCIALNET_PORPAGE;
		$c['lang']['action'] = _AM_SOCIALNET_ACTION;
		$c['lang']['semresult'] = _AM_SOCIALNET_SEMRESULT;
		$c['lang']['group_action'] = _AM_SOCIALNET_GRP_ACTION;
		$c['lang']['group_error_sel'] = _AM_SOCIALNET_GRP_ERR_SEL;
		$c['lang']['group_del'] = _AM_SOCIALNET_GRP_DEL;
		$c['lang']['group_del_sure'] = _AM_SOCIALNET_GRP_DEL_SURE;
		echo $socialnet_fil_files->administration(XOOPS_URL."/modules/socialnet/admin/treefiles.php", $c);
		$fil_classe =& new socialnet_fil_files($fil_10_id);
		$form['title'] = ((empty($fil_10_id)) ? _AM_SOCIALNET_NFILE : _AM_SOCIALNET_EFILE);
		$form['op'] = "save";
		include XOOPS_ROOT_PATH."/modules/socialnet/include/fil.form.inc.php";
		$fil_form->display();
		break;
}
echo "<div align='center' style='margin-top:10px'><a href='http://www.ipwgc.com/socialnet/'><img src='../images/socialnetLogo.png'></a><br /><img src='../images/menu/mailuser.gif'><a style='color: #029116; font-size:11px' href='feedback.php'>"._AM_SOCIALNET_FEEDBACK."</a> - <img src='../images/icons/mainvideo.gif'><a style='color: #FF0000; font-size:11px' href='http://www.ipwgc.com/socialnet/modules/socialnet/index.php' target='_blank'>"._AM_SOCIALNET_CHKVERSION."</a></div>";
xoops_cp_footer();
?>