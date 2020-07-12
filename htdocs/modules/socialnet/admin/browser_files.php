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
include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
$op = (empty($_GET['op'])) ? 'list' : $_GET['op'];
$op = (empty($_POST['op'])) ? $op : $_POST['op'];
//$mpb_wysiwyg_url = XOOPS_URL.$xoopsModuleConfig['socialnet_conf_wysiwyg_path'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$lang_browser_procurar}</title>



<script language="javascript" type="text/javascript">
<!--
function addItem(itemurl, name) {
	var field = tinyMCE.getWindowArg('field');
	var win = tinyMCE.getWindowArg('win');
	win.document.getElementById(field).value=itemurl;
	if(field == "href" && win.document.getElementById('title')) win.document.getElementById('title').value=name;
	if(field == "href"){
		if(win.selectByValue) win.selectByValue(win.document.forms[0],'linklisthref',itemurl);
	}
	tinyMCEPopup.close();
	return;
}
function init() {
	window.focus();
}

function cancelAction() {
	top.close();
}
//-->
</script>
	<base target="_self" />
</head>
<body onload="tinyMCEPopup.executeOnLoad('init();');">
		<div class="tabs">
			<ul>
				<li id="gerenciador_tab" <?php echo ($op == "listfil" || $op == "list") ? ' class="current"' : '';?>><span><a href="javascript:mcTabs.displayTab('gerenciador_tab','gerenciador_panel');" onmousedown="return false;">{$lang_browser_ger_files}</a></span></li>
				<li id="new_file_tab" <?php echo ($op == "addfile") ? ' class="current"' : '';?>><span><a href="javascript:mcTabs.displayTab('new_file_tab','new_file_panel');" onmousedown="return false;">{$lang_browser_new_file}</a></span></li>
			</ul>
		</div>
<div class="panel_wrapper">
			<div id="gerenciador_panel" class="panel <?php echo ($op == "listfil" || $op == "list") ? 'current' : '';?>" style="overflow: auto;">
				<h3>{$lang_browser_file_title}</h3>
<?PHP
if ($op == 'listfil') {
	$fil_30_mime = $_GET['fil_30_mime'];
	$fil_classe = new socialnet_fil_files();
	$criterio = new CriteriaCompo(new Criteria("fil_30_mime", $fil_30_mime));
	if(!empty($_GET['fil_30_name'])){
		$criterio->add(new Criteria("fil_30_name", "%".$_GET['fil_30_name']."%", "LIKE"));
	}
	$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
	$criterio->setStart($start);
	$criterio->setLimit(20);
	$files = $fil_classe->PegaTudo($criterio);
	$files_total = $fil_classe->contar($criterio);
	if (!$files) {
		header("Location: ".$_SERVER['PHP_SELF']."?fil_30_mime=".$fil_30_mime."&erro=".urlencode(_AM_SOCIALNET_ERRO_FIL404).((!empty($_GET['fil_30_name'])) ? "&fil_30_name=".urlencode($_GET['fil_30_name']) : ""));
	}else{
		$tipos_select = "";
		$mimes = $fil_classe->pegaMimes();
		foreach ($mimes as $k=>$v) {
			$tipos_select .= "<option value='".$k."' ".(($fil_30_mime == $k) ? "selected='selected'" : "").">".$v."</option>";
		}
		echo '<h4><a href="'.$_SERVER['PHP_SELF'].'">'. _AM_SOCIALNET_BROWSER_GER_FIL .'</a>&nbsp;<span style="font-weight:bold;">&raquo;&raquo;</span>&nbsp;'.$mimes[$fil_30_mime].'</h4>';
		echo "<fieldset><legend>"._AM_SOCIALNET_FILTERS."</legend>";
		echo "<form action='".$_SERVER['PHP_SELF']."' method='GET'>";
		echo _AM_SOCIALNET_FIL_30_NAME." <input type='hidden' name='op' value='listfil'> <input type='text' name='fil_30_name' value='".((!empty($_GET['fil_30_name'])) ? $_GET['fil_30_name'] : "")."'> "._AM_SOCIALNET_FIL_30_MIME." <select name='fil_30_mime'>".$tipos_select."</select> <input type='image' src='".XOOPS_URL."/modules/socialnet/admin/images/envia.gif' align='absmiddle' style='border:0'>";
		echo "</form></fieldset><br />";
		echo '<table style="width:100%;"><thead><tr>
	<td>&nbsp;</td>
	<td style="border: 1px double black; text-align: center">'._AM_SOCIALNET_FIL_30_NAME.'</td>
	<td style="border: 1px double black; text-align: center">'._AM_SOCIALNET_FIL_10_SIZE.'</td>
	<td style="border: 1px double black; text-align: center">'._AM_SOCIALNET_FIL_22_DATA.'</td>
	<td style="border: 1px double black; text-align: center">'._AM_SOCIALNET_ACTION.'</td>
	</tr></thead><tbody>
	';
		foreach ($files as $fil) {
			$file_url = SOCIALNET_FILES_URL."/".$fil->getVar('fil_30_file');
			echo '<tr><td width="30%" style="text-align: center">';
			echo '<a href="javascript:void(0)" style="border:2px solid white" onclick="addItem(\''.$file_url.'\', \''.$fil->getVar('fil_30_name').'\')"/>'.$fil->getVar('fil_10_id').'</a>';
			echo '</td><td style="border: 2px double #F0F0EE; text-align: center">'.$fil->getVar('fil_30_name').'</td><td style="border: 2px double #F0F0EE; text-align: center">'.number_format($fil->getVar("fil_10_size")/1024, 2, ".", "").' Kb</td><td style="border: 2px double #F0F0EE; text-align: center">'.date("d/m/Y",$fil->getVar("fil_22_data")).'</td>';
			echo '<td style="border: 2px double #F0F0EE; text-align: center"><a href="javascript:void(0)" onclick="addItem(\''.$file_url.'\', \''.$fil->getVar('fil_30_name').'\')">'._SELECT.'</a></td></tr>';
		}
		echo "</tbody></table>";
		if ($files_total > 0) {
			if ($files_total > 20) {
				include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
				$nav = new XoopsPageNav($files_total, 20, $start, 'start', 'op=listfil&amp;fil_30_mime='.$fil_30_mime.((!empty($_GET['fil_30_name'])) ? "&amp;fil_30_name=".$_GET['fil_30_name'] : ""));
				echo '<div style="text-align:right">'.$nav->renderNav().'</div>';
			}
		}
	}
}else{
	$fil_classe = new socialnet_fil_files();
	$mimes = $fil_classe->pegaMimes();
	$tipos_select = "";
	if($mimes){
		echo '<ul>';
		foreach ($mimes as $k=>$v) {
			$tipos_select .= "<option value='".$k."' ".((!empty($_GET['fil_30_mime']) && $_GET['fil_30_mime'] == $k) ? "selected='selected'" : "").">".$v."</option>";
			$files_count = $fil_classe->contar(new Criteria('fil_30_mime', $k));
			echo '<li>'.$v.' (<b>'.$files_count.'</b> '._AM_SOCIALNET_BROWSER_GER_FIL.') '.(($files_count > 0) ? '[<a href="'.$_SERVER['PHP_SELF'].'?op=listfil&amp;fil_30_mime='.$k.'">'._LIST.'</a>]</li>' : '');
		}
		echo '</ul>';
		echo "<fieldset><legend>"._AM_SOCIALNET_FILTERS."</legend>";
		echo "<form action='".$_SERVER['PHP_SELF']."' method='GET'>";
		echo _AM_SOCIALNET_FIL_30_NAME." <input type='hidden' name='op' value='listfil'> <input type='text' name='fil_30_name' value='".((!empty($_GET['fil_30_name'])) ? $_GET['fil_30_name'] : "")."'> "._AM_SOCIALNET_FIL_30_MIME." <select name='fil_30_mime'>".$tipos_select."</select> <input type='image' src='".XOOPS_URL."/modules/socialnet/admin/images/envia.gif' align='absmiddle' style='border:0'>";
		echo "</form></fieldset>";
	}
	if (!empty($_GET['erro'])) {
		echo "<br /><div style='border: 2px solid red; text-align:center; font-weight:bold'>".$_GET['erro']."</div>";
	}
}
?>
</div>

			<div id="new_file_panel" class="panel <?php echo ($op == "addfile") ? 'current' : '';?>" style="overflow: visible;">
<?PHP
if ($op == 'addfile') {
	$file = new socialnet_fil_files();
	$file_name = $_FILES[$_POST['xoops_upload_file'][0]];
	$file_name = (get_magic_quotes_gpc()) ? stripslashes($file_name['name']) : $file_name['name'];
	if(xoops_trim($file_name!='')) {
		include_once(XOOPS_ROOT_PATH."/class/uploader.php");
		$uploader = new XoopsMediaUploader( SOCIALNET_FILES_PATH, $xoopsModuleConfig['socialnet_conf_mimetypes'], $xoopsModuleConfig['socialnet_mmax_filesize']*1024);
		$uploader->setPrefix("files_");
		if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
			if ($uploader->upload()) {
				$file->setVar("fil_30_name", $_POST['fil_30_name']);
				$file->setVar("fil_30_file", $uploader->getSavedFileName());
				$file->setVar("fil_30_mime", $uploader->getMediaType());
				$file->setVar("fil_10_size", $uploader->getMediaSize());
				$file->setVar("fil_12_show", $_POST['fil_12_show']);
				$file->setVar("fil_22_data", time());
				if(!$file->store()) {
					echo "<fieldset><legend>"._ERRORS."</legend>";
					xoops_error(_AM_SOCIALNET_PAGEERRORDB);
					echo "</fieldset>";
				}else{
					echo "<fieldset><legend>"._AM_SOCIALNET_SENFIL_SUCESS."</legend>";
					echo '<table style="width:100%;"><thead><tr>
					<td>&nbsp;</td>
					<td style="border: 1px double black; text-align: center">'._AM_SOCIALNET_FIL_30_NAME.'</td>
					<td style="border: 1px double black; text-align: center">'._AM_SOCIALNET_FIL_10_SIZE.'</td>
					<td style="border: 1px double black; text-align: center">'._AM_SOCIALNET_FIL_22_DATA.'</td>
					<td style="border: 1px double black; text-align: center">'._AM_SOCIALNET_ACTION.'</td>
					</tr></thead><tbody>
					';
					$file_url = SOCIALNET_FILES_URL."/".$uploader->getSavedFileName();
					echo '<tr><td width="30%" style="text-align: center">';
					echo '<a href="javascript:void(0)" style="border:2px solid white" onclick="addItem(\''.$file_url.'\', \''.$file->getVar('fil_30_name').'\')"/>'.$file->getVar('fil_10_id').'</a>';
					echo '</td><td style="border: 2px double #F0F0EE; text-align: center">'.$file->getVar('fil_30_name').'</td><td style="border: 2px double #F0F0EE; text-align: center">'.number_format($file->getVar("fil_10_size")/1024, 2, ".", "").'Kb</td><td style="border: 2px double #F0F0EE; text-align: center">'.date("d/m/Y", $file->getVar('fil_22_data')).'</td>';
					echo '<td style="border: 2px double #F0F0EE; text-align: center"><a href="javascript:void(0)" onclick="addItem(\''.$file_url.'\', \''.$file->getVar('fil_30_name').'\')">'._SELECT.'</a></td></tr>';
					echo "</tbody></table></fieldset>";
				}
			} else {
				echo "<fieldset><legend>"._ERRORS."</legend>";
				xoops_error($uploader->getErrors(), _AM_SOCIALNET_SENDERROR);
				echo "</fieldset>";
			}
		} else {
			echo "<fieldset><legend>"._ERRORS."</legend>";
			xoops_error($uploader->getErrors());
			echo "</fieldset>";
		}
	}else{
		echo "<fieldset><legend>"._ERRORS."</legend>";
		xoops_error(_AM_SOCIALNET_ERR_SELECT_FILE);
		echo "</fieldset>";
	}
}
echo "<h4>"._AM_SOCIALNET_NFILE."</h4>";
$fil_classe =& new socialnet_fil_files();
$fil_form = new XoopsThemeForm("", "socialnet_fil_form", $_SERVER['PHP_SELF'], "post");
$fil_form->setExtra('enctype="multipart/form-data"');
$fil_form->addElement(new XoopsFormText(_AM_SOCIALNET_FIL_30_NAME, "fil_30_name", 50, 50, $fil_classe->getVar("fil_30_name")), true);
$fil_file = new XoopsFormFile('', 'fil_30_file', $xoopsModuleConfig['socialnet_max_filesize']*1024);
$arquivo_tray = new XoopsFormElementTray(_AM_SOCIALNET_FIL_30_FILE, '&nbsp;');
$arquivo_tray->addElement($fil_file);
$fil_form->addElement($arquivo_tray);
$fil_form->addElement(new XoopsFormRadioYN(_AM_SOCIALNET_FIL_12_SHOW, 'fil_12_show',$fil_classe->getVar("fil_12_show")));
$fil_form->addElement(new XoopsFormHidden('fil_10_id', $fil_classe->getVar('fil_10_id')));
$fil_form->addElement(new XoopsFormHidden('op', "addfile"));
$fil_buttons_tray = new XoopsFormElementTray("", "&nbsp;&nbsp;");
$fil_button_cancel = new XoopsFormButton("", "cancelar", _CANCEL);
$fil_buttons_tray->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
$fil_button_cancel->setExtra("onclick=\"document.location= '".XOOPS_URL."/modules/socialnet/admin/treefiles.php'\"");
$fil_buttons_tray->addElement($fil_button_cancel);
$fil_form->addElement($fil_buttons_tray);
$fil_form->display();
?>
</div>
</div>
<div class="mceActionPanel">
<div style="float: right">
<input type="button" id="cancel" name="cancel" value="{$lang_close}" onclick="tinyMCEPopup.close();" />
</div>
</div>
<!--
<!--{xo-logger-output}-->
-->
</body>
</html>