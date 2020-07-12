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

include 'header.php';
require 'chatconfig.php';
include "../../mainfile.php";
xoops_header();
?>
<html><head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;CHARSET=<?echo CHARSET;?>">
<SCRIPT LANGUAGE="JavaScript">
<!--
function autoclear() {
  document.s.message.value="";
  document.s.message.focus();
}
-->
</SCRIPT>
</head>
<body class="outer">
<form action="chatmain.php" target="frame2" METHOD="POST" NAME="s" onSubmit="setTimeout(<autoclear()>,100);">
<!--<FORM method="post" action="<? echo $PHP_SELF;?>">-->
<?
//if (!$xoopsUser)
//	echo "<b>Guest Name:</b><INPUT name=\"name\" type=\"text\" size=\"10\" maxlength=\"15\" value=\"\">";
echo "<textarea name=\"message\" rows='3' cols='50'></textarea>";
echo "<br>&nbsp;<INPUT name='submit' type='submit' value='" . _MD_SOCIALNET_POPCHAT_SEND . "'>";
//die("</body></html>");
echo "</form>";
xoops_footer();
?>
