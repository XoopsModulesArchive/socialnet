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

function chat_marquee_show($options)
{
	global $xoopsUser;
	include_once XOOPS_ROOT_PATH . "/modules/socialnet/class/socialnet_chat_marquee_class.php";
	include_once XOOPS_ROOT_PATH . "/modules/socialnet/class/socialnet_chat_class.php";
	$block = array();
	$marquee= new marquee($options[0]);
	$block['marqueecode'] = $marquee->constructmarquee(chat::getreacentlyMessage());
	$block['marqueecode'] .= 
			"<div align='right'><a href=".XOOPS_URL."/modules/socialnet/chatbegin.php>"._MB_SOCIALNET_POPCHAT_GOCHAT."</a></div>";

	return $block;
}

function chat_marquee_edit($options)
{
	include_once XOOPS_ROOT_PATH . "/modules/socialnet/class/socialnet_chat_marquee_class.php";
	$marquee= new marquee();
	$form = "<table border=0>";
	$form.= "<tr><td>" . _MB_SOCIALNET_POPCHAT_MARQUEE_SELECT . "</td><td><select name='options[0]'>".
		 $marquee->getHtmlMarqueesList($options[0]). "</select></td></tr>";
	$form.="</table>";
	return $form;
}
?>