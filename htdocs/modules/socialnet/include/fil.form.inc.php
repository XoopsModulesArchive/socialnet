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
echo "<img src='../images/icons/open.gif'> ". _AM_SOCIALNET_EXTENSIONUPLOAD . " ";

$fil_form = new XoopsThemeForm($form['title'], "socialnet_fil_form", $_SERVER['PHP_SELF'], "post");
$fil_form->setExtra('enctype="multipart/form-data"');
$fil_form->addElement(new XoopsFormText(_AM_SOCIALNET_FIL_30_NAME, "fil_30_name", 50, 50, $fil_classe->getVar("fil_30_name")), true);
$fil_file = new XoopsFormFile('', 'fil_30_file', $xoopsModuleConfig['socialnet_max_filesize']*1024);
$arquivo_tray = new XoopsFormElementTray(_AM_SOCIALNET_FIL_30_FILE, '&nbsp;');
$arquivo_tray->addElement($fil_file);
$fil_form->addElement($arquivo_tray);
$fil_form->addElement(new XoopsFormRadioYN(_AM_SOCIALNET_FIL_12_SHOW, 'fil_12_show',$fil_classe->getVar("fil_12_show")));
$fil_form->addElement(new XoopsFormHidden('fil_10_id', $fil_classe->getVar('fil_10_id')));
$fil_form->addElement(new XoopsFormHidden('op', $form['op']));
$fil_buttons_tray = new XoopsFormElementTray("", "&nbsp;&nbsp;");
$fil_button_cancel = new XoopsFormButton("", "cancelar", _CANCEL);
$fil_buttons_tray->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
$fil_button_cancel->setExtra("onclick=\"document.location= '".XOOPS_URL."/modules/socialnet/admin/treefiles.php'\"");
$fil_buttons_tray->addElement($fil_button_cancel);
$fil_form->addElement($fil_buttons_tray);
?>