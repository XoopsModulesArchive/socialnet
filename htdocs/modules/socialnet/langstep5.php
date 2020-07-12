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
$dir2 = $_SESSION['socialnet']['base_dir'].$_SESSION['socialnet']['to'].$_SESSION['socialnet']['path'];
$file1 = $dir2.'/'.$_SESSION['socialnet']['file'];
$file2 = XOOPS_ROOT_PATH.'/cache/'.$_SESSION['socialnet']['file'];

$path_array = explode('/', $_SESSION['socialnet']['path']);
$mk_path = $_SESSION['socialnet']['base_dir'].$_SESSION['socialnet']['to'];
if(!file_exists($mk_path) && is_writeable($_SESSION['socialnet']['base_dir']))
    mkdir($mk_path);
    
for($i=1;$i<(sizeof($path_array) - 1);$i++)
{
    if(!file_exists($mk_path))
        mkdir($mk_path);
    $mk_path .= '/' . $path_array[$i];
}

if(is_writeable($_SESSION['socialnet']['base_dir'].$_SESSION['socialnet']['to'].$_SESSION['socialnet']['path'])){
  $target_file = $file1;
} else {
  $target_file = $file2;
}

$translated_str = '';
switch($_POST['ext'])
{
    case 'php':
        $file_from = $_SESSION['socialnet']['base_dir'].$_SESSION['socialnet']['from'].$_SESSION['socialnet']['path'].'/'.$_SESSION['socialnet']['file'];
        $source_str = file_get_contents($file_from);
        $translated_str=preg_replace_callback(LANG_TOOL_PATTERN,'lang_trans',$source_str);    
    break;
    case 'tpl':
        $translated_str = $_POST['target'];
    default:
}

$fh = fopen($target_file, 'wb');
if(isset($translated_str))
    fwrite($fh, $translated_str);
fclose($fh);
$content .= _MD_SOCIALNET_LANGTOOL_YOUCANFIND. $target_file;
$content .= '<p><a href="langdownload.php">'._MD_SOCIALNET_LANGTOOL_DOWNLOAD.'</a></p>' . _MD_SOCIALNET_LANGTOOL_SHARE;
?>