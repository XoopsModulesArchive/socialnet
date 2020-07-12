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

include_once "../../mainfile.php";
include_once "header.php";
// *******************************************************************************
// **** Main
// *******************************************************************************

if (!$_POST) {
    echo "<h1>".$xoopsModule->getVar("name")."</h1>";
    echo _MD_SOCIALNET_PROMOTE."<br /><br />";
    include_once XOOPS_ROOT_PATH."/modules/socialnet/include/generator.form.inc.php";
    $dstac_form->display();
}else{
    if (isset($_POST)) {
        foreach ($_POST as $k => $v) {
            $$k = $v;
        }
    }
    $sec_classe =& spot_getClass(_MI_SOCIALNET_TABLESECSECTION, $sec_10_id);
    if (empty($sec_10_id) || $sec_classe->getVar('sec_10_id') == '' || $sec_classe->contaDestaques() == 0) {
        xoops_error(sprintf(_MD_SOCIALNET_SEC_404, $sec_classe->getVar("sec_30_name")));
    }else{
        $iframe = '<iframe src="'.XOOPS_URL.'/modules/socialnet/tac.php?sec_id='.$sec_10_id;
        $iframe .= ($spot_w != "100%") ? '&w='.$spot_w : '';
        $iframe .= ($spot_h != 200) ? '&h='.intval($spot_h) : '';
        $iframe .= ($arrows == 0) ? '&noarrows=1' : '';
        $iframe .= ($bar == 0) ? '&notextbar=1' : '';
        $iframe .= ($delay != 6) ? '&delay='.intval($delay) : '';
        $iframe .= ($barcolor != "326801") ? '&barcolor='.$barcolor : '';
        $iframe .= ($textcolor != "FFFFFF") ? '&textcolor='.$textcolor : '';
        $iframe .= ($transp != 50) ? '&bartransp='.$transp : '';
        $iframe .= '" scrolling="no" frameborder="0" width="'.$spot_w.'" height="'.$spot_h.'" marginheight="0" marginwidth="0" align="'.$align.'"></iframe>';
        echo "<h3>"._MD_SOCIALNET_FORM_TITLE."</h3>";
        echo $iframe;
        echo "<br /><br />"._MD_SOCIALNET_COPY_PASTE."<br /><br />";
        echo "<textarea rows='5' style='width:90%; padding:5px; margin-top:10px; margin-bottom:10px;' onfocus='this.select();' >".$iframe."</textarea>";
    }
    include_once XOOPS_ROOT_PATH."/modules/socialnet/include/generator.form.inc.php";
    $dstac_form->display();
}

/**
* Adding to the module js and css of the lightbox and new ones
*/
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/leftmenu.css');


include("../../footer.php");
