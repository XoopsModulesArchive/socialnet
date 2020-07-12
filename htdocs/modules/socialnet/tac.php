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
$xoopsLogger->activated = false;
include_once "header.php";
// *******************************************************************************
// **** Main
// *******************************************************************************

/**
 * Expected values:
 *
 * $_GET['sec_id'] = ID of the Section (the absence of this parameter Page comes back in White)
 * $_GET['w'] = Width (pattern 100%)
 * $_GET['h'] = Height in pixels (pattern 200)
 * $_GET['noarrows'] = 1 for NON show the sailing arrows (the absence of this parameter does with that the arrows are exhibited)
 * $_GET['notextbar'] = 1 for NON show the text bar (the absence of this parameter does with that the text bar is exhibited)
 * $_GET['delay'] = Time of transition among the prominences - in seconds - (pattern 6)
 * $_GET['barcolor'] = Color of the text bar in HEXADECIMAL WITHOUT # (pattern 326801)
 * $_GET['textcolor'] =  Color of the text in HEXADECIMAL WITHOUT # (standard FFFFFF)
 * $_GET['bartransp'] = Transparency of Barra of Text WITHOUT THE SYMBOL % (pattern 50)
 *
 */


if (isset($_GET)) {
    foreach ($_GET as $k => $v) {
        $$k = $v;
    }
}
$tac = (!empty($_GET['sec_id'])) ? intval($_GET['sec_id']) : 0;
$sec_classe =& spot_getClass(_MI_SOCIALNET_TABLESECSECTION, $tac);
if (empty($tac) || $sec_classe->getVar('sec_10_id') == '' || $sec_classe->contaDestaques() ==0) {
    exit();
}else{
    $w = !empty($w) ? $w : "100%";
    $h = !empty($h) ? intval($h) : 200;
    $arrows = empty($noarrows) ? 1 : 0;
    $bar = empty($notextbar) ? 1 : 0;
    $delay = !empty($delay) ? intval($delay) : 6;
    $barcolor = !empty($barcolor) ? $barcolor : "326801";
    $textcolor = !empty($textcolor) ? $textcolor : "FFFFFF";
    $bartransp = !empty($bartransp) ? intval($bartransp) : 50;
    echo '
<style type="text/css">
div#dstacs_'.$tac.'.jdGallery .slideInfoZone
{
	position: absolute;
	z-index: 17;
	width: 100%;
	margin: 0px;
	left: 0;
	bottom: 0;
	height: 30px;
	background: #'.$barcolor.';
	color: #'.$textcolor.';
	text-indent: 0;
	overflow: hidden;
}
div#dstacs_'.$tac.'.jdGallery .slideInfoZone div a
{
	padding: 0;
	margin: 0;
	font-family: Tahoma, Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: normal !important;
	color:#'.$textcolor.' !important;
	text-decoration:none;
}
</style>
';
    echo $sec_classe->montaGaleria($h, $tac, $arrows, $bar, $delay, $bartransp, $w);
}