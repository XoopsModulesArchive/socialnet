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

require_once '../../../include/cp_header.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/include/common.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/admin/functions.php';
require_once XOOPS_ROOT_PATH.'/class/pagenav.php';
include("admin_header.php");

// *******************************************************************************
// **** Main
// *******************************************************************************

if ( file_exists(XOOPS_ROOT_PATH."/modules/socialnet/language/".$xoopsConfig['language']."/modinfo.php") )
	{
		include_once(XOOPS_ROOT_PATH."/modules/socialnet/language/".$xoopsConfig['language']."/modinfo.php");
	}
else
	{
		include_once(XOOPS_ROOT_PATH."/modules/socialnet/language/english/modinfo.php");
	}
if( ! xoops_refcheck() ) die( ""._AM_SOCIALNET_MSGNOTALLOWED."" ) ;
 $myts =& MyTextSanitizer::getInstance();

  if ( empty($_POST["comment"])) {
    redirect_header(XOOPS_URL . "/modules/socialnet/admin/tools_add_note.php" , 3, ""._AM_SOCIALNET_MSGNOCOMMENT."");
  } else if (strlen($_POST["comment"]) > $xoopsModuleConfig['themesssage']) {

      redirect_header(XOOPS_URL . "/modules/socialnet/admin/tools_add_note.php" , 3, ""._AM_SOCIALNET_MSGLONGCOMMENT."");
   }
    $name = $myts->makeTboxData4Save($_POST["name"]);
     $comment = $myts->makeTboxData4Save($_POST["comment"]);        ////
  $sql = "INSERT INTO ".$xoopsDB->prefix("socialnet_note")." (name, comment) VALUES ('$name', '$comment')";

	$ret = $xoopsDB->query($sql);
   if ( $ret ) {
       redirect_header(XOOPS_URL . "/modules/socialnet/admin/tools_add_note.php" , 3, ""._AM_SOCIALNET_MSGCOMMENTADDED." ");
       } else {
    redirect_header(XOOPS_URL . "/modules/socialnet/admin/tools_add_note.php" , 3, ""._AM_SOCIALNET_MSGCOMMENTERROR."");
   }

   ?>