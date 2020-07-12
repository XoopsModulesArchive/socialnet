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

 global $xoopsConfig, $xoopsTheme, $xoopsUser, $xoopsModule;

xoops_cp_header();
adminmenu(11);
include("admin_header.php");

$db = mysql_connect(XOOPS_DB_HOST,XOOPS_DB_USER,XOOPS_DB_PASS);
mysql_select_db(XOOPS_DB_NAME,$db);

?>

<br>
<a name="Socialnet">Socialnet</a><br>
<table border=1 cellspacing=5 cellpadding=5 bordercolor="#996633" >
<tr>
<td colspan=4 bgcolor="#FFCC66">
<?php echo "". _AM_SOCIALNET_OPTIMIZE_MYSQL .""; ?><b>&quot;<?php echo XOOPS_DB_NAME; ?></b>&quot;
</td>
</tr>
<tr>
<td colspan=2 bgcolor="#CCFFCC">
<?php echo "". _AM_SOCIALNET_OPTIMIZE_ISLAH .""; ?>
</tr>
<td colspan=2 bgcolor="#CCFFCC">
<?php echo "". _AM_SOCIALNET_OPTIMIZE_TNSHEET .""; ?>
</td>
<td bgcolor="#CCFFCC">

<?php
$tbl_array = array(); $c = 0;
$result2 = mysql_list_tables(XOOPS_DB_NAME);
for($x=0; $x<mysql_num_rows($result2); $x++)
{
 $tabelle = mysql_tablename($result2,$x);
// echo $tabelle."<BR>";
?>

<tr>
<td bgcolor="#FFCC66">
<?php echo $tabelle; ?><img border="0" src="../images/icons/approve.gif" width="20" height="20">
</td>
<td align=center width=70 bgcolor="#FFFFCC">
<?php
$sql = "REPAIR TABLE `".$tabelle."`";
$result = mysql_query($sql,$db);
if (!$result)
{
 print mysql_error();
}
else
{
 echo "". _AM_SOCIALNET_STATS ." <font color=green><b>". _AM_SOCIALNET_OPTIMIZE_OK ."</b></font>";
}
?><img border="0" src="../images/profile/toggle.gif" width="16" height="16">
</td>
<td bgcolor="#FFCC66">
<?php echo $tabelle; ?><img border="0" src="../images/icons/approve.gif" width="20" height="20">
</td>
<td align=center width=70 bgcolor="#FFFFCC">
<?php
$sql = "OPTIMIZE TABLE `".$tabelle."`";
$result = mysql_query($sql,$db);
if (!$result)
{
 print mysql_error();
}
else
{
 echo "". _AM_SOCIALNET_STATS ." <font color=green><b>". _AM_SOCIALNET_OPTIMIZE_OK ."</b></font>";
}
}
?><img border="0" src="../images/profile/toggle.gif" width="16" height="16">
</td>
</tr>
</table><br>
<a href="#Socialnet"><img border="0" src="../images/fans/trustyc.gif" width="48" height="16"><br>Go Top</a><br>
<br>


<?
echo "<div align='center' style='margin-top:10px'><a href='http://www.ipwgc.com/socialnet/'><img src='../images/socialnetLogo.png'></a><br /><img src='../images/menu/mailuser.gif'><a style='color: #029116; font-size:11px' href='feedback.php'>"._AM_SOCIALNET_FEEDBACK."</a> - <img src='../images/icons/mainvideo.gif'><a style='color: #FF0000; font-size:11px' href='http://www.ipwgc.com/socialnet/modules/socialnet/index.php' target='_blank'>"._AM_SOCIALNET_CHKVERSION."</a></div>";
 xoops_cp_footer();
 ?>