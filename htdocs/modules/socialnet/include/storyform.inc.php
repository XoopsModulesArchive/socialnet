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

if (file_exists(XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/calendar.php')) {
	include_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/calendar.php';
} else {
	include_once XOOPS_ROOT_PATH.'/language/english/calendar.php';
}
//Include xoopsformloader using CBB Way
if(file_exists(XOOPS_ROOT_PATH."/Frameworks/xoops22/class/xoopsformloader.php"))
{
	if(!@include_once XOOPS_ROOT_PATH."/Frameworks/xoops22/class/xoopsformloader.php"){
		include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
	}
}else
{
	include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
}

//Added socialnet 2.50 for cookies manangement
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/vars.inc.php";
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/functions.inc.php";

include_once(XOOPS_ROOT_PATH."/class/tree.php");

$sform = new XoopsThemeForm(_MD_SOCIAL_NW_SUBMITNEWS, "storyform", XOOPS_URL.'/modules/socialnet/submit_news.php');
$sform->setExtra('enctype="multipart/form-data"');
$sform->addElement(new XoopsFormText(_MD_SOCIAL_NW_TITLE, 'title', 50, 80, $story->title('Edit')), true);

//Todo: Change to only display topics, which a user has submit privileges for
if (!isset($xt)) {
    $xt = new SocialnetTopic($xoopsDB->prefix("socialnet_topics"));
}
$alltopics = $xt->getAllTopics(true, "socialnet_submit");
if (count($alltopics) == 0) {
    redirect_header('news.php', 3, _MD_SOCIAL_NW_NOTOPICS);
}
$topic_obj_tree = new XoopsObjectTree($alltopics, 'topic_id', 'topic_pid');
$sform->addElement(new XoopsFormLabel(_MD_SOCIAL_NW_TOPIC, $topic_obj_tree->makeSelBox('topic_id', 'topic_title', '--', $story->topicid())));

//If admin - show admin form
//TODO: Change to "If submit privilege"
if ($approveprivilege) {
    //Show topic image?
    $topic_img = new XoopsFormRadio(_AM_SOCIALNET_TOPICDISPLAY, 'topicdisplay', $story->topicdisplay());
    $topic_img->addOption(0, _AM_SOCIALNET_NONEIMAGE);
    $topic_img->addOption(1, _AM_SOCIALNET_TOPIC);
    $topic_img->addOption(2, _AM_SOCIALNET_AUTHOR);
    $sform->addElement($topic_img);
    //Select image position
    $posselect = new XoopsFormSelect(_AM_SOCIALNET_TOPICALIGN, 'topicalign', $story->topicalign());
    $posselect->addOption('R', _AM_SOCIALNET_RIGHT);
    $posselect->addOption('L', _AM_SOCIALNET_LEFT);
    $sform->addElement($posselect);
    //Publish in home?
    //TODO: Check that pubinhome is 0 = no and 1 = yes (currently vice versa)
    $sform->addElement(new XoopsFormRadioYN(_AM_SOCIALNET_PUBINHOME, 'ihome', $story->ihome(), _NO, _YES));
    $audience_handler =& xoops_getmodulehandler('audience', 'socialnet');
    $audiences = $audience_handler->getAllAudiences();
    $audience_select = new XoopsFormSelect(_MD_SOCIAL_NW_AUDIENCE, 'audience', $story->audienceid);
    if (is_array($audiences) && count($audiences) > 0) {
        foreach ($audiences as $aid => $audience) {
            $audience_select->addOption($aid, $audience->getVar('audience'));
        }
    }
    $sform->addElement($audience_select);
}

$myts =& MyTextSanitizer::getInstance();
/*
if(file_exists(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/".$xoopsConfig['language'].".php")) 
include_once ''.XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/".$xoopsConfig['language'].".php";
else include_once ''.XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/english.php"; 
*/

//Added socialnet Enable use selection Editor
if($xoopsModuleConfig['editor_userchoice']==TRUE)
{
if(isset($_REQUEST['seditor'])) $editor= $_REQUEST['seditor'];
if(!empty($editor)){
	socialnet_setcookie("cookie_editor",$editor);
}elseif(!$editor = socialnet_getcookie("cookie_editor")){
	if(empty($editor)){
		$editor =$xoopsModuleConfig['editor'];
	}
}
$editor_select=@ $xoopsModuleConfig['editor_choice'];
$sform->addElement(new XoopsFormSelectEditor($sform, "seditor", $editor, $story->nohtml(),$editor_select));
}else
{
	$editor=$xoopsModuleConfig['editor'];
}

//Change multiple WYSIWYG using CBB Way
$editor_configs = array();
//required configs
$editor_configs['caption'] = _MD_SOCIAL_NW_THESCOOP;
$editor_configs['name'] ='hometext';
$editor_configs['value'] = $myts->htmlSpecialChars($story->hometext);
//optional configs
$editor_configs['rows'] = 25; // default value = 5
$editor_configs['cols'] = 60; // default value = 50
$editor_configs['width'] = '100%'; // default value = 100%
$editor_configs['height'] = '400px'; // default value = 400px

$sform->addElement(new XoopsFormEditor($editor_configs['caption'], $editor , $editor_configs, $story->nohtml(), null));
$sform->addElement( (new XoopsFormLabel('','* '._AM_SOCIALNET_MULTIPLE_PAGE_GUIDE)),false );

$editor_configs = array();
//required configs
$editor_configs['caption'] = _AM_SOCIALNET_EXTEXT;
$editor_configs['name'] ='bodytext';
$editor_configs['value'] = $myts->htmlSpecialChars($story->bodytext);
//optional configs
$editor_configs['rows'] = 25; // default value = 5
$editor_configs['cols'] = 60; // default value = 50
$editor_configs['width'] = '100%'; // default value = 100%
$editor_configs['height'] = '400px'; // default value = 400px

$sform->addElement(new XoopsFormEditor($editor_configs['caption'], $editor , $editor_configs, $story->nohtml(), null));
$sform->addElement( (new XoopsFormLabel('','* '._AM_SOCIALNET_MULTIPLE_PAGE_GUIDE)),false );

$sform->addElement(new XoopsFormTextArea(_MD_SOCIAL_NW_BANNER, 'banner', $myts->htmlSpecialChars($story->banner)));

if ($edit && (!isset($_GET['approve']))) {
    $change_radio = new XoopsFormRadio(_MD_SOCIAL_NW_MAJOR, 'change', $story->change);
    $change_radio->addOption(0, _MD_SOCIAL_NW_NOVERSIONCHANGE);
    $change_radio->addOption(1, _MD_SOCIAL_NW_VERSION);
    $change_radio->addOption(2, _MD_SOCIAL_NW_REVISION);
    $change_radio->addOption(3, _MD_SOCIAL_NW_MINOR);
    $change_radio->addOption(4, _MD_SOCIAL_NW_AUTO);
    $change_radio->setDescription(_MD_SOCIAL_NW_VERSIONDESC);
    $change_radio->setValue(4);
    $sform->addElement($change_radio);
    $sform->addElement(new XoopsFormRadioYN(_MD_SOCIAL_NW_SWITCHAUTHOR." (".$story->uname.")", 'newauthor', 0));
}

// Manage upload(s)
$allowupload = false;
switch ($xoopsModuleConfig['uploadgroups']) 
{ 
	case 1: //Submitters and Approvers        
		$allowupload = true;        
		break;    
	case 2: //Approvers only        
		$allowupload = $approveprivilege ? true : false;
		break;    
	case 3: //Upload Disabled
		$allowupload = false;        
		break;
}

if($allowupload) 
{
	if($edit) {
		$sfiles = new sFiles();	
		$filesarr=Array();
		$filesarr=$sfiles->getAllbyStory($story->storyid());
		if(count($filesarr)>0) {
			$upl_tray = new XoopsFormElementTray(_AM_SOCIALNET_UPLOAD_ATTACHFILE,'<br />');
			$upl_checkbox=new XoopsFormCheckBox('', 'delupload[]');
			
			foreach ($filesarr as $onefile) 
			{
				$link=sprintf("<a href='%s/%s' target='_blank'>%s</a>\n",XOOPS_UPLOAD_URL,$onefile->getDownloadname('S'),$onefile->getFileRealName('S'));
				$upl_checkbox->addOption($onefile->getFileid(),$link);
			}			
			$upl_tray->addElement($upl_checkbox,false);
			$dellabel=new XoopsFormLabel(_AM_SOCIALNET_DELETE_SELFILES,'');
			$upl_tray->addElement($dellabel,false);			
			$sform->addElement($upl_tray);
		}
	}
	$sform->addElement(new XoopsFormFile(_AM_SOCIALNET_SELFILE, 'attachedfile', $xoopsModuleConfig['maxuploadsize']), false);
}


$option_tray = new XoopsFormElementTray(_OPTIONS,'<br />');
//Set date of publish/expiration
if ($approveprivilege) {
    $approve_checkbox = new XoopsFormCheckBox('', 'approve', $story->approved);
    $approve_checkbox->addOption(1, _AM_SOCIALNET_APPROVE);
    $option_tray->addElement($approve_checkbox);

    $published_checkbox = new XoopsFormCheckBox('', 'autodate',$story->published()?1:0);
    $published_checkbox->addOption(1, _AM_SOCIALNET_SETDATETIME);
    $option_tray->addElement($published_checkbox);

    $option_tray->addElement(new XoopsFormDateTime(_AM_SOCIALNET_SETDATETIME, 'publish_date', 15, $story->published()));

    $expired_checkbox = new XoopsFormCheckBox('', 'autoexpdate',$story->expired()?1:0);
    $expired_checkbox->addOption(1, _AM_SOCIALNET_SETEXPDATETIME);
    $option_tray->addElement($expired_checkbox);

    $option_tray->addElement(new XoopsFormDateTime(_AM_SOCIALNET_SETEXPDATETIME, 'expiry_date', 15, $story->expired()));
}

if (is_object($xoopsUser)) {
	$notify_checkbox = new XoopsFormCheckBox('', 'notifypub', $story->notifypub());
	$notify_checkbox->addOption(1, _MD_SOCIAL_NW_NOTIFYPUBLISH);
	$option_tray->addElement($notify_checkbox);
	if ($xoopsUser->isAdmin($xoopsModule->getVar('mid'))) {
		$nohtml_checkbox = new XoopsFormCheckBox('', 'nohtml', $story->nohtml());
		$nohtml_checkbox->addOption(1, _DISABLEHTML);
		$option_tray->addElement($nohtml_checkbox);
	}
}
$smiley_checkbox = new XoopsFormCheckBox('', 'nosmiley', $story->nosmiley());
$smiley_checkbox->addOption(1, _DISABLESMILEY);
$option_tray->addElement($smiley_checkbox);


$sform->addElement($option_tray);

//TODO: Approve checkbox + "Move to top" if editing + Edit indicator

//Submit buttons
$button_tray = new XoopsFormElementTray('' ,'');
$preview_btn = new XoopsFormButton('', 'preview', _PREVIEW, 'submit');
$preview_btn->setExtra('accesskey="p"');
$button_tray->addElement($preview_btn);
$submit_btn = new XoopsFormButton('', 'post', _MD_SOCIAL_NW_POST, 'submit');
$submit_btn->setExtra('accesskey="s"');
$button_tray->addElement($submit_btn);
$sform->addElement($button_tray);

//Hidden variables
if(isset($_REQUEST['op']))
{
	$op_hidden = new XoopsFormHidden('op', $_REQUEST['op']);
	$sform->addElement($op_hidden);
}
if($story->storyid() > 0){
    $storyid_hidden = new XoopsFormHidden('storyid', $story->storyid());
    $sform->addElement($storyid_hidden);
}
if (!($story->type())) {
    if ($approveprivilege) {
        $type = "admin";
    }
    else {
        $type = "user";
    }
}
$type_hidden = new XoopsFormHidden('type', $type);
$sform->addElement($type_hidden);
$sform->display();
?>