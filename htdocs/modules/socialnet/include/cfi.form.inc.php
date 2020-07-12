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
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
echo "<br>";
echo "<hr>";
echo "<div style='color: #FF0000; font-size: 20px'>  "._AM_SOCIALNET_EXTENDIONYOUCAN."</div>";
echo "<img src='../images/icons/open.gif'> ". _AM_SOCIALNET_EXTENSIONUPLOADCONTENT . " ";

$cfi_form = new XoopsThemeForm($form['title'], "socialnet_cfi_form", $_SERVER['PHP_SELF'], "post");
$cfi_form->setExtra('enctype="multipart/form-data"');
$cfi_form->addElement(new XoopsFormText(_AM_SOCIALNET_CFI_30_NAME, "cfi_30_name", 50, 50, $cfi_classe->getVar("cfi_30_name")), true);
$cfi_file = new XoopsFormFile('', 'cfi_30_file', $xoopsModuleConfig['socialnet_max_filesize']*1024);
$arquivo_tray = new XoopsFormElementTray(_AM_SOCIALNET_CFI_30_FILE, '&nbsp;');
$arquivo_tray->addElement($cfi_file);
$cfi_form->addElement($arquivo_tray);
$cfi_form->addElement(new XoopsFormRadioYN(_AM_SOCIALNET_CFI_12_SHOW, 'cfi_12_show',$cfi_classe->getVar("cfi_12_show")));
$cfi_form->addElement(new XoopsFormHidden('cfi_10_id', $cfi_classe->getVar('cfi_10_id')));
$cfi_form->addElement(new XoopsFormHidden('op', $form['op']));
$cfi_buttons_tray = new XoopsFormElementTray("", "&nbsp;&nbsp;");
$cfi_button_cancel = new XoopsFormButton("", "cancelar", _CANCEL);
$cfi_buttons_tray->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
$cfi_button_cancel->setExtra("onclick=\"document.location= '".XOOPS_URL."/modules/socialnet/admin/treepages.php'\"");
$cfi_buttons_tray->addElement($cfi_button_cancel);
$cfi_form->addElement($cfi_buttons_tray);
?>