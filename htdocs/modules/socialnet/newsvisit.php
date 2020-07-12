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

include "../../mainfile.php";
include_once 'class/class.sfiles.php';
include_once 'class/class.newsstory.php';
// *******************************************************************************
// **** Main
// *******************************************************************************

$myts =& MyTextSanitizer::getInstance(); // MyTextSanitizer object
$fileid = (isset($_GET['fileid'])) ? intval($_GET['fileid']) : 0;
if (empty($fileid)) {
    redirect_header("news.ph[",2,_ERRORS);
    exit();
}
$sfiles = new sFiles($fileid);

// Do we have the right to see the file ?
$article = new SocialnetStory($sfiles->getStoryid());
$gperm_handler =& xoops_gethandler('groupperm');
if (is_object($xoopsUser)) {
$groups = $xoopsUser->getGroups();
} else {
$groups = XOOPS_GROUP_ANONYMOUS;
}
if (!$gperm_handler->checkRight("socialnet_newsaudience", $article->audienceid, $groups, $xoopsModule->getVar('mid'))) {
redirect_header('news.php', 3, _NOPERM);
exit();
}



$sfiles->updateCounter();
$url=XOOPS_UPLOAD_URL.'/socialnet/news/'.$sfiles->getDownloadname();
if (!preg_match("/^ed2k*:\/\//i", $url)) {
	Header("Location: $url");
}
echo "<html><head><meta http-equiv=\"Refresh\" content=\"0; URL=".$myts->htmlSpecialChars($url)."\"></meta></head><body></body></html>";
exit();
?>