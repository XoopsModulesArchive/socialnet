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

function xoops_module_install_socialnet() {
    global $xoopsModule, $xoopsConfig, $xoopsDB;

    $namemodule = "socialnet";
    if( file_exists(XOOPS_ROOT_PATH."/modules/socialnet/language/".$xoopsConfig['language']."/admin.php") ) {
        include_once(XOOPS_ROOT_PATH."/modules/socialnet/language/".$xoopsConfig['language']."/admin.php");
    } else {
        include_once(XOOPS_ROOT_PATH."/modules/socialnet/language/english/admin.php");
    }

	//Creation of the file socialnet/
	$dir = XOOPS_ROOT_PATH."/uploads/socialnet";
	if(!is_dir($dir))
		mkdir($dir, 0777);
		chmod($dir, 0777);
	
	//Creation of the file socialnet/mp3
	$dir = XOOPS_ROOT_PATH."/uploads/socialnet/mp3";
	if(!is_dir($dir))
		mkdir($dir, 0777);
		chmod($dir, 0777);
	
	//Creation of the file socialnet/iphotos
	$dir = XOOPS_ROOT_PATH."/uploads/socialnet/photos";
	if(!is_dir($dir))
		mkdir($dir, 0777);
		chmod($dir, 0777);
		
	//Creation of the file socialnet/groups
	$dir = XOOPS_ROOT_PATH."/uploads/socialnet/groups";
	if(!is_dir($dir))
		mkdir($dir, 0777);
		chmod($dir, 0777);
    
    //Creation of the file socialnet/files
	$dir = XOOPS_ROOT_PATH."/uploads/socialnet/files";
	if(!is_dir($dir))
		mkdir($dir, 0777);
		chmod($dir, 0777);
			
	//Creation of the file socialnet/html
	$dir = XOOPS_ROOT_PATH."/uploads/socialnet/html";
	if(!is_dir($dir))
		mkdir($dir, 0777);
		chmod($dir, 0777);

	//Creation of the file socialnet/media
	$dir = XOOPS_ROOT_PATH."/uploads/socialnet/media";
	if(!is_dir($dir))
		mkdir($dir, 0777);
		chmod($dir, 0777);

// I NEED FIXED THE PROBLEM FOR THE NEWS IMAGES GO TO THIS FOLDER
	//Creation of the file socialnet/news
	$dir = XOOPS_ROOT_PATH."/uploads/socialnet/news";
	if(!is_dir($dir))
		mkdir($dir, 0777);
		chmod($dir, 0777);

//Copie des index.html
	$indexFile = XOOPS_ROOT_PATH."/modules/socialnet/include/index.html";
	copy($indexFile, XOOPS_ROOT_PATH."/uploads/socialnet/index.html");
	copy($indexFile, XOOPS_ROOT_PATH."/uploads/socialnet/mp3/index.html");
	copy($indexFile, XOOPS_ROOT_PATH."/uploads/socialnet/photos/index.html");
	copy($indexFile, XOOPS_ROOT_PATH."/uploads/socialnet/groups/index.html");
    copy($indexFile, XOOPS_ROOT_PATH."/uploads/socialnet/files/index.html");
	copy($indexFile, XOOPS_ROOT_PATH."/uploads/socialnet/html/index.html");
	copy($indexFile, XOOPS_ROOT_PATH."/uploads/socialnet/media/index.html");
	copy($indexFile, XOOPS_ROOT_PATH."/uploads/socialnet/news/index.html");


//I'M WORKING ON THE OPTIONS BELOW
//Copie des blank.gif
	//$blankFile = XOOPS_ROOT_PATH."/modules/socialnet/images/icons/blank.gif";
	//copy($blankFile, XOOPS_ROOT_PATH."/uploads/socialnet/photos/blank.gif");
    //copy($blankFile, XOOPS_ROOT_PATH."/uploads/socialnet/groups/blank.gif");
    //copy($blankFile, XOOPS_ROOT_PATH."/uploads/socialnet/files/blank.gif");

//Copy the pictures for fields   
    copy(XOOPS_ROOT_PATH."/modules/socialnet/flash/clock_calendar.swf", XOOPS_ROOT_PATH."/uploads/socialnet/media/clock_calendar.swf");
    copy(XOOPS_ROOT_PATH."/images/form/player2.swf", XOOPS_ROOT_PATH."/uploads/socialnet/media/player2.swf");
    copy(XOOPS_ROOT_PATH."/images/banners/banner.swf", XOOPS_ROOT_PATH."/uploads/socialnet/files/banner.swf");
    copy(XOOPS_ROOT_PATH."/images/banners/xoops_banner.gif", XOOPS_ROOT_PATH."/uploads/socialnet/files/xoops_banner.gif");

// Copy photo from images/photo to uploads/socialnet/groups
    copy(XOOPS_ROOT_PATH."/modules/socialnet/images/photo/group_15448108.gif", XOOPS_ROOT_PATH."/uploads/socialnet/groups/group_15448108.gif");
    copy(XOOPS_ROOT_PATH."/modules/socialnet/images/photo/group_12050037.gif", XOOPS_ROOT_PATH."/uploads/socialnet/groups/group_12050037.gif");
    copy(XOOPS_ROOT_PATH."/modules/socialnet/images/photo/group_17268464.gif", XOOPS_ROOT_PATH."/uploads/socialnet/groups/group_17268464.gif");

// Copy photos from /images/photo/ to uploads uploads/socialnet/photos
    copy(XOOPS_ROOT_PATH."/modules/socialnet/images/photo/pic_1_4b640d6b69777.jpg", XOOPS_ROOT_PATH."/uploads/socialnet/photos/pic_1_4b640d6b69777.jpg");
    copy(XOOPS_ROOT_PATH."/modules/socialnet/images/photo/pic_1_4b640d8a8b0a2.jpg", XOOPS_ROOT_PATH."/uploads/socialnet/photos/pic_1_4b640d8a8b0a2.jpg");
    copy(XOOPS_ROOT_PATH."/modules/socialnet/images/photo/pic_1_4b640da62df71.jpg", XOOPS_ROOT_PATH."/uploads/socialnet/photos/pic_1_4b640da62df71.jpg");

    copy(XOOPS_ROOT_PATH."/modules/socialnet/images/photo/thumb_pic_1_4b640d6b69777.jpg", XOOPS_ROOT_PATH."/uploads/socialnet/photos/thumb_pic_1_4b640d6b69777.jpg");
    copy(XOOPS_ROOT_PATH."/modules/socialnet/images/photo/thumb_pic_1_4b640d8a8b0a2.jpg", XOOPS_ROOT_PATH."/uploads/socialnet/photos/thumb_pic_1_4b640d8a8b0a2.jpg");
    copy(XOOPS_ROOT_PATH."/modules/socialnet/images/photo/thumb_pic_1_4b640da62df71.jpg", XOOPS_ROOT_PATH."/uploads/socialnet/photos/thumb_pic_1_4b640da62df71.jpg");

    copy(XOOPS_ROOT_PATH."/modules/socialnet/images/photo/resized_pic_1_4b640d6b69777.jpg", XOOPS_ROOT_PATH."/uploads/socialnet/photos/resized_pic_1_4b640d6b69777.jpg");
    copy(XOOPS_ROOT_PATH."/modules/socialnet/images/photo/resized_pic_1_4b640d8a8b0a2.jpg", XOOPS_ROOT_PATH."/uploads/socialnet/photos/resized_pic_1_4b640d8a8b0a2.jpg");
    copy(XOOPS_ROOT_PATH."/modules/socialnet/images/photo/resized_pic_1_4b640da62df71.jpg", XOOPS_ROOT_PATH."/uploads/socialnet/photos/resized_pic_1_4b640da62df71.jpg");


	return true;
}

?>
