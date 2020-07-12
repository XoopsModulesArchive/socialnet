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

//Present in many files (videos pictures etc...)
define('_MD_SOCIALNET_DELETE', 'Delete');
define('_MD_SOCIALNET_EDITDESC', 'Edit description');
define('_MD_SOCIALNET_TOKENEXPIRED', 'Your Security Token has Expired <br /> Please Try Again');
define('_MD_SOCIALNET_DESC_EDITED', 'The description was edited successfully');
define('_MD_SOCIALNET_CAPTION', 'Caption');
define('_MD_SOCIALNET_YOUCANUPLOAD', 'You can only upload jpg\'s files and up to %s KBytes in size');
define('_MD_SOCIALNET_UPLOADPICTURE', 'Upload Picture');
define('_MD_SOCIALNET_ANERROR', 'AN ERROR has not been possible to up load the file <br /> Unfortunately, this module has acted in an unexpected way. Hopefully it will return to its helpful self if you try again. ');
define('_MD_SOCIALNET_PAGETITLE', '%s - %s\'s Social Network');
define('_MD_SOCIALNET_SUBMIT', 'Submit');
define('_MD_SOCIALNET_VIDEOS', 'Videos');
define('_MD_SOCIALNET_SCRAPBOOK', 'Scraps');
define('_MD_SOCIALNET_PHOTOS', 'Photos');
define('_MD_SOCIALNET_FRIENDS', 'Friends');
define('_MD_SOCIALNET_GROUPS', 'Groups');
define('_MD_SOCIALNET_NOGROUPSYET', 'No Groups yet');
define('_MD_SOCIALNET_MYGROUPS', 'My Groups');
define('_MD_SOCIALNET_ALLGROUPS', 'All Groups');
define('_MD_SOCIALNET_MEMBERSHIP', 'Portal Members');
define('_MD_SOCIALNET_PROFILE', 'Profile');
define('_MD_SOCIALNET_HOME', 'Home');
define('_MD_SOCIALNET_CONFIGSTITLE', 'Who can see');
############### PICTURES #####################
define('_MD_SOCIALNET_UPLOADED', 'Upload Successful');
//delpicture.php
define('_MD_SOCIALNET_ASKCONFIRMDELETION', 'Are you sure you want to delete this picture?');
define('_MD_SOCIALNET_CONFIRMDELETION', 'Yes please delete it!');
//album.php
define('_MD_SOCIALNET_YOUHAVE', 'You have %s picture (s) in your album.');
define('_MD_SOCIALNET_YOUCANHAVE', 'You can have up to %s picture (s).');
define('_MD_SOCIALNET_DELETED', 'Image deleted successfully');
define('_MD_SOCIALNET_SUBMIT_PIC_TITLE', 'Upload photo');
define('_MD_SOCIALNET_SELECT_PHOTO', 'Select Photo');
define('_MD_SOCIALNET_NOTHINGYET', 'No pictures in this album yet');
define('_MD_SOCIALNET_AVATARCHANGE', 'Make this picture your new avatar');
define('_MD_SOCIALNET_PRIVATIZE', 'Only you will see this image in your album');
define('_MD_SOCIALNET_UNPRIVATIZE', 'Everyone will be able to see this image in your album');
define('_MD_SOCIALNET_MYPHOTOS', 'My Photos');
//avatar.php
define('_MD_SOCIALNET_AVATAR_EDITED', 'You changed your avatar!');
//private.php
define('_MD_SOCIALNET_PRIVATIZED', 'From now on only you can see this image in your album');
define('_MD_SOCIALNET_UNPRIVATIZED', 'From now everyone can see this image in your album');
############### FRIENDS ##############################
//friends.php
define('_MD_SOCIALNET_FRIENDSTITLE', '%s\'s Friends');
define('_MD_SOCIALNET_NOFRIENDSYET', 'No friends yet');
define('_MD_SOCIALNET_MYFRIENDS', 'My Friends');
define('_MD_SOCIALNET_FRIENDSHIPCONFIGS', 'Click to Set the configs of this friendship. Evaluate your friend go now!.');
//class/socialnet_friendship.php
define('_MD_SOCIALNET_EDITFRIENDSHIP', 'Your friendship with this member:');
define('_MD_SOCIALNET_FRIENDNAME', 'Username');
define('_MD_SOCIALNET_LEVEL', 'Friendship level:');
define('_MD_SOCIALNET_UNKNOWNACCEPTED', 'Haven\'t met accepted');
define('_MD_SOCIALNET_AQUAITANCE', 'Acquaintances');
define('_MD_SOCIALNET_FRIEND', 'Friend');
define('_MD_SOCIALNET_BESTFRIEND', 'Best Friend');
define('_MD_SOCIALNET_FAN', 'Fan');
define('_MD_SOCIALNET_SEXY', 'Sexy');
define('_MD_SOCIALNET_SEXYNO', 'Nope');
define('_MD_SOCIALNET_SEXYYES', 'Yes');
define('_MD_SOCIALNET_SEXYALOT', 'Very much!');
define('_MD_SOCIALNET_TRUSTY', 'Trusty');
define('_MD_SOCIALNET_TRUSTYNO', 'Nope');
define('_MD_SOCIALNET_TRUSTYYES', 'Yes');
define('_MD_SOCIALNET_TRUSTYALOT', 'Very much');
define('_MD_SOCIALNET_COOL', 'Cool');
define('_MD_SOCIALNET_COOLNO', 'Nope');
define('_MD_SOCIALNET_COOLYES', 'Yes');
define('_MD_SOCIALNET_COOLALOT', 'Very much');
define('_MD_SOCIALNET_PHOTO', 'Friend\'s Photo');
define('_MD_SOCIALNET_UPDATEFRIEND', 'Update Friendship');
//editfriendship.php
define('_MD_SOCIALNET_FRIENDSHIPUPDATED', 'Friendship Updated');
//submit_friendpetition.php
define('_MD_SOCIALNET_PETITIONED', 'A friend request has been sent to this user, Wait until he accepts to have him in your friends list.');
define('_MD_SOCIALNET_ALREADY_PETITIONED', 'You have already sent a friendship request to this user or vice-versa <br />, Wait until he accepts or rejects it or check if he has asked you as a friend visiting your profile page.');
//makefriends.php
define('_MD_SOCIALNET_FRIENDMADE', 'Added as a friend!');
//delfriendship.php
define('_MD_SOCIALNET_FRIENDSHIPTERMINATED', 'You have broken your friendship with this user!');
############# VIDEOS ##########################
//mainvideo.php
define('_MD_SOCIALNET_SETMAINVIDEO', 'This video is selected on your front page from now on');
//youtube.php
define('_MD_SOCIALNET_YOUTUBECODE', 'You Tube code or URL');
define('_MD_SOCIALNET_ADDVIDEO', 'Add video');
define('_MD_SOCIALNET_ADDFAVORITEVIDEOS', 'Add favorite videos');
define('_MD_SOCIALNET_ADDVIDEOSHELP', 'If you want to upload your own video for sharing, then upload your videos to www.youtube.com Go You Tube click here and then add the URL to here.');
define('_MD_SOCIALNET_MYVIDEOS', 'My Videos');
define('_MD_SOCIALNET_MAKEMAIN', 'Make this video your main video');
define('_MD_SOCIALNET_NOVIDEOSYET', 'No videos yet!');
//delvideo.php
define('_MD_SOCIALNET_ASKCONFIRMVIDEODELETION', 'Are you sure you want to delete this video?');
define('_MD_SOCIALNET_CONFIRMVIDEODELETION', 'Yes I am!');
define('_MD_SOCIALNET_VIDEODELETED', 'Your video was deleted');
//submit_video.php
define('_MD_SOCIALNET_VIDEOSAVED', 'Your video was saved');
################ GROUPS ###############
//class/socialnet_groups.php
define('_MD_SOCIALNET_SUBMIT_GROUP', 'Create a new group');
define('_MD_SOCIALNET_UPLOADGROUP', 'Save Group');
define('_MD_SOCIALNET_GROUP_IMAGE', 'Group Image');
define('_MD_SOCIALNET_GROUP_TITLE', 'Title');
define('_MD_SOCIALNET_GROUP_DESC', 'Description');
define('_MD_SOCIALNETCREATEYOURGROUP', 'Create your own Group!');
//abandongroup.php
define('_MD_SOCIALNET_ASKCONFIRMABANDONGROUP', 'Are you sure you want to leave this Group?');
define('_MD_SOCIALNET_CONFIRMABANDON', 'Yes please remove me from this Group!');
define('_MD_SOCIALNET_GROUPABANDONED', 'You don\'t belong to this Group anymore.');
//becomemembergroup.php
define('_MD_SOCIALNET_YOUAREMEMBERNOW', 'You are now member of this community');
define('_MD_SOCIALNET_YOUAREMEMBERALREADY', 'You are already a member of this Group');
//delete_group.php
define('_MD_SOCIALNET_ASKCONFIRMGROUPDELETION', 'Are you sure you want to delete this Group permanently?');
define('_MD_SOCIALNET_CONFIRMGROUPDELETION', 'Yes, please delete this Group!');
define('_MD_SOCIALNET_GROUPDELETED', 'Group deleted!');
//edit_group.php
define('_MD_SOCIALNET_MAINTAINOLDIMAGE', 'Keep this image');
define('_MD_SOCIALNET_GROUPEDITED', 'Group edited');
define('_MD_SOCIALNET_EDIT_GROUP', 'Edit your Group');
define('_MD_SOCIALNET_GROUPOWNER', 'You are the owner of this Group!');
define('_MD_SOCIALNET_MEMBERSDOFGROUP', 'Members of Group');
//submit_group.php
define('_MD_SOCIALNET_GROUP_CREATED', 'Your Group was created');
//kickfromgroup.php
define('_MD_SOCIALNET_CONFIRMKICK', 'Yes kick him out!');
define('_MD_SOCIALNET_ASKCONFIRMKICKFROMGROUP', 'Are you sure you want to kick this person out of the Group?');
define('_MD_SOCIALNET_GROUPKICKED', 'You\'ve banished this user from the Group, but who knows when he\'ll try and comeback!');
//groups.php
define('_MD_SOCIALNET_GROUP_ABANDON', 'Leave this Group');
define('_MD_SOCIALNET_GROUP_JOIN', 'Join this Group and show everyone who you are!');
define('_MD_SOCIALNET_GROUP_SEARCH', 'Search a Group');
define('_MD_SOCIALNET_GROUP_SEARCHKEYWORD', 'Keyword');
############### SCRAPS ###################
//scrapbook.php
define('_MD_SOCIALNET_ENTERTEXTSCRAP', 'Enter Text or Xoops Codes');
define('_MD_SOCIALNET_SENDSCRAP', 'post Scrap');
define('_MD_SOCIALNET_ANSWERSCRAP', 'Reply');
define('_MD_SOCIALNET_MYSCRAPBOOK', 'My Scrapbook');
define('_MD_SOCIALNET_CANCEL', 'Cancel');
define('_MD_SOCIALNET_SCRAPTIPS', 'Scrap tips');
define('_MD_SOCIALNET_BOLD', 'bold');
define('_MD_SOCIALNET_ITALIC', 'italic');
define('_MD_SOCIALNET_UNDERLINE', 'underline');
define('_MD_SOCIALNET_NOSCRAPSYET', 'No Scraps created in this Scrapbook yet');
//submit_scrap.php
define('_MD_SOCIALNET_SCRAP_SENT', 'Thanks for participating, Scrap sent');
//delete_scrap.php
define('_MD_SOCIALNET_ASKCONFIRMSCRAPDELETION', 'Are you sure you want to delete this Scrap?');
define('_MD_SOCIALNET_CONFIRMSCRAPDELETION', 'Yes please delete this Scrap.');
define('_MD_SOCIALNET_SCRAPDELETED', 'The Scrap was deleted');
################## CONFIGS ################
//configs.php
define('_MD_SOCIALNET_CONFIGSEVERYONE', 'Everyone');
define('_MD_SOCIALNET_CONFIGSONLYEUSERS', 'Only Registered Members');
define('_MD_SOCIALNET_CONFIGSONLYEFRIENDS', 'My friends.');
define('_MD_SOCIALNET_CONFIGSONLYME', 'Only Me');
define('_MD_SOCIALNET_CONFIGSPICTURES', 'See your Photos');
define('_MD_SOCIALNET_CONFIGSVIDEOS', 'See your Videos');
define('_MD_SOCIALNET_CONFIGSGROUPS', 'See your Groups');
define('_MD_SOCIALNET_CONFIGSSCRAPS', 'See your Scraps');
define('_MD_SOCIALNET_CONFIGSSCRAPSSEND', 'Send you Scraps');
define('_MD_SOCIALNET_CONFIGSFRIENDS', 'See your Friends');
define('_MD_SOCIALNET_CONFIGSPROFILECONTACT', 'See your contact info');
define('_MD_SOCIALNET_CONFIGSPROFILEGENERAL', 'See your Info');
define('_MD_SOCIALNET_CONFIGSPROFILESTATS', 'See your Stats');
define('_MD_SOCIALNET_WHOCAN', 'Who can:');
//submit_configs.php
define('_MD_SOCIALNET_CONFIGSSAVE', 'Configuration saved!');
//class/socialnet_controler.php
define('_MD_SOCIALNET_NOPRIVILEGE', 'The owner of this profile has set the privileges to see it, <br /> higher than you have now. <br />Login to become their friend. <br /> If they haven\'t set it, so only they can see, <br /> then you will be able to view it.');
################# OTHERS #################
//index.php
define('_MD_SOCIALNET_VISITORS', 'Visitors (who visited your profile recently)');
define('_MD_SOCIALNET_USERDETAILS', 'User details');
define('_MD_SOCIALNET_USERCONTRIBUTIONS', 'User contributions');
define('_MD_SOCIALNET_FANS', 'Click to see your Fans');
define('_MD_SOCIALNET_UNKNOWNREJECTING', 'I don\'t know this person, Do not add them to my friends list');
define('_MD_SOCIALNET_UNKNOWNACCEPTING', 'I don\'t know this person, Yet add them to my friends list');
define('_MD_SOCIALNET_ASKINGFRIEND', 'Is %s your friend?');
define('_MD_SOCIALNET_ASKBEFRIEND', 'Ask this user to be your friend?');
define('_MD_SOCIALNET_EDITPROFILE', 'Edit your profile');
define('_MD_SOCIALNET_SELECTAVATAR', 'Upload pictures to your album and select one as your avatar.');
define('_MD_SOCIALNET_SELECTMAINVIDEO', 'Add a video to your videos album and then select it as your main video');
define('_MD_SOCIALNET_NOAVATARYET', 'No avatar yet');
define('_MD_SOCIALNET_NOMAINVIDEOYET', 'No main video yet');
define('_MD_SOCIALNET_MYPROFILE', 'My Profile');
define('_MD_SOCIALNET_YOUHAVEXPETITIONS', 'You have %u requests for friendship.');
define('_MD_SOCIALNET_CONTACTINFO', 'Contact Info');
define('_MD_SOCIALNET_SUSPENDUSER', 'Suspend user');
define('_MD_SOCIALNET_SUSPENDTIME', 'Time of suspension (in secs)');
define('_MD_SOCIALNET_UNSUSPEND', 'Unsuspended User');
define('_MD_SOCIALNET_SUSPENSIONADMIN', 'Suspension Admin Tools');
//index.php
define('_MD_SOCIALNET_SUSPENDED', 'User under suspension until %s');
define('_MD_SOCIALNET_USERSUSPENDED', 'User suspended!');
//unsuspend.php
define('_MD_SOCIALNET_USERUNSUSPENDED', 'User Unsuspended');
//searchmembers.php
define('_MD_SOCIALNET_SEARCH', 'Search Members');
define('_MD_SOCIALNET_REALNAME', 'Real Name');
define('_MD_SOCIALNET_REGDATE', 'Joined Date');
define('_MD_SOCIALNET_EMAIL', 'Email');
define('_MD_SOCIALNET_PM', 'PM');
define('_MD_SOCIALNET_URL', 'URL');
define('_MD_SOCIALNET_ADMIN', 'ADMIN');
define('_MD_SOCIALNET_PREVIOUS', 'Previous');
define('_MD_SOCIALNET_NEXT', 'Next');
define('_MD_SOCIALNET_USERSFOUND', '%s member (s) found');
define('_MD_SOCIALNET_TOTALUSERS', 'Total: %s members');
define('_MD_SOCIALNET_NOFOUND', 'No Members Found');
define('_MD_SOCIALNET_UNAME', 'User Name');
define('_MD_SOCIALNET_ICQ', 'ICQ Number');
define('_MD_SOCIALNET_AIM', 'AIM Handle');
define('_MD_SOCIALNET_YIM', 'YIM Handle');
define('_MD_SOCIALNET_MSNM', 'MSNM Handle');
define('_MD_SOCIALNET_LOCATION', 'Location contains');
define('_MD_SOCIALNET_OCCUPATION', 'Occupation contains');
define('_MD_SOCIALNET_INTEREST', 'Interest contains');
define('_MD_SOCIALNET_URLC', 'URL contains');
define('_MD_SOCIALNET_LASTLOGMORE', 'Last login is more than <span style=\'color:#ff0000;\'>X</span> days ago');
define('_MD_SOCIALNET_LASTLOGLESS', 'Last login is less than <span style=\'color:#ff0000;\'>X</span> days ago');
define('_MD_SOCIALNET_REGMORE', 'Joined date is more than <span style=\'color:#ff0000;\'>X</span> days ago');
define('_MD_SOCIALNET_REGLESS', 'Joined date is less than <span style=\'color:#ff0000;\'>X</span> days ago');
define('_MD_SOCIALNET_POSTSMORE', 'Number of Posts is greater than <span style=\'color:#ff0000;\'>X</span>');
define('_MD_SOCIALNET_POSTSLESS', 'Number of Posts is less than <span style=\'color:#ff0000;\'>X</span>');
define('_MD_SOCIALNET_SORT', 'Sort by');
define('_MD_SOCIALNET_ORDER', 'Order');
define('_MD_SOCIALNET_LASTLOGIN', 'Last login');
define('_MD_SOCIALNET_POSTS', 'Number of posts');
define('_MD_SOCIALNET_ASC', 'Ascending order');
define('_MD_SOCIALNET_DESC', 'Descending order');
define('_MD_SOCIALNET_LIMIT', 'Number of members per page');
define('_MD_SOCIALNET_RESULTS', 'Search results');
define('_MD_SOCIALNET_VIDEOSNOTENABLED', 'The administrator of the site has disabled videos feature');
define('_MD_SOCIALNET_FRIENDSNOTENABLED', 'The administrator of the site has disabled friends feature');
define('_MD_SOCIALNET_GROUPSNOTENABLED', 'The administrator of the site has disabled groups feature');
define('_MD_SOCIALNET_PICTURESNOTENABLED', 'The administrator of the site has disabled pictures feature');
define('_MD_SOCIALNET_SCRAPSNOTENABLED', 'The administrator of the site has disabled scraps feature');
define('_MD_SOCIALNET_ALLFRIENDS', 'View all friends');
define('_MD_SOCIALNET_FRIENDSHIPNOTACCEPTED', 'Friendship rejected');
define('_MD_SOCIALNET_USERDOESNTEXIST', 'This user doesn\'t exist or was deleted');
define('_MD_SOCIALNET_FANSTITLE', '%s\'s Fans');
define('_MD_SOCIALNET_NOFANSYET', 'No fans yet');
define('_MD_SOCIALNET_AUDIONOTENABLED', 'The administrator of the site has disabled audio feature');
define('_MD_SOCIALNET_NOAUDIOYET', 'This user hasn\'t uploaded any audio files yet');
define('_MD_SOCIALNET_AUDIOS', 'Audio');
define('_MD_SOCIALNET_CONFIGSAUDIOS', 'See your Audio files');
define('_MD_SOCIALNET_UPLOADEDAUDIO', 'Audio file uploaded');
define('_MD_SOCIALNET_SELECTAUDIO', 'Browse for your mp3 file');
define('_MD_SOCIALNET_AUTHORAUDIO', 'Author / Singer');
define('_MD_SOCIALNET_TITLEAUDIO', 'Title of file or song');
define('_MD_SOCIALNET_ADDAUDIO', 'Add an mp3 file');
define('_MD_SOCIALNET_SUBMITAUDIO', 'Upload file');
define('_MD_SOCIALNET_ADDAUDIOHELP', 'Choose an mp3 file on your computer, max size %s , <br /> Leave title and author fields blank if your file has metainfo already');
define('_MD_SOCIALNET_AUDIODELETED', 'Your mp3 file was deleted!');
define('_MD_SOCIALNET_ASKCONFIRMAUDIODELETION', 'Do you really want to delete your audio file?');
define('_MD_SOCIALNET_CONFIRMAUDIODELETION', 'Yes please delete it!');
define('_MD_SOCIALNET_META', 'Meta Info');
define('_MD_SOCIALNET_META_TITLE', 'Title');
define('_MD_SOCIALNET_META_ALBUM', 'Album');
define('_MD_SOCIALNET_META_ARTIST', 'Artist');
define('_MD_SOCIALNET_META_YEAR', 'Year');
define('_MD_SOCIALNET_PLAYER', 'Your audio player');
define('_MD_SOCIALNET_MYAUDIOS', 'My Audios');
################# MEMBERSHIP ################
//membership.php
define('_MD_SOCIALNET_ALL', 'All');
define('_MD_SOCIALNET_OTHER', 'Other');
define('_MD_SOCIALNET_WELCOMETO', 'Welcome to members directory');
define('_MD_SOCIALNET_GREETINGS', 'Last Member');
define('_MD_SOCIALNET_RESETSEARCH', 'Reset Search');
define('_MD_SOCIALNET_AVATAR', 'Avatar');
define('_MD_SOCIALNET_NICKNAME', 'Nickname');
define('_MD_SOCIALNET_FUNCTIONS', 'Functions');
define('_MD_SOCIALNET_EDIT', 'Edit');
define('_MD_SOCIALNET_NOUSERFOUND', 'No Member Found');
################# USER PAGE ##############################
//pageuser.php
define('_MD_SOCIALNET_TITLE', 'Title');
define('_MD_SOCIALNET_CONTENT', 'Content');
define('_MD_SOCIALNET_CREATION_DATE', 'Creation\'s date : ');
define('_MD_SOCIALNET_HITS', 'View');
define('_MD_SOCIALNET_PUBLISH', 'Publish and create you Page');
define('_MD_SOCIALNET_PRINTABLE', 'Printer Friendly Version');
define('_MD_SOCIALNET_PDF', 'PDF Version');
define('_MD_SOCIALNET_EMAIL_SEND', 'Send this page to a friend');
define('_MD_SOCIALNET_YOUR_PAGE', 'Your page');
define('_MD_SOCIALNET_RSS_FEED', 'RSS Feed');
define('_MD_SOCIALNET_INTARTICLE', 'Interesting page at %s');
define('_MD_SOCIALNET_INTARTFOUND', 'Here is an interesting page I have found at %s');
define('_MD_SOCIALNET_EMPTY_PAGE', 'The page is empty');
define('_MD_SOCIALNET_DB_OK', 'The database was updated');
define('_MD_SOCIALNET_DB_PB', 'Error while updating the database');
define('_MD_SOCIALNET_PAGE_NOT_FOUND', 'Page not found');
define('_MD_SOCIALNET_PAGE_OF', 'Page of ');
define('_MD_SOCIALNET_THISCOMESFROM', 'This page is coming from %s');
define('_MD_SOCIALNET_URLFORPAGE', 'The URL for this page is:');
define('_MD_SOCIALNET_PAGELIST', 'Pages List');
define('_MD_SOCIALNET_USER', 'User');
define('_MD_SOCIALNET_DATE', 'Date');
define('_MD_SOCIALNET_PDF_PAGE', 'Page');
define('_MD_SOCIALNET_POSTEDON', 'Posted on : ');
define('_MD_SOCIALNET_ARE_YOU_SURE', 'Are you sure ?');
define('_MD_SOCIALNET_VIEW', 'View');
################# CONTACT US ################
//contactus.php
define('_MD_SOCIALNET_CONTACTUS', 'Contact Us');
define('_MD_SOCIALNET_CONTACTFORM', 'Contact Us Form');
define('_MD_SOCIALNET_THANKYOU', 'Thank you for your interest in our site!');
define('_MD_SOCIALNET_NAME', 'Name');
define('_MD_SOCIALNET_COMPANY', 'Company');
define('_MD_SOCIALNET_COMMENTS', 'Comments');
define('_MD_SOCIALNET_YOURMESSAGE', 'Your Message:');
define('_MD_SOCIALNET_WEBMASTER', 'Webmaster');
define('_MD_SOCIALNET_HELLO', 'Hello %s,');
define('_MD_SOCIALNET_THANKYOUCOMMENTS', 'Thank you for your comments about %s.');
define('_MD_SOCIALNET_SENTTOWEBMASTER', 'Your message has been sent to the webmaster (s) of %s.');
define('_MD_SOCIALNET_SUBMITTED', '%s submitted the following Information:');
define('_MD_SOCIALNET_MESSAGESENT', 'Message to %s Sent');
define('_MD_SOCIALNET_SENTASCONFIRM', 'Your comments have been sent to: %s as a confirmation email.');
define('_MD_SOCIALNET_INVALIDMAIL', 'Invalid e-mail address');
################# NEWS ##############################
// news.php
define('_MD_SOCIAL_NW_PRINTER', 'Printer Friendly Page');
define('_MD_SOCIAL_NW_SENDSTORY', 'Send this Article to a Friend');
define('_MD_SOCIAL_NW_READMORE', 'Read More...');
define('_MD_SOCIAL_NW_COMMENTS', 'Comments?');
define('_MD_SOCIAL_NW_ONECOMMENT', '1 comment');
define('_MD_SOCIAL_NW_BYTESMORE', '%s words more');
define('_MD_SOCIAL_NW_NUMCOMMENTS', '%s comments');
define('_MD_SOCIAL_NW_MORERELEASES', 'More releases in');
// submit_news.php
define('_MD_SOCIAL_NW_SUBMITNEWS', 'Submit Article');
define('_MD_SOCIAL_NW_TITLE', 'Title');
define('_MD_SOCIAL_NW_TOPIC', 'Topic');
define('_MD_SOCIAL_NW_THESCOOP', 'Article Text');
define('_MD_SOCIAL_NW_NOTIFYPUBLISH', 'Notify by mail when published');
define('_MD_SOCIAL_NW_POST', 'Post');
define('_MD_SOCIAL_NW_GO', 'Go!');
define('_MD_SOCIAL_NW_THANKS', 'Thanks for your submission.');
define('_MD_SOCIAL_NW_NOTIFYSBJCT', 'Article for my site');
define('_MD_SOCIAL_NW_NOTIFYMSG', 'You have a new submission for your site.');
// newsarchive.php
define('_MD_SOCIAL_NW_NEWSARCHIVES', 'Article Archives');
define('_MD_SOCIAL_ARTICLES', 'Articles');
define('_MD_SOCIAL_NW_VIEWS', 'Views');
define('_MD_SOCIAL_NW_DATE', 'Date');
define('_MD_SOCIAL_NW_ACTIONS', 'Actions');
define('_MD_SOCIAL_NW_PRINTERFRIENDLY', 'Printer Friendly Page');
define('_MD_SOCIAL_NW_THEREAREINTOTAL', 'There are %s article (s) in total');
define('_MD_SOCIAL_NW_INTARTICLE', 'Interesting Article at %s');
define('_MD_SOCIAL_NW_INTARTFOUND', 'Here is an interesting article I have found at %s');
define('_MD_SOCIAL_NW_TOPICC', 'Topic:');
define('_MD_SOCIAL_NW_URL', 'URL:');
define('_MD_SOCIAL_NW_NOSTORY', 'Sorry, the selected article does not exist.');
// newsprint.php
define('_MD_SOCIAL_NW_URLFORSTORY', 'The URL for this article is:');
// %s represents your site name
define('_MD_SOCIAL_NW_THISCOMESFROM', 'This article comes from %s');
define('_MD_SOCIAL_NW_ATTACHEDFILES', 'Attached Files:');
define('_MD_SOCIAL_NW_MAJOR', 'Major Change?');
define('_MD_SOCIAL_NW_STORYID', 'Article ID');
define('_MD_SOCIAL_NW_VERSION', 'Version');
define('_MD_SOCIAL_NW_SETVERSION', 'Set Current Version');
define('_MD_SOCIAL_NW_VERSIONUPDATED', 'Current Version Set To %s');
define('_MD_SOCIAL_NW_OVERRIDE', 'Override');
define('_MD_SOCIAL_NW_FINDVERSION', 'Find Version');
define('_MD_SOCIAL_NW_REVISION', 'Revision');
define('_MD_SOCIAL_NW_MINOR', 'Minor Revision');
define('_MD_SOCIAL_NW_VERSIONDESC', 'Choose level of change - If you do NOT specify this, the text will NOT UPDATE!');
define('_MD_SOCIAL_NW_NOVERSIONCHANGE', 'No Version Change');
define('_MD_SOCIAL_NW_AUTO', 'Auto');
define('_MD_SOCIAL_NW_RATEARTICLE', 'Rate Article');
define('_MD_SOCIAL_NW_RATE', 'Rate Article');
define('_MD_SOCIAL_NW_SUBMITRATING', 'Submit Rating');
define('_MD_SOCIAL_NW_RATING_SUCCESSFUL', 'Article Rated Successfully');
define('_MD_SOCIAL_NW_PUBLISHED_DATE', 'Published Date: ');
define('_MD_SOCIAL_NW_POSTEDBY', 'Author');
define('_MD_SOCIAL_NW_READS', 'Reads');
define('_MD_SOCIAL_NW_AUDIENCE', 'Audience');
define('_MD_SOCIAL_NW_SWITCHAUTHOR', 'Update Author?');
//Warnings
define('_MD_SOCIAL_NW_VERSIONSEXIST', '%s Version (s) with higher versions exist and <strong> will </strong> be OVERWRITTEN with NO restoration ability:');
define('_MD_SOCIAL_NW_AREYOUSUREOVERRIDE', 'Are you sure you want to replace these versions');
define('_MD_SOCIAL_NW_CONFLICTWHAT2DO', 'An article with the calculated version number exists <br /> What do You want to do? <br /> Override: This version is saved with the calculated version number and all higher versions in the same version group (xx.xx.xx) will be deleted <br />Find Version: Let the system find the next available version in the same version group');
define('_MD_SOCIAL_NW_VERSIONCONFLICT', 'Version Conflict');
define('_MD_SOCIAL_NW_TRYINGTOSAVE', 'Attempting to save');
//Error messages
define('_MD_SOCIAL_NW_ERROR', 'Error Occurred');
define('_MD_SOCIAL_NW_RATING_FAILED', 'Rating Failed');
define('_MD_SOCIAL_NW_SAVEFAILED', 'Article Saving Failed');
define('_MD_SOCIAL_NW_TEXTSAVEFAILED', 'Could not save article text');
define('_MD_SOCIAL_NW_VERSIONUPDATEFAILED', 'Could not update version');
define('_MD_SOCIAL_NW_COULDNOTRESET', 'Could not reset versions');
define('_MD_SOCIAL_NW_COULDNOTUPDATEVERSION', 'Could not update to current version');
define('_MD_SOCIAL_NW_COULDNOTSAVERATING', 'Could not save rating');
define('_MD_SOCIAL_NW_COULDNOTUPDATERATING', 'Could not update article rating');
define('_MD_SOCIAL_NW_COULDNOTADDLINK', 'Link could not be related to article');
define('_MD_SOCIAL_NW_COULDNOTDELLINK', 'Error - Link not deleted');
define('_MD_SOCIAL_NW_CANNOTVOTESELF', 'Author cannot rate articles');
define('_MD_SOCIAL_NW_ANONYMOUSVOTEDISABLED', 'Anonymous rating disabled');
define('_MD_SOCIAL_NW_ANONYMOUSHASVOTED', 'This IP has already rated this article');
define('_MD_SOCIAL_NW_USERHASVOTED', 'You have already rated this article');
define('_MD_SOCIAL_NW_NOTALLOWEDAUDIENCE', 'You are not allowed to read %s level articles');
define('_MD_SOCIAL_NW_NOERRORSENCOUNTERED', 'No errors encountered');
// Additional constants
define('_MD_SOCIAL_NW_USERNAME', 'Username');
define('_MD_SOCIAL_NW_ADDLINK', 'Add Link (s)');
define('_MD_SOCIAL_NW_DELLINK', 'Remove Link (s)');
define('_MD_SOCIAL_NW_RELATEDARTICLES', 'Recommended Reading');
define('_MD_SOCIAL_NW_SEARCHRESULTS', 'Search Results:');
define('_MD_SOCIAL_NW_MANAGELINK', 'Links');
define('_MD_SOCIAL_NW_DELVERSIONS', 'Delete versions below this version');
define('_MD_SOCIAL_NW_DELALLVERSIONS', 'Delete ALL versions apart from this version');
define('_MD_SOCIAL_NW_SUBMIT', 'Submit');
define('_MD_SOCIAL_NW_RUSUREDELVERSIONS', 'Are you sure you want to delete ALL versions BEYOND RESTORATION!!! below this version?');
define('_MD_SOCIAL_NW_RUSUREDELALLVERSIONS', 'Are you sure you want to delete ALL versions BEYOND RESTORATION!!! apart from this version?');
define('_MD_SOCIAL_NW_EXTERNALLINK', 'External Link');
define('_MD_SOCIAL_NW_ADDEXTERNALLINK', 'Add External Link');
define('_MD_SOCIAL_NW_PREREQUISITEARTICLES', 'Prerequisite Reading');
define('_MD_SOCIAL_NW_LINKTYPE', 'Link Type');
define('_MD_SOCIAL_NW_SETTITLE', 'Set Title of Link');
define('_MD_SOCIAL_NW_BANNER', 'Banner / Sponsor');
define('_MD_SOCIAL_NW_NOTOPICS', 'No Topics Exist - please create a topic and set appropriate permissions before submitting an article');
define('_MD_SOCIAL_NW_TOTALARTICLES', 'Total Articles');
define('_MD_SOCIAL_NW_INDEX', 'Index');
define('_MD_SOCIAL_NW_SUBTOPICS', 'Sub-Topics for ');
define('_MD_SOCIAL_NW_PAGEBREAK', 'PAGEBREAK');
################# SPOT IMAGES ##############
// socialnet/imagespot.php
define('_MD_SOCIALNET_PROMOTE', 'Promote us! Use the form below to create the code to put in your site.');
define('_MD_SOCIALNET_FORM_TITLE', 'Code Generator');
define('_MD_SOCIALNET_COPY_PASTE', 'Copy the code below and paste in your site to show the spotlights above.');
define('_MD_SOCIALNET_SECTION', 'Section');
define('_MD_SOCIALNET_SPOTWIDTH', 'Spotlight Width');
define('_MD_SOCIALNET_SPOTHEIGHT', 'Spotlight Height (pixels)');
define('_MD_SOCIALNET_ARROWS', 'Show navigation arrows?');
define('_MD_SOCIALNET_BAR', 'Show Text Bar?');
define('_MD_SOCIALNET_DELAY', 'Transition time between images <br /> (seconds)');
define('_MD_SOCIALNET_BARCOLOR', 'Text Bar Color');
define('_MD_SOCIALNET_TEXTCOLOR', 'Text Color');
define('_MD_SOCIALNET_TRANSP', 'Text Bar Transparency');
define('_MD_SOCIALNET_GENERATE', 'Generate!');
define('_MD_SOCIALNET_ALIGN', 'Align');
define('_MD_SOCIALNET_ALIGN_MIDDLE', 'Middle');
define('_MD_SOCIALNET_ALIGN_LEFT', 'Left');
define('_MD_SOCIALNET_ALIGN_RIGHT', 'Right');
define('_MD_SOCIALNET_SEC_404', 'There is no active spotlights in the %s section');
################# TREE MENU ####################
define('_MD_SOCIALNET_404', 'Error! Page not found!');
define('_MD_SOCIALNET_RECOMMEND', 'Recommend this page to a friend!');
define('_MD_SOCIALNET_RECTOAFRIEND', 'Recommend the page <span style=\'color:red\'>\' %s \'</span> to a friend.');
define('_MD_SOCIALNET_YNAME', 'Your name');
define('_MD_SOCIALNET_YEMAIL', 'Your Email');
define('_MD_SOCIALNET_FNAME', 'Your friend\'s name');
define('_MD_SOCIALNET_FEMAIL', 'Your friend\'s email');
define('_MD_SOCIALNET_MESSAGE', 'Additional Message');
define('_MD_SOCIALNET_MAILSUBJECT', 'Recommendation from %s');
define('_MD_SOCIALNET_MAILBODY', 'Hello %s! <br /> %s (%s) visited the page \' <a href=\'%s\'>%s</a> \' and would like to recommend it to you. <br /> In case you\'re not being able to see the link, copy and paste it at your browser: <br /> %s <br /><br /> Additional message from %s: <br /> %s');
define('_MD_SOCIALNET_MAILSUCCESS', '<h3> Message sent to %s </h3> <a href=\'%s\'> Return </a>');
define('_MD_SOCIALNET_PRINT', 'Prepare to print');
define('_MD_SOCIALNET_INFOPG', 'Information');
define('_MD_SOCIALNET_AUTHOR', 'Page Author:');
define('_MD_SOCIALNET_CREATED', 'Created on:');
define('_MD_SOCIALNET_UPDATE', 'Latest update:');
define('_MD_SOCIALNET_CONTADOR', 'Page viewed <b>%u</b> times');
define('_MD_SOCIALNET_ZCONTADOR', 'Reset views');
define('_MD_SOCIALNET_EDITPAGE', 'Edit page');
define('_MD_SOCIALNET_RELATED', 'See also');
define('_MD_SOCIALNET_NEWPAGE', 'New Sub-page');
define('_MD_SOCIALNET_MYPAGES', 'My pages');
################# FLAGS TRANSLATE ###############
define('_MD_SOCIALNET_TRANSLATE', 'Click in the flag and translate this website');
// To add to link of the text of the flag
define('_MD_TRANS_GERMAN', 'Translate Page To German');
define('_MD_TRANS_SPANISH', 'Translate Page To Spanish');
define('_MD_TRANS_FRENCH', 'Translate Page To French');
define('_MD_TRANS_ITALIAN', 'Translate Page To Italian');
define('_MD_TRANS_JAPONESE', 'Translate Page To Japanese');
define('_MD_TRANS_KOREAN', 'Translate Page To Korean');
define('_MD_TRANS_PORTUGUESE', 'Translate Page To Portuguese');
define('_MD_TRANS_CHINESE', 'Translate Page To Chinese');
// To add to the secondary section
define('_MD_PAIR_GERMAN', '&amp;langpair=en%7Cde');
define('_MD_PAIR_SPANISH', '&amp;langpair=en%7Ces');
define('_MD_PAIR_FRENCH', '&amp;langpair=en%7Cfr');
define('_MD_PAIR_ITALIAN', '&amp;langpair=en%7Cit');
define('_MD_PAIR_JAPONESE', '&amp;langpair=en%7Cja');
define('_MD_PAIR_KOREAN', '&amp;langpair=en%7Cko');
define('_MD_PAIR_PORTUGUESE', '&amp;langpair=en%7Cpt');
define('_MD_PAIR_CHINESE', '&amp;langpair=en%7Czh-CN');
// To add to the section third
define('_MD_TO_GERMAN', 'English_to_German');
define('_MD_TO_SPANISH', 'English_to_Spanish');
define('_MD_TO_FRENCH', 'English_to_French');
define('_MD_TO_ITALIAN', 'English_to_Italian');
define('_MD_TO_JAPONESE', 'English_to_Japanese');
define('_MD_TO_KOREAN', 'English_to_Korean');
define('_MD_TO_PORTUGUESE', 'English_to_Portuguese');
define('_MD_TO_CHINESE', 'English_to_Chino');
################# LANGUAGE TOOL ##############
define('_MD_SOCIALNET_LANGTOOL_MENU', 'Language Tool');
define('_MD_SOCIALNET_LANGTOOL_STEPS', 'Steps:');
define('_MD_SOCIALNET_LANGTOOL_STEPS_MODULE', 'Module');
define('_MD_SOCIALNET_LANGTOOL_STEPS_LANGUAGE', 'Language');
define('_MD_SOCIALNET_LANGTOOL_STEPS_FILE', 'File');
define('_MD_SOCIALNET_LANGTOOL_STEPS_TRANSLATE', 'Translate');
define('_MD_SOCIALNET_LANGTOOL_STEPS_FINISH', 'Finish');
define('_MD_SOCIALNET_LANGTOOL_SESELECTMOD', 'Please select the module you want to translate :');
define('_MD_SOCIALNET_LANGTOOL_MANUALPATH', 'Or, manually input the path where language folder located, like /var/www/tmp/socialnet/language/ (Remember the trailing slash / ):');
define('_MD_SOCIALNET_LANGTOOL_DIRERROR', 'There\'s something error with your directory (%s) !! Please fix it before using this tool!');
define('_MD_SOCIALNET_LANGTOOL_SESELECTLANG', 'Please select the languages you want to translate :');
define('_MD_SOCIALNET_LANGTOOL_FROM', 'From :');
define('_MD_SOCIALNET_LANGTOOL_TO', 'To :');
define('_MD_SOCIALNET_LANGTOOL_SESELECTFILE', 'Please select the file you want to translate :');
define('_MD_SOCIALNET_LANGTOOL_ISFOLDER', 'This is a folder.');
define('_MD_SOCIALNET_LANGTOOL_FILEEXIST', 'The target file (folder) is existing.');
define('_MD_SOCIALNET_LANGTOOL_YOUCANFIND', 'You could find the file at :');
define('_MD_SOCIALNET_LANGTOOL_INFILE', 'The file you are processing :');
define('_MD_SOCIALNET_LANGTOOL_INMODULE', 'The module you are processing :');
define('_MD_SOCIALNET_LANGTOOL_DOWNLOAD', 'Download the whole language pack');
define('_MD_SOCIALNET_LANGTOOL_SHARE', 'Share your language pack with us through the Official XOOPS Website');
################# POPCHAT ###################
define('_MD_SOCIALNET_POPCHATMENU', 'Members Chat');
define('_MD_SOCIALNET_POPCHAT_RELOAD', 'Reload');
define('_MD_SOCIALNET_POPCHAT_CLEAR', 'Clear');
define('_MD_SOCIALNET_POPCHAT_SEND', 'Send');
################# MY BIRTHDAY ###############
define('_MD_SOCIALNET_BIRTH_TITLE_2', 'Members Birth Dates');
define('_MD_SOCIALNET_BIRTH_EDIT', 'Edit your Birthday');
define('_MD_SOCIALNET_BIRTH_ENTER', 'Edit your Birth Date');
define('_MD_SOCIALNET_BIRTH_YOUR_DATE', 'Your date');
define('_MD_SOCIALNET_BIRTH_SAVE', 'Save');
define('_MD_SOCIALNET_BIRTH_DBUPDATED', 'The Data Base has been updated.');
define('_MD_SOCIALNET_BIRTH_NOBIRTHDAYSAVED', 'Impossible to save data !');
define('_MD_SOCIALNET_BIRTH_NO_ACCES', 'You can\'t edit your birth date.');
define('_MD_SOCIALNET_BIRTH_SEEWORKING', 'To see how this section works, select today\'s date and look at the block to the left side');
################# BUDDY FRIENDS ###############
define('_MD_SOCIALNET_BUDDY_PLEASE', 'You must be a member to use it!');
define('_MD_SOCIALNET_BUDDY_REGIN', 'Register!');
define('_MD_SOCIALNET_BUDDY_ORLOGIN', 'Connect');
define('_MD_SOCIALNET_BUDDY_WHOISONLINE', 'Who is Online?');
define('_MD_SOCIALNET_BUDDY_MYFRIENDS', 'My friends');
define('_MD_SOCIALNET_BUDDY_VISITER', 'Visitor');
define('_MD_SOCIALNET_BUDDY_INCOMINGFROM', 'Message from ');
define('_MD_SOCIALNET_BUDDY_SENTAT', 'Send :');
define('_MD_SOCIALNET_BUDDY_REPLY', 'Reply');
define('_MD_SOCIALNET_BUDDY_DELETEON', 'Delete this message?');
define('_MD_SOCIALNET_BUDDY_CONTINUE', 'Continue');
define('_MD_SOCIALNET_BUDDY_EXISTS', 'This friend already exist in list!');
define('_MD_SOCIALNET_BUDDY_BACKTOLIST', 'Back to friends list');
define('_MD_SOCIALNET_BUDDY_BACKTOMODPAGE', 'Back to modify friends list');
define('_MD_SOCIALNET_BUDDY_NEXT', 'Next');
define('_MD_SOCIALNET_BUDDY_PREVIOUS', 'Previous');
define('_MD_SOCIALNET_BUDDY_FRIENDSLIST', 'Friends list');
define('_MD_SOCIALNET_BUDDY_FRIENDSLIST_HAVE', 'Got ');
define('_MD_SOCIALNET_BUDDY_FRIENDSLIST_ACTUAL', 'friends for now');
define('_MD_SOCIALNET_BUDDY_PAGES', 'Pages');
define('_MD_SOCIALNET_BUDDY_ALL', 'All');
define('_MD_SOCIALNET_BUDDY_MEMBERS', 'Members');
define('_MD_SOCIALNET_BUDDY_TO', 'to');
define('_MD_SOCIALNET_BUDDY_FRIENDADDED', 'Friend added');
define('_MD_SOCIALNET_BUDDY_PROBLEM', 'Problem');
define('_MD_SOCIALNET_BUDDY_FRIENDDELETED', 'Friend deleted');
define('_MD_SOCIALNET_BUDDY_ALLOWSYOUTO', 'Allows you to send private message with other members. By leaving it open, messages you\'ll received will automatically be shown in a popup window..');
define('_MD_SOCIALNET_BUDDY_INSTMESSANGER', 'Instant Messenger');
################# FORUM #####################
//forumfunctions.php
define('_MD_SOCIALNET_FORUM_ERROR', 'Error');
define('_MD_SOCIALNET_FORUM_NOPOSTS', 'No Posts');
define('_MD_SOCIALNET_FORUM_GO', 'Go');
//forumstart.php
define('_MD_SOCIALNET_FORUM_FORUM', 'Forum');
define('_MD_SOCIALNET_FORUM_WELCOME', 'Welcome to %s Forum.');
define('_MD_SOCIALNET_FORUM_TOPICS', 'Topics');
define('_MD_SOCIALNET_FORUM_POSTS', 'Posts');
define('_MD_SOCIALNET_FORUM_LASTPOST', 'Last Post');
define('_MD_SOCIALNET_FORUM_MODERATOR', 'Moderator');
define('_MD_SOCIALNET_FORUM_NEWPOSTS', 'New posts');
define('_MD_SOCIALNET_FORUM_NONEWPOSTS', 'No new posts');
define('_MD_SOCIALNET_FORUM_PRIVATEFORUM', 'Private forum');
define('_MD_SOCIALNET_FORUM_BY', 'by');
define('_MD_SOCIALNET_FORUM_TOSTART', 'To start viewing messages, select the forum that you want to visit from the selection below.');
define('_MD_SOCIALNET_FORUM_TOTALTOPICSC', 'Total Topics: ');
define('_MD_SOCIALNET_FORUM_TOTALPOSTSC', 'Total Posts: ');
define('_MD_SOCIALNET_FORUM_TIMENOW', 'The time now is %s');
define('_MD_SOCIALNET_FORUM_LASTVISIT', 'You last visited: %s');
define('_MD_SOCIALNET_FORUM_ADVSEARCH', 'Advanced Search');
define('_MD_SOCIALNET_FORUM_POSTEDON', 'Posted on: ');
define('_MD_SOCIALNET_FORUM_SUBJECT', 'Subject');
//header.php
define('_MD_SOCIALNET_FORUM_MODERATEDBY', 'Moderated by');
define('_MD_SOCIALNET_FORUM_SEARCH', 'Search');
define('_MD_SOCIALNET_FORUM_SEARCHRESULTS', 'Search Results');
define('_MD_SOCIALNET_FORUM_FORUMINDEX', '%s Forum Index');
define('_MD_SOCIALNET_FORUM_POSTNEW', 'Post New Message');
define('_MD_SOCIALNET_FORUM_REGTOPOST', 'Register To Post');
//forumsearch.php
define('_MD_SOCIALNET_FORUM_KEYWORDS', 'Keywords:');
define('_MD_SOCIALNET_FORUM_SEARCHANY', 'Search for ANY of the terms (Default)');
define('_MD_SOCIALNET_FORUM_SEARCHALL', 'Search for ALL of the terms');
define('_MD_SOCIALNET_FORUM_SEARCHALLFORUMS', 'Search All Forums');
define('_MD_SOCIALNET_FORUM_FORUMC', 'Forum');
define('_MD_SOCIALNET_FORUM_SORTBY', 'Sort by');
define('_MD_SOCIALNET_FORUM_DATE', 'Date');
define('_MD_SOCIALNET_FORUM_TOPIC', 'Topic');
define('_MD_SOCIALNET_FORUM_USERNAME', 'Username');
define('_MD_SOCIALNET_FORUM_SEARCHIN', 'Search in');
define('_MD_SOCIALNET_FORUM_BODY', 'Body');
define('_MD_SOCIALNET_FORUM_NOMATCH', 'No records match that query. Please broaden your search.');
define('_MD_SOCIALNET_FORUM_POSTTIME', 'Post Time');
//forumview.php
define('_MD_SOCIALNET_FORUM_REPLIES', 'Replies');
define('_MD_SOCIALNET_FORUM_POSTER', 'Poster');
define('_MD_SOCIALNET_FORUM_VIEWS', 'Views');
define('_MD_SOCIALNET_FORUM_MORETHAN', 'New posts [ Popular ]');
define('_MD_SOCIALNET_FORUM_MORETHAN2', 'No New posts [ Popular ]');
define('_MD_SOCIALNET_FORUM_TOPICSTICKY', 'Topic is Sticky');
define('_MD_SOCIALNET_FORUM_TOPICLOCKED', 'Topic is Locked');
define('_MD_SOCIALNET_FORUM_LEGEND', 'Legend');
define('_MD_SOCIALNET_FORUM_NEXTPAGE', 'Next Page');
define('_MD_SOCIALNET_FORUM_SORTEDBY', 'Sorted by');
define('_MD_SOCIALNET_FORUM_TOPICTITLE', 'topic title');
define('_MD_SOCIALNET_FORUM_NUMBERREPLIES', 'number of replies');
define('_MD_SOCIALNET_FORUM_TOPICPOSTER', 'topic poster');
define('_MD_SOCIALNET_FORUM_LASTPOSTTIME', 'last post time');
define('_MD_SOCIALNET_FORUM_ASCENDING', 'Ascending order');
define('_MD_SOCIALNET_FORUM_DESCENDING', 'Descending order');
define('_MD_SOCIALNET_FORUM_FROMLASTDAYS', 'From last %s days');
define('_MD_SOCIALNET_FORUM_THELASTYEAR', 'From the last year');
define('_MD_SOCIALNET_FORUM_BEGINNING', 'From the beginning');
//forumviewtopic.php
define('_MD_SOCIALNET_FORUM_AUTHOR', 'Author');
define('_MD_SOCIALNET_FORUM_LOCKTOPIC', 'Lock this topic');
define('_MD_SOCIALNET_FORUM_UNLOCKTOPIC', 'Unlock this topic');
define('_MD_SOCIALNET_FORUM_STICKYTOPIC', 'Make this topic Sticky');
define('_MD_SOCIALNET_FORUM_UNSTICKYTOPIC', 'Make this topic UnSticky');
define('_MD_SOCIALNET_FORUM_MOVETOPIC', 'Move this topic');
define('_MD_SOCIALNET_FORUM_DELETETOPIC', 'Delete this topic');
define('_MD_SOCIALNET_FORUM_TOP', 'Top');
define('_MD_SOCIALNET_FORUM_PARENT', 'Parent');
define('_MD_SOCIALNET_FORUM_PREVTOPIC', 'Previous Topic');
define('_MD_SOCIALNET_FORUM_NEXTTOPIC', 'Next Topic');
//socialnet_forumform.inc
define('_MD_SOCIALNET_FORUM_ABOUTPOST', 'About Posting');
define('_MD_SOCIALNET_FORUM_ANONCANPOST', '<b> Anonymous </b> users can post new topics and replies to this forum');
define('_MD_SOCIALNET_FORUM_PRIVATE', 'This is a <b> Private </b> forum. <br /> Only users with special access can post new topics and replies to this forum');
define('_MD_SOCIALNET_FORUM_MODSCANPOST', 'Only <b> Moderators and Administrators </b> can post new topics and replies to this forum');
define('_MD_SOCIALNET_FORUM_PREVPAGE', 'Previous Page');
define('_MD_SOCIALNET_FORUM_QUOTE', 'Quote');
// ERROR messages
define('_MD_SOCIALNET_FORUM_ERRORFORUM', 'ERROR: Forum not selected!');
define('_MD_SOCIALNET_FORUM_ERRORPOST', 'ERROR: Post not selected!');
define('_MD_SOCIALNET_FORUM_NORIGHTTOPOST', 'You don\'t have the right to post in this forum.');
define('_MD_SOCIALNET_FORUM_NORIGHTTOACCESS', 'You don\'t have the right to access this forum.');
define('_MD_SOCIALNET_FORUM_ERRORTOPIC', 'ERROR: Topic not selected!');
define('_MD_SOCIALNET_FORUM_ERRORCONNECT', 'ERROR: Could not connect to the forums database.');
define('_MD_SOCIALNET_FORUM_ERROREXIST', 'ERROR: The forum you selected does not exist. Please go back and try again.');
define('_MD_SOCIALNET_FORUM_ERROROCCURED', 'An Error Occurred');
define('_MD_SOCIALNET_FORUM_COULDNOTQUERY', 'Could not query the forums database.');
define('_MD_SOCIALNET_FORUM_FORUMNOEXIST', 'Error - The forum / topic you selected does not exist. Please go back and try again.');
define('_MD_SOCIALNET_FORUM_USERNOEXIST', 'That user does not exist.  Please go back and search again.');
define('_MD_SOCIALNET_FORUM_COULDNOTREMOVE', 'Error - Could not remove posts from the database!');
define('_MD_SOCIALNET_FORUM_COULDNOTREMOVETXT', 'Error - Could not remove post texts!');
//forumreply.php
define('_MD_SOCIALNET_FORUM_ON', 'on');
define('_MD_SOCIALNET_FORUM_USERWROTE', '%s wrote:');
//forumpost.php
define('_MD_SOCIALNET_FORUM_EDITNOTALLOWED', 'You\'re not allowed to edit this post!');
define('_MD_SOCIALNET_FORUM_EDITEDBY', 'Edited by');
define('_MD_SOCIALNET_FORUM_ANONNOTALLOWED', 'Anonymous user not allowed to post. <br> Please register.');
define('_MD_SOCIALNET_FORUM_THANKSSUBMIT', 'Thanks for your submission!');
define('_MD_SOCIALNET_FORUM_REPLYPOSTED', 'A reply to your topic has been posted.');
define('_MD_SOCIALNET_FORUM_HELLO', 'Hello %s,');
define('_MD_SOCIALNET_FORUM_URRECEIVING', 'You are receiving this email because a message you posted on %s forums has been replied to.');
define('_MD_SOCIALNET_FORUM_CLICKBELOW', 'Click on the link below to view the thread:');
//include/socialnet_forumform.inc
define('_MD_SOCIALNET_FORUM_YOURNAME', 'Your Name:');
define('_MD_SOCIALNET_FORUM_LOGOUT', 'Logout');
define('_MD_SOCIALNET_FORUM_REGISTER', 'Register');
define('_MD_SOCIALNET_FORUM_SUBJECTC', 'Subject:');
define('_MD_SOCIALNET_FORUM_MESSAGEICON', 'Message Icon:');
define('_MD_SOCIALNET_FORUM_MESSAGEC', 'Message:');
define('_MD_SOCIALNET_FORUM_ALLOWEDHTML', 'Allowed HTML:');
define('_MD_SOCIALNET_FORUM_OPTIONS', 'Options:');
define('_MD_SOCIALNET_FORUM_POSTANONLY', 'Post Anonymously');
define('_MD_SOCIALNET_FORUM_DISABLESMILEY', 'Disable Smiley');
define('_MD_SOCIALNET_FORUM_DISABLEHTML', 'Disable html');
define('_MD_SOCIALNET_FORUM_NEWPOSTNOTIFY', 'Notify me of new posts in this thread');
define('_MD_SOCIALNET_FORUM_ATTACHSIG', 'Attach Signature');
define('_MD_SOCIALNET_FORUM_POST', 'Post');
define('_MD_SOCIALNET_FORUM_SUBMIT', 'Submit');
define('_MD_SOCIALNET_FORUM_CANCELPOST', 'Cancel Post');
//forumpost.php
define('_MD_SOCIALNET_FORUM_ADD', 'Add');
define('_MD_SOCIALNET_FORUM_REPLY', 'Reply');
// forumtopicmanager.php
define('_MD_SOCIALNET_FORUM_YANTMOTFTYCPTF', 'You are not the moderator of this forum therefore you cannot perform this function.');
define('_MD_SOCIALNET_FORUM_TTHBRFTD', 'The topic has been removed from the database.');
define('_MD_SOCIALNET_FORUM_RETURNTOTHEFORUM', 'Return to the forum');
define('_MD_SOCIALNET_FORUM_RTTFI', 'Return to the forum index');
define('_MD_SOCIALNET_FORUM_EPGBATA', 'Error - Please go back and try again.');
define('_MD_SOCIALNET_FORUM_TTHBM', 'The topic has been moved.');
define('_MD_SOCIALNET_FORUM_VTUT', 'View the updated topic');
define('_MD_SOCIALNET_FORUM_TTHBL', 'The topic has been locked.');
define('_MD_SOCIALNET_FORUM_TTHBS', 'The topic has been Stickyed.');
define('_MD_SOCIALNET_FORUM_TTHBUS', 'The topic has been unStickyed.');
define('_MD_SOCIALNET_FORUM_VIEWTHETOPIC', 'View the topic');
define('_MD_SOCIALNET_FORUM_TTHBU', 'The topic has been unlocked.');
define('_MD_SOCIALNET_FORUM_OYPTDBATBOTFTTY', 'Once you press the delete button at the bottom of this form the topic you have selected, and all its related posts, will be <b> permanently </b> removed.');
define('_MD_SOCIALNET_FORUM_OYPTMBATBOTFTTY', 'Once you press the move button at the bottom of this form the topic you have selected, and its related posts, will be moved to the forum you have selected.');
define('_MD_SOCIALNET_FORUM_OYPTLBATBOTFTTY', 'Once you press the lock button at the bottom of this form the topic you have selected will be locked. You may unlock it at a later time if you like.');
define('_MD_SOCIALNET_FORUM_OYPTUBATBOTFTTY', 'Once you press the unlock button at the bottom of this form the topic you have selected will be unlocked. You may lock it again at a later time if you like.');
define('_MD_SOCIALNET_FORUM_OYPTSBATBOTFTTY', 'Once you press the Sticky button at the bottom of this form the topic you have selected will be Stickyed. You may unSticky it again at a later time if you like.');
define('_MD_SOCIALNET_FORUM_OYPTTBATBOTFTTY', 'Once you press the unSticky button at the bottom of this form the topic you have selected will be unStickyed. You may Sticky it again at a later time if you like.');
define('_MD_SOCIALNET_FORUM_MOVETOPICTO', 'Move Topic To:');
define('_MD_SOCIALNET_FORUM_NOFORUMINDB', 'No Forums in DB');
define('_MD_SOCIALNET_FORUM_DATABASEERROR', 'Database Error');
define('_MD_SOCIALNET_FORUM_DELTOPIC', 'Delete Topic');
// forumdelete.php
define('_MD_SOCIALNET_FORUM_DELNOTALLOWED', 'Sorry, but you\'re not allowed to delete this post.');
define('_MD_SOCIALNET_FORUM_AREUSUREDEL', 'Are you sure you want to delete this post and all its child posts?');
define('_MD_SOCIALNET_FORUM_POSTSDELETED', 'Selected post and all its child posts deleted.');
// definitions moved from global.
define('_MD_SOCIALNET_FORUM_THREAD', 'Thread');
define('_MD_SOCIALNET_FORUM_FROM', 'From');
define('_MD_SOCIALNET_FORUM_JOINED', 'Joined');
define('_MD_SOCIALNET_FORUM_ONLINE', 'Online');
define('_MD_SOCIALNET_FORUM_BOTTOM', 'Bottom');
//include/socialnet_forumform.inc
define('_MD_SOCIALNET_FORUM_ATTACH_FILE', 'Attach File');
define('_MD_SOCIALNET_FORUM_ATTACHED_FILES', 'Attached File (s)');
define('_MD_SOCIALNET_FORUM_UPLOAD_DBERROR_SAVE', 'Error while attaching file to the story');
define('_MD_SOCIALNET_FORUM_UPLOAD_ERROR', 'Error while uploading the file');
################# INTEREST FRIENDS #####################
//myfavoritebegin.php
define('_MD_SOCIALNET_INTEREST_REMOVED', 'This Favorite has been removed');
define('_MD_SOCIALNET_INTEREST_NOT_REMOVED', 'This Favorite could not be removed');
define('_MD_SOCIALNET_INTEREST_ADMIRER_REMOVED', 'You have been removed as a Favorite');
define('_MD_SOCIALNET_INTEREST_ADMIRER_NOT', 'You could not be removed as a Favorite');
define('_MD_SOCIALNET_INTEREST_FAV_EMAILSUBJ', '%s: %s has added you as a Favorite!');
define('_MD_SOCIALNET_INTEREST_INT_EMAILSUBJ', '%s - New Interest in your profile!');
define('_MD_SOCIALNET_INTEREST_FAV_ADDED', 'This member has been added as your Favorite');
define('_MD_SOCIALNET_INTEREST_FAV_ALREADY', 'This member is already on your Favorite list');
define('_MD_SOCIALNET_INTEREST_INTERESTED', 'is interested in you!');
define('_MD_SOCIALNET_INTEREST_INTERESTED_BODY', 'Congratulations! %s is interested in you! Reply to this message or view this profile and click Show Interest to let your admirer know that you are interested too!');
define('_MD_SOCIALNET_INTEREST_INTEREST_SENT', 'Your Interest has been sent');
//myfavorite.php
define('_MD_SOCIALNET_INTEREST_ADMIRER_TITLE', 'Who admirers me?');
define('_MD_SOCIALNET_INTEREST_ADMIRER_NONE', 'You haven\'t been added as a Favorite yet.');
define('_MD_SOCIALNET_INTEREST_FAVORITE_TITLE', 'My Favorite Users');
define('_MD_SOCIALNET_INTEREST_FAVORITE_NONE', 'You haven\'t added any profiles to your Favorites List yet. <br> To add a profile as your favorite, please click on the Add Favorite button when browsing the profile.');
define('_MD_SOCIALNET_INTEREST_24HOURS', 'Within 24 hours');
define('_MD_SOCIALNET_INTEREST_48HOURS', 'Within 48 hours');
define('_MD_SOCIALNET_INTEREST_1WEEK', 'Within 1 week');
define('_MD_SOCIALNET_INTEREST_1MONTH', 'Within 1 month');
define('_MD_SOCIALNET_INTEREST_3MONTHS', 'Within 3 months');
define('_MD_SOCIALNET_INTEREST_LONGER', 'Longer than 3 months');
define('_MD_SOCIALNET_INTEREST_LOCATION', 'Location');
define('_MD_SOCIALNET_INTEREST_ACTIVE', 'Last time active');
define('_MD_SOCIALNET_INTEREST_PAGE', 'Page');
define('_MD_SOCIALNET_INTEREST_FAVORITE_NAME', 'Favorite');
define('_MD_SOCIALNET_INTEREST_ADMIRER_NAME', 'Admirer');
define('_MD_SOCIALNET_INTEREST_VIEW_PROFILE', 'View Profile');
define('_MD_SOCIALNET_INTEREST_INTEREST', 'Show Interest');
define('_MD_SOCIALNET_INTEREST_DEL_FAVORITE', 'Delete Favorite');
define('_MD_SOCIALNET_INTEREST_DEL_ADMIRER', 'Delete Admirer');
?>
