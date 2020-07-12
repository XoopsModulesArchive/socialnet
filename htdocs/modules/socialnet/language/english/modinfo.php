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

//xoops_version.php Module Name
define('_MI_SOCIALNET_NAME_MOD', 'SocialNet');
define('_MI_SOCIALNET_MODULEDESC', 'This module simulates a social network software. Contains tools for the admin section');
define('_MI_SOCIALNET_LICENSE', 'GPL see LICENSE.');
########### MENU ADMIN SECTION ##########
// BEGIN admin menu
define('_MI_SOCIALNET_ADMENU1', 'Home');
define('_MI_SOCIALNET_ADMENU2', 'Blocks');
define('_MI_SOCIALNET_ADMENU3', 'About-SNet');
define('_MI_SOCIALNET_ADMENU4', 'User Pages');
define('_MI_SOCIALNET_ADMENU5', 'Topics Manager');
define('_MI_SOCIALNET_ADMENU6', 'Manage Articles');
define('_MI_SOCIALNET_ADMENU7', 'Articles/Permissions');
define('_MI_SOCIALNET_ADMENU8', 'Spotlight News');
define('_MI_SOCIALNET_ADMENU9', 'Audience Levels');
define('_MI_SOCIALNET_ADMENU10', 'Announce Message');
define('_MI_SOCIALNET_ADMENU11', 'Check Mysql');
define('_MI_SOCIALNET_ADMENU12', 'Active all Users');
define('_MI_SOCIALNET_ADMENU13', '1Spot: Add Category');
define('_MI_SOCIALNET_ADMENU14', '2Spot: Images Manage');
define('_MI_SOCIALNET_ADMENU15', '1Tree: Add html txt php js');
define('_MI_SOCIALNET_ADMENU16', '2Tree: Add Content');
define('_MI_SOCIALNET_ADMENU17', '3Tree: Manage HTML files');
define('_MI_SOCIALNET_ADMENU18', '4Tree: Add Medias');
define('_MI_SOCIALNET_ADMENU19', '5Tree: Add Files');
define('_MI_SOCIALNET_ADMENU20', 'Manage Languages');
define('_MI_SOCIALNET_ADMENU21', 'Pop Chat Preference');
// Admin Forum menu
define('_MI_SOCIALNET_ADMENU22', 'Forum Setup');
define('_MI_SOCIALNET_ADMENU23', 'Add Forum');
define('_MI_SOCIALNET_ADMENU24', 'Edit Forum');
define('_MI_SOCIALNET_ADMENU25', 'Edit Priv. Forum');
define('_MI_SOCIALNET_ADMENU26', 'Sync forums/topics');
define('_MI_SOCIALNET_ADMENU27', 'Add Category');
define('_MI_SOCIALNET_ADMENU28', 'Edit Category');
define('_MI_SOCIALNET_ADMENU29', 'Delete Category');
define('_MI_SOCIALNET_ADMENU30', 'Re-order Category');
define('_MI_SOCIALNET_ADMENU31', 'Help and Credit');
//END admin menu

########### SUB MENU SECTION ##########
//Sub Menu
define('_MI_SOCIALNET_MENU_SEARCH', 'Search Members');
define('_MI_SOCIALNET_MENU_MYPROFILE', 'My Profile');
define('_MI_SOCIALNET_MENU_MEMBERSHIP', 'Members List');
define('_MI_SOCIALNET_MENU_MYSCRAPS', 'My Scraps');
define('_MI_SOCIALNET_MENU_MYPICTURES', 'My Photos');
define('_MI_SOCIALNET_MENU_MYAUDIOS', 'My audios');
define('_MI_SOCIALNET_MENU_MYVIDEOS', 'My Videos');
define('_MI_SOCIALNET_MENU_MYFRIENDS', 'My Friends');
define('_MI_SOCIALNET_MENU_MYGROUPS', 'My Groups');
define('_MI_SOCIALNET_MENU_MYCONFIGS', 'Who can see');
define('_MI_SOCIALNET_MENU_PAGELIST', 'Pages List');
define('_MI_SOCIALNET_MENU_CONTACTUS', 'Contact Us');
// Sub menus in News Section
define('_MI_SOCIALNET_MENU_NEWS', 'Article/News');
define('_MI_SOCIALNET_MENU_SUBMIT', 'Submit Article');
define('_MI_SOCIALNET_MENU_ARCHIVE', 'Article Archive');
define('_MI_SOCIALNET_MENU_CHAT', 'Members Chat');
define('_MI_SOCIALNET_MENU_FAVORITES', 'My Favorites');
define('_MI_SOCIALNET_MENU_ADMIRERS', 'My Admirers');
//END Sub Menu

########### BLOCKS SECTION ##########
//Blocks
define('_MI_SOCIALNET_FRIENDS', 'My Friends');
define('_MI_SOCIALNET_FRIENDS_DESC', 'This block shows the user friends');
define('_MI_SOCIALNET_LAST', 'PHOTO: Last pictures');
define('_MI_SOCIALNET_LAST_DESC', 'Last pictures sent independently of the album');
define('_MI_SOCIALNET_CLOCK', 'Clock Calendar');
define('_MI_SOCIALNET_CLOCK_DESC', 'Shows a clock/calendar in flash');
define('_MI_SOCIALNET_USERMENU', 'The user menu');
define('_MI_SOCIALNET_USERMENU_DESC', 'Block user');
define('_MI_SOCIALNET_USERPAGE_LAST', 'BLOG: Last created pages');
define('_MI_SOCIALNET_USERPAGE_DESC', 'Shows last pages');
define('_MI_SOCIALNET_USERPAGE_TOP', 'BLOG: Most viewed pages');
define('_MI_SOCIALNET_USERPAGE_TOP_DESC', 'Show most viewed pages');
define('_MI_SOCIALNET_USERPAGE_RANDOM', 'BLOG: Random pages');
define('_MI_SOCIALNET_USERPAGE_RANDOM_DESC', 'Show random pages');
define('_MI_SOCIALNET_ADDTO_TITLE', 'SocialNet Markers');
define('_MI_SOCIALNET_ADDTO_DESC', 'Block of Social Markers');
define('_MI_SOCIALNET_GOOGLE', 'Google Search');
define('_MI_SOCIALNET_GOOGLE_DESC', 'SocialNet: Google Search');
// NEWS BLOCKS
define('_MI_SOCIALNET_NEWS_BNAME1', 'NEWS: Big Story');
define('_MI_SOCIALNET_NEWS_BNAME2', 'NEWS: Navigate thru topics');
define('_MI_SOCIALNET_NEWS_BNAME3', 'NEWS: Most Active Authors');
define('_MI_SOCIALNET_NEWS_BNAME4', 'NEWS: Most Read Authors');
define('_MI_SOCIALNET_NEWS_BNAME5', 'NEWS: Highest Rated Articles');
define('_MI_SOCIALNET_NEWS_BNAME6', 'NEWS: Socialnet Spotlight');
// ADMIN NOTE TO USERS
define('_MI_SOCIALNET_NOTE_TITLE', 'Admin Note');
define('_MI_SOCIALNET_NOTE_TITLEDEC', 'The Admin Messages to his Visitors');
// SPOT IMAGES  blocks/socialnet_spot.php
define('_MI_SOCIALNET_DIR', 'socialnet');
define('_MI_SOCIALNET_BLOCKS', 'Blocks');
// Table for Spot Images created by the sql file sql without prefix
define('_MI_SOCIALNET_TABLESECSECTION', 'socialnet_sec_section');
define('_MI_SOCIALNET_TABLESPOTIMAGES', 'socialnet_spotimages');
// Table for Tree Menu created by the sql file sql without prefix
define('_MI_SOCIALNET_TABLEPUBLISH', 'socialnet_mpb_mpublish');
define('_MI_SOCIALNET_TABLEFILES', 'socialnet_fil_files');
define('_MI_SOCIALNET_TABLEMEDIA', 'socialnet_med_media');
define('_MI_SOCIALNET_TABLECONTENTS', 'socialnet_cfi_contentfiles');
// Table for Forum created by the sql file sql without prefix
define('_MI_SOCIALNET_TABLEFORUMCATEGORIES', 'socialnet_forumcategories');
define('_MI_SOCIALNET_TABLEFORUMACCESS', 'socialnet_forumaccess');
define('_MI_SOCIALNET_TABLEFORUMMODS', 'socialnet_forummods');
define('_MI_SOCIALNET_TABLEFORUMS', 'socialnet_forums');
define('_MI_SOCIALNET_TABLEFORUMPOSTS', 'socialnet_forumposts');
define('_MI_SOCIALNET_TABLEFORUMSPOSTSTEXT', 'socialnet_forumposts_text');
define('_MI_SOCIALNET_TABLEFORUMTOPICS', 'socialnet_forumtopics');
define('_MI_SOCIALNET_TABLEFORUMFILES', 'socialnet_forumfiles');
// SPOT IMAGES
define('_MI_SOCIALNET_SPOT_IMAGES', 'Images Spotlights');
define('_MI_SOCIALNET_SPOT_IMAGES_DESC', 'Block to show spotlights');
// socialnet/xoops_version.php configuration for tree-menu
define('_MI_SOCIALNET_BLOCK1B', 'TREE: Main Menu');
define('_MI_SOCIALNET_BLOCK1B_DESC', 'Css Menu with Submenus');
define('_MI_SOCIALNET_BLOCK2', 'TREE: Navigation');
define('_MI_SOCIALNET_BLOCK2_DESC', 'Navigation Bar');
define('_MI_SOCIALNET_BLOCK3', 'TREE: See also');
define('_MI_SOCIALNET_BLOCK3_DESC', 'Show the pages belonging to the same category');
define('_MI_SOCIALNET_BLOCK4', 'TREE: Tree Menu');
define('_MI_SOCIALNET_BLOCK4_DESC', 'Tree Menu with Submenus');
define('_MI_SOCIALNET_BLOCK5', 'TREE: Horizontal Menu');
define('_MI_SOCIALNET_BLOCK5_DESC', 'CSS Horizontal Menu with Submenus');
define('_MI_SOCIALNET_BLOCK6', 'TREE: Related Pages Menu');
define('_MI_SOCIALNET_BLOCK6_DESC', 'Menu containing related pages in relation to the current one');
// FORUM BLOCK NAME
define('_MI_SOCIALNET_BNAME1', 'FORUM: Recent Topics');
define('_MI_SOCIALNET_BNAME2', 'FORUM: Most Viewed Topics');
define('_MI_SOCIALNET_BNAME3', 'FORUM: Most Active Topics');
define('_MI_SOCIALNET_BNAME4', 'FORUM: Recent Private Topics');
// MY BIRTHDAY
define('_MI_SOCIALNET_BIRTH_TITLE', 'Happy Birthday');
define('_MI_SOCIALNET_BIRTH_DESC', 'Block Show Members Birthday');
// INTEREST FRIENDS
define('_MI_SOCIALNET_INTEREST_BLOCK_ADMIRERS', 'My Admirers');
define('_MI_SOCIALNET_INTEREST_BLOCK_ADMIRERS_DESC', 'Show the latest 3 members who added you as a favorite');
//END Blocks

########### TEMPLATES ##########
//Templates
define('_MI_SOCIALNET_TEMPLATENAVBARDESC', 'Template for the upper navbar used in all pages');
define('_MI_SOCIALNET_TEMPLATENAVBARBELOWDESC', 'Template for the upper navbar below used in all pages');
define('_MI_SOCIALNET_PICTURE_TEMPLATEINDEXDESC', 'This template shows the pictures of the user');
define('_MI_SOCIALNET_PICTURE_TEMPLATEFRIENDSDESC', 'This template shows the friends of the user');
define('_MI_SOCIALNET_PICTURE_TEMPLATESCRAPBOOKDESC', 'Template for the Scrapbook');
define('_MI_SOCIALNET_PICTURE_TEMPLATEAUDIODESC', 'Template of audios page');
define('_MI_SOCIALNET_PICTURE_TEMPLATEYOUTUBEDESC', 'Template for the videos section');
define('_MI_SOCIALNET_PICTURE_TEMPLATEALBUMDESC', 'Template for the picture gallery');
define('_MI_SOCIALNET_PICTURE_TEMPLATEGROUPSDESC', 'Template for the Groups');
define('_MI_SOCIALNET_PICTURE_TEMPLATECONFIGSDESC', 'Template settings for the user');
define('_MI_SOCIALNET_PICTURE_TEMPLATEFOOTERDESC', 'Template for the footer of the module');
define('_MI_SOCIALNET_PICTURE_TEMPLATEEDITGROUP', 'Template for the Groups page attributes');
define('_MI_SOCIALNET_PICTURE_TEMPLATESEARCHRESULTDESC', 'This template shows the results of a search for communities');
define('_MI_SOCIALNET_PICTURE_TEMPLATEGROUPDESC', 'This template shows a Group and its members');
define('_MI_SOCIALNET_PICTURE_TEMPLATESEARCHRESULTSDESC', 'Template for the search results');
define('_MI_SOCIALNET_PICTURE_TEMPLATESEARCHFORMDESC', 'Template for the search form');
define('_MI_SOCIALNET_PICTURE_TEMPLATENOTIFICATIONS', 'Template for the notifications');
define('_MI_SOCIALNET_PICTURE_TEMPLATEFANS', 'Template for the fans page');
define('_MI_SOCIALNET_USERPAGE_TEMPLATEUSERPAGE', 'Template Show and edit a user page and show a list of all pages');
define('_MI_SOCIALNET_RSS_TEMPLATERSS', 'Template RSS Feed');
define('_MI_SOCIALNET_USERPAGE_TEMPLATEEDIT', 'Template Form used to edit a user\'s page');
define('_MI_SOCIALNET_USERPAGE_TEMPLATELIST', 'Template Show a list of user\'s page');
define('_MI_SOCIALNET_TREEMENU_TEMPLATEMENU_DESC', 'Template Show a Page layout in tree menu');
define('_MI_SOCIALNET_POPCHAT_TEMPLATECHATDESC', 'Template Show a Popup Chat');
//END Templates

########### GENERAL CONFIG ##########
//Configs
define('_MI_SOCIALNET_WELCOME_TITLE', 'WELCOME: Greetings from the SocialNet developer module');
define('_MI_SOCIALNET_WELCOME_DESC', '<p style=\'font-weight:bold; color:red; width: 550px\'> I setup this section so that you don\'t have any problem. The module is ready to run, if you have upload images through the Image Manager system. Select the category that you create, otherwise you cannot expose the block images spotlights. Check bellow in the 61-SPOT IMAGES: section. </p> If you didn\'t upload images yet, make it right now.<b><br /> www.YOUR-SITE/modules/system/admin.php?fct=images</b><br />The other configurations are ready so that the module can runs with success. <br /><b> Regards David Yanez Osses</b>');
define('_MI_SOCIALNET_ENABLEPICT_TITLE', '1-PHOTOS: Enable pictures section');
define('_MI_SOCIALNET_ENABLEPICT_DESC', 'Enabling the pictures section for the users, will enable the pictures gallery');
define('_MI_SOCIALNET_NUMBPICT_TITLE', '2-PHOTOS: Number of Pictures');
define('_MI_SOCIALNET_NUMBPICT_DESC', 'Number of pictures a user can have in their page');
define('_MI_SOCIALNET_PATHUPLOAD_TITLE', '3-PHOTOS: Path for Uploads Pictures and mp3');
define('_MI_SOCIALNET_PATHUPLOAD_DESC', 'Path to the uploads directory <br /> in Linux it should look like this /var/www/uploads<br />in Windows like this C:/Program Files/www');
define('_MI_SOCIALNET_LINKPATHUPLOAD_TITLE', '4-PHOTOS: Link to your uploads directory');
define('_MI_SOCIALNET_LINKPATHUPLOAD_DESC', 'This is the address of the root path to uploads <br /> like www.yoursite.com/uploads');
define('_MI_SOCIALNET_THUMW_TITLE', '5-PHOTOS: Thumb Width');
define('_MI_SOCIALNET_THUMBW_DESC', 'Thumbnails width in pixels. This means your picture thumbnail will be most of this size in width.<br /> All proportions are maintained');
define('_MI_SOCIALNET_THUMBH_TITLE', '6-PHOTOS: Thumb Height');
define('_MI_SOCIALNET_THUMBH_DESC', 'Thumbnails Height in pixels. This means your picture thumbnail will be most of this size in height<br />All proportions are maintained');
define('_MI_SOCIALNET_RESIZEDW_TITLE', '7-PHOTOS: Resized picture width');
define('_MI_SOCIALNET_RESIZEDW_DESC', 'Resized picture width in pixels. This means your picture will be most of this size in width. All proportions are maintained. The original picture if bigger than this size will <br /> be resized, so it wont break your template');
define('_MI_SOCIALNET_RESIZEDH_TITLE', '8-PHOTOS: Resized picture height');
define('_MI_SOCIALNET_RESIZEDH_DESC', 'Resized picture height in pixels. This means your picture will be most of this size in height. All proportions are maintained. The original picture if bigger than this size will <br />be resized, so it wont break your template design');
define('_MI_SOCIALNET_ORIGINALW_TITLE', '9-PHOTOS: Max original picture width');
define('_MI_SOCIALNET_ORIGINALW_DESC', 'Maximum original picture width in pixels<br /> This means the user\'s original picture can\'t exceed <br />this size in height <br /> else it won\'t be uploaded');
define('_MI_SOCIALNET_ORIGINALH_TITLE', '10-PHOTOS: Max original picture height');
define('_MI_SOCIALNET_ORIGINALH_DESC', 'Maximum original picture height in pixels <br /> This means the user\'s original picture can\'t exceed <br />this size in height <br /> else it won\'t be uploaded');
define('_MI_SOCIALNET_PICTURESPERPAGE_TITLE', '11-PHOTOS: Pictures showing per page');
define('_MI_SOCIALNET_PICTURESPERPAGE_DESC', 'Pictures showing per page before pagination');
define('_MI_SOCIALNET_DELETEPHYSICAL_TITLE', '12-PHOTOS: Delete files from the upload folder to');
define('_MI_SOCIALNET_DELETEPHYSICAL_DESC', 'Confirming yes here, will allow the script to delete the files from the uploaded data in the database as well.<br /> Be careful about this feature, if you exclude the files from the folder and not only in the database, some people who may have linked to the image directly in another part of the site may also lose their content; <br /> at the same time if you don\'t exclude them, you may use to much space in the server hard disk.<br /> Configure this item well for your needs.');
define('_MI_SOCIALNET_IMGORDER_TITLE', '13-PHOTOS: Pictures Order');
define('_MI_SOCIALNET_IMGORDER_DESC', 'Show the newest pictures first?');
//Friends Configs
define('_MI_SOCIALNET_ENABLEFRIENDS_TITLE', '14-FRIENDS: Enable friends section');
define('_MI_SOCIALNET_ENABLEFRIENDS_DESC', 'Enabling friends section for the users, will enable friends agenda');
define('_MI_SOCIALNET_FRIENDSPERPAGE_TITLE', '15-FRIENDS: Friends per page');
define('_MI_SOCIALNET_FRIENDSPERPAGE_DESC', 'Set the number of friends to show per page <br /> In the my Friends page');
//Audio Configs
define('_MI_SOCIALNET_ENABLEAUDIO_TITLE', '16-AUDIO: Enable audio section');
define('_MI_SOCIALNET_ENABLEAUDIO_DESC', 'Enabling audio section for the users, will enable the audio play list');
define('_MI_SOCIALNET_NUMBAUDIO_TITLE', '17-AUDIO: Max number of audio');
define('_MI_SOCIALNET_NUMBAUDIO_DESC', 'Max number of audio for a user');
define('_MI_SOCIALNET_AUDIOSPERPAGE_TITLE', '18-AUDIO: Number of mp3 files');
define('_MI_SOCIALNET_AUDIOSPERPAGE_DESC', 'Number of mp3 files per page');
define('_MI_SOCIALNET_MAXFILEBYTES_TITLE', '19-AUDIO: Max size in bytes');
define('_MI_SOCIALNET_MAXFILEBYTES_DESC', 'This is the maximum size of the mp3 file can be upload, <br /> Defaulted is setup to 6000000 <br /> You can set it in bytes like this: 512000 for 500 KB<br /> Be careful that the maximum size is also set in the php.ini file.');
//Video Configs
define('_MI_SOCIALNET_ENABLEVIDEOS_TITLE', '20-VIDEO: Enable videos section');
define('_MI_SOCIALNET_ENABLEVIDEOS_DESC', 'Enabling videos section for the users, will enable the video gallery');
define('_MI_SOCIALNET_VIDEOSPERPAGE_TITLE', '21-VIDEO: Videos per Page');
define('_MI_SOCIALNET_VIDEOSPERPAGE_DESC', 'Videos per Page');
define('_MI_SOCIALNET_TUBEW_TITLE', '22-VIDEO: Width of the You Tube videos');
define('_MI_SOCIALNET_TUBEW_DESC', 'The width in pixels of the You Tube video player');
define('_MI_SOCIALNET_TUBEH_TITLE', '23-VIDEO: Height of the You Tube videos');
define('_MI_SOCIALNET_TUBEH_DESC', 'The height in pixels of the You Tube video player');
define('_MI_SOCIALNET_MAINTUBEW_TITLE', '24-VIDEO: Main Video width');
define('_MI_SOCIALNET_MAINTUBEW_DESC', 'Width of the video, which shows in the front page of the module');
define('_MI_SOCIALNET_MAINTUBEH_TITLE', '25-VIDEO: Main Video height');
define('_MI_SOCIALNET_MAINTUBEH_DESC', 'Height of the video, that shows in the front page of the module');
//Groups Configs
define('_MI_SOCIALNET_ENABLEGROUPS_TITLE', '26-GROUPS: Enable Groups section');
define('_MI_SOCIALNET_ENABLEGROUPS_DESC', 'Enabling Groups section for the users, will enable them to create Groups, which group users that have similar interests');
define('_MI_SOCIALNET_GROUPSPERPAGE_TITLE', '27-GROUPS: Groups per page');
define('_MI_SOCIALNET_GROUPSPERPAGE_DESC', 'Groups per page before pagination show up');
//Notes Configs
define('_MI_SOCIALNET_ENABLESCRAPS_TITLE', '28-NOTE: Enable Scraps section');
define('_MI_SOCIALNET_ENABLESCRAPS_DESC', 'Enabling Scraps section, will enable members to leave public messages to other users. This feature is like the Wall on Facebook');
define('_MI_SOCIALNET_SCRAPSPERPAGE_TITLE', '29-NOTE: Number of Scraps per page');
define('_MI_SOCIALNET_SCRAPSPERPAGE_DESC', 'Number of Scraps in a page before the page navigation shows ');
//Membership Configs
define('_MI_SOCIALNET_MPAGE', '30-MEMBERS: Member per page');
define('_MI_SOCIALNET_MPAGE_DSC', 'How many members will we show per page?');
define('_MI_SOCIALNET_DAVATAR', '31-MEMBERS: Use a default avatar?');
define('_MI_SOCIALNET_DAVATAR_DSC', 'If yes then a default avatar will be used for users that don\'t have an avatar<br />The default avatar must be in socialnet/images/profile/noavatar.gif');
// User Page Configs
define('_MI_SOCIALNET_OPT0', '32-BLOG: Enable html ?');
define('_MI_SOCIALNET_OPT0_DSC', 'Select if users can use html');
define('_MI_SOCIALNET_OPT1', '33-BLOG: Enable RSS Feed ?');
define('_MI_SOCIALNET_OPT1_DSC', 'Select if users can use RSS Feed');
define('_MI_SOCIALNET_OPT3', '34-BLOG: Date\'s format');
define('_MI_SOCIALNET_OPT3_DSC', 'See the www.php.net/manual/en/function.date.php <br /> If you don\'t specify anything then the default date\'s format will be used');
define('_MI_SOCIALNET_OPT4', '35-BLOG: Number of characters to display in RSS Feed ?');
define('_MI_SOCIALNET_OPT4_DSC', 'Select the number of visible characters in the RSS Feed');
define('_MI_SOCIALNET_OPT5', '36-BLOG: Number of lines per page (in the pages listing)');
define('_MI_SOCIALNET_OPT5_DSC', 'Select the number of lines in the user side');
define('_MI_SOCIALNET_OPT6', '37-BLOG: Editor to use ?');
define('_MI_SOCIALNET_OPT6_DSC', 'Select the editor to use and if necessary, don\'t forget to set the first option (Enable html) to true');
define('_MI_SOCIALNET_FORM_DHTML', 'DHTML');
define('_MI_SOCIALNET_FORM_COMPACT', 'Compact');
define('_MI_SOCIALNET_FORM_SPAW', 'Spaw Editor');
define('_MI_SOCIALNET_FORM_HTMLAREA', 'HtmlArea Editor');
define('_MI_SOCIALNET_FORM_FCK', 'FCK Editor');
define('_MI_SOCIALNET_FORM_KOIVI', 'Koivi Editor');
define('_MI_SOCIALNET_FORM_TINYEDITOR', 'TinyEditor');
define('_MI_SOCIALNET_URL_REWRITING', '38-BLOG: Use URL Rewriting?');
// BEGIN IN NEWS SECTION Title of config items
define('_MI_SOCIALNET_STORYHOME', '39-NEWS: Select the number of articles to display on top page');
define('_MI_SOCIALNET_STORYHOMEDSC', 'This controls how many items will be displayed on the top page (i.e. when no topic is selected)');
define('_MI_SOCIALNET_STORYCOUNTADMIN', '40-NEWS: Number of new articles to display in admin area: ');
define('_MI_SOCIALNET_STORYCOUNTTOPIC', '41-NEWS: Select the number of articles to display on a topics');
define('_MI_SOCIALNET_STORYCOUNTTOPIC_DESC', 'This controls how many items will be displayed on a topic page (i.e. not front page)');
define('_MI_SOCIALNET_MAXITEMS', '42-NEWS: Maximum allowed items');
define('_MI_SOCIALNET_MAXITEMDESC', 'This sets the maximum number of items, a user can select in the navigation box on index or topic pages');
define('_MI_SOCIALNET_SPOTLIGHT_ITEMS', '43-NEWS: Spotlight Article Candidates');
define('_MI_SOCIALNET_DISPLAYNAV', '44-NEWS: Select yes to display navigation box at the top of each module page');
define('_MI_SOCIALNET_AUTOAPPROVE', '45-NEWS: Auto approve articles without admin intervention?');
define('_MI_SOCIALNET_UPLOADGROUPS', '46-NEWS: Authorized groups to upload');
define('_MI_SOCIALNET_UPLOADGROUPS_DESC', 'Select the groups who can upload to the server');
define('_MI_SOCIALNET_UPLOADFILESIZE', '47-NEWS: MAX File size Upload (KB) 1048576 = 1 Meg');
// News Editor section
define('_MI_SOCIALNET_EDITOR', '48-NEWS: Editor');
define('_MI_SOCIALNET_EDITOR_DESC', 'Choose the editor to use in the submit form - non-default editors MUST be separately installed');
define('_MI_SOCIALNET_EDITOR_DEFAULT', 'Xoops Default');
define('_MI_SOCIALNET_EDITOR_DHTML', 'DHTML');
define('_MI_SOCIALNET_EDITOR_HTMLAREA', 'HtmlArea Editor');
define('_MI_SOCIALNET_EDITOR_FCK', 'FCK WYSIWYG Editor');
define('_MI_SOCIALNET_EDITOR_KOIVI', 'Koivi WYSIWYG Editor');
define('_MI_SOCIALNET_EDITOR_TINYMCE', 'TinyMCE WYSIWYG Editor');
define('_MI_SOCIALNET_EDITOR_USER_CHOICE', '49-NEWS: Enable Editor Choice To User');
define('_MI_SOCIALNET_EDITOR_USER_CHOICE_DESC', 'Enable user to choose which editor they want');
define('_MI_SOCIALNET_EDITOR_CHOICE', '50-NEWS: Editor Choices');
define('_MI_SOCIALNET_EDITOR_CHOICE_DESC', 'Choices of editors enabled to user');
// End News Editor section
define('_MI_SOCIALNET_NEWSDISPLAY', '51-NEWS: Article Display Layout');
define('_MI_SOCIALNET_NEWSDISPLAYDESC', 'Classic shows all articles ordered by date of publish. Articles by topic will group the articles by topic with the latest article in full and the others with just the title');
define('_MI_SOCIALNET_AUTHORDISPLAY', '52-NEWS: Author\'s name');
define('_MI_SOCIALNET_ADISPLAYNAMEDSC', 'Select how to display the author\'s');
define('_MI_SOCIALNET_DISPLAYNAME1', 'User name');
define('_MI_SOCIALNET_DISPLAYNAME2', 'Real name');
define('_MI_SOCIALNET_COLUMNMODE', '53-NEWS: Columns');
define('_MI_SOCIALNET_COLUMNMODE_DESC', 'You can choose the number of columns to display articles list');
define('_MI_SOCIALNET_RESTRICTINDEX', '54-NEWS: Restrict Topics on Index Page?');
define('_MI_SOCIALNET_RESTRICTINDEXDSC', 'If set to yes, users will only see articles listed in the index from the topics, they have access to as set in Article Permissions');
define('_MI_SOCIALNET_ANONYMOUS_VOTE', '55-NEWS: Enable Anonymous Rating of Articles');
define('_MI_SOCIALNET_ANONYMOUS_VOTE_DESC', 'If enabled, anonymous users can rate articles');
define('_MI_SOCIALNET_INDEX_NAME', '56-NEWS: Name of Index');
define('_MI_SOCIALNET_INDEX_DESC', 'This will be displayed as the top-level link in the breadcrumbs in topic and article view');
// Description of each config items
define('_MI_SOCIALNET_DISPLAYNAVDSC', 'Display navigation');
define('_MI_SOCIALNET_AUTOAPPROVEDSC', 'Auto Approve');
define('_MI_SOCIALNET_ALLOWEDSUBMITGROUPSDESC', 'The selected groups will be able to submit articles');
define('_MI_SOCIALNET_ALLOWEDAPPROVEGROUPSDESC', 'The selected groups will be able to approve articles');
define('_MI_SOCIALNET_STORYCOUNTADMIN_DESC', 'Story count admin');
define('_MI_SOCIALNET_UPLOADFILESIZE_DESC', 'max upload size');
// Name of config item values
define('_MI_SOCIALNET_NEWSCLASSIC', 'Classic');
define('_MI_SOCIALNET_NEWSBYTOPIC', 'By Topic');
define('_MI_SOCIALNET_DISPLAYNAME3', 'Do not display author');
define('_MI_SOCIALNET_UPLOAD_GROUP1', 'Submitters and Approvers');
define('_MI_SOCIALNET_UPLOAD_GROUP2', 'Approvers Only');
define('_MI_SOCIALNET_UPLOAD_GROUP3', 'Upload Disabled');
// END NEWS CONFIG

// socialnet/xoops_version.php configuration for spot-image
define('_MI_SOCIALNET_BLOCK1', 'SPOT: Images Spotlights');
define('_MI_SOCIALNET_BLOCK1_DESC', 'Block to show spotlights');
define('_MI_SOCIALNET_BLOCK1_FILE', 'socialnet_spot.php');
define('_MI_SOCIALNET_BLOCK1_SHOW', 'socialnet_spot_show');
define('_MI_SOCIALNET_BLOCK1_EDIT', 'socialnet_spot_edit');
define('_MI_SOCIALNET_BLOCK1_TEMPLATE', 'socialnet_block_spot.html');
########### ADMIN NOTE ##########
// Admin Notes
define('_MI_SOCIALNET_MSGADMINTITLE', '57-ADMIN NOTE: Note Number');
define('_MI_SOCIALNET_MSGADMINTITLEDESC', 'The Number of Messages in admin Page');
define('_MI_SOCIALNET_ADMIN_MSGWIDTH', '58-ADMIN NOTE: Note Length');
define('_MI_SOCIALNET_ADMIN_MSGWIDTHDSC', 'The Max length of the admin Note');
########### ADMIN ACTIVE ALL USERS ##########
// admin/activeall_user.php configuration
define('_MI_SOCIALNET_ACTIVEID', '59-ACTIVATE USER: User ID');
define('_MI_SOCIALNET_ACTIVEIDDSC', 'Show User ID Field');
define('_MI_SOCIALNET_USERPERPAGE', '60-ACTIVATE NEW USERS: Portal or Website Users ');
define('_MI_SOCIALNET_USERPERPAGEDSC', 'Number of Non-Active new website users in each page');
########### SPOT IMAGES ##########
define('_MI_SOCIALNET_DSTAC_IMG', '61-SPOT IMAGES: Spotlights Images');
define('_MI_SOCIALNET_DSTAC_IMG_DES', 'Select the image libraries that will keep the spotlights images.<br />Select using the <b>CTRL</b>.<p style=\'font-weight:bold; color:red; width: 550px\'>If you added some images library after the installation of this module, update it so the added category will appears to the side.</p>');
//END GENERAL CONFIG

########### TREE MENU ##############
//Module Paths for tree-menu
define('_MI_SOCIALNET_HIGHLIGHT_SEARCH', '<b style=\'color: red\'> The following search terms were highlighted: </b> ');
define('_MI_SOCIALNET_HOME_ID', '62-TREE: Main Page ID');
define('_MI_SOCIALNET_HOME_ID_DESC', 'Enter the Page ID that will open as the default page when entering the module. Leave it blank so that the last inserted page becomes the main page.');
define('_MI_SOCIALNET_MIMETYPES', '63-TREE: Allowed extensions in the file manager.');
define('_MI_SOCIALNET_MIMETYPES_DESC', 'Select the allowed extensions for upload in the file manager. Keep the <b> CTRL </b> key pressed to select more than one option.');
define('_MI_SOCIALNET_CONTENTMIMES', '64-TREE: Allowed extensions in the content file manager.');
define('_MI_SOCIALNET_CONTENTMIMES_DESC', 'Select the allowed extensions for upload in the content file manager. Keep the <b> CTRL </b> key pressed to select more than one option.');
define('_MI_SOCIALNET_MAXFILESIZE', '65-TREE: Maximum size for sending files.');
define('_MI_SOCIALNET_MAXFILESIZE_DESC', 'Values in Kbytes');
define('_MI_SOCIALNET_MMAXFILESIZE', '66-TREE: Maximum size for sending medias.');
define('_MI_SOCIALNET_MMAXFILESIZE_DESC', 'Values in Kbytes');
define('_MI_SOCIALNET_NAMES_ID', '67-TREE: Use text instead of the ID in the URL?');
define('_MI_SOCIALNET_NAMES_ID_DESC', 'By choosing Yes the menu text will be used instead of the ID in the URL\'s content. The system accepts both as default to load a page. This setup will only affect the links generated by the system.');
define('_MI_SOCIALNET_IFRAME_WIDTH', '68-TREE: IFrames width');
define('_MI_SOCIALNET_IFRAME_WIDTH_DESC', 'Define the width (in pixels) to be used with IFrame pages');
define('_MI_SOCIALNET_IFRAME_HEIGHT', '69-TREE: IFrames height');
define('_MI_SOCIALNET_IFRAME_HEIGHT_DESC', 'Define the height (in pixels) to be used with IFrame pages');
define('_MI_SOCIALNET_RELATED', '70-TREE: Show links to related pages at the bottom of each page');
define('_MI_SOCIALNET_RELATED_DESC', 'This option allows to show links to pages that are in the same category that the current page. <br /> You can disable this option if you already use the Related Pages block');
define('_MI_SOCIALNET_CANEDIT', '71-TREE: Can the authors edit their own pages?');
define('_MI_SOCIALNET_CANEDIT_DESC', 'Select yes so that the author can edit their own pages (even not being in the webmaster group ).');
define('_MI_SOCIALNET_CANCREATE', '72-TREE: Can the authors create sub-pages?');
define('_MI_SOCIALNET_CANCREATE_DESC', 'Select yes so that the author can create sub-pages inside their own pages (even not being in the webmaster group).');
define('_MI_SOCIALNET_CANDELETE', '73-TREE: Can the authors delete their own pages?');
define('_MI_SOCIALNET_CANDELETE_DESC', 'Select yes so that the author can delete their own pages ( even not being in the webmaster group ) .');
define('_MI_SOCIALNET_SHOWMSG', '74-FORUM: Show private titles and forums ?');
define('_MI_SOCIALNET_SHOWMSGDESC', 'When set to no, users can\'t see forums and posts they don\'t have access to <br /> Warning, if you change for YES everybody will see the private forums.');
define('_MI_SOCIALNET_ATTACH_FILES', '75-FORUM: Mime Types (to attach files or pictures)');
define('_MI_SOCIALNET_ATTACH_HLP', 'Type one mime type per line');
define('_MI_SOCIALNET_UPLSIZE', '76-FORUM: MAX File size Upload (KB) 1048576 = 1 Meg');
define('_MI_SOCIALNET_UPLSIZE_DSC', 'in bytes');
// PATH FOR TREE- MENU
define("SOCIALNET_MEDIA_URL", XOOPS_URL."/uploads/socialnet/media");
define("SOCIALNET_MEDIA_PATH", XOOPS_ROOT_PATH."/uploads/socialnet/media");
define("SOCIALNET_FILES_URL", XOOPS_URL."/uploads/socialnet/files");
define("SOCIALNET_FILES_PATH", XOOPS_ROOT_PATH."/uploads/socialnet/files");
define("SOCIALNET_HTML_URL", XOOPS_URL."/uploads/socialnet/html");
define("SOCIALNET_HTML_PATH", XOOPS_ROOT_PATH."/uploads/socialnet/html");

########### GENERAL ITEMS ############
// Warning note in admin/about.php
define('_MI_WARNING', 'This module comes as is, without any guarantees whatsoever. Although this module is not beta, it is still under active development. This release can be used in a live website or a production environment, but its use is under your own responsibility, which means the author is not responsible.');
// socialnet/contactus.php
define('_MI_CONTACT_NAME', 'Contact Us');
define('_MI_SOCIALNET_CONTACT_DESC', 'To sending messages to the webmaster');
define('_MI_SOCIALNET_POPCHAT_NAME', 'Members POP Chat');
define('_MI_SOCIALNET_POPCHAT_DESC', 'SocialNet Pop Chat');
// Config Forum in xoops_version.php
define('_MI_SOCIALNET_SMNAME1', 'Forum Search');
############ NOTIFICATIONS ##############
//Notification Picture
define('_MI_SOCIALNET_PICTURE_NOTIFYTIT', 'Album');
define('_MI_SOCIALNET_PICTURE_NOTIFYDSC', 'Notifications related to user\'s album');
define('_MI_SOCIALNET_PICTURE_NEWPIC_NOTIFY', 'New Picture');
define('_MI_SOCIALNET_PICTURE_NEWPIC_NOTIFYCAP', 'Tell me when this user submits a new picture');
define('_MI_SOCIALNET_PICTURE_NEWPOST_NOTIFYDSC', 'Tell me when this user submits a new picture');
define('_MI_SOCIALNET_PICTURE_NEWPIC_NOTIFYSBJ', '{X_OWNER_NAME} has submitted a new picture to their album');
//Notification Video
define('_MI_SOCIALNET_VIDEO_NOTIFYTIT', 'Videos');
define('_MI_SOCIALNET_VIDEO_NOTIFYDSC', 'Video notifications');
define('_MI_SOCIALNET_VIDEO_NEWVIDEO_NOTIFY', 'New video');
define('_MI_SOCIALNET_VIDEO_NEWVIDEO_NOTIFYCAP', 'Notify me when a new video is submitted by this user');
define('_MI_SOCIALNET_VIDEO_NEWVIDEO_NOTIFYDSC', 'New video notify description');
define('_MI_SOCIALNET_VIDEO_NEWVIDEO_NOTIFYSBJ', '{X_OWNER_NAME} has submitted a new video to their profile');
//Notification Scraps
define('_MI_SOCIALNET_SCRAP_NOTIFYTIT', 'Scraps');
define('_MI_SOCIALNET_SCRAP_NOTIFYDSC', 'Scrapbook notifications');
define('_MI_SOCIALNET_SCRAP_NEWSCRAP_NOTIFY', 'New scrap');
define('_MI_SOCIALNET_SCRAP_NEWSCRAP_NOTIFYCAP', 'Notify me when a new Scrap is sent to this Scrapbook');
define('_MI_SOCIALNET_SCRAP_NEWSCRAP_NOTIFYDSC', 'New scrap notification description');
define('_MI_SOCIALNET_SCRAP_NEWSCRAP_NOTIFYSBJ', '{X_OWNER_NAME} has received a new Scrap into their Scrapbook');
//Notification Friendships
define('_MI_SOCIALNET_FRIENDSHIP_NOTIFYTIT', 'Friendships');
define('_MI_SOCIALNET_FRIENDSHIP_NOTIFYDSC', 'Petitions of friendship');
define('_MI_SOCIALNET_FRIEND_NEWPETITION_NOTIFY', 'Petition');
define('_MI_SOCIALNET_FRIEND_NEWPETITION_NOTIFYCAP', 'Notify me when someone ask for friendship');
define('_MI_SOCIALNET_FRIEND_NEWPETITION_NOTIFYDSC', 'Notify me when someone ask for friendship');
define('_MI_SOCIALNET_FRIEND_NEWPETITION_NOTIFYSBJ', 'Someone has just asked to be your friend');
// Notification from NEWS
define('_MI_SOCIALNET_NEWS_GLOBAL_NOTIFY', 'Global');
define('_MI_SOCIALNET_NEWS_GLOBAL_NOTIFYDSC', 'Global news notification options.');
define('_MI_SOCIALNET_NEWS_STORY_NOTIFY', 'Story');
define('_MI_SOCIALNET_NEWS_STORY_NOTIFYDSC', 'Notification options that apply to the current story.');
define('_MI_SOCIALNET_NEWS_GLOBAL_NEWCATEGORY_NOTIFY', 'New Topic');
define('_MI_SOCIALNET_NEWS_GLOBAL_NEWCATEGORY_NOTIFYCAP', 'Notify me when a new topic is created.');
define('_MI_SOCIALNET_NEWS_GLOBAL_NEWCATEGORY_NOTIFYDSC', 'Receive notification when a new topic is created.');
define('_MI_SOCIALNET_NEWS_GLOBAL_NEWCATEGORY_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New news topic');
define('_MI_SOCIALNET_NEWS_GLOBAL_STORYSUBMIT_NOTIFY', 'New Story Submitted');
define('_MI_SOCIALNET_NEWS_GLOBAL_STORYSUBMIT_NOTIFYCAP', 'Notify me when any new article is submitted (awaiting approval).');
define('_MI_SOCIALNET_NEWS_GLOBAL_STORYSUBMIT_NOTIFYDSC', 'Receive notification when any new article is submitted (awaiting approval).');
define('_MI_SOCIALNET_NEWS_GLOBAL_STORYSUBMIT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New article submitted');
define('_MI_SOCIALNET_NEWS_GLOBAL_NEWSTORY_NOTIFY', 'New Story');
define('_MI_SOCIALNET_NEWS_GLOBAL_NEWSTORY_NOTIFYCAP', 'Notify me when any new article is posted.');
define('_MI_SOCIALNET_NEWS_GLOBAL_NEWSTORY_NOTIFYDSC', 'Receive notification when any new article is posted.');
define('_MI_SOCIALNET_NEWS_GLOBAL_NEWSTORY_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New Article');
define('_MI_SOCIALNET_NEWS_STORY_APPROVE_NOTIFY', 'Story Approved');
define('_MI_SOCIALNET_NEWS_STORY_APPROVE_NOTIFYCAP', 'Notify me when this story is approved.');
define('_MI_SOCIALNET_NEWS_STORY_APPROVE_NOTIFYDSC', 'Receive notification when this article is approved.');
define('_MI_SOCIALNET_NEWS_STORY_APPROVE_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Article Approved');
// Notifcation Forum
define('_MI_SOCIALNET_THREAD_NOTIFY', 'Thread');
define('_MI_SOCIALNET_THREAD_NOTIFYDSC', 'Notification options that apply to the current thread.');
define('_MI_SOCIALNET_FORUM_NOTIFY', 'Forum');
define('_MI_SOCIALNET_FORUM_NOTIFYDSC', 'Notification options that apply to the current forum.');
define('_MI_SOCIALNET_GLOBAL_NOTIFY', 'Global');
define('_MI_SOCIALNET_GLOBAL_NOTIFYDSC', 'Global forum notification options.');
define('_MI_SOCIALNET_THREAD_NEWPOST_NOTIFY', 'New Post');
define('_MI_SOCIALNET_THREAD_NEWPOST_NOTIFYCAP', 'Notify me of new posts in the current thread.');
define('_MI_SOCIALNET_THREAD_NEWPOST_NOTIFYDSC', 'Receive notification when a new message is posted to the current thread.');
define('_MI_SOCIALNET_THREAD_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New post in thread');
define('_MI_SOCIALNET_FORUM_NEWTHREAD_NOTIFY', 'New Thread');
define('_MI_SOCIALNET_FORUM_NEWTHREAD_NOTIFYCAP', 'Notify me of new topics in the current forum.');
define('_MI_SOCIALNET_FORUM_NEWTHREAD_NOTIFYDSC', 'Receive notification when a new thread is started in the current forum.');
define('_MI_SOCIALNET_FORUM_NEWTHREAD_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New thread in forum');
define('_MI_SOCIALNET_GLOBAL_NEWFORUM_NOTIFY', 'New Forum');
define('_MI_SOCIALNET_GLOBAL_NEWFORUM_NOTIFYCAP', 'Notify me when a new forum is created.');
define('_MI_SOCIALNET_GLOBAL_NEWFORUM_NOTIFYDSC', 'Receive notification when a new forum is created.');
define('_MI_SOCIALNET_GLOBAL_NEWFORUM_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New forum');
define('_MI_SOCIALNET_GLOBAL_NEWPOST_NOTIFY', 'New Post');
define('_MI_SOCIALNET_GLOBAL_NEWPOST_NOTIFYCAP', 'Notify me of any new posts.');
define('_MI_SOCIALNET_GLOBAL_NEWPOST_NOTIFYDSC', 'Receive notification when any new message is posted.');
define('_MI_SOCIALNET_GLOBAL_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New post');
define('_MI_SOCIALNET_FORUM_NEWPOST_NOTIFY', 'New Post');
define('_MI_SOCIALNET_FORUM_NEWPOST_NOTIFYCAP', 'Notify me of any new posts in the current forum.');
define('_MI_SOCIALNET_FORUM_NEWPOST_NOTIFYDSC', 'Receive notification when any new message is posted in the current forum.');
define('_MI_SOCIALNET_FORUM_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New post in forum');
define('_MI_SOCIALNET_GLOBAL_NEWFULLPOST_NOTIFY', 'New Post (Full Text)');
define('_MI_SOCIALNET_GLOBAL_NEWFULLPOST_NOTIFYCAP', 'Notify me of any new posts (include full text in message).');
define('_MI_SOCIALNET_GLOBAL_NEWFULLPOST_NOTIFYDSC', 'Receive full text notification when any new message is posted.');
define('_MI_SOCIALNET_GLOBAL_NEWFULLPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New post (full text)');
?>
