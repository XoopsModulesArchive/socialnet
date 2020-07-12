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


$op = (isset($_GET['op'])) ? $_GET['op'] : 'media';
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
	case "media_editar":
		adminmenu(18);
		$med_10_id = (!empty($med_10_id)) ? $med_10_id : 0;
		$med_classe =& new socialnet_med_media($med_10_id);
		if (empty($med_10_id) || $med_classe->getVar('med_10_id') == '') {
			redirect_header(XOOPS_URL."/modules/socialnet/admin/treemedia.php", 3, _AM_SOCIALNET_ERRO_MED404);
		}
		$form['title'] = _AM_SOCIALNET_EMEDIA;
		$form['op'] = "save";
		include XOOPS_ROOT_PATH."/modules/socialnet/include/med.form.inc.php";
		$med_form->display();
		break;
	case "media_delete":
		adminmenu(18);
		$med_10_id = (!empty($med_10_id)) ? $med_10_id : 0;
		$med_classe =& new socialnet_med_media($med_10_id);
		if (empty($med_10_id) || $med_classe->getVar('med_10_id') == '') {
			redirect_header(XOOPS_URL."/modules/socialnet/admin/treemedia.php", 3, _AM_SOCIALNET_ERRO_MED404);
		}
		xoops_confirm(array('op' => 'media_delete_ok', 'med_10_id' => $med_10_id), 'treemedia.php', sprintf(_AM_SOCIALNET_CONFIRM_DELMED, $med_10_id, $med_classe->getVar("med_30_name")));
		break;
	case "media_delete_ok":
		$med_10_id = (!empty($med_10_id)) ? $med_10_id : 0;
		$med_classe =& new socialnet_med_media($med_10_id);
		if (empty($med_10_id) || $med_classe->getVar('med_10_id') == '') {
			redirect_header(XOOPS_URL."/modules/socialnet/admin/treemedia.php", 3, _AM_SOCIALNET_ERRO_MED404);
		}
		$med_classe->delete();
		$med_classe->deletaArquivo();
		redirect_header(XOOPS_URL."/modules/socialnet/admin/treemedia.php", 3,_AM_SOCIALNET_DELMED_SUCESS);
		break;
	case 'media_adicionar':
		adminmenu(18);
		$med_classe =& new socialnet_med_media();
		$form['title'] = _AM_SOCIALNET_NMEDIA;
		$form['op'] = "save";
		include XOOPS_ROOT_PATH."/modules/socialnet/include/med.form.inc.php";
		$med_form->display();
		break;
	case 'save':
		if (empty($med_10_id)) {
			$media = new socialnet_med_media();
		}else{
			$media = new socialnet_med_media($med_10_id);
		}
		$erro = '';
		$file_name = $_FILES[$_POST['xoops_upload_file'][0]];
		$file_name = (get_magic_quotes_gpc()) ? stripslashes($file_name['name']) : $file_name['name'];
		if(xoops_trim($file_name!='')) {
			include_once(XOOPS_ROOT_PATH."/class/uploader.php");
			switch ($_POST['med_10_type']){
				case 1:
					$permittedtypes=array('application/x-shockwave-flash');
					break;
				case 2:
					$permittedtypes=array('video/quicktime');
					break;
				case 3:
					$permittedtypes=array('application/x-director');
					break;
				case 4:
					$permittedtypes=array('application/octet-stream', 'video/x-ms-asf', 'video/x-msvideo', 'video/x-ms-wmv');
					break;
				case 5:
				default:
					$permittedtypes=array('audio/x-pn-realaudio');
					break;
			}
			$uploader = new XoopsMediaUploader( SOCIALNET_MEDIA_PATH, $permittedtypes, $xoopsModuleConfig['socialnet_mmax_filesize']*1024);
			$uploader->extensionToMime = array_merge($uploader->extensionToMime, array("wmv"=>"video/x-ms-wmv","asf"=>"video/x-ms-asf", "rm"=>"audio/x-pn-realaudio"));
			unset($uploader->imageExtensions[4]);
			$uploader->setPrefix("media_");
			if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
				if ($uploader->upload()) {
					if (!empty($med_10_id)) {
						$media->deletaArquivo();
					}
					$media->setVar("med_30_name", $_POST['med_30_name']);
					$media->setVar("med_30_file", $uploader->getSavedFileName());
					$largalt = @getimagesize(SOCIALNET_MEDIA_PATH."/".$uploader->getSavedFileName());
					if($largalt){
						$media->setVar("med_10_width", $largalt[0]);
						$media->setVar("med_10_height", $largalt[1]);
					}else{
						$media->setVar("med_10_height", $_POST['med_10_height']);
						$media->setVar("med_10_width", $_POST['med_10_width']);
					}
					$media->setVar("med_10_size", $uploader->getMediaSize());
					$media->setVar("med_12_show", $_POST['med_12_show']);
					$media->setVar("med_22_data", time());
					$media->setVar("med_10_type", $_POST['med_10_type']);
					if(!$media->store()) {
						ob_start();
						xoops_error(_AM_SOCIALNET_PAGEERRORDB);
						$erro .= ob_get_clean();

					}else{
						redirect_header(XOOPS_URL."/modules/socialnet/admin/treemedia.php", 3,((empty($med_10_id)) ? _AM_SOCIALNET_SENMED_SUCESS : _AM_SOCIALNET_SUCESS2));
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
		}elseif ($file_name == "" && !empty($med_10_id)){
			$media->setVar("med_30_name", $_POST['med_30_name']);
			$media->setVar("med_10_height", $_POST['med_10_height']);
			$media->setVar("med_10_width", $_POST['med_10_width']);
			$media->setVar("med_12_show", $_POST['med_12_show']);
			if(!$media->store()) {
				ob_start();
				xoops_error(_AM_SOCIALNET_PAGEERRORDB);
				$erro .= ob_get_clean();

			}else{
				redirect_header(XOOPS_URL."/modules/socialnet/admin/treemedia.php", 3,_AM_SOCIALNET_SUCESS2);
			}
		}else{
			redirect_header(XOOPS_URL."/modules/socialnet/admin/treemedia.php", 3,_AM_SOCIALNET_ERR_SELECT_MEDIA);
		}
	case 'media':
	default:
		adminmenu(18);
		echo (!empty($erro)) ? $erro."<br />" : '';
		$socialnet_med_media = new socialnet_med_media();
		$med_10_id = (empty($med_10_id)) ? null : $med_10_id;
		// Opções
		$c['op'] = 'media';
		$c['form'] = 0; // 0 to exhibit the registrations in mode visualization, 1 in mode edition
		$c['checks'] = 1;

		$c['name'][1] = 'med_10_id';
		$c['label'][1] = _AM_SOCIALNET_MED_10_ID;
		$c['type'][1] = "text";
		$c['size'][1] = 5;
		$c['show'][1] = '$reg->getVar($reg->id)';

		$c['name'][2] = 'med_30_name';
		$c['label'][2] = _AM_SOCIALNET_MED_30_NAME;
		$c['type'][2] = "text";
		$c['size'][2] = 15;
		//$c['nosort'][2] = 1;

		$c['name'][3] = 'med_30_file';
		$c['label'][3] = _AM_SOCIALNET_MED_30_FILE;
		$c['type'][3] = "text";
		$c['show'][3] = '"<a href=\'".SOCIALNET_MEDIA_URL."/".$reg->getVar("med_30_file")."\' target=\'_blank\'>".$reg->getVar("med_30_file")."</a>"';
		$c['nosort'][3] = 1;

		$c['name'][4] = 'med_10_size';
		$c['label'][4] = _AM_SOCIALNET_MED_10_SIZE;
		$c['type'][4] = "none";
		$c['show'][4] = 'number_format($reg->getVar("med_10_size")/1024, 2, ".", "")." Kb"';

		$c['name'][5] = 'med_10_type';
		$c['label'][5] = _AM_SOCIALNET_MED_10_TYPE;
		$c['type'][5] = "select";
		$c['options'][5] = array(1 => _AM_SOCIALNET_MED_10_TYPE_1, 2=>_AM_SOCIALNET_MED_10_TYPE_2, 3=>_AM_SOCIALNET_MED_10_TYPE_3, 4=>_AM_SOCIALNET_MED_10_TYPE_4, 5=>_AM_SOCIALNET_MED_10_TYPE_5);

		$c['name'][6] = 'med_12_show';
		$c['label'][6] = trim(_AM_SOCIALNET_SHOW);
		$c['type'][6] = "simnao";

		$c['name'][7] = 'med_22_data';
		$c['label'][7] = _AM_SOCIALNET_MED_22_DATA;
		$c['type'][7] = "none";
		$c['show'][7] = 'date("d/m/Y", $reg->getVar("med_22_data"))';

		$c['group_del'] = 1;
		$c['group_del_function'][1] = 'deletaArquivo';

		$c['buttons'][1]['link'] = XOOPS_URL.'/modules/socialnet/admin/treemedia.php?op=media_editar';
		$c['buttons'][1]['image'] = '../images/icons/edit.gif';
		$c['buttons'][1]['text'] = _AM_SOCIALNET_EMEDIA;

		$c['buttons'][2]['link'] = XOOPS_URL.'/modules/socialnet/admin/treemedia.php?op=media_delete';
		$c['buttons'][2]['image'] = '../images/icons/dele.gif';
		$c['buttons'][2]['text'] = _AM_SOCIALNET_DMEDIA;

		// Translation
		$c['lang']['title'] = _AM_SOCIALNET_MEDIATITLE;
		$c['lang']['filters'] = _AM_SOCIALNET_FILTERS;
		$c['lang']['show'] = _AM_SOCIALNET_SHOW;
		$c['lang']['showing'] = _AM_SOCIALNET_SHOWING_MEDIA;
		$c['lang']['perpage'] = _AM_SOCIALNET_PORPAGE;
		$c['lang']['action'] = _AM_SOCIALNET_ACTION;
		$c['lang']['semresult'] = _AM_SOCIALNET_SEMRESULT;
		$c['lang']['group_action'] = _AM_SOCIALNET_GRP_ACTION;
		$c['lang']['group_error_sel'] = _AM_SOCIALNET_GRP_ERR_SEL;
		$c['lang']['group_del'] = _AM_SOCIALNET_GRP_DEL;
		$c['lang']['group_del_sure'] = _AM_SOCIALNET_GRP_DEL_SURE;
		echo $socialnet_med_media->administration(XOOPS_URL."/modules/socialnet/admin/treemedia.php", $c);
		$med_classe =& new socialnet_med_media($med_10_id);
		$form['title'] = ((empty($med_10_id)) ? _AM_SOCIALNET_NMEDIA : _AM_SOCIALNET_EMEDIA);
		$form['op'] = "save";
		include XOOPS_ROOT_PATH."/modules/socialnet/include/med.form.inc.php";
		$med_form->display();
		break;
}
echo "<div align='center' style='margin-top:10px'><a href='http://www.ipwgc.com/socialnet/'><img src='../images/socialnetLogo.png'></a><br /><img src='../images/menu/mailuser.gif'><a style='color: #029116; font-size:11px' href='feedback.php'>"._AM_SOCIALNET_FEEDBACK."</a> - <img src='../images/icons/mainvideo.gif'><a style='color: #FF0000; font-size:11px' href='http://www.ipwgc.com/socialnet/modules/socialnet/index.php' target='_blank'>"._AM_SOCIALNET_CHKVERSION."</a></div>";
xoops_cp_footer();
?>