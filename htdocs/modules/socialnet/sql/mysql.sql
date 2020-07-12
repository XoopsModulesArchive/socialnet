CREATE TABLE socialnet_friendpetition (
  friendpet_id int(11) NOT NULL auto_increment,
  petitioner_uid int(11) NOT NULL,
  petioned_uid int(11) NOT NULL,
  PRIMARY KEY  (friendpet_id)
) TYPE=MyISAM;
# --------------------------------------------------------

CREATE TABLE socialnet_friendship (
  friendship_id int(11) NOT NULL auto_increment,
  friend1_uid int(11) NOT NULL,
  friend2_uid int(11) NOT NULL,
  level int(11) NOT NULL,
  hot tinyint(4) NOT NULL,
  trust tinyint(4) NOT NULL,
  cool tinyint(4) NOT NULL,
  fan tinyint(4) NOT NULL,
  PRIMARY KEY  (friendship_id)
) TYPE=MyISAM;
INSERT INTO `socialnet_friendship` (`friendship_id`, `friend1_uid`, `friend2_uid`, `level`, `hot`, `trust`, `cool`, `fan`) VALUES
(1, 1, 2, 3, 0, 0, 0, 0),
(2, 2, 1, 5, 3, 3, 3, 1),
(3, 1, 3, 3, 0, 0, 0, 0),
(4, 3, 1, 5, 3, 3, 3, 1),
(5, 1, 4, 3, 0, 0, 0, 0),
(6, 4, 1, 5, 3, 3, 3, 1),
(7, 1, 5, 3, 0, 0, 0, 0),
(8, 5, 1, 5, 3, 3, 3, 1),
(9, 1, 6, 3, 0, 0, 0, 0),
(10, 6, 1, 5, 3, 3, 3, 1),
(11, 1, 7, 3, 0, 0, 0, 0),
(12, 7, 1, 5, 3, 3, 3, 1),
(13, 1, 8, 3, 0, 0, 0, 0),
(14, 8, 1, 5, 3, 3, 3, 1),
(15, 1, 9, 3, 0, 0, 0, 0),
(16, 9, 1, 5, 3, 3, 3, 1),
(17, 1, 10, 3, 0, 0, 0, 0),
(18, 10, 1, 5, 3, 3, 3, 1);
# --------------------------------------------------------

CREATE TABLE socialnet_images (
  cod_img int(11) NOT NULL auto_increment,
  title varchar(255) NOT NULL,
  data_creation date NOT NULL,
  data_update date NOT NULL,
  uid_owner varchar(50) NOT NULL,
  url text NOT NULL,
  private varchar(1) NOT NULL,
  PRIMARY KEY  (cod_img)
) TYPE=MyISAM;
INSERT INTO `socialnet_images` (`cod_img`, `title`, `data_creation`, `data_update`, `uid_owner`, `url`, `private`) VALUES (1, 'SocialNet Is just a module', '2010-01-30', '2010-01-30', '1', 'pic_1_4b640d6b69777.jpg', '0'), (2, 'SocialNet Is just a module', '2010-01-30', '2010-01-30', '1', 'pic_1_4b640d8a8b0a2.jpg', '0'), (3, 'SocialNet Is just a module', '2010-01-30', '2010-01-30', '1', 'pic_1_4b640da62df71.jpg', '0');
# --------------------------------------------------------

CREATE TABLE socialnet_visitors (
  cod_visit int(11) NOT NULL auto_increment,
  uid_owner int(11) NOT NULL,
  uid_visitor int(11) NOT NULL,
  uname_visitor varchar(30) NOT NULL,
  datetime timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (cod_visit)
) TYPE=MyISAM;
# --------------------------------------------------------

CREATE TABLE socialnet_youtube (
  video_id int(11) NOT NULL auto_increment,
  uid_owner int(11) NOT NULL,
  video_desc text NOT NULL,
  youtube_code varchar(11) NOT NULL,
  main_video varchar(1) NOT NULL,
  PRIMARY KEY  (video_id)
) TYPE=MyISAM;
INSERT INTO `socialnet_youtube` (`video_id`, `uid_owner`, `video_desc`, `youtube_code`, `main_video`) VALUES (1, 1, 'Michael W Smith - Awesome God', '38V8jnN1Kpw', '0'), (2, 1, 'Hillsong United ''One Way''', 'IPuUIUWE8h8', '1'), (3, 1, 'Hillsong - Mighty to Save - With Subtitles/Lyrics', '-08YZF87OBQ', '0'), (4, 1, 'Hillsong - From The Inside Out - With Subtitles/Lyrics', 'X-afZJ9_TIM', '');
# --------------------------------------------------------

CREATE TABLE socialnet_relgroupuser (
  rel_id int(11) NOT NULL auto_increment,
  rel_group_id int(11) NOT NULL,
  rel_user_uid int(11) NOT NULL,
  PRIMARY KEY  (rel_id)
) TYPE=MyISAM;
# --------------------------------------------------------

CREATE TABLE socialnet_groups (
  group_id int(11) NOT NULL auto_increment,
  owner_uid int(11) NOT NULL,
  group_title varchar(255) NOT NULL,
  group_desc tinytext NOT NULL,
  group_img varchar(255) NOT NULL,
  PRIMARY KEY  (group_id)
) TYPE=MyISAM;
INSERT INTO `socialnet_groups` (`group_id`, `owner_uid`, `group_title`, `group_desc`, `group_img`) VALUES (1, 1, 'group1', 'This group is for all profile', 'group_15448108.gif'), (2, 1, 'group2', 'This group is for all profile', 'group_12050037.gif'), (3, 1, 'group3', 'This group is for all profile', 'group_17268464.gif');
# --------------------------------------------------------

CREATE TABLE socialnet_scraps (
  scrap_id int(11) NOT NULL auto_increment,
  scrap_text text NOT NULL,
  scrap_from int(11) NOT NULL,
  scrap_to int(11) NOT NULL,
  private tinyint(1) NOT NULL,
  date timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (scrap_id)
) TYPE=MyISAM;
INSERT INTO `socialnet_scraps` (`scrap_id`, `scrap_text`, `scrap_from`, `scrap_to`, `private`, `date`) VALUES (1, 'XOOPS is a web application platform written in PHP for the MySQL database. Its object orientation makes it an ideal tool for developing small or large community websites, intra company and corporate portals, weblogs and much more.', 1, 1, 0, '2009-12-28 04:30:38'), (2, 'XOOPS is released under the terms of the GNU General Public License (GPL) and is free to use and modify. It is free to redistribute as long as you abide by the distribution terms of the GPL.', 1, 1, 0, '2009-12-28 04:31:11');
# --------------------------------------------------------

CREATE TABLE socialnet_configs (
  config_id int(11) NOT NULL auto_increment,
  config_uid int(11) NOT NULL,
  pictures tinyint(1) NOT NULL,
  audio tinyint(1) NOT NULL,
  videos tinyint(1) NOT NULL,
  groups tinyint(1) NOT NULL,
  scraps tinyint(1) NOT NULL,
  friends tinyint(1) NOT NULL,
  profile_contact tinyint(1) NOT NULL,
  profile_general tinyint(1) NOT NULL,
  profile_stats tinyint(1) NOT NULL,
  suspension tinyint(1) NOT NULL,
  backup_password varchar(255) NOT NULL,
  backup_email varchar(255) NOT NULL,
  end_suspension timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (config_id),
  KEY config_uid (config_uid)
) TYPE=MyISAM;
# --------------------------------------------------------

CREATE TABLE socialnet_suspensions (
  uid int(11) NOT NULL,
  old_pass varchar(255) NOT NULL,
  old_email varchar(100) NOT NULL,
  old_signature text NOT NULL,
  suspension_time int(11) NOT NULL,
  old_enc_type int(2) NOT NULL,
  old_pass_expired int(1) NOT NULL,
  PRIMARY KEY  (uid)
) TYPE=MyISAM;
# --------------------------------------------------------

CREATE TABLE socialnet_audio (
  audio_id int(11) NOT NULL auto_increment,
  title varchar(256) NOT NULL,
  author varchar(256) NOT NULL,
  url varchar(256) NOT NULL,
  uid_owner int(11) NOT NULL,
  data_creation date NOT NULL,
  data_update date NOT NULL,
  PRIMARY KEY  (audio_id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `socialnet_userpage`
#

CREATE TABLE socialnet_userpage (
  up_pageid int(10) unsigned NOT NULL auto_increment,
  up_uid mediumint(8) NOT NULL default '0',
  up_title varchar(255) NOT NULL default '',
  up_text text NOT NULL,
  up_created int(10) unsigned NOT NULL default '0',
  up_hits int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (up_pageid),
  KEY up_uid (up_uid),
  KEY up_title (up_title),
  KEY up_hits (up_hits)
) TYPE=MyISAM;
INSERT INTO `socialnet_userpage` (`up_pageid`, `up_uid`, `up_title`, `up_text`, `up_created`, `up_hits`) VALUES (1, 1, 'All About XOOPS', '[url=http://www.xoops.org/modules/wfchannel/]All About XOOPS[/url]\r\nXOOPS is released under the terms of the GNU General Public License (GPL) and is free to use and modify. It is free to redistribute as long as you abide by the distribution terms of the GPL.\r\n\r\nWhat XOOPS stands for\r\nXOOPS is an acronym of eXtensible Object Oriented Portal System. Though started as a portal system, XOOPS is in fact striving steadily on the track of Content Management System. It can serve as a web framework for use by small, medium and large sites.\r\n\r\nA lite XOOPS can be used as a personal weblog or journal. For this purpose, you can do a standard install, and use its News module only. For a medium site, you can use modules like News, Forum, Download, Web Links etc to form a community to interact with your members and visitors. For a large site as an enterprise one, you can develop your own modules such as eShop, and use XOOP''s uniform user management system to seamlessly integrate your modules with the whole system.\r\n\r\nRegards, ADMIN :-)', 1261978241, 0);
# --------------------------------------------------------

######## FROM HERE BEGIN NEWS ##########
#
# Table structure for table `socialnet_article`
#

CREATE TABLE socialnet_article (
  storyid int(8) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  created int(10) unsigned NOT NULL default '0',
  published int(10) unsigned NOT NULL default '0',
  expired int(10) UNSIGNED NOT NULL default '0',
  hostname varchar(20) NOT NULL default '',
  nohtml tinyint(1) NOT NULL default '0',
  nosmiley tinyint(1) NOT NULL default '0',
  counter int(8) unsigned NOT NULL default '0',
  topicid smallint(4) unsigned NOT NULL default '1',
  ihome tinyint(1) NOT NULL default '0',
  notifypub tinyint(1) NOT NULL default '0',
  story_type varchar(5) NOT NULL default '',
  topicdisplay tinyint(1) NOT NULL default '0',
  topicalign char(1) NOT NULL default 'R',
  comments smallint(5) unsigned NOT NULL default '0',
  rating int(3) NOT NULL default '0',
  banner text,
  audienceid int(11) NOT NULL default 1,
  PRIMARY KEY  (storyid),
  KEY idxstoriestopic (topicid),
  KEY ihome (ihome),
  KEY published_ihome (published,ihome),
  KEY title (title(40)),
  KEY created (created),
  FULLTEXT KEY search (title)
) TYPE=MyISAM;
INSERT INTO `socialnet_article` (`storyid`, `title`, `created`, `published`, `expired`, `hostname`, `nohtml`, `nosmiley`, `counter`, `topicid`, `ihome`, `notifypub`, `story_type`, `topicdisplay`, `topicalign`, `comments`, `rating`, `banner`, `audienceid`) VALUES (1, 'Register', 1262388432, 1262388432, 0, '190.164.40.37', 0, 0, 1, 1, 0, 1, 'admin', 1, 'R', 0, 0, '', 1);
# --------------------------------------------------------

#
# Table structure for table `socialnet_text`
#

CREATE TABLE socialnet_text (
  storyid int(8) unsigned NOT NULL,
  version int(8) unsigned NOT NULL default '1',
  revision int(8) unsigned NOT NULL default '0',
  revisionminor int(8) unsigned NOT NULL default '0',
  uid int(5) unsigned NOT NULL default '0',
  hometext text NOT NULL,
  bodytext text NOT NULL,
  current tinyint(2) NOT NULL default '0',
  updated int(10) unsigned NOT NULL default '0',
  PRIMARY KEY (`storyid`, `version`, `revision`, `revisionminor`),
  KEY uid (uid),
  FULLTEXT KEY search (hometext,bodytext)
) TYPE=MyISAM;
INSERT INTO `socialnet_text` (`storyid`, `version`, `revision`, `revisionminor`, `uid`, `hometext`, `bodytext`, `current`, `updated`) VALUES (1, 1, 0, 0, 1, 'Register:\r\nTell your visitors a little about the registration process and its advantages... \r\n\r\nIf you have not already registered for an account you may do so at the registration page. We ask all users to confirm their email address to prevent spamming. \r\n\r\nOnce you are logged in you can access your profile using the "User Menu" on the right side of the screen. You can add or edit information and change your settings. ', 'An account is not needed to read the pages on this page. But it is required to post in the forum and to receive notifications. \r\n\r\nYou may tell your visitors a little about the nature of your site such as... in the case of XOOPS dot ORG \r\n\r\nThis site is absolutely non-commercial. No information is collected or shared. It is up to you how much information you want to present in your profile. All posts are by user-name only, you do not need to give your full name. To prevent spamming an IP address is logged with every post. \r\n\r\nUsing the Forum: \r\nXoops uses the following terminology: There are a number of Forums (e.g. "Getting Started"), each of which contains a number of topics (e.g. "How can I ..."). Each topic is a collection of posts, in the order in which they are posted. \r\n\r\nA good way to catch up with recent activity is to use receive email notifications of new posts. To do so select one of the notification options at the bottom of the Forum main page. You can choose to be notified either by email or private message. \r\n\r\nPosting in the Forum: To reply to a post, simply click the "Reply" button in the forum. To start a new topic first select an appropriate forum, then click "New Topic". \r\n\r\nXoops has some neat features that make it easy to format a post. There are a number of codes you can use:', 1, 1262388432);
# --------------------------------------------------------

#
# Table structure for table `socialnet_newsfiles`
#

CREATE TABLE socialnet_newsfiles (
  fileid int(8) unsigned NOT NULL auto_increment,
  filerealname varchar(255) NOT NULL default '',
  storyid int(8) unsigned NOT NULL default '0',
  date int(10) NOT NULL default '0',
  mimetype varchar(64) NOT NULL default '',
  downloadname varchar(255) NOT NULL default '',
  counter int(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (fileid),
  KEY storyid (storyid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `socialnet_topics`
#

CREATE TABLE socialnet_topics (
  topic_id smallint(4) unsigned NOT NULL auto_increment,
  topic_pid smallint(4) unsigned NOT NULL default '0',
  topic_imgurl varchar(50) NOT NULL default '',
  topic_title varchar(50) NOT NULL default '',
  banner text,
  banner_inherit tinyint(2) NOT NULL default 0,
  forum_id int(12) NOT NULL default 0,
  weight int(5) NOT NULL default 1,
  PRIMARY KEY  (topic_id),
  KEY pid (topic_pid)
) TYPE=MyISAM;
INSERT INTO `socialnet_topics` (`topic_id`, `topic_pid`, `topic_imgurl`, `topic_title`, `banner`, `banner_inherit`, `forum_id`, `weight`) VALUES (1, 0, 'topicnews.gif', 'News', 'Greetings', 0, 0, 1), (2, 0, 'announc.gif', 'Announce', 'Announcement', 0, 0, 1), (3, 0, 'weblinks.gif', 'General', 'General News', 0, 0, 1);
# --------------------------------------------------------

#
# Table structure for table `socialnet_newslink`
#

CREATE TABLE `socialnet_newslink` (
    `linkid` int(12) unsigned NOT NULL auto_increment,
    `storyid` INT(12) NOT NULL,
    `link_module` INT(12) NOT NULL,
    `link_link` varchar(120) NOT NULL default '',
    `link_title` varchar(70) NOT NULL default '',
    `link_counter` int(12) unsigned NOT NULL default 0,
    `link_position` varchar(12) NOT NULL default 'bottom',
    PRIMARY KEY (`linkid`)
) TYPE=MyISAM;
INSERT INTO `socialnet_newslink` (`linkid`, `storyid`, `link_module`, `link_link`, `link_title`, `link_counter`, `link_position`) VALUES (1, 1, -1, 'http://www.ipwgc.com/socialnet/modules/socialnet/youtube.php', 'SocialNet Videos', 0, 'bottom');
# --------------------------------------------------------

#
# Table structure for table `socialnet_newsrating`
#

CREATE TABLE `socialnet_newsrating` (
  ratingid int(11) unsigned NOT NULL auto_increment,
  storyid int(11) unsigned NOT NULL default '0',
  ratinguser int(11) NOT NULL default '0',
  rating smallint(5) unsigned NOT NULL default '0',
  ratinghostname varchar(60) NOT NULL default '',
  ratingtimestamp int(10) NOT NULL default '0',
  PRIMARY KEY  (`ratingid`),
  KEY `ratinguser` (`ratinguser`),
  KEY `ratinghostname` (`ratinghostname`),
  KEY `storyid` (`storyid`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `socialnet_newsaudience`
#

CREATE TABLE socialnet_newsaudience (
  audienceid int(11) unsigned NOT NULL auto_increment,
  audience varchar(30) NOT NULL,
  PRIMARY KEY (audienceid)
) TYPE=MyISAM;
INSERT INTO `socialnet_newsaudience` (`audienceid`, `audience`) VALUES (1, 'Default'), (2, 'Moderator'), (3, 'General');
# --------------------------------------------------------

#
# Table structure for table `socialnet_newsspotlight`
#

CREATE TABLE socialnet_newsspotlight (
  spotlightid int(11) unsigned NOT NULL auto_increment,
  showimage tinyint(1) default 1,
  image varchar (255) default '',
  teaser text,
  autoteaser tinyint(1) default 1,
  maxlength int(5) default 100,
  display tinyint(1) default 1,
  mode tinyint(1) default 1,
  storyid int(12) default 0,
  topicid int(12) default 0,
  weight int(5) default 1,
  PRIMARY KEY  (spotlightid)
) TYPE=MyISAM;
INSERT INTO `socialnet_newsspotlight` (`spotlightid`, `showimage`, `image`, `teaser`, `autoteaser`, `maxlength`, `display`, `mode`, `storyid`, `topicid`, `weight`) VALUES (1, 1, '', '', 1, 100, 1, 1, 0, 0, 1);
# --------------------------------------------------------
######## END NEWS ##########

#
# Table structure for table `socialnet_note`
#

CREATE TABLE socialnet_note (
  xid int(11) NOT NULL auto_increment,
  name varchar(100) NOT NULL default '',
  comment mediumtext NOT NULL,
  PRIMARY KEY  (xid)
) TYPE=MyISAM;
INSERT INTO `socialnet_note` (`xid`, `name`, `comment`) VALUES (1, 'Admin', 'Greetings from SocialNet Administrator  :-) ');
# --------------------------------------------------------

######## BEGIN SPOT IMAGES ##########

CREATE TABLE socialnet_spotimages (
  spot_10_id int(11) unsigned NOT NULL auto_increment,
  sec_10_id int(11) unsigned NOT NULL default '0',
  spot_30_name varchar(100) default '',
  spot_30_link varchar(150) NOT NULL default '',
  spot_11_target tinyint(3) unsigned NOT NULL default '0',
  spot_30_image varchar(150) NOT NULL default '',
  spot_10_access int(11) unsigned NOT NULL default '0',
  spot_12_ative tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (spot_10_id),
  KEY sec_10_id (sec_10_id)
) Type=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `socialnet_sec_section`
#

CREATE TABLE socialnet_sec_section (
  sec_10_id int(11) unsigned NOT NULL auto_increment,
  sec_30_name varchar(100) NOT NULL default '',
  PRIMARY KEY  (sec_10_id)
) Type=MyISAM;
INSERT INTO `socialnet_sec_section` VALUES (1, 'General');
# --------------------------------------------------------

######## BEGIN TREE MENU ##########

CREATE TABLE socialnet_cfi_contentfiles (
  cfi_10_id int(10) unsigned NOT NULL auto_increment,
  cfi_30_name varchar(255) NOT NULL default '',
  cfi_30_file varchar(100) NOT NULL default '',
  cfi_30_mime varchar(100) NOT NULL default '',
  cfi_10_size int(10) NOT NULL default '0',
  cfi_12_show tinyint(1) NOT NULL default '1',
  cfi_22_data int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (cfi_10_id)
) TYPE=MyISAM;
# --------------------------------------------------------

CREATE TABLE socialnet_fil_files (
  fil_10_id int(10) unsigned NOT NULL auto_increment,
  fil_30_name varchar(255) NOT NULL default '',
  fil_30_file varchar(100) NOT NULL default '',
  fil_30_mime varchar(100) NOT NULL default '',
  fil_10_size int(10) NOT NULL default '0',
  fil_12_show tinyint(1) NOT NULL default '1',
  fil_22_data int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (fil_10_id)
) TYPE=MyISAM;
INSERT INTO `socialnet_fil_files` (`fil_10_id`, `fil_30_name`, `fil_30_file`, `fil_30_mime`, `fil_10_size`, `fil_12_show`, `fil_22_data`) VALUES (1, 'banner', 'banner.swf', 'application/x-shockwave-flash', 27175, 1, 1264814829), (2, 'Example xoops_banner', 'xoops_banner.gif', 'image/gif', 3609, 1, 1264815042);
# --------------------------------------------------------

CREATE TABLE socialnet_med_media (
  med_10_id int(10) unsigned NOT NULL auto_increment,
  med_30_name varchar(255) NOT NULL default '',
  med_30_file varchar(100) NOT NULL default '',
  med_10_height int(4) unsigned NOT NULL default '0',
  med_10_width int(4) unsigned NOT NULL default '0',
  med_10_size int(8) unsigned NOT NULL default '0',
  med_12_show tinyint(1) NOT NULL default '1',
  med_22_data int(10) NOT NULL default '0',
  med_10_type int(1) NOT NULL default '1',
  PRIMARY KEY  (med_10_id)
) TYPE=MyISAM;
INSERT INTO `socialnet_med_media` (`med_10_id`, `med_30_name`, `med_30_file`, `med_10_height`, `med_10_width`, `med_10_size`, `med_12_show`, `med_22_data`, `med_10_type`) VALUES (1, 'clock calendar', 'clock_calendar.swf', 130, 130, 38346, 1, 1264813256, 1), (2, 'Sample player2', 'player2.swf', 25, 90, 1194, 1, 1264813915, 1);
# --------------------------------------------------------

CREATE TABLE socialnet_mpb_mpublish (
  mpb_10_id int(10) unsigned NOT NULL auto_increment,
  mpb_10_idpai int(10) NOT NULL default '0',
  usr_10_uid int(10) unsigned NOT NULL default '0',
  mpb_30_menu varchar(50) NOT NULL default '',
  mpb_30_title varchar(100) NOT NULL default '',
  mpb_35_content longtext,
  mpb_12_withoutlink tinyint(1) NOT NULL default '0',
  mpb_30_file varchar(255) default 'NULL',
  mpb_11_visible tinyint(10) unsigned NOT NULL default '1',
  mpb_11_open tinyint(3) unsigned NOT NULL default '0',
  mpb_12_comments tinyint(1) NOT NULL default '0',
  mpb_12_exibesub tinyint(1) NOT NULL default '1',
  mpb_12_recommend tinyint(1) NOT NULL default '1',
  mpb_12_print tinyint(1) NOT NULL default '1',
  mpb_22_create int(10) unsigned NOT NULL default '0',
  mpb_22_uptodate int(10) unsigned NOT NULL default '0',
  mpb_10_order int(10) unsigned default '0',
  mpb_10_counter int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (mpb_10_id),
  KEY mpb_10_idpai (mpb_10_idpai)
) TYPE=MyISAM;
# --------------------------------------------------------

######## TRANSLATOR LANGUAGE TOOL ##########
#
# Table structure for table `socialnet_languages`
#

CREATE TABLE socialnet_languages (
  lang_id int(5) unsigned NOT NULL auto_increment,
  lang_title varchar(100) NOT NULL,
  dirname varchar(30) NOT NULL,
  PRIMARY KEY  (lang_id)
) TYPE=MyISAM;

INSERT INTO `socialnet_languages` VALUES ('', 'English', 'english');
INSERT INTO `socialnet_languages` VALUES ('', 'Traditional Chinese', 'zh-tw');
INSERT INTO `socialnet_languages` VALUES ('', 'Simplified Chinese', 'schinese');
INSERT INTO `socialnet_languages` VALUES ('', 'French', 'french');
INSERT INTO `socialnet_languages` VALUES ('', 'Bulgarian', 'bulgarian');
INSERT INTO `socialnet_languages` VALUES ('', 'German', 'german');
INSERT INTO `socialnet_languages` VALUES ('', 'Portuguesebr', 'portuguesebr');
INSERT INTO `socialnet_languages` VALUES ('', 'Lithuanian', 'lithuanian');
INSERT INTO `socialnet_languages` VALUES ('', 'Spanish', 'spanish');
INSERT INTO `socialnet_languages` VALUES ('', 'Italian', 'italian');
# --------------------------------------------------------

######## SOCIALNET POPCHAT ##########
#
# Table structure for table Pop Chat
#

CREATE TABLE socialnet_chatmember (
	chatid int(8) NOT NULL,
	sessionid varchar(32) NOT NULL,
	uid int(5) unsigned NOT NULL default '0',
	name text,
	host text,
	in_date TIMESTAMP NOT NULL,
	PRIMARY KEY  (chatid,sessionid)
) TYPE=MyISAM;
# --------------------------------------------------------

CREATE TABLE socialnet_chatmessage (
	chatid int(8) NOT NULL,
	input_date DATETIME NOT NULL,
	uid mediumint(8) NOT NULL default '0',
	post_text text,
	view tinyint(1) NOT NULL  default '0',
	PRIMARY KEY  (chatid,input_date)
) TYPE=MyISAM;
# --------------------------------------------------------

CREATE TABLE socialnet_chatmarquee (
  chatid int(8) NOT NULL auto_increment,
  uid mediumint(8) NOT NULL default '0',
  direction smallint(6) NOT NULL default '0',
  scrollamount int(11) NOT NULL default '0',
  behaviour smallint(6) NOT NULL default '0',
  bgcolor varchar(6) NOT NULL default '',
  align smallint(6) NOT NULL default '0',
  height smallint(6) NOT NULL default '0',
  width varchar(4) NOT NULL default '',
  hspace smallint(6) NOT NULL default '0',
  scrolldelay smallint(6) NOT NULL default '0',
  stoponmouseover smallint(6) NOT NULL default '0',
  chatloop smallint(6) NOT NULL default '0',
  vspace smallint(6) NOT NULL default '0',
  content text NOT NULL,
  PRIMARY KEY  (chatid)
) TYPE=MyISAM;
INSERT INTO `socialnet_chatmarquee` (`chatid`, `uid`, `direction`, `scrollamount`, `behaviour`, `bgcolor`, `align`, `height`, `width`, `hspace`, `scrolldelay`, `stoponmouseover`, `chatloop`, `vspace`, `content`) VALUES ('1', '1', '1', '1', '0', '', '0', '20', '95%', '1', '10', '0', '0', '1', '(enter your message here)');
# --------------------------------------------------------

######## SOCIALNET FORUM ##########
#
# Table structure for table `socialnet_forumcategories`
#

CREATE TABLE socialnet_forumcategories (
  cat_id smallint(3) NOT NULL auto_increment,
  cat_title varchar(100) NOT NULL default '',
  cat_order varchar(10) default NULL,
  PRIMARY KEY  (cat_id)
) TYPE=MyISAM;
INSERT INTO `socialnet_forumcategories` (`cat_id`, `cat_title`, `cat_order`) VALUES (1, 'Support', '1'), (2, 'Moderator', '2'), (3, 'General', '3');

# --------------------------------------------------------

#
# Table structure for table `socialnet_forumaccess`
#

CREATE TABLE socialnet_forumaccess (
  forum_id int(4) unsigned NOT NULL default '0',
  user_id int(5) unsigned NOT NULL default '0',
  can_post tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (forum_id,user_id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `socialnet_forummods`
#

CREATE TABLE socialnet_forummods (
  forum_id int(4) unsigned NOT NULL default '0',
  user_id int(5) unsigned NOT NULL default '0',
  KEY forum_user_id (forum_id,user_id)
) TYPE=MyISAM;
INSERT INTO `socialnet_forummods` (`forum_id`, `user_id`) VALUES (1, 1), (2, 1), (3, 1);
# --------------------------------------------------------

#
# Table structure for table `socialnet_forums`
#

CREATE TABLE socialnet_forums (
  forum_id int(4) unsigned NOT NULL auto_increment,
  forum_name varchar(150) NOT NULL default '',
  forum_desc text,
  forum_access tinyint(2) NOT NULL default '1',
  forum_moderator int(2) default NULL,
  forum_topics int(8) NOT NULL default '0',
  forum_posts int(8) NOT NULL default '0',
  forum_last_post_id int(5) unsigned NOT NULL default '0',
  cat_id int(2) NOT NULL default '0',
  forum_type int(10) default '0',
  allow_html ENUM('0','1') DEFAULT '0' NOT NULL,
  allow_sig ENUM('0','1') DEFAULT '0' NOT NULL,
  posts_per_page TINYINT(3) UNSIGNED DEFAULT '20' NOT NULL,
  hot_threshold TINYINT(3) UNSIGNED DEFAULT '10' NOT NULL,
  topics_per_page TINYINT(3) UNSIGNED DEFAULT '20' NOT NULL,
  show_name enum('0','1') NOT NULL default '0',
  show_icons_panel enum('0','1') NOT NULL default '1',
  show_smilies_panel enum('0','1') NOT NULL default '1',
  allow_upload TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  PRIMARY KEY  (forum_id),
  KEY forum_last_post_id (forum_last_post_id),
  KEY cat_id (cat_id)
) TYPE=MyISAM;
INSERT INTO `socialnet_forums` (`forum_id`, `forum_name`, `forum_desc`, `forum_access`, `forum_moderator`, `forum_topics`, `forum_posts`, `forum_last_post_id`, `cat_id`, `forum_type`, `allow_html`, `allow_sig`, `posts_per_page`, `hot_threshold`, `topics_per_page`, `show_name`, `show_icons_panel`, `show_smilies_panel`, `allow_upload`) VALUES (1, 'Support', 'SocialNet Support', 1, NULL, 1, 1, 1, 1, 0, '1', '1', 10, 10, 20, '0', '1', '1', 1), (2, 'Moderator', 'SocialNet Moderator', 1, NULL, 1, 1, 2, 2, 1, '1', '1', 10, 10, 20, '0', '1', '1', 1), (3, 'General', 'All relate to the SocialNet Module', 1, NULL, 1, 1, 3, 3, 0, '1', '1', 10, 10, 20, '0', '1', '1', 1);

# --------------------------------------------------------

#
# Table structure for table `socialnet_forumposts`
#

CREATE TABLE socialnet_forumposts (
  post_id int(8) unsigned NOT NULL auto_increment,
  pid int(8) NOT NULL default '0',
  topic_id int(8) NOT NULL default '0',
  forum_id int(4) NOT NULL default '0',
  post_time int(10) NOT NULL default '0',
  uid int(5) unsigned NOT NULL default '0',
  poster_ip varchar(15) NOT NULL default '',
  subject varchar(255) NOT NULL default '',
  nohtml tinyint(1) NOT NULL default '0',
  nosmiley tinyint(1) NOT NULL default '0',
  icon varchar(25) NOT NULL default '',
  attachsig tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (post_id),
  KEY uid (uid),
  KEY pid (pid),
  KEY subject (subject(40)),
  KEY forumid_uid (forum_id, uid),
  KEY topicid_uid (topic_id, uid),
  KEY topicid_postid_pid (topic_id, post_id, pid),
  FULLTEXT KEY search (subject)
) TYPE=MyISAM;
INSERT INTO `socialnet_forumposts` (`post_id`, `pid`, `topic_id`, `forum_id`, `post_time`, `uid`, `poster_ip`, `subject`, `nohtml`, `nosmiley`, `icon`, `attachsig`) VALUES (1, 0, 1, 1, 1264698693, 1, '190.164.40.37', 'This forum is for support', 0, 0, 'icon3.gif', 1), (2, 0, 2, 2, 1264698905, 1, '190.164.40.37', 'Moderators Support', 0, 0, 'icon3.gif', 1), (3, 0, 3, 3, 1264700013, 1, '190.164.40.37', 'Report Bug', 0, 0, 'icon3.gif', 1);

# --------------------------------------------------------

#
# Table structure for table `socialnet_forumposts_text`
#

CREATE TABLE socialnet_forumposts_text (
  post_id int(8) unsigned NOT NULL auto_increment,
  post_text text,
  PRIMARY KEY  (post_id),
  FULLTEXT KEY search (post_text)
) TYPE=MyISAM;
INSERT INTO `socialnet_forumposts_text` (`post_id`, `post_text`) VALUES (1, 'About Posting: All Registered users can post new topics and replies to this forum\r\n\r\nRegards, :-) \r\nWebmaster'), (2, 'About Posting: This is a Private forum.\r\nOnly users with special access can post new topics and replies to this forum\r\n\r\nRegards,  :-) \r\nWebmaster'), (3, 'About Posting: All Registered users can post new topics and replies to this forum.\r\n\r\nReport any bug to the webmaster of this portal\r\n\r\nRegards,  :-) \r\nWebmaster');

# --------------------------------------------------------

#
# Table structure for table `socialnet_forumtopics`
#

CREATE TABLE socialnet_forumtopics (
  topic_id int(8) unsigned NOT NULL auto_increment,
  topic_title varchar(255) default NULL,
  topic_poster int(5) NOT NULL default '0',
  topic_time int(10) NOT NULL default '0',
  topic_views int(5) NOT NULL default '0',
  topic_replies int(4) NOT NULL default '0',
  topic_last_post_id int(8) unsigned NOT NULL default '0',
  forum_id int(4) NOT NULL default '0',
  topic_status tinyint(1) NOT NULL default '0',
  topic_sticky tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (topic_id),
  KEY forum_id (forum_id),
  KEY topic_last_post_id (topic_last_post_id),
  KEY topic_poster (topic_poster),
  KEY topic_forum (topic_id,forum_id),
  KEY topic_sticky (topic_sticky)
) TYPE=MyISAM;
INSERT INTO `socialnet_forumtopics` (`topic_id`, `topic_title`, `topic_poster`, `topic_time`, `topic_views`, `topic_replies`, `topic_last_post_id`, `forum_id`, `topic_status`, `topic_sticky`) VALUES (1, 'This forum is for support', 1, 1264698693, 1, 0, 1, 1, 0, 0), (2, 'Moderators Support', 1, 1264698905, 1, 0, 2, 2, 0, 0), (3, 'Report Bug', 1, 1264700013, 1, 0, 3, 3, 0, 0);

# --------------------------------------------------------

#
# Table structure for table `socialnet_forumfiles`
#

CREATE TABLE socialnet_forumfiles (
  fileid int(8) unsigned NOT NULL auto_increment,
  filerealname varchar(255) NOT NULL default '',
  post_id int(8) unsigned NOT NULL default '0',
  date int(10) NOT NULL default '0',
  mimetype varchar(64) NOT NULL default '',
  downloadname varchar(255) NOT NULL default '',
  counter int(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (fileid),
  KEY post_id (post_id)
) TYPE=MyISAM;
# --------------------------------------------------------
# 
# Structure de la table `socialnet_birthday` 
# 
CREATE TABLE socialnet_birthday ( 
  uid int(11) NOT NULL default '0', 
  day char(2) NOT NULL default '', 
  month char(2) NOT NULL default '', 
  year varchar(4) NOT NULL default '', 
  PRIMARY KEY `uid`(`uid`) 
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table 'socialnet_buddyfriends'
#

CREATE TABLE socialnet_buddyfriends (
   ref int(11) NOT NULL auto_increment,
   uid int(5) NOT NULL default '0',
   fuid int(5) NOT NULL default '0',
   PRIMARY KEY  (ref),
   UNIQUE KEY REF (ref)
   ) TYPE=MyISAM;
INSERT INTO `socialnet_buddyfriends` (`ref`, `uid`, `fuid`) VALUES
(1, 1, 2), (2, 1, 3), (3, 1, 4), (4, 1, 5), (5, 1, 6), (6, 1, 7), (7, 1, 8), (8, 1, 9), (9, 1, 10);
# --------------------------------------------------------

#
# Table structure for table 'socialnet_interestfriends'
#
CREATE TABLE socialnet_interestfriends (
   ref int(11) NOT NULL auto_increment,
   uid int(5) NOT NULL default '0',
   fuid int(5) NOT NULL default '0',
   PRIMARY KEY  (ref),
   UNIQUE KEY REF (ref)
   ) TYPE=MyISAM;


