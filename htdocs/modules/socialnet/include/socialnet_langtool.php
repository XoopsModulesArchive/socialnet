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

function showitem($str, $key){
  if(!$_SESSION['socialnet']['step'] || ($_SESSION['socialnet']['step'] == $key && $key == 1))
    return '<font color="red">'.$str.'</font>';
  else if($_SESSION['socialnet']['step'] == $key)
    return ' => <font color="red">'.$str.'</font>';
  else if($key == 1)
    return '<a href="?step=1">' . $str . '</a>';
  else if($key == 2 && isset($_SESSION['socialnet']['module']))
    return ' => <a href="?step=2">' . $str . '</a>';
  else if($key == 3 && isset($_SESSION['socialnet']['from']))
    return ' => <a href="?step=3">' . $str . '</a>';
  else
    return ' => '.$str;
}

function navbar(){
  $str = _MD_SOCIALNET_LANGTOOL_STEPS;
  $str .= showitem(_MD_SOCIALNET_LANGTOOL_STEPS_MODULE, 1);
  $str .= showitem(_MD_SOCIALNET_LANGTOOL_STEPS_LANGUAGE, 2);
  $str .= showitem(_MD_SOCIALNET_LANGTOOL_STEPS_FILE, 3);
  $str .= showitem(_MD_SOCIALNET_LANGTOOL_STEPS_TRANSLATE, 4);
  $str .= showitem(_MD_SOCIALNET_LANGTOOL_STEPS_FINISH, 5);
  return $str;
}

function lang_trans($matches) {  
    if(isset($_POST[$matches[1]]))
        $new_string = preg_replace('/\'/', '\\\'', stripslashes($_POST[$matches[1]]));
    else
        $new_string = preg_replace('/\'/', '\\\'', stripslashes($matches[2]));
    $i =0 ;
    
    while(strpos($new_string, '\\\\')){
        $new_string = str_replace('\\\\', '\\', $new_string);
    }
    if(preg_match_all('/\\\\\'\s*\.(.*?)\s*\.\s*\\\\\'/ism', $new_string, $inmatches)) {
    	foreach($inmatches[1] AS $key => $val) {
    		$inmatches[1][$key] = '\' . ' . stripslashes($val) . ' . \'';
    	}
    	$new_string = str_replace($inmatches[0], $inmatches[1], $new_string);
    }
        
        return 'define(\''.$matches[1].'\', \''.$new_string.'\');'. chr(10);
}

function getlist($dir, &$var){
  if(is_dir($dir)){
    if($dh = opendir($dir)){
      while(($file = readdir($dh)) !== false){
        if($file != '.' && $file != '..')
          $the_list[] = getlist($dir . '/' . $file, $var);
      }
    }
  } else {
    $var[] = $dir;
  }
}
?>