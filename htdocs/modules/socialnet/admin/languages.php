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
require_once XOOPS_ROOT_PATH.'/modules/socialnet/include/common.php';
require_once XOOPS_ROOT_PATH.'/modules/socialnet/admin/functions.php';
require_once XOOPS_ROOT_PATH.'/class/pagenav.php';
include 'langtoolform.php';

// *******************************************************************************
// **** Main
// *******************************************************************************


xoops_cp_header();
adminmenu(20);
define('LANG_THIS_URL', XOOPS_URL.'/modules/socialnet/admin/languages.php');

switch($_GET['act']){
  case 'add':
    if($_POST['lang']){
      if($_POST['lang_title']&&$_POST['dirname']){
        $sql = 'INSERT INTO `'.$xoopsDB->prefix('socialnet_languages').'` VALUES (\'\', \''.$_POST['lang_title'].'\', \''.$_POST['dirname'].'\')';
        if ($result = $xoopsDB->query($sql)) {
          redirect_header(LANG_THIS_URL,1, _AM_SOCIALNET_LANGTOOL_UPDATEOK);
        }
      }
    } else {
      the_form();
    }
  break;

  case 'edit':
    if($_GET['lang_id']){
      if($_POST['lang']){
        if($_POST['lang_title']&&$_POST['dirname']){
          $sql = 'UPDATE `'.$xoopsDB->prefix('socialnet_languages').'` SET
                 `lang_title` = \''.$_POST['lang_title'].'\',
                 `dirname` = \''.$_POST['dirname'].'\'
                 WHERE `lang_id` = \''.$_GET['lang_id'].'\'';
          if ($xoopsDB->query($sql)) {
            redirect_header(LANG_THIS_URL,1,_AM_SOCIALNET_LANGTOOL_UPDATEOK);
          }
        }
      } else {
        $sql = 'SELECT * FROM `'.$xoopsDB->prefix('socialnet_languages').'` WHERE `lang_id` = '.$_GET['lang_id'];
        if (!$result = $xoopsDB->query($sql)) {
          redirect_header(XOOPS_URL.'/',1,_AM_SOCIALNET_LANGTOOL_ERROR);
          exit();
        }
        $data = $xoopsDB->fetchArray($result);
        the_form($data);
      }
    } else {
      redirect_header(LANG_THIS_URL,1,_AM_SOCIALNET_LANGTOOL_NOLANG);
    }
  break;

  case 'del':
    if($_GET['lang_id']){
      $sql = 'DELETE FROM `'.$xoopsDB->prefix('socialnet_languages').'` WHERE `lang_id` = '.$_GET['lang_id'];
      if(mysql_query($sql)){
        redirect_header(LANG_THIS_URL,1,_AM_SOCIALNET_LANGTOOL_UPDATEOK);
      }
    } else {
      redirect_header(LANG_THIS_URL,1,_AM_SOCIALNET_LANGTOOL_NOLANG);
    }
  break;

  default:
    $sql1 = 'SELECT `lang_id` FROM `'.$xoopsDB->prefix('socialnet_languages').'`';
    if (!$result1 = $xoopsDB->query($sql1) ) {
      redirect_header(XOOPS_URL.'/',1,_AM_SOCIALNET_LANGTOOL_ERROR);
      exit();
    }
    $total = $xoopsDB->getRowsNum($result1);
    if(!$_GET["page"]) $page=1;
    else $page = $_GET["page"];
    $per = 20;
    $list = 10;
    $start = ($page-1)*$per;
    $pages = ceil($total/$per);
    
    if((floor($pages/$list)>=1)&&($pages > $list)){
      if($page%$list > 0)
        $page_loop = ((floor($page/$list))*$list) +1;
      else
        $page_loop = ((floor(($page-1)/$list))*$list) +1;
      
      if($pages > ($list+$page_loop-1))
        $page_limit = $list+$page_loop-1;
      else
        $page_limit = $pages;
    } else {
      $page_loop = 1;
      $page_limit = $pages;
    }
    
    if($page==$pages&&$total%$per!=0)
      $per = $total % $per;
    
    $sql = 'SELECT * FROM `'.$xoopsDB->prefix('socialnet_languages').'` LIMIT '.$start.', '.$per;
    if (!$result = $xoopsDB->query($sql) ) {
      redirect_header(XOOPS_URL.'/',1,_AM_SOCIALNET_LANGTOOL_ERROR);
      exit();
    }
    
    if(($num = $xoopsDB->getRowsNum($result))>0){
      

echo "<br>";
echo "<hr>";
echo "<div style='color: #FF0000; font-size: 20px'>  "._AM_SOCIALNET_SEC_TITHE."</div>";
echo "<h3><img src='../images/profile/toggle.gif'>" . _AM_SOCIALNET_LANGTOOL_LANGTOOL . "</h3>";

		echo '<table align="center" width="400">';
      	echo '<tr><td colspan="3" align="right"><a href="'.LANG_THIS_URL.'?act=add" style="padding:3px; border:5px double #FFFFFF; background-color: #00950F; color: #FFFFFF" ><img src="../images/topics/folder_locked_big.gif">'._AM_SOCIALNET_LANGTOOL_ADD.'</a><br /><br /></td></tr>';

		echo "<br>";
		echo '<tr><td width="200">'._AM_SOCIALNET_LANGTOOL_LANGTITLE.'</td><td width="100">'._AM_SOCIALNET_LANGTOOL_FOLDER.'</td><td width="100">'._AM_SOCIALNET_LANGTOOL_ADMIN.'</td></tr>';
      for($i=0;$i<$num;$i++){
        $data = $xoopsDB->fetchArray($result);
        echo '<tr>';
        echo '<td>'.$data['lang_title'].'</td>';
        echo '<td>'.$data['dirname'].'</td>';
        echo '<td>';
        echo '<a href="'.LANG_THIS_URL.'?act=edit&lang_id='.$data['lang_id'].'">'._AM_SOCIALNET_LANGTOOL_EDIT.'</a>&nbsp;&nbsp;';
        echo '<a href="'.LANG_THIS_URL.'?act=del&lang_id='.$data['lang_id'].'">'._AM_SOCIALNET_LANGTOOL_DEL.'</a>&nbsp;&nbsp;';
        echo '</td>';
        echo '</tr>';
      }
      echo '</table>';
      if($pages>1){
        echo '<table align="center" width="400"><tr><td align="center"><hr>';
        if($pages>$list&&$page>$list){
          $p = floor(($page_loop - 2) / $list)*$list+1;
          echo '<a href="'.LANG_THIS_URL.'?page='.$p.'">'._AM_SOCIALNET_LANGTOOL_L10.'</a>&nbsp;';
        }
        if($page>1){
          $p = $page - 1;
          echo '&nbsp;<a href="'.LANG_THIS_URL.'?page='.$p.'">'._AM_SOCIALNET_LANGTOOL_L1.'</a>&nbsp;';
        }
        for($t=$page_loop;$t<=$page_limit;$t++){
          if ($page == $t){
            echo '&nbsp;<b>'.$t.'</b>&nbsp;';
          } else {
            echo '&nbsp;<a href="'.LANG_THIS_URL.'?page='.$t.'">'.$t.'</a>&nbsp;';
          }
        }
        if($pages>$page){
          $p = $page + 1;
          echo '&nbsp;<a href="'.LANG_THIS_URL.'?page='.$p.'">'._MD_SOCIALNET_LANGTOOL_N1.'</a>&nbsp;';
        }
        if($pages>$list&&$pages >= ($page_loop+$list) ){
          $p = $page_limit + 1;
          echo '&nbsp;<a href="'.LANG_THIS_URL.'?page='.$p.'">'._MD_SOCIALNET_LANGTOOL_N10.'</a>';
        }
        echo '</td></tr></table>';
      }
    }
}
echo "<br>";
echo "<br>";
 	echo "<div align='center' style='margin-top:10px'><a href='http://www.ipwgc.com/socialnet/'><img src='../images/socialnetLogo.png'></a><br /><img src='../images/menu/mailuser.gif'><a style='color: #029116; font-size:11px' href='feedback.php'>"._AM_SOCIALNET_FEEDBACK."</a> - <img src='../images/icons/mainvideo.gif'><a style='color: #FF0000; font-size:11px' href='http://www.ipwgc.com/socialnet/modules/socialnet/index.php' target='_blank'>"._AM_SOCIALNET_CHKVERSION."</a></div>";
xoops_cp_footer();
?>