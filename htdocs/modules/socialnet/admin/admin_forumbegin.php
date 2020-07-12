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

include_once 'admin_header.php';
include_once '../../../include/cp_header.php';
include_once '../forumfunctions.php';
include_once '../forumconfig.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/include/common.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/admin/functions.php';
require_once XOOPS_ROOT_PATH.'/class/pagenav.php';
xoops_cp_header();
adminmenu(22);
// *******************************************************************************
// **** Main
// *******************************************************************************

echo"<table width='100%' border='0' cellspacing='1' class='outer'>"
."<tr><td class=\"odd\">";
echo "<a href='./admin_forumbegin.php'><h4>"._AM_SOCIALNET_FORUMCONF."</h4></a>";
if(isset($mode)) {

}
else {
?>
<table border="0" cellpadding="4" cellspacing="1" width="100%">

<tr class='bg1' align="left">
	<td><span class='fg2'><a href="<?php echo $bbUrl['admin'];?>/admin_forums.php?mode=addforum"><?php echo _AM_SOCIALNET_ADDAFORUM;?></a></span></td>
	<td><span class='fg2'><?php echo _AM_SOCIALNET_LINK2ADDFORUM;?></span></td>
</tr>
<tr class='bg1' align="left">
	<td><span class='fg2'><a href='<?php echo $bbUrl['admin'];?>/admin_forums.php?mode=editforum'><?php echo _AM_SOCIALNET_EDITAFORUM;?></a></span></td>
	<td><span class='fg2'><?php echo _AM_SOCIALNET_LINK2EDITFORUM;?></span></td>
</tr>
<tr class='bg1' align='left'>
	<td><span class='fg2'><a href="<?php echo $bbUrl['admin']?>/admin_priv_forums.php?mode=editforum"><?php echo _AM_SOCIALNET_SETPRIVFORUM;?></a></span></td>
	<td><span class='fg2'><?php echo _AM_SOCIALNET_LINK2SETPRIV;?></span></td>
</tr>
<tr class='bg1' align='left'>
	<td><span class='fg2'><a href="<?php echo $bbUrl['admin'];?>/admin_forums.php?mode=sync"><?php echo _AM_SOCIALNET_SYNCFORUM;?></a></span></td>
	<td><span class='fg2'><?php echo _AM_SOCIALNET_LINK2SYNC;?></span></td>
</tr>
<tr class='bg1' align='left'>
	<td><span class='fg2'><a href="<?php echo $bbUrl['admin'];?>/admin_forums.php?mode=addcat"><?php echo _AM_SOCIALNET_ADDACAT;?></a></span></td>
	<td><span class='fg2'><?php echo _AM_SOCIALNET_LINK2ADDCAT;?></span></td>
</tr>
<tr class='bg1' align='left'>
	<td><span class='fg2'><a href="<?php echo $bbUrl['admin'];?>/admin_forums.php?mode=editcat"><?php echo _AM_SOCIALNET_EDITCATTTL;?></a></span></td>
	<td><span class='fg2'><?php echo _AM_SOCIALNET_LINK2EDITCAT;?></span></td>
</tr>
<tr class='bg1' align='left'>
     <td><span class='fg2'><a href="<?php echo $bbUrl['admin'];?>/admin_forums.php?mode=remcat"><?php echo _AM_SOCIALNET_RMVACAT;?></a></span></td>
     <td><span class='fg2'><?php echo _AM_SOCIALNET_LINK2RMVCAT;?></span></td>
</tr>
<tr class='bg1' align='left'>
     <td><span class='fg2'><a href="<?php echo $bbUrl['admin'];?>/admin_forums.php?mode=catorder"><?php echo _AM_SOCIALNET_REORDERCAT;?></a></span></td>
     <td><span class='fg2'><?php echo _AM_SOCIALNET_LINK2ORDERCAT;?></span></td>
</tr>

</table>
<?php
echo"</td></tr></table><BR>";

// ********************************************************************************************************************************************************************************************************************************************************************************************************************
echo "<table width='100%' class='outer' cellpadding='0' cellspacing='1'>\n";
echo "<TR><TH ALIGN='center' HEIGHT=18 COLSPAN=6>"._AM_SOCIALNET_FORUMCONF."</TH></TR>\n";

global $xoopsDB;
$LinkToAddForum=$bbUrl['admin'].'/admin_forums.php?mode=addforum';
$LinkToAddCategory=sprintf("<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0><TR><TD VALIGN=\"middle\"><FORM NAME=\"AddCategory\" method=\"POST\" ACTION=\"%s/modules/socialnet/admin/admin_forums.php\" style=\"margin-bottom:0; padding:0; border:0; margin:0\"><input type=\"hidden\" name=\"mode\" value=\"addcat\"><input type=\"text\" name=\"title\" size=\"40\" maxlength=\"100\">&nbsp;<INPUT TYPE=\"submit\" NAME=\"submit\" VALUE=\"%s\"></FORM></TD></TR></TABLE>",XOOPS_URL,_AM_SOCIALNET_CREATENEWCATEGORY);
$sql = "SELECT cat_id, cat_title, cat_order FROM ".$xoopsDB->prefix("socialnet_forumcategories ")." order by cat_order";
if ( $result = $xoopsDB->query($sql) )
{
	$class = 'odd';
	while($myrow = $xoopsDB->fetchArray($result) )
	{
		$categ=$myrow['cat_id'];
		$LinkGo=sprintf("<A HREF=\"%s/modules/socialnet/forumstart.php?cat=%d\">",XOOPS_URL,$categ);
		$LinkEdit=sprintf("<TABLE BORDER=0><TR><TD VALIGN=\"middle\"><FORM NAME=\"EditCateg\" method=\"POST\" ACTION=\"%s/modules/socialnet/admin/admin_forums.php\" style=\"margin-bottom:0; padding:0; border:0; margin:0\"><input type=\"hidden\" name=\"cat\" value=\"%d\"><input type=\"hidden\" name=\"mode\" value=\"editcat\"><INPUT TYPE=\"submit\" NAME=\"submit\" VALUE=\"%s\" ></FORM></TD></TR></TABLE>",XOOPS_URL,$categ,_AM_SOCIALNET_EDIT);
		$LinkDelete=sprintf("<TABLE BORDER=0><TR><TD VALIGN=\"middle\"><FORM NAME=\"DeleteCateg\" method=\"POST\" ACTION=\"%s/modules/socialnet/admin/admin_forums.php\" style=\"margin-bottom:0; padding:0; border:0; margin:0\"><input type=\"hidden\" name=\"cat\" value=\"%d\"><input type=\"hidden\" name=\"mode\" value=\"remcat\"><INPUT TYPE=\"submit\" NAME=\"submit\" VALUE=\"%s\" ></FORM></TD></TR></TABLE>",XOOPS_URL,$categ,_AM_SOCIALNET_REMOVE);
		$class = ($class == 'even') ? 'odd' : 'even';
		echo "<tr class='".$class."'><td colspan=3 width='70%'>".$LinkGo.$myrow['cat_title']."</A></td><td align='center'>".$LinkEdit."</td><td align='center'>".$LinkDelete."</td><td>&nbsp;</td></tr>\n";

		$sql2="select * FROM ".$xoopsDB->prefix("socialnet_forums")." WHERE cat_id=$categ ORDER BY forum_id";
		if ( $result2 = $xoopsDB->query($sql2) )
		{
			while($myrow2 = $xoopsDB->fetchArray($result2) )
			{
				$forumid=$myrow2['forum_id'];
				$class = ($class == 'even') ? 'odd' : 'even';
				$LinkGoForum=sprintf("<A HREF=\"%s/modules/socialnet/forumview.php?forum=%d\">",XOOPS_URL,$forumid);
				$LinkEdit=sprintf("<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0><TR><TD VALIGN=\"middle\"><FORM NAME=\"EditForum\" method=\"POST\" ACTION=\"%s/modules/socialnet/admin/admin_forums.php\" style=\"margin-bottom:0; padding:0; border:0; margin:0\"><input type=\"hidden\" name=\"forum\" value=\"%d\"><input type=\"hidden\" name=\"mode\" value=\"editforum\"><INPUT TYPE=\"submit\" NAME=\"submit\" VALUE=\"%s\"></FORM></TD></TR></TABLE>",XOOPS_URL,$forumid,_AM_SOCIALNET_EDIT);
				$LinkPerms=sprintf("&nbsp;");
				if($myrow2['forum_type']=='1')
				{
					$LinkPerms=sprintf("<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0><TR><TD VALIGN=\"middle\"><FORM NAME=\"PermsForum\" method=\"POST\" ACTION=\"%s/modules/socialnet/admin/admin_priv_forums.php\" style=\"margin-bottom:0; padding:0; border:0; margin:0\"><input type=\"hidden\" name=\"forum\" value=\"%d\"><input type=\"hidden\" name=\"op\" value=\"showform\"><INPUT TYPE=\"submit\" NAME=\"submit\" VALUE=\"%s\"></FORM></TD></TR></TABLE>",XOOPS_URL,$forumid,_AM_SOCIALNET_EDITPERMS);
				}
				$LinkDelete=sprintf("<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0><TR><TD VALIGN=\"middle\"><FORM NAME=\"EditForum\" method=\"POST\" ACTION=\"%s/modules/socialnet/admin/admin_forums.php\" style=\"margin-bottom:0; padding:0; border:0; margin:0\"><input type=\"hidden\" name='delete' value=\"1\"><input type=\"hidden\" name=\"forum\" value=\"%d\"><input type=\"hidden\" name=\"mode\" value=\"editforum\"><INPUT TYPE=\"submit\" NAME=\"save\" VALUE=\"%s\"></FORM></TD></TR></TABLE>",XOOPS_URL,$forumid,_AM_SOCIALNET_REMOVE);
                		echo "<tr class='".$class."'><td>".$LinkGoForum.$myrow2['forum_name']."</A><BR><FONT SIZE='-2'>".$myrow2['forum_desc']."</font></td><td align='center'>".$myrow2['forum_topics']."</td><td align='center'>".$myrow2['forum_posts']."</td><td align='center'>".$LinkEdit."</td><td align='center'>".$LinkDelete."</td><td align='center'>".$LinkPerms."</td></tr>\n";
			}
		}
		$class = ($class == 'even') ? 'odd' : 'even';
		echo "<tr class='".$class."'><TD colspan=6 align='center'><A HREF='".$LinkToAddForum."&Category=".$categ."'>"._AM_SOCIALNET_ADDAFORUM."</A></th></tr>\n";
	}
}
$class = ($class == 'even') ? 'odd' : 'even';
echo "<tr class='".$class."'><TD colspan=6 align='left'>".$LinkToAddCategory."</th></tr>\n";
echo "</table><BR>\n";
// END *******************************************************************************************************************
}

xoops_cp_footer();
?>
