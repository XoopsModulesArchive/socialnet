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

define('POPCHAT_SHOW_NAME', 0 );			// 0 = Normal, 1 = Replace user's name with real name
define('CHARSET',_CHARSET);					// Charset for Chat window:"utf-8",x-euc-jp
define('LINE', 16);							// Line Of Display
define('MAX', 100);							// Max Line for Log file
define('ROM', 1);							// Display Listener 0=No, 1=Count, 2=Host
define('SEPA',",");							// Memeber Sepalation
define('DatePrint',"m/d(D)Ah:i");			// Date Print for Chat Message
define('MAX_LOGDATE',2);					// How many days for Chat Message log
define('VERSION',"0.04e");					// Version
?>