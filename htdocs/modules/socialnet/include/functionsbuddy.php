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

function buddygo() {
Header("Location: buddy.php");
}
function buddylist() {
global $ModName, $modversion, $xoopsUser, $xoopsConfig, $xoopsTheme, $xoopsDB, $xoopsLogger, $xoopsMF, $HTTP_COOKIE_VARS;
$idd =$xoopsUser->getVar("uid", "E");
$sql = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("priv_msgs")." WHERE to_userid = '$idd' AND read_msg='0'");
if ($row = $xoopsDB->getRowsNum($sql)) {
while ($msgs = $xoopsDB->fetchArray($sql)) {
echo "<SCRIPT LANGUAGE=\"JavaScript\">\n
var telwin = null;\n
telwin = window.open(\"buddy.php?task=buddyread&msg_id=$msgs[msg_id]\", \"$priv_msg[msg_time]\", \"width=450,height=370,toolbar=no,location=no,menubar=no,scrollbars=yes,resizeable=no,status=no\");\n
</SCRIPT>\n\n";
        }
}
move();

echo "<title>".$xoopsConfig['sitename']." - $ModName</title>
<script language=\"javascript\">\nfunction IM(IM) { var MainWindow = window.open (IM, \"_blank\",\"width=450,height=370,toolbar=no,location=no,menubar=no,scrollbars=no,resizeable=no,status=no\");}\n</script>
</head><body onload=setInterval('self.location.reload()',20000)>";
echo "<center><table class='outer'><tr class='odd'><td align='center'>";
echo "<p class=normal><a href=buddy.php><font size=2>"._MD_SOCIALNET_BUDDY_WHOISONLINE."</a>&nbsp;&nbsp;|&nbsp;&nbsp;";
echo "<a href=buddy.php?task=buddyfriend>"._MD_SOCIALNET_BUDDY_MYFRIENDS."</a>&nbsp;&nbsp;|&nbsp;&nbsp;";
echo "<a href=buddy.php?task=mod>"._LIST."</a></font></td></tr></table><br>";
echo '<table width="100%" cellspacing="1" class="outer"><tr><th colspan="4"><font size=2>'._MD_SOCIALNET_BUDDY_WHOISONLINE.'</font></th></tr>';
//////////////////////
$result = $xoopsDB->query("SELECT online_uid, online_uname, online_module FROM ".$xoopsDB->prefix("online")."");
while (list($online_uid,$online_uname,$online_module)= $xoopsDB->fetchRow($result)) {
$isadmin = 0;
$isFriend=false;
$isMe=false;
if($online_uid!=0) {
echo "<tr align='center' class=\"odd\"><td>";
$s = $xoopsDB->query("SELECT user_avatar FROM ".$xoopsDB->prefix("users")." where uid=$online_uid");
$r  = $xoopsDB->fetchArray($s);
echo "<img src='".XOOPS_UPLOAD_URL."/$r[user_avatar]' width=\"100\" height=\"100\" >";
echo "</td><td valign='middle'><a href=\"javascript:window.opener.location='".XOOPS_URL."/userinfo.php?uid=$online_uid';javascript:window.location='buddy.php';\"><font size=2>$online_uname</font></a>";
$s2 = $xoopsDB->query("SELECT name FROM ".$xoopsDB->prefix("modules")." where mid=$online_module");
$r2  = $xoopsDB->fetchArray($s2);
echo "</td><td valign='middle'><font size=2>$result[name]</font></td><td valign='middle'>";
echo "<a href=\"javascript:IM('".XOOPS_URL."/pmlite.php?send2=1&to_userid=$online_uid','pmlite',450,370);\">
<img src=\"".XOOPS_URL."/images/icons/pm_small.gif\" border=\"0\" width=\"27\" height=\"17\" alt=\"\" /></a>";
$s4 = $xoopsDB->query("SELECT uid FROM ".$xoopsDB->prefix("socialnet_buddyfriends")." WHERE uid= '$idd' AND fuid= '$online_uid'");
$r4 = $xoopsDB->fetchRow($s4);
if(!empty($r4[0])){
$isFriend=true;	
}
$s6 = $xoopsDB->query("SELECT uid FROM ".$xoopsDB->prefix("socialnet_buddyfriends")." WHERE uid= '$online_uid' AND fuid= '$idd'");
$r6 = $xoopsDB->fetchRow($s6);
if(!empty($r6[0])){
$isFriend=true;	
}

if($idd==$online_uid){
$isMe=true;
}
if(!$isMe){
	if (!$isFriend) {
	echo "<a href=\"buddy.php?task=add&uid=$online_uid\"><font size=1>Add</font></a>";
	}	if ($isFriend) {
		echo "<a href=\"buddy.php?task=remove&uid=$online_uid\"><font size=1>Remove</font></a>";
		}
}
echo "</td></tr>";
}else {
echo "<tr align=\"center\" class=\"odd\"><td>";
echo "</td><td valign='middle'><font size=2>"._MD_SOCIALNET_BUDDY_VISITER."</font></a>";
$s5 = $xoopsDB->query("SELECT name FROM ".$xoopsDB->prefix("modules")." where mid=$online_module");
$rt5  = $xoopsDB->fetchArray($s5);
echo "</td><td valign='middle'><font size=2>$result5[name]</font></td><td>";
echo "</td></tr>";
}
}
//////////////////////
echo '</table><br/>';
echo "</center></body></html>";
exit;
}
function buddycompose($to, $subject, $msg_id) {
echo "<SCRIPT LANGUAGE=\"JavaScript\">
document.location.href=\"".XOOPS_URL."/pmlite.php?reply=1&msg_id=".$msg_id."\"
</SCRIPT>";
exit;
}
function buddyread($msg_id) {
global $ModName, $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsTheme, $xoopsLogger, $xoopsMF;
$idd =$xoopsUser->getVar("uid", "E");
$sql = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("priv_msgs")." WHERE msg_id=$msg_id AND to_userid='$idd' AND read_msg='0'");
$priv_msg = $xoopsDB->fetchArray($sql);
$from_userid = $priv_msg[from_userid];
$fromuser = $xoopsDB->query("select uname from ".$xoopsDB->prefix("users")." where uid = '$from_userid'");
$fname = $xoopsDB->fetchArray($fromuser);
$from_user = $fname[uname];
$subject = stripslashes($priv_msg[subject]);
$msg_image = stripslashes($priv_msg[msg_image]);
$message = stripslashes($priv_msg[msg_text]);
$msgtime = formatTimestamp($priv_msg['msg_time']);
mysql_query("UPDATE ".$xoopsDB->prefix("priv_msgs")." SET read_msg='1' WHERE msg_id='$priv_msg[msg_id]'");
echo "<title>"._MD_SOCIALNET_BUDDY_INCOMINGFROM." $from_user !</title>\n";
move();
echo "</head>\n";
echo "<body LEFTMARGIN=3 MARGINWIDTH=3 TOPMARGIN=3 MARGINHEIGHT=3>";
echo "<embed src=\"".XOOPS_URL."/modules/socialnet/newmessage.wav\" autostart=\"true\" hidden=\"true\" loop=\"false\"><table width=100% cellspacing=1 cellpadding=3 class='outer'><tr><td>";
$result = $xoopsDB->query("SELECT uid, user_avatar FROM ".$xoopsDB->prefix("users")." WHERE uname='$from_user'");
$result2  = $xoopsDB->fetchArray($result);
echo "<tr><th colspan='2' align='left'><font size=2>"._MD_SOCIALNET_BUDDY_INCOMINGFROM." $from_user</font></td></tr><tr class='odd'><td valign='middle' align='center'>";
echo "<img src=\"".XOOPS_UPLOAD_URL."/$result2[user_avatar]\" alt=\"\"/>";
echo "</td><td><img src='".XOOPS_URL."/images/subject/$msg_image' alt='' />&nbsp;<font size=2>"._MD_SOCIALNET_BUDDY_SENTAT." $msgtime</font>";
		echo "<hr /><b><font size=2>$subject</font></b><br /><br /><font size=2>\n";
$myts =& MyTextSanitizer::getInstance();
$message = $myts->makeTboxData4Show($message);
echo "$message";
echo "</font><br /><br /></td></tr></table><br>";
echo "<FORM METHOD=POST task=\"buddy.php\" TARGET=_self>
<input type=HIDDEN name=\"to\" value=\"$from_user\">
<input type=HIDDEN name=\"subject\" value=\"$subject\">
<input type=HIDDEN name=\"prev_msg\" value=\"".$priv_msg[msg_id]."\">";
echo "<CENTER><TABLE WIDTH=100% BORDER=0>
    <TR>
      <TD COLSPAN=2 ALIGN=\"CENTER\">
<SELECT NAME=\"task\">
	<OPTION VALUE=\"buddycompose\"> "._MD_SOCIALNET_BUDDY_REPLY."
	<OPTION VALUE=\"buddel\"> "._MD_SOCIALNET_BUDDY_DELETEON."
</SELECT>
</TD>
    </TR>
    <TR>
      <TD VALIGN=\"TOP\"  ALIGN=\"CENTER\"><INPUT TYPE=\"submit\" VALUE=\""._MD_SOCIALNET_BUDDY_CONTINUE."\"></TD>
      <TD VALIGN=\"TOP\"  ALIGN=\"CENTER\"></FORM></TD>
    </TR>
</TABLE></CENTER>
</body>
</html>";
exit;
}
function buddel($prev_msg) {
global $ModName, $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsTheme, $xoopsLogger, $xoopsMF;
$idd =$xoopsUser->getVar("uid", "E");
$xoopsDB->query("DELETE FROM ".$xoopsDB->prefix("priv_msgs")." WHERE msg_id='$prev_msg' AND to_userid ='$idd'");
echo "<script language=JavaScript>
<!--
self.name=\"wname\";window.close();
//-->
</script>";
exit;
}
function friendExists() {
echo "<br />"._MD_SOCIALNET_BUDDY_EXISTS."<br /><br />";
echo "<a href='buddy.php?task=buddyfriend'>"._MD_SOCIALNET_BUDDY_BACKTOLIST."</a>";
}
function displayFriendsList($beg_in) {
global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsTheme, $xoopsLogger, $xoopsMF;
$ModName = "Messenger";
$idd =$xoopsUser->getVar("uid", "E");
$sql = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("priv_msgs")." WHERE to_userid = '$idd' AND read_msg='0'");
if ($row = $xoopsDB->getRowsNum($sql)) {
while ($msgs = $xoopsDB->fetchArray($sql)) {
echo "<SCRIPT LANGUAGE=\"JavaScript\">\n
var telwin = null;\n
telwin = window.open(\"buddy.php?task=buddyread&msg_id=$msgs[msg_id]\", \"$priv_msg[msg_time]\", \"width=450,height=370,toolbar=no,location=no,menubar=no,scrollbars=yes,resizeable=no,status=no\");\n
</SCRIPT>\n\n";
        }
}
move();
	$isadmin = 0;
echo "<title>".$xoopsConfig['sitename']." - $ModName</title>
<script language=\"javascript\">\nfunction IM(IM) { var MainWindow = window.open (IM, \"_blank\",\"width=450,height=370,toolbar=no,location=no,menubar=no,scrollbars=no,resizeable=no,status=no\");}\n</script>
</head><body onload=setInterval('self.location.reload()',20000)>";
echo "<center><table class='outer'><tr class='odd'><td align='center'>";
echo "<p class=normal><a href=buddy.php><font size=2>"._MD_SOCIALNET_BUDDY_WHOISONLINE."</a>&nbsp;&nbsp;|&nbsp;&nbsp;";
echo "<a href=buddy.php?task=buddyfriend>"._MD_SOCIALNET_BUDDY_MYFRIENDS."</a>&nbsp;&nbsp;|&nbsp;&nbsp;";
echo "<a href=buddy.php?task=mod>"._LIST."</a></font></td></tr></table><br>";
$myid=$xoopsUser->uid();
if (is_numeric($beg_in)==false) {
        $beg_in=0;
        }
else {
if ($beg_in<1) {
        $beg_in=0;
        }
}
//##
$sqlstr="SELECT fuid FROM ".$xoopsDB->prefix("socialnet_buddyfriends")." WHERE uid=$myid";
//count my friends
$sqlstr2="SELECT Count(*) FROM ".$xoopsDB->prefix("socialnet_buddyfriends")." WHERE uid=$myid";
$result2 = $xoopsDB->query($sqlstr2) or die($xoopsDB->error() );
while (list($rep) = $xoopsDB->fetchRow($result2)) {
        $numfriends = $rep;
        }
$resultzz = $xoopsDB->query($sqlstr) or die($xoopsDB->error() );
//begin of html
echo "<table width=\"100%\" cellspacing=\"1\" class=\"outer\"><tr><th colspan=\"4\">
<font size=2>"._MD_SOCIALNET_BUDDY_FRIENDSLIST_HAVE."<b>$numfriends</b>"._MD_SOCIALNET_BUDDY_FRIENDSLIST_ACTUAL."</font></th></tr>";
while ($userinfo = $xoopsDB->fetchArray($resultzz) ) {
        $userinfo = new XoopsUser($userinfo['fuid']);
        $zuid=$userinfo->uid();
        $zuname=$userinfo->uname();
        $zavatar=$userinfo->user_avatar();
        echo "<tr class='odd'><td align='center' valign='middle'>";
        echo "<img src=\"".XOOPS_UPLOAD_URL."/".$zavatar."\" name=\"avatar\" id=\"avatar\" width=\"100\" height=\"100\"'>";
        echo "</td><td align=center valign='middle'>";
        echo "<a href=\"javascript:window.opener.location='".XOOPS_URL."/userinfo.php?uid=$zuid';javascript:window.location='buddy.php?task=buddyfriend';\"><font size=2>".ucfirst($zuname)."</font></a>";
        echo "</td><td align=center valign='middle'>";
        echo "<a href=\"buddy.php?task=remove&uid=$zuid\"><font size=1>Remove</font></a>";
        echo "</td><td align=center valign='middle'>";
        echo "<a href=\"javascript:IM('".XOOPS_URL."/pmlite.php?send2=1&to_userid=$zuid','pmlite',450,370);\"><img src=\"".XOOPS_URL."/images/icons/pm_small.gif\" border=\"0\" width=\"27\" height=\"17\" alt=\"\" /></a>";
        echo "</td></tr>";
        }
echo "</table>";
echo "<br>";
echo "</center>";
}
function displayUsersList($beg_in, $let_in) {
global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsTheme, $xoopsLogger, $xoopsMF;
$ModName = "Messenger";
$idd =$xoopsUser->getVar("uid", "E");
$sql = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("priv_msgs")." WHERE to_userid = '$idd' AND read_msg='0'");
if ($row = $xoopsDB->getRowsNum($sql)) {
while ($msgs = $xoopsDB->fetchArray($sql)) {
echo "<SCRIPT LANGUAGE=\"JavaScript\">\n
var telwin = null;\n
telwin = window.open(\"buddy.php?task=buddyread&msg_id=$msgs[msg_id]\", \"$priv_msg[msg_time]\", \"width=450,height=370,toolbar=no,location=no,menubar=no,scrollbars=yes,resizeable=no,status=no\");\n
</SCRIPT>\n\n";
        }
}
move();
	$isadmin = 0;
echo "<title>".$xoopsConfig['sitename']." - $ModName</title>
<script language=\"javascript\">\nfunction IM(IM) { var MainWindow = window.open (IM, \"_blank\",\"width=450,height=370,toolbar=no,location=no,menubar=no,scrollbars=no,resizeable=no,status=no\");}\n</script>
</head><body onload=setInterval('self.location.reload()',20000)>";
echo "<center><table class='outer'><tr class='odd'><td align='center'>";
echo "<p class=normal><a href=buddy.php><font size=2>"._MD_SOCIALNET_BUDDY_WHOISONLINE."</a>&nbsp;&nbsp;|&nbsp;&nbsp;";
echo "<a href=buddy.php?task=buddyfriend>"._MD_SOCIALNET_BUDDY_MYFRIENDS."</a>&nbsp;&nbsp;|&nbsp;&nbsp;";
echo "<a href=buddy.php?task=mod>"._LIST."</a></font></td></tr></table><br>";
$myid=$xoopsUser->uid();
//$p = $xoopsConfig["prefix"];
//##
if (is_numeric($beg_in)==false) {
        $beg_in=0;
        }
else {
if ($beg_in<1) {
        $beg_in=0;
        }
}
if ($let_in) {
$let_in=strip_tags($let_in);
}
//##
$tranche=20;
$inf=$beg_in;
$sup=$beg_in+$tranche;

//select users
$sqlstr ="SELECT uid, uname, level FROM ".$xoopsDB->prefix("users")." WHERE level>0 AND uid!=$myid LIMIT $inf, $tranche";

//select my friends
$sqlstr1="SELECT uid, fuid FROM ".$xoopsDB->prefix("socialnet_buddyfriends")." WHERE uid=$myid ORDER BY fuid ASC";
$result1 = $xoopsDB->query($sqlstr1) or die($xoopsDB->error() );

//count my friends
$sqlstr2="SELECT Count(*) from ".$xoopsDB->prefix("users")." WHERE level>0 AND uid!=$myid";
$result2 = $xoopsDB->query($sqlstr2) or die($xoopsDB->error() );
while (list($rep) = $xoopsDB->fetchRow($result2)) {
        $numusers = $rep;
        }
$ismyfriend=array();
while (list($uid,$fuid) = $xoopsDB->fetchRow($result1) ) {
        $ismyfriend[$fuid]=1;
        }

//letters
if ($let_in) {
$let_in1=strtoupper($let_in);
$let_in2=strtolower($let_in);
$sqlstr="SELECT uid, uname, level FROM ".$xoopsDB->prefix("users")." WHERE (((uname LIKE '$let_in1%') OR (uname LIKE '$let_in2%')) AND level>0 AND uid!=$myid)";
}
$result = $xoopsDB->query($sqlstr) or die($xoopsDB->error() );

//##links for next/previous pages
$prevlink="";
$nextlink="";
if ($sup<$numusers) {
$nextlink="<a href='buddy.php?task=mod&beg=$sup'>"._MD_SOCIALNET_BUDDY_NEXT."</a>";
$aff_sup=$sup;
}
else {
$aff_sup=$numusers;
}
$prevn=$inf-$tranche;
if ($prevn>=0) {
$prevlink="<a href='buddy.php?task=mod&beg=$prevn'>"._MD_SOCIALNET_BUDDY_PREVIOUS."</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$aff_inf=$inf+1;
}
else {
$aff_inf=1;
}
//num pages
$numz=0;
$numpage=1;
$pagesLinks="";
while ($numz<$numusers) {
$pagesLinks.="<a href='buddy.php?task=mod&beg=$numz'>$numpage</a>&nbsp;&nbsp;";
$numz+=$tranche;
$numpage++;
}
//##
//begin of html
echo "<table width=\"100%\" cellspacing=\"1\" class=\"outer\"><tr><th colspan=\"4\">";
echo "<font size=2><a href='buddy.php?task=mod'>"._MD_SOCIALNET_BUDDY_ALL."</a>&nbsp;&nbsp;";
echo "<a href='buddy.php?task=mod&letter=A'>A</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=B'>B</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=C'>C</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=D'>D</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=E'>E</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=F'>F</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=G'>G</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=H'>H</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=I'>I</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=J'>J</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=K'>K</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=L'>L</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=M'>M</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=N'>N</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=O'>O</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=P'>P</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=Q'>Q</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=R'>R</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=S'>S</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=T'>T</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=U'>U</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=V'>V</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=W'>W</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=X'>X</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=Y'>Y</a>&nbsp;";
echo "<a href='buddy.php?task=mod&letter=Z'>Z</a></font>";
echo "</th></tr>";
while ($userinfo = $xoopsDB->fetchArray($result) ) {
        $userinfo = new XoopsUser($userinfo['uid']);
        $zuid=$userinfo->uid();
        $zuname=$userinfo->uname();
        $zavatar=$userinfo->user_avatar();
        echo "<tr class='odd'><td align='center' valign='middle'>";
        echo "<img src=\"".XOOPS_UPLOAD_URL."/".$zavatar."\" name=\"avatar\" id=\"avatar\" width=\"100\" height='100'>";
        echo "</td><td align='center'  valign='middle'>";
        if ($ismyfriend[$zuid]!=1) {
                echo "<a href='".XOOPS_URL."/userinfo.php?uid=$zuid' target=new><font size=2>".ucfirst($zuname)."</font></a>";
                }
        else {
                echo "<a href=\"javascript:window.opener.location='".XOOPS_URL."/userinfo.php?uid=$zuid';javascript:window.location='buddy.php?task=mod';\"><font color='#D13313' size=2><b>".ucfirst($zuname)."</b></font></a>";
                }
        echo "</td><td align=center  valign='middle'>";
        if ($ismyfriend[$zuid]!=1) {
                echo "<a href=\"buddy.php?task=add&uid=$zuid\"><font size=1>Add</font></a>";
                }
        else {
                echo "<a href=\"buddy.php?task=remove&uid=$zuid\"><font size=1>Remove</font></a>";
                }
        echo "</td><td align=center valign='middle'><a href=\"javascript:IM('".XOOPS_URL."/pmlite.php?send2=1&to_userid=$zuid','pmlite',450,370);\">
<img src=\"".XOOPS_URL."/images/icons/pm_small.gif\" border=\"0\" width=\"27\" height=\"17\" alt=\"\" /></a></td></tr>";
        }
echo "</table>";
echo "<br /><center>";
if (!isset($let_in)) {
echo _MD_SOCIALNET_BUDDY_MEMBERS." ".$aff_inf." ". _MD_SOCIALNET_BUDDY_TO." ".$aff_sup."<br /><br />";
echo $prevlink.$nextlink;
if ($numpage>2 && $numpage<20) {
        echo "<br />"._MD_SOCIALNET_BUDDY_PAGES." ";
        echo $pagesLinks;
        }
if ($numpage>20) {
        echo "";
        }
}
echo "</center>";
}
function addFriend($fuid_in) {
global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsTheme, $xoopsLogger, $xoopsMF;
$myid=$xoopsUser->uid();
//control if $fuid is not already a friend
$sqlstr1="SELECT uid, fuid FROM ".$xoopsDB->prefix("socialnet_buddyfriends")." WHERE uid=$myid ORDER BY fuid ASC";
$req1=mysql_query($sqlstr1);
while (list($uid, $fuid) = mysql_fetch_row($req1)) {
        if ($fuid==$fuid_in) {
                friendExists();
                $doNot=1;
                }
        }
//add a friend in database
//& secure? &
if (is_numeric($fuid_in)==false) {
        header("Location: ./buddy.php");
        }
//&&
if ($doNot!=1) {
        $sqlstr ="INSERT INTO ".$xoopsDB->prefix("socialnet_buddyfriends")." (uid, fuid) VALUES ($myid, $fuid_in)";
        $req=mysql_query($sqlstr);
        if ($req) {
                echo "<table align='center' cellpadding='0' border='0'><tr><td align='center'>";
                echo "<br /><br /><b>"._MD_SOCIALNET_BUDDY_FRIENDADDED."</b>";
                echo "<br /><br /><br /><a href='buddy.php?task=mod'>"._MD_SOCIALNET_BUDDY_BACKTOMODPAGE."</a>";
                echo "<br /><br /><a href='buddy.php?task=buddyfriend'>"._MD_SOCIALNET_BUDDY_BACKTOLIST."</a>";
                echo "</td></tr></table>";
                }
        else {
                echo _MD_SOCIALNET_BUDDY_PROBLEM;
                }
        }
}
function deleteFriend($fuid_in) {
//& secure? &
if (is_numeric($fuid_in)==false) {
        header("Location: ./buddy.php");
        }
global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsTheme, $xoopsLogger, $xoopsMF;
$myid=$xoopsUser->uid();
$sqlstr="DELETE FROM ".$xoopsDB->prefix("socialnet_buddyfriends")." WHERE (uid=$myid AND fuid=$fuid_in)";
$req1=mysql_query($sqlstr);
echo "<table align='center' cellpadding='0' border='0'><tr><td align='center'>";
if ($req1) {
        echo "<br /><br /><b>"._MD_SOCIALNET_BUDDY_FRIENDDELETED."</b>";
        }
echo "<br /><br /><br /><a href='buddy.php?task=mod'>"._MD_SOCIALNET_BUDDY_BACKTOMODPAGE."</a>";
echo "<br /><br /><a href='buddy.php?task=buddyfriend'>"._MD_SOCIALNET_BUDDY_BACKTOLIST."</a>";
echo "</td></tr></table>";
}
function updateLastseen(){
	global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsTheme, $xoopsLogger, $xoopsMF, $REMOTE_ADDR;
	$past = time() - 300; // anonymous records are deleted after 10 minutes
	$userpast = time() - 8640000; // user records idle for the past 100 days are deleted
	$ip = $REMOTE_ADDR;
	if ($xoopsUser) {
		$uid = $xoopsUser->getVar("uid");
		$uname = $xoopsUser->getVar("uname");
	} else {
		$uid = 0;
		$uname = "Anonymous";
	}
	$sql = "SELECT * FROM ".$xoopsDB->prefix("online")." WHERE online_uname=".$uname."";
	if ( $uid == 0 ) {
		$sql .= " AND ip='".$ip."'";
	}
	//echo $sql;
	$result = $xoopsDB->query($sql);
	list($getRowsNum) = $xoopsDB->fetchRow($result);
}

function buddy_smile($message) {
    $message = str_replace(":)", "<IMG SRC=\"../../images/smilies/icon_smile.gif\">", $message);
    $message = str_replace(":-)", "<IMG SRC=\"../../images/smilies/icon_smile.gif\">", $message);
    $message = str_replace(":(", "<IMG SRC=\"../../images/smilies/icon_frown.gif\">", $message);
    $message = str_replace(":-(", "<IMG SRC=\"../../images/smilies/icon_frown.gif\">", $message);
    $message = str_replace(":-D", "<IMG SRC=\"../../images/smilies/icon_biggrin.gif\">", $message);
    $message = str_replace(":D", "<IMG SRC=\"../../images/smilies/icon_biggrin.gif\">", $message);
    $message = str_replace(";)", "<IMG SRC=\"../../images/smilies/icon_wink.gif\">", $message);
    $message = str_replace(";-)", "<IMG SRC=\"../../images/smilies/icon_wink.gif\">", $message);
    $message = str_replace(":o", "<IMG SRC=\"../../images/smilies/icon_eek.gif\">", $message);
    $message = str_replace(":O", "<IMG SRC=\"../../images/smilies/icon_eek.gif\">", $message);
    $message = str_replace(":-o", "<IMG SRC=\"../../images/smilies/icon_eek.gif\">", $message);
    $message = str_replace(":-O", "<IMG SRC=\"../../images/smilies/icon_eek.gif\">", $message);
    $message = str_replace("8)", "<IMG SRC=\"../../images/smilies/icon_cool.gif\">", $message);
    $message = str_replace("8-)", "<IMG SRC=\"../../images/smilies/icon_cool.gif\">", $message);
    $message = str_replace(":?", "<IMG SRC=\"../../images/smilies/icon_confused.gif\">", $message);
    $message = str_replace(":-?", "<IMG SRC=\"../../images/smilies/icon_confused.gif\">", $message);
    $message = str_replace(":p", "<IMG SRC=\"../../images/smilies/icon_razz.gif\">", $message);
    $message = str_replace(":P", "<IMG SRC=\"../../images/smilies/icon_razz.gif\">", $message);
    $message = str_replace(":-p", "<IMG SRC=\"../../images/smilies/icon_razz.gif\">", $message);
    $message = str_replace(":-P", "<IMG SRC=\"../../images/smilies/icon_razz.gif\">", $message);
    $message = str_replace(":-|", "<IMG SRC=\"../../images/smilies/icon_mad.gif\">", $message);
    $message = str_replace(":|", "<IMG SRC=\"../../images/smilies/icon_mad.gif\">", $message);
    return($message);
}


function buddy_bbencode($message) {

        // [CODE] and [/CODE] for posting code (HTML, PHP, C etc etc) in your posts.
        $matchCount = preg_match_all("#\[code\](.*?)\[/code\]#si", $message, $matches);

        for ($i = 0; $i < $matchCount; $i++)
        {
                $currMatchTextBefore = preg_quote($matches[1][$i]);
                $currMatchTextAfter = htmlspecialchars($matches[1][$i]);
                $message = preg_replace("#\[code\]$currMatchTextBefore\[/code\]#si", "<!-- BBCode Start --><TABLE BORDER=0 ALIGN=CENTER WIDTH=85%><TR><TD><font class=\"pn-sub\">Code:</font><HR></TD></TR><TR><TD><FONT class=\"pn-sub\"><PRE>$currMatchTextAfter</PRE></FONT></TD></TR><TR><TD><HR></TD></TR></TABLE><!-- BBCode End -->", $message);
        }

        // [QUOTE] and [/QUOTE] for posting replies with quote, or just for quoting stuff.
        $message = preg_replace("#\[quote\](.*?)\[/quote]#si", "<!-- BBCode Quote Start --><TABLE BORDER=0 ALIGN=CENTER WIDTH=85%><TR><TD><font class=\"pn-sub\">Quote:</font><HR></TD></TR><TR><TD><FONT class=\"pn-sub\"><BLOCKQUOTE>\\1</BLOCKQUOTE></FONT></TD></TR><TR><TD><HR></TD></TR></TABLE><!-- BBCode Quote End -->", $message);

        // [b] and [/b] for bolding text.
        $message = preg_replace("#\[b\](.*?)\[/b\]#si", "<!-- BBCode Start --><B>\\1</B><!-- BBCode End -->", $message);

        // [i] and [/i] for italicizing text.
        $message = preg_replace("#\[i\](.*?)\[/i\]#si", "<!-- BBCode Start --><I>\\1</I><!-- BBCode End -->", $message);

        // [url]www.phpbb.com[/url] code..
        $message = preg_replace("#\[url\](http://)?(.*?)\[/url\]#si", "<!-- BBCode Start --><A HREF=\"http://\\2\" TARGET=\"_blank\">\\2</A><!-- BBCode End -->", $message);

        // [url=www.phpbb.com]phpBB[/url] code..
        $message = preg_replace("#\[url=(http://)?(.*?)\](.*?)\[/url\]#si", "<!-- BBCode Start --><A HREF=\"http://\\2\" TARGET=\"_blank\">\\3</A><!-- BBCode End -->", $message);

        // [email]user@domain.tld[/email] code..
        $message = preg_replace("#\[email\](.*?)\[/email\]#si", "<!-- BBCode Start --><A HREF=\"mailto:\\1\">\\1</A><!-- BBCode End -->", $message);

        // [img]image_url_here[/img] code..
        $message = preg_replace("#\[img\](.*?)\[/img\]#si", "<!-- BBCode Start --><IMG SRC=\"\\1\"><!-- BBCode End -->", $message);

        // unordered list code..
        $matchCount = preg_match_all("#\[list\](.*?)\[/list\]#si", $message, $matches);

        for ($i = 0; $i < $matchCount; $i++)
        {
                $currMatchTextBefore = preg_quote($matches[1][$i]);
                $currMatchTextAfter = preg_replace("#\[\*\]#si", "<LI>", $matches[1][$i]);

                $message = preg_replace("#\[list\]$currMatchTextBefore\[/list\]#si", "<!-- BBCode ulist Start --><UL>$currMatchTextAfter</UL><!-- BBCode ulist End -->", $message);
        }

        // ordered list code..
        $matchCount = preg_match_all("#\[list=([a1])\](.*?)\[/list\]#si", $message, $matches);

        for ($i = 0; $i < $matchCount; $i++)
        {
                $currMatchTextBefore = preg_quote($matches[2][$i]);
                $currMatchTextAfter = preg_replace("#\[\*\]#si", "<LI>", $matches[2][$i]);

                $message = preg_replace("#\[list=([a1])\]$currMatchTextBefore\[/list\]#si", "<!-- BBCode olist Start --><OL TYPE=\\1>$currMatchTextAfter</OL><!-- BBCode olist End -->", $message);
        }

        return($message);
}


function buddy_make_clickable($text) {
        $ret = eregi_replace(" ([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])", " <a href=\"\\1://\\2\\3\" target=\"_blank\" target=\"_new\">\\1://\\2\\3</a>", $text);
        $ret = eregi_replace(" (([a-z0-9_]|\\-|\\.)+@([^[:space:]]*)([[:alnum:]-]))", " <a href=\"mailto:\\1\" target=\"_new\">\\1</a>", $ret);
        return($ret);
}


function move() {
echo "<SCRIPT LANGUAGE=\"javascript\">
<!--
window.moveTo(10,10);
//-->
</SCRIPT>";
}
?>