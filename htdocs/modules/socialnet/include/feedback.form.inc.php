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
$feedbackform = new XoopsThemeForm($form['title'], "feedbackform", $_SERVER['PHP_SELF'], "post");
$feedbackform->addElement(new XoopsFormText(_AM_SOCIALNET_YNAME, "yname", 35, 50, $xoopsUser->getVar('name')));
$feedbackform->addElement(new XoopsFormText(_AM_SOCIALNET_YEMAIL, "yemail", 35, 50, $xoopsConfig['adminmail']));
$feedbackform->addElement(new XoopsFormText(_AM_SOCIALNET_YSITE, "ydomain", 35, 50, XOOPS_URL));
$feedback_category_tray = new XoopsFormElementTray(_AM_SOCIALNET_FEEDTYPE, "&nbsp;&nbsp;&nbsp;");
$category_select = new XoopsFormSelect("", "feedback_type", _AM_SOCIALNET_TSUGGESTION);
$category_select->addOptionArray(array(_AM_SOCIALNET_TSUGGESTION=>_AM_SOCIALNET_TSUGGESTION, _AM_SOCIALNET_TBUGS=>_AM_SOCIALNET_TBUGS, _AM_SOCIALNET_TESTIMONIAL=>_AM_SOCIALNET_TESTIMONIAL, _AM_SOCIALNET_TFEATURES=>_AM_SOCIALNET_TFEATURES, _AM_SOCIALNET_TOTHERS=>_AM_SOCIALNET_TOTHERS));
$feedback_category_tray->addElement($category_select);
$feedback_category_tray->addElement(new XoopsFormText(_AM_SOCIALNET_TOTHERS, "feedback_other", 25, 50));
$feedbackform->addElement($feedback_category_tray);
$textarea = new XoopsFormDhtmlTextArea(_AM_SOCIALNET_DESC, "feedback_content", "", 20);
$textarea->setExtra("style='width: 100%' class='wysiwyg'");
$feedbackform->addElement($textarea);
$feedbackform->addElement(new XoopsFormHidden('op', $form['op']));
$feedbackbuttons_tray = new XoopsFormElementTray("", "&nbsp;&nbsp;");
$feedbackbutton_cancel = new XoopsFormButton("", "cancel", _CANCEL);
$feedbackbuttons_tray->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
$feedbackbutton_cancel->setExtra("onclick=\"document.location= '".XOOPS_URL."/modules/socialnet/admin/index.php'\"");
$feedbackbuttons_tray->addElement($feedbackbutton_cancel);
$feedbackform->addElement($feedbackbuttons_tray);