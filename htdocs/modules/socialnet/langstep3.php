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
if(!isset($pass_step4)){
  if($_SESSION['socialnet']['module']&&$_SESSION['socialnet']['from']&&$_SESSION['socialnet']['to']){
    $dir = $_SESSION['socialnet']['base_dir'].$_SESSION['socialnet']['from'].$_SESSION['socialnet']['path'];
    if (is_dir($dir)) {
      if ($dh = opendir($dir)) {
        if($_SESSION['socialnet']['path'] != '')
            $lang_file[] = '..';
        while (($file = readdir($dh)) !== false) {
          if($file!='.'&&$file!='..')
            $lang_file[] = $file;
          }
        closedir($dh);
      }
    }
    $num=sizeof($lang_file);
    $content .= '<input type="hidden" name="step" value="4">';
    $content .= _MD_SOCIALNET_LANGTOOL_SESELECTFILE;
    if($_SESSION['socialnet']['file'] != '') {
        $content .= '<a href="#focus">[>>>]</a>';
    }
    $content .= '<hr><table cellpadding="0" cellspacing="0">';
    $k = 0;
    for($i=0;$i<$num;$i++){
      if(preg_match('/(gif)|(jpg)|(jpeg)|(png)|(htaccess)|(html)|(htm)/i', $lang_file[$i])){
        if($k==0) $k =1;
        else $k=0;
        continue;
      }
      ($i%2==$k) ? $bgcolor = '#D8E3B8' : $bgcolor = '#339933';
      $the_file1 = $_SESSION['socialnet']['base_dir'].$_SESSION['socialnet']['from'].$_SESSION['socialnet']['path'].'/'.$lang_file[$i];
      $the_file2 = $_SESSION['socialnet']['base_dir'].$_SESSION['socialnet']['to'].$_SESSION['socialnet']['path'].'/'.$lang_file[$i];
      $content .= '<tr bgcolor="'.$bgcolor.'"><td>';
      $content .= '<input type="radio" name="the_file" value="'.$lang_file[$i].'">';
      if($_SESSION['socialnet']['file'] == $lang_file[$i]) {
          $content .= '</td><td style="color:red;font-weight:900;font-size:120%;"><a name="focus"></a>'.$lang_file[$i].'</td>';
      } else {
          $content .= '</td><td>'.$lang_file[$i].'</td>';
      }
      $content .= '<td>';
      if($lang_file[$i] == '..')
      {
        $content .= '&nbsp;</td>';
        continue;
      }
      if(is_dir($the_file1))
        $content .= _MD_SOCIALNET_LANGTOOL_ISFOLDER;
      if(file_exists($the_file2)){
        $content .= _MD_SOCIALNET_LANGTOOL_FILEEXIST;
      }
      $content .= '</td>';
    }
    $content .= '</table><hr><input type="submit">';
  }
}
?>
