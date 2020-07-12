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

if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}

// Socialnet cookie structure
//create in Socialnet for future CLONEABLE ability
/* -- Cookie settings -- */
$SocialNetCookie['domain'] = "";
$SocialNetCookie['path'] = "/";
$SocialNetCookie['secure'] = false;
$SocialNetCookie['expire'] = time() + 3600 * 24 * 30; // one month
$SocialNetCookie['prefix'] = '';

// set cookie name to avoid subsites confusion such as: domain.com, sub1.domain.com, sub2.domain.com, domain.com/xoopss, domain.com/xoops2
if(empty($SocialNetCookie['prefix'])){
	$cookie_prefix = preg_replace("/[^a-z_0-9]+/i", "_", preg_replace("/(http(s)?:\/\/)?(www.)?/i","",XOOPS_URL));
	$cookie_userid = (is_object($xoopsUser))?$xoopsUser->getVar('uid'):0;
	$SocialNetCookie['prefix'] = $cookie_prefix."_".$xoopsModule->dirname().$cookie_userid."_";
}
?>
