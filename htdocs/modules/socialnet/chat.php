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


include_once "../../mainfile.php";
require 'chatconfig.php';
include_once "./class/socialnet_chat_class.php";
chat::deleteMessage(date('Y/m/d H:i:s',strtotime("-".MAX_LOGDATE." day")));
include_once "chatmain.php";
?>
<!--
<html><head><title>SocialNet.PopChat</title>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;CHARSET=<?echo CHARSET;?>">
</head>
<frameset rows="80%,*" cols="*" border=0 framespacing=0 frameborder=0> 
<frame name=frame2 src="chatmain.php" bordercolor="#FFFFFF" marginwidth="10" marginheight="10">
<frame name=frame1 src="chatinput.php" bordercolor="#FFFFFF" marginwidth="0" marginheight="0">
</frameset>
<noframes><body>MUST HAVE FRAME</body></noframes>
</html>
-->
