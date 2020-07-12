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

include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
$sec_form = new XoopsThemeForm($form['title'], 'secform', 'sec.php', 'post', true);
$sec_form->addElement(new XoopsFormText(_AM_SOCIALNET_NAME, "sec_30_name", 30, 100, $sec_classe->getVar("sec_30_name")), true);
$sec_form->addElement(new XoopsFormHidden('sec_10_id',  $sec_classe->getVar("sec_10_id")));
$sec_form->addElement(new XoopsFormHidden('op', "salve"));
$secbuttons_tray = new XoopsFormElementTray("", "&nbsp;&nbsp;");
$secbutton_cancel = new XoopsFormButton("", "cancelar", _CANCEL);
$secbuttons_tray->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
$secbutton_cancel->setExtra("onclick=\"history.go(-1);\"");
$secbuttons_tray->addElement($secbutton_cancel);
$sec_form->addElement($secbuttons_tray);