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

include("../../../mainfile.php");
include '../../../include/cp_header.php';

if ( file_exists(XOOPS_ROOT_PATH."/modules/socialnet/language/".$xoopsConfig['language']."/modinfo.php") )
	{
		include_once(XOOPS_ROOT_PATH."/modules/socialnet/language/".$xoopsConfig['language']."/modinfo.php");
	}
else
	{
		include_once(XOOPS_ROOT_PATH."/modules/socialnet/language/english/modinfo.php");
	}

xoops_cp_header();

global $xoopsConfig, $xoopsTheme, $xoopsUser, $xoopsModule;

   $xid       = $HTTP_POST_VARS['xid'];
   $name      = $HTTP_POST_VARS['name'];
   $comment   = $HTTP_POST_VARS['comment'];


 $query =mysql_query("UPDATE  ".$xoopsDB->prefix("socialnet_note")." SET name='$name', comment='$comment'  WHERE xid='$xid' ")
  or die("can't edit the note");

  if (!$query){
  echo"<center>"._AM_SOCIALNET_MSGEDITERROR."</center><META HTTP-EQUIV=\"Refresh\" Content=5;URL=\"tools_add_note.php\">";
  }else{
  echo"<center>"._AM_SOCIALNET_MSGEDITEDOK."</center><META HTTP-EQUIV=\"Refresh\" Content=2;URL=\"tools_add_note.php\">";
    }
 xoops_cp_footer();
 ?>