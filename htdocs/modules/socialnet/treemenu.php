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

include '../../mainfile.php';
$xoopsOption['template_main'] = 'socialnet_menutree.tpl.html';
include_once "header.php";
// *******************************************************************************
// **** Main
// *******************************************************************************


$tac = (isset($_GET['tac'])) ? $_GET['tac'] : 0;
$tac = (is_int($tac)) ? $tac : str_replace("_"," ", $tac);
if(!$tac){
    if ($xoopsModuleConfig['socialnet_conf_home_id']) {
    	$socialnet_classe = new socialnet_mpb_mpublish($xoopsModuleConfig['socialnet_conf_home_id']);
    }else{
        $socialnet_classe = new socialnet_mpb_mpublish();
        //$socialnet_classe->loadLast();
    }
}else{
    $socialnet_classe = new socialnet_mpb_mpublish(urldecode($tac));
}
if (!$socialnet_classe->getVar("mpb_10_id")) {
    redirect_header(XOOPS_URL, 2, _MD_SOCIALNET_404);
}else{
    $groups = (!empty($xoopsUser) && is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
    $gperm_handler =& xoops_gethandler('groupperm');
    if (!$gperm_handler->checkRight("socialnet_mpublish_acesso", $socialnet_classe->getVar("mpb_10_id"), $groups, $xoopsModule->getVar('mid'))) {
        redirect_header(XOOPS_URL, 3, _NOPERM);
        exit();
    }
    if ($xoopsModuleConfig['socialnet_conf_navigation']) {
        $xoopsTpl->assign("navigation", $socialnet_classe->geraNavigation());
    }else{
        $xoopsTpl->assign("navigation", "");
    }
    if($socialnet_classe->getVar("mpb_30_file") != "" && substr($socialnet_classe->getVar("mpb_30_file"), 0, 7) == "http://"){
        $content = '<iframe src ="'.$socialnet_classe->getVar("mpb_30_file").'" width="'.$xoopsModuleConfig['socialnet_conf_iframe_width'].'" height="'.$xoopsModuleConfig['socialnet_conf_iframe_height'].'" scrolling="auto" frameborder="0"></iframe>';
        $xoopsTpl->assign("content", $content);
    }elseif ($socialnet_classe->getVar("mpb_30_file") != "" && $socialnet_classe->getVar("mpb_35_content") == ""){
        $pageContent = SOCIALNET_HTML_PATH."/".$socialnet_classe->getVar("mpb_30_file");
        if(file_exists($pageContent)){
            ob_start();
            if(substr(strtolower($socialnet_classe->getVar("mpb_30_file")), -3) == "php"){
                include($pageContent);
            }else{
                readfile($pageContent);
            }
            $content = ob_get_contents();
            ob_end_clean();
            if (substr(strtolower($socialnet_classe->getVar("mpb_30_file")), -3) == "txt") {
                $content = nl2br($content);
            }
            $content = prepareContent($content);
            $xoopsTpl->assign("content", $content);
        }
    }else{
        $mpb_35_content = prepareContent($socialnet_classe->getVar("mpb_35_content", "n"));
        $xoopsTpl->assign("content", $mpb_35_content);
    }
    $xoopsTpl->assign('comments', $socialnet_classe->getVar("mpb_12_comments"));
    if($socialnet_classe->getVar("mpb_12_recommend") == 1){
        $xoopsTpl->assign('recommend', "<a href='".$socialnet_classe->pegaLink("treerecommend.php")."' title='"._MD_SOCIALNET_RECOMMEND."'><img src='".XOOPS_URL."/modules/socialnet/images/menu/people.gif' alt='"._MD_SOCIALNET_RECOMMEND."'></a> ");
    }else{
        $xoopsTpl->assign('recommend', "");
    }
    if ($socialnet_classe->getVar("mpb_12_print") == 1) {
        $xoopsTpl->assign('print', "<a href='".$socialnet_classe->pegaLink("treeprint.php")."' target='_blank'  title='"._MD_SOCIALNET_PRINT."'><img src='".XOOPS_URL."/modules/socialnet/images/icons/print.gif' alt='"._MD_SOCIALNET_PRINT."'></a>");
    }else{
        $xoopsTpl->assign('print', "");
    }
    if (!empty($xoopsUser) && $xoopsUser->isAdmin()) {
        $xoopsTpl->assign('infos', _MD_SOCIALNET_INFOPG);
        $xoopsTpl->assign('author', _MD_SOCIALNET_AUTHOR." <b>".XoopsUser::getUnameFromId($socialnet_classe->getVar("usr_10_uid"))."</b>");
        $xoopsTpl->assign('create', _MD_SOCIALNET_CREATED." <b>".date(_SHORTDATESTRING, $socialnet_classe->getVar("mpb_22_create"))."</b>");
        $xoopsTpl->assign('uptodate', _MD_SOCIALNET_UPDATE." <b>".date(_SHORTDATESTRING, $socialnet_classe->getVar("mpb_22_uptodate"))."</b>");
        $xoopsTpl->assign('counter', sprintf(_MD_SOCIALNET_CONTADOR, $socialnet_classe->getVar("mpb_10_counter")));
        $xoopsTpl->assign('zerar_cont', '<input style="font-size: 11px; border:2px solid #9C9C9C; background-color: #FFFFFF" name="limpacont" id="limpacont" value="'._MD_SOCIALNET_ZCONTADOR.'" onclick="document.location= \''.XOOPS_URL.'/modules/socialnet/admin/treemenu.php?op=limpacont&mpb_10_id='.$socialnet_classe->getVar('mpb_10_id').'\'" type="button">');
        $xoopsTpl->assign('edit_page', '<input style="font-size: 11px; border:2px solid #9C9C9C; background-color: #FFFFFF" name="editcont" id="editcont" value="'._MD_SOCIALNET_EDITPAGE.'" onclick="document.location= \''.XOOPS_URL.'/modules/socialnet/admin/treemenu.php?op=list_editar&mpb_10_id='.$socialnet_classe->getVar('mpb_10_id').'\'" type="button">');
        $xoopsTpl->assign('tools_image', "<a href='javascript:void(0)' title='"._MD_SOCIALNET_INFOPG."' onclick='document.getElementById(\"admin_page\").style.display=(document.getElementById(\"admin_page\").style.display)? \"\" : \"none\"'><img src='".XOOPS_URL."/modules/socialnet/images/topics/folder_locked_big.gif' alt='"._MD_SOCIALNET_INFOPG."'></a>");
        $xoopsTpl->assign('socialnet_isauthor', 1);
    }elseif (!empty($xoopsUser) && $xoopsUser->getVar('uid') == $socialnet_classe->getVar("usr_10_uid") && ($xoopsModuleConfig['socialnet_conf_canedit'] == 1 || $xoopsModuleConfig['socialnet_conf_cancreate'] == 1)){
        $xoopsTpl->assign('infos', _MD_SOCIALNET_INFOPG);
        $xoopsTpl->assign('author', _MD_SOCIALNET_AUTHOR." <b>".XoopsUser::getUnameFromId($socialnet_classe->getVar("usr_10_uid"))."</b>");
        $xoopsTpl->assign('create', _MD_SOCIALNET_CREATED." <b>".date(_SHORTDATESTRING, $socialnet_classe->getVar("mpb_22_create"))."</b>");
        $xoopsTpl->assign('uptodate', _MD_SOCIALNET_UPDATE." <b>".date(_SHORTDATESTRING, $socialnet_classe->getVar("mpb_22_uptodate"))."</b>");
        $xoopsTpl->assign('counter', sprintf(_MD_SOCIALNET_CONTADOR, $socialnet_classe->getVar("mpb_10_counter")));
        $xoopsTpl->assign('zerar_cont', '<input style="font-size: 11px; border:2px solid #9C9C9C; background-color: #FFFFFF" name="limpacont" id="limpacont" value="'._MD_SOCIALNET_ZCONTADOR.'" onclick="document.location= \''.XOOPS_URL.'/modules/socialnet/treeauthor.php?op=limpacont&mpb_10_id='.$socialnet_classe->getVar('mpb_10_id').'\'" type="button">');
        $xoopsTpl->assign('edit_page', (($xoopsModuleConfig['socialnet_conf_canedit']) ? '<input style="font-size: 11px; border:2px solid #9C9C9C; background-color: #FFFFFF" name="editcont" id="editcont" value="'._MD_SOCIALNET_EDITPAGE.'" onclick="document.location= \''.XOOPS_URL.'/modules/socialnet/treeauthor.php?op=editar&mpb_10_id='.$socialnet_classe->getVar('mpb_10_id').'\'" type="button"><br /><br />' : '').'<input style="font-size: 11px; border:2px solid #FF0000; background-color: #FFFFFF" name="mycont" id="mycont" value="'._MD_SOCIALNET_MYPAGES.'" onclick="document.location= \''.XOOPS_URL.'/modules/socialnet/treeauthor.php?op=list\'" type="button"> '.(($xoopsModuleConfig['socialnet_conf_cancreate']) ? ' <input style="font-size: 11px; border:2px solid #FF0000; background-color: #FFFFFF" name="newcont" id="newcont" value="'._MD_SOCIALNET_NEWPAGE.'" onclick="document.location= \''.XOOPS_URL.'/modules/socialnet/treeauthor.php?op=new&mpb_10_id='.$socialnet_classe->getVar('mpb_10_id').'\'" type="button">' : '' ).(($xoopsModuleConfig['socialnet_conf_candelete']) ? ' <input style="font-size: 11px; border:2px solid #FF0000; background-color: #FFFFFF" name="delcont" id="delcont" value="'._DELETE.'" onclick="document.location= \''.XOOPS_URL.'/modules/socialnet/treeauthor.php?op=delete&mpb_10_id='.$socialnet_classe->getVar('mpb_10_id').'\'" type="button">' : '' ));
        $xoopsTpl->assign('tools_image', "<a href='javascript:void(0)' title='"._MD_SOCIALNET_INFOPG."' onclick='document.getElementById(\"admin_page\").style.display=(document.getElementById(\"admin_page\").style.display)? \"\" : \"none\"'><img src='".XOOPS_URL."/modules/socialnet/images/topics/folder_locked_big.gif' alt='"._MD_SOCIALNET_INFOPG."'></a>");
        $xoopsTpl->assign('socialnet_isauthor', 1);
    }else{
        $xoopsTpl->assign('socialnet_isauthor', 0);
    }
    if ($xoopsModuleConfig['socialnet_conf_related'] && $socialnet_classe->getVar("mpb_10_idpai") != 0) {
        $rel_crit = new CriteriaCompo(new Criteria("mpb_10_idpai", $socialnet_classe->getVar("mpb_10_idpai")));
        $rel_crit->add(new Criteria("mpb_10_id", $socialnet_classe->getVar("mpb_10_id"), "<>"));
        $rel_crit->add(new Criteria("mpb_12_withoutlink", 0));
        $rel_crit2 = new CriteriaCompo(new Criteria("mpb_11_visible", 2));
        $rel_crit2->add(new Criteria("mpb_11_visible", 3), "OR");
        $rel_crit->add($rel_crit2);
        $rel_crit->setSort("mpb_10_order");
        $all_related = $socialnet_classe->PegaTudo($rel_crit);
        if ($all_related) {
            foreach ($all_related as $v) {
                $relateds = array();
                $relateds['title'] = $v->getVar("mpb_30_title");
                $relateds['link'] = $v->pegaLink();
                $xoopsTpl->append('relpages', $relateds);
            }
            $xoopsTpl->assign('relateds', 1);
            $xoopsTpl->assign('related_label', _MD_SOCIALNET_RELATED);
        }else{
            $xoopsTpl->assign('related', 0);
        }
    }else{
        $xoopsTpl->assign('related', 0);
    }
    $xoopsTpl->assign("xoops_pagetitle", $socialnet_classe->getVar("mpb_30_title"));
    $xoopsTpl->assign("mpb_30_title", $socialnet_classe->getVar("mpb_30_title"));
    $xoopsTpl->assign('mpversion', round($xoopsModule->getVar('version') / 100, 2));
    $socialnet_classe->updateCount();
}
include_once XOOPS_ROOT_PATH."/modules/socialnet/include/comment_view.php";


/**
* Adding to the module js and css of the lightbox and new ones
*/
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/socialnet.css');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/jquery.tabs.css');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/leftmenu.css');
// what browser they use if IE then add corrective script.
if(ereg('msie', strtolower($_SERVER['HTTP_USER_AGENT']))) {$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/jquery.tabs-ie.css');}

$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/jquery.lightbox-0.5.css');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jquery.js');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jquery.lightbox-0.5.js');
//$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/socialnet.js');

// SocialNetFaceStyle starts here
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/barfacestyle.css');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/socialnet/css/barface.stylesheet.css');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/barface.readyfunction.js');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jquery-1.3.2.min.js');
$xoTheme->addScript(XOOPS_URL.'/modules/socialnet/js/jixedbar-0.0.3-dev.js');
// SocialNetFaceStyle End here

//navbar
$xoopsTpl->assign('module_name',$xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection',_MD_SOCIALNET_MYPROFILE);
$xoopsTpl->assign('section_name',_MD_SOCIALNET_MYPROFILE);
$xoopsTpl->assign('lang_home',_MD_SOCIALNET_HOME);
$xoopsTpl->assign('lang_photos',_MD_SOCIALNET_PHOTOS);
$xoopsTpl->assign('lang_friends',_MD_SOCIALNET_FRIENDS);
$xoopsTpl->assign('lang_audio',_MD_SOCIALNET_AUDIOS);
$xoopsTpl->assign('lang_videos',_MD_SOCIALNET_VIDEOS);
$xoopsTpl->assign('lang_scrapbook',_MD_SOCIALNET_SCRAPBOOK);
$xoopsTpl->assign('lang_profile',_MD_SOCIALNET_PROFILE);
$xoopsTpl->assign('lang_groups',_MD_SOCIALNET_GROUPS);
$xoopsTpl->assign('lang_configs',_MD_SOCIALNET_CONFIGSTITLE);
$xoopsTpl->assign('lang_search', _MD_SOCIALNET_SEARCH);
$xoopsTpl->assign('lang_membership', _MD_SOCIALNET_MEMBERSHIP);
$xoopsTpl->assign('lang_pagelist', _MD_SOCIALNET_PAGELIST);
$xoopsTpl->assign('lang_publish', _MD_SOCIALNET_PUBLISH);
$xoopsTpl->assign('lang_your_page', _MD_SOCIALNET_YOUR_PAGE);
$xoopsTpl->assign('lang_contactus', _MD_SOCIALNET_CONTACTUS);
$xoopsTpl->assign('lang_articles', _MD_SOCIAL_ARTICLES);
$xoopsTpl->assign('lang_popchatmenu', _MD_SOCIALNET_POPCHATMENU);
$xoopsTpl->assign('lang_forum', _MD_SOCIALNET_FORUM_FORUM);

include("../../footer.php");
?>