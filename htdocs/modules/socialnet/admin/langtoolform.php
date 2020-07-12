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

function the_form($data=NULL){
?>
<br />
<h3><img src='../images/profile/toggle.gif'><?=_AM_SOCIALNET_LANGTOOL_LANGTOOL;?></h3>
<br />
<form method="post">
<input type="hidden" name="lang" value="1">
<table align="center" cellpadding="1" cellspacing="1" width="400" border="1">
 <tr>
  <td width="100"><?=_AM_SOCIALNET_LANGTOOL_LANGTITLE;?></td>
  <td width="300">
   <input type="text" name="lang_title" value="<?=$data['lang_title'];?>" size="40">
  </td>
 </tr>
 <tr>
  <td width="100"><?=_AM_SOCIALNET_LANGTOOL_FOLDER;?></td>
  <td width="300">
   <input type="text" name="dirname" value="<?=$data['dirname'];?>" size="40">
  </td>
 </tr>
 <tr>
  <td colspan="4" align="center">
   <input type="submit">
   <input type="reset">
  </td>
 </tr>
</table>
</form>
<?
}

?>