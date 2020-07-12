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

include_once XOOPS_ROOT_PATH."/modules/socialnet/chatconfig.php";
if(!defined('XOOPS_ROOT_PATH') || !is_file(XOOPS_ROOT_PATH.'/class/snoopy.php')){
	exit();
}
require_once XOOPS_ROOT_PATH.'/class/snoopy.php';
require_once(XOOPS_ROOT_PATH.'/mainfile.php');

class chat
{
	function getMessage($chatid = 1){
		global $xoopsDB;
		$sql = "SELECT * FROM ".$xoopsDB->prefix('socialnet_chatmessage')." WHERE chatid=".intval($chatid)." and view=0 order by input_date desc limit 25";
		return $xoopsDB->query($sql);
	}
	function convert2sqlString($text){
		$ts =& MyTextSanitizer::getInstance();
		if(!is_object($ts)){
			exit();
		}
		$res = $ts->stripSlashesGPC($text);
		$res = $ts->censorString($res);
		$res = addslashes($res);
		return $res;
	}	
	function putMessage($post_text, $chatid = 1){
		global $xoopsDB,$xoopsUser;
		if(!$xoopsUser) $uid=0;
		else $uid =  $xoopsUser->uid();
		$post_text = chat::convert2sqlString($post_text);
		$sql = sprintf("INSERT INTO %s (chatid, input_date, uid, post_text) VALUES (%u,CURRENT_TIMESTAMP(), %u,'%s')",$xoopsDB->prefix('socialnet_chatmessage'), $chatid , $uid, $post_text);
		$xoopsDB->queryF($sql);
	}
	function clearMessage($chatid = 1){
		global $xoopsDB;
		$sql = sprintf("UPDATE %s SET view=REPLACE(view,0,-1) WHERE chatid=%u",$xoopsDB->prefix('socialnet_chatmessage'), $chatid);
		$xoopsDB->queryF($sql);
	}
	function deleteMessage($idate,$chatid = 1){
		global $xoopsDB;
		$sql = sprintf("DELETE FROM %s WHERE chatid = %u and input_date<='%s'",$xoopsDB->prefix('socialnet_chatmessage'), $chatid,$idate);
		$xoopsDB->queryF($sql);
	}
	function getreacentlyMessage( $chatid = 1){
		$db =& Database::getInstance();
		$sql = "SELECT uid,post_text FROM ".$db->prefix('socialnet_chatmessage')." WHERE chatid=".intval($chatid)." and view=0 order by input_date desc limit 1";
		if(list($uid,$post_text) = $db->fetchRow($db->query($sql))){
			if ($uid>0){ 
				if ( POPCHAT_SHOW_NAME==1 && (trim(chat::username($uid))!='') )
					$name = chat::username($uid);
				else
					$name = chat::uname($uid);
			}
			$post_text = eregi_replace("\n|<br>|<br />","&nbsp;",$post_text);
			return '<B>'.$name.'</B> > '.$post_text;
		}
	}
	function clearMember($chatid = 1){
		global $xoopsDB;
		$sql = sprintf("DELETE FROM %s WHERE chatid = %u",$xoopsDB->prefix('socialnet_chatmember'), $chatid);
		$xoopsDB->queryF($sql);
	}
	function sweepMember($chatid = 1){
		global $xoopsDB;
		$sql = sprintf("SELECT count(*) FROM %s WHERE chatid = %u and in_date < CURRENT_TIMESTAMP()-300",$xoopsDB->prefix('socialnet_chatmember'), $chatid);
		if($dbResult = $xoopsDB->query($sql)){
			list($num) = $xoopsDB->fetchRow($dbResult);
		}
		if	($num>0){
			$sql = sprintf("DELETE FROM %s WHERE chatid = %u and in_date < CURRENT_TIMESTAMP()-300",$xoopsDB->prefix('socialnet_chatmember'), $chatid);
			$xoopsDB->queryF($sql);
		}
	}
	function getMember($chatid = 1){
		global $xoopsDB;
		$sql = "SELECT * FROM ".$xoopsDB->prefix('socialnet_chatmember')." WHERE chatid=".intval($chatid)." order by in_date";
		return $xoopsDB->query($sql);
	}
	function putMember($sessionid, $uname, $host, $ipdate, $chatid = 1){
		global $xoopsDB,$xoopsUser;

		$sql = "SELECT count(*) num FROM ".$xoopsDB->prefix('socialnet_chatmember')." WHERE sessionid='".$sessionid."'";
		if($dbResult = $xoopsDB->query($sql)){
			list($num) = $xoopsDB->fetchRow($dbResult);
		}
		if	($num==0){
			if ($xoopsUser) $uid = $xoopsUser->uid();
			else $uid = 0;
			$sql = sprintf("INSERT INTO %s (chatid, sessionid, uid, name, host, in_date) VALUES (%u,'%s',%u,'%s','%s',CURRENT_TIMESTAMP())",$xoopsDB->prefix('socialnet_chatmember'), $chatid ,$sessionid,$uid,$uname,$host);
			$result = $xoopsDB->queryF($sql);
			return true;
		}
		return false;
	}
	function updateMember($sessionid, $chatid = 1){
		global $xoopsDB;
		$sql = sprintf("UPDATE %s SET in_date = CURRENT_TIMESTAMP() Where chatid=%u and sessionid='%s'",$xoopsDB->prefix('socialnet_chatmember'), $chatid , $sessionid);
		$xoopsDB->query($sql);
	}
	function quitMember($sessionid, $chatid = 1){
		global $xoopsDB,$xoopsUser;
		$sql = sprintf("DELETE FROM %s WHERE chatid = %u and sessionid = '%s'",$xoopsDB->prefix('socialnet_chatmember'), $chatid , $sessionid);
		$xoopsDB->queryF($sql);
	}
	function offlineMember($onlineuids, $chatid = 1){
		global $xoopsDB;

	}

	// Get Real name
	function username($uid)	{
		global $xoopsDB;
		static $TblUser;
		if (isset($TblUser) && array_key_exists($uid,$TblUser)){
			$ret=$TblUser[$uid];
		}else{
			$sql = "SELECT name FROM ".$xoopsDB->prefix("users")." WHERE uid= $uid";
			$ret = '';
			if ( $result = $xoopsDB->query($sql) ) {
				if ( $myrow = $xoopsDB->fetchRow($result) ){
						$ret = $myrow[0];
				}
			}
			$TblUser[$uid]=$ret;
		}
		return $ret;
	}
	// Get User name
	function uname($uid)	{
		global $xoopsDB;
		static $TblUser;
		if (isset($TblUser) && array_key_exists($uid,$TblUser)){
			$ret=$TblUser[$uid];
		}else{
			$sql = "SELECT uname FROM ".$xoopsDB->prefix("users")." WHERE uid= $uid";
			$ret = '';
			if ( $result = $xoopsDB->query($sql) ) {
				if ( $myrow = $xoopsDB->fetchRow($result) ){
						$ret = $myrow[0];
				}
			}
			$TblUser[$uid]=$ret;
		}
		return $ret;
	}
}
?>
