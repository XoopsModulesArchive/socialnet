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

$adminmenu[1]['title'] = _MI_SOCIALNET_ADMENU1;//Home
$adminmenu[1]['link'] = "admin/index.php";
$adminmenu[2]['title'] = _MI_SOCIALNET_ADMENU2;//Blocks
$adminmenu[2]['link'] = "admin/blocksadmin.php";
$adminmenu[3]['title'] = _MI_SOCIALNET_ADMENU3;//About
$adminmenu[3]['link'] = "admin/about.php";
// USER PAGE
$adminmenu[4]['title'] 	= _MI_SOCIALNET_ADMENU4;//User Pages
$adminmenu[4]['link'] 	= "admin/userpage.php";
// NEWS
$adminmenu[5]['title'] = _MI_SOCIALNET_ADMENU5;//Topics Manager
$adminmenu[5]['link'] = "admin/news.php?op=topicsmanager";
$adminmenu[6]['title'] = _MI_SOCIALNET_ADMENU6;//Manage Articles
$adminmenu[6]['link'] = "admin/news.php?op=newarticle";
$adminmenu[7]['title'] = _MI_SOCIALNET_ADMENU7;//Articles/Permissions
$adminmenu[7]['link'] = "admin/groupperms.php";
$adminmenu[8]['title'] = _MI_SOCIALNET_ADMENU8;//Spotlight News
$adminmenu[8]['link'] = "admin/spotlight.php";
$adminmenu[9]['title'] = _MI_SOCIALNET_ADMENU9;//Audience Levels
$adminmenu[9]['link'] = "admin/news.php?op=audience";
// TOOLS ADMIN
$adminmenu[10]['title'] = _MI_SOCIALNET_ADMENU10;//Announce Message
$adminmenu[10]['link'] = "admin/tools_add_note.php";
$adminmenu[11]['title'] = _MI_SOCIALNET_ADMENU11;//Optimize Mysql
$adminmenu[11]['link'] = "admin/tools_optimize.php";
$adminmenu[12]['title'] = _MI_SOCIALNET_ADMENU12;//Active all Users
$adminmenu[12]['link'] = "admin/tools_activeall_user.php";
// SPOT-IMAGES
$adminmenu[13]['title'] = _MI_SOCIALNET_ADMENU13;//Sections Images
$adminmenu[13]['link'] = "admin/sec.php?op=list";
$adminmenu[14]['title'] = _MI_SOCIALNET_ADMENU14;//Spot Images
$adminmenu[14]['link'] = "admin/spot.php?op=list";
// MENU-TREE
$adminmenu[15]['title'] = _MI_SOCIALNET_ADMENU15;//TR1Manage Contents
$adminmenu[15]['link'] = "admin/treepages.php";
$adminmenu[16]['title'] = _MI_SOCIALNET_ADMENU16;//TR2Add Content
$adminmenu[16]['link'] = "admin/treemenu.php?op=new";
$adminmenu[17]['title'] = _MI_SOCIALNET_ADMENU17;//TR3Manage HTML files
$adminmenu[17]['link'] = "admin/treemenu.php?op=list";
$adminmenu[18]['title'] = _MI_SOCIALNET_ADMENU18;//TR4Medias
$adminmenu[18]['link'] = "admin/treemedia.php";
$adminmenu[19]['title'] = _MI_SOCIALNET_ADMENU19;//TR5Files
$adminmenu[19]['link'] = "admin/treefiles.php";
// TRANSLATE LANGUAGES
$adminmenu[20]['title'] = _MI_SOCIALNET_ADMENU20;//Language translate
$adminmenu[20]['link'] = "admin/languages.php";
// POP-CHAT
$adminmenu[21]['title'] = _MI_SOCIALNET_ADMENU21;//Member Chat
$adminmenu[21]['link'] = "admin/beginchat.php";
// FORUM
$adminmenu[22]['title'] = _MI_SOCIALNET_ADMENU22;
$adminmenu[22]['link'] = "admin/admin_forumbegin.php";
$adminmenu[23]['title'] = _MI_SOCIALNET_ADMENU23;
$adminmenu[23]['link'] = "admin/admin_forums.php?mode=addforum";
$adminmenu[24]['title'] = _MI_SOCIALNET_ADMENU24;
$adminmenu[24]['link'] = "admin/admin_forums.php?mode=editforum";
$adminmenu[25]['title'] = _MI_SOCIALNET_ADMENU25;
$adminmenu[25]['link'] = "admin/admin_priv_forums.php?mode=editforum";
$adminmenu[26]['title'] = _MI_SOCIALNET_ADMENU26;
$adminmenu[26]['link'] = "admin/admin_forums.php?mode=sync";
$adminmenu[27]['title'] = _MI_SOCIALNET_ADMENU27;
$adminmenu[27]['link'] = "admin/admin_forums.php?mode=addcat";
$adminmenu[28]['title'] = _MI_SOCIALNET_ADMENU28;
$adminmenu[28]['link'] = "admin/admin_forums.php?mode=editcat";
$adminmenu[29]['title'] = _MI_SOCIALNET_ADMENU29;
$adminmenu[29]['link'] = "admin/admin_forums.php?mode=remcat";
$adminmenu[30]['title'] = _MI_SOCIALNET_ADMENU30;
$adminmenu[30]['link'] = "admin/admin_forums.php?mode=catorder";
// MODULES HELP AND CREDIT
$adminmenu[31]['title'] = _MI_SOCIALNET_ADMENU31;//Modules Credit
$adminmenu[31]['link'] = "admin/tutorial_credit.php";

?>