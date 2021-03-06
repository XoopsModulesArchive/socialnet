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

include 'langheader.php';
include 'include/socialnet_zip.lib.php';
// *******************************************************************************
// **** Main
// *******************************************************************************

if(isset($_SESSION['socialnet'])) {
    $dir = $_SESSION['socialnet']['base_dir'];
    getlist($dir . $_SESSION['socialnet']['to'], $var);
    $data = array();
    $zipfile = new Compress_zip;
    $i = 0;

    foreach($var as $file){
      $data[$i]['name'] = str_replace($dir, '', $file);
      $data[$i]['data'] = file_get_contents($file);
      $i++;
    }

    $zipfilename = date('Ymd') . '_' . $_SESSION['socialnet']['module'] . '_' . $_SESSION['socialnet']['to'] . '.zip';
    header("Content-type: application/octet-stream");
    header("Content-disposition: attachment; filename=".$zipfilename);
    echo $zipfile->compress($data);
} else {
    header('Location: /');
    exit();
}
?>