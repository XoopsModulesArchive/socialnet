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

include_once '../../mainfile.php';
include_once '../../header.php';
include_once '../../class/criteria.php';
include_once 'class/socialnet_youtube.php';

// *******************************************************************************
// **** Main
// *******************************************************************************

if(!($GLOBALS['xoopsSecurity']->check())) {redirect_header($_SERVER['HTTP_REFERER'], 3, _MD_SOCIALNET_TOKENEXPIRED);}

$cod_img = intval($_POST['video_id']);
$marker = intval($_POST['marker']);

$uid = intval($xoopsUser->getVar('uid'));

if($marker==1)
{
	/**
	* Creating the factory  loading the picture changing its caption
	*/
	$video_factory = new Xoopssocialnet_youtubeHandler($xoopsDB);
	$video = $video_factory->create(false);
	$video->load($cod_img);
	$video->setVar('video_desc',trim(htmlspecialchars($_POST['caption'])));
	
	/**
	* Verifying who's the owner to allow changes
	*/
	if($uid == $video->getVar('uid_owner'))
	{
		if($video_factory->insert($video)) {redirect_header('youtube.php?uid='.$uid, 2, _MD_SOCIALNET_DESC_EDITED);}
		else {redirect_header('index.php?uid='.$uid, 2, _MD_SOCIALNET_ANERROR);}
	}
}
/**
* Creating the factory  and the criteria to edit the desc of the picture
* The user must be the owner
*/ 
$album_factory = new Xoopssocialnet_youtubeHandler($xoopsDB);
$criteria_video = new Criteria('video_id',$cod_img);
$criteria_uid = new Criteria('uid_owner',$uid);
$criteria = new CriteriaCompo($criteria_video);
$criteria->add($criteria_uid);

/**
* Lets fetch the info of the pictures to be able to render the form
* The user must be the owner
*/
if($array_pict = $album_factory->getObjects($criteria))
{
	$caption = $array_pict[0]->getVar('video_desc');
	$url = $array_pict[0]->getVar('youtube_code');
}

$album_factory->renderFormEdit($caption,$cod_img,$url);

include '../../footer.php';
?>

