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
include_once XOOPS_ROOT_PATH."/modules/socialnet/class/formimage.php";
$go2_form = new XoopsThemeForm($form['title'], 'go2form', 'spot.php', 'post', true);
$image_select = new SocialnetFormSelectImage(_AM_SOCIALNET_IMAGE, "spot_30_image", $go2_classe->getVar("spot_30_image"), ((is_array($xoopsModuleConfig['spot_des_img']) && $xoopsModuleConfig['spot_des_img'][0] != "") ? $xoopsModuleConfig['spot_des_img'] : null ));
$go2_form->addElement($image_select);
$section_select = new XoopsFormSelect(_AM_SOCIALNET_SECTION, "sec_10_id", (($go2_classe->getVar("spot_10_id") != "") ? $go2_classe->getVar("sec_10_id") : ((!empty($_REQUEST['sec_10_id'])) ? $_REQUEST['sec_10_id'] : 0)));
$section_select->addOptionArray($sec_select);
$go2_form->addElement($section_select);
$go2_form->addElement(new XoopsFormText(_AM_SOCIALNET_SPOT_30_NAME, "spot_30_name", 30, 100, $go2_classe->getVar("spot_30_name")), true);
$go2_form->addElement(new XoopsFormText(_AM_SOCIALNET_SPOT_30_LINK, "spot_30_link", 30, 150, $go2_classe->getVar("spot_30_link")), true);
$link_select = new XoopsFormSelect(_AM_SOCIALNET_SPOT_11_TARGET, "spot_11_target", $go2_classe->getVar("spot_11_target"));
$link_select->addOptionArray(array(0=>_AM_SOCIALNET_SPOT_11_TARGET_0, 1=>_AM_SOCIALNET_SPOT_11_TARGET_1));
$go2_form->addElement($link_select);
$go2_form->addElement(new XoopsFormRadioYN(_AM_SOCIALNET_SPOT_ACTIVE, 'spot_12_ative', $go2_classe->getVar("spot_12_ative")));
$go2_form->addElement(new XoopsFormHidden('spot_10_id',  $go2_classe->getVar("spot_10_id")));
$go2_form->addElement(new XoopsFormHidden('op', "salve"));
$go2buttons_tray = new XoopsFormElementTray("", "&nbsp;&nbsp;");
$go2button_cancel = new XoopsFormButton("", "cancelar", _CANCEL);
$go2buttons_tray->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
$go2button_cancel->setExtra("onclick=\"history.go(-1);\"");
$go2buttons_tray->addElement($go2button_cancel);
$go2_form->addElement($go2buttons_tray);