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

if(!defined('XOOPS_ROOT_PATH')) exit();
if($_POST['module'] || $_SESSION['socialnet']['module']){
  $sql = 'SELECT * FROM `'.$xoopsDB->prefix('socialnet_languages').'`';
  if (!$result = $xoopsDB->query($sql) ) {
    redirect_header(XOOPS_URL.'/',1,_MD_ERROROCCURED);
    exit();
  }

  $content .= '<input type="hidden" name="step" value="3">';
  $content .= _MD_SOCIALNET_LANGTOOL_SESELECTLANG.'<p>';
  $content .= _MD_SOCIALNET_LANGTOOL_FROM.'<p><select name="from">';
  while ( $row = $xoopsDB->fetchArray($result) ) {
    $content .= '<option value="'.$row['dirname'].'">'.$row['lang_title'].'</option>';
  }
  $content .= '</select><p>'._MD_SOCIALNET_LANGTOOL_TO.'<p><select name="to">';
  @mysql_data_seek($result, 0);
  while ($row = $xoopsDB->fetchArray($result)){
    $content .= '<option value="'.$row['dirname'].'">'.$row['lang_title'].'</option>';
  }
  $content .= '</select>';
  $content .= '<input type="submit">';
}
?>