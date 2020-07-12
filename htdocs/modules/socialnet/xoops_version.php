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

include_once XOOPS_ROOT_PATH."/modules/socialnet/include/functionspot.inc.php";

$modversion['name'] = _MI_SOCIALNET_NAME_MOD;
$modversion['version'] = '1.0';
$modversion['description'] = _MI_SOCIALNET_MODULEDESC;
$modversion['credits'] = 'Developped by IPWGC http://www.ipwgc.com ';
$modversion['author'] = 'David Yanez Osses';
//$modversion['help'] = '';
$modversion['license'] = _MI_SOCIALNET_LICENSE;
$modversion['official'] = 1;
$modversion['image'] = 'images/socialnetLogo.png';
$modversion['dirname'] = 'socialnet';
$modversion['onInstall'] = 'include/install.php';

//ABOUT SECTION
$modversion['developer_website_url'] = 'http://www.ipwgc.com/';
$modversion['developer_website_name'] = 'International Prayer Warriors';
$modversion['developer_email'] = 'support@ipwgc.com';
$modversion['status_version'] = '1.0';
$modversion['status'] = 'RC1';
$modversion['date'] = '2009-10-01';

$modversion['people']['developers'][] = 'David Yanez Osses (Dev)';
$modversion['people']['testers'][] = 'Alianza AMIC (alianzadeministerios.cl)';
$modversion['people']['testers'][] = 'Oracion (ipwgc.com/espanol)';
$modversion['people']['translators'][] = 'David Yanez Osses';

$modversion['demo_site_url'] = 'http://www.ipwgc.com/socialnet/';
$modversion['demo_site_name'] = 'IPWGC.com';
$modversion['support_site_url'] = 'http://www.ipwgc.com/socialnet/';
$modversion['support_site_name'] = 'IPWGC Support Forums';
$modversion['submit_bug'] = 'http://www.ipwgc.com/socialnet/';
$modversion['submit_feature'] = 'http://www.ipwgc.com/socialnet/';
//$modversion['author_word'] = '';
$modversion['warning'] = _MI_WARNING;

// Admin section
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';


// BEGIN MY SQL TABLES
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql file
$modversion['tables'][0] = 'socialnet_images';
$modversion['tables'][1] = 'socialnet_friendship';
$modversion['tables'][2] = 'socialnet_visitors';
$modversion['tables'][3] = 'socialnet_youtube';
$modversion['tables'][4] = 'socialnet_friendpetition';
$modversion['tables'][5] = 'socialnet_groups';
$modversion['tables'][6] = 'socialnet_relgroupuser';
$modversion['tables'][7] = 'socialnet_scraps';
$modversion['tables'][8] = 'socialnet_configs';
$modversion['tables'][9] = 'socialnet_suspensions';
$modversion['tables'][10] = 'socialnet_audio';
$modversion['tables'][11] = 'socialnet_userpage';
$modversion['tables'][12] = 'socialnet_article';
$modversion['tables'][13] = 'socialnet_topics';
$modversion['tables'][14] = 'socialnet_newsfiles';
$modversion['tables'][15] = 'socialnet_newslink';
$modversion['tables'][16] = 'socialnet_text';
$modversion['tables'][17] = 'socialnet_newsrating';
$modversion['tables'][18] = 'socialnet_newsaudience';
$modversion['tables'][19] = 'socialnet_newsspotlight';
$modversion['tables'][20] = 'socialnet_note';
$modversion['tables'][21] = 'socialnet_languages';
$modversion['tables'][22] = 'socialnet_chatmarquee';
$modversion['tables'][23] = 'socialnet_chatmessage';
$modversion['tables'][24] = 'socialnet_chatmember';
$modversion['tables'][25] = 'socialnet_birthday';
$modversion['tables'][26] = 'socialnet_buddyfriends';
$modversion['tables'][27] = 'socialnet_interestfriends';
// NOTE:    Tables 28 to 41 created by the sql file without prefix, don\'t change.
$modversion['tables'][28] = _MI_SOCIALNET_TABLESECSECTION;
$modversion['tables'][29] = _MI_SOCIALNET_TABLESPOTIMAGES;
$modversion['tables'][30] = _MI_SOCIALNET_TABLEPUBLISH;
$modversion['tables'][31] = _MI_SOCIALNET_TABLEFILES;
$modversion['tables'][32] = _MI_SOCIALNET_TABLEMEDIA;
$modversion['tables'][33] = _MI_SOCIALNET_TABLECONTENTS;
// FORUM 
$modversion['tables'][34] = _MI_SOCIALNET_TABLEFORUMCATEGORIES;
$modversion['tables'][35] = _MI_SOCIALNET_TABLEFORUMACCESS;
$modversion['tables'][36] = _MI_SOCIALNET_TABLEFORUMMODS;
$modversion['tables'][37] = _MI_SOCIALNET_TABLEFORUMS;
$modversion['tables'][38] = _MI_SOCIALNET_TABLEFORUMPOSTS;
$modversion['tables'][39] = _MI_SOCIALNET_TABLEFORUMSPOSTSTEXT;
$modversion['tables'][40] = _MI_SOCIALNET_TABLEFORUMTOPICS;
$modversion['tables'][41] = _MI_SOCIALNET_TABLEFORUMFILES;
// END TABLE CREATED

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'socialnet_search';
$modversion['search']['file'] = 'include/searchpage.php';
$modversion['search']['func'] = 'socialnet_searchpage';
$modversion['search']['file'] = 'include/searchnews.inc.php';
$modversion['search']['func'] = 'socialnet_searchnews';
$modversion['search']['file'] = 'include/searchtree.inc.php';
$modversion['search']['func'] = 'socialnet_mpublish_busca';
$modversion['search']['file'] = 'include/forumsearch.php';
$modversion['search']['func'] = 'socialnet_forumsearch';

// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['pageName'] = 'group.php';
$modversion['comments']['itemName'] = 'group_id';
$modversion['comments']['pageName'] = 'pageuser.php';
$modversion['comments']['itemName'] = 'page_id';
$modversion['comments']['pageName'] = 'newsarticle.php';
$modversion['comments']['itemName'] = 'storyid';
$modversion['comments']['pageName'] = 'treemenu.php';
$modversion['comments']['itemName'] = 'tac';

// Comment callback functions NEWS
$modversion['comments']['callbackFile'] = 'include/comment_functions.php';
$modversion['comments']['callback']['approve'] = 'socialnet_com_approve';
$modversion['comments']['callback']['update'] = 'socialnet_com_update';

// Smarty
$modversion['use_smarty'] = 1;

//MAIN MENU
$modversion['hasMain'] = 1;

//BEGIN SUB MENU
global $xoopsModule;
if (isset($xoopsModule) && $xoopsModule->getVar('dirname') == $modversion['dirname']) {
    global $xoopsUser;
    if (is_object($xoopsUser)) {
        $groups = $xoopsUser->getGroups();
    } else {
        $groups = XOOPS_GROUP_ANONYMOUS;
    }
    $gperm_handler =& xoops_gethandler('groupperm');
    if ($gperm_handler->checkRight("socialnet_submit", 0, $groups, $xoopsModule->getVar('mid'))) {
        $modversion['sub'][3]['name'] = _MI_SOCIALNET_MENU_SUBMIT;
        $modversion['sub'][3]['url'] = 'submit_news.php';
    }
}

$modversion['sub'][1]['name'] = _MI_SOCIALNET_MENU_MYPROFILE;
$modversion['sub'][1]['url'] = 'index.php';
$modversion['sub'][2]['name'] = _MI_SOCIALNET_MENU_NEWS;
$modversion['sub'][2]['url'] = 'news.php';
// See above sub menu number 3
$modversion['sub'][4]['name'] = _MI_SOCIALNET_MENU_ARCHIVE;
$modversion['sub'][4]['url'] = 'newsarchive.php';
$modversion['sub'][5]['name'] = _MI_SOCIALNET_MENU_MEMBERSHIP;
$modversion['sub'][5]['url'] = 'membership.php';

global $xoopsModule;
if (is_object($xoopsModule) && $xoopsModule->dirname() == $modversion['dirname']) {
  $mod_handler =& xoops_gethandler('module');
  $mod_socialnet  =& $mod_handler->getByDirname('socialnet');
  $conf_handler =& xoops_gethandler('config');
  $moduleConfig   =& $conf_handler->getConfigsByCat(0, $mod_socialnet->getVar('mid'));


  if ($moduleConfig['enable_scraps']==1){ 
    $modversion['sub'][6]['name'] = _MI_SOCIALNET_MENU_MYSCRAPS;
    $modversion['sub'][6]['url'] = 'scrapbook.php';
  }
  if ($moduleConfig['enable_pictures']==1){
    $modversion['sub'][7]['name'] = _MI_SOCIALNET_MENU_MYPICTURES;
    $modversion['sub'][7]['url'] = 'album.php';
  }
  if ($moduleConfig['enable_audio']==1){
    $modversion['sub'][8]['name'] = _MI_SOCIALNET_MENU_MYAUDIOS;
    $modversion['sub'][8]['url'] = 'audio.php';
  }
  if ($moduleConfig['enable_videos']==1){ 
    $modversion['sub'][9]['name'] = _MI_SOCIALNET_MENU_MYVIDEOS;
    $modversion['sub'][9]['url'] = 'youtube.php';
  }
  if ($moduleConfig['enable_friends']==1){ 
    $modversion['sub'][10]['name'] = _MI_SOCIALNET_MENU_MYFRIENDS;
    $modversion['sub'][10]['url'] = 'friends.php';
  }
  if ($moduleConfig['enable_groups']==1){ 
    $modversion['sub'][11]['name'] = _MI_SOCIALNET_MENU_MYGROUPS;
    $modversion['sub'][11]['url'] = 'groups.php';
  }
}
$modversion['sub'][12]['name'] = _MI_SOCIALNET_MENU_MYCONFIGS;
$modversion['sub'][12]['url'] = 'configs.php';
$modversion['sub'][13]['name'] = _MI_SOCIALNET_MENU_PAGELIST;
$modversion['sub'][13]['url'] = 'pagelist.php';
$modversion['sub'][14]['name'] = _MI_SOCIALNET_MENU_CONTACTUS;
$modversion['sub'][14]['url'] = 'contactus.php';
$modversion['sub'][15]['name'] = _MI_SOCIALNET_MENU_SEARCH;
$modversion['sub'][15]['url'] = 'searchmembers.php';
$modversion['sub'][16]['name'] = _MI_SOCIALNET_SPOT_IMAGES;
$modversion['sub'][16]['url'] = 'imagespot.php';
$modversion['sub'][17]['name'] = _MI_SOCIALNET_MENU_CHAT;
$modversion['sub'][17]['url'] = 'chatbegin.php';
$modversion['sub'][18]['name'] = _MI_SOCIALNET_SMNAME1;
$modversion['sub'][18]['url'] = 'forumsearch.php';
$modversion['sub'][19]['name'] 	= _MI_SOCIALNET_MENU_FAVORITES;
$modversion['sub'][19]['url'] 	= 'myfavorites.php';
$modversion['sub'][20]['name']	= _MI_SOCIALNET_MENU_ADMIRERS;
$modversion['sub'][20]['url'] 	= 'myfavorites.php?type=admirers';
// END SUB MENU

// BEGIN CONFIGURATION
$i=1;
$i++;
$modversion['config'][$i]['name'] = 'welcome';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_WELCOME_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_WELCOME_DESC';
$modversion['config'][$i]['default'] = 0;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'enable_pictures';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_ENABLEPICT_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_ENABLEPICT_DESC';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'nb_pict';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_NUMBPICT_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_NUMBPICT_DESC';
$modversion['config'][$i]['default'] = 50;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'path_upload';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_PATHUPLOAD_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_PATHUPLOAD_DESC';
$modversion['config'][$i]['default'] = XOOPS_ROOT_PATH.'/uploads/socialnet/';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$i++;
$modversion['config'][$i]['name'] = 'link_path_upload';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_LINKPATHUPLOAD_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_LINKPATHUPLOAD_DESC';
$modversion['config'][$i]['default'] = XOOPS_UPLOAD_URL.'/socialnet/';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$i++;
$modversion['config'][$i]['name'] = 'thumb_width';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_THUMW_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_THUMBW_DESC';
$modversion['config'][$i]['default'] = 125;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'thumb_height';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_THUMBH_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_THUMBH_DESC';
$modversion['config'][$i]['default'] = 175;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'resized_width';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_RESIZEDW_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_RESIZEDW_DESC';
$modversion['config'][$i]['default'] = 650;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'resized_height';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_RESIZEDH_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_RESIZEDH_DESC';
$modversion['config'][$i]['default'] = 450;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'max_original_width';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_ORIGINALW_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_ORIGINALW_DESC';
$modversion['config'][$i]['default'] = 2048;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'max_original_height';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_ORIGINALH_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_ORIGINALH_DESC';
$modversion['config'][$i]['default'] = 1600;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'picturesperpage';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_PICTURESPERPAGE_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_PICTURESPERPAGE_DESC';
$modversion['config'][$i]['default'] = 6;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'physical_delete';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_DELETEPHYSICAL_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_DELETEPHYSICAL_DESC';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'images_order';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_IMGORDER_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_IMGORDER_DESC';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'enable_friends';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_ENABLEFRIENDS_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_ENABLEFRIENDS_DESC';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'friendsperpage';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_FRIENDSPERPAGE_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_FRIENDSPERPAGE_DESC';
$modversion['config'][$i]['default'] = 6;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'enable_audio';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_ENABLEAUDIO_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_ENABLEAUDIO_DESC';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'nb_audio';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_NUMBAUDIO_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_NUMBAUDIO_DESC';
$modversion['config'][$i]['default'] = 50;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'audiosperpage';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_AUDIOSPERPAGE_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_AUDIOSPERPAGE_DESC';
$modversion['config'][$i]['default'] = 10;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'maxfilesize';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_MAXFILEBYTES_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_MAXFILEBYTES_DESC';
$modversion['config'][$i]['default'] = 6000000;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'enable_videos';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_ENABLEVIDEOS_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_ENABLEVIDEOS_DESC';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'videosperpage';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_VIDEOSPERPAGE_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_VIDEOSPERPAGE_DESC';
$modversion['config'][$i]['default'] = 6;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'width_tube';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_TUBEW_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_TUBEW_DESC';
$modversion['config'][$i]['default'] = 450;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'height_tube';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_TUBEH_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_TUBEH_DESC';
$modversion['config'][$i]['default'] = 350;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'width_maintube';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_MAINTUBEW_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_MAINTUBEW_DESC';
$modversion['config'][$i]['default'] = 250;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'height_maintube';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_MAINTUBEH_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_MAINTUBEH_DESC';
$modversion['config'][$i]['default'] = 210;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'enable_groups';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_ENABLEGROUPS_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_ENABLEGROUPS_DESC';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'groupsperpage';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_GROUPSPERPAGE_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_GROUPSPERPAGE_DESC';
$modversion['config'][$i]['default'] = 6;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'enable_scraps';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_ENABLESCRAPS_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_ENABLESCRAPS_DESC';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'scrapsperpage';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_SCRAPSPERPAGE_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_SCRAPSPERPAGE_DESC';
$modversion['config'][$i]['default'] = 20;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
// CONFIGURATION FOR MEMBERSHIP
$modversion['config'][$i]['name'] = 'membersperpage';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_MPAGE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_MPAGE_DSC';
$modversion['config'][$i]['default'] = 20;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'defaultavatar';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_DAVATAR';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_DAVATAR_DSC';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
// CONFIGURATION FOR USERPAGE
$modversion['config'][$i]['name'] = 'allowhtml';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_OPT0';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_OPT0_DSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
//Allow RSS Feeds ?
$modversion['config'][$i]['name'] = 'allowrss';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_OPT1';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_OPT1_DSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
//Date's format. If you don't specify anything then the default date's format will be used
$modversion['config'][$i]['name'] = 'dateformat';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_OPT3';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_OPT3_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';
$i++;
//Number of characters to use in the RSS feed
$modversion['config'][$i]['name'] = 'rsslength';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_OPT4';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_OPT4_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 200;
$i++;
//Number of lines per page
$modversion['config'][$i]['name'] = 'linesperpage';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_OPT5';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_OPT5_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;
$i++;
//Editor to use
$modversion['config'][$i]['name'] = 'usekiovi';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_OPT6';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_OPT6_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['options'] = array( _MI_SOCIALNET_FORM_DHTML=>'dhtml', _MI_SOCIALNET_FORM_COMPACT=>'textarea', _MI_SOCIALNET_FORM_SPAW=>'spaw', _MI_SOCIALNET_FORM_HTMLAREA=>'htmlarea', _MI_SOCIALNET_FORM_KOIVI=>'koivi', _MI_SOCIALNET_FORM_FCK=>'fck', _MI_SOCIALNET_FORM_TINYEDITOR=>'tinyeditor');
$modversion['config'][$i]['default'] = 'dhtml';
$i++;
//Allow html ?
$modversion['config'][$i]['name'] = 'url_rewriting';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_URL_REWRITING';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
// BEGIN CONFIG NEWS
$modversion['config'][$i]['name'] = 'storyhome';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_STORYHOME';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_STORYHOMEDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;
$modversion['config'][$i]['options'] = array('1' => 1, '5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30);
$i++;
$modversion['config'][$i]['name'] = 'storycountadmin';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_STORYCOUNTADMIN';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_STORYCOUNTADMIN_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;
$modversion['config'][$i]['options'] = array('1' => 1, '2' => 2, '4' => 4, '5' => 5, '6' => 6, '8' => 8, '9' => 9, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '35' => 35, '40' => 40);
$i++;
$modversion['config'][$i]['name'] = 'storyhome_topic';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_STORYCOUNTTOPIC';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_STORYCOUNTTOPIC_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;
$modversion['config'][$i]['options'] = array('1' => 1, '2' => 2, '4' => 4, '5' => 5, '6' => 6, '8' => 8, '9' => 9, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '35' => 35, '40' => 40);
$i++;
$modversion['config'][$i]['name'] = 'max_items';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_MAXITEMS';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_MAXITEMDESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 30;
$i++;
$modversion['config'][$i]['name'] = 'spotlight_art_num';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_SPOTLIGHT_ITEMS';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_SPOTLIGHT_ITEMDESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;
$modversion['config'][$i]['options'] = array('1' => 1, '5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50, '100' => 100, '500' => 500);
$i++;
$modversion['config'][$i]['name'] = 'displaynav';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_DISPLAYNAV';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_DISPLAYNAVDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'autoapprove';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_AUTOAPPROVE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_AUTOAPPROVEDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'uploadgroups';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_UPLOADGROUPS';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_UPLOADGROUPS_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 2;
$modversion['config'][$i]['options'] = array('_MI_SOCIALNET_UPLOAD_GROUP1' => 1, '_MI_SOCIALNET_UPLOAD_GROUP2' => 2, '_MI_SOCIALNET_UPLOAD_GROUP3' => 3);
$i++;
$modversion['config'][$i]['name'] = 'maxuploadsize';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_UPLOADFILESIZE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_UPLOADFILESIZE_DESC';
$modversion['config'][$i]['formtype'] = 'texbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1048576;
$i++;
//I ADD THIS SECTION TO FIXED THE EDITOR NEWS CONFLICT
$modversion['config'][$i]['name'] = 'editor';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_EDITOR';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_EDITOR_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 0;
$modversion['config'][$i]['options'] = array('_MI_SOCIALNET_EDITOR_DEFAULT' => 'textarea', '_MI_SOCIALNET_EDITOR_DHTML' => 'dhtmlext', '_MI_SOCIALNET_EDITOR_HTMLAREA' => 'dhtmltextarea','_MI_SOCIALNET_EDITOR_FCK' => 'FCKeditor','_MI_SOCIALNET_EDITOR_KOIVI' => 'koivi', '_MI_SOCIALNET_EDITOR_TINYMCE' => 'tinymce');
$i++;
$modversion['config'][$i]['name'] = 'editor_userchoice';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_EDITOR_USER_CHOICE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_EDITOR_USER_CHOICE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'editor_choice';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_EDITOR_CHOICE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_EDITOR_CHOICE_DESC';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['default'] = array('_MI_SOCIALNET_EDITOR_DEFAULT' => 'textarea', '_MI_SOCIALNET_EDITOR_DHTML' => 'dhtmlext', '_MI_SOCIALNET_EDITOR_HTMLAREA' => 'dhtmltextarea','_MI_SOCIALNET_EDITOR_FCK' => 'FCKeditor','_MI_SOCIALNET_EDITOR_KOIVI' => 'koivi', '_MI_SOCIALNET_EDITOR_TINYMCE' => 'tinymce');
$modversion['config'][$i]['options'] = array('_MI_SOCIALNET_EDITOR_DEFAULT' => 'textarea', '_MI_SOCIALNET_EDITOR_DHTML' => 'dhtmlext', '_MI_SOCIALNET_EDITOR_HTMLAREA' => 'dhtmltextarea','_MI_SOCIALNET_EDITOR_FCK' => 'FCKeditor','_MI_SOCIALNET_EDITOR_KOIVI' => 'koivi', '_MI_SOCIALNET_EDITOR_TINYMCE' => 'tinymce');
$modversion['config'][12]['category'] = 'tiny_settings';
$i++;
$modversion['config'][$i]['name'] = 'newsdisplay';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_NEWSDISPLAY';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_NEWSDISPLAYDESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'Classic';
$modversion['config'][$i]['options'] = array('_MI_SOCIALNET_NEWSCLASSIC' => 'Classic', '_MI_SOCIALNET_NEWSBYTOPIC' => 'Bytopic');
$i++;
// END EDITOR NEWS UNTIL FIXED THE PROBLEM
$modversion['config'][$i]['name'] = 'displayname';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_AUTHORDISPLAY';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_ADISPLAYNAMEDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['options']	= array('_MI_SOCIALNET_DISPLAYNAME1' => 1, '_MI_SOCIALNET_DISPLAYNAME2' => 2, '_MI_SOCIALNET_DISPLAYNAME3' => 3);
$i++;
$modversion['config'][$i]['name'] = 'columnmode';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_COLUMNMODE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_COLUMNMODE_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['options'] = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5);
$i++;
$modversion['config'][$i]['name'] = 'restrictindex';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_RESTRICTINDEX';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_RESTRICTINDEXDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'anonymous_vote';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_ANONYMOUS_VOTE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_ANONYMOUS_VOTE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'index_name';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_INDEX_NAME';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_INDEX_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'Index';
$i++;
// END CONFIG NEWS
// CONFIGURATION FOR ADMIN NOTE
$modversion['config'][$i]['name'] = 'perpage';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_MSGADMINTITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_MSGADMINTITLEDESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 15;
$modversion['config'][$i]['options'] = array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50);
$i++;
$modversion['config'][$i]['name'] = 'themesssage';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_ADMIN_MSGWIDTH';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_ADMIN_MSGWIDTHDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '300';
$i++;
// END ADMIN NOTE
// CONFIGURATION FOR ACTIVE ALL USERS
$modversion['config'][$i]['name'] = 'activeid';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_ACTIVEID';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_ACTIVEIDDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
// ACTIVATE ALL USER, USERS PER PAGE
$modversion['config'][$i]['name'] = 'userperpage';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_USERPERPAGE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_USERPERPAGEDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 20;
$modversion['config'][$i]['options'] = array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '50' => 50, '100' => 100, '200' => 200);
$i++;
// CONFIGURATION FOR SPOT IMAGES
$imgcat_handler =& xoops_gethandler('imagecategory');
$catlist =& array_flip($imgcat_handler->getList(array(), 'imgcat_read', 1));
$modversion['config'][$i]['name'] = 'spot_des_img';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_DSTAC_IMG';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_DSTAC_IMG_DES';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['options'] = $catlist;
$i++;
// CONFIGURATION FOR TREE MENU
$modversion['config'][$i]['name'] = 'socialnet_conf_home_id';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_HOME_ID';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_HOME_ID_DESC';
$modversion['config'][$i]['formtype'] = 'texbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '0';
$i++;
$modversion['config'][$i]['name'] = 'socialnet_conf_mimetypes';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_MIMETYPES';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_MIMETYPES_DESC';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['options'] = array("gtar"=>"application/x-gtar", "tar"=>"application/x-tar", "gz"=>"application/x-gzip", "doc"=>"application/msword", "pdf"=>"application/pdf", "xla"=>"application/vnd.ms-excel", "xls"=>"application/vnd.ms-excel", "ppt"=>"application/vnd.ms-powerpoint", "pps"=>"application/ms-powerpoint", "zip"=>"application/zip", "avi"=>"video/x-msvideo", "gif"=>"image/gif", "mov"=>"video/quicktime", "mp3"=>"audio/mpeg", "ra"=>"audio/x-realaudio", "ram"=>"audio/x-pn-realaudio", "swf"=>"application/x-shockwave-flash", "wav"=>"audio/x-wav", "mid"=>"audio/midi", "midi"=>"audio/midi", "mpe"=>"video/mpeg", "mpeg"=>"video/mpeg", "mpg"=>"video/mpeg" );
$modversion['config'][$i]['default'] = array("application/x-gtar", "application/x-tar", "application/x-gzip", "application/msword", "application/pdf", "application/vnd.ms-excel", "application/vnd.ms-excel", "application/vnd.ms-powerpoint", "application/ms-powerpoint", "application/zip", "video/x-msvideo", "image/gif", "video/quicktime", "audio/mpeg", "audio/x-realaudio", "audio/x-pn-realaudio", "application/x-shockwave-flash", "audio/x-wav", "audio/midi", "audio/midi", "video/mpeg", "video/mpeg", "video/mpeg" );
$i++;
$modversion['config'][$i]['name'] = 'socialnet_conf_contentmimes';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_CONTENTMIMES';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_CONTENTMIMES_DESC';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['options'] = array("html"=>"text/html", "txt"=>"text/plain", "php"=>"application/x-httpd-php", "js"=>"application/x-javascript");
$modversion['config'][$i]['default'] = array("text/html", "text/plain", "application/x-httpd-php", "application/x-javascript");
$i++;
$modversion['config'][$i]['name'] = 'socialnet_max_filesize';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_MAXFILESIZE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_MAXFILESIZE_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = intval(get_cfg_var('upload_max_filesize'))*1024;
$i++;
$modversion['config'][$i]['name'] = 'socialnet_mmax_filesize';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_MMAXFILESIZE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_MMAXFILESIZE_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = intval(get_cfg_var('upload_max_filesize'))*1024;
$i++;
$modversion['config'][$i]['name'] = 'socialnet_conf_names_id';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_NAMES_ID';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_NAMES_ID_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'socialnet_conf_iframe_width';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_IFRAME_WIDTH';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_IFRAME_WIDTH_DESC';
$modversion['config'][$i]['formtype'] = 'texbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '100%';
$i++;
$modversion['config'][$i]['name'] = 'socialnet_conf_iframe_height';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_IFRAME_HEIGHT';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_IFRAME_HEIGHT_DESC';
$modversion['config'][$i]['formtype'] = 'texbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '800';
$i++;
$modversion['config'][$i]['name'] = 'socialnet_conf_related';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_RELATED';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_RELATED_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'socialnet_conf_canedit';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_CANEDIT';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_CANEDIT_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'socialnet_conf_cancreate';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_CANCREATE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_CANCREATE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'socialnet_conf_candelete';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_CANDELETE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_CANDELETE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
// CONFIGURATION FORUM 
$modversion['config'][$i]['name'] = 'confidentiality';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_SHOWMSG';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_SHOWMSGDESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
//Mime Types - Default values : Web pictures (png, gif, jpeg), zip, pdf, gtar, tar, pdf, word, excel, open office
$modversion['config'][$i]['name'] = 'mimetypes';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_ATTACH_FILES';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_ATTACH_HLP';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'image/gif\nimage/jpeg\nimage/pjpeg\nimage/x-png\nimage/png\napplication/x-zip-compressed\napplication/zip\napplication/pdf\napplication/x-gtar\napplication/x-tar\napplication/msword\napplication/vnd.ms-excel\napplication/vnd.oasis.opendocument.text\napplication/vnd.oasis.opendocument.spreadsheet\napplication/vnd.oasis.opendocument.presentation\napplication/vnd.oasis.opendocument.graphics\napplication/vnd.oasis.opendocument.chart\napplication/vnd.oasis.opendocument.formula\napplication/vnd.oasis.opendocument.database\napplication/vnd.oasis.opendocument.image\napplication/vnd.oasis.opendocument.text-master';
$i++;
//MAX Filesize Upload in kilo bytes
$modversion['config'][$i]['name'] = 'maxuploadsize';
$modversion['config'][$i]['title'] = '_MI_SOCIALNET_UPLSIZE';
$modversion['config'][$i]['description'] = '_MI_SOCIALNET_UPLSIZE_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1048576;
// END GENERAL CONFIG

// BEGIN TEMPLATES SECTION
$i=1;
$modversion['templates'][$i]['file'] = 'socialnet_navbar.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_TEMPLATENAVBARDESC;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_navbarbelow.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_TEMPLATENAVBARBELOWDESC;
$i++;
// Template Bar facebookstyle
$modversion['templates'][$i]['file'] = 'socialnet_navbarfacebookstyle.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_navbarfaceprofile.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_index.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_PICTURE_TEMPLATEINDEXDESC;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_friends.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_PICTURE_TEMPLATEFRIENDSDESC;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_scrapbook.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_PICTURE_TEMPLATESCRAPBOOKDESC;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_audio.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_PICTURE_TEMPLATEAUDIODESC;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_youtube.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_PICTURE_TEMPLATEYOUTUBEDESC;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_album.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_PICTURE_TEMPLATEALBUMDESC;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_groups.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_PICTURE_TEMPLATEGROUPSDESC;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_configs.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_PICTURE_TEMPLATECONFIGSDESC;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_footer.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_PICTURE_TEMPLATEFOOTERDESC;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_editgroup.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_PICTURE_TEMPLATEEDITGROUP;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_groupsresults.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_PICTURE_TEMPLATESEARCHRESULTDESC;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_group.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_PICTURE_TEMPLATEGROUPDESC;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_searchresults.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_PICTURE_TEMPLATESEARCHRESULTSDESC;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_searchform.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_PICTURE_TEMPLATESEARCHFORMDESC;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_notifications.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_PICTURE_TEMPLATENOTIFICATIONS;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_fans.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_PICTURE_TEMPLATEFANS;
$i++;
// Templates Membership
$modversion['templates'][$i]['file'] = 'socialnet_membership.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_about.html';
$modversion['templates'][$i]['description'] = '';
$i++;
// Templates UserPage
$modversion['templates'][$i]['file'] = 'socialnet_userpage.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_USERPAGE_TEMPLATEUSERPAGE;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_rss.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_RSS_TEMPLATERSS;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_pageedit.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_USERPAGE_TEMPLATEEDIT;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_pagelist.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_USERPAGE_TEMPLATELIST;
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_addto.html';
$modversion['templates'][$i]['description'] = 'Displays an AddTo bar';
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_contactusform.html';
$modversion['templates'][$i]['description'] = '';
$i++;
// Templates News
$modversion['templates'][$i]['file'] = 'socialnet_item.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_archive.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_article.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_news.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_by_topic.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_ratearticle.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_newsversion.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_newssearchform.html';
$modversion['templates'][$i]['description'] = '';
$i++;
// Template Tree Menu
$modversion['templates'][$i]['file'] = 'socialnet_menutree.tpl.html';
$modversion['templates'][$i]['description'] = _MI_SOCIALNET_TREEMENU_TEMPLATEMENU_DESC;
$i++;
// Templates Tools Languages
$modversion['templates'][$i]['file'] = 'socialnet_langtool.html';
$modversion['templates'][$i]['description'] = 'Socialnet Languages Tool Form';
$i++;
// Templates PopChat
$modversion['templates'][$i]['file'] = 'socialnet_popchat.html';
$modversion['templates'][$i]['description'] = '_MI_SOCIALNET_POPCHAT_TEMPLATECHATDESC';
$i++;
// Templates Forum
$modversion['templates'][$i]['file'] = 'socialnet_forumbegin.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_forumsearch.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_forumsearchresults.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_forumthread.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_forumview.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_forumviewtopicflat.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_forumviewtopicthread.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_birthday.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'socialnet_interestfriendslist.html';
$modversion['templates'][$i]['description'] = '';
//END TEMPLATES

// BEGIN BLOCKS SECTIONS
$i++;
$modversion['blocks'][$i]['file'] = 'socialnet_blocks.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_FRIENDS;
$modversion['blocks'][$i]['description'] = _MI_SOCIALNET_FRIENDS_DESC;
$modversion['blocks'][$i]['show_func'] = 'b_socialnet_friends_show';
$modversion['blocks'][$i]['options'] = '5';
$modversion['blocks'][$i]['edit_func'] = 'b_socialnet_friends_edit';
$modversion['blocks'][$i]['template'] = 'socialnet_block_friends.html';
$i++;
$modversion['blocks'][$i]['file'] = 'socialnet_blocks.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_LAST;
$modversion['blocks'][$i]['description'] = _MI_SOCIALNET_LAST_DESC;
$modversion['blocks'][$i]['show_func'] = 'b_socialnet_lastpictures_show';
$modversion['blocks'][$i]['options'] = '5';
$modversion['blocks'][$i]['edit_func'] = 'b_socialnet_lastpictures_edit';
$modversion['blocks'][$i]['template'] = 'socialnet_block_lastpictures.html';
$i++;
// Blocks + Clock templates
$modversion['blocks'][$i]['file'] = 'socialnet_clockc.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_CLOCK;
$modversion['blocks'][$i]['description'] = _MI_SOCIALNET_CLOCK_DESC;
$modversion['blocks'][$i]['show_func'] = 'clockc_show';
$modversion['blocks'][$i]['options'] = '5';
$modversion['blocks'][$i]['template'] = 'socialnet_block_clockc.html';
$i++;
// Blocks Users
$modversion['blocks'][$i]['file'] = 'socialnet_usersblock.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_USERMENU;
$modversion['blocks'][$i]['description'] = _MI_SOCIALNET_USERMENU_DESC;
$modversion['blocks'][$i]['show_func'] = 'user_block';
$modversion['blocks'][$i]['edit_func'] = 'user_options';
$modversion['blocks'][$i]['options']	= '1|1|1|1|1|10';
$modversion['blocks'][$i]['template'] = 'socialnet_block_users.html';
$modversion['blocks'][$i]['show_all_module'] = true;
$modversion['blocks'][$i]['can_clone'] = false ;
$i++;
// Blocks UserPage
$modversion['blocks'][$i]['file'] = 'socialnet_pagelast.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_USERPAGE_LAST;
$modversion['blocks'][$i]['description'] = _MI_SOCIALNET_USERPAGE_DESC;
$modversion['blocks'][$i]['show_func'] = 'b_socialnet_last_show';
$modversion['blocks'][$i]['edit_func'] = 'b_socialnet_last_edit';
$modversion['blocks'][$i]['options'] = '10|30';	// 10=Items count, 30=Title's length
$modversion['blocks'][$i]['template'] = 'socialnet_block_pagelast.html';
$i++;
$modversion['blocks'][$i]['file'] = 'socialnet_pagetop.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_USERPAGE_TOP;
$modversion['blocks'][$i]['description'] = _MI_SOCIALNET_USERPAGE_TOP_DESC;
$modversion['blocks'][$i]['show_func'] = 'b_socialnet_top2_show';
$modversion['blocks'][$i]['edit_func'] = 'b_socialnet_top2_edit';
$modversion['blocks'][$i]['options'] = '10|30';	// 10=Items count, 30=Title's length
$modversion['blocks'][$i]['template'] = 'socialnet_block_pagetop.html';
$i++;
$modversion['blocks'][$i]['file'] = 'socialnet_pagerandom.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_USERPAGE_RANDOM;
$modversion['blocks'][$i]['description'] = _MI_SOCIALNET_USERPAGE_RANDOM_DESC;
$modversion['blocks'][$i]['show_func'] = 'b_socialnet_random_show';
$modversion['blocks'][$i]['edit_func'] = 'b_socialnet_random_edit';
$modversion['blocks'][$i]['options'] = '10|30';	// 10=Items count, 30=Title's length
$modversion['blocks'][$i]['template'] = 'socialnet_block_pagerandom.html';
$i++;
// Blocks Addto
$modversion['blocks'][$i]['file'] = 'socialnet_addto.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_ADDTO_TITLE;
$modversion['blocks'][$i]['description']	= _MI_SOCIALNET_ADDTO_DESC;
$modversion['blocks'][$i]['show_func'] = 'socialnet_addto_show';
$modversion['blocks'][$i]['edit_func'] = 'socialnet_addto_edit';
//$modversion['blocks'][$i]['options']	= '0';
$modversion['blocks'][$i]['template'] = 'socialnet_block_addto.html';
$i++;
// Blocks Search
$modversion['blocks'][$i]['file'] = 'socialnet_googlesearch.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_GOOGLE;
$modversion['blocks'][$i]['description'] = _MI_SOCIALNET_GOOGLE_DESC;
$modversion['blocks'][$i]['show_func'] = 'b_socialnet_search_show';
$modversion['blocks'][$i]['edit_func'] = 'b_socialnet_search_edit';
$modversion['blocks'][$i]['options'] = '0|0|1|s|http://www.google.com/search';
$modversion['blocks'][$i]['template'] = 'socialnet_block_googlesearch.html';
$i++;

// Begin Blocks Module News
$modversion['blocks'][$i]['file'] = 'socialnet_bigstory.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_NEWS_BNAME1;
$modversion['blocks'][$i]['description'] = 'Shows most read story of the day';
$modversion['blocks'][$i]['show_func'] = 'b_socialnet_bigstory_show';
$modversion['blocks'][$i]['template'] = 'socialnet_block_bigstory.html';
$i++;
$modversion['blocks'][$i]['file'] = 'socialnet_topicsnav.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_NEWS_BNAME2;
$modversion['blocks'][$i]['description'] = 'Shows a block to navigate topics';
$modversion['blocks'][$i]['show_func'] = 'b_socialnet_topicsnav_show';
$modversion['blocks'][$i]['edit_func'] = 'b_socialnet_topicsnav_edit';
$modversion['blocks'][$i]['options'] = 0;
$modversion['blocks'][$i]['template'] = 'socialnet_block_topicnav.html';
$i++;
$modversion['blocks'][$i]['file'] = 'socialnet_author.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_NEWS_BNAME3;
$modversion['blocks'][$i]['description'] = 'Shows top authors';
$modversion['blocks'][$i]['show_func'] = 'b_socialnet_author_show';
$modversion['blocks'][$i]['edit_func'] = 'b_socialnet_author_edit';
$modversion['blocks'][$i]['options'] = 'count|5|uname';
$modversion['blocks'][$i]['template'] = 'socialnet_block_authors.html';
$i++;
$modversion['blocks'][$i]['file'] = 'socialnet_author.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_NEWS_BNAME4;
$modversion['blocks'][$i]['description'] = 'Shows top authors';
$modversion['blocks'][$i]['show_func'] = 'b_socialnet_author_show';
$modversion['blocks'][$i]['edit_func'] = 'b_socialnet_author_edit';
$modversion['blocks'][$i]['options'] = 'read|5|uname';
$modversion['blocks'][$i]['template'] = 'socialnet_block_authors.html';
$i++;
$modversion['blocks'][$i]['file'] = 'socialnet_newstop.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_NEWS_BNAME5;
$modversion['blocks'][$i]['description'] = 'Shows top rated articles';
$modversion['blocks'][$i]['show_func'] = 'b_socialnet_top_show';
$modversion['blocks'][$i]['edit_func'] = 'b_socialnet_top_edit';
$modversion['blocks'][$i]['options'] = 'rating|10|25|0';
$modversion['blocks'][$i]['template'] = 'socialnet_block_topnews.html';
$i++;
$modversion['blocks'][$i]['file'] = 'socialnet_newsspotlight.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_NEWS_BNAME6;
$modversion['blocks'][$i]['description'] = 'Spotlight articles';
$modversion['blocks'][$i]['show_func'] = 'b_socialnet_newsspotlight_show';
$modversion['blocks'][$i]['edit_func'] = 'b_socialnet_newsspotlight_edit';
$modversion['blocks'][$i]['template'] = 'socialnet_block_spotlight.html';
// End Module News

// Admin notes
$i++;
$modversion['blocks'][$i]['file'] = 'socialnet_note.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_NOTE_TITLE;
$modvertion['blocks'][$i]['description'] = _MI_SOCIALNET_NOTE_TITLEDEC;
$modversion['blocks'][$i]['show_func'] = 'b_note_blocks_show';
$modversion['blocks'][$i]['edit_func'] = 'b_note_blocks_edit';
$modversion['blocks'][$i]['can_clone'] = true ;
$modversion['blocks'][$i]['options'] = 'date|10|19';
$modversion['blocks'][$i]['template'] = 'socialnet_block_note.html';
$i++;
// Blocks Spot image
$modversion['blocks'][$i]['file'] = _MI_SOCIALNET_BLOCK1_FILE;
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_BLOCK1;
$modversion['blocks'][$i]['description'] = _MI_SOCIALNET_BLOCK1_DESC;
$modversion['blocks'][$i]['show_func'] = _MI_SOCIALNET_BLOCK1_SHOW;
$modversion['blocks'][$i]['edit_func'] = _MI_SOCIALNET_BLOCK1_EDIT;
$modversion['blocks'][$i]['options'] = '0|200|1|1|6|326801|FFFFFF|50';
$modversion['blocks'][$i]['template'] = _MI_SOCIALNET_BLOCK1_TEMPLATE;
$i++;
// Blocks for Tree-Menu
$modversion['blocks'][$i]['file'] = 'socialnet_menucss.bloco.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_BLOCK1B;
$modversion['blocks'][$i]['description'] = _MI_SOCIALNET_BLOCK1B_DESC;
$modversion['blocks'][$i]['show_func'] = 'socialnet_menucss_exibe';
$modversion['blocks'][$i]['edit_func'] = 'socialnet_menucss_edita';
$modversion['blocks'][$i]['options'] = '0|1|Home|1|100%|170px|'.XOOPS_URL.'/modules/socialnet/images/icons/arrow.gif|D8E3B8|326801|000000|EBE8FA|326801|0|0|0|0|0|0|1px|solid|CCCCCC|1px|groove|326801|4px|0';
$modversion['blocks'][$i]['template'] = 'socialnet_block_menucss.tpl.html';
$i++;
$modversion['blocks'][$i]['file'] = 'socialnet_navigation.bloco.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_BLOCK2;
$modversion['blocks'][$i]['description'] = _MI_SOCIALNET_BLOCK2_DESC;
$modversion['blocks'][$i]['show_func'] = 'socialnet_navigation_exibe';
$modversion['blocks'][$i]['edit_func'] = 'socialnet_navigation_edita';
$modversion['blocks'][$i]['options'] = '15px|000000|/';
$i++;
$modversion['blocks'][$i]['file'] = 'socialnet_related.bloco.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_BLOCK3;
$modversion['blocks'][$i]['description'] = _MI_SOCIALNET_BLOCK3_DESC;
$modversion['blocks'][$i]['show_func'] = 'socialnet_related_exibe';
$modversion['blocks'][$i]['edit_func'] = 'socialnet_related_edita';
$modversion['blocks'][$i]['options'] = '10px|2200FF|mpb_30_title|50';
$modversion['blocks'][$i]['template'] = 'socialnet_block_related.tpl.html';
$i++;
$modversion['blocks'][$i]['file'] = 'socialnet_menutree.bloco.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_BLOCK4;
$modversion['blocks'][$i]['description'] = _MI_SOCIALNET_BLOCK4_DESC;
$modversion['blocks'][$i]['show_func'] = 'socialnet_menutree_exibe';
$modversion['blocks'][$i]['edit_func'] = 'socialnet_menutree_edita';
$modversion['blocks'][$i]['options'] = 'mpub_menutree|1|Home|1|FFFFFF|F2F2F2|000000|757575|3C00AB|0|0|0|0|0|0|0';
$modversion['blocks'][$i]['template'] = 'socialnet_block_menutree.tpl.html';
$i++;
$modversion['blocks'][$i]['file'] = 'socialnet_menuhor.bloco.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_BLOCK5;
$modversion['blocks'][$i]['description'] = _MI_SOCIALNET_BLOCK5_DESC;
$modversion['blocks'][$i]['show_func'] = 'socialnet_menuhor_exibe';
$modversion['blocks'][$i]['edit_func'] = 'socialnet_menuhor_edita';
$modversion['blocks'][$i]['options'] = '0|1|Home|1|150px|170px|'.XOOPS_URL.'/modules/socialnet/images/icons/plus.gif|FFFFFF|050200|326801|EBE8FA|1D5223|0|0|0|0|0|0|1px|solid|CCCCCC|1px|groove|000000|4px|0';
$modversion['blocks'][$i]['template'] = 'socialnet_block_menuhor.tpl.html';
$i++;
$modversion['blocks'][$i]['file'] = 'socialnet_menurelated.bloco.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_BLOCK6;
$modversion['blocks'][$i]['description'] = _MI_SOCIALNET_BLOCK6_DESC;
$modversion['blocks'][$i]['show_func'] = 'socialnet_menurelated_exibe';
$modversion['blocks'][$i]['edit_func'] = 'socialnet_menurelated_edita';
$modversion['blocks'][$i]['options'] = 'mpub_menurel|100%|170px|'.XOOPS_URL.'/modules/socialnet/images/icons/arrow.gif|FFFFFF|050200|326801|EBE8FA|1D5223|0|0|0|0|0|0|1px|solid|CCCCCC|1px|groove|000000|4px';
$modversion['blocks'][$i]['template'] = 'socialnet_block_menurelated.tpl.html';
$i++;
// Blocks Pop Chat
$modversion['blocks'][$i]['file'] = 'socialnet_marquee.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_POPCHAT_NAME;
$modversion['blocks'][$i]['description'] = _MI_SOCIALNET_POPCHAT_DESC;
$modversion['blocks'][$i]['show_func'] = 'chat_marquee_show';
$modversion['blocks'][$i]['options'] = '1';
$modversion['blocks'][$i]['edit_func'] = 'chat_marquee_edit';
$modversion['blocks'][$i]['template'] = 'socialnet_block_marquee.html';
$i++;
// Blocks Forum
$modversion['blocks'][$i]['file'] = 'socialnet_forumblocks.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_BNAME1;
$modversion['blocks'][$i]['description'] = 'Shows recent topics in the forums';
$modversion['blocks'][$i]['show_func'] = 'b_socialnet_new_show';
$modversion['blocks'][$i]['options'] = '10|1|time|1';
$modversion['blocks'][$i]['edit_func'] = 'b_socialnet_new_edit';
$modversion['blocks'][$i]['template'] = 'socialnet_block_forum_new.html';
$i++;
$modversion['blocks'][$i]['file'] = 'socialnet_forumblocks.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_BNAME2;
$modversion['blocks'][$i]['description'] = 'Shows most viewed topics in the forums';
$modversion['blocks'][$i]['show_func'] = 'b_socialnet_new_show';
$modversion['blocks'][$i]['options'] = '10|1|views|1';
$modversion['blocks'][$i]['edit_func'] = 'b_socialnet_new_edit';
$modversion['blocks'][$i]['template'] = 'socialnet_block_forum_top.html';
$i++;
$modversion['blocks'][$i]['file'] = 'socialnet_forumblocks.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_BNAME3;
$modversion['blocks'][$i]['description'] = 'Shows most active topics in the forums';
$modversion['blocks'][$i]['show_func'] = 'b_socialnet_new_show';
$modversion['blocks'][$i]['options'] = '10|1|replies|1';
$modversion['blocks'][$i]['edit_func'] = 'b_socialnet_new_edit';
$modversion['blocks'][$i]['template'] = 'socialnet_block_forum_active.html';
$i++;
$modversion['blocks'][$i]['file'] = 'socialnet_forumblocks.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_BNAME4;
$modversion['blocks'][$i]['description'] = 'Shows recent and private topics in the forums';
$modversion['blocks'][$i]['show_func'] = 'b_socialnet_new_private_show';
$modversion['blocks'][$i]['options'] = '10|1|time|1';
$modversion['blocks'][$i]['edit_func'] = 'b_socialnet_new_edit';
$modversion['blocks'][$i]['template'] = 'socialnet_block_forum_prv.html';
$i++;
// Blocks Birthday
$modversion['blocks'][$i]['file'] = 'socialnet_birthday.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_BIRTH_TITLE;
$modversion['blocks'][$i]['description'] = _MI_SOCIALNET_BIRTH_DESC;
$modversion['blocks'][$i]['show_func'] = 'b_birthday_show';
$i++;
// Blocks Interest Friends
$modversion['blocks'][$i]['file'] = 'socialnet_interestfriends.php';
$modversion['blocks'][$i]['name'] = _MI_SOCIALNET_INTEREST_BLOCK_ADMIRERS;
$modversion['blocks'][$i]['description'] = _MI_SOCIALNET_INTEREST_BLOCK_ADMIRERS_DESC;
$modversion['blocks'][$i]['show_func'] = 'myadmirers_show';
$modversion['blocks'][$i]['template'] = 'socialnet_block_myadmirers.html';
// END BLOCKS MODULE

// BEGIN NOTIFICATIONS
$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'socialnet_iteminfo';
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'socialnet_notify_iteminfo';
$modversion['notification']['lookup_file'] = 'include/socialnet_forumnotification.inc.php';
//$modversion['notification']['lookup_func'] = 'socialnet_notify_iteminfo';

$modversion['notification']['category'][1]['name'] = 'picture';
$modversion['notification']['category'][1]['title'] = _MI_SOCIALNET_PICTURE_NOTIFYTIT;
$modversion['notification']['category'][1]['description'] = _MI_SOCIALNET_PICTURE_NOTIFYDSC;
$modversion['notification']['category'][1]['subscribe_from'] = 'album.php';
$modversion['notification']['category'][1]['item_name'] = 'uid';
$modversion['notification']['category'][1]['allow_bookmark'] = 1;
$modversion['notification']['event'][1]['name'] = 'new_picture';
$modversion['notification']['event'][1]['category'] = 'picture';
$modversion['notification']['event'][1]['title'] = _MI_SOCIALNET_PICTURE_NEWPIC_NOTIFY;
$modversion['notification']['event'][1]['caption'] = _MI_SOCIALNET_PICTURE_NEWPIC_NOTIFYCAP;
$modversion['notification']['event'][1]['description'] = _MI_SOCIALNET_PICTURE_NEWPOST_NOTIFYDSC;
$modversion['notification']['event'][1]['mail_template'] = 'picture_newpic_notify';
$modversion['notification']['event'][1]['mail_subject'] = _MI_SOCIALNET_PICTURE_NEWPIC_NOTIFYSBJ;

$modversion['notification']['category'][2]['name'] = 'video';
$modversion['notification']['category'][2]['title'] = _MI_SOCIALNET_VIDEO_NOTIFYTIT;
$modversion['notification']['category'][2]['description'] = _MI_SOCIALNET_VIDEO_NOTIFYDSC;
$modversion['notification']['category'][2]['subscribe_from'] = 'youtube.php';
$modversion['notification']['category'][2]['item_name'] = 'uid';
$modversion['notification']['category'][2]['allow_bookmark'] = 1;
$modversion['notification']['event'][2]['name'] = 'new_video';
$modversion['notification']['event'][2]['category'] = 'video';
$modversion['notification']['event'][2]['title'] = _MI_SOCIALNET_VIDEO_NEWVIDEO_NOTIFY;
$modversion['notification']['event'][2]['caption'] = _MI_SOCIALNET_VIDEO_NEWVIDEO_NOTIFYCAP;
$modversion['notification']['event'][2]['description'] = _MI_SOCIALNET_VIDEO_NEWVIDEO_NOTIFYDSC;
$modversion['notification']['event'][2]['mail_template'] = 'video_newvideo_notify';
$modversion['notification']['event'][2]['mail_subject'] = _MI_SOCIALNET_VIDEO_NEWVIDEO_NOTIFYSBJ;

$modversion['notification']['category'][3]['name'] = 'scrap';
$modversion['notification']['category'][3]['title'] = _MI_SOCIALNET_SCRAP_NOTIFYTIT;
$modversion['notification']['category'][3]['description'] = _MI_SOCIALNET_SCRAP_NOTIFYDSC;
$modversion['notification']['category'][3]['subscribe_from'] = 'scrapbook.php';
$modversion['notification']['category'][3]['item_name'] = 'uid';
$modversion['notification']['category'][3]['allow_bookmark'] = 1;
$modversion['notification']['event'][3]['name'] = 'new_scrap';
$modversion['notification']['event'][3]['category'] = 'scrap';
$modversion['notification']['event'][3]['title'] = _MI_SOCIALNET_SCRAP_NEWSCRAP_NOTIFY;
$modversion['notification']['event'][3]['caption'] = _MI_SOCIALNET_SCRAP_NEWSCRAP_NOTIFYCAP;
$modversion['notification']['event'][3]['description'] = _MI_SOCIALNET_SCRAP_NEWSCRAP_NOTIFYDSC;
$modversion['notification']['event'][3]['mail_template'] = 'scrap_newscrap_notify';
$modversion['notification']['event'][3]['mail_subject'] = _MI_SOCIALNET_SCRAP_NEWSCRAP_NOTIFYSBJ;

$modversion['notification']['category'][4]['name'] = 'friendship';
$modversion['notification']['category'][4]['title'] = _MI_SOCIALNET_FRIENDSHIP_NOTIFYTIT;
$modversion['notification']['category'][4]['description'] = _MI_SOCIALNET_FRIENDSHIP_NOTIFYDSC;
$modversion['notification']['category'][4]['subscribe_from'] = 'friends.php';
$modversion['notification']['category'][4]['item_name'] = 'uid';
$modversion['notification']['category'][4]['allow_bookmark'] = 0;
$modversion['notification']['event'][4]['name'] = 'new_friendship';
$modversion['notification']['event'][4]['category'] = 'friendship';
$modversion['notification']['event'][4]['title'] = _MI_SOCIALNET_FRIEND_NEWPETITION_NOTIFY;
$modversion['notification']['event'][4]['caption'] = _MI_SOCIALNET_FRIEND_NEWPETITION_NOTIFYCAP;
$modversion['notification']['event'][4]['description'] = _MI_SOCIALNET_FRIEND_NEWPETITION_NOTIFYDSC;
$modversion['notification']['event'][4]['mail_template'] = 'friendship_newpetition_notify';
$modversion['notification']['event'][4]['mail_subject'] = _MI_SOCIALNET_FRIEND_NEWPETITION_NOTIFYSBJ;

//Notifications News
$modversion['notification']['category'][5]['name'] = 'global';
$modversion['notification']['category'][5]['title'] = _MI_SOCIALNET_NEWS_GLOBAL_NOTIFY;
$modversion['notification']['category'][5]['description'] = _MI_SOCIALNET_NEWS_GLOBAL_NOTIFYDSC;
$modversion['notification']['category'][5]['subscribe_from'] = array('news.php', 'newsarticle.php');
$modversion['notification']['event'][5]['name'] = 'new_category';
$modversion['notification']['event'][5]['category'] = 'global';
$modversion['notification']['event'][5]['title'] = _MI_SOCIALNET_NEWS_GLOBAL_NEWCATEGORY_NOTIFY;
$modversion['notification']['event'][5]['caption'] = _MI_SOCIALNET_NEWS_GLOBAL_NEWCATEGORY_NOTIFYCAP;
$modversion['notification']['event'][5]['description'] = _MI_SOCIALNET_NEWS_GLOBAL_NEWCATEGORY_NOTIFYDSC;
$modversion['notification']['event'][5]['mail_template'] = 'global_newcategory_notify';
$modversion['notification']['event'][5]['mail_subject'] = _MI_SOCIALNET_NEWS_GLOBAL_NEWCATEGORY_NOTIFYSBJ;

$modversion['notification']['category'][6]['name'] = 'story';
$modversion['notification']['category'][6]['title'] = _MI_SOCIALNET_NEWS_STORY_NOTIFY;
$modversion['notification']['category'][6]['description'] = _MI_SOCIALNET_NEWS_STORY_NOTIFYDSC;
$modversion['notification']['category'][6]['subscribe_from'] = array('newsarticle.php');
$modversion['notification']['category'][6]['item_name'] = 'storyid';
$modversion['notification']['category'][6]['allow_bookmark'] = 1;
$modversion['notification']['event'][6]['name'] = 'story_submit';
$modversion['notification']['event'][6]['category'] = 'global';
$modversion['notification']['event'][6]['admin_only'] = 1;
$modversion['notification']['event'][6]['title'] = _MI_SOCIALNET_NEWS_GLOBAL_STORYSUBMIT_NOTIFY;
$modversion['notification']['event'][6]['caption'] = _MI_SOCIALNET_NEWS_GLOBAL_STORYSUBMIT_NOTIFYCAP;
$modversion['notification']['event'][6]['description'] = _MI_SOCIALNET_NEWS_GLOBAL_STORYSUBMIT_NOTIFYDSC;
$modversion['notification']['event'][6]['mail_template'] = 'global_storysubmit_notify';
$modversion['notification']['event'][6]['mail_subject'] = _MI_SOCIALNET_NEWS_GLOBAL_STORYSUBMIT_NOTIFYSBJ;

$modversion['notification']['event'][7]['name'] = 'new_story';
$modversion['notification']['event'][7]['category'] = 'global';
$modversion['notification']['event'][7]['title'] = _MI_SOCIALNET_NEWS_GLOBAL_NEWSTORY_NOTIFY;
$modversion['notification']['event'][7]['caption'] = _MI_SOCIALNET_NEWS_GLOBAL_NEWSTORY_NOTIFYCAP;
$modversion['notification']['event'][7]['description'] = _MI_SOCIALNET_NEWS_GLOBAL_NEWSTORY_NOTIFYDSC;
$modversion['notification']['event'][7]['mail_template'] = 'global_newstory_notify';
$modversion['notification']['event'][7]['mail_subject'] = _MI_SOCIALNET_NEWS_GLOBAL_NEWSTORY_NOTIFYSBJ;

$modversion['notification']['event'][8]['name'] = 'approve';
$modversion['notification']['event'][8]['category'] = 'story';
$modversion['notification']['event'][8]['invisible'] = 1;
$modversion['notification']['event'][8]['title'] = _MI_SOCIALNET_NEWS_STORY_APPROVE_NOTIFY;
$modversion['notification']['event'][8]['caption'] = _MI_SOCIALNET_NEWS_STORY_APPROVE_NOTIFYCAP;
$modversion['notification']['event'][8]['description'] = _MI_SOCIALNET_NEWS_STORY_APPROVE_NOTIFYDSC;
$modversion['notification']['event'][8]['mail_template'] = 'story_approve_notify';
$modversion['notification']['event'][8]['mail_subject'] = _MI_SOCIALNET_NEWS_STORY_APPROVE_NOTIFYSBJ;

// Notification Forum
$modversion['notification']['category'][9]['name'] = 'thread';
$modversion['notification']['category'][9]['title'] = _MI_SOCIALNET_THREAD_NOTIFY;
$modversion['notification']['category'][9]['description'] = _MI_SOCIALNET_THREAD_NOTIFYDSC;
$modversion['notification']['category'][9]['subscribe_from'] = 'forumviewtopic.php';
$modversion['notification']['category'][9]['item_name'] = 'topic_id';
$modversion['notification']['category'][9]['allow_bookmark'] = 1;
$modversion['notification']['event'][9]['name'] = 'new_post';
$modversion['notification']['event'][9]['category'] = 'thread';
$modversion['notification']['event'][9]['title'] = _MI_SOCIALNET_THREAD_NEWPOST_NOTIFY;
$modversion['notification']['event'][9]['caption'] = _MI_SOCIALNET_THREAD_NEWPOST_NOTIFYCAP;
$modversion['notification']['event'][9]['description'] = _MI_SOCIALNET_THREAD_NEWPOST_NOTIFYDSC;
$modversion['notification']['event'][9]['mail_template'] = 'thread_newpost_notify';
$modversion['notification']['event'][9]['mail_subject'] = _MI_SOCIALNET_THREAD_NEWPOST_NOTIFYSBJ;

$modversion['notification']['category'][10]['name'] = 'forum';
$modversion['notification']['category'][10]['title'] = _MI_SOCIALNET_FORUM_NOTIFY;
$modversion['notification']['category'][10]['description'] = _MI_SOCIALNET_FORUM_NOTIFYDSC;
$modversion['notification']['category'][10]['subscribe_from'] = array('forumviewtopic.php', 'forumview.php');
$modversion['notification']['category'][10]['item_name'] = 'forum';
$modversion['notification']['category'][10]['allow_bookmark'] = 1;
$modversion['notification']['event'][10]['name'] = 'new_thread';
$modversion['notification']['event'][10]['category'] = 'forum';
$modversion['notification']['event'][10]['title'] = _MI_SOCIALNET_FORUM_NEWTHREAD_NOTIFY;
$modversion['notification']['event'][10]['caption'] = _MI_SOCIALNET_FORUM_NEWTHREAD_NOTIFYCAP;
$modversion['notification']['event'][10]['description'] = _MI_SOCIALNET_FORUM_NEWTHREAD_NOTIFYDSC;
$modversion['notification']['event'][10]['mail_template'] = 'forum_newthread_notify';
$modversion['notification']['event'][10]['mail_subject'] = _MI_SOCIALNET_FORUM_NEWTHREAD_NOTIFYSBJ;

$modversion['notification']['category'][11]['name'] = 'global';
$modversion['notification']['category'][11]['title'] = _MI_SOCIALNET_GLOBAL_NOTIFY;
$modversion['notification']['category'][11]['description'] = _MI_SOCIALNET_GLOBAL_NOTIFYDSC;
$modversion['notification']['category'][11]['subscribe_from'] = array('forumstart.php', 'forumviewtopic.php', 'forumview.php');
$modversion['notification']['event'][11]['name'] = 'new_forum';
$modversion['notification']['event'][11]['category'] = 'global';
$modversion['notification']['event'][11]['title'] = _MI_SOCIALNET_GLOBAL_NEWFORUM_NOTIFY;
$modversion['notification']['event'][11]['caption'] = _MI_SOCIALNET_GLOBAL_NEWFORUM_NOTIFYCAP;
$modversion['notification']['event'][11]['description'] = _MI_SOCIALNET_GLOBAL_NEWFORUM_NOTIFYDSC;
$modversion['notification']['event'][11]['mail_template'] = 'global_newforum_notify';
$modversion['notification']['event'][11]['mail_subject'] = _MI_SOCIALNET_GLOBAL_NEWFORUM_NOTIFYSBJ;

$modversion['notification']['event'][12]['name'] = 'new_post';
$modversion['notification']['event'][12]['category'] = 'global';
$modversion['notification']['event'][12]['title'] = _MI_SOCIALNET_GLOBAL_NEWPOST_NOTIFY;
$modversion['notification']['event'][12]['caption'] = _MI_SOCIALNET_GLOBAL_NEWPOST_NOTIFYCAP;
$modversion['notification']['event'][12]['description'] = _MI_SOCIALNET_GLOBAL_NEWPOST_NOTIFYDSC;
$modversion['notification']['event'][12]['mail_template'] = 'global_newpost_notify';
$modversion['notification']['event'][12]['mail_subject'] = _MI_SOCIALNET_GLOBAL_NEWPOST_NOTIFYSBJ;

$modversion['notification']['event'][13]['name'] = 'new_post';
$modversion['notification']['event'][13]['category'] = 'forum';
$modversion['notification']['event'][13]['title'] = _MI_SOCIALNET_FORUM_NEWPOST_NOTIFY;
$modversion['notification']['event'][13]['caption'] = _MI_SOCIALNET_FORUM_NEWPOST_NOTIFYCAP;
$modversion['notification']['event'][13]['description'] = _MI_SOCIALNET_FORUM_NEWPOST_NOTIFYDSC;
$modversion['notification']['event'][13]['mail_template'] = 'forum_newpost_notify';
$modversion['notification']['event'][13]['mail_subject'] = _MI_SOCIALNET_FORUM_NEWPOST_NOTIFYSBJ;

$modversion['notification']['event'][14]['name'] = 'new_fullpost';
$modversion['notification']['event'][14]['category'] = 'global';
$modversion['notification']['event'][14]['admin_only'] = 1;
$modversion['notification']['event'][14]['title'] = _MI_SOCIALNET_GLOBAL_NEWFULLPOST_NOTIFY;
$modversion['notification']['event'][14]['caption'] = _MI_SOCIALNET_GLOBAL_NEWFULLPOST_NOTIFYCAP;
$modversion['notification']['event'][14]['description'] = _MI_SOCIALNET_GLOBAL_NEWFULLPOST_NOTIFYDSC;
$modversion['notification']['event'][14]['mail_template'] = 'global_newfullpost_notify';
$modversion['notification']['event'][14]['mail_subject'] = _MI_SOCIALNET_GLOBAL_NEWFULLPOST_NOTIFYSBJ;

?>
