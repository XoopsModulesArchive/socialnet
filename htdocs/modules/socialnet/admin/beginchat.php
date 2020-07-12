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

include_once("admin_header.php");
require_once '../../../include/cp_header.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/include/common.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/admin/functions.php';
require_once XOOPS_ROOT_PATH.'/class/pagenav.php';
include_once XOOPS_ROOT_PATH . "/modules/socialnet/class/socialnet_chat_marquee_class.php";
include_once "functions.php";
// ********************************************************************************************************************
// **** Main
// ********************************************************************************************************************

$op = 'default';
$pval = array('content','bgcolor','width','height','scrollamount','hspace'
	,'vspace','scrolldelay','direction','behaviour','align','loop','stoponmouseover'
	,'op','chatid','submit');
foreach($pval as $v){
	$$v = isset($_POST[$v]) ? $_POST[$v] : NULL;
}
if (!$op) $op = 'default';

if ( isset( $_GET['op'] ) )
{
    $op = $_GET['op'];
    if ( isset( $_GET['storyid'] ) )
    {
        $storyid = intval( $_GET['storyid'] );
    }
}

// Fonction pour ajouter et
function AddEditMarqueeForm($chatid, $Action, $FormTitle, $contentvalue, $bgcolorvalue,$widthvalue,$heightvalue,$scrollamountvalue,$hspacevalue, $vspacevalue,$scrolldelayvalue,$directionvalue,$behaviourvalue,$alignvalue,$loopvalue,$stopvalue , $LabelSubmitButton)
{
	include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
	global $xoopsModule;

	$sform = new XoopsThemeForm($FormTitle, "marqueeform", XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/admin/beginchat.php');
	$sform->addElement(new XoopsFormDhtmlTextArea(_AM_SOCIALNET_POPCHAT_CONTENT, 'content', $contentvalue, 15, 70), true);
	$sform->addElement(new XoopsFormText(_AM_SOCIALNET_POPCHAT_BGCOLOR, 'bgcolor', 7, 7, $bgcolorvalue), false);
	$sform->addElement(new XoopsFormText(_AM_SOCIALNET_POPCHAT_WIDTH, 'width', 4, 4, $widthvalue), false);
	$sform->addElement(new XoopsFormText(_AM_SOCIALNET_POPCHAT_HEIGHT, 'height',4, 4, $heightvalue), false);
	$sform->addElement(new XoopsFormText(_AM_SOCIALNET_POPCHAT_SCRAMOUNT, 'scrollamount',4, 4, $scrollamountvalue), false);
	$sform->addElement(new XoopsFormText(_AM_SOCIALNET_POPCHAT_HSPACE, 'hspace',4, 4, $hspacevalue), false);
	$sform->addElement(new XoopsFormText(_AM_SOCIALNET_POPCHAT_VSPACE, 'vspace',4, 4, $vspacevalue), false);
	$sform->addElement(new XoopsFormText(_AM_SOCIALNET_POPCHAT_SCRDELAY, 'scrolldelay',6, 6, $scrolldelayvalue), false);

	$direction= new XoopsFormSelect(_AM_SOCIALNET_POPCHAT_DIRECTION, "direction", $directionvalue);
	$direction->addOption("0", _AM_SOCIALNET_POPCHAT_DIRECTION1);
	$direction->addOption("1", _AM_SOCIALNET_POPCHAT_DIRECTION2);
	$direction->addOption("2", _AM_SOCIALNET_POPCHAT_DIRECTION3);
	$direction->addOption("3", _AM_SOCIALNET_POPCHAT_DIRECTION4);
	$sform->addElement($direction,true);

	$behaviour= new XoopsFormSelect(_AM_SOCIALNET_POPCHAT_BEHAVIOUR, "behaviour", $behaviourvalue);
	$behaviour->addOption("0", _AM_SOCIALNET_POPCHAT_BEHAVIOUR1);
	$behaviour->addOption("1", _AM_SOCIALNET_POPCHAT_BEHAVIOUR2);
	$behaviour->addOption("2", _AM_SOCIALNET_POPCHAT_BEHAVIOUR3);
	$sform->addElement($behaviour,true);

	$align= new XoopsFormSelect(_AM_SOCIALNET_POPCHAT_ALIGN, "align", $alignvalue);
	$align->addOption("0", _AM_SOCIALNET_POPCHAT_ALIGN1);
	$align->addOption("1", _AM_SOCIALNET_POPCHAT_ALIGN2);
	$align->addOption("2", _AM_SOCIALNET_POPCHAT_ALIGN3);
	$sform->addElement($align,true);

	$loop= new XoopsFormSelect(_AM_SOCIALNET_POPCHAT_LOOP, "loop", $loopvalue);
	$loop->addOption("0", _AM_SOCIALNET_POPCHAT_INFINITELOOP);
	for($i=1;$i<=100;$i++)
	{
		$loop->addOption($i, $i);
	}
	$sform->addElement($loop,true);

	$sform->addElement(new XoopsFormRadioYN(_AM_SOCIALNET_POPCHAT_STOP, 'stoponmouseover', $stopvalue, _YES, _NO));

	$sform->addElement(new XoopsFormHidden('op', $Action), false);
	if(!empty($chatid))
	{
		$sform->addElement(new XoopsFormHidden('chatid', $chatid), false);
	}
	$button_tray = new XoopsFormElementTray('' ,'');
	$submit_btn = new XoopsFormButton('', 'submit', $LabelSubmitButton, 'submit');
	$button_tray->addElement($submit_btn);
	$cancel_btn = new XoopsFormButton('', 'reset', _AM_SOCIALNET_POPCHAT_RESETBUTTON, 'reset');
	$button_tray->addElement($cancel_btn);
	$sform->addElement($button_tray);
	$sform->display();
}

// ******************************************************************************************************************************************
// **** Main ********************************************************************************************************************************
// ******************************************************************************************************************************************

switch ($op)
{
	// Verification avant ajout d'un ñÍñÎent
	case "verifybeforeedit":
		$myts =& MyTextSanitizer::getInstance();
		if ( isset($_POST['submit']) && $_POST['submit'] != "" )
		{
			if ( $content== '')
			{
            	adminmenu(21);
				xoops_cp_header();
		    	echo "<table width='100%' border='0' cellspacing='1' class='outer'>\n";
				echo "<tr><td class=\"odd\">";
		    	echo "<a href='beginchat.php'><h4>"._AM_SOCIALNET_POPCHAT_CONFIG."</h4></a>";
				echo _AM_SOCIALNET_POPCHAT_ERROR_ADD_MARQUEE;
				echo"</td></tr></table>";
				xoops_cp_footer();
				exit();
			}
			$chatid=intval($_POST['chatid']);
			$marquee = new marquee($chatid);
			$marquee->setchatid($chatid);
			$marquee->setUid($xoopsUser->getVar("uid"));
			$marquee->setdirection(intval($_POST['direction']));
			$marquee->setscrollamount(intval($_POST['scrollamount']));
			$marquee->setbehaviour(intval($_POST['behaviour']));
			$marquee->setbgcolor($myts->makeTareaData4Save($_POST['bgcolor']));
			$marquee->setalign(intval($_POST['align']));
			$marquee->setheight(intval($_POST['height']));
			$marquee->setwidth($myts->makeTareaData4Save($_POST['width']));
			$marquee->sethspace(intval($_POST['hspace']));
			$marquee->setscrolldelay(intval($_POST['scrolldelay']));
			$marquee->setstoponmouseover(intval($_POST['stoponmouseover']));
			$marquee->setloop(intval($_POST['loop']));
			$marquee->setvspace(intval($_POST['vspace']));
			$marquee->setcontent($myts->makeTareaData4Save($_POST['content']));
			if(!$marquee->store())
			{
				redirect_header("beginchat.php", 1,_AM_SOCIALNET_POPCHAT_ERROR_MODIFY_DB);
				exit();
			}
			redirect_header("./beginchat.php", 1, _AM_SOCIALNET_POPCHAT_DBUPDATED);
		}
        break;

	// Edition d'un ñÍñÎent
    case "edit":
		
        xoops_cp_header();
        adminmenu(21);
		if(isset($_GET['chatid']))
        {
    	    $chatid=intval($_GET['chatid']);
    	    $marquee = new marquee($chatid);
    	    AddEditMarqueeForm($chatid,'verifybeforeedit', _AM_SOCIALNET_POPCHAT_CONFIG, $marquee->content('Edit'), $marquee->bgcolor('Edit'), $marquee->width(), $marquee->height('Edit'), $marquee->scrollamount(), $marquee->hspace(), $marquee->vspace(), $marquee->scrolldelay(), $marquee->direction(), $marquee->behaviour(), $marquee->align(), $marquee->loop(), $marquee->stoponmouseover(),_AM_SOCIALNET_POPCHAT_UPDATE);
        }
        break;

    // Suppression d'une ligne
    case "delete":
        if ($_POST['ok'] != 1 )
        {
            xoops_cp_header();
            echo "<h4>" . _AM_SOCIALNET_POPCHAT_CONFIG . "</h4>";
            xoops_confirm( array( 'op' => 'delete', 'chatid' => $_GET['chatid'], 'ok' => 1 ), 'beginchat.php', _AM_SOCIALNET_POPCHAT_RUSUREDEL );
        }
        else
        {
            if ( empty( $_POST['chatid']) )
            {
                redirect_header( 'beginchat.php', 2, _AM_SOCIALNET_POPCHAT_ERROR_ADD_MARQUEE);
                exit();
            }
            $chatid=intval($_POST['chatid']);
            $marquee = new marquee($chatid);
           	$marquee->delete();
            redirect_header( 'beginchat.php', 1, _AM_SOCIALNET_POPCHAT_DBUPDATED );
            exit();
        }
        break;


	// Verification avant ajout
    case "verifytoadd":
		$myts =& MyTextSanitizer::getInstance();
		if ( isset($_POST['submit']) && $_POST['submit'] != "" )
		{
			if ( $content== '' )
			{
            	xoops_cp_header();
		    	echo "<table width='100%' border='0' cellspacing='1' class='outer'>\n";
				echo "<tr><td class=\"odd\">";
		    	echo "<a href='beginchat.php'><h4>"._AM_SOCIALNET_POPCHAT_CONFIG."</h4></a>";
				echo _AM_SOCIALNET_POPCHAT_ERROR_ADD_MARQUEE;
				echo"</td></tr></table>";
				xoops_cp_footer();
				exit();
			}
			$marquee = new marquee;
			$marquee->setUid($xoopsUser->getVar("uid"));
			$marquee->setdirection(intval($_POST['direction']));
			$marquee->setscrollamount(intval($_POST['scrollamount']));
			$marquee->setbehaviour(intval($_POST['behaviour']));
			$marquee->setbgcolor($myts->makeTareaData4Save($_POST['bgcolor']));
			$marquee->setalign(intval($_POST['align']));
			$marquee->setheight(intval($_POST['height']));
			$marquee->setwidth($myts->makeTareaData4Save($_POST['width']));
			$marquee->sethspace(intval($_POST['hspace']));
			$marquee->setscrolldelay(intval($_POST['scrolldelay']));
			$marquee->setstoponmouseover(intval($_POST['stoponmouseover']));
			$marquee->setloop(intval($_POST['loop']));
			$marquee->setvspace(intval($_POST['vspace']));
			$marquee->setcontent($myts->makeTareaData4Save($_POST['content']));
			if(!$marquee->store())
			{
				redirect_header("beginchat.php", 1,_AM_SOCIALNET_POPCHAT_ERROR_ADD_MARQUEE);
				exit();
			}
			redirect_header("./beginchat.php", 1, _AM_SOCIALNET_POPCHAT_ADDED_OK);
		}
        break;

	// Affichage du formulaire d'ajout
    case "addmarquee":
    	xoops_cp_header();
    	AddEditMarqueeForm(0, 'verifytoadd', _AM_SOCIALNET_POPCHAT_CONFIG, '', '','','','',0, 0,'',0,0,0,0,0, _AM_SOCIALNET_POPCHAT_ADDBUTTON);
        break;

	// Action par dñÇaut, lister les marquees
    case "default":
    default:
        xoops_cp_header();
		adminmenu(21);
        echo "<h4>" . _AM_SOCIALNET_POPCHAT_CONFIG . "</h4><br />\n";
        echo"<table width='100%' border='0' cellspacing='1' class='outer'>\n";
        echo "<tr><th align='center'>". _AM_SOCIALNET_POPCHAT_ID . "</th><th align='center'>" . _AM_SOCIALNET_POPCHAT_CONTENT . "</th><th align='center'>" . _AM_SOCIALNET_POPCHAT_BEHAVIOUR . "</th><th align='center'>" .  _AM_SOCIALNET_POPCHAT_STOP . "</th><th align='center'>" . _AM_SOCIALNET_POPCHAT_DIRECTION . "</th><th align='center'>" . _AM_SOCIALNET_POPCHAT_ACTION . "</th></tr>\n";
		$marquee= new marquee;
		$marqueearray= $marquee->getAllMarquees();
		$class = 'even';
		$baseurl=XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/admin/beginchat.php';
		if ( count( $marqueearray ) > 0 )
    	{
        	foreach( $marqueearray as $marquee)
        	{
				$action_edit="<a href='".$baseurl."?op=edit&chatid=".$marquee->chatid()."'><img src='../images/icons/edit.gif' />"._AM_SOCIALNET_POPCHAT_EDIT."</a>";
				$action_delete="<a href='".$baseurl."?op=delete&chatid=".$marquee->chatid()."'><img src='../images/icons/dele.gif' />"._AM_SOCIALNET_POPCHAT_DELETE."</a>";
				switch ($marquee->direction())
				{
					case 0:	// Right
						$direction=_AM_SOCIALNET_POPCHAT_DIRECTION1;
						break;
					case 1:	// Left
						$direction=_AM_SOCIALNET_POPCHAT_DIRECTION2;
						break;
					case 2:	// Up
						$direction=_AM_SOCIALNET_POPCHAT_DIRECTION3;
						break;
					case 3:	// Down
						$direction=_AM_SOCIALNET_POPCHAT_DIRECTION4;
						break;
				}
				switch ($marquee->behaviour())
				{
					case 0:	// scroll
						$behaviour=_AM_SOCIALNET_POPCHAT_BEHAVIOUR1;
						break;
					case 1:	// slide
						$behaviour=_AM_SOCIALNET_POPCHAT_BEHAVIOUR2;
						break;
					case 2:	// alternate
						$behaviour=_AM_SOCIALNET_POPCHAT_BEHAVIOUR3;
						break;
				}
                if($marquee->stoponmouseover()==0) {
                	$stop=_NO;
                } else {
                	$stop=_YES;
                }
				echo "<tr class='".$class."'><td align='center'>" . $marquee->chatid() . 
					"</td><td align='center'>" . xoops_substr($marquee->content(),0,60) . 
					"</td><td align='center'>" . $behaviour . "</td><td align='center'>" . $stop . 
					"</td><td align='center'>" . $direction . "</td><td align='center'>" . $action_edit . "&nbsp;-&nbsp;" . $action_delete . 
					"</td></tr>\n";
				$class = ($class == 'even') ? 'odd' : 'even';
        	}
        }

        echo"</table>";
        break;
}
echo "<br>";
echo "<br>";
echo "<div align='center' style='margin-top:10px'><a href='http://www.ipwgc.com/socialnet/'><img src='../images/socialnetLogo.png'></a><br /><img src='../images/menu/mailuser.gif'><a style='color: #029116; font-size:11px' href='feedback.php'>"._AM_SOCIALNET_FEEDBACK."</a> - <img src='../images/icons/mainvideo.gif'><a style='color: #FF0000; font-size:11px' href='http://www.ipwgc.com/socialnet/modules/socialnet/index.php' target='_blank'>"._AM_SOCIALNET_CHKVERSION."</a></div>";
xoops_cp_footer();
?>
