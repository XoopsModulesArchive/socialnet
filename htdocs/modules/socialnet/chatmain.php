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

include "../../mainfile.php";
require 'chatconfig.php';
require("chatsajax.php");
include_once "./class/socialnet_chat_class.php";
include 'chatonline.php';

session_register("name");
global $xoopsUser,$xoopsDB;

if ($xoopsUser){
	$userid = $xoopsUser->uid();
	if ( POPCHAT_SHOW_NAME==1 && (trim(chat::username($userid))!='') ) $name = chat::username($userid);
	else $name = chat::uname($userid);
}

function DatePrint($format){
  $n_date = " <font size=-1 color=#888888>".date($format,time())."</font>";
  return $n_date;
}
function NameCheck($name,$id=0){
  global $xoopsDB;
  $mem_arr = chat::getMember();
  while(list($chatid,$m_id,$m_name,$m_ip,$m_time) = $xoopsDB->fetchRow($mem_arr)){
    if($id==$m_id) return true;
  }
  return false;
}
function MemDump(){
  global $xoopsDB;
  $mem_cnt = 0;
  $rom_cnt = 0;
  $mem_lst ='';
  $mem_arr = chat::getMember();
  while(list($chatid,$m_id,$m_uid,$m_name,$m_ip,$m_time) = $xoopsDB->fetchRow($mem_arr)){
    if($m_name){
      $mem_lst .= "&nbsp;".$m_name.SEPA;
      $mem_cnt++;
    }elseif(ROM==2){
      $mem_lst .= "&nbsp;".$m_ip.SEPA;
    }elseif(ROM==1){
      $rom_cnt++;
    }
  }
  return array($mem_cnt,$mem_lst,$rom_cnt);
}
function convert_encoding(&$text, $from = 'auto', $to = 'auto'){
	if(function_exists('mb_convert_encoding')){
		return mb_convert_encoding($text, $to, $from); 
	} else if (function_exists('iconv')){
		return iconv($from, $to, $text);
	} else if (function_exists('JcodeConvert')) {
		return JcodeConvert($str, 0, 1);
	}else{
		return $text;
	}
}

	// The world's least efficient wall implementation
		function colorify_ip($ip)
	{
		$parts = explode(".", $ip);
		$color = sprintf("%02s", dechex($parts[1])) .
				 sprintf("%02s", dechex($parts[2])) .
				 sprintf("%02s", dechex($parts[3]));
		return $color;
	}
	function utf8RawUrlDecode ($source) {
		$decodedStr = "";
		$pos = 0;
		$len = strlen ($source);
		while ($pos < $len) {
			$charAt = substr ($source, $pos, 1);
			if ($charAt == "%") {
				$pos++;
				$charAt = substr ($source, $pos, 1);
				if ($charAt == "u") {
					// we got a unicode character
					$pos++;
					$unicodeHexVal = substr ($source, $pos, 4);
					$unicode = hexdec ($unicodeHexVal);
					$entity = "&#". $unicode . ";";
					$decodedStr .= utf8_encode ($entity);
					$pos += 4;
				} else {
					// we have an escaped ascii character
					$hexVal = substr ($source, $pos, 2);
					$decodedStr .= chr (hexdec ($hexVal));
					$pos += 2;
				}
			} else {
				$decodedStr .= $charAt;
				$pos++;
			}
		}
		return $decodedStr;
	}
	function add_line($msg) {
		$user_time = xoops_getUserTimestamp(time());
		$dt = strftime("%m/%d %H:%M:%S", $user_time);
		$remote = $_SERVER["REMOTE_ADDR"];
		$color = colorify_ip($remote);
		$msg = $dt . strip_tags(stripslashes(utf8RawUrlDecode($msg)));
		chat::putMessage($msg);
  	}
	
	function refresh() {
		global $xoopsDB;
		$lines = array();
		$i=0;
		$results = chat::getMessage();
		while(list($chatid, $input_date, $uid, $post_text) = $xoopsDB->fetchRow($results) ){

			$lines[] = $post_text;

		}
		return join("\n<br />",$lines);
	}
	
	$sajax_request_type = "GET";
	sajax_init();
	sajax_export("add_line", "refresh");
	sajax_handle_client_request();
?>
<head>
	<script>
	<?
	sajax_show_javascript();
	?>
	
	var check_n = 0;
	
	function refresh_cb(new_data) {
		document.getElementById("wall").innerHTML = new_data;
		document.getElementById("status").innerHTML = "&nbsp;";	//"Checked #" + check_n++;
		setTimeout("refresh()", 1000);
	}
	
	function refresh() {
		document.getElementById("status").innerHTML = ".";	//checking...
		x_refresh(refresh_cb);
	}
	
	function add_cb() {

	}

	function add() {
		var line;
		var handle;
		handle = document.getElementById("handle").value;
		line = document.getElementById("line").value;
		if (line == "") 
			return;
		x_add_line("[" + handle + "] " + line, add_cb);
		document.getElementById("line").value = "";
	}
	</script>
</head>
<?php xoops_header();?>
<body class="outer" onload="refresh();">
<?php
echo '<table width="100%" cellspacing="2"><tr>';
$hstr = "<td class='outer'>[<a href=?>"._MD_SOCIALNET_POPCHAT_RELOAD."</a>]&nbsp;";
$hstr .= "<INPUT type=\"submit\" name='Clear' value=\""._MD_SOCIALNET_POPCHAT_CLEAR."\"></td>";
convert_encoding($hstr,"auto",CHARSET);
echo '<table width="95%" cellspacing="2">
<form action="chatmain.php" METHOD="POST"><tr class="head">'.$hstr.'</tr></form></table>';
?>
<table  width="100%" cellspacing="2"><tr><td class="even">
<form name="f" action="#" onsubmit="add();return false;">
	<?php
	if (isset($name)){
		echo $name;
		echo "<input type='hidden' name='handle' id='handle' value='$name' onfocus='this.select()' style='width:100px;'>";
	}else{
		$name = "anonymous";
		echo "<input type='text' name='handle' id='handle' value='$name' onfocus='this.select()' style='width:100px;'>";
	}
	?>
	<input type="text" name="line" id="line" value="(enter your message here)"
		onfocus="this.select()"
		style="width:300px;">
	<input type="button" name="check" value="<?php echo _MD_SOCIALNET_POPCHAT_SEND; ?>"
		onclick="add(); return false;">
</form>
</td></tr><tr><td class="odd">
<div id="wall"></div>
<div id="status"><em>Loading..</em></div>
<?

chat::sweepMember();
$id = session_id();
$addr = getenv("REMOTE_ADDR");
$host = @gethostbyaddr($addr);
$ret = '';
if (isset($message)) $ret = chat::putMember($id,$name,$host,time());
if ($ret==true){
	$notification_handler = & xoops_gethandler( 'notification' );
	$tags = array();
	$tags['USER_NAME'] = $uname;
	$tags['USER_MESSAGE'] = $message;
	$notification_handler -> triggerEvent( 'category', 0, 'new_event', $tags );
}else{
	chat::updateMember($id);
}
$mem_arr = MemDump();
$class = 'odd';
$newline = 0;
if (isset($Clear)){ chat::clearMessage(); chat::clearMember();}
if (isset($Quit)) chat::quitMember($id); 
if (!isset($message)) $message='';
if ($message && $name && NameCheck($name,$id)){	
  $message = htmlspecialchars ($message);
  
  $message = ereg_replace("(https?|ftp)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)",
       "<a href=\"\\1\\2\" target=\"_blank\">\\1\\2</a>",$message);

  $name = htmlspecialchars ($name);
  $date = DatePrint(DatePrint);
  if(!$xoopsUser) $message = '<B>'.$name.'</B> > '.$message;
  $message = "$message $date<BR>";
  convert_encoding($message,"auto",CHARSET);
  chat::putMessage($message);
  $newline = 1;
}

echo "</tr></td></table>";
$version =	$xoopsModule ->getVar('version') / 100;
echo '<div class="footer">SocialNetChat Version&nbsp;'.$version.'&nbsp;<a href="http://www.ipwgc.com/socialnet/">IPWGC.com </a>2010</div>';

xoops_footer();
?>
