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

	xoops_cp_header();
	adminmenu(12);
	global $xoopsConfig, $xoopsTheme, $xoopsUser, $xoopsModule;

// Page Starts Here
	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

	$page = ($page == 0 ? 1 : $page);

	$perpage = $xoopsModuleConfig['userperpage'];

	$startpoint = ($page * $perpage) - $perpage;
// Page in Ends here
 include("admin_header.php");

$result = mysql_query("SELECT * FROM ".$xoopsDB->prefix("users")."  WHERE level=0 LIMIT $startpoint,$perpage ");
$rows = mysql_num_rows($result);
if($rows > 0){

//Display users
  ?>
 <script type="text/javascript">

  function confirmation2() {
    var answer = confirm("<? echo ""._AM_SOCIALNET_JAVAALERTALLOK.""; ?>")
    if (answer){

       window.location = "tools_do_active_user.php?action=statusr";
    }
    else{
        alert("<? echo ""._AM_SOCIALNET_JAVAALERT_CANCEL.""; ?>")
    }
}

  </script>
<!--
/// JAVASCRIPT ALERT END HERE
 //-->
<?
echo "<table width='700' border='1'>
    <tr>
    <td><center><font size='+2'>" . _AM_SOCIALNET_NONACTIVEUSERS . "</font></center></td>
    </tr>
    <tr>
    <td>";
        echo "<table border='1' width='100%'>";
            echo "<tr>";
            $ACTIVEID=$xoopsModuleConfig['activeid'];
if ($ACTIVEID== 1) {
            echo "<td width='25%'><b>" . _AM_SOCIALNET_USERID . "</b></td>  ";
               }
  else
{
echo"";
 }
          echo "  <td width='25%'><b>" . _AM_SOCIALNET_USER . "</b></td><td width='25%'><b>" . _AM_SOCIALNET_USEREMAIL . "</b> ";
           echo " <td width='25%'><b><p>" . _AM_SOCIALNET_STATSUSER . " \<a href='#' onclick='confirmation2(); return false;''>"._AM_SOCIALNET_APPROVEALL."</a></p></b>";
            echo "</td><td width='25%'><b>" . _AM_SOCIALNET_ACTION . "</b></td>" ;
            echo "</tr>";

while($row = mysql_fetch_array($result)){
$ACTIVEID=$xoopsModuleConfig['activeid'];
if ($ACTIVEID== 1) {
echo "<tr><td width='25%'>".$row['uid']."</td>";
   }
  else
{
echo"";
 }

echo "<td width='25%'>".$row['uname']."</td> ";
echo "<td width='25%'>" . _AM_SOCIALNET_RE_ACTIVE . " ::  <a href=tools_re_active.php?uid=".$row['uid'].">".$row['email']."</a></td> ";
?>
<script type="text/javascript">
function linkRef(yurl ){
var linkref = yurl;
if(confirm("<? echo ""._AM_SOCIALNET_JAVAALERTREJECTHIM.""; ?>")){
window.location.href=linkref;
}
}
</script>
</head>
<body>

<td width="25%"><a href="#" onClick="linkRef('tools_do_active_user.php?action=statusd&uid=<?php echo $row['uid']; ?>' )"><? echo ""._AM_SOCIALNET_DELETHIM.""; ?></a>  </td>
</body>
</html>
<?
 echo "<td width='25%'><a href=tools_do_active_user.php?action=status&uid=".$row['uid'].">"._AM_SOCIALNET_APPROVEIT."</a></td></tr>";
}

    echo "</table>";

echo "</td> ";
  echo "  </tr>   ";
   echo " </table>";
}
 else
{

echo " <table border='2' cellpadding='10' cellspacing='10' style='border-collapse: collapse'  width='50%' >
  <tr><br><br>
    <td bgcolor='#FFCC66'><font size='+1'><img src='../images/icons/info.gif'>" . _AM_SOCIALNET_NOUSERSFOUND. "</font></td>
  </tr>
</table> ";
}
// Now lets Start Pages

		$pagesnum = @ceil(mysql_num_rows(mysql_query("SELECT * FROM ".$xoopsDB->prefix("users")."  WHERE level=0")) / $perpage);
	for ($i=1; $i<=$pagesnum; $i++) {
		if ($i != $page) {


			$z = "<a href='". $_SERVER['PHP_SELF'] ."?page=$i'>$i</a>";
		} else {
			$z = "<u>$i</u>";
		}

		echo "[$z] ";
	}


echo "<div align='center' style='margin-top:10px'><a href='http://www.ipwgc.com/socialnet/'><img src='../images/socialnetLogo.png'></a><br /><img src='../images/menu/mailuser.gif'><a style='color: #029116; font-size:11px' href='feedback.php'>"._AM_SOCIALNET_FEEDBACK."</a> - <img src='../images/icons/mainvideo.gif'><a style='color: #FF0000; font-size:11px' href='http://www.ipwgc.com/socialnet/modules/socialnet/index.php' target='_blank'>"._AM_SOCIALNET_CHKVERSION."</a></div>";
xoops_cp_footer();
?>