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


   $myts =& MyTextSanitizer::getInstance();
  define('_note_TABLE',$xoopsDB->prefix('socialnet_note'));
  if (isset($_GET['show'])) {
        $show = intval($_GET['show']);
} else {
        $show = $xoopsModuleConfig['perpage'];
}
$min = isset($_GET['min']) ? intval($_GET['min']) : 0;
if (!isset($max)) {
	$max = $min + $show;
}
  if ( !empty($_GET['xid']) ) {
    $sql = "DELETE FROM "._note_TABLE." WHERE xid = ".intval($_GET['xid']);
    $result=$xoopsDB->queryF($sql);
  }
   xoops_cp_header();
   adminmenu(10);
  include("admin_header.php");
  $class = 'even';
  echo "<table class='outer' cellSpacing='1' width='100%'>";
  echo '<th>'._AM_SOCIALNET_AMSGNOTE1.'</th><th>'._AM_SOCIALNET_AMSGDELETE.'</th></tr>';
  //read data
  $sql=$xoopsDB->query("select count(xid) from ".$xoopsDB->prefix("socialnet_note"));
  list($numrows) = $xoopsDB->fetchRow($sql);
  $sql="SELECT * FROM "._note_TABLE;
  $sql.=" ORDER BY xid DESC LIMIT ".$min.",".$show;
  $result=$xoopsDB->query($sql);
  while( $val = $xoopsDB->fetchArray($result) ){
    $class = ($class == 'even') ? 'odd' : 'even';
    echo "<tr class='$class'>";
      echo '<td>'.$myts->htmlSpecialChars($val['comment']).'</td>';
       echo '<td><img src="../images/icons/dele.gif"><a href="tools_add_note.php?xid='.$val['xid'].'">'._AM_SOCIALNET_AMSGDELETE.'</a>&nbsp;&nbsp; - &nbsp;&nbsp;<img src="../images/icons/edit.gif"><a href="tools_edit.php?xid='.$val['xid'].'">'._AM_SOCIALNET_MSGEDIT.'</a></td>';
    echo '</tr>';
  }
  echo '</table>';
  	$msgpages = ceil($numrows / $show);
if ($msgpages!=1 && $msgpages!=0) {
       		echo "<br /><br />";
        	$prev = $min - $show;
        	if ($prev>=0) {
        		echo "&nbsp;<a href='tools_add_note.php?min=$prev&show=$show'>";
                 echo "&nbsp;"._AM_SOCIALNET_MSGPRV."&nbsp;";
        	}
$counter = 1;
        	$currentpage = ($max / $show);
        	while ( $counter<=$msgpages ) {
               		$mintemp = ($show * $counter) - $show;
               		if ($counter == $currentpage) {
				echo "<b>$counter</b>&nbsp;";
			} else {
				echo "<a href='tools_add_note.php?min=$mintemp&show=$show'>$counter</a>&nbsp;";
			}
               		$counter++;
        	}
if ( $numrows>$max ) {
        		echo "&nbsp;<a href='tools_add_note.php?min=$max&show=$show'>";
                 echo "&nbsp;"._AM_SOCIALNET_MSGNEXT."&nbsp;";
        	}
    	  }
?>

  <form method="post" name="form" action="tools_note.php">
      <table cellspacing="1" cellpadding="2" border="0" class="outer" width="100%">
         <tr>
            <td class="odd" width="344">
               <script type="text/javascript">
                  function emoticon(text) {
                     var txtarea = document.getElementById("form").comment;
                     text = ' ' + text + ' ';
                     if (txtarea.createTextRange && txtarea.caretPos) {
                        var caretPos = txtarea.caretPos;
                        caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
                        txtarea.focus();
                     } else {
                        txtarea.value  += text;
                        txtarea.focus();
                     }
                  }


	var isSelected = false;

	function copySelection(workArea){

		workArea.workText = document.selection.createRange();
		isSelected = true;
	}

	function wrapInTags(workArea,isTag){

  		if (isSelected)
			{
			 workArea.workText.text = "["+isTag+"]"+workArea.workText.text+"[/"+isTag+"]";
			 if (workArea.workText.text==''){isSelected=false;workArea.focus()}
  			}
	}

	function AddURL(workArea){

	var AddURL="";
	var txt="";


	txt=prompt("Enter URL for the link.","http://");
	AddURL="[url="+txt+"]";
	AddURL2="[/url]";


  	if (isSelected)
		{
		 workArea.workText.text = AddURL+workArea.workText.text+AddURL2;
		 if (workArea.workText.text==''){isSelected=false;workArea.focus()}
  		}

	}

</Script>
<!-- Smiley List Starts Here -->

<table width="100%" border="0" cellspacing="0" cellpadding="5">
<tr align="center" valign="middle">
    <td width="5%"><a href="javascript:emoticon(':-D')"><img border="0" alt="Very Happy" title="Very Happy" src="../../../uploads/smil3dbd4d4e4c4f2.gif" width="17" height="17"></a></td>
    <td width="5%"><a href="javascript:emoticon(':-)')"><img border="0" alt="Smile" title="Smile" src="../../../uploads/smil3dbd4d6422f04.gif" width="17" height="17"></a></td>
    <td width="5%"><a href="javascript:emoticon(':-(')"><img border="0" alt="Sad" title="Sad" src="../../../uploads/smil3dbd4d75edb5e.gif" width="17" height="17"></a></td>
    <td width="5%"><a href="javascript:emoticon(':-o')"><img border="0" alt="Surprised" title="Surprised" src="../../../uploads/smil3dbd4d8676346.gif" width="17" height="17"></a></td>
    <td width="5%"><a href="javascript:emoticon(':-?')"><img border="0" alt="Confused" title="Confused" src="../../../uploads/smil3dbd4d99c6eaa.gif" width="17" height="17"></a></td>
    <td width="5%"><a href="javascript:emoticon('8-)')"><img border="0" alt="Cool" title="Cool" src="../../../uploads/smil3dbd4daabd491.gif" width="17" height="17"></a></td>
    <td width="5%"><a href="javascript:emoticon(':lol:')"><img border="0" alt="Laughing" title="Laughing" src="../../../uploads/smil3dbd4dbc14f3f.gif" width="15" height="15"></a></td>
    <td width="5%"><a href="javascript:emoticon(':-x')"><img border="0" alt="Mad" title="Mad" src="../../../uploads/smil3dbd4dcd7b9f4.gif" width="17" height="17"></a></td>
    <td width="6%"><a href="javascript:emoticon(':-P')"><img border="0" alt="Razz" title="Razz" src="../../../uploads/smil3dbd4ddd6835f.gif" width="17" height="17"></td>
    <td width="6%"><a href="javascript:emoticon(':oops:')"><img border="0" alt="Embaressed" title="Embaressed" src="../../../uploads/smil3dbd4df1944ee.gif" width="17" height="17"></a></td>
    <td width="6%"><a href="javascript:emoticon(':cry:')"><img border="0" alt="Crying (very sad)" title="Crying (very sad)" src="../../../uploads/smil3dbd4e02c5440.gif" width="17" height="17"></a></td>
    <td width="6%"><a href="javascript:emoticon(':evil:')"><img border="0" alt="Evil or Very Mad" title="Evil or Very Mad" src="../../../uploads/smil3dbd4e1748cc9.gif" width="17" height="17"></a></td>
    <td width="6%"><a href="javascript:emoticon(':roll:')"><img border="0" alt="Rolling Eyes" title="Rolling Eyes" src="../../../uploads/smil3dbd4e29bbcc7.gif" width="17" height="17"></a></td>
    <td width="6%"><a href="javascript:emoticon(';-)')"><img border="0" alt="Wink" title="Wink" src="../../../uploads/smil3dbd4e398ff7b.gif" width="17" height="17"></a></td>
    <td width="6%"><a href="javascript:emoticon(':pint:')"><img border="0" alt="Another pint of beer" title="Another pint of beer" src="../../../uploads/smil3dbd4e4c2e742.gif" width="45" height="20"></a></td>
    <td width="6%"><a href="javascript:emoticon(':hammer:')"><img border="0" alt="ToolTimes at work" title="ToolTimes at work" src="../../../uploads/smil3dbd4e5e7563a.gif" width="30" height="26"></a></td>
    <td width="6%"><a href="javascript:emoticon(':idea:')"><img border="0" alt="I have an idea" title="I have an idea" src="../../../uploads/smil3dbd4e7853679.gif" width="17" height="17"></a></td>
</tr>
</table>

<!-- Smiley List Stops Here -->
            </td>
         </tr>
         <tr>
            <td class="odd" width="100%">
            <p>  <input type=button value='Italic' onclick="wrapInTags(this.form.comment,'i')"><input type=button value='Bold' onclick="wrapInTags(this.form.comment,'b')"><input type=button value='Underline' onclick="wrapInTags(this.form.comment,'u')"><input type=button value='Link' onclick="AddURL(this.form.comment)"></p>
            <p>  <? echo _AM_SOCIALNET_MSGBBOCE; ?></p>
            				                 <textarea rows="10" id="comment" name="comment" cols="41" onselect="copySelection(this)"></textarea>&nbsp;&nbsp;&nbsp;

            <p><? echo _AM_SOCIALNET_MSGNAME; ?><input type="text" name="name" size="20" value="<? echo _AM_SOCIALNET_MSGAdmin; ?>"></p>
            <p>

<input type=submit value='Submit'></td>


  </tr>
</table>
</form>

<?
echo "<div align='center' style='margin-top:10px'><a href='http://www.ipwgc.com/socialnet/'><img src='../images/socialnetLogo.png'></a><br /><img src='../images/menu/mailuser.gif'><a style='color: #029116; font-size:11px' href='feedback.php'>"._AM_SOCIALNET_FEEDBACK."</a> - <img src='../images/icons/mainvideo.gif'><a style='color: #FF0000; font-size:11px' href='http://www.ipwgc.com/socialnet/modules/socialnet/index.php' target='_blank'>"._AM_SOCIALNET_CHKVERSION."</a></div>";
xoops_cp_footer();
?>