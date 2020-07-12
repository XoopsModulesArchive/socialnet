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

if (!defined('XOOPS_ROOT_PATH')) {
	die("Erro! XOOPS_ROOT_PATH não está definido");
}
echo <<<JSCRIPT
<script type="text/javascript">
<!--
function LargAlt(){
var tipo = document.getElementById("med_10_type");
var id = document.getElementById("med_10_id");

if(tipo.options[tipo.selectedIndex].value == 1 && id.value == ""){
document.getElementById('largalt').style.display="none";
}else{
document.getElementById('largalt').style.display="";
}
}
-->
</script>

JSCRIPT;
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
$med_form = new XoopsThemeForm($form['title'], "socialnet_med_form", $_SERVER['PHP_SELF'], "post");
$med_form->setExtra('enctype="multipart/form-data"');
if($med_classe->getVar("med_10_id") != ""){
	$arquivo = SOCIALNET_MEDIA_URL."/".$med_classe->getVar("med_30_file");
	$altura = ($med_classe->getVar("med_10_height") > 0) ?  $med_classe->getVar("med_10_height") : 200;
	$largura = ($med_classe->getVar("med_10_width") > 0) ?  $med_classe->getVar("med_10_width") : 200;
	switch ($med_classe->getVar("med_10_type")) {
		case 1:
			$cod_html = '
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" width="'.$largura.'" height="'.$altura.'">
<param name="src" value="'.$arquivo.'" />
<param name="width" value="'.$largura.'" />
<param name="height" value="'.$altura.'" />
<embed type="application/x-shockwave-flash" src="'.$arquivo.'" width="'.$largura.'" height="'.$altura.'"></embed>
</object>';
			break;
		case 2:
		$cod_html = '
<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab#version=6,0,2,0" width="'.$largura.'" height="'.$altura.'">
<param name="src" value="'.$arquivo.'" />
<param name="width" value="'.$largura.'" />
<param name="height" value="'.$altura.'" />
<embed type="video/quicktime" src="'.$arquivo.'" width="'.$largura.'" height="'.$altura.'"></embed>
</object>
		';
			break;
		case 3:
		$cod_html = '
<object classid="clsid:166B1BCA-3F9C-11CF-8075-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#version=8,5,1,0" width="'.$largura.'" height="'.$altura.'">
<param name="sound" value="true" />
<param name="progress" value="true" />
<param name="autostart" value="true" />
<param name="swstretchstyle" value="none" />
<param name="swstretchhalign" value="none" />
<param name="swstretchvalign" value="none" />
<param name="src" value="'.$arquivo.'" />
<param name="width" value="'.$largura.'" />
<param name="height" value="'.$altura.'" />
<embed type="application/x-director" sound="true" progress="true" autostart="true" swliveconnect="false" swstretchstyle="none" swstretchhalign="none" swstretchvalign="none" src="'.$arquivo.'" width="'.$largura.'" height="'.$altura.'"></embed>
</object>
		';
		break;
		case 4:
		$cod_html = '
<object classid="clsid:6BF52A52-394A-11D3-B153-00C04F79FAA6" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701" width="'.$largura.'" height="'.$altura.'">
<param name="src" value="'.$arquivo.'" />
<param name="url" value="'.$arquivo.'" />
<param name="width" value="'.$largura.'" />
<param name="height" value="'.$altura.'" />
<embed type="application/x-mplayer2" src="'.$arquivo.'" width="'.$largura.'" height="'.$altura.'"></embed>
</object>
		';
			break;
		case 5:
		default:
		$cod_html = '
<object classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" width="'.$largura.'" height="'.$altura.'">
<param name="autostart" value="true" />
<param name="src" value="'.$arquivo.'" />
<param name="width" value="'.$largura.'" />
<param name="height" value="'.$altura.'" />
<embed type="audio/x-pn-realaudio-plugin" autostart="true" src="'.$arquivo.'" width="'.$largura.'" height="'.$altura.'"></embed>
</object>
		';
			break;
	}
	$arq_html = new XoopsFormElementTray(_AM_SOCIALNET_MPB_HTML, "<br />");
	$arq_html->addElement(new XoopsFormLabel("", $cod_html));
	$arq_html->addElement(new XoopsFormLabel("", "<pre>".htmlspecialchars($cod_html)."</pre>"));
	$med_form->addElement($arq_html);
}
$med_form->addElement(new XoopsFormText(_AM_SOCIALNET_MED_30_NAME, "med_30_name", 50, 50, $med_classe->getVar("med_30_name")), true);
$tipo_select = new XoopsFormSelect("", "med_10_type", $med_classe->getVar("med_10_type"));
$tipo_select->setExtra("onchange='LargAlt();'");
$tipo_select->addOptionArray(array(1 => _AM_SOCIALNET_MED_10_TYPE_1, 2=>_AM_SOCIALNET_MED_10_TYPE_2, 3=>_AM_SOCIALNET_MED_10_TYPE_3, 4=>_AM_SOCIALNET_MED_10_TYPE_4, 5=>_AM_SOCIALNET_MED_10_TYPE_5));
$tipo_tray = new XoopsFormElementTray(_AM_SOCIALNET_MED_10_TYPE);
$tipo_tray->addElement($tipo_select);
$tipo_tray->addElement(new XoopsFormLabel("", "<br /><div id='largalt' ".(($med_classe->getVar("med_10_id") <= 0) ? "style='display:none'" : "").">"));
$tipo_tray->addElement(new XoopsFormText(_AM_SOCIALNET_MED_10_WIDTH, "med_10_width", 4, 4, $med_classe->getVar("med_10_width")), true);
$tipo_tray->addElement(new XoopsFormText(_AM_SOCIALNET_MED_10_HEIGHT, "med_10_height", 4, 4, $med_classe->getVar("med_10_height")), true);
$tipo_tray->addElement(new XoopsFormLabel("", "</div>"));
$med_form->addElement($tipo_tray);
$med_file = new XoopsFormFile('', 'med_30_file', $xoopsModuleConfig['socialnet_mmax_filesize']*1024);
$arquivo_tray = new XoopsFormElementTray(_AM_SOCIALNET_MED_30_FILE, '&nbsp;');
$arquivo_tray->addElement($med_file);
$med_form->addElement($arquivo_tray);
$med_form->addElement(new XoopsFormRadioYN(_AM_SOCIALNET_MED_12_SHOW, 'med_12_show',$med_classe->getVar("med_12_show")));
$med_form->addElement(new XoopsFormHidden('med_10_id', $med_classe->getVar('med_10_id')));
$med_form->addElement(new XoopsFormHidden('op', $form['op']));
$med_buttons_tray = new XoopsFormElementTray("", "&nbsp;&nbsp;");
$med_button_cancel = new XoopsFormButton("", "cancelar", _CANCEL);
$med_buttons_tray->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
$med_button_cancel->setExtra("onclick=\"document.location= '".XOOPS_URL."/modules/socialnet/admin/treemedia.php'\"");
$med_buttons_tray->addElement($med_button_cancel);
$med_form->addElement($med_buttons_tray);
?>