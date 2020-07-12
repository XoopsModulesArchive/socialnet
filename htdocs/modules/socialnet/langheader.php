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

require('../../mainfile.php');
include 'include/socialnet_langtool.php';
// *******************************************************************************
// **** Main
// *******************************************************************************

DEFINE('LANG_TOOL_PATTERN', '/define\s*\(\s*[\'"]([^\'"]*?)[\'"]\s*,\s*[\'"](.*?)[\'"]\s*\)\s*;\s*/ism');
$skip_patterns = array(
    '/\/\/.*/',
    '/\/\*([^\*]*)\*\//s',
);
//	'/define\s*\(\s*[\'"]([^\'"]*?)[\'"]\s*,\s*([^\'"]*?)\s*;\s*/ism',

if(isset($_POST['step']))
    $step = $_POST['step'];
else if(isset($_GET['step']) && $_GET['step'] < 4)
    $step = $_GET['step'];
else if(isset($_SESSION['socialnet']['step']))
    $step = 3;
else $step = 1;

switch($step)
{
    case 1:
        $_SESSION['socialnet']['step'] = 1;
    break;
    case 2:
        if(isset($_POST['module']))
        {
            if($_POST['manual_path'] != '' && $_POST['manual_path'] != $_SESSION['socialnet']['base_dir'] && file_exists($_POST['manual_path'])) {
            	$_SESSION['socialnet']['base_dir'] = $_POST['manual_path'];
            	$_SESSION['socialnet']['module'] = $_POST['manual_path'];
            } else if($_POST['module'] == 'xoops_core_lang_files') {
            	$_SESSION['socialnet']['base_dir'] = XOOPS_ROOT_PATH.'/language/';
            	$_SESSION['socialnet']['module'] = $_POST['module'];
            } else {
            	$_SESSION['socialnet']['base_dir'] = XOOPS_ROOT_PATH.'/modules/'.$_POST['module'].'/language/';
            	$_SESSION['socialnet']['module'] = $_POST['module'];
            }
        	
        }
        $_SESSION['socialnet']['step'] = 2;
    break;
    case 3:
        if($_POST['step'] == '3' && $_POST['from'] != $_POST['to']){
          $_SESSION['socialnet']['from'] = $_POST['from'];
          $_SESSION['socialnet']['to'] = $_POST['to'];
          $_SESSION['socialnet']['step'] = 3;
          $_SESSION['socialnet']['path'] = '';
        } else $_SESSION['socialnet']['step'] = 3;
    break;
    case 4:
        $_SESSION['socialnet']['file'] = preg_replace('/..\//', '', $_POST['the_file']);
        $file_from = $_SESSION['socialnet']['base_dir'].$_SESSION['socialnet']['from'].$_SESSION['socialnet']['path'].'/'.$_SESSION['socialnet']['file'];
        $file_to = $_SESSION['socialnet']['base_dir'].$_SESSION['socialnet']['to'].$_SESSION['socialnet']['path'].'/'.$_SESSION['socialnet']['file'];
        $pass_step4 = 1;
        if(is_dir($file_to)||is_dir($file_from)){
          $pass_step4 = NULL;
          if($_POST["the_file"] != '')
          {
              if($_POST["the_file"] != '..')
                $_SESSION['socialnet']['path'] .= '/'.$_POST["the_file"];
              else
              {
                if(substr_count($_SESSION['socialnet']['path'], '/') < 1)
                    unset($_SESSION['socialnet']['path']);
                else
                {
                    $path_array = explode('/', $_SESSION['socialnet']['path']);
                    $_SESSION['socialnet']['path'] = '';
                    for($i=1;$i<(sizeof($path_array) - 1);$i++)
                        $_SESSION['socialnet']['path'] .= '/' . $path_array[$i];
                }
              }
          }
          $_SESSION['socialnet']['step'] = 3;
        } else $_SESSION['socialnet']['step'] = 4;
    break;
    case 5:
        $_SESSION['socialnet']['step'] = 5;
    break;
    default:
        redirect_header(XOOPS_URL.'/',1,_MD_ERROROCCURED);
        exit();
}

  //unset($_SESSION['socialnet']);
?>
