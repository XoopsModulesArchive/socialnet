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

//index.php
define('_AM_SOCIALNET_403', 'You are not allowed to view this page!');
define('_AM_SOCIALNET_SUCESS', 'Information updated!');
define('_AM_SOCIALNET_FRAMEWORKSFALSE', 'You need to install this package, in order to make this module work correctly: <br /> Frameworks v 1.1 or newer <br />');
define('_AM_SOCIALNET_FRAMEWORKSTRUE', 'You have version %s of the Frameworks package');
define('_AM_SOCIALNET_CONFIGEVERYTHING', 'Make sure you\'ve configured everything under the preferences tab ');
define('_AM_SOCIALNET_ALLTESTSOK', 'All tests must be OK for this module to work 100%:');
define('_AM_SOCIALNET_GDEXTENSIONOK', 'GD extension loaded: OK!');
define('_AM_SOCIALNET_MOREINFO', 'Here is more info on:');
define('_AM_SOCIALNET_GDEXTENSIONFALSE', 'GD extension loaded: FAILED ');
define('_AM_SOCIALNET_CONFIGPHPINI', 'Configure your php.ini or ask your server manager to install it and enable it for you.');
define('_AM_SOCIALNET_PHP5PRESENT', 'You have a compatible version of PHP:');
define('_AM_SOCIALNET_PHP5NOTPRESENT', 'Your PUP version is compatible, but many details would work better on a php5 server and above.');
define('_AM_SOCIALNET_MAXBYTESPHPINI', 'Your server limits the size of uploads to %s');
define('_AM_SOCIALNET_MEMORYLIMIT', 'The Memory Limit of your server is:');
define('_AM_SOCIALNET_WELCOME', 'Welcome to SocialNet 2010');
define('_AM_SOCIALNET_PREFERENCES', 'Preferences');
define('_AM_SOCIALNET_GOMOD', 'Go to module');
define('_AM_SOCIALNET_HELPCREDIT', 'Help and Credit');
define('_AM_SOCIALNET_UPDATE', 'SocialNet Update');
define('_AM_SOCIALNET_MODADMIN', 'Module Administration');
//User Page
define('_AM_SOCIALNET_STATS', 'there are  %u page (s) on your site');
// NEWS SETUP
define('_AM_SOCIALNET_NEWSUB', 'New Submissions');
define('_AM_SOCIALNET_TITLE', 'Title');
define('_AM_SOCIALNET_POSTED', 'Posted');
define('_AM_SOCIALNET_POSTER', 'Poster');
define('_AM_SOCIALNET_ACTION', 'Action');
define('_AM_SOCIALNET_DELETE', 'Delete');
define('_AM_SOCIALNET_PUBLISHEDARTICLES', 'Published Articles');
define('_AM_SOCIALNET_SORT', 'Sort');
define('_AM_SOCIALNET_STORYID', 'Story ID');
define('_AM_SOCIALNET_VERSION', 'Version');
define('_AM_SOCIALNET_VERSIONCOUNT', 'Versions');
define('_AM_SOCIALNET_TOPIC', 'Topic');
define('_AM_SOCIALNET_PUBLISHED', 'Published');
define('_AM_SOCIALNET_HITS', 'Hits');
define('_AM_SOCIALNET_RATING', 'Rating');
define('_AM_SOCIALNET_COMMENTS', 'Comments');
define('_AM_SOCIALNET_EDIT', 'Edit');
define('_AM_SOCIALNET_TOPICSMNGR', 'Topics Manager');
define('_AM_SOCIALNET_OF', 'of');
define('_AM_SOCIALNET_TOPICNAME', 'Topic Name');
define('_AM_SOCIALNET_PARENTTOPIC', 'Parent Topic');
define('_AM_SOCIALNET_WEIGHT', 'Weight');
define('_AM_SOCIALNET_SUBMIT', 'Submit');
define('_AM_SOCIALNET_MODIFY', 'Modify');
define('_AM_SOCIALNET_MODIFYTOPIC', 'Modify Topic');
define('_AM_SOCIALNET_ADD_TOPIC', 'Add a topic');
define('_AM_SOCIALNET_MAX40CHAR', '(max: 40 characters)');
define('_AM_SOCIALNET_TOPICIMG', 'Topic Image');
define('_AM_SOCIALNET_IMGNAEXLOC', 'image name + extension located in %s');
define('_AM_SOCIALNET_TOPIC_PICTURE', 'Upload picture');
define('_AM_SOCIALNET_LINKEDFORUM', 'Linked Forum');
define('_AM_SOCIALNET_TOPICBANNER', 'Banner');
define('_AM_SOCIALNET_BANNERINHERIT', 'Inherit from parent');
define('_AM_SOCIALNET_APPROVEFORM', 'Approve Permissions');
define('_AM_SOCIALNET_APPROVEFORM_DESC', 'Select, who can approve articles');
define('_AM_SOCIALNET_SUBMITFORM', 'Submit Permissions');
define('_AM_SOCIALNET_SUBMITFORM_DESC', 'Select, who can submit articles');
define('_AM_SOCIALNET_VIEWFORM', 'View Permissions');
define('_AM_SOCIALNET_VIEWFORM_DESC', 'Select, who can view which topics');
define('_AM_SOCIALNET_ADD_TOPIC_ERROR1', 'ERROR: Cannot select this topic for parent topic!');
define('_AM_SOCIALNET_ERRORTOPICNAME', 'You must enter a topic name!');
define('_AM_SOCIALNET_UPLOAD_ERROR', 'Error while uploading the file');
define('_AM_SOCIALNET_DBUPDATED', 'Database Updated Successfully!');
define('_AM_SOCIALNET_NOTOPICSELECTED', 'No Topic Selected');
define('_AM_SOCIALNET_CONFIG', 'SOCIALNET Configuration');
define('_AM_SOCIALNET_WAYSYWTDTTAL', 'WARNING: Are you sure you want to delete this Topic and ALL its Stories and Comments?');
define('_AM_SOCIALNET_ADD_TOPIC_ERROR', 'Error, topic already exists!');
define('_AM_SOCIALNET_MANAGEAUDIENCES', 'Manage Audience Levels');
define('_AM_SOCIALNET_AUDIENCENAME', 'Audience Name');
define('_AM_SOCIALNET_ACCESSRIGHTS', 'Access Rights');
define('_AM_SOCIALNET_SAVE', 'Save');
define('_AM_SOCIALNET_EMPTYNODELETE', 'Nothing to delete!');
define('_AM_SOCIALNET_RUSUREDEL', 'Are you sure you want to delete this article and all its comments?');
define('_AM_SOCIALNET_CANNOTDELETEDEFAULTAUDIENCE', 'Error - Cannot delete default audience');
define('_AM_SOCIALNET_AUDIENCEHASSTORIES', '%u articles have this audience, please select a new audience level for these articles');
define('_AM_SOCIALNET_RUSUREDELAUDIENCE', 'Are you sure you want to delete this audience level completely?');
define('_AM_SOCIALNET_PLEASESELECTNEWAUDIENCE', 'Please Select Replacement Audience Level');
define('_AM_SOCIALNET_AUDIENCEDELETED', 'Audience Deleted Successfully');
define('_AM_SOCIALNET_ERROR_AUDIENCENOTDELETED', 'Error - Audience NOT deleted');
define('_AM_SOCIALNET_ERROR_REORDERERROR', 'Error - Errors occurred during reordering');
define('_AM_SOCIALNET_REORDERSUCCESSFUL', 'Topics Reordered');
define('_AM_SOCIALNET_UPLOAD_WARNING', '<b> Warning, do not forget to apply write permissions to the following folder : %s </b>');
//BEGIN FILTER PAGE
define('_AM_SOCIALNET_FILTER', 'Filter');
define('_AM_SOCIALNET_SORTING', 'Sorting Options');
define('_AM_SOCIALNET_STATUS', 'Status');
define('_AM_SOCIALNET_EXPIRED', 'Expired');
define('_AM_SOCIALNET_ORDER', 'Order');
///END FILTER PAGE
define('_AM_SOCIALNET_EDITARTICLE', 'Edit Article');
///END NEWS SETUP

//BEGIN ADMIN/SPOTLIGHT.PHP
define('_AM_SOCIALNET_SPOT_ADD', 'Add Spotlight Mini Block');
define('_AM_SOCIALNET_SPOT_EDITBLOCK', 'Edit Block Settings');
define('_AM_SOCIALNET_SPOT_NAME', 'Name');
define('_AM_SOCIALNET_SPOT_IMAGE', 'Image');
define('_AM_SOCIALNET_SPOT_WEIGHT', 'Weight');
define('_AM_SOCIALNET_SPOT_DISPLAY', 'Display');
define('_AM_SOCIALNET_SPOT_SAVESUCCESS', 'Spotlight Successfully Saved');
define('_AM_SOCIALNET_SPOT_DELETESUCCESS', 'Spotlight Successfully Deleted');
define('_AM_SOCIALNET_RUSUREDELSPOTLIGHT', 'Are you sure you want to remove this Spotlight?');
// CLASS/SPOTLIGHT.PHP
define('_AM_SOCIALNET_SPOTLIGHT', 'Spotlight');
define('_AM_SOCIALNET_SPOT_LATESTARTICLE', 'Latest Article');
define('_AM_SOCIALNET_SPOT_LATESTINTOPIC', 'Latest in Topic');
define('_AM_SOCIALNET_SPOT_SPECIFICARTICLE', 'Specific Article');
define('_AM_SOCIALNET_SPOT_CUSTOM', 'Custom');
define('_AM_SOCIALNET_SPOT_TOPIC_DESC', 'If Latest in Topic is selected, which topic should it select from?');
define('_AM_SOCIALNET_ARTICLE', 'Article');
define('_AM_SOCIALNET_SPOT_ARTICLE_DESC', 'If Specific Article is selected, which article should be displayed?');
define('_AM_SOCIALNET_SPOT_MODE_SELECT', 'Spotlight Mode');
define('_AM_SOCIALNET_SPOT_SHOWIMAGE', 'Show Image');
define('_AM_SOCIALNET_SPOT_SHOWIMAGE_DESC', 'Select an image to display or set it to show either topic image or author avatar');
define('_AM_SOCIALNET_SPOT_SPECIFYIMAGE', 'Specify Image');
define('_AM_SOCIALNET_SPOT_TOPICIMAGE', 'Image from Topic');
define('_AM_SOCIALNET_SPOT_AUTHORIMAGE', 'Author Avatar');
define('_AM_SOCIALNET_SPOT_NOIMAGE', 'No Image');
define('_AM_SOCIALNET_SPOT_AUTOTEASER', 'Automatic Teaser');
define('_AM_SOCIALNET_SPOT_TEASER', 'Manual Teaser Text');
define('_AM_SOCIALNET_SPOT_MAXLENGTH', 'Maximum Length of Auto-Teaser');
// END SPOTLIGHT

// BEGIN INCLUDE/STORYFORM.INC.PHP
define('_AM_SOCIALNET_TOPICDISPLAY', 'Display Image?');
define('_AM_SOCIALNET_NONEIMAGE', 'No Image');
define('_AM_SOCIALNET_AUTHOR', 'Author\'s Avatar');
define('_AM_SOCIALNET_TOPICALIGN', 'Position');
define('_AM_SOCIALNET_RIGHT', 'Right');
define('_AM_SOCIALNET_LEFT', 'Left');
define('_AM_SOCIALNET_PUBINHOME', 'Publish in Home?');
define('_AM_SOCIALNET_EXTEXT', 'Extended Text');
define('_AM_SOCIALNET_UPLOAD_ATTACHFILE', 'Attached file (s)');
define('_AM_SOCIALNET_DELETE_SELFILES', 'Delete selected files');
define('_AM_SOCIALNET_SELFILE', 'Select file');
define('_AM_SOCIALNET_APPROVE', 'Approve');
define('_AM_SOCIALNET_SETDATETIME', 'Set the date / time of publish');
define('_AM_SOCIALNET_SETEXPDATETIME', 'Set the date / time of expiration');
define('_AM_SOCIALNET_MULTIPLE_PAGE_GUIDE', 'Type [page break] to split to multiple pages');
// END INCLUDE/STORYFORM.INC.PHP

################# ADMIN NOTES ##############################
// admin/add_note.php
define('_AM_SOCIALNET_AMSGNOTE1', 'Admin Messages to The Visitors..');
define('_AM_SOCIALNET_AMSGDELETE', 'Delete');
define('_AM_SOCIALNET_MSGEDIT', 'Edit');
define('_AM_SOCIALNET_MSGNEXT', 'Next');
define('_AM_SOCIALNET_MSGPRV', 'Previous');
define('_AM_SOCIALNET_MSGBBOCE', 'Highlight the Text Before Wrap it with Code.');
define('_AM_SOCIALNET_MSGNAME', 'Name:');
define('_AM_SOCIALNET_MSGAdmin', 'Admin');
// admin/edit.php
define('_AM_SOCIALNET_MSGNONEEDIT', 'You Did not Select Note to Edit');
define('_AM_SOCIALNET_MSGTHENOTE', 'Note:');
define('_AM_SOCIALNET_MSGSAVE', 'Save');
// admin/note.php
define('_AM_SOCIALNET_MSGNOTALLOWED', 'You Can Not access this Page Directly');
define('_AM_SOCIALNET_MSGNOCOMMENT', 'Please Write A comment Before Posting');
define('_AM_SOCIALNET_MSGLONGCOMMENT', 'The Note is Very Long');
define('_AM_SOCIALNET_MSGCOMMENTADDED', 'Your Note was Added .');
define('_AM_SOCIALNET_MSGCOMMENTERROR', 'There was Some error in your Myself Table , We Could not Update the Tables');
// admin/do_edit.php
define('_AM_SOCIALNET_MSGEDITERROR', 'Can Note Edit the Note , There Something wrong with the Database');
define('_AM_SOCIALNET_MSGEDITEDOK', 'The Database Was Updated....');
// admin/aptimize.php
define('_AM_SOCIALNET_OPTIMIZE_OK', 'OK');
define('_AM_SOCIALNET_OPTIMIZE_ISLAH', 'Repair Tables');
define('_AM_SOCIALNET_OPTIMIZE_TNSHEET', 'Optimize Tables');
define('_AM_SOCIALNET_OPTIMIZE_MYSQL', 'Database Name :');
// admin/activeall_user.php
define('_AM_SOCIALNET_JAVAALERTALLOK', 'Active ALL Members? Ok?');
define('_AM_SOCIALNET_JAVAALERT_CANCEL', 'Canceled..');
define('_AM_SOCIALNET_NONACTIVEUSERS', 'Non-Active Users');
define('_AM_SOCIALNET_USERID', 'User ID');
define('_AM_SOCIALNET_USER', 'User Name  ');
define('_AM_SOCIALNET_USEREMAIL', 'User Email');
define('_AM_SOCIALNET_STATSUSER', 'Stats');
define('_AM_SOCIALNET_APPROVEALL', 'Accept All ');
define('_AM_SOCIALNET_RE_ACTIVE', 'Re-Send Activation Code');
define('_AM_SOCIALNET_JAVAALERTREJECTHIM', 'The User Account will be Removed ...Ok?');
define('_AM_SOCIALNET_DELETHIM', 'Reject User');
define('_AM_SOCIALNET_APPROVEIT', 'Accept');
define('_AM_SOCIALNET_NOUSERSFOUND', 'No Users waiting activation');
// admin/do_active_user.php
define('_AM_SOCIALNET_ERROR', 'Error ! Can not update the Database');
define('_AM_SOCIALNET_OK', 'Database Updated');
define('_AM_SOCIALNET_REDIRECT', 'Taken you Back ...');
// admin/re_active user
define('_AM_SOCIALNET_RE_ACTIVE0', 'Re-Send Activation Code');
define('_AM_SOCIALNET_RE_ACTIVE1', 'User Email');
define('_AM_SOCIALNET_RE_ACTIVE2', '');
define('_AM_SOCIALNET_RE_ACTIVE3', 'Email was not found in Database');
define('_AM_SOCIALNET_RE_ACTIVE4', 'This User');
define('_AM_SOCIALNET_RE_ACTIVE5', 'This User has been Activated Before ');
define('_AM_SOCIALNET_RE_ACTIVE6', 'Error: we Could Not Send the Code');
define('_AM_SOCIALNET_RE_ACTIVE7', 'Try again ...');
define('_AM_SOCIALNET_RE_ACTIVE8', 'Re-activation Code To ');
define('_AM_SOCIALNET_RE_ACTIVE9', 'Code was Sent - Tell your Members To Check the Junk Box or Spam Box for the Email.');
define('_AM_SOCIALNET_USERKEYFOR', 'User activation key for %s');
################# SPOT IMAGES SECTION ##############################
define('_AM_SOCIALNET_SEC', 'Sections');
define('_AM_SOCIALNET_SPOT', 'Spotlights');
define('_AM_SOCIALNET_GER', 'Manage');
define('_AM_SOCIALNET_ID', 'ID');
define('_AM_SOCIALNET_NAME', 'Name');
define('_AM_SOCIALNET_IMAGE', 'Image');
define('_AM_SOCIALNET_SHOWHIDEMENU', 'Show / Hide Menu');
define('_AM_SOCIALNET_PERPAGE', 'records per page');
define('_AM_SOCIALNET_FILTERS', 'Filters');
define('_AM_SOCIALNET_SEMRESULT', 'No record found!');
define('_AM_SOCIALNET_GRP_ERR_SEL', 'Select a record!');
define('_AM_SOCIALNET_GRP_ACTION', 'Group actions: ');
define('_AM_SOCIALNET_GRP_DEL', 'Delete selected');
define('_AM_SOCIALNET_GRP_DEL_SURE', 'Do you want to delete the selected records?');
define('_AM_SOCIALNET_SELECT', 'Select');
define('_AM_SOCIALNET_SEARCH', 'Search');
define('_AM_SOCIALNET_SHOW', 'Show ');
define('_AM_SOCIALNET_SHOWING', 'Showing from %u° to %u° of <b>%u</b> records.');
define('_AM_SOCIALNET_SUCESS_ADD', 'Information sent successfully');
define('_AM_SOCIALNET_SUCESS_UPD', 'Information updated');
define('_AM_SOCIALNET_SUCESS_DEL', 'Information deleted successfully');
define('_AM_SOCIALNET_404', 'Error! Record not found!');
define('_AM_SOCIALNET_DB_ERROR', 'Error while saving into the database');
define('_AM_SOCIALNET_BLOCKS', 'Blocks');
define('_AM_SOCIALNET_IMAGES', 'Images');
define('_AM_SOCIALNET_GROUPS', 'Groups');
define('_AM_SOCIALNET_SECTION', 'Section');
define('_AM_SOCIALNET_DSTAC', 'Spotlight');
// admin/sec.php
define('_AM_SOCIALNET_SEC_TITHE', 'Sections Administration');
define('_AM_SOCIALNET_SEC_NEW', 'New Section');
define('_AM_SOCIALNET_SEC_EDIT', 'Edit Section');
define('_AM_SOCIALNET_SEC_CONFIRM_DEL', 'Are you sure you want to delete the section <b># %u</b> - %s AND ALL SPOTLIGHTS OF THIS SECTION?');
// admin/spot.php
define('_AM_SOCIALNET_SPOT_30_NAME', 'Text');
define('_AM_SOCIALNET_SPOT_30_LINK', 'URL');
define('_AM_SOCIALNET_SPOT_10_ACCESS', 'Clicks');
define('_AM_SOCIALNET_SPOT_11_TARGET', 'Open URL in');
define('_AM_SOCIALNET_SPOT_11_TARGET_0', 'Same Window');
define('_AM_SOCIALNET_SPOT_11_TARGET_1', 'New Window');
define('_AM_SOCIALNET_SPOT_TITHE', 'Spotlights Administration');
define('_AM_SOCIALNET_SPOT_NEW', 'New Spotlight');
define('_AM_SOCIALNET_SPOT_EDIT', 'Edit Spotlight');
define('_AM_SOCIALNET_SPOT_CONFIRM_DEL', 'Are you sure you want to delete the spotlight \'# %u - %s\' ?');
define('_AM_SOCIALNET_SPOT_ACTIVE', 'Active');
define('_AM_SOCIALNET_SPOT_ACTIVATE_SEL', 'Activate Selected');
define('_AM_SOCIALNET_SPOT_DEACTIVATE_SEL', 'Deactivate Selected');
define('_AM_SOCIALNET_SPOT_ZERA_COUNT', 'Clear Clicks');
################# FEEDBACK SPOT IMAGES ##############################
// admin/Feedback
define('_AM_SOCIALNET_FEEDBACK', 'Send us Feedback');
define('_AM_SOCIALNET_YNAME', 'Your Name');
define('_AM_SOCIALNET_YEMAIL', 'Your Email');
define('_AM_SOCIALNET_YSITE', 'Site');
define('_AM_SOCIALNET_FEEDTYPE', 'Feedback type<br /><span style=\'font-size:10px; font-weight:normal\'>* Testimonials will be published at Social Net2010 main site page</span>');
define('_AM_SOCIALNET_TBUGS', 'Bug');
define('_AM_SOCIALNET_TESTIMONIAL', 'Testimonial');
define('_AM_SOCIALNET_TSUGGESTION', 'Suggestions');
define('_AM_SOCIALNET_TFEATURES', 'Resources');
define('_AM_SOCIALNET_TOTHERS', 'Other');
define('_AM_SOCIALNET_DESC', 'Description');
define('_AM_SOCIALNET_FEEDSUCCESS', 'Feedback sent successfully!');
define('_AM_SOCIALNET_FEEDBACKN', 'Send us Feedback');
define('_AM_SOCIALNET_CHKVERSION', 'Check for updates click here');
################# TREE MENU ##############################
define('_AM_SOCIALNET_TITLETREE', 'SocialNet 2010 - Management');
define('_AM_SOCIALNET_HTMLTITLE', 'SocialNet 2010 - HTML page Management');
define('_AM_SOCIALNET_FILETITLE', 'SocialNet 2010 - File Management');
define('_AM_SOCIALNET_PGTITLE', 'SocialNet 2010 - Content File Management');
define('_AM_SOCIALNET_MEDIATITLE', 'SocialNet 2010 - Media Management');
define('_AM_SOCIALNET_UPLOAD', 'Upload HTML page');
define('_AM_SOCIALNET_ADD', 'Add Content');
define('_AM_SOCIALNET_EPAGE', 'Edit Content');
define('_AM_SOCIALNET_NMEDIA', 'Send Media');
define('_AM_SOCIALNET_EMEDIA', 'Edit Media');
define('_AM_SOCIALNET_DMEDIA', 'Delete Media');
define('_AM_SOCIALNET_NFILE', 'Send New File');
define('_AM_SOCIALNET_NPG', 'Send new content file');
define('_AM_SOCIALNET_EPG', 'Edit content file');
define('_AM_SOCIALNET_EFILE', 'Edit file');
define('_AM_SOCIALNET_ADD_PAGE', 'Add page');
define('_AM_SOCIALNET_DELETATITLE', 'Delete HTML page');
define('_AM_SOCIALNET_INFO', 'Information');
define('_AM_SOCIALNET_BY', '<b> Created by: </b>');
define('_AM_SOCIALNET_DTCREATED', '<b> Created in: </b>');
define('_AM_SOCIALNET_DTUPDATE', '<b> Latest update: </b>');
define('_AM_SOCIALNET_VIEWS', '<b> Views: </b>');
define('_AM_SOCIALNET_LIMPACONT', 'Reset views');
define('_AM_SOCIALNET_EDITAR', 'Edit content');
define('_AM_SOCIALNET_MENUP', 'Main Menu');
define('_AM_SOCIALNET_MPB_10_ID', 'ID');
define('_AM_SOCIALNET_MPB_10_IDPAI', 'Show in');
define('_AM_SOCIALNET_MPB_30_MENU', 'Menu Text');
define('_AM_SOCIALNET_MPB_30_TITLE', 'Title');
define('_AM_SOCIALNET_MPB_35_CONTENT', 'Content');
define('_AM_SOCIALNET_MPB_12_SEMLINK', '1: No Link');
define('_AM_SOCIALNET_MPB_FROMFILE', '4: CHECK Create content based on html file');
define('_AM_SOCIALNET_MPB_FRAME', '3: IFrame');
define('_AM_SOCIALNET_MPB_FRAME_URL', 'Iframe URL:');
define('_AM_SOCIALNET_MPB_30_FILE', 'File');
define('_AM_SOCIALNET_MPB_HTML', 'HTML Code');
define('_AM_SOCIALNET_MPB_11_VISIBLE', 'Visible');
define('_AM_SOCIALNET_FIL_10_ID', 'ID');
define('_AM_SOCIALNET_FIL_30_NAME', 'Name');
define('_AM_SOCIALNET_FIL_30_FILE', 'File');
define('_AM_SOCIALNET_FIL_10_SIZE', 'Size');
define('_AM_SOCIALNET_FIL_30_MIME', 'Type');
define('_AM_SOCIALNET_FIL_22_DATA', 'Sent on');
define('_AM_SOCIALNET_FIL_12_SHOW', 'Show in the visual editor links list?');
define('_AM_SOCIALNET_CFI_10_ID', 'ID');
define('_AM_SOCIALNET_CFI_30_NAME', 'Name');
define('_AM_SOCIALNET_CFI_30_FILE', 'File');
define('_AM_SOCIALNET_CFI_10_SIZE', 'Size');
define('_AM_SOCIALNET_CFI_30_MIME', 'Type');
define('_AM_SOCIALNET_CFI_22_DATA', 'Sent on');
define('_AM_SOCIALNET_CFI_12_SHOW', 'Show in the page list?');
define('_AM_SOCIALNET_MPB_11_VISIBLE_1', 'Menu only');
define('_AM_SOCIALNET_MPB_11_VISIBLE_2', 'Menu and related pages');
define('_AM_SOCIALNET_MPB_11_VISIBLE_3', 'Only related pages');
define('_AM_SOCIALNET_MPB_11_VISIBLE_4', 'Invisible');
define('_AM_SOCIALNET_MPB_11_OPEN', 'Open link at');
define('_AM_SOCIALNET_MPB_11_OPEN_0', 'Same page');
define('_AM_SOCIALNET_MPB_11_OPEN_1', 'New page');
define('_AM_SOCIALNET_MPB_12_COMMENTS', 'Allow comments?');
define('_AM_SOCIALNET_MPB_12_COMMENTS2', 'Comments');
define('_AM_SOCIALNET_MPB_12_EXIBESUB', 'Show submenus?');
define('_AM_SOCIALNET_MPB_12_RECOMMEND', 'Show Recommend Link?');
define('_AM_SOCIALNET_MPB_12_PRINT', 'Show Print Links?');
define('_AM_SOCIALNET_MPB_22_CREATED', 'Created on');
define('_AM_SOCIALNET_MPB_22_UPDATE', 'Latest update');
define('_AM_SOCIALNET_MPB_10_ORDER', 'Order');
define('_AM_SOCIALNET_MPB_10_CONTADOR', 'Views');
define('_AM_SOCIALNET_ERRO1', 'Error while saving the content into the database!');
define('_AM_SOCIALNET_ERRO2', 'Error! Page not found!');
define('_AM_SOCIALNET_ERRO_MED404', 'Error! Media not found!');
define('_AM_SOCIALNET_ERRO_FIL404', 'Error! File not found!');
define('_AM_SOCIALNET_HTMLERROR', 'Error! \'html\' must have write permissions! (CHMOD 777)');
define('_AM_SOCIALNET_MEDIAERROR', 'Error! \'media\' must have write permissions! (CHMOD 777)');
define('_AM_SOCIALNET_PAGEERRORDB', 'Error while saving the file into the database!');
define('_AM_SOCIALNET_SENDERROR', 'Error while sending the file!');
define('_AM_SOCIALNET_ERR_SELECT_MEDIA', 'Error! Select a media!');
define('_AM_SOCIALNET_ERR_SELECT_FILE', 'Error! Select a file!');
define('_AM_SOCIALNET_SHOWING_PAGE', 'Showing from %u° to %u° of <b>%u</b> pages.');
define('_AM_SOCIALNET_SHOWING_MEDIA', 'Showing from %u° to %u° of <b>%u</b> medias.');
define('_AM_SOCIALNET_SHOWING_FILES', 'Showing from %u° to %u° of <b>%u</b> files.');
define('_AM_SOCIALNET_PORPAGE', 'records per page');
define('_AM_SOCIALNET_SUCESS1', 'Information sent successfully!');
define('_AM_SOCIALNET_SUCESS2', 'Information updated!');
define('_AM_SOCIALNET_DEL_SUCESS', '%u page (s) was (were) deleted successfully!');
define('_AM_SOCIALNET_DELFIL_SUCESS', 'File deleted successfully!');
define('_AM_SOCIALNET_DELMED_SUCESS', 'Media deleted successfully!');
define('_AM_SOCIALNET_SENMED_SUCESS', 'Media sent successfully!');
define('_AM_SOCIALNET_SENFIL_SUCESS', 'File sent successfully!');
define('_AM_SOCIALNET_CONFIRM_DEL', 'Are you sure you want to delete the page <b># %u</b> - %s?');
define('_AM_SOCIALNET_CONFIRM_DELFIL', 'Are you sure you want to delete the file <b># %u</b> - %s?');
define('_AM_SOCIALNET_CONFIRM_DELPG', 'Are you sure you want to delete the file <b># %u</b> - %s and ALL related pages?');
define('_AM_SOCIALNET_CONFIRM_DELMED', 'Are you sure you want to delete the media <b># %u</b> - %s?');
define('_AM_SOCIALNET_CONFIRM_DEL_CATIMG', 'Are you sure you want to delete this category and all the images in it?');
define('_AM_SOCIALNET_CONFIRM_LIMPACONT', 'Are you sure you want to delete the views per page <b># %u</b> - %s?');
define('_AM_SOCIALNET_CONFIRM_DEL_SUB', 'Are you sure you want to delete the page <b># %u</b> - %s?<br><b> WARNING! </b> This page contains %u sub-page(s) that will also be deleted!');
define('_AM_SOCIALNET_BROWSER_GER_MED', 'Medias');
define('_AM_SOCIALNET_BROWSER_GER_FIL', 'Files');
define('_AM_SOCIALNET_BROWSER_IMGERRO_NOCAT', 'Error: No category found. Add a category.');
define('_AM_SOCIALNET_MED_10_ID', 'ID');
define('_AM_SOCIALNET_MED_30_NAME', 'Media name');
define('_AM_SOCIALNET_MED_30_FILE', 'File');
define('_AM_SOCIALNET_MED_10_HEIGHT', 'Height');
define('_AM_SOCIALNET_MED_10_WIDTH', 'Width');
define('_AM_SOCIALNET_MED_10_SIZE', 'Size');
define('_AM_SOCIALNET_MED_12_SHOW', 'Show in the visual editor list?');
define('_AM_SOCIALNET_MED_22_DATA', 'Sent on');
define('_AM_SOCIALNET_MED_10_TYPE', 'Typo');
define('_AM_SOCIALNET_MED_10_TYPE_1', 'Flash (.swf)');
define('_AM_SOCIALNET_MED_10_TYPE_2', 'QuickTime (.mov)');
define('_AM_SOCIALNET_MED_10_TYPE_3', 'Shockwave (.dcr)');
define('_AM_SOCIALNET_MED_10_TYPE_4', 'Windows Media (.wmv)');
define('_AM_SOCIALNET_MED_10_TYPE_5', 'Real Media (.rm)');
define('_AM_SOCIALNET_USR_10_UID', 'Author');
define('_AM_SOCIALNET_MPB_EXTERNAL', '2: External Link');
define('_AM_SOCIALNET_MPB_EXTERNAL_URL', 'URL to be linked');
define('_AM_SOCIALNET_SHOW_INLINE_MODE', 'Ungroup Pages');
define('_AM_SOCIALNET_SHOW_NESTED_MODE', 'Group Pages');
define('_AM_SOCIALNET_SHOWSUBS', 'Show Sub-Pages');
define('_AM_SOCIALNET_SUBS', 'Sub-Pages');
define('_AM_SOCIALNET_CLONE', '-- Clone --');
define('_AM_SOCIALNET_CONFIRM_CLONE', 'Are you sure you want to clone the page <b># %u</b> - %s?');
define('_AM_SOCIALNET_EXTENDIONYOUCAN', 'Files extension that you can uploading');
define('_AM_SOCIALNET_EXTENSIONUPLOAD', '| x-gtar: gtar | x-tar: tar |x-gzip: gz | msword: doc |  pdf |vnd.ms-excel: xls | vnd.ms-powerpoint: ppt | ms-powerpoint: pps | zip | x-msvideo: avi | gif | quicktime: mov | audio-mpeg: mp3 | realaudio: ra | realaudio: ram | shockwave-flash: swf | audio x-wav: wav | audio: midi | video mpeg: mpg |');
define('_AM_SOCIALNET_EXTENSIONUPLOADCONTENT', '| text/html: html | text/plain: txt | x-httpd-php: php | x-javascript: js |');
################# TOOLS LANGUAGE ##############################
define('_AM_SOCIALNET_LANGTOOL_LANGTOOL', 'Language Tool');
define('_AM_SOCIALNET_LANGTOOL_UPDATEOK', 'Update Successful!!');
define('_AM_SOCIALNET_LANGTOOL_ERROR', 'Database Error!!');
define('_AM_SOCIALNET_LANGTOOL_NOLANG', 'You haven\'t select any language!!');
define('_AM_SOCIALNET_LANGTOOL_EDIT', 'EDIT');
define('_AM_SOCIALNET_LANGTOOL_DEL', 'DELETE');
define('_AM_SOCIALNET_LANGTOOL_ADD', 'ADD LANGUAGE');
define('_AM_SOCIALNET_LANGTOOL_LANGTITLE', 'Language Title');
define('_AM_SOCIALNET_LANGTOOL_FOLDER', 'Folder Name');
define('_AM_SOCIALNET_LANGTOOL_ADMIN', 'Admin');
define('_AM_SOCIALNET_LANGTOOL_L10', '< 10 < ');
define('_AM_SOCIALNET_LANGTOOL_N10', '>10 >');
define('_AM_SOCIALNET_LANGTOOL_L1', '< < ');
define('_AM_SOCIALNET_LANGTOOL_N1', '> >');
################# POP CHAT ##############################
// admin/beginchat.php
define('_AM_SOCIALNET_POPCHAT_CONTENT', 'Content');
define('_AM_SOCIALNET_POPCHAT_BGCOLOR', 'Background color ( don\'t forget to put a # if you specify a color code )');
define('_AM_SOCIALNET_POPCHAT_WIDTH', 'Width ( in pixels or percent )');
define('_AM_SOCIALNET_POPCHAT_HEIGHT', 'Height ( in pixels )');
define('_AM_SOCIALNET_POPCHAT_SCRAMOUNT', 'Scroll amount');
define('_AM_SOCIALNET_POPCHAT_HSPACE', 'Horizontal space (in pixels)');
define('_AM_SOCIALNET_POPCHAT_VSPACE', 'Vertical space (in pixels)');
define('_AM_SOCIALNET_POPCHAT_SCRDELAY', 'Delay between two moves in milliseconds');
define('_AM_SOCIALNET_POPCHAT_DIRECTION', 'Direction');
define('_AM_SOCIALNET_POPCHAT_DIRECTION1', 'left-> right');
define('_AM_SOCIALNET_POPCHAT_DIRECTION2', 'right-> left');
define('_AM_SOCIALNET_POPCHAT_DIRECTION3', 'bottom-> top');
define('_AM_SOCIALNET_POPCHAT_DIRECTION4', 'top-> bottom');
define('_AM_SOCIALNET_POPCHAT_BEHAVIOUR', 'Behavior');
define('_AM_SOCIALNET_POPCHAT_BEHAVIOUR1', 'scroll');
define('_AM_SOCIALNET_POPCHAT_BEHAVIOUR2', 'slide');
define('_AM_SOCIALNET_POPCHAT_BEHAVIOUR3', 'alternate');
define('_AM_SOCIALNET_POPCHAT_ALIGN', 'Align');
define('_AM_SOCIALNET_POPCHAT_ALIGN1', 'Top');
define('_AM_SOCIALNET_POPCHAT_ALIGN2', 'Bottom');
define('_AM_SOCIALNET_POPCHAT_ALIGN3', 'Middle');
define('_AM_SOCIALNET_POPCHAT_LOOP', 'Loop');
define('_AM_SOCIALNET_POPCHAT_INFINITELOOP', 'Infinite');
define('_AM_SOCIALNET_POPCHAT_STOP', 'Stop when mouse is over');
define('_AM_SOCIALNET_POPCHAT_RESETBUTTON', 'Reset');
define('_AM_SOCIALNET_POPCHAT_CONFIG', 'Chat Configuration');
define('_AM_SOCIALNET_POPCHAT_ERROR_ADD_MARQUEE', 'Error, the required fields have not been typed');
define('_AM_SOCIALNET_POPCHAT_ERROR_MODIFY_DB', 'Error while updating the database');
define('_AM_SOCIALNET_POPCHAT_DBUPDATED', 'The database has been successfully updated');
define('_AM_SOCIALNET_POPCHAT_UPDATE', 'Update');
define('_AM_SOCIALNET_POPCHAT_RUSUREDEL', 'Are you sure you want to delete this item ?');
define('_AM_SOCIALNET_POPCHAT_ADDED_OK', 'The marquee has been successfully added');
define('_AM_SOCIALNET_POPCHAT_ADDBUTTON', 'Add');
define('_AM_SOCIALNET_POPCHAT_ID', 'ID');
define('_AM_SOCIALNET_POPCHAT_ACTION', 'Action');
define('_AM_SOCIALNET_POPCHAT_EDIT', 'Edit');
define('_AM_SOCIALNET_POPCHAT_DELETE', 'Delete');
################# FORUM ##############################
// admin/admin_forumbegin.php
define('_AM_SOCIALNET_FORUMCONF', 'Forum Configuration');
define('_AM_SOCIALNET_ADDAFORUM', 'Add a Forum');
define('_AM_SOCIALNET_LINK2ADDFORUM', 'This Link will take you to a page where you can add a forum to the database.');
define('_AM_SOCIALNET_EDITAFORUM', 'Edit a Forum');
define('_AM_SOCIALNET_LINK2EDITFORUM', 'This link will allow you to edit an existing forum.');
define('_AM_SOCIALNET_SETPRIVFORUM', 'Set Private Forum Permissions');
define('_AM_SOCIALNET_LINK2SETPRIV', 'This link will allow you to set the access to an existing private forum.');
define('_AM_SOCIALNET_SYNCFORUM', 'Sync forum / topic index');
define('_AM_SOCIALNET_LINK2SYNC', 'This link will allow you to sync up the forum and topic indexes to fix any discrepancies that might arise');
define('_AM_SOCIALNET_ADDACAT', 'Add a Category');
define('_AM_SOCIALNET_LINK2ADDCAT', 'This link will allow you to add a new category to put forums into.');
define('_AM_SOCIALNET_EDITCATTTL', 'Edit a Category Title');
define('_AM_SOCIALNET_LINK2EDITCAT', 'This link will allow you edit the title of a category.');
define('_AM_SOCIALNET_RMVACAT', 'Remove a Category');
define('_AM_SOCIALNET_LINK2RMVCAT', 'This link allows you to remove any categories from the database');
define('_AM_SOCIALNET_REORDERCAT', 'Re-Order Categories');
define('_AM_SOCIALNET_LINK2ORDERCAT', 'This link will allow you to change the order in which your categories display on the index page');
// admin/admin_forums.php
define('_AM_SOCIALNET_FORUMUPDATED', 'Forum Updated');
define('_AM_SOCIALNET_HTSMHNBRBITHBTWNLBAMOTF', 'However the selected moderator (s) have not be removed because if they had been there would no longer be any moderators on this forum.');
define('_AM_SOCIALNET_FORUMREMOVED', 'Forum Removed.');
define('_AM_SOCIALNET_FRFDAWAIP', 'Forum removed from database along with all its posts.');
define('_AM_SOCIALNET_NOSUCHFORUM', 'No such forum');
define('_AM_SOCIALNET_EDITTHISFORUM', 'Edit This Forum');
define('_AM_SOCIALNET_DTFTWARAPITF', 'Delete this forum (This will also remove all posts in this forum!)');
define('_AM_SOCIALNET_FORUMNAME', 'Forum Name:');
define('_AM_SOCIALNET_FORUMDESCRIPTION', 'Forum Description:');
define('_AM_SOCIALNET_MODERATOR', 'Moderator (s):');
define('_AM_SOCIALNET_REMOVE', 'Remove');
define('_AM_SOCIALNET_NOMODERATORASSIGNED', 'No Moderators Assigned');
define('_AM_SOCIALNET_NONE', 'None');
define('_AM_SOCIALNET_CATEGORY', 'Category:');
define('_AM_SOCIALNET_ANONYMOUSPOST', 'Anonymous Posting');
define('_AM_SOCIALNET_REGISTERUSERONLY', 'Registered users only');
define('_AM_SOCIALNET_MODERATORANDADMINONLY', 'Moderators / Administrators only');
define('_AM_SOCIALNET_TYPE', 'Type:');
define('_AM_SOCIALNET_PUBLIC', 'Public');
define('_AM_SOCIALNET_PRIVATE', 'Private');
define('_AM_SOCIALNET_SELECTFORUMEDIT', 'Select a Forum to Edit');
define('_AM_SOCIALNET_NOFORUMINDATABASE', 'No Forums in Database');
define('_AM_SOCIALNET_DATABASEERROR', 'Database Error');
define('_AM_SOCIALNET_CATEGORYUPDATED', 'Category Updated.');
define('_AM_SOCIALNET_EDITCATEGORY', 'Editing Category:');
define('_AM_SOCIALNET_CATEGORYTITLE', 'Category Title:');
define('_AM_SOCIALNET_SELECTACATEGORYEDIT', 'Select a Category to Edit');
define('_AM_SOCIALNET_CATEGORYCREATED', 'Category Created.');
define('_AM_SOCIALNET_NTWNRTFUTCYMDTVTEFS', 'Note: This will NOT remove the forums under the category, you must do that via the Edit Forum section.');
define('_AM_SOCIALNET_REMOVECATEGORY', 'Remove Category');
define('_AM_SOCIALNET_CREATENEWCATEGORY', 'Create a New Category');
define('_AM_SOCIALNET_YDNFOATPOTFDYAA', 'You did not fill out all the parts of the form. <br> Did you assign at least one moderator? Please go back and correct the form.');
define('_AM_SOCIALNET_FORUMCREATED', 'Forum Created.');
define('_AM_SOCIALNET_VTFYJC', 'View the forum  you just created.');
define('_AM_SOCIALNET_EYMAACBYAF', 'Error, you must add a category before you add forums');
define('_AM_SOCIALNET_CREATENEWFORUM', 'Create a New Forum');
define('_AM_SOCIALNET_ACCESSLEVEL', 'Access Level:');
define('_AM_SOCIALNET_CATEGORYMOVEUP', 'Category Moved Up');
define('_AM_SOCIALNET_TCIATHU', 'This is already the highest category.');
define('_AM_SOCIALNET_CATEGORYMOVEDOWN', 'Category Moved Down');
define('_AM_SOCIALNET_TCIATLD', 'This is already the lowest category.');
define('_AM_SOCIALNET_SETCATEGORYORDER', 'Set Category Ordering');
define('_AM_SOCIALNET_TODHITOTCWDOTIP', 'The order displayed here is the order the categories will display on the index page. To move a category up in the ordering click Move Up to move it down click Move Down.');
define('_AM_SOCIALNET_ECWMTCPUODITO', 'Each click will move the category 1 place up or down in the ordering.');
define('_AM_SOCIALNET_CATEGORY1', 'Category');
define('_AM_SOCIALNET_MOVEUP', 'Move Up');
define('_AM_SOCIALNET_MOVEDOWN', 'Move Down');
define('_AM_SOCIALNET_FORUMUPDATE', 'Forum Settings Updated');
define('_AM_SOCIALNET_RETURNTOADMINPANEL', 'Return to the Administration Panel.');
define('_AM_SOCIALNET_RETURNTOFORUMINDEX', 'Return to the forum index');
define('_AM_SOCIALNET_ALLOWHTML', 'Allow HTML:');
define('_AM_SOCIALNET_YES', 'Yes');
define('_AM_SOCIALNET_NO', 'No');
define('_AM_SOCIALNET_ALLOWSIGNATURES', 'Allow Signatures:');
define('_AM_SOCIALNET_HOTTOPICTHRESHOLD', 'Hot Topic Threshold:');
define('_AM_SOCIALNET_POSTPERPAGE', 'Posts per Page:');
define('_AM_SOCIALNET_TITNOPPTTWBDPPOT', '(This is the number of posts per topic that will be displayed per page of a topic)');
define('_AM_SOCIALNET_TOPICPERFORUM', 'Topics per Forum:');
define('_AM_SOCIALNET_TITNOTPFTWBDPPOAF', '(This is the number of topics per forum that will be displayed per page of a forum)');
define('_AM_SOCIALNET_SAVECHANGES', 'Save Changes');
define('_AM_SOCIALNET_CLEAR', 'Clear');
define('_AM_SOCIALNET_CLICKBELOWSYNC', 'Clicking the button below will sync up your forums and topics pages with the correct data from the database. Use this section whenever you notice flaws in the topics and forums lists.');
define('_AM_SOCIALNET_SYNCHING', 'Synchronizing forum index and topics (This may take a while)');
define('_AM_SOCIALNET_DONESYNC', 'Done!');
define('_AM_SOCIALNET_CATEGORYDELETED', 'Category deleted.');
// admin/admin_priv_forums.php
define('_AM_SOCIALNET_SAFTE', 'Select a Forum to Edit');
define('_AM_SOCIALNET_NFID', 'No Forums in Database');
define('_AM_SOCIALNET_EFPF', 'Editing Forum Permissions for: <b>%s</b>');
define('_AM_SOCIALNET_UWA', 'Users With Access:');
define('_AM_SOCIALNET_UWOA', 'Users Without Access:');
define('_AM_SOCIALNET_ADDUSERS', 'Add Users -->');
define('_AM_SOCIALNET_CLEARALLUSERS', 'Clear all users');
define('_AM_SOCIALNET_REVOKEPOSTING', 'revoke posting');
define('_AM_SOCIALNET_GRANTPOSTING', 'grant posting');
define('_AM_SOCIALNET_SHOWNAME', 'Replace user\'s name with real name');
define('_AM_SOCIALNET_SHOWICONSPANEL', 'Show icons panel');
define('_AM_SOCIALNET_SHOWSMILIESPANEL', 'Show smiles panel');
define('_AM_SOCIALNET_EDITPERMS', 'Permissions');
define('_AM_SOCIALNET_CURRENT', 'Current');
define('_AM_SOCIALNET_SHOWMSGPAGINATION', 'show messages pagination on blocks');
define('_AM_SOCIALNET_CANPOST', 'Can post');
define('_AM_SOCIALNET_CANTPOST', 'Can\'t post');
define('_AM_SOCIALNET_ALLOW_UPLOAD', 'Allow files to be uploaded');
?>
