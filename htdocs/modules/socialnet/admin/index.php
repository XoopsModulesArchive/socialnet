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

// *******************************************************************************
// **** Main
// *******************************************************************************
$op = 'default';
if(isset($_POST['op'])) {
 $op=$_POST['op'];
} elseif(isset($_GET['op'])) {
	$op=$_GET['op'];
}
$socialnet_handler =& xoops_getmodulehandler('socialnet', 'socialnet');

switch ($op) {
	/**
 	 * Default action, show statistics and a listing of all the pages
 	 */
	case 'Default':
	default:
        xoops_cp_header();
        adminmenu(1);

		if (file_exists(XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/admin.php')) {
			require_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/admin.php';
		} else {
			require_once XOOPS_ROOT_PATH.'/modules/socialnet/language/english/main.php';
		}

		if (file_exists(XOOPS_ROOT_PATH.'/modules/socialnet/language/'.$xoopsConfig['language'].'/main.php')) {
			require_once XOOPS_ROOT_PATH.'/modules/socialnet/language/'.$xoopsConfig['language'].'/main.php';
		} else {
			require_once XOOPS_ROOT_PATH.'/modules/socialnet/language/english/main.php';
		}


echo "<h3>" . _AM_SOCIALNET_WELCOME . "</h3>";
echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer' style='margin-top: 15px;'><tr><td class='bg3'><b>"._AM_SOCIALNET_ALLTESTSOK."</b></td></tr>";

$a = mysql_get_server_info();
//$b = substr($a, 0, strpos($a, "-"));
$b = explode("-",$a,2);
$b=$b[0];
$c = explode(".",$b);
echo "<tr><td class='odd'>";
if ($c[0]>4 || ($c[0]==4 && $c[1]>0)) {
  echo "<img src='../images/icons/approve.gif' align='baseline'> ";
  echo "Mysql Version:<b>".$b;
} else {
  echo "<img src='../images/users/notifications.gif'> ";
  echo "Mysql Version:<b>".$b. "</b>. You must use a version higher than 4.1 </td></tr>";
} 
if (extension_loaded('gd')) {
echo "<tr><td class='even'><img src='../images/icons/approve.gif' align='baseline'> "._AM_SOCIALNET_GDEXTENSIONOK." "._AM_SOCIALNET_MOREINFO." <a href='http://www.libgd.org/Main_Page'> Gd Library</a> </td></tr>";
                
} else {
echo "<tr><td class='even'><img src='../images/users/notifications.gif'> "._AM_SOCIALNET_GDEXTENSIONFALSE." "._AM_SOCIALNET_CONFIGPHPINI." "._AM_SOCIALNET_MOREINFO." <a href='http://www.libgd.org/Main_Page'>Gd Library</a> </td></tr>";
}
if ( (str_replace('.', '', PHP_VERSION)) > 499 ){              
 echo "<tr><td class='odd'><img src='../images/icons/approve.gif' align='baseline'> "._AM_SOCIALNET_PHP5PRESENT." ". PHP_VERSION."</td></tr>";
} else { echo "<tr><td class='odd'><img src='../images/users/notifications.gif' align='baseline'> "._AM_SOCIALNET_PHP5NOTPRESENT." ". PHP_VERSION."</td></tr>";
}
if (!is_dir(XOOPS_ROOT_PATH."/uploads/socialnet/mp3/")) { echo "<tr><td class='odd'><img src='../images/users/notifications.gif'> /uploads/socialnet/mp3/ is not exists</td></tr>";
}elseif (!is_writable(XOOPS_ROOT_PATH."/uploads/socialnet/mp3/")) { echo "<tr><td class='odd'><img src='../images/users/notifications.gif'> /uploads/socialnet/mp3/ is not writable</td></tr>";
}else{ echo "<tr><td class='odd'><img src='../images/icons/approve.gif' align='baseline'> <b><font color='#0000FF'>/uploads/socialnet/mp3/</font></b> <b><font color='#FF0000'> exists and writable</font></b></td></tr>";
}

if (!is_dir(XOOPS_ROOT_PATH."/uploads/socialnet/photos/")) { echo "<tr><td class='odd'><img src='../images/users/notifications.gif'> /uploads/socialnet/photos/ is not exists</td></tr>";
} elseif (!is_writable(XOOPS_ROOT_PATH."/uploads/socialnet/photos/")) { echo "<tr><td class='odd'><img src='../images/users/notifications.gif'> /uploads/socialnet/photos/ is not writable</td></tr>";
} else{ echo "<tr><td class='odd'><img src='../images/icons/approve.gif' align='baseline'> <b><font color='#0000FF'>/uploads/socialnet/photos/</font></b> <b><font color='#FF0000'> exists and writable</font></b></td></tr>";
}

if (!is_dir(XOOPS_ROOT_PATH."/uploads/socialnet/groups/")) { echo "<tr><td class='odd'><img src='../images/users/notifications.gif'> /uploads/socialnet/groups/ is not exists</td></tr>";
} elseif (!is_writable(XOOPS_ROOT_PATH."/uploads/socialnet/groups/")) { echo "<tr><td class='odd'><img src='../images/users/notifications.gif'> /uploads/socialnet/groups/ is not writable</td></tr>";
} else{ echo "<tr><td class='odd'><img src='../images/icons/approve.gif' align='baseline'> <b><font color='#0000FF'>/uploads/socialnet/groups/</font></b> <b><font color='#FF0000'> exists and writable</font></b></td></tr>";
}

if (!is_dir(XOOPS_ROOT_PATH."/uploads/socialnet/files/")) { echo "<tr><td class='odd'><img src='../images/users/notifications.gif'> /uploads/socialnet/files/ is not exists</td></tr>";
} elseif (!is_writable(XOOPS_ROOT_PATH."/uploads/socialnet/files/")) { echo "<tr><td class='odd'><img src='../images/users/notifications.gif'> /uploads/socialnet/files/ is not writable</td></tr>";
} else{ echo "<tr><td class='odd'><img src='../images/icons/approve.gif' align='baseline'> <b><font color='#0000FF'>/uploads/socialnet/files/</font></b> <b><font color='#FF0000'> exists and writable</font></b></td></tr>";
}

if (!is_dir(XOOPS_ROOT_PATH."/uploads/socialnet/html/")) { echo "<tr><td class='odd'><img src='../images/users/notifications.gif'> /uploads/socialnet/html/ is not exists</td></tr>";
} elseif (!is_writable(XOOPS_ROOT_PATH."/uploads/socialnet/html/")) { echo "<tr><td class='odd'><img src='../images/users/notifications.gif'> /uploads/socialnet/html/ is not writable</td></tr>";
} else{ echo "<tr><td class='odd'><img src='../images/icons/approve.gif' align='baseline'> <b><font color='#0000FF'>/uploads/socialnet/html/</font></b> <b><font color='#FF0000'> exists and writable</font></b></td></tr>";
}

if (!is_dir(XOOPS_ROOT_PATH."/uploads/socialnet/media/")) { echo "<tr><td class='odd'><img src='../images/users/notifications.gif'> /uploads/socialnet/media/ is not exists</td></tr>";
} elseif (!is_writable(XOOPS_ROOT_PATH."/uploads/socialnet/media/")) { echo "<tr><td class='odd'><img src='../images/users/notifications.gif'> /uploads/socialnet/media/ is not writable</td></tr>";
} else{ echo "<tr><td class='odd'><img src='../images/icons/approve.gif' align='baseline'> <b><font color='#0000FF'>/uploads/socialnet/media/</font></b> <b><font color='#FF0000'> exists and writable</font></b></td></tr>";
}

echo "<tr><td class='odd'><img src='../images/icons/info.gif'> ".sprintf(_AM_SOCIALNET_MAXBYTESPHPINI,ini_get('post_max_size'))."</td></tr>";
if (function_exists('memory_get_usage')){
echo "<tr><td class='even'><img src='../images/icons/info.gif'> "._AM_SOCIALNET_MEMORYLIMIT." ".memory_get_usage()."</td></tr>";
}

echo "</table>";

}

echo "<div align='center' style='margin-top:10px'><a href='http://www.ipwgc.com/socialnet/'><img src='../images/socialnetLogo.png'></a><br /><img src='../images/menu/mailuser.gif'><a style='color: #029116; font-size:11px' href='feedback.php'>"._AM_SOCIALNET_FEEDBACK."</a> - <img src='../images/icons/mainvideo.gif'><a style='color: #FF0000; font-size:11px' href='http://www.ipwgc.com/socialnet/modules/socialnet/index.php' target='_blank'>"._AM_SOCIALNET_CHKVERSION."</a></div>";
xoops_cp_footer();
?>
