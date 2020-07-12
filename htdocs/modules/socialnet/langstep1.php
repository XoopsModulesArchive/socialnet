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
$base = XOOPS_ROOT_PATH.'/modules';
if(is_dir($base)){
  if ($dh = opendir($base)) {
    while (($file = readdir($dh)) !== false) {
      if($file!='.'&&$file!='..'&&is_dir($base.'/'.$file))
        $mo_dir[] = $file;
      }
    closedir($dh);
  }
} else {
  echo printf(_MD_SOCIALNET_LANGTOOL_DIRERROR, $base);
}
$mo_dir[] = 'xoops_core_lang_files';
$content .= '<input type="hidden" name="step" value="2">';
$content .= _MD_SOCIALNET_LANGTOOL_SESELECTMOD.'<p></p>';
$content .= '<select name="module">';
$num = sizeof($mo_dir);
for($i=0;$i<$num;$i++){
  $content .= '<option>'.$mo_dir[$i].'</option>';
}
$content .= '</select>';
$content .= '<p>'._MD_SOCIALNET_LANGTOOL_MANUALPATH.'</p><input type="text" name="manual_path" value="';
if(isset($_SESSION['socialnet']['base_dir'])) {
	$content .= $_SESSION['socialnet']['base_dir'];
}
$content .= '" size="60"><p></p>';
$content .= '<input type="submit">';
?>