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

class marquee
{
	var $chatid;
	var $uid;
	var $direction;
	var $scrollamount;
    var $behaviour;
    var $bgcolor;
    var $align;
    var $height;
    var $width;
    var $hspace;
    var $content;
    var $scrolldelay;
    var $stoponmouseover;
    var $loop;
    var $vspace;
	var $table;

	function marquee($chatid=-1, $table='socialnet_chatmarquee')
	{
		$db =& Database::getInstance();
		$this->table = $db->prefix($table);
		if( $chatid != -1 ) {
			$this->getMarquee(intval($chatid));
		}
	}

	function getMarquee($chatid)
	{
		$db =& Database::getInstance();
		$sql = "SELECT * FROM ".$this->table." WHERE chatid=".intval($chatid);
		$array = $db->fetchArray($db->queryF($sql));
		$this->makeMarquee($array);
	}

	function makeMarquee($array)
	{
		foreach ( $array as $key=>$value ){
			$this->$key = $value;
		}
	}

	function getAllMarquees($limit=0, $asobject=true)
	{
		$ret = array();
		$db =& Database::getInstance();
		$sql = "SELECT * FROM ".$this->table." ORDER BY chatid";
		$result = $db->query($sql,$limit,0);
		while ( $myrow = $db->fetchArray($result) )
		{
			if ( $asobject ) {
				$ret[] = new marquee($myrow['chatid']);
			} else {
				$ret[$myrow['chatid']] = $myrow;
			}
		}
		return $ret;
	}

	function getHtmlMarqueesList($selectedmarquee=0)
	{
		$ret='';
		$db =& Database::getInstance();
		$sql = "SELECT * FROM ".$this->table." ORDER BY chatid";
		$result = $db->queryF($sql);
		while ( $myrow = $db->fetchArray($result) )
		{
			$mymarquee = new marquee($myrow['chatid']);
			$selected='';
			if($mymarquee->chatid()==$selectedmarquee) {
				$selected=' selected';
			}
			$ret.="<option ".$selected." value='".$mymarquee->chatid()."'>".xoops_substr($mymarquee->content(),0,50)."</option>";
		}
		return $ret;
	}


	function store()
	{
		$db =& Database::getInstance();
		$myts =& MyTextSanitizer::getInstance();

		$content = $myts->censorString($this->content);
		$content = $myts->makeTareaData4Save($content);
		$uid=intval($this->uid);
		$direction= intval($this->direction);
		$scrollamount= intval($this->scrollamount);
		$behaviour= intval($this->behaviour);
		$bgcolor= $myts->makeTboxData4Save($this->bgcolor);
		$align= intval($this->align);
		$height= intval($this->height);
		$width= $myts->makeTboxData4Save($this->width);
		$hspace= intval($this->hspace);
		$scrolldelay= intval($this->scrolldelay);
		$stoponmouseover= intval($this->stoponmouseover);
		$loop= intval($this->loop);
		$vspace= intval($this->vspace);

		if (!isset($this->chatid))
		{
			$sql = sprintf("INSERT INTO %s (uid, direction, scrollamount, behaviour, bgcolor, align, height, width, hspace, scrolldelay, stoponmouseover, chatloop, vspace, content) VALUES (%u, %u, %u, %u, '%s', %d, %u, '%s', %u, %u, %u, %u, %u, '%s')",$this->table,$uid, $direction, $scrollamount, $behaviour, $bgcolor, $align, $height, $width, $hspace, $scrolldelay, $stoponmouseover, $loop, $vspace, $content);
			$newchatid=0;
		}
		else
		{
			$sql = sprintf("UPDATE %s set uid=%u, direction=%u, scrollamount=%u, behaviour=%u, bgcolor='%s', align=%u, height=%u, width='%s', hspace=%u, scrolldelay=%u, stoponmouseover=%u, chatloop=%u, vspace=%u, content='%s' WHERE chatid=%u",$this->table,$uid, $direction, $scrollamount, $behaviour, $bgcolor, $align, $height, $width, $hspace, $scrolldelay, $stoponmouseover, $loop, $vspace, $content, intval($this->chatid));
			$newchatid = $this->chatid;
		}
		if (!$result = $db->queryF($sql)) {
			return false;
		}
		if (empty($newchatid)) {
			$newchatid= $db->getInsertId();
			$this->chatid= $newchatid;
		}
		return $newchatid;
	}


	function chatid()
	{
		return intval($this->chatid);
	}

	function uid()
	{
		return intval($this-uid);
	}

	function direction()
	{
		return intval($this->direction);
	}

	function scrollamount()
	{
		return intval($this->scrollamount);
	}

	function behaviour()
	{
		return intval($this->behaviour);
	}

	function bgcolor($format="Show")
	{
		$myts =& MyTextSanitizer::getInstance();
		$tmp=$this->bgcolor;
		switch ( $format ) {
		case "Show":
			$zone = $myts->makeTboxData4Show($tmp);
			break;
		case "Edit":
			$zone = $myts->makeTboxData4Edit($tmp);
			break;
		case "Preview":
			$zone = $myts->makeTboxData4Preview($tmp);
			break;
		case "InForm":
			$zone = $myts->makeTboxData4PreviewInForm($tmp);
			break;
		case "keep":
			$zone=$tmp;
		}
		return $zone;
	}

	function align()
	{
		return intval($this->align);
	}

	function height()
	{
		return intval($this->height);
	}

	function width($format="Show")
	{
		$myts =& MyTextSanitizer::getInstance();
		$tmp=$this->width;
		switch ( $format ) {
		case "Show":
			$zone = $myts->makeTboxData4Show($tmp);
			break;
		case "Edit":
			$zone = $myts->makeTboxData4Edit($tmp);
			break;
		case "Preview":
			$zone = $myts->makeTboxData4Preview($tmp);
			break;
		case "InForm":
			$zone = $myts->makeTboxData4PreviewInForm($tmp);
			break;
		case "keep":
			$zone=$tmp;
		}
		return $zone;
	}

	function hspace()
	{
		return intval($this->hspace);
	}

	function scrolldelay()
	{
		return intval($this->scrolldelay);
	}

	function stoponmouseover()
	{
		return intval($this->stoponmouseover);
	}

	function loop()
	{
		return intval($this->loop);
	}

	function vspace()
	{
		return intval($this->vspace);
	}

	function content($format="Show")
	{
		$myts =& MyTextSanitizer::getInstance();
		switch ( $format ) {
		case "Show":
			$content = $myts->makeTareaData4Show($this->content);
			break;
		case "Edit":
			$content = $myts->makeTareaData4Edit($this->content);
			break;
		case "Preview":
			$content = $myts->makeTareaData4Preview($this->content);
			break;
		case "InForm":
			$content = $myts->makeTareaData4PreviewInForm($this->content);
			break;
		}
		return $content;
	}

	function setchatid($value)
	{
		$this->chatid=intval($value);
	}

	function setUid($value)
	{
		$this->uid=intval($value);
	}

	function setdirection($value)
	{
		$this->direction = intval($value);
	}

	function setscrollamount($value)
	{
		$this->scrollamount = intval($value);
	}

	function setbehaviour($value)
	{
		$this->behaviour = intval($value);
	}

	function setbgcolor($value)
	{
		$this->bgcolor = $value;
	}

	function setalign($value)
	{
		$this->align = $value;
	}

	function setheight($value)
	{
		$this->height = intval($value);
	}

	function setwidth($value)
	{
		$this->width = $value;
	}

	function sethspace($value)
	{
		$this->hspace=intval($value);
	}

	function setscrolldelay($value)
	{
		$this->scrolldelay = intval($value);
	}

	function setstoponmouseover($value)
	{
		$this->stoponmouseover = intval($value);
	}

	function setloop($value)
	{
		$this->loop=intval($value);
	}

	function setvspace($value)
	{
		$this->vspace =intval($value);
	}

	function setcontent($value)
	{
		$this->content = $value;
	}

	function delete()
	{
		$db =& Database::getInstance();
		$sql = sprintf("DELETE FROM %s WHERE chatid=%u", $this->table, intval($this->chatid));
		if( !$result = $db->queryF($sql) ) {
			return false;
		}
		return true;
	}
	function constructmarquee($contents='')
	{
		$tblalign=Array("top","bottom","middle");
		$tblbehaviour=Array("scroll","slide","alternate");
		$tbldirection=Array("right","left","up","down");
		$stop=$this->stoponmouseover()==1 ? ' onmouseover="this.stop()" onmouseout="this.start()"' : '';
		$bgcolor=trim($this->bgcolor())!='' ? " bgcolor='".$this->bgcolor()."'" : '';
		$height=$this->height()!=0 ? " height=".$this->height() : '';
		$hspace=$this->hspace()!=0 ? " hspace=".$this->hspace() : '';
		$width=trim($this->width())!='' ? " width='".$this->width()."'" : '';
		$scrolldelay=$this->scrolldelay()!=0 ? " scrolldelay=".$this->scrolldelay() : '';

		$loop=$this->loop()!=0 ? " loop=".$this->hspace() : " loop='infinite'";

		$vspace=$this->vspace()!=0 ? " vspace=".$this->vspace() : '';
		$scrollamount=$this->scrollamount()!=0 ? " scrollamount=".$this->scrollamount() : '';
		if (!$contents) $contents = $this->content();
		return "<marquee align='".$tblalign[$this->align()]."' behavior='".$tblbehaviour[$this->behaviour()].
			"' direction='".$tbldirection[$this->direction()]."' ".
			$stop.$scrollamount.$bgcolor.$height.$hspace.$width.$scrolldelay.$loop.$vspace.">".$contents.
			"</marquee>";
	}
}
?>
