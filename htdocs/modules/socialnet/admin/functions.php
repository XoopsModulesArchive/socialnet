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
	die("XOOPS root path not defined");
}

function adminmenu($currentoption=0, $breadcrumb = "")
{
    global $xoopsModule, $xoopsConfig;
    $tblColors=Array();
    $tblColors[1]=$tblColors[2]=$tblColors[3]=$tblColors[4]=$tblColors[5]=$tblColors[6]=$tblColors[7]=$tblColors[8]=$tblColors[9]=$tblColors[10]=$tblColors[11]=$tblColors[12]=$tblColors[13]=$tblColors[14]=$tblColors[15]=$tblColors[16]=$tblColors[17]=$tblColors[18]=$tblColors[19]=$tblColors[20]=$tblColors[21]=$tblColors[22]=$tblColors[23]=$tblColors[24]=$tblColors[25]=$tblColors[26]=$tblColors[27]=$tblColors[28]=$tblColors[29]=$tblColors[30]=$tblColors[31]='';
    if($currentoption>=0) {
    $tblColors[$currentoption]='id=\'current\'';;
	}
    if (file_exists(XOOPS_ROOT_PATH.'/modules/socialnet/language/'.$xoopsConfig['language'].'/modinfo.php')) {
        include_once '../language/'.$xoopsConfig['language'].'/modinfo.php';
    }
    else {
        include_once '../language/english/modinfo.php';
    }
    
    /* Nice buttons styles */
    $return = "
    	<style type='text/css'>
    	#buttontop { float:left; width:100%; background: #dae0d2; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
		#admintabs { FONT-SIZE: 93%; BACKGROUND: url(images/bg.gif) #dae0d2 repeat-x 50% bottom; FLOAT: left; WIDTH: 100%; LINE-HEIGHT: normal; border-left: 1px solid black; border-right: 1px solid black; }
        #admintabs ul { PADDING-RIGHT: 10px; PADDING-LEFT: 10px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 10px; LIST-STYLE-TYPE: none; }
        #admintabs li {PADDING-RIGHT: 0px; PADDING-LEFT: 9px; BACKGROUND: url(images/left.gif) no-repeat left top; FLOAT: left; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; list-style: none; }
        #admintabs A { PADDING-RIGHT: 15px; DISPLAY: block; PADDING-LEFT: 6px; FONT-WEIGHT: bold; BACKGROUND: url(images/right.gif) no-repeat right top; FLOAT: left; PADDING-BOTTOM: 4px; COLOR: #765; PADDING-TOP: 5px; TEXT-DECORATION: none }
        #admintabs A { FLOAT: left; }
        #admintabs A:hover { COLOR: #333 }
        #admintabs #current { BACKGROUND-IMAGE: url(images/left_on.gif) }
        #admintabs #current A { BACKGROUND-IMAGE: url(images/right_on.gif); COLOR: #333; float:left; }
		</style>
    ";
    
    include XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/admin/menu.php";

    $return .= "<div id='buttontop'>";
    $return .= "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
	$return .= "<td style='width: 60%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;'><a class='nobutton' href='" . XOOPS_URL . "/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoopsModule->getVar('mid') . "'>" . _AM_SOCIALNET_PREFERENCES . "</a> | <a href='" . XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/index.php'>" . _AM_SOCIALNET_GOMOD . " </a> | <a href='" . XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/admin/tutorial_credit.php'>" . _AM_SOCIALNET_HELPCREDIT . " </a> | <a href='" . XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/admin/feedback.php'>" . _AM_SOCIALNET_FEEDBACK . " </a> | <a href=\"../../system/admin.php?fct=modulesadmin&op=update&module=socialnet\">" . _AM_SOCIALNET_UPDATE . "</a></td>";
    $return .= "<td style='width: 40%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;'><b>" . $xoopsModule->name() . " " . _AM_SOCIALNET_MODADMIN . "</b> " . $breadcrumb . "</td>";
    $return .= "</tr></table>";
    $return .= "</div>";
    $return .= "<div id='admintabs'>";
    $return .= "<ul>";
    foreach ($adminmenu as $key => $menu) {
        $return .= "<li ". $tblColors[$key] . "><a href=\"" . XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/".$menu['link']."\">" . $menu['title'] . "</a></li>";
    }
    $return .= "</ul></div><div style=\"clear:both;\"></div>";
    
    echo $return;
    
/*    
  	echo "<div id=\"navcontainer\"><ul style=\"padding: 3px 0; margin-left: 0; font: bold 12px Verdana, sans-serif; \">";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"index.php?\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[1]."; text-decoration: none; \">"._MI_SOCIALNET_ADMENU1."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"blocksadmin.php?\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[2]."; text-decoration: none; \">"._MI_SOCIALNET_ADMENU2."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"about.php?\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[3]."; text-decoration: none; \">"._MI_SOCIALNET_ADMENU3."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"userpage.php?\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[4]."; text-decoration: none; \">"._MI_SOCIALNET_ADMENU4."</a></li>";

	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"news.php?op=topicsmanager\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[5]."; text-decoration: none; \">"._MI_SOCIALNET_ADMENU5."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"news.php?op=newarticle\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[6]."; text-decoration: none; \">"._MI_SOCIALNET_ADMENU6."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"groupperms.php\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[7]."; text-decoration: none; \">"._MI_SOCIALNET_NEWS_ADMENU7."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"spotlight.php\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[8]."; text-decoration: none; \">"._AM_SOCIALNET_ADMENU8."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"news.php?op=audience\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[9]."; text-decoration: none; \">"._AM_SOCIALNET_ADMENU9."</a></li>";

	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"tools_add_note.php?\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[10]."; text-decoration: none; \">"._AM_SOCIALNET_ADMENU10."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"tools_optimize.php?\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[11]."; text-decoration: none; \">"._AM_SOCIALNET_ADMENU11."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"tools_activeall_user.php?\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[12]."; text-decoration: none; \">"._AM_SOCIALNET_ADMENU12."</a></li>";

	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"sec.php?op=list\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[13]."; text-decoration: none; \">"._AM_SOCIALNET_ADMENU13."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"spot.php?op=list\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[14]."; text-decoration: none; \">"._AM_SOCIALNET_ADMENU14."</a></li>";

	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"treepages.php\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[15]."; text-decoration: none; \">"._MI_SOCIALNET_ADMENU15."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"treemenu.php?op=new\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[16]."; text-decoration: none; \">"._MI_SOCIALNET_ADMENU16."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"treemenu.php?op=list\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[17]."; text-decoration: none; \">"._MI_SOCIALNET_ADMENU17."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"treemedia.php\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[18]."; text-decoration: none; \">"._MI_SOCIALNET_MENU_ADMENU18."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"treefiles.php\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[19]."; text-decoration: none; \">"._MI_SOCIALNET_MENU_ADMENU19."</a></li>";

	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"languages.php\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[20]."; text-decoration: none; \">"._MI_SOCIALNET_MENU_ADMENU20."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"beginchat.php\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[21]."; text-decoration: none; \">"._MI_SOCIALNET_MENU_ADMENU21."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"admin_forumbegin.php\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[22]."; text-decoration: none; \">"._MI_SOCIALNET_MENU_ADMENU22."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"tutorial_credit.php\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[31]."; text-decoration: none; \">"._MI_SOCIALNET_MENU_ADMENU31."</a></li>";

	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=".$xoopsModule -> getVar( 'mid' )."\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[1]."; text-decoration: none; \">"._PREFERENCES."</a></li>";
	echo "</ul></div>";
*/	
}

function table_exists($tablename) {
    global $xoopsDB;
    $sql = "SELECT COUNT(*) FROM ".$xoopsDB->prefix($tablename);
    return $xoopsDB->query($sql);
}


function socialnet_collapsableBar($tablename = '', $iconname = '')
{

    ?>
	<script type="text/javascript"><!--
	function goto_URL(object)
	{
		window.location.href = object.options[object.selectedIndex].value;
	}

	function toggle(id)
	{
		if (document.getElementById) { obj = document.getElementById(id); }
		if (document.all) { obj = document.all[id]; }
		if (document.layers) { obj = document.layers[id]; }
		if (obj) {
			if (obj.style.display == "none") {
				obj.style.display = "";
			} else {
				obj.style.display = "none";
			}
		}
		return false;
	}

	var iconClose = new Image();
	iconClose.src = 'images/close12.gif';
	var iconOpen = new Image();
	iconOpen.src = 'images/open12.gif';

	function toggleIcon ( iconName )
	{
		if ( document.images[iconName].src == window.iconOpen.src ) {
			document.images[iconName].src = window.iconClose.src;
		} else if ( document.images[iconName].src == window.iconClose.src ) {
			document.images[iconName].src = window.iconOpen.src;
		}
		return;
	}

	//-->
	</script>
	<?php
	echo "<h4 style=\"color: #2F5376; margin: 6px 0 0 0; \"><a href='#' onClick=\"toggle('" . $tablename . "'); toggleIcon('" . $iconname . "');\">";
}
?>
