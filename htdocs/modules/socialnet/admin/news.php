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

include '../../../include/cp_header.php';
include_once XOOPS_ROOT_PATH . "/class/xoopstopic.php";
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once XOOPS_ROOT_PATH . "/modules/socialnet/class/class.newsstory.php";
include_once XOOPS_ROOT_PATH . "/modules/socialnet/class/class.newstopic.php";
include_once XOOPS_ROOT_PATH . "/modules/socialnet/class/class.sfiles.php";
include_once XOOPS_ROOT_PATH . '/class/uploader.php';
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
include_once "functions.php";
include_once XOOPS_ROOT_PATH . '/modules/socialnet/include/functions.inc.php';

// *******************************************************************************
// **** Main
// *******************************************************************************

$op = 'default';
if ( isset( $_POST ) )
{
    foreach ( $_POST as $k => $v )
    {
        ${$k} = $v;
    }
}

if ( isset( $_GET['op'] ) )
{
    $op = $_GET['op'];
    if ( isset( $_GET['storyid'] ) )
    {
        $storyid = intval( $_GET['storyid'] );
    }
}


/*
* Show new submissions
*/
function newSubmissions()
{
    $storyarray = SocialnetStory :: getAllSubmitted();
    if ( count( $storyarray ) > 0 )
    {
        echo"<table width='100%' border='0' cellspacing='1' class='outer'><tr><td class=\"odd\">";
        echo "<div style='text-align: center;'><b>" . _AM_SOCIALNET_NEWSUB . "</b><br /><table width='100%' border='1'><tr class='bg3'><td align='center'>" . _AM_SOCIALNET_TITLE . "</td><td align='center'>" . _AM_SOCIALNET_POSTED . "</td><td align='center'>" . _AM_SOCIALNET_POSTER . "</td><td align='center'>" . _AM_SOCIALNET_ACTION . "</td></tr>\n";
        foreach( $storyarray as $newstory )
        {
            $uids[] = $newstory->uid();
        }
        $member_handler =& xoops_gethandler('member');
        $users = $member_handler->getUsers(new Criteria('uid', "(".implode(',', array_keys($uids)).")", 'IN') , true);
        foreach( $storyarray as $newstory )
        {
            $newstory -> uname($users);
            echo "<tr><td>\n";
            $title = $newstory->title();
            if ( !isset( $title ) || ( $title == "" ) )
            {
                echo "<a href='news.php?op=edit&amp;storyid=" . $newstory -> storyid() . "'>" . _AD_NOSUBJECT . "</a>\n";
            }
            else
            {
                echo "&nbsp;<a href='../submit_news.php?op=edit&amp;storyid=" . $newstory -> storyid() . "'>" . $title . "</a>\n";
            }
            echo "</td><td align='center' class='nw'>" . formatTimestamp( $newstory -> created(), 's' ) . "</td><td align='center'><a href='" . XOOPS_URL . "/userinfo.php?uid=" . $newstory -> uid() . "'>" . $newstory -> uname . "</a></td><td align='right'><a href='news.php?op=delete&amp;storyid=" . $newstory -> storyid() . "'><img src='../images/icons/dele.gif' />" . _AM_SOCIALNET_DELETE . "</a></td></tr>\n";
        }
        echo "</table></div>\n";
        echo"</td></tr></table>";
        echo "<br />";
    }
}

/*
* Shows last x published stories
*/
function lastStories()
{
    global $xoopsModule, $xoopsModuleConfig;
    $start = (isset($_GET['start'])) ? $_GET['start'] : 0;

    $title = isset($_POST['title']) ? $_POST['title'] : (isset($_GET['title']) ? $_GET['title'] : "");
    $topicid = isset($_POST['topicid']) ? $_POST['topicid'] : (isset($_GET['topicid']) ? $_GET['topicid'] : 0);
    $status = isset($_POST['status']) ? $_POST['status'] : (isset($_GET['status']) ? $_GET['status'] : "none");
    $author = isset($_POST['author']) ? $_POST['author'] : (isset($_GET['author']) ? $_GET['author'] : array());

    $criteria = new CriteriaCompo();
    $querystring = "op=newarticle";
    if (isset($title) && $title != "") {
        $criteria->add(new Criteria('n.title', "%".$title."%", 'LIKE'));
        $querystring .= "&amp;title=".$title;
    }
    if (isset($author) && is_array($author) && count($author) != 0) {
        $criteria->add(new Criteria('t.uid', "(".implode($author).")", 'IN'));
        foreach ($author as $uid) {
            $querystring .= "&amp;author[]=".$uid;
        }
    }

    if (isset($status) && $status != 'none') {
        if ($status == "published") {
            $status_crit = new CriteriaCompo(new Criteria('n.published', 0, '>'));
            $status_crit->add(new Criteria('n.published', time(), '<='));
            $status_exp= new CriteriaCompo(new Criteria('n.expired', 0));
            $status_exp->add(new Criteria('n.expired', time(), '>='), 'OR');
            $status_crit->add($status_exp);
            $criteria->add($status_crit);
        }
        elseif ($status == "expired") {
            $criteria->add(new Criteria('n.expired', 0, '!='));
            $criteria->add(new Criteria('n.expired', time(), '<'));
        }
    }

    if (isset($topicid) && $topicid != 0) {
        $criteria->add(new Criteria('n.topicid', $topicid));
    }

    $order = isset($_POST['order']) ? $_POST['order'] : (isset($_GET['order']) ? $_GET['order'] : 'DESC');
    $revOrder = $order == 'DESC' ? 'ASC' : 'DESC';
    $criteria->setOrder($order);

    $sort = isset($_POST['sort']) ? $_POST['sort'] : (isset($_GET['sort']) ? $_GET['sort'] : 'n.published');
    $criteria->setSort($sort);
    $revString = $querystring."&amp;sort=".$sort."&amp;order=".$revOrder;
    $querystring .= "&amp;order=".$order;

    include 'filterform.php';
    $fform->display();

    echo"<table width='100%' border='0' cellspacing='1' class='outer'><tr><td class=\"odd\">";
    echo "<div style='text-align: center;'><b>" ._AM_SOCIALNET_PUBLISHEDARTICLES . "</b> <a href='?".$revString."'>"._AM_SOCIALNET_SORT." ".$revOrder."</a><br />";

    $storyarray = SocialnetStory :: getAllNews($xoopsModuleConfig['storycountadmin'], $start, $criteria);
    $storyids = array_keys($storyarray);
    $versioncount_arr = SocialnetStory::getVersionCounts($storyids);
    echo "<table border='1' width='100%'><tr class='bg3'>
            <td align='center'><a href='?".$querystring."&amp;sort=n.storyid'>" . _AM_SOCIALNET_STORYID . "</a></td>
            <td align='center'><a href='?".$querystring."&amp;sort=n.title'>" . _AM_SOCIALNET_TITLE . "</a></td>
            <td align='center'>" . _AM_SOCIALNET_VERSION . "</td>
            <td align='center'>" . _AM_SOCIALNET_TOPIC . "</td>
            <td align='center'>" . _AM_SOCIALNET_POSTER . "</td>
            <td align='center'><a href='?".$querystring."&amp;sort=n.published'>" . _AM_SOCIALNET_PUBLISHED . "</a></td>
            <td align='center'>"._AM_SOCIALNET_VERSIONCOUNT."</td>
            <td align='center'><a href='?".$querystring."&amp;sort=n.counter'>" . _AM_SOCIALNET_HITS . "</a></td>
            <td align='center'><a href='?".$querystring."&amp;sort=n.rating'>" . _AM_SOCIALNET_RATING . "</a></td>
            <td align='center'><a href='?".$querystring."&amp;sort=n.comments'>" . _AM_SOCIALNET_COMMENTS . "</a></td>
            <td align='center'>" . _AM_SOCIALNET_ACTION . "</td></tr>";
    foreach( $storyarray as $eachstory )
    {
        $uids[] = $eachstory->uid();
    }
    $member_handler =& xoops_gethandler('member');
    $users = $member_handler->getUsers(new Criteria('uid', "(".implode(',', array_keys($uids)).")", 'IN') , true);
    foreach( $storyarray as $storyid => $eachstory ) {
        $eachstory -> uname($users);
        $published = formatTimestamp( $eachstory -> published(), 's' );
        //$expired = ( $eachstory -> expired() > 0 ) ? formatTimestamp( $eachstory -> expired(), 's' ) : '---';
        $topic = $eachstory -> topic();
        echo "
        	<tr><td align='center'><b>" . $storyid . "</b>
        	</td><td align='left'><a href='" . XOOPS_URL . "/modules/" . $xoopsModule -> dirname() . "/newsarticle.php?storyid=" . $eachstory -> storyid() . "'>" . $eachstory -> title() . "</a>
        	</td><td align='left'>".$eachstory->version()."
            </td><td align='center'>" . $topic -> topic_title() . "
        	</td><td align='center'><a href='" . XOOPS_URL . "/userinfo.php?uid=" . $eachstory -> uid() . "'>" . $eachstory->uname . "</a></td>
            <td align='center' class='nw'>" . $published . "</td>
            <td align='center'>" . $versioncount_arr[$eachstory->storyid()]."</td>
            <td align='center'>" . $eachstory -> counter() . "</td>
            <td align='center'>" . $eachstory -> rating . "</td>
            <td align='center'>" . $eachstory -> comments() . "</td>
            <td align='center'><a href='../submit_news.php?op=edit&amp;storyid=" . $eachstory -> storyid() . "'><img src='../images/icons/edit.gif' />" . _AM_SOCIALNET_EDIT . "</a>-<a href='news.php?op=delete&amp;storyid=" . $eachstory -> storyid() . "'><img src='../images/icons/dele.gif' />" . _AM_SOCIALNET_DELETE . "</a>";
        echo "</td></tr>\n";
    }
    echo "</table><br /></div>";
    echo"</td></tr></table><br />";
    $totalPublished = SocialnetStory::countPublishedByTopic();
    if ($totalPublished > $xoopsModuleConfig['storycountadmin']) {
        include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
        $pagenav = new XoopsPageNav($totalPublished, $xoopsModuleConfig['storycountadmin'], $start, 'start', $querystring);
        echo $pagenav->renderNav();
    }
}

/*
* Display a list of all the existing topics and enable the user to add or modify an existing topic
*/
function topicsmanager()
{
    global $xoopsModule, $xoopsModuleConfig, $xoopsDB;
    include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
    //$uploadfolder=sprintf(_AM_SOCIALNET_UPLOAD_WARNING,XOOPS_URL . "/modules/" . $xoopsModule -> dirname().'/images/topics');
    $uploadirectory="/modules/" . $xoopsModule -> dirname().'/images/topics';
    $start = isset( $_GET['start'] ) ? intval( $_GET['start'] ) : 0;

    include_once(XOOPS_ROOT_PATH."/class/tree.php");
    $xt = new SocialnetTopic($xoopsDB -> prefix("socialnet_topics"));
    $allTopics = $xt->getAllTopics();
    $totaltopics = count($allTopics);
    if ($totaltopics > 0) {
        $topic_obj_tree = new XoopsObjectTree($allTopics, 'topic_id', 'topic_pid');
        $topics_arr = $topic_obj_tree->getAllChild(0);
    }
    echo "<form action='news.php' method='POST'>";
    echo"<div class=\"odd\">";
    echo "<div style='text-align: center;'><b>" . _AM_SOCIALNET_TOPICSMNGR . ' (' . ($start +1) .'-'. (($start + $xoopsModuleConfig['storycountadmin']) > $totaltopics ? $totaltopics : $start + $xoopsModuleConfig['storycountadmin']) .' '._AM_SOCIALNET_OF.' '. $totaltopics . ')' . "</b><br /><br />";
    echo "<table border='1' width='100%'><tr class='bg3'><td align='center'>" . _AM_SOCIALNET_TOPIC . "</td><td align='left'>" . _AM_SOCIALNET_TOPICNAME . "</td><td align='center'>" . _AM_SOCIALNET_PARENTTOPIC . "</td><td> ". _AM_SOCIALNET_WEIGHT." </td><td align='center'>" . _AM_SOCIALNET_ACTION . "</td></tr>";

    if($totaltopics > 0 ) {
        $i = 0;
        foreach ($topics_arr as $thisTopic) {
            $i++;
            if ($i > $start && $i - $start <= $xoopsModuleConfig['storycountadmin']) {
                $linkedit = XOOPS_URL . '/modules/'.$xoopsModule->dirname() . '/admin/news.php?op=topicsmanager&amp;topic_id=' . $thisTopic->topic_id();
                $linkdelete = XOOPS_URL . '/modules/'.$xoopsModule->dirname() . '/admin/news.php?op=delTopic&amp;topic_id=' . $thisTopic->topic_id();
                $action=sprintf("<a href='%s'>%s</a> - <a href='%s'>%s</a>",$linkedit,_AM_SOCIALNET_EDIT , $linkdelete, _AM_SOCIALNET_DELETE);
                $parent='&nbsp;';
                $pid = $thisTopic->topic_pid();
                if($pid  > 0)
                {
                    $parent = $topics_arr[$pid]->topic_title();
                    $thisTopic->prefix = str_replace(".","-",$thisTopic->prefix) . '&nbsp;&nbsp;';
                }
                else {
                    $thisTopic->prefix = str_replace(".","",$thisTopic->prefix);
                }
                echo "<tr><td>" . $thisTopic->topic_id() . "</td><td align='left'>" . $thisTopic->prefix() . $thisTopic->topic_title() . "</td><td align='left'>" . $parent . "</td><td align='center'><input type='text' name='weight[".$thisTopic->topic_id()."]' value='".$thisTopic->weight."' size='10' maxlength='10' /> </td><td>" . $action . "</td></tr>";
            }
        }
        echo "<tr><td colspan='3'></td><td><input type='hidden' name='op' value='reorder' />
                <input type='submit' name='submit' value='"._AM_SOCIALNET_SUBMIT."' /></td><td></td></tr>";
    }
    echo "</table></div></div></form>";
    if ($totaltopics > $xoopsModuleConfig['storycountadmin']) {
        $pagenav = new XoopsPageNav( $totaltopics, $xoopsModuleConfig['storycountadmin'], $start, 'start', 'op=topicsmanager');
        echo "<div align='right'>";
        echo $pagenav->renderNav().'</div><br />';
    }

    $topic_id = isset( $_GET['topic_id'] ) ? intval( $_GET['topic_id'] ) : 0;
    if($topic_id>0)
    {
        $xtmod = $topics_arr[$topic_id];
        $topic_title=$xtmod->topic_title('E');
        $op='modTopicS';
        if(trim($xtmod->topic_imgurl())!='') {
            $topicimage=$xtmod->topic_imgurl();
        } else {
            $topicimage="blank.png";
        }
        $btnlabel=_AM_SOCIALNET_MODIFY;
        $parent=$xtmod->topic_pid();
        $formlabel=_AM_SOCIALNET_MODIFYTOPIC;
        $banner = $xtmod->banner;
        $banner_inherit = $xtmod->banner_inherit;
        $forum = $xtmod->forum_id;
        unset($xtmod);
    }
    else
    {
        $topic_title='';
        $op='addTopic';
        $topicimage='xoops.gif';
        $btnlabel=_AM_SOCIALNET_ADD;
        $parent=0;
        $formlabel=_AM_SOCIALNET_ADD_TOPIC;
        $banner = '';
        $banner_inherit = 0;
        $forum = 0;
    }

    $sform = new XoopsThemeForm($formlabel, "topicform", XOOPS_URL.'/modules/socialnet/admin/news.php', 'post');
    $sform->setExtra('enctype="multipart/form-data"');
    $sform->addElement(new XoopsFormText(_AM_SOCIALNET_TOPICNAME . ' ' . _AM_SOCIALNET_MAX40CHAR, 'topic_title', 40, 50, $topic_title), true);
    $sform->addElement(new XoopsFormHidden('op', $op), false);
    $sform->addElement(new XoopsFormHidden('topic_id', $topic_id), false);

    if ($totaltopics > 0) {
        $sform->addElement(new XoopsFormLabel(_AM_SOCIALNET_PARENTTOPIC, $topic_obj_tree->makeSelBox('topic_pid', 'topic_title', '--', $parent, true)));
    }
    else {
        $sform->addElement(new XoopsFormHidden('topic_pid', 0));
    }
    // ********** Picture
    $imgtray = new XoopsFormElementTray(_AM_SOCIALNET_TOPICIMG,'<br />');

    $imgpath=sprintf(_AM_SOCIALNET_IMGNAEXLOC, "modules/" . $xoopsModule -> dirname() . "/images/topics/" );
    $imageselect= new XoopsFormSelect($imgpath, 'topic_imgurl',$topicimage);
    $topics_array = XoopsLists :: getImgListAsArray( XOOPS_ROOT_PATH . "/modules/socialnet/images/topics/" );
    foreach( $topics_array as $image )
    {
        $imageselect->addOption("$image", $image);
    }
    $imageselect->setExtra( "onchange='showImgSelected(\"image3\", \"topic_imgurl\", \"" . $uploadirectory . "\", \"\", \"" . XOOPS_URL . "\")'" );
    $imgtray->addElement($imageselect,false);
    $imgtray -> addElement( new XoopsFormLabel( '', "<br /><img src='" . XOOPS_URL . "/" . $uploadirectory . "/" . $topicimage . "' name='image3' id='image3' alt='' />" ) );


    $uploadfolder=sprintf(_AM_SOCIALNET_UPLOAD_WARNING,XOOPS_URL . "/modules/" . $xoopsModule -> dirname().'/images/topics');
    $fileseltray= new XoopsFormElementTray('','<br />');
    $fileseltray->addElement(new XoopsFormFile(_AM_SOCIALNET_TOPIC_PICTURE , 'attachedfile', $xoopsModuleConfig['maxuploadsize']), false);
    $fileseltray->addElement(new XoopsFormLabel($uploadfolder ), false);
    $imgtray->addElement($fileseltray);
    $sform->addElement($imgtray);

    //Forum linking
    $module_handler =& xoops_gethandler('module');
    $forum_module =& $module_handler->getByDirname('newbb');
    if (is_object($forum_module) && $forum_module->getVar('version') >= 200) {
        $forum_handler =& xoops_getmodulehandler('forum', 'newbb', true);
        if (is_object($forum_handler)) {
            $forums = $forum_handler->getForums();
            if (count($forums) > 0) {
                $forum_tree = new XoopsObjectTree($forums, 'forum_id', 'parent_forum');
                $sform->addElement(new XoopsFormLabel(_AM_SOCIALNET_LINKEDFORUM, $forum_tree->makeSelBox('forum_id', 'forum_name', '--', $forum, true)));
            }
        }
    }


    //Banner
    $sform->addElement(new XoopsFormDhtmlTextArea(_AM_SOCIALNET_TOPICBANNER, 'banner', $banner));
    $inherit_checkbox = new XoopsFormCheckBox(_AM_SOCIALNET_BANNERINHERIT, 'banner_inherit', $banner_inherit);
    $inherit_checkbox->addOption(1, _YES);
    $sform->addElement($inherit_checkbox);

	// Permissions
    $member_handler = & xoops_gethandler('member');
    $group_list = &$member_handler->getGroupList();
    $gperm_handler = &xoops_gethandler('groupperm');
    $full_list = array_keys($group_list);

	$groups_ids = array();
    if($topic_id > 0) {		// Edit mode
    	$groups_ids = $gperm_handler->getGroupIds('socialnet_approve', $topic_id, $xoopsModule->getVar('mid'));
    	$groups_ids = array_values($groups_ids);
    	$groups_socialnet_can_approve_checkbox = new XoopsFormCheckBox(_AM_SOCIALNET_APPROVEFORM, 'groups_socialnet_can_approve[]', $groups_ids);
    } else {	// Creation mode
    	$groups_socialnet_can_approve_checkbox = new XoopsFormCheckBox(_AM_SOCIALNET_APPROVEFORM, 'groups_socialnet_can_approve[]');
    }
    $groups_socialnet_can_approve_checkbox->addOptionArray($group_list);
    $sform->addElement($groups_socialnet_can_approve_checkbox);

	$groups_ids = array();
    if($topic_id > 0) {		// Edit mode
    	$groups_ids = $gperm_handler->getGroupIds('socialnet_submit', $topic_id, $xoopsModule->getVar('mid'));
    	$groups_ids = array_values($groups_ids);
    	$groups_socialnet_can_submit_checkbox = new XoopsFormCheckBox(_AM_SOCIALNET_SUBMITFORM, 'groups_socialnet_can_submit[]', $groups_ids);
    } else {	// Creation mode
    	$groups_socialnet_can_submit_checkbox = new XoopsFormCheckBox(_AM_SOCIALNET_SUBMITFORM, 'groups_socialnet_can_submit[]');
    }
    $groups_socialnet_can_submit_checkbox->addOptionArray($group_list);
    $sform->addElement($groups_socialnet_can_submit_checkbox);

	$groups_ids = array();
    if($topic_id > 0) {		// Edit mode
    	$groups_ids = $gperm_handler->getGroupIds('socialnet_view', $topic_id, $xoopsModule->getVar('mid'));
    	$groups_ids = array_values($groups_ids);
    	$groups_socialnet_can_view_checkbox = new XoopsFormCheckBox(_AM_SOCIALNET_VIEWFORM, 'groups_socialnet_can_view[]', $groups_ids);
    } else {	// Creation mode
    	$groups_socialnet_can_view_checkbox = new XoopsFormCheckBox(_AM_SOCIALNET_VIEWFORM, 'groups_socialnet_can_view[]', $full_list);
    }
    $groups_socialnet_can_view_checkbox->addOptionArray($group_list);
    $sform->addElement($groups_socialnet_can_view_checkbox);
	
    // Submit buttons
    $button_tray = new XoopsFormElementTray('' ,'');
    $submit_btn = new XoopsFormButton('', 'post', $btnlabel, 'submit');
    $button_tray->addElement($submit_btn);
    $sform->addElement($button_tray);
    $sform->display();
}

/*
* Save a topic after it has been modified
*/
function modTopicS()
{
    global $xoopsDB, $xoopsModule, $xoopsModuleConfig;
    $xt = new SocialnetTopic( $xoopsDB -> prefix( "socialnet_topics" ), $_POST['topic_id'] );
    if ( $_POST['topic_pid'] == $_POST['topic_id'] )
    {
        redirect_header( 'news.php?op=topicsmanager', 2, _AM_SOCIALNET_ADD_TOPIC_ERROR1 );
    }
    $xt -> setTopicPid( $_POST['topic_pid'] );
    if ( empty( $_POST['topic_title'] ) )
    {
        redirect_header( "news.php?op=topicsmanager", 2, _AM_SOCIALNET_ERRORTOPICNAME );
    }
    $xt -> setTopicTitle( $_POST['topic_title'] );
    if ( isset( $_POST['topic_imgurl'] ) && $_POST['topic_imgurl'] != "" )
    {
        $xt -> setTopicImgurl($_POST['topic_imgurl']);
    }

    $xt->banner_inherit = (isset($_POST['banner_inherit']) ) ? 1 : 0;
    $xt->banner = $_POST['banner'];
    $xt->forum_id = isset($_POST['forum_id']) ? intval($_POST['forum_id']) : 0;

    if(isset($_POST['xoops_upload_file']))
    {
        $fldname = $_FILES[$_POST['xoops_upload_file'][0]];
        $fldname = (get_magic_quotes_gpc()) ? stripslashes($fldname['name']) : $fldname['name'];
        if(trim($fldname!=''))
        {
            $sfiles = new sFiles();
            $dstpath = XOOPS_ROOT_PATH . "/modules/" . $xoopsModule -> dirname() . '/images/topics';
            $destname=$sfiles->createUploadName($dstpath ,$fldname, true);
            $permittedtypes=array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png');
            $uploader = new XoopsMediaUploader($dstpath, $permittedtypes, $xoopsModuleConfig['maxuploadsize']);
            $uploader->setTargetFileName($destname);
            if ($uploader->fetchMedia($_POST['xoops_upload_file'][0]))
            {
                if ($uploader->upload()) {
                    $xt->setTopicImgurl(basename($destname));
                } else {
                    echo _AM_SOCIALNET_UPLOAD_ERROR;
                }
            } else {
                echo $uploader->getErrors();
            }
        }
    }

    $xt -> store();
    
    //Added in Socialnet  Use News permission style
    // Permissions
    $gperm_handler = &xoops_gethandler('groupperm');
    $criteria = new CriteriaCompo();
    $criteria->add(new Criteria('gperm_itemid', $xt->topic_id(), '='));
    $criteria->add(new Criteria('gperm_modid', $xoopsModule->getVar('mid'),'='));
    $criteria->add(new Criteria('gperm_name', 'socialnet_approve', '='));
    $gperm_handler->deleteAll($criteria);

    $criteria = new CriteriaCompo();
    $criteria->add(new Criteria('gperm_itemid', $xt->topic_id(), '='));
    $criteria->add(new Criteria('gperm_modid', $xoopsModule->getVar('mid'),'='));
    $criteria->add(new Criteria('gperm_name', 'socialnet_submit', '='));
    $gperm_handler->deleteAll($criteria);

    $criteria = new CriteriaCompo();
    $criteria->add(new Criteria('gperm_itemid', $xt->topic_id(), '='));
    $criteria->add(new Criteria('gperm_modid', $xoopsModule->getVar('mid'),'='));
    $criteria->add(new Criteria('gperm_name', 'socialnet_view', '='));
    $gperm_handler->deleteAll($criteria);

    if(isset($_POST['groups_socialnet_can_approve'])) {
        foreach($_POST['groups_socialnet_can_approve'] as $onegroup_id) {
            $gperm_handler->addRight('socialnet_approve', $xt->topic_id(), $onegroup_id, $xoopsModule->getVar('mid'));
        }
    }

    if(isset($_POST['groups_socialnet_can_submit'])) {
        foreach($_POST['groups_socialnet_can_submit'] as $onegroup_id) {
            $gperm_handler->addRight('socialnet_submit', $xt->topic_id(), $onegroup_id, $xoopsModule->getVar('mid'));
        }
    }

    if(isset($_POST['groups_socialnet_can_view'])) {
        foreach($_POST['groups_socialnet_can_view'] as $onegroup_id) {
            $gperm_handler->addRight('socialnet_view', $xt->topic_id(), $onegroup_id, $xoopsModule->getVar('mid'));
        }
    }

    socialnet_updateCache();    
    
    redirect_header( 'news.php?op=topicsmanager', 1, _AM_SOCIALNET_DBUPDATED );
    exit();
}

function delTopic()
{
    if (!isset($_REQUEST['topic_id']) || $_REQUEST['topic_id'] == 0) {
        redirect_header('news.php?op=topicsmanager', 3, _AM_SOCIALNET_NOTOPICSELECTED);
    }
    global $xoopsDB, $xoopsModule;
    if (!isset($_POST['ok']))
    {
        echo "<h4>" . _AM_SOCIALNET_CONFIG . "</h4>";
        $xt = new XoopsTopic( $xoopsDB -> prefix( "socialnet_topics" ), intval($_GET['topic_id']) );
        xoops_confirm( array( 'op' => 'delTopic', 'topic_id' => intval( $_GET['topic_id'] ), 'ok' => 1 ), 'news.php', _AM_SOCIALNET_WAYSYWTDTTAL . '<br />' . $xt->topic_title('S'));
    }
    else
    {
        $xt = new XoopsTopic( $xoopsDB -> prefix( "socialnet_topics" ), intval($_POST['topic_id']) );
        // get all subtopics under the specified topic
        $topic_arr = $xt -> getAllChildTopics();
        array_push( $topic_arr, $xt );
        foreach( $topic_arr as $eachtopic )
        {
            // get all stories in each topic
            $story_arr = SocialnetStory :: getByTopic( $eachtopic -> topic_id() );
            foreach( $story_arr as $eachstory )
            {
                if (false != $eachstory->delete())
                {
                    xoops_comment_delete( $xoopsModule -> getVar( 'mid' ), $eachstory -> storyid() );
                    xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'story', $eachstory->storyid());
                }
            }
            // all stories for each topic is deleted, now delete the topic data
            $eachtopic -> delete();
            // Delete also the notifications and permissions
            xoops_notification_deletebyitem( $xoopsModule -> getVar( 'mid' ), 'category', $eachtopic -> topic_id );
            xoops_groupperm_deletebymoditem($xoopsModule->getVar('mid'), 'socialnet_approve', $eachtopic -> topic_id);
            xoops_groupperm_deletebymoditem($xoopsModule->getVar('mid'), 'socialnet_submit', $eachtopic -> topic_id);
            xoops_groupperm_deletebymoditem($xoopsModule->getVar('mid'), 'socialnet_view', $eachtopic -> topic_id);
        }
        redirect_header( 'news.php?op=topicsmanager', 1, _AM_SOCIALNET_DBUPDATED );
        exit();
    }
}

function addTopic()
{
    global $xoopsDB, $xoopsModule, $xoopsModuleConfig;
    $topicpid = isset($_POST['topic_pid']) ? intval($_POST['topic_pid']) : 0;
    $xt = new SocialnetTopic( $xoopsDB -> prefix( "socialnet_topics" ) );
    if ( !$xt -> topicExists( $topicpid, $_POST['topic_title'] ) )
    {
        $xt -> setTopicPid( $topicpid );
        if ( empty( $_POST['topic_title']) || trim($_POST['topic_title'])=='' )
        {
            redirect_header( "news.php?op=topicsmanager", 2, _AM_SOCIALNET_ERRORTOPICNAME );
        }
        $xt -> setTopicTitle( $_POST['topic_title'] );
        if ( isset( $_POST['topic_imgurl'] ) && $_POST['topic_imgurl'] != "" )
        {
            $xt -> setTopicImgurl( $_POST['topic_imgurl'] );
        }

        if(isset($_POST['xoops_upload_file']))
        {
            $fldname = $_FILES[$_POST['xoops_upload_file'][0]];
            $fldname = (get_magic_quotes_gpc()) ? stripslashes($fldname['name']) : $fldname['name'];
            if(trim($fldname!=''))
            {
                $sfiles = new sFiles();
                $dstpath = XOOPS_ROOT_PATH . "/modules/" . $xoopsModule -> dirname() . '/images/topics';
                $destname=$sfiles->createUploadName($dstpath ,$fldname, true);
                $permittedtypes=array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png');
                $uploader = new XoopsMediaUploader($dstpath, $permittedtypes, $xoopsModuleConfig['maxuploadsize']);
                $uploader->setTargetFileName($destname);
                if ($uploader->fetchMedia($_POST['xoops_upload_file'][0]))
                {
                    if ($uploader->upload()) {
                        $xt->setTopicImgurl(basename($destname));
                    } else {
                        echo _AM_SOCIALNET_UPLOAD_ERROR;
                    }
                } else {
                    echo $uploader->getErrors();
                }
            }
        }
            
        $xt->banner_inherit = (isset($_POST['banner_inherit']) ) ? 1 : 0;
        $xt->banner = $_POST['banner'];
        $xt->forum_id = isset($_POST['forum_id']) ? intval($_POST['forum_id']) : 0;
        if ($xt -> store()) {
		
	
		    // Permissions
		    $gperm_handler = &xoops_gethandler('groupperm');
		    if(isset($_POST['groups_socialnet_can_approve'])) {
		        foreach($_POST['groups_socialnet_can_approve'] as $onegroup_id) {
		            $gperm_handler->addRight('socialnet_approve', $xt->topic_id(), $onegroup_id, $xoopsModule->getVar('mid'));
		        }
		    }

		    if(isset($_POST['groups_socialnet_can_submit'])) {
		        foreach($_POST['groups_socialnet_can_submit'] as $onegroup_id) {
		            $gperm_handler->addRight('socialnet_submit', $xt->topic_id(), $onegroup_id, $xoopsModule->getVar('mid'));
		        }
		    }

		    if(isset($_POST['groups_socialnet_can_view'])) {
		        foreach($_POST['groups_socialnet_can_view'] as $onegroup_id) {
		            $gperm_handler->addRight('socialnet_view', $xt->topic_id(), $onegroup_id, $xoopsModule->getVar('mid'));
		        }
		    }
		    socialnet_updateCache();
	
            $notification_handler = & xoops_gethandler( 'notification' );
            $tags = array();
            $tags['TOPIC_NAME'] = $_POST['topic_title'];
            $notification_handler -> triggerEvent( 'global', 0, 'new_category', $tags );
            redirect_header( 'news.php?op=topicsmanager', 1, _AM_SOCIALNET_DBUPDATED );
            exit();
        }

    }
    else
    {
        redirect_header( 'news.php?op=topicsmanager', 2, _AM_SOCIALNET_ADD_TOPIC_ERROR );
        exit();
    }

    
}

function listAudience() {
    $audience_handler =& xoops_getmodulehandler('audience', 'socialnet');
    $all_audiences = $audience_handler->getAllAudiences();
    $output = "";
    if (is_array($all_audiences) && count($all_audiences) > 0) {
        $output = "<table>";
        foreach ($all_audiences as $audid => $audience) {
            $output .= "<tr><td class='odd'>".$audid."</td>
            <td class='even'><a href='?op=audience&amp;audid=".$audid."'>".$audience->getVar('audience')."</a></td>
            <td class='even'>";
            if ($audid != 1) {
                $output .= "<a href='?op=delaudience&amp;audienceid=".$audid."'>"._AM_SOCIALNET_DELETE."</a>";
            }
            $output .= "</td>
            </tr>";
        }
        $output .= "</table>";
    }
    return $output;
}

function audienceForm($id = 0) {
    $id = intval($id);
    if ($id > 0) {
        global $xoopsModule;
        $audience_handler =& xoops_getmodulehandler('audience', 'socialnet');
        $thisaudience =& $audience_handler->get($id);
        $audience = $thisaudience->getVar('audience');
        $gperm_handler =& xoops_gethandler('groupperm');
        $groups = $gperm_handler->getGroupIds("socialnet_newsaudience", $id, $xoopsModule->getVar('mid'));
    }
    else {
        $audience = "";
        $groups = array();
    }
    include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
    $aform = new XoopsThemeForm(_AM_SOCIALNET_MANAGEAUDIENCES, "audienceform", 'news.php', 'post');
    if ($id > 0) {
        $aform->addElement(new XoopsFormHidden('aid', $id));
    }
    $aform->addElement(new XoopsFormHidden('op', 'audience'));
    $aform->addElement(new XoopsFormText(_AM_SOCIALNET_AUDIENCENAME, 'aname', 12, 20, $audience), true);
    $aform->addElement(new XoopsFormSelectGroup(_AM_SOCIALNET_ACCESSRIGHTS, 'groups', true, $groups, 5, true), true);
    $aform->addElement(new XoopsFormButton('', 'submitaud', _AM_SOCIALNET_SAVE, 'submit'));
    $aform->display();
}


xoops_cp_header();
switch ( $op )
{
    case "newarticle":
    adminmenu(6);
    include_once XOOPS_ROOT_PATH . "/class/module.textsanitizer.php";
    newSubmissions();
    lastStories();
    break;

    case "audience":
    adminmenu(9);
    if (isset($_POST['submitaud'])) {
        $audience_handler =& xoops_getmodulehandler('audience', 'socialnet');
        $gperm_handler =& xoops_gethandler('groupperm');
        if (isset($_POST['aid'])) {
            $audience =& $audience_handler->get($_POST['aid']);
        }
        else {
            $audience =& $audience_handler->create();
        }
        $audience->setVar('audience', $_POST['aname']);
        if ($audience_handler->insert($audience)) {
            $audid = $audience->getVar('audienceid');
            global $xoopsModule;
            $criteria = new CriteriaCompo(new Criteria('gperm_name', 'socialnet_newsaudience'));
            $criteria->add(new Criteria('gperm_modid', intval($xoopsModule->getVar('mid'))));
            $criteria->add(new Criteria('gperm_itemid', intval($audid)));
            $gperm_handler->deleteAll($criteria);
            foreach ($_POST['groups'] as $groupid) {
                $gperm_handler->addRight("socialnet_newsaudience", $audid, $groupid, $xoopsModule->getVar('mid'));
            }
            echo "<div class='confirmMsg'><h3>".$audience->getVar('audience')." Saved</h3></div>";
        }
    }
    $audid = isset($_GET['audid']) ? intval($_GET['audid']) : 0;
    audienceForm($audid);
    echo listAudience();
    break;

    case "delete":
    if ( !empty( $_POST['ok'] ) )
    {
        if (empty($storyid))
        {
            redirect_header( 'news.php?op=newarticle', 2, _AM_SOCIALNET_EMPTYNODELETE );
            exit();
        }
        $story = new SocialnetStory($storyid);
        $story -> delete();
        $sfiles = new sFiles();
        $filesarr=Array();
        $filesarr=$sfiles->getAllbyStory($storyid);
        if(count($filesarr)>0)
        {
            foreach ($filesarr as $onefile)
            {
                $onefile->delete();
            }
        }
        xoops_comment_delete( $xoopsModule -> getVar( 'mid' ), $storyid );
        xoops_notification_deletebyitem( $xoopsModule -> getVar( 'mid' ), 'story', $storyid );
        redirect_header( 'news.php?op=newarticle', 1, _AM_SOCIALNET_DBUPDATED );
        exit();
    }
    else
    {
        $story = new SocialnetStory($storyid);
        echo "<h4>" . _AM_SOCIALNET_CONFIG . "</h4>";
        xoops_confirm( array( 'op' => 'delete', 'storyid' => $storyid, 'ok' => 1 ), 'news.php', _AM_SOCIALNET_RUSUREDEL .'<br />' . $story->title());
    }
    break;
    
    case "default":
    default:
    case "topicsmanager":
    adminmenu(5);
    topicsmanager();
    break;

    case "addTopic":
    addTopic();
    break;

    case "delTopic":
    delTopic();
    break;
    case "modTopicS":
    modTopicS();
    break;

    case "edit":
    include("../submit_news.php");
    break;

    case "delaudience":
    if ($_GET['audienceid'] == 1) {
        redirect_header('news.php?op=audience', 2, _AM_SOCIALNET_CANNOTDELETEDEFAULTAUDIENCE);
    }
    $audience_handler =& xoops_getmodulehandler('audience', 'socialnet');
    $audiences =& $audience_handler->getAllAudiences();
    $thisaudience = $audiences[$_GET['audienceid']];
    unset($audiences[$_GET['audienceid']]);
    foreach ($audiences as $id => $audience) {
        $newaudiences[$audience->getVar('audience')] = $id;
    }
    $storycount = $audience_handler->getStoryCountByAudience($thisaudience);
    if ($storycount > 0) {
        xoops_confirm( array( 'op' => 'delaudienceok', 'audienceid' => $_GET['audienceid'], 'newaudience' => $newaudiences), 'news.php', $thisaudience->getVar('audience') . "<br />". sprintf(_AM_SOCIALNET_AUDIENCEHASSTORIES, $storycount));
    }
    else {
        xoops_confirm( array( 'op' => 'delaudienceok', 'audienceid' => $_GET['audienceid'], 'newaudience' => 1), 'news.php', $thisaudience->getVar('audience') . "<br />". _AM_SOCIALNET_RUSUREDELAUDIENCE);
    }
    break;

    case "delaudienceok":
    if (!isset($_POST['audienceid']) || !isset($_POST['newaudience'])) {
        redirect_header('javascript:history.go(-1)', 2, _AM_SOCIALNET_PLEASESELECTNEWAUDIENCE);
    }
    $audience_handler =& xoops_getmodulehandler('audience', 'socialnet');
    $thisaudience =& $audience_handler->get($_POST['audienceid']);
    if ($audience_handler->delete($thisaudience, $_POST['newaudience'])) {
        redirect_header('news.php?op=audience', 3, _AM_SOCIALNET_AUDIENCEDELETED);
    }
    else {
        redirect_header('news.php?op=audience', 3, _AM_SOCIALNET_ERROR_AUDIENCENOTDELETED);
    }
    break;

    case "reorder":
    if (!isset($_POST['weight']) || !is_array($_POST['weight']) || (count($_POST['weight']) == 0)) {
        header("location:news.php?op=topicsmanager");
    }
    $topics = SocialnetTopic::getAllTopics();
    $errors = 0;
    foreach ($_POST['weight'] as $topicid => $weight) {
        $topics[$topicid]->weight = $weight;

		//Added in Socialnet Fix bug: Topic name with an ' (apostrophe) in it, cannot change the weight of that Topic
		if(get_magic_quotes_gpc())
		{
			$topics[$topicid]->topic_title=addslashes($topics[$topicid]->topic_title);
		}
		
        if (!$topics[$topicid]->store()) {
            $errors++;
        }
    }
    if ($errors) {
        redirect_header('news.php?op=topicsmanager', 3, _AM_SOCIALNET_ERROR_REORDERERROR);
    }
    else {
        redirect_header('news.php?op=topicsmanager', 3, _AM_SOCIALNET_REORDERSUCCESSFUL);
    }
    break;
    
}

echo "<div align='center' style='margin-top:10px'><a href='http://www.ipwgc.com/socialnet/'><img src='../images/socialnetLogo.png'></a><br /><img src='../images/menu/mailuser.gif'><a style='color: #029116; font-size:11px' href='feedback.php'>"._AM_SOCIALNET_FEEDBACK."</a> - <img src='../images/icons/mainvideo.gif'><a style='color: #FF0000; font-size:11px' href='http://www.ipwgc.com/socialnet/modules/socialnet/index.php' target='_blank'>"._AM_SOCIALNET_CHKVERSION."</a></div>";
xoops_cp_footer();
?>