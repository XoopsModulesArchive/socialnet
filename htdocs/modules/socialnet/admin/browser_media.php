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
$mpb_wysiwyg_url = XOOPS_URL.$xoopsModuleConfig['socialnet_conf_wysiwyg_path'];
$tipos = array(1=>_AM_SOCIALNET_MED_10_TYPE_1, 2=>_AM_SOCIALNET_MED_10_TYPE_2, 3=>_AM_SOCIALNET_MED_10_TYPE_3,4=>_AM_SOCIALNET_MED_10_TYPE_4,5=>_AM_SOCIALNET_MED_10_TYPE_5);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$lang_browser_procurar}</title>

<script language="javascript" type="text/javascript">
<!--
function addItem(itemurl, name, larg, alt) {
	var field = tinyMCE.getWindowArg('field');
	var win = tinyMCE.getWindowArg('win');
	win.document.getElementById(field).value=itemurl;
	if(win.document.getElementById('name')) win.document.getElementById('name').value=name;
	if(win.document.getElementById('width')) win.document.getElementById('width').value=larg;
	if(win.document.getElementById('height')) win.document.getElementById('height').value=alt;
	if(field == "src"){
		if(win.selectByValue) win.selectByValue(win.document.forms[0],'linklist',itemurl);
		if(win.switchType) win.switchType(itemurl);
		if(win.generatePreview()) win.generatePreview();
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
function LargAlt(){
	var tipo = document.forms[1].med_10_type;
	if(tipo.options[tipo.selectedIndex].value == 1){
		document.getElementById('largalt').style.display="none";
	}else{
		document.getElementById('largalt').style.display="";
	}
}
//-->
</script>
	<base target="_self" />
</head>
<body onload="tinyMCEPopup.executeOnLoad('init();');">
		<div class="tabs">
			<ul>
				<li id="gerenciador_tab" <?php echo ($op == "listmed" || $op == "list") ? ' class="current"' : '';?>><span><a href="javascript:mcTabs.displayTab('gerenciador_tab','gerenciador_panel');" onmousedown="return false;">{$lang_browser_ger_medias}</a></span></li>
				<li id="nova_media_tab" <?php echo ($op == "addmedia") ? ' class="current"' : '';?>><span><a href="javascript:mcTabs.displayTab('nova_media_tab','nova_media_panel');" onmousedown="return false;">{$lang_browser_nova_media}</a></span></li>
			</ul>
		</div>
<div class="panel_wrapper">
			<div id="gerenciador_panel" class="panel <?php echo ($op == "listmed" || $op == "list") ? 'current' : '';?>" style="overflow: auto;">
				<h3>{$lang_browser_media_title}</h3>
<?PHP
if ($op == 'listmed') {
	$med_10_type = intval($_GET['med_10_type']);
	$med_classe = new socialnet_med_media();
	$criterio = new CriteriaCompo(new Criteria("med_10_type", $med_10_type));
	if(!empty($_GET['med_30_name'])){
		$criterio->add(new Criteria("med_30_name", "%".$_GET['med_30_name']."%", "LIKE"));
	}
	$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
	$criterio->setStart($start);
	$criterio->setLimit(20);
	$medias = $med_classe->PegaTudo($criterio);
	$medias_total = $med_classe->contar($criterio);
	if (!$medias) {
		header("Location: ".$_SERVER['PHP_SELF']."?med_10_type=".$med_10_type."&erro=".urlencode(_AM_SOCIALNET_ERRO_MED404).((!empty($_GET['med_30_name'])) ? "&med_30_name=".urlencode($_GET['med_30_name']) : ""));
	}else{
		$tipos_select = "";
		for ($i = 1; $i <= 5; $i++) {
			$tipos_select .= "<option value='".$i."' ".((!empty($_GET['med_10_type']) && $_GET['med_10_type'] == $i) ? "selected='selected'" : "").">".$tipos[$i]."</option>\n";
		}
		echo '<h4><a href="'.$_SERVER['PHP_SELF'].'">'. _AM_SOCIALNET_BROWSER_GER_MED .'</a>&nbsp;<span style="font-weight:bold;">&raquo;&raquo;</span>&nbsp;'.$tipos[$med_10_type].'</h4>';
		echo "<fieldset><legend>"._AM_SOCIALNET_FILTERS."</legend>";
		echo "<form action='".$_SERVER['PHP_SELF']."' method='GET'>";
		echo _AM_SOCIALNET_MED_30_NAME." <input type='hidden' name='op' value='listmed'> <input type='text' name='med_30_name' value='".((!empty($_GET['med_30_name'])) ? $_GET['med_30_name'] : "")."'> "._AM_SOCIALNET_MED_10_TYPE." <select name='med_10_type'>".$tipos_select."</select> <input type='image' src='".XOOPS_URL."/modules/socialnet/admin/images/envia.gif' align='absmiddle' style='border:0'>";
		echo "</form></fieldset><br />";
		echo '<table style="width:100%;"><thead><tr>
	<td>&nbsp;</td>
	<td style="border: 1px double black; text-align: center">'._AM_SOCIALNET_MED_30_NAME.'</td>
	<td style="border: 1px double black; text-align: center">'._AM_SOCIALNET_MED_10_WIDTH.' X '._AM_SOCIALNET_MED_10_HEIGHT.'</td>
	<td style="border: 1px double black; text-align: center">'._AM_SOCIALNET_MED_10_SIZE.'</td>
	<td style="border: 1px double black; text-align: center">'._AM_SOCIALNET_ACTION.'</td>
	</tr></thead><tbody>
	';
		foreach ($medias as $med) {
			$media_url = SOCIALNET_MEDIA_URL."/".$med->getVar('med_30_file');
			echo '<tr><td width="30%" style="text-align: center">';
			echo '<a href="javascript:void(0)" style="border:2px solid white" onclick="addItem(\''.$media_url.'\', \''.$med->getVar('med_30_name').'\', \''.$med->getVar('med_10_width').'\', \''.$med->getVar('med_10_height').'\')"/>'.$med->getVar('med_10_id').'</a>';
			echo '</td><td style="border: 2px double #F0F0EE; text-align: center">'.$med->getVar('med_30_name').'</td><td style="border: 2px double #F0F0EE; text-align: center">'.$med->getVar('med_10_width').'px X '.$med->getVar('med_10_height').'px</td><td style="border: 2px double #F0F0EE; text-align: center">'.number_format($med->getVar("med_10_size")/1024, 2, ".", "").'Kb</td>';
			echo '<td style="border: 2px double #F0F0EE; text-align: center"><a href="javascript:void(0)" onclick="addItem(\''.$media_url.'\', \''.$med->getVar('med_30_name').'\', \''.$med->getVar('med_10_width').'\', \''.$med->getVar('med_10_height').'\')">'._SELECT.'</a></td></tr>';
		}
		echo "</tbody></table>";
		if ($medias_total > 0) {
			if ($medias_total > 20) {
				include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
				$nav = new XoopsPageNav($medias_total, 20, $start, 'start', 'op=listmed&amp;med_10_type='.$med_10_type.((!empty($_GET['med_30_name'])) ? "&amp;med_30_name=".$_GET['med_30_name'] : ""));
				echo '<div style="text-align:right">'.$nav->renderNav().'</div>';
			}
		}
	}
}else{
	$med_classe = new socialnet_med_media();
	$tipos_select = "";
	echo '<ul>';
	for ($i = 1; $i <= 5; $i++) {
		$tipos_select .= "<option value='".$i."' ".((!empty($_GET['med_10_type']) && $_GET['med_10_type'] == $i) ? "selected='selected'" : "").">".$tipos[$i]."</option>\n";
		$medias = $med_classe->contar(new Criteria('med_10_type', $i));
		echo '<li>'.$tipos[$i].' (<b>'.$medias.'</b> '._AM_SOCIALNET_BROWSER_GER_MED.') '.(($medias > 0) ? '[<a href="'.$_SERVER['PHP_SELF'].'?op=listmed&amp;med_10_type='.$i.'">'._LIST.'</a>]</li>' : '');
	}
	echo '</ul>';
	echo "<fieldset><legend>"._AM_SOCIALNET_FILTERS."</legend>";
	echo "<form action='".$_SERVER['PHP_SELF']."' method='GET'>";
	echo _AM_SOCIALNET_MED_30_NAME." <input type='hidden' name='op' value='listmed'> <input type='text' name='med_30_name' value='".((!empty($_GET['med_30_name'])) ? $_GET['med_30_name'] : "")."'> "._AM_SOCIALNET_MED_10_TYPE." <select name='med_10_type'>".$tipos_select."</select> <input type='image' src='".XOOPS_URL."/modules/socialnet/admin/images/envia.gif' align='absmiddle' style='border:0'>";
	echo "</form></fieldset>";
	if (!empty($_GET['erro'])) {
		echo "<br /><div style='border: 2px solid red; text-align:center; font-weight:bold'>".$_GET['erro']."</div>";
	}
}
?>
</div>

			<div id="nova_media_panel" class="panel <?php echo ($op == "addmedia") ? 'current' : '';?>" style="overflow: visible;">
<?PHP
if ($op == 'addmedia') {
	$media = new socialnet_med_media();
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
					echo "<fieldset><legend>"._ERRORS."</legend>";
					xoops_error(_AM_SOCIALNET_PAGEERRORDB);
					echo "</fieldset>";
				}else{
					echo "<fieldset><legend>"._AM_SOCIALNET_SENMED_SUCESS."</legend>";
					echo '<table style="width:100%;"><thead><tr>
					<td>&nbsp;</td>
					<td style="border: 1px double black; text-align: center">'._AM_SOCIALNET_MED_30_NAME.'</td>
					<td style="border: 1px double black; text-align: center">'._AM_SOCIALNET_MED_10_WIDTH.' X '._AM_SOCIALNET_MED_10_HEIGHT.'</td>
					<td style="border: 1px double black; text-align: center">'._AM_SOCIALNET_MED_10_SIZE.'</td>
					<td style="border: 1px double black; text-align: center">'._AM_SOCIALNET_ACTION.'</td>
					</tr></thead><tbody>
					';
					$media_url = SOCIALNET_MEDIA_URL."/".$uploader->getSavedFileName();
					echo '<tr><td width="30%" style="text-align: center">';
					echo '<a href="javascript:void(0)" style="border:2px solid white" onclick="addItem(\''.$media_url.'\', \''.$media->getVar('med_30_name').'\', \''.$media->getVar('med_10_width').'\', \''.$media->getVar('med_10_height').'\')"/>'.$media->getVar('med_10_id').'</a>';
					echo '</td><td style="border: 2px double #F0F0EE; text-align: center">'.$media->getVar('med_30_name').'</td><td style="border: 2px double #F0F0EE; text-align: center">'.$media->getVar('med_10_width').'px X '.$media->getVar('med_10_height').'px</td><td style="border: 2px double #F0F0EE; text-align: center">'.number_format($media->getVar("med_10_size")/1024, 2, ".", "").'Kb</td>';
					echo '<td style="border: 2px double #F0F0EE; text-align: center"><a href="javascript:void(0)" onclick="addItem(\''.$media_url.'\', \''.$media->getVar('med_30_name').'\', \''.$media->getVar('med_10_width').'\', \''.$media->getVar('med_10_height').'\')">'._SELECT.'</a></td></tr>';
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
		xoops_error(_AM_SOCIALNET_ERR_SELECT_MEDIA);
		echo "</fieldset>";
	}
}
echo "<h4>"._AM_SOCIALNET_NMEDIA."</h4>";
$med_classe =& new socialnet_med_media();
$med_form = new XoopsThemeForm("", "socialnet_med_form", $_SERVER['PHP_SELF'], "post");
$med_form->setExtra('enctype="multipart/form-data"');
$med_form->addElement(new XoopsFormText(_AM_SOCIALNET_MED_30_NAME, "med_30_name", 50, 50), true);
$tipo_select = new XoopsFormSelect("", "med_10_type");
$tipo_select->setExtra("onchange='LargAlt();'");
$tipo_select->addOptionArray($tipos);
$tipo_tray = new XoopsFormElementTray(_AM_SOCIALNET_MED_10_TYPE);
$tipo_tray->addElement($tipo_select);
$tipo_tray->addElement(new XoopsFormLabel("", "<br /><div id='largalt' style='display:none'>"));
$tipo_tray->addElement(new XoopsFormText(_AM_SOCIALNET_MED_10_WIDTH, "med_10_width", 4, 4), true);
$tipo_tray->addElement(new XoopsFormText(_AM_SOCIALNET_MED_10_HEIGHT, "med_10_height", 4, 4), true);
$tipo_tray->addElement(new XoopsFormLabel("", "</div>"));
$med_form->addElement($tipo_tray);
$med_file = new XoopsFormFile('', 'med_30_file', 50000000);
$arquivo_tray = new XoopsFormElementTray(_AM_SOCIALNET_MED_30_FILE, '&nbsp;');
$arquivo_tray->addElement($med_file);
$med_form->addElement($arquivo_tray);
$med_form->addElement(new XoopsFormRadioYN(_AM_SOCIALNET_MED_12_SHOW, 'med_12_show', 1));
$med_form->addElement(new XoopsFormHidden('op', "addmedia"));
$med_buttons_tray = new XoopsFormElementTray("", "&nbsp;&nbsp;");
$med_button_cancel = new XoopsFormButton("", "cancelar", _CANCEL);
$med_buttons_tray->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
$med_button_cancel->setExtra("onclick=\"document.location= '".$_SERVER['PHP_SELF']."'\"");
$med_buttons_tray->addElement($med_button_cancel);
$med_form->addElement($med_buttons_tray);
$med_form->display();
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