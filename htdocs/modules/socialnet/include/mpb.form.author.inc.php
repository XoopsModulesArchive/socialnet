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
	die("Ooops!");
}
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
$mpb_form = new XoopsThemeForm($form['title'], "socialnet_mpb_form", $_SERVER['PHP_SELF'], "post");
if($mpb_10_id > 0){
	$mpb_infos_tray = new XoopsFormElementTray(_AM_SOCIALNET_INFO, "<br />");
	$mpb_infos_tray->addElement(new XoopsFormLabel(_AM_SOCIALNET_BY, XoopsUser::getUnameFromId($socialnet_classe->getVar('usr_10_uid'))));
	$mpb_infos_tray->addElement(new XoopsFormLabel(_AM_SOCIALNET_DTCREATED, date(_DATESTRING, $socialnet_classe->getVar('mpb_22_create'))));
	$mpb_infos_tray->addElement(new XoopsFormLabel(_AM_SOCIALNET_DTUPDATE, date(_DATESTRING, $socialnet_classe->getVar('mpb_22_uptodate'))));
	$mpb_infos_tray->addElement(new XoopsFormLabel(_AM_SOCIALNET_VIEWS, $socialnet_classe->getVar('mpb_10_counter')));
	$mpb_button_limpacont = new XoopsFormButton("", "limpacont", _AM_SOCIALNET_LIMPACONT);
	$mpb_button_limpacont->setExtra("onclick=\"document.location= '".XOOPS_URL."/modules/socialnet/treetreeauthor.php?op=limpacont&mpb_10_id=".$mpb_10_id."'\"");
	$mpb_infos_tray->addElement($mpb_button_limpacont);
	$mpb_form->addElement($mpb_infos_tray);

}
/*$grupos_ids = ($mpb_10_id > 0) ? $moduleperm_handler->getGroupIds("socialnet_mpublish_acesso", $mpb_10_id, $xoopsModule->getVar('mid')) : $xoopsUser->getGroups();
$perm_grupos_select = new XoopsFormSelectGroup(_AM_SOCIALNET_GROUPS, 'grupos_perm', true, $grupos_ids, 5, true);
$mpb_form->addElement($perm_grupos_select);
*/
$mpb_form->addElement(new XoopsFormLabel(_AM_SOCIALNET_USR_10_UID, $xoopsUser->getVar('uname')));

$mpb_show_tray = new XoopsFormElementTray(_AM_SOCIALNET_MPB_10_IDPAI, "&nbsp;&nbsp;&nbsp;");
$exibir_select = $socialnet_classe->geraMenuSelect();
$mpb_show_tray->addElement(new XoopsFormLabel("", "<b>".$exibir_select[$mpb_10_idpai]."</b>"));
$mpb_show_tray->addElement(new XoopsFormText(_AM_SOCIALNET_MPB_10_ORDER, "mpb_10_order", 5, 6, $socialnet_classe->getVar("mpb_10_order")));
$mpb_form->addElement($mpb_show_tray);
$mpb_form->addElement(new XoopsFormText(_AM_SOCIALNET_MPB_30_MENU, "mpb_30_menu", 50, 50, $socialnet_classe->getVar("mpb_30_menu")), true);
$mpb_tray_title_withoutlink = new XoopsFormElementTray(_AM_SOCIALNET_MPB_30_TITLE);
$mpb_title = new XoopsFormText("", "mpb_30_title", 50,100, $socialnet_classe->getVar("mpb_30_title"));
$mpb_tray_title_withoutlink->addElement($mpb_title);
$mpb_withoutlink = new XoopsFormCheckBox("", "mpb_12_withoutlink", $socialnet_classe->getVar("mpb_12_withoutlink"));
$mpb_withoutlink->setExtra("id='mpb_12_withoutlink' onclick='if(this.checked){ document.getElementById(\"mpb_external\").checked=false; document.getElementById(\"mpb_page\").checked=false; document.getElementById(\"mpb_frame\").checked=false; document.getElementById(\"mpb_external_span\").style.display=\"none\"; document.getElementById(\"mpb_35_content_span\").style.display=\"none\"; document.getElementById(\"mpb_page_span\").style.display=\"none\"; document.getElementById(\"mpb_30_file_span\").style.display=\"none\"; }else{ document.getElementById(\"mpb_35_content_span\").style.display=\"\";".(($xoopsModuleConfig['socialnet_conf_wysiwyg']) ? "tinyMCE.execCommand(\"mceResetDesignMode\");" : "" )."}'");
$mpb_withoutlink->addOption(1, _AM_SOCIALNET_MPB_12_SEMLINK);
$mpb_tray_title_withoutlink->addElement($mpb_withoutlink);

$mpb_external_check = new XoopsFormCheckBox("", "mpb_external", ((substr($socialnet_classe->getVar("mpb_30_file"), 0, 4) == 'ext:') ? 1 : 0));
$mpb_external_check->setExtra("id='mpb_external' onclick='if(this.checked) { document.getElementById(\"mpb_page\").checked=false; document.getElementById(\"mpb_12_withoutlink\").checked=false; document.getElementById(\"mpb_frame\").checked=false; document.getElementById(\"mpb_external_span\").style.display=\"\"; document.getElementById(\"mpb_30_file_span\").style.display=\"none\"; document.getElementById(\"mpb_page_span\").style.display=\"none\"; document.getElementById(\"mpb_35_content_span\").style.display=\"none\";}else{document.getElementById(\"mpb_external_span\").style.display=\"none\";document.getElementById(\"mpb_35_content_span\").style.display=\"\";".(($xoopsModuleConfig['socialnet_conf_wysiwyg']) ? "tinyMCE.execCommand(\"mceResetDesignMode\");" : "" )."}'");
$mpb_external_check->addOption(1, _AM_SOCIALNET_MPB_EXTERNAL);
$mpb_tray_title_withoutlink->addElement($mpb_external_check);

$mpb_frame_check = new XoopsFormCheckBox("", "mpb_frame", ((substr($socialnet_classe->getVar("mpb_30_file"), 0, 4) == 'http') ? 1 : 0));
$mpb_frame_check->setExtra("id='mpb_frame' onclick='if(this.checked) { document.getElementById(\"mpb_external\").checked=false; document.getElementById(\"mpb_page\").checked=false; document.getElementById(\"mpb_12_withoutlink\").checked=false; document.getElementById(\"mpb_external_span\").style.display=\"none\"; document.getElementById(\"mpb_30_file_span\").style.display=\"\"; document.getElementById(\"mpb_page_span\").style.display=\"none\"; document.getElementById(\"mpb_35_content_span\").style.display=\"none\";}else{document.getElementById(\"mpb_30_file_span\").style.display=\"none\";document.getElementById(\"mpb_35_content_span\").style.display=\"\";".(($xoopsModuleConfig['socialnet_conf_wysiwyg']) ? "tinyMCE.execCommand(\"mceResetDesignMode\");" : "" )."}'");
$mpb_frame_check->addOption(1, _AM_SOCIALNET_MPB_FRAME);
$mpb_tray_title_withoutlink->addElement($mpb_frame_check);
$mpb_page = new XoopsFormCheckBox("", "mpb_page", (($socialnet_classe->getVar("mpb_30_file") != "" && substr($socialnet_classe->getVar("mpb_30_file"), 0, 4) != 'http' && substr($socialnet_classe->getVar("mpb_30_file"), 0, 4) != 'ext:') ? 1 : 0));
$mpb_page->setExtra("id='mpb_page' onclick='if(this.checked){ document.getElementById(\"mpb_external\").checked=false; document.getElementById(\"mpb_frame\").checked=false; document.getElementById(\"mpb_12_withoutlink\").checked=false; document.getElementById(\"mpb_external_span\").style.display=\"none\"; document.getElementById(\"mpb_35_content_span\").style.display=\"none\";document.getElementById(\"mpb_30_file_span\").style.display=\"none\";document.getElementById(\"mpb_page_span\").style.display=\"\";}else{ document.getElementById(\"mpb_35_content_span\").style.display=\"\";document.getElementById(\"mpb_page_span\").style.display=\"none\";".(($xoopsModuleConfig['socialnet_conf_wysiwyg']) ? "tinyMCE.execCommand(\"mceResetDesignMode\");" : "" )."}'");
$mpb_page->addOption(1, _AM_SOCIALNET_MPB_FROMFILE);
$mpb_tray_title_withoutlink->addElement($mpb_page);

$mpb_form->addElement($mpb_tray_title_withoutlink);
$mpb_tray_content = new XoopsFormElementTray(_AM_SOCIALNET_MPB_35_CONTENT, "");
$mpb_tray_content->addElement(new XoopsFormLabel("", "<span id='mpb_35_content_span' ".(($socialnet_classe->getVar("mpb_30_file") != '' || $socialnet_classe->getVar("mpb_12_withoutlink") == 1) ? 'style="display:none"' : '').">"));
if(!$xoopsModuleConfig['socialnet_conf_wysiwyg']){
	$mpb_tray_content->addElement(new XoopsFormDhtmlTextArea("", "mpb_35_content", $socialnet_classe->getVar("mpb_35_content")));
}else{
	$mpb_wysiwyg_url = XOOPS_URL.$xoopsModuleConfig['socialnet_conf_wysiwyg_path'];
	//if($xoopsModuleConfig['socialnet_conf_gzip']){

/*
		echo '
<!-- TinyMCE -->
<!-- /TinyMCE -->
		';
	}else{
		echo '
<!-- TinyMCE -->
<!-- /TinyMCE -->';
*/
	}
	//$textarea = new XoopsFormTextArea("", "mpb_35_content", $socialnet_classe->getVar("mpb_35_content", "n"), 30);
	//$textarea->setExtra("style='width: 100%' class='socialnet_wysiwyg'");
	//$mpb_tray_content->addElement($textarea);
	//$mpb_tray_content->addElement(new XoopsFormLabel("", $socialnet_classe->PegaSmileys()));

$mpb_tray_content->addElement(new XoopsFormLabel("", "</span><span id='mpb_30_file_span' ".((substr($socialnet_classe->getVar("mpb_30_file"), 0, 4) != 'http') ? 'style="display:none"' : '').">"));
$mpb_tray_content->addElement(new XoopsFormText(_AM_SOCIALNET_MPB_FRAME_URL, 'mpb_30_file_frame', 30, 100, ((substr($socialnet_classe->getVar("mpb_30_file"), 0, 4) == 'http') ? $socialnet_classe->getVar("mpb_30_file") : '')));
$mpb_tray_content->addElement(new XoopsFormLabel("", "</span>"));

$mpb_tray_content->addElement(new XoopsFormLabel("", "</span><span id='mpb_external_span' ".((substr($socialnet_classe->getVar("mpb_30_file"), 0, 4) != 'ext:') ? 'style="display:none"' : '').">"));
$mpb_tray_content->addElement(new XoopsFormText(_AM_SOCIALNET_MPB_EXTERNAL_URL, 'mpb_30_file_external', 30, 100, ((substr($socialnet_classe->getVar("mpb_30_file"), 0, 4) == 'ext:') ? substr($socialnet_classe->getVar("mpb_30_file"), 4) : 'http://')));
$mpb_tray_content->addElement(new XoopsFormLabel("", "</span>"));

$mpb_tray_content->addElement(new XoopsFormLabel("", "<span id='mpb_page_span' ".(($socialnet_classe->getVar("mpb_30_file") == "" || substr($socialnet_classe->getVar("mpb_30_file"), 0, 4) == 'http' || substr($socialnet_classe->getVar("mpb_30_file"), 0, 4) == 'ext:') ? 'style="display:none"' : '').">"));
$pages_select = new XoopsFormSelect(_AM_SOCIALNET_SELECT, "page", $socialnet_classe->getVar("mpb_30_file"));
$pages_select->addOptionArray($cfi_classe->listPages());
$mpb_tray_content->addElement($pages_select);
$mpb_tray_content->addElement(new XoopsFormLabel("", "<a href='".XOOPS_URL."/modules/socialnet/admin/treepages.php?op=contentfiles_adicionar'>"._ADD."</a></span>"));

$mpb_form->addElement($mpb_tray_content);
$mpb_options_tray = new XoopsFormElementTray(_OPTIONS,'<br />');
$mpb_visible_select = new XoopsFormSelect(_AM_SOCIALNET_MPB_11_VISIBLE, "mpb_11_visible", $socialnet_classe->getVar("mpb_11_visible"));
$mpb_visible_select->addOptionArray(array(1=>_AM_SOCIALNET_MPB_11_VISIBLE_1, 3=>_AM_SOCIALNET_MPB_11_VISIBLE_3, 2=>_AM_SOCIALNET_MPB_11_VISIBLE_2, 4=>_AM_SOCIALNET_MPB_11_VISIBLE_4));
$mpb_options_tray->addElement($mpb_visible_select);
$mpb_open_select = new XoopsFormSelect(_AM_SOCIALNET_MPB_11_OPEN, "mpb_11_open", $socialnet_classe->getVar("mpb_11_open"));
$mpb_open_select->addOptionArray(array(0=>_AM_SOCIALNET_MPB_11_OPEN_0, 1=>_AM_SOCIALNET_MPB_11_OPEN_1));
$mpb_options_tray->addElement($mpb_open_select);
$mpb_comments = new XoopsFormCheckBox("", "mpb_12_comments", $socialnet_classe->getVar("mpb_12_comments"));
$mpb_comments->addOption(1,_AM_SOCIALNET_MPB_12_COMMENTS);
$mpb_options_tray->addElement($mpb_comments);
$mpb_exibesub = new XoopsFormCheckBox("", "mpb_12_exibesub", $socialnet_classe->getVar("mpb_12_exibesub"));
$mpb_exibesub->addOption(1,_AM_SOCIALNET_MPB_12_EXIBESUB);
$mpb_options_tray->addElement($mpb_exibesub);
$mpb_recommend = new XoopsFormCheckBox("", "mpb_12_recommend", $socialnet_classe->getVar("mpb_12_recommend"));
$mpb_recommend->addOption(1,_AM_SOCIALNET_MPB_12_RECOMMEND);
$mpb_options_tray->addElement($mpb_recommend);
$mpb_print = new XoopsFormCheckBox("", "mpb_12_print", $socialnet_classe->getVar("mpb_12_print"));
$mpb_print->addOption(1,_AM_SOCIALNET_MPB_12_PRINT);
$mpb_options_tray->addElement($mpb_print);

$mpb_form->addElement($mpb_options_tray);

$mpb_form->addElement(new XoopsFormHidden('mpb_10_id', $mpb_10_id));
$mpb_form->addElement(new XoopsFormHidden('mpb_10_idpai', $mpb_10_idpai));
$mpb_form->addElement(new XoopsFormHidden('op', $form['op']));
$mpb_buttons_tray = new XoopsFormElementTray("", "&nbsp;&nbsp;");
$mpb_button_cancel = new XoopsFormButton("", "cancelar", _CANCEL);
$mpb_buttons_tray->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
$mpb_button_cancel->setExtra("onclick=\"document.location= '".XOOPS_URL."'\"");
$mpb_buttons_tray->addElement($mpb_button_cancel);
$mpb_form->addElement($mpb_buttons_tray);
?>